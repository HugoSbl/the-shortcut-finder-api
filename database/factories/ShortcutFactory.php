<?php

namespace Database\Factories;

use App\Models\Shortcut;
use Illuminate\Database\Eloquent\Factories\Factory;

class ShortcutFactory extends Factory
{
    protected $model = Shortcut::class;
    public function definition(): array
    {
        return [
            'title' => $this->faker->sentence(),
            'short_description' => $this->faker->text(50),
            'complete_description' => $this->faker->paragraph(2),
            'number_of_downloads' => $this->faker->numberBetween(0, 1000),
            'number_of_views' => $this->faker->numberBetween(0, 1000),
            'likes' => $this->faker->numberBetween(0, 100),
            'dislikes' => $this->faker->numberBetween(0, 100),
            'app_id' => null,
            'category_id' => null,
            'user_id' => null,
            'is_archived' => false,
            'is_deleted' => false
        ];
    }
}
