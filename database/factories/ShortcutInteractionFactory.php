<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\ShortcutInteraction;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\AppModelsShortcutInteraction>
 */
class ShortcutInteractionFactory extends Factory
{
    protected $model = ShortcutInteraction::class;
    public $timestamps = false;

    public function definition(): array
    {
        $interactions = ['view', 'download', 'like', 'dislike'];
        
        return [
            'shortcut_id' => null,
            'user_id' => null,
            'interaction_type' => $this->faker->randomElement($interactions),
        ];
    }
}
