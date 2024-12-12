<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        // Table categories_of_shortcut (INT UNSIGNED)
        Schema::create('categories_of_shortcut', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title')->nullable();
            $table->string('description')->nullable();
            $table->unsignedInteger('parent_id')->nullable();
            $table->integer('number_of_shortcuts_associated')->nullable();
            $table->timestamps();
            $table->foreign('parent_id')->references('id')->on('categories_of_shortcut')->onDelete('set null');
        });

        // Table apps (INT UNSIGNED)
        Schema::create('apps', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name')->nullable();
            $table->string('description')->nullable();
            $table->unsignedInteger('appable_id')->nullable();
            $table->string('appable_type')->nullable();
            $table->timestamps();
        });

        // Table shortcuts (Référence users en BIGINT UNSIGNED)
        Schema::create('shortcuts', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title')->nullable();
            $table->string('short_description')->nullable();
            $table->text('complete_description')->nullable();
            $table->integer('number_of_downloads')->nullable();
            $table->integer('number_of_views')->nullable();
            $table->integer('likes')->nullable();
            $table->integer('dislikes')->nullable();

            // apps et categories_of_shortcut en INT UNSIGNED
            $table->unsignedInteger('app_id')->nullable();
            $table->unsignedInteger('category_id')->nullable();

            // users en BIGINT UNSIGNED
            $table->foreignId('user_id')->nullable()->constrained('users')->onDelete('set null');

            $table->boolean('is_archived')->default(false);
            $table->boolean('is_deleted')->default(false);
            $table->timestamps();

            // Clés étrangères
            $table->foreign('app_id')->references('id')->on('apps')->onDelete('set null');
            $table->foreign('category_id')->references('id')->on('categories_of_shortcut')->onDelete('set null');
        });

        Schema::create('shortcut_storages', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('shortcut_id');
            $table->enum('storage_type', ['icloud', 'file'])->nullable();
            $table->string('storage_url')->nullable();
            $table->timestamps();

            $table->foreign('shortcut_id')->references('id')->on('shortcuts')->onDelete('cascade');
        });

        Schema::create('file_metadata', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('shortcut_id');
            $table->integer('file_size')->nullable();
            $table->string('mime_type')->nullable();
            $table->string('checksum')->nullable();
            $table->timestamps();

            $table->foreign('shortcut_id')->references('id')->on('shortcuts')->onDelete('cascade');
        });

        Schema::create('tags', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name')->nullable();
            $table->timestamps();
        });

        Schema::create('taggables', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('tag_id');
            $table->unsignedInteger('taggable_id');
            $table->string('taggable_type');
            $table->timestamps();

            $table->foreign('tag_id')->references('id')->on('tags')->onDelete('cascade');
        });

        Schema::create('shortcut_interactions', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('shortcut_id');
            // users en BIGINT UNSIGNED
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->enum('interaction_type', ['view', 'download', 'like', 'dislike'])->nullable();
            $table->timestamps();

            $table->foreign('shortcut_id')->references('id')->on('shortcuts')->onDelete('cascade');
        });

        Schema::create('versions', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('shortcut_id');
            $table->integer('version_number')->nullable();
            $table->text('content')->nullable();
            $table->timestamps();

            $table->foreign('shortcut_id')->references('id')->on('shortcuts')->onDelete('cascade');
        });

        Schema::create('images', function (Blueprint $table) {
            $table->increments('id');
            $table->string('url')->nullable();
            $table->unsignedInteger('imageable_id')->nullable();
            $table->string('imageable_type')->nullable();
            $table->timestamps();
        });

        Schema::create('category_shortcut', function (Blueprint $table) {
            $table->unsignedInteger('category_id');
            $table->unsignedInteger('shortcut_id');
            $table->timestamps();

            $table->foreign('category_id')->references('id')->on('categories_of_shortcut')->onDelete('cascade');
            $table->foreign('shortcut_id')->references('id')->on('shortcuts')->onDelete('cascade');
        });

        Schema::create('proposals', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title')->notNull();
            $table->string('short_description')->notNull();
            $table->boolean('is_approved')->default(false);
            $table->boolean('is_rejected')->default(false);
            $table->boolean('is_resolved')->default(false);
            $table->integer('likes')->nullable();
            $table->integer('dislikes')->nullable();
            $table->unsignedInteger('category_id')->nullable();
            // users en BIGINT UNSIGNED
            $table->foreignId('user_id')->nullable()->constrained('users')->onDelete('set null');
            $table->unsignedInteger('app_id')->nullable();
            $table->timestamps();

            $table->foreign('category_id')->references('id')->on('categories_of_shortcut')->onDelete('set null');
            $table->foreign('app_id')->references('id')->on('apps')->onDelete('set null');
        });

        Schema::create('comments', function (Blueprint $table) {
            $table->increments('id');
            $table->text('content')->notNull();
            $table->unsignedInteger('commentable_id')->nullable();
            $table->string('commentable_type')->nullable();
            // users en BIGINT UNSIGNED
            $table->foreignId('user_id')->nullable()->constrained('users')->onDelete('set null');
            $table->unsignedInteger('parent_id')->nullable();
            $table->timestamps();

            $table->foreign('parent_id')->references('id')->on('comments')->onDelete('set null');
        });

        Schema::create('reports', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('reportable_id')->nullable();
            $table->string('reportable_type')->nullable();
            // users en BIGINT UNSIGNED
            $table->foreignId('user_id')->nullable()->constrained('users')->onDelete('set null');
            $table->string('reason')->nullable();
            $table->boolean('is_resolved')->default(false);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('reports');
        Schema::dropIfExists('comments');
        Schema::dropIfExists('proposals');
        Schema::dropIfExists('category_shortcut');
        Schema::dropIfExists('images');
        Schema::dropIfExists('versions');
        Schema::dropIfExists('shortcut_interactions');
        Schema::dropIfExists('taggables');
        Schema::dropIfExists('tags');
        Schema::dropIfExists('file_metadata');
        Schema::dropIfExists('shortcut_storages');
        Schema::dropIfExists('shortcuts');
        Schema::dropIfExists('apps');
        Schema::dropIfExists('categories_of_shortcut');
    }
};
