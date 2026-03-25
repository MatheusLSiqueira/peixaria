<?php

namespace App\Http\Controllers;

use App\Enums\UserRole;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rules;

class AdminController extends Controller
{
    // O middleware agora é gerenciado pelo routes/web.php

    /**
     * Dashboard Geral
     */
    public function dashboard()
    {
        $stats = [
            'total_orders'    => Order::count(),
            'pending_orders'  => Order::where('status', 'pendente')->count(),
            'total_revenue'   => Order::where('status', '!=', 'cancelado')->sum('total'),
            'total_products'  => Product::count(),
            'total_customers' => User::where('role', UserRole::Client)->count(),
        ];

        $recentOrders = Order::with('user')
                             ->orderByDesc('created_at')
                             ->limit(5)
                             ->get();

        return view('admin.dashboard', compact('stats', 'recentOrders'));
    }

    /**
     * Gestão de Pedidos
     */
    public function orders(Request $request)
    {
        $query = Order::with('user')->orderByDesc('created_at');

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $orders = $query->paginate(20)->withQueryString();

        return view('admin.orders.index', compact('orders'));
    }

    public function showOrder(Order $order)
    {
        $order->load(['items.product', 'user']);
        return view('admin.orders.show', compact('order'));
    }

    public function updateOrderStatus(Request $request, Order $order)
    {
        $request->validate([
            'status' => 'required|in:pendente,confirmado,em_preparo,enviado,entregue,cancelado',
        ]);

        $order->update(['status' => $request->status]);

        return back()->with('success', 'Status do pedido #' . $order->id . ' atualizado com sucesso!');
    }

    /**
     * Gestão de Clientes
     */
    public function customers()
    {
        $customers = User::where('role', UserRole::Client)
                         ->withCount('orders')
                         ->orderBy('name')
                         ->paginate(15);

        return view('admin.customers.index', compact('customers'));
    }

    public function showCustomer(User $user)
    {
        $user->load(['orders' => fn($q) => $q->orderByDesc('created_at')->limit(10)]);
        return view('admin.customers.show', compact('user'));
    }

    public function editCustomer(User $user)
    {
        return view('admin.customers.edit', compact('user'));
    }

    public function updateCustomer(Request $request, User $user)
    {
        $validated = $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|email|unique:users,email,' . $user->id,
            'phone'    => 'nullable|string|max:20',
            'address'  => 'nullable|string|max:500',
            'password' => ['nullable', 'confirmed', Rules\Password::defaults()],
        ]);

        if ($request->filled('password')) {
            $validated['password'] = Hash::make($request->password);
        } else {
            unset($validated['password']);
        }

        $user->update($validated);

        return redirect()->route('admin.customers')->with('success', 'Dados do cliente atualizados!');
    }

    public function destroyCustomer(User $user)
    {
        // Impede exclusão do próprio perfil e de outros administradores
        if ($user->isAdmin() || $user->getKey() === Auth::id()) {
            return back()->with('error', 'Ação não permitida: Este usuário possui privilégios administrativos ou é o próprio usuário logado.');
        }

        $user->delete();

        return redirect()->route('admin.customers')->with('success', 'Cliente removido do sistema.');
    }

    /**
     * Relatórios de Vendas
     */
    public function reports(Request $request)
    {
        $startDate = $request->input('start_date', now()->startOfMonth()->format('Y-m-d'));
        $endDate   = $request->input('end_date', now()->format('Y-m-d'));

        $salesByDay = Order::where('status', '!=', 'cancelado')
            ->whereBetween('created_at', [$startDate, $endDate . ' 23:59:59'])
            ->selectRaw('DATE(created_at) as date, COUNT(*) as total_orders, SUM(total) as revenue')
            ->groupBy('date')
            ->orderBy('date')
            ->get();

        $topProducts = DB::table('order_items')
            ->join('products', 'order_items.product_id', '=', 'products.id')
            ->join('orders', 'order_items.order_id', '=', 'orders.id')
            ->where('orders.status', '!=', 'cancelado')
            ->whereBetween('orders.created_at', [$startDate, $endDate . ' 23:59:59'])
            ->selectRaw('products.name, SUM(order_items.quantity) as total_sold, SUM(order_items.subtotal) as revenue')
            ->groupBy('products.id', 'products.name')
            ->orderByDesc('total_sold')
            ->limit(10)
            ->get();

        $summary = [
            'total_orders'  => $salesByDay->sum('total_orders'),
            'total_revenue' => $salesByDay->sum('revenue'),
        ];

        return view('admin.reports', compact('salesByDay', 'topProducts', 'summary', 'startDate', 'endDate'));
    }

    /**
     * Gerar Relatório em PDF
     */
    public function generatePdfReport(Request $request)
    {
        $startDate = $request->input('start_date', now()->startOfMonth()->format('Y-m-d'));
        $endDate   = $request->input('end_date', now()->format('Y-m-d'));

        // Buscar todos os pedidos no período
        $orders = Order::with(['user', 'items.product'])
            ->where('status', '!=', 'cancelado')
            ->whereBetween('created_at', [$startDate, $endDate . ' 23:59:59'])
            ->orderByDesc('created_at')
            ->get();

        // Calcular estatísticas
        $summary = [
            'total_orders'  => $orders->count(),
            'total_revenue' => $orders->sum('total'),
            'start_date'    => $startDate,
            'end_date'      => $endDate,
        ];

        // Agrupar vendas por dia
        $salesByDay = $orders->groupBy(function($order) {
            return $order->created_at->format('Y-m-d');
        })->map(function($dayOrders) {
            return [
                'date' => $dayOrders->first()->created_at->format('d/m/Y'),
                'total_orders' => $dayOrders->count(),
                'revenue' => $dayOrders->sum('total'),
            ];
        })->values();

        // Produtos mais vendidos
        $topProducts = DB::table('order_items')
            ->join('products', 'order_items.product_id', '=', 'products.id')
            ->join('orders', 'order_items.order_id', '=', 'orders.id')
            ->where('orders.status', '!=', 'cancelado')
            ->whereBetween('orders.created_at', [$startDate, $endDate . ' 23:59:59'])
            ->selectRaw('products.name, SUM(order_items.quantity) as total_sold, SUM(order_items.subtotal) as revenue')
            ->groupBy('products.id', 'products.name')
            ->orderByDesc('total_sold')
            ->limit(10)
            ->get();

        $pdf = Pdf::loadView('admin.reports-pdf', compact('orders', 'summary', 'salesByDay', 'topProducts'));

        $filename = 'relatorio-pedidos-' . $startDate . '-a-' . $endDate . '.pdf';

        return $pdf->download($filename);
    }
}