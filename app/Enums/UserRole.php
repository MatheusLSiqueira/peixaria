<?php

namespace App\Enums;

enum UserRole: string
{
    case Admin  = 'admin';
    case Client = 'cliente';

    public function label(): string
    {
        return match($this) {
            self::Admin  => 'Administrador',
            self::Client => 'Cliente',
        };
    }
}
