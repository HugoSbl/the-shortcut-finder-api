<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

// commentaire: Cette migration ajoute les champs manquants dans la table users existante
return new class extends Migration {
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // commentaire: Ajout du pseudo unique et non nul
            $table->string('pseudo')->unique()->after('name');
            // commentaire: Ajout du champ params de type json
            $table->json('params')->nullable()->after('password');
            // commentaire: Ajout du champ image
            $table->string('image')->nullable()->after('params');
            // commentaire: Ajout de la date d'inscription
            $table->date('date_of_inscription')->nullable()->after('image');
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // commentaire: Suppression des champs ajoutés
            $table->dropColumn(['pseudo', 'params', 'image', 'date_of_inscription']);
        });
    }
};
