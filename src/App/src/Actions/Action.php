<?php

declare(strict_types=1);

namespace App\Actions;

enum Action: string
{
    case login  = 'login';
    case admin  = 'admin';
    case signup = 'register';
    case logout = 'logout';
}
