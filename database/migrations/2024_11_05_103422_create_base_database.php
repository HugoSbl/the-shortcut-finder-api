<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('shortcuts', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('short_description');
            $table->text('complete_description'); // Data from WYSIWYG editor
            $table->json('version_notes');
            $table->integer('number_of_downloads');
            $table->integer('number_of_views');
            $table->integer('likes');
            $table->integer('dislikes');

            $table->foreignId('category_id')->constrained('categories')->onDelete('cascade');
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->timestamps();
        });

        // Table many-to-many pour les tags
        Schema::create('shortcut_tag', function (Blueprint $table) {
            $table->id();
            $table->foreignId('shortcut_id')->constrained('shortcuts')->onDelete('cascade');
            $table->foreignId('tag_id')->constrained('tags')->onDelete('cascade');
        });

        Schema::create('tags', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->timestamps();
        });

        // Table many-to-many pour les catégories
        Schema::create('category_shortcut', function (Blueprint $table) {
            $table->id();
            $table->foreignId('category_id')->constrained('categories')->onDelete('cascade');
            $table->foreignId('shortcut_id')->constrained('shortcuts')->onDelete('cascade');
        });

        Schema::create('categories', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('description');
            $table->integer('number_of_shortcuts_associated');
            $table->timestamps();
        });

        // Polymorphisme pour les images
        Schema::create('images', function (Blueprint $table) {
            $table->id();
            $table->string('url');
            $table->morphs('imageable');
            $table->timestamps();
        });

        // Polymorphisme pour les apps
        Schema::create('apps', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('description');
            $table->morphs('appable'); // Polymorphisme pour app
            $table->timestamps();
        });

        // Table pour les propositions de shortcuts
        Schema::create('shortcut_proposals', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('short_description');
            $table->boolean('is_approved');
            $table->boolean('is_rejected');
            $table->boolean('is_resolved');
            $table->integer('likes');
            $table->integer('dislikes');
            $table->foreignId('category_id')->constrained('categories')->onDelete('cascade');
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('app_id')->constrained('apps')->onDelete('cascade');
            $table->timestamps();
        });

        // Polymorphisme pour les commentaires
        Schema::create('comments', function (Blueprint $table) {
            $table->id();
            $table->text('content');
            $table->morphs('commentable'); // Polymorphisme pour commentaires
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->integer('parent_id')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('comments');
        Schema::dropIfExists('shortcut_proposals');
        Schema::dropIfExists('apps');
        Schema::dropIfExists('images');
        Schema::dropIfExists('categories');
        Schema::dropIfExists('tags');
        Schema::dropIfExists('category_shortcut');
        Schema::dropIfExists('shortcut_tag');
        Schema::dropIfExists('shortcuts');
    }
};

