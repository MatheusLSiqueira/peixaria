<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Relatório de Pedidos - {{ $summary['start_date'] }} a {{ $summary['end_date'] }}</title>
    <style>
        body {
            font-family: 'DejaVu Sans', sans-serif;
            font-size: 12px;
            line-height: 1.4;
            color: #374151;
            margin: 0;
            padding: 20px;
        }

        .header {
            text-align: center;
            border-bottom: 2px solid #1e40af;
            padding-bottom: 20px;
            margin-bottom: 30px;
        }

        .header h1 {
            color: #1e40af;
            font-size: 24px;
            margin: 0 0 10px 0;
            font-weight: bold;
        }

        .header p {
            margin: 5px 0;
            color: #6b7280;
        }

        .summary {
            display: table;
            width: 100%;
            margin-bottom: 30px;
            border-collapse: collapse;
        }

        .summary-row {
            display: table-row;
        }

        .summary-cell {
            display: table-cell;
            padding: 15px;
            border: 1px solid #e5e7eb;
            text-align: center;
            background: #f8fafc;
        }

        .summary-cell h3 {
            margin: 0 0 5px 0;
            font-size: 18px;
            color: #1e40af;
        }

        .summary-cell p {
            margin: 0;
            font-size: 14px;
            color: #6b7280;
        }

        .section {
            margin-bottom: 30px;
        }

        .section h2 {
            color: #1e40af;
            font-size: 16px;
            margin: 0 0 15px 0;
            padding-bottom: 5px;
            border-bottom: 1px solid #e5e7eb;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        th, td {
            padding: 8px 12px;
            text-align: left;
            border: 1px solid #e5e7eb;
        }

        th {
            background: #f8fafc;
            font-weight: bold;
            color: #374151;
        }

        .text-right {
            text-align: right;
        }

        .text-center {
            text-align: center;
        }

        .status-pendente { color: #f59e0b; }
        .status-confirmado { color: #3b82f6; }
        .status-em_preparo { color: #f97316; }
        .status-enviado { color: #8b5cf6; }
        .status-entregue { color: #10b981; }
        .status-cancelado { color: #ef4444; }

        .footer {
            margin-top: 40px;
            padding-top: 20px;
            border-top: 1px solid #e5e7eb;
            text-align: center;
            font-size: 10px;
            color: #9ca3af;
        }

        .currency {
            font-weight: bold;
            color: #059669;
        }
    </style>
</head>
<body>

    <div class="header">
        <h1>🐟 Peixaria - Relatório de Pedidos</h1>
        <p>Período: {{ \Carbon\Carbon::parse($summary['start_date'])->format('d/m/Y') }} a {{ \Carbon\Carbon::parse($summary['end_date'])->format('d/m/Y') }}</p>
        <p>Gerado em: {{ now()->format('d/m/Y H:i:s') }}</p>
    </div>

    {{-- Summary --}}
    <div class="summary">
        <div class="summary-row">
            <div class="summary-cell">
                <h3>{{ $summary['total_orders'] }}</h3>
                <p>Total de Pedidos</p>
            </div>
            <div class="summary-cell">
                <h3 class="currency">R$ {{ number_format($summary['total_revenue'], 2, ',', '.') }}</h3>
                <p>Receita Total</p>
            </div>
        </div>
    </div>

    {{-- Sales by Day --}}
    <div class="section">
        <h2>Vendas por Dia</h2>
        <table>
            <thead>
                <tr>
                    <th>Data</th>
                    <th class="text-center">Pedidos</th>
                    <th class="text-right">Receita</th>
                </tr>
            </thead>
            <tbody>
                @foreach($salesByDay as $day)
                    <tr>
                        <td>{{ $day['date'] }}</td>
                        <td class="text-center">{{ $day['total_orders'] }}</td>
                        <td class="text-right currency">R$ {{ number_format($day['revenue'], 2, ',', '.') }}</td>
                    </tr>
                @endforeach
                @if($salesByDay->isEmpty())
                    <tr>
                        <td colspan="3" class="text-center" style="color: #9ca3af;">Nenhum pedido encontrado no período</td>
                    </tr>
                @endif
            </tbody>
        </table>
    </div>

    {{-- Top Products --}}
    <div class="section">
        <h2>Produtos Mais Vendidos</h2>
        <table>
            <thead>
                <tr>
                    <th>Produto</th>
                    <th class="text-center">Quantidade Vendida</th>
                    <th class="text-right">Receita</th>
                </tr>
            </thead>
            <tbody>
                @foreach($topProducts as $product)
                    <tr>
                        <td>{{ $product->name }}</td>
                        <td class="text-center">{{ $product->total_sold }}</td>
                        <td class="text-right currency">R$ {{ number_format($product->revenue, 2, ',', '.') }}</td>
                    </tr>
                @endforeach
                @if($topProducts->isEmpty())
                    <tr>
                        <td colspan="3" class="text-center" style="color: #9ca3af;">Nenhum produto vendido no período</td>
                    </tr>
                @endif
            </tbody>
        </table>
    </div>

    {{-- Orders List --}}
    <div class="section">
        <h2>Lista de Pedidos</h2>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Cliente</th>
                    <th>Data</th>
                    <th>Status</th>
                    <th class="text-right">Valor</th>
                </tr>
            </thead>
            <tbody>
                @foreach($orders as $order)
                    <tr>
                        <td>#{{ $order->id }}</td>
                        <td>{{ $order->user->name }}</td>
                        <td>{{ $order->created_at->format('d/m/Y H:i') }}</td>
                        <td>
                            <span class="status-{{ $order->status }}">
                                {{ $order->status_label }}
                            </span>
                        </td>
                        <td class="text-right currency">R$ {{ number_format($order->total, 2, ',', '.') }}</td>
                    </tr>
                @endforeach
                @if($orders->isEmpty())
                    <tr>
                        <td colspan="5" class="text-center" style="color: #9ca3af;">Nenhum pedido encontrado no período</td>
                    </tr>
                @endif
            </tbody>
        </table>
    </div>

    <div class="footer">
        <p>Relatório gerado automaticamente pelo sistema Peixaria</p>
        <p>© {{ date('Y') }} - Todos os direitos reservados</p>
    </div>

</body>
</html>