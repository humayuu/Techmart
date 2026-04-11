<?php

namespace Database\Factories;

use App\Models\Admin;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;

/**
 * @extends Factory<Admin>
 */
class AdminFactory extends Factory
{
    /**
     * The current password being used by the factory.
     */
    protected static ?string $password;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => 'Admin',
            'email' => 'admin@gmail.com',
            'password' => static::$password ??= Hash::make('password'),
            'role' => 'admin',
            'access' => [
                'dashboard',
                'admin_users',
                'customers',
                'products',
                'orders',
                'categories',
                'brands',
                'coupons',
                'sliders',
                'shipping',
                'stock',
                'return_orders',
                'reports',
                'settings',
                'seo_settings',
            ],
            'status' => 'active',
        ];
    }
}
