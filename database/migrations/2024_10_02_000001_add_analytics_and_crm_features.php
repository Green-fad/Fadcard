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
        // Table pour les analytics des cartes
        Schema::create('vcard_analytics', function (Blueprint $table) {
            $table->id();
            $table->foreignId('vcard_id')->constrained()->onDelete('cascade');
            $table->string('visitor_ip')->nullable();
            $table->string('visitor_country')->nullable();
            $table->string('visitor_city')->nullable();
            $table->string('user_agent')->nullable();
            $table->string('referrer')->nullable();
            $table->string('source_type')->default('direct'); // direct, qr_code, social, email
            $table->timestamp('viewed_at');
            $table->timestamps();
            
            $table->index(['vcard_id', 'viewed_at']);
            $table->index(['visitor_ip', 'vcard_id']);
        });

        // Table pour les interactions avec les éléments de la carte
        Schema::create('vcard_interactions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('vcard_id')->constrained()->onDelete('cascade');
            $table->string('element_type'); // phone, email, website, social, download
            $table->string('element_value');
            $table->string('visitor_ip')->nullable();
            $table->timestamp('interacted_at');
            $table->timestamps();
            
            $table->index(['vcard_id', 'element_type']);
            $table->index(['vcard_id', 'interacted_at']);
        });

        // Table pour les contacts CRM
        Schema::create('crm_contacts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('vcard_id')->nullable()->constrained()->onDelete('set null');
            $table->string('name');
            $table->string('email')->nullable();
            $table->string('phone')->nullable();
            $table->string('company')->nullable();
            $table->string('title')->nullable();
            $table->string('location')->nullable();
            $table->text('notes')->nullable();
            $table->json('tags')->nullable();
            $table->timestamp('first_contact_at')->nullable();
            $table->timestamp('last_contact_at')->nullable();
            $table->timestamps();
            
            $table->index(['user_id', 'name']);
            $table->index(['user_id', 'company']);
        });

        // Table pour l'historique des interactions CRM
        Schema::create('crm_interactions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('contact_id')->constrained('crm_contacts')->onDelete('cascade');
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('type'); // email, call, meeting, note, view
            $table->string('title');
            $table->text('description')->nullable();
            $table->timestamp('interaction_date');
            $table->timestamps();
            
            $table->index(['contact_id', 'interaction_date']);
            $table->index(['user_id', 'type']);
        });

        // Table pour les rappels et tâches
        Schema::create('crm_reminders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('contact_id')->constrained('crm_contacts')->onDelete('cascade');
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('title');
            $table->text('description')->nullable();
            $table->timestamp('reminder_date');
            $table->boolean('is_completed')->default(false);
            $table->timestamp('completed_at')->nullable();
            $table->timestamps();
            
            $table->index(['user_id', 'reminder_date']);
            $table->index(['contact_id', 'is_completed']);
        });

        // Table pour les insights et recommandations IA
        Schema::create('ai_insights', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('vcard_id')->nullable()->constrained()->onDelete('cascade');
            $table->string('type'); // optimization, expansion, engagement, performance
            $table->string('title');
            $table->text('description');
            $table->json('data')->nullable(); // Données supplémentaires pour l'insight
            $table->integer('priority')->default(1); // 1=low, 2=medium, 3=high
            $table->boolean('is_read')->default(false);
            $table->timestamp('generated_at');
            $table->timestamps();
            
            $table->index(['user_id', 'is_read']);
            $table->index(['user_id', 'priority']);
        });

        // Table pour les badges et gamification
        Schema::create('user_achievements', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('badge_type'); // networker_pro, content_creator, analytics_master, etc.
            $table->string('badge_name');
            $table->text('badge_description');
            $table->string('badge_icon')->nullable();
            $table->integer('points_earned')->default(0);
            $table->timestamp('earned_at');
            $table->timestamps();
            
            $table->index(['user_id', 'badge_type']);
            $table->unique(['user_id', 'badge_type']);
        });

        // Table pour les points de gamification
        Schema::create('user_points', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('action_type'); // card_created, card_viewed, contact_added, etc.
            $table->integer('points');
            $table->text('description');
            $table->timestamp('earned_at');
            $table->timestamps();
            
            $table->index(['user_id', 'earned_at']);
        });

        // Ajouter des colonnes aux tables existantes
        Schema::table('vcards', function (Blueprint $table) {
            $table->integer('total_views')->default(0)->after('status');
            $table->integer('total_interactions')->default(0)->after('total_views');
            $table->timestamp('last_viewed_at')->nullable()->after('total_interactions');
            $table->json('seo_meta')->nullable()->after('last_viewed_at');
            $table->boolean('analytics_enabled')->default(true)->after('seo_meta');
        });

        Schema::table('users', function (Blueprint $table) {
            $table->integer('total_points')->default(0)->after('email_verified_at');
            $table->integer('current_level')->default(1)->after('total_points');
            $table->timestamp('last_activity_at')->nullable()->after('current_level');
            $table->json('preferences')->nullable()->after('last_activity_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_points');
        Schema::dropIfExists('user_achievements');
        Schema::dropIfExists('ai_insights');
        Schema::dropIfExists('crm_reminders');
        Schema::dropIfExists('crm_interactions');
        Schema::dropIfExists('crm_contacts');
        Schema::dropIfExists('vcard_interactions');
        Schema::dropIfExists('vcard_analytics');

        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['total_points', 'current_level', 'last_activity_at', 'preferences']);
        });

        Schema::table('vcards', function (Blueprint $table) {
            $table->dropColumn(['total_views', 'total_interactions', 'last_viewed_at', 'seo_meta', 'analytics_enabled']);
        });
    }
};
