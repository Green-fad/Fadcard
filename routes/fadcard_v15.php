<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Dashboard\ModernDashboardController;
use App\Http\Controllers\CRM\ContactController;
use App\Http\Controllers\Analytics\VcardAnalyticsController;
use App\Http\Controllers\AI\InsightController;
use App\Http\Controllers\Gamification\AchievementController;

/*
|--------------------------------------------------------------------------
| FadCard 1.5 Routes
|--------------------------------------------------------------------------
|
| Routes pour les nouvelles fonctionnalités de FadCard version 1.5
| Inclut le tableau de bord modernisé, CRM, analytics avancés, et IA
|
*/

Route::middleware(['auth', 'verified'])->group(function () {
    
    // Dashboard modernisé
    Route::prefix('dashboard')->name('dashboard.')->group(function () {
        Route::get('/modern', ModernDashboardController::class)->name('modern');
        Route::get('/widgets', [ModernDashboardController::class, 'getWidgets'])->name('widgets');
        Route::post('/widgets/order', [ModernDashboardController::class, 'updateWidgetOrder'])->name('widgets.order');
        Route::get('/stats/{period}', [ModernDashboardController::class, 'getStats'])->name('stats');
    });

    // CRM - Gestion des contacts
    Route::prefix('crm')->name('crm.')->group(function () {
        Route::resource('contacts', ContactController::class);
        Route::post('contacts/{contact}/interactions', [ContactController::class, 'addInteraction'])->name('contacts.interactions.store');
        Route::post('contacts/{contact}/reminders', [ContactController::class, 'addReminder'])->name('contacts.reminders.store');
        Route::patch('contacts/{contact}/tags', [ContactController::class, 'updateTags'])->name('contacts.tags.update');
        Route::get('contacts/{contact}/export', [ContactController::class, 'export'])->name('contacts.export');
        Route::post('contacts/import', [ContactController::class, 'import'])->name('contacts.import');
        Route::get('contacts/export/all', [ContactController::class, 'exportAll'])->name('contacts.export.all');
        
        // Recherche et filtres
        Route::get('contacts/search/{query}', [ContactController::class, 'search'])->name('contacts.search');
        Route::get('contacts/filter/{tag}', [ContactController::class, 'filterByTag'])->name('contacts.filter');
        
        // Rappels
        Route::get('reminders', [ContactController::class, 'reminders'])->name('reminders.index');
        Route::patch('reminders/{reminder}/complete', [ContactController::class, 'completeReminder'])->name('reminders.complete');
    });

    // Analytics avancés
    Route::prefix('analytics')->name('analytics.')->group(function () {
        Route::get('/', [VcardAnalyticsController::class, 'index'])->name('index');
        Route::get('/vcard/{vcard}', [VcardAnalyticsController::class, 'show'])->name('vcard.show');
        Route::get('/vcard/{vcard}/export', [VcardAnalyticsController::class, 'export'])->name('vcard.export');
        
        // APIs pour les graphiques
        Route::get('/api/views/{vcard}/{period}', [VcardAnalyticsController::class, 'getViewsData'])->name('api.views');
        Route::get('/api/sources/{vcard}/{period}', [VcardAnalyticsController::class, 'getSourcesData'])->name('api.sources');
        Route::get('/api/countries/{vcard}/{period}', [VcardAnalyticsController::class, 'getCountriesData'])->name('api.countries');
        Route::get('/api/interactions/{vcard}/{period}', [VcardAnalyticsController::class, 'getInteractionsData'])->name('api.interactions');
        
        // Comparaisons
        Route::get('/compare', [VcardAnalyticsController::class, 'compare'])->name('compare');
        Route::post('/compare/vcards', [VcardAnalyticsController::class, 'compareVcards'])->name('compare.vcards');
    });

    // Intelligence Artificielle et Insights
    Route::prefix('ai')->name('ai.')->group(function () {
        Route::get('/insights', [InsightController::class, 'index'])->name('insights.index');
        Route::patch('/insights/{insight}/read', [InsightController::class, 'markAsRead'])->name('insights.read');
        Route::delete('/insights/{insight}', [InsightController::class, 'dismiss'])->name('insights.dismiss');
        
        // Génération d'insights
        Route::post('/insights/generate', [InsightController::class, 'generate'])->name('insights.generate');
        Route::post('/insights/vcard/{vcard}/analyze', [InsightController::class, 'analyzeVcard'])->name('insights.analyze');
        
        // Assistant IA pour l'optimisation
        Route::post('/optimize/content', [InsightController::class, 'optimizeContent'])->name('optimize.content');
        Route::post('/optimize/design', [InsightController::class, 'optimizeDesign'])->name('optimize.design');
        Route::post('/suggest/keywords', [InsightController::class, 'suggestKeywords'])->name('suggest.keywords');
    });

    // Gamification et Achievements
    Route::prefix('gamification')->name('gamification.')->group(function () {
        Route::get('/achievements', [AchievementController::class, 'index'])->name('achievements.index');
        Route::get('/leaderboard', [AchievementController::class, 'leaderboard'])->name('leaderboard');
        Route::get('/points/history', [AchievementController::class, 'pointsHistory'])->name('points.history');
        
        // Actions pour gagner des points
        Route::post('/points/claim/{action}', [AchievementController::class, 'claimPoints'])->name('points.claim');
        Route::post('/achievements/check', [AchievementController::class, 'checkAchievements'])->name('achievements.check');
    });

    // Éditeur de cartes avancé
    Route::prefix('editor')->name('editor.')->group(function () {
        Route::get('/vcard/{vcard}', [VcardEditorController::class, 'edit'])->name('vcard.edit');
        Route::post('/vcard/{vcard}/elements', [VcardEditorController::class, 'addElement'])->name('vcard.elements.add');
        Route::patch('/vcard/{vcard}/elements/{element}', [VcardEditorController::class, 'updateElement'])->name('vcard.elements.update');
        Route::delete('/vcard/{vcard}/elements/{element}', [VcardEditorController::class, 'deleteElement'])->name('vcard.elements.delete');
        
        // Thèmes et templates
        Route::get('/themes', [VcardEditorController::class, 'getThemes'])->name('themes');
        Route::post('/vcard/{vcard}/theme', [VcardEditorController::class, 'applyTheme'])->name('vcard.theme.apply');
        
        // Prévisualisation
        Route::get('/vcard/{vcard}/preview', [VcardEditorController::class, 'preview'])->name('vcard.preview');
        Route::get('/vcard/{vcard}/preview/{device}', [VcardEditorController::class, 'previewDevice'])->name('vcard.preview.device');
    });

    // APIs pour les fonctionnalités temps réel
    Route::prefix('api/v1.5')->name('api.v15.')->group(function () {
        // Notifications en temps réel
        Route::get('/notifications', [NotificationController::class, 'index'])->name('notifications.index');
        Route::patch('/notifications/{notification}/read', [NotificationController::class, 'markAsRead'])->name('notifications.read');
        
        // Statistiques en temps réel
        Route::get('/stats/live', [VcardAnalyticsController::class, 'liveStats'])->name('stats.live');
        Route::get('/stats/summary', [VcardAnalyticsController::class, 'summary'])->name('stats.summary');
        
        // Recherche globale
        Route::get('/search', [SearchController::class, 'global'])->name('search.global');
        Route::get('/search/contacts', [SearchController::class, 'contacts'])->name('search.contacts');
        Route::get('/search/vcards', [SearchController::class, 'vcards'])->name('search.vcards');
        
        // Export de données
        Route::post('/export/dashboard', [ExportController::class, 'dashboard'])->name('export.dashboard');
        Route::post('/export/analytics', [ExportController::class, 'analytics'])->name('export.analytics');
        Route::post('/export/contacts', [ExportController::class, 'contacts'])->name('export.contacts');
    });
});

