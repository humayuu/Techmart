<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Setting>
 */
class SettingFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'logo' => $this->faker->imageUrl(null, 640, 480),
            'phone' => '03243480273',
            'email' => 'techmart@gmail.com',
            'company_name' => 'TechMart',
            'company_address' => '873 Castro St, Mountain View, CA 94041',
            'description' => 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Quaerat, fugit neque nesciunt vero sed harum!',
            'facebook' => 'https://www.facebook.com/',
            'x' => 'https://x.com/',
            'linkedin' => 'https://linkedin.com/',
            'youtube' => 'https://www.youtube.com/',
        ];
    }
}
