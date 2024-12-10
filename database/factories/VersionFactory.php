<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Version;
/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\AppModelsVersion>
 */
class VersionFactory extends Factory
{
    protected $model = Version::class;

    public function definition(): array
    {
        return [
            'shortcut_id' => null,
            'version_number' => $this->faker->numberBetween(1, 10),
            'content' => $this->faker->paragraph(),
        ];
    }
}