// Routes publiques pour le tracking des vues
Route::prefix('track')->name('track.')->group(function () {
    Route::post('/view/{vcard}', [VcardAnalyticsController::class, 'trackView'])->name('view');
    Route::post('/interaction/{vcard}', [VcardAnalyticsController::class, 'trackInteraction'])->name('interaction');
    Route::get('/pixel/{vcard}.gif', [VcardAnalyticsController::class, 'trackingPixel'])->name('pixel');
});

// Webhooks pour les intégrations externes
Route::prefix('webhooks')->name('webhooks.')->group(function () {
    Route::post('/analytics/external', [WebhookController::class, 'analytics'])->name('analytics');
    Route::post('/crm/sync', [WebhookController::class, 'crmSync'])->name('crm.sync');
    Route::post('/ai/insights', [WebhookController::class, 'aiInsights'])->name('ai.insights');
});

// Routes pour les intégrations tierces
Route::prefix('integrations')->name('integrations.')->middleware('auth')->group(function () {
    // Google Analytics
    Route::post('/google-analytics/connect', [IntegrationController::class, 'connectGoogleAnalytics'])->name('ga.connect');
    Route::delete('/google-analytics/disconnect', [IntegrationController::class, 'disconnectGoogleAnalytics'])->name('ga.disconnect');
    
    // CRM externes (HubSpot, Salesforce, etc.)
    Route::post('/crm/{provider}/connect', [IntegrationController::class, 'connectCRM'])->name('crm.connect');
    Route::delete('/crm/{provider}/disconnect', [IntegrationController::class, 'disconnectCRM'])->name('crm.disconnect');
    Route::post('/crm/{provider}/sync', [IntegrationController::class, 'syncCRM'])->name('crm.sync');
    
    // Calendriers (Google Calendar, Outlook)
    Route::post('/calendar/{provider}/connect', [IntegrationController::class, 'connectCalendar'])->name('calendar.connect');
    Route::delete('/calendar/{provider}/disconnect', [IntegrationController::class, 'disconnectCalendar'])->name('calendar.disconnect');
});

// Routes pour les fonctionnalités premium
Route::prefix('premium')->name('premium.')->middleware(['auth', 'premium'])->group(function () {
    // Analytics avancés (premium)
    Route::get('/analytics/advanced', [PremiumAnalyticsController::class, 'index'])->name('analytics.advanced');
    Route::get('/analytics/heatmaps', [PremiumAnalyticsController::class, 'heatmaps'])->name('analytics.heatmaps');
    Route::get('/analytics/funnels', [PremiumAnalyticsController::class, 'funnels'])->name('analytics.funnels');
    
    // IA avancée (premium)
    Route::post('/ai/advanced-insights', [PremiumAIController::class, 'advancedInsights'])->name('ai.advanced');
    Route::post('/ai/content-generator', [PremiumAIController::class, 'generateContent'])->name('ai.content.generate');
    Route::post('/ai/design-optimizer', [PremiumAIController::class, 'optimizeDesign'])->name('ai.design.optimize');
    
    // Fonctionnalités AR/VR (premium)
    Route::get('/ar/editor', [ARController::class, 'editor'])->name('ar.editor');
    Route::post('/ar/generate', [ARController::class, 'generate'])->name('ar.generate');
    Route::get('/ar/preview/{vcard}', [ARController::class, 'preview'])->name('ar.preview');
});
