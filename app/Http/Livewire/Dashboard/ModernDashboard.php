<?php

namespace App\Http\Livewire\Dashboard;

use App\Models\Vcard;
use App\Models\VcardAnalytics;
use App\Models\CrmContact;
use App\Models\AiInsight;
use App\Models\UserAchievement;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class ModernDashboard extends Component
{
    public $selectedPeriod = '30days';
    public $widgets = [];
    public $dashboardStats = [];
    public $recentActivity = [];
    public $insights = [];

    protected $listeners = [
        'periodChanged' => 'updatePeriod',
        'widgetMoved' => 'updateWidgetOrder',
    ];

    public function mount()
    {
        $this->loadDashboardData();
        $this->loadWidgets();
    }

    public function render()
    {
        return view('livewire.dashboard.modern-dashboard');
    }

    public function updatePeriod($period)
    {
        $this->selectedPeriod = $period;
        $this->loadDashboardData();
    }

    private function loadDashboardData()
    {
        $user = Auth::user();
        $userVcards = $user->vcards;

        // Statistiques principales
        $this->dashboardStats = [
            'total_views' => $this->getTotalViews($userVcards),
            'total_contacts' => $this->getTotalContacts(),
            'active_cards' => $userVcards->where('status', 1)->count(),
            'growth_rate' => $this->getGrowthRate($userVcards),
        ];

        // Données pour les graphiques
        $this->dashboardStats['views_chart'] = $this->getViewsChartData($userVcards);
        $this->dashboardStats['sources_chart'] = $this->getSourcesChartData($userVcards);

        // Activité récente
        $this->recentActivity = $this->getRecentActivity();

        // Insights IA
        $this->insights = $this->getAiInsights();
    }

    private function loadWidgets()
    {
        $user = Auth::user();
        $preferences = $user->preferences ?? [];
        
        // Configuration par défaut des widgets
        $defaultWidgets = [
            ['id' => 'stats_views', 'type' => 'stat', 'title' => 'Vues Totales', 'order' => 1],
            ['id' => 'stats_contacts', 'type' => 'stat', 'title' => 'Contacts Ajoutés', 'order' => 2],
            ['id' => 'stats_cards', 'type' => 'stat', 'title' => 'Cartes Actives', 'order' => 3],
            ['id' => 'chart_views', 'type' => 'chart', 'title' => 'Vues par Jour', 'order' => 4],
            ['id' => 'chart_sources', 'type' => 'chart', 'title' => 'Sources de Trafic', 'order' => 5],
            ['id' => 'recent_activity', 'type' => 'activity', 'title' => 'Activité Récente', 'order' => 6],
        ];

        $this->widgets = $preferences['dashboard_widgets'] ?? $defaultWidgets;
    }

    private function getTotalViews($vcards)
    {
        $vcardIds = $vcards->pluck('id');
        $period = $this->getPeriodDays();
        
        return VcardAnalytics::whereIn('vcard_id', $vcardIds)
            ->where('viewed_at', '>=', now()->subDays($period))
            ->count();
    }

    private function getTotalContacts()
    {
        $period = $this->getPeriodDays();
        
        return CrmContact::where('user_id', Auth::id())
            ->where('created_at', '>=', now()->subDays($period))
            ->count();
    }

    private function getGrowthRate($vcards)
    {
        $vcardIds = $vcards->pluck('id');
        $period = $this->getPeriodDays();
        
        $currentPeriod = VcardAnalytics::whereIn('vcard_id', $vcardIds)
            ->where('viewed_at', '>=', now()->subDays($period))
            ->count();

        $previousPeriod = VcardAnalytics::whereIn('vcard_id', $vcardIds)
            ->where('viewed_at', '>=', now()->subDays($period * 2))
            ->where('viewed_at', '<', now()->subDays($period))
            ->count();

        if ($previousPeriod === 0) {
            return $currentPeriod > 0 ? 100 : 0;
        }

        return round((($currentPeriod - $previousPeriod) / $previousPeriod) * 100, 2);
    }

    private function getViewsChartData($vcards)
    {
        $vcardIds = $vcards->pluck('id');
        $period = $this->getPeriodDays();
        
        $data = VcardAnalytics::whereIn('vcard_id', $vcardIds)
            ->where('viewed_at', '>=', now()->subDays($period))
            ->selectRaw('DATE(viewed_at) as date, COUNT(*) as views')
            ->groupBy('date')
            ->orderBy('date')
            ->get();

        // Formater pour le graphique
        return $data->map(function ($item) {
            return [
                'date' => Carbon::parse($item->date)->format('M d'),
                'views' => $item->views,
            ];
        });
    }

    private function getSourcesChartData($vcards)
    {
        $vcardIds = $vcards->pluck('id');
        $period = $this->getPeriodDays();
        
        $data = VcardAnalytics::whereIn('vcard_id', $vcardIds)
            ->where('viewed_at', '>=', now()->subDays($period))
            ->selectRaw('source_type, COUNT(*) as views')
            ->groupBy('source_type')
            ->orderByDesc('views')
            ->get();

        $colors = [
            'qr_code' => '#8b5cf6',
            'direct' => '#06b6d4',
            'social' => '#10b981',
            'email' => '#f59e0b',
            'referral' => '#ef4444',
        ];

        return $data->map(function ($item) use ($colors) {
            return [
                'name' => $this->getSourceLabel($item->source_type),
                'value' => $item->views,
                'color' => $colors[$item->source_type] ?? '#6b7280',
            ];
        });
    }

    private function getRecentActivity()
    {
        $user = Auth::user();
        $activities = [];

        // Vues récentes des cartes
        $recentViews = VcardAnalytics::whereHas('vcard', function ($query) use ($user) {
            $query->where('user_id', $user->id);
        })
        ->with('vcard')
        ->latest('viewed_at')
        ->limit(5)
        ->get();

        foreach ($recentViews as $view) {
            $activities[] = [
                'type' => 'view',
                'title' => "Nouvelle vue sur votre carte \"{$view->vcard->name}\"",
                'time' => $view->viewed_at->diffForHumans(),
                'icon' => 'eye',
            ];
        }

        // Nouveaux contacts
        $recentContacts = CrmContact::where('user_id', $user->id)
            ->latest('created_at')
            ->limit(3)
            ->get();

        foreach ($recentContacts as $contact) {
            $activities[] = [
                'type' => 'contact',
                'title' => "Contact ajouté: {$contact->name}",
                'time' => $contact->created_at->diffForHumans(),
                'icon' => 'user-plus',
            ];
        }

        // Badges récents
        $recentAchievements = UserAchievement::where('user_id', $user->id)
            ->latest('earned_at')
            ->limit(2)
            ->get();

        foreach ($recentAchievements as $achievement) {
            $activities[] = [
                'type' => 'achievement',
                'title' => "Nouveau badge débloqué: {$achievement->badge_name}",
                'time' => $achievement->earned_at->diffForHumans(),
                'icon' => 'award',
            ];
        }

        // Trier par date et limiter
        usort($activities, function ($a, $b) {
            return strtotime($b['time']) - strtotime($a['time']);
        });

        return array_slice($activities, 0, 10);
    }

    private function getAiInsights()
    {
        return AiInsight::where('user_id', Auth::id())
            ->where('is_read', false)
            ->orderByDesc('priority')
            ->orderByDesc('generated_at')
            ->limit(3)
            ->get();
    }

    private function getPeriodDays()
    {
        return match ($this->selectedPeriod) {
            '7days' => 7,
            '30days' => 30,
            '90days' => 90,
            '1year' => 365,
            default => 30,
        };
    }

    private function getSourceLabel($sourceType)
    {
        return match ($sourceType) {
            'qr_code' => 'QR Code',
            'direct' => 'Lien Direct',
            'social' => 'Réseaux Sociaux',
            'email' => 'Email',
            'referral' => 'Référence',
            default => 'Autre',
        };
    }

    public function updateWidgetOrder($widgets)
    {
        $this->widgets = $widgets;
        
        // Sauvegarder les préférences utilisateur
        $user = Auth::user();
        $preferences = $user->preferences ?? [];
        $preferences['dashboard_widgets'] = $widgets;
        $user->update(['preferences' => $preferences]);
    }

    public function markInsightAsRead($insightId)
    {
        AiInsight::where('id', $insightId)
            ->where('user_id', Auth::id())
            ->update(['is_read' => true]);
        
        $this->insights = $this->getAiInsights();
    }

    public function refreshData()
    {
        $this->loadDashboardData();
        $this->emit('dataRefreshed');
    }
}
