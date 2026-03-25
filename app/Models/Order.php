<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 'total', 'status', 'notes', 'shipping_address',
        'shipping_city', 'shipping_street', 'shipping_number', 'shipping_neighborhood', 'shipping_reference',
    ];

    protected $casts = [
        'total' => 'decimal:2',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }

    public function getStatusLabelAttribute(): string
    {
        return match($this->status) {
            'pendente'    => 'Pendente',
            'confirmado'  => 'Confirmado',
            'em_preparo'  => 'Em Preparo',
            'enviado'     => 'Enviado',
            'entregue'    => 'Entregue',
            'cancelado'   => 'Cancelado',
            default       => 'Desconhecido',
        };
    }

    public function getStatusColorAttribute(): string
    {
        return match($this->status) {
            'pendente'   => 'yellow',
            'confirmado' => 'blue',
            'em_preparo' => 'orange',
            'enviado'    => 'purple',
            'entregue'   => 'green',
            'cancelado'  => 'red',
            default      => 'gray',
        };
    }

    public function getFormattedTotalAttribute(): string
    {
        return 'R$ ' . number_format($this->total, 2, ',', '.');
    }
}
