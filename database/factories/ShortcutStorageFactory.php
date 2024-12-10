<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\ShortcutStorage;
/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\AppModelsShortcutStorage>
 */
class ShortcutStorageFactory extends Factory
{

    protected $model = ShortcutStorage::class;

    public function definition(): array
    {
        $types = ['icloud', 'file'];
        return [
            'shortcut_id' => null,
            'storage_type' => $this->faker->randomElement($types),
            'storage_url' => $this->faker->url(),
        ];
    }
}
