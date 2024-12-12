<?php

// commentaire: Seeder global pour utiliser toutes les factories disponibles
// commentaire: Ce seeder crée un jeu de données cohérent en partant des ressources principales

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // commentaire: Création d'utilisateurs (par exemple 5)
        $users = \App\Models\User::factory()->count(5)->create();

        // commentaire: Création de quelques catégories de shortcuts
        $categories = \App\Models\CategoryOfShortcut::factory()->count(3)->create();

        // commentaire: Création de quelques apps
        $apps = \App\Models\App::factory()->count(2)->create();

        // commentaire: Création de tags
        $tags = \App\Models\Tag::factory()->count(5)->create();

        // commentaire: Création de shortcuts
        $shortcuts = \App\Models\Shortcut::factory()
            ->count(10)
            // commentaire: Associer aléatoirement un user, une category, et une app
            ->state(function () use ($users, $categories, $apps) {
                return [
                    'user_id' => $users->random()->id,
                    'category_id' => $categories->random()->id,
                    'app_id' => $apps->random()->id
                ];
            })
            ->create();

        // commentaire: Pour chaque shortcut, créer des versions, file_metadata, shortcut_storage, interactions
        $shortcuts->each(function ($shortcut) use ($users, $tags) {
            // Versions
            \App\Models\Version::factory()->count(2)->create(['shortcut_id' => $shortcut->id]);

            // FileMetadata
            \App\Models\FileMetadata::factory()->count(1)->create(['shortcut_id' => $shortcut->id]);

            // ShortcutStorage
            \App\Models\ShortcutStorage::factory()->count(1)->create(['shortcut_id' => $shortcut->id]);


            // Interactions (view/like...) par des users aléatoires
            \App\Models\ShortcutInteraction::factory()->count(3)->create([
                'shortcut_id' => $shortcut->id,
                'user_id' => $users->random()->id
            ]);

            // Association de tags via la table taggables (morphToMany)
            // commentaire: On peut créer les entrées dans la table taggables via la relation
            $assignedTags = $tags->random(2);
            $shortcut->tags()->attach($assignedTags->pluck('id')->toArray());
        });

        // commentaire: Création de propositions (associées à un user, une category, une app)
        // \App\Models\Proposal::factory()->count(5)->state(function () use ($users, $categories, $apps) {
        //     return [
        //         'user_id' => $users->random()->id,
        //         'category_id' => $categories->random()->id,
        //         'app_id' => $apps->random()->id
        //     ];
        // })->create();

        // commentaire: Création de commentaires (commentable : shortcuts ou propositions)
        // commentaire: Un mélange de commentaires sur des shortcuts et sur la première proposition par exemple
        // $someShortcut = $shortcuts->random();
        // \App\Models\Comment::factory()->count(5)->state([
        //     'commentable_id' => $someShortcut->id,
        //     'commentable_type' => \App\Models\Shortcut::class,
        //     'user_id' => $users->random()->id
        // ])->create();

        // $someProposition = \App\Models\Proposal::first();
        // \App\Models\Comment::factory()->count(3)->state([
        //     'commentable_id' => $someProposition->id,
        //     'commentable_type' => \App\Models\Proposal::class,
        //     'user_id' => $users->random()->id
        // ])->create();

        // commentaire: Création de reports (sur un shortcut ou une proposition)
        // \App\Models\Report::factory()->count(2)->state([
        //     'reportable_id' => $someShortcut->id,
        //     'reportable_type' => \App\Models\Shortcut::class,
        //     'user_id' => $users->random()->id
        // ])->create();

        // \App\Models\Report::factory()->count(2)->state([
        //     'reportable_id' => $someProposition->id,
        //     'reportable_type' => \App\Models\Proposal::class,
        //     'user_id' => $users->random()->id
        // ])->create();
    }
}
