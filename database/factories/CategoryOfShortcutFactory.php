<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\CategoryOfShortcut;
/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\AppModelsCategoryOfShortcut>
 */
class CategoryOfShortcutFactory extends Factory
{

    protected $model = CategoryOfShortcut::class;

    public function definition(): array
    {
        return [
            'title' => $this->faker->word(),
            'description' => $this->faker->sentence(),
            'parent_id' => null,
            'number_of_shortcuts_associated' => $this->faker->numberBetween(0, 100),
        ];
    }
}
