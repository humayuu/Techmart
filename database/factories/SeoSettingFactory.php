<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\SeoSetting>
 */
class SeoSettingFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'meta_title' => 'Techmart | Buy Electronics Online',
            'meta_author' => 'Techmart',
            'meta_keyword' => 'techmart, electronics, gadgets, smartphones, laptops',
            'meta_description' => 'Techmart is an online electronics store offering smartphones, laptops, and gadgets at the best prices.',
            'google_analytics' => '<script>/* Google Analytics Code */</script>',
        ];
    }
}
