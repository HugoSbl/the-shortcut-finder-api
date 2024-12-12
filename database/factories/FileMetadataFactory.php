<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\FileMetadata;
/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\AppModelsFileMetadata>
 */
class FileMetadataFactory extends Factory
{
    protected $model = FileMetadata::class;

    public function definition(): array
    {
        return [
            'shortcut_id' => null,
            'file_size' => $this->faker->numberBetween(1000, 1000000),
            'mime_type' => $this->faker->mimeType(),
            'checksum' => $this->faker->sha1(),
        ];
    }
}
