<div class="min-h-screen bg-gray-50">
    <!-- Header -->
    <div class="bg-white border-b border-gray-200 px-6 py-4">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-3xl font-bold text-gray-900">{{ __('Tableau de Bord') }}</h1>
                <p class="text-gray-600 mt-1">{{ __('Bienvenue dans FadCard 1.5 - Votre centre de networking intelligent') }}</p>
            </div>
            <div class="flex items-center space-x-4">
                <!-- Sélecteur de période -->
                <select wire:model="selectedPeriod" wire:change="updatePeriod($event.target.value)" 
                        class="border border-gray-300 rounded-lg px-3 py-2 text-sm">
                    <option value="7days">{{ __('7 derniers jours') }}</option>
                    <option value="30days">{{ __('30 derniers jours') }}</option>
                    <option value="90days">{{ __('90 derniers jours') }}</option>
                    <option value="1year">{{ __('1 an') }}</option>
                </select>
                
                <!-- Boutons d'action -->
                <button class="inline-flex items-center px-3 py-2 border border-gray-300 rounded-lg text-sm font-medium text-gray-700 bg-white hover:bg-gray-50">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-5 5-5-5h5v-12h5v12z"/>
                    </svg>
                    {{ __('Notifications') }}
                    @if(count($insights) > 0)
                        <span class="ml-2 inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-red-100 text-red-800">
                            {{ count($insights) }}
                        </span>
                    @endif
                </button>
                
                <button class="inline-flex items-center px-4 py-2 border border-transparent rounded-lg text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                    </svg>
                    {{ __('Nouvelle Carte') }}
                </button>
            </div>
        </div>
    </div>

    <!-- Actions rapides -->
    <div class="px-6 py-4 bg-white border-b border-gray-200">
        <div class="flex items-center space-x-4">
            <a href="{{ route('vcards.index') }}" class="inline-flex items-center px-3 py-2 border border-gray-300 rounded-lg text-sm font-medium text-gray-700 bg-white hover:bg-gray-50">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/>
                </svg>
                {{ __('Mes Cartes') }}
            </a>
            <a href="#" class="inline-flex items-center px-3 py-2 border border-gray-300 rounded-lg text-sm font-medium text-gray-700 bg-white hover:bg-gray-50">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z"/>
                </svg>
                {{ __('Contacts') }}
            </a>
            <a href="#" class="inline-flex items-center px-3 py-2 border border-gray-300 rounded-lg text-sm font-medium text-gray-700 bg-white hover:bg-gray-50">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                </svg>
                {{ __('Analyses') }}
            </a>
            <a href="#" class="inline-flex items-center px-3 py-2 border border-gray-300 rounded-lg text-sm font-medium text-gray-700 bg-white hover:bg-gray-50">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/>
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                </svg>
                {{ __('Paramètres') }}
            </a>
        </div>
    </div>

    <!-- Contenu principal -->
    <div class="px-6 py-6">
        <!-- Widgets de statistiques -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
            <!-- Vues Totales -->
            <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6 hover:shadow-md transition-shadow duration-200">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-600">{{ __('Vues Totales') }}</p>
                        <p class="text-2xl font-bold text-gray-900">{{ number_format($dashboardStats['total_views'] ?? 0) }}</p>
                        <p class="text-xs text-gray-500 mt-1">
                            <span class="text-green-600 font-medium">+{{ $dashboardStats['growth_rate'] ?? 0 }}%</span>
                            {{ __('par rapport à la période précédente') }}
                        </p>
                    </div>
                    <div class="p-3 bg-blue-50 rounded-lg">
                        <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                        </svg>
                    </div>
                </div>
            </div>

            <!-- Contacts Ajoutés -->
            <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6 hover:shadow-md transition-shadow duration-200">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-600">{{ __('Contacts Ajoutés') }}</p>
                        <p class="text-2xl font-bold text-gray-900">{{ number_format($dashboardStats['total_contacts'] ?? 0) }}</p>
                        <p class="text-xs text-gray-500 mt-1">
                            <span class="text-green-600 font-medium">+8%</span>
                            {{ __('par rapport à la période précédente') }}
                        </p>
                    </div>
                    <div class="p-3 bg-green-50 rounded-lg">
                        <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z"/>
                        </svg>
                    </div>
                </div>
            </div>

            <!-- Cartes Actives -->
            <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6 hover:shadow-md transition-shadow duration-200">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-600">{{ __('Cartes Actives') }}</p>
                        <p class="text-2xl font-bold text-gray-900">{{ $dashboardStats['active_cards'] ?? 0 }}</p>
                        <p class="text-xs text-gray-500 mt-1">
                            <span class="text-green-600 font-medium">+2%</span>
                            {{ __('par rapport à la période précédente') }}
                        </p>
                    </div>
                    <div class="p-3 bg-purple-50 rounded-lg">
                        <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/>
                        </svg>
                    </div>
                </div>
            </div>

            <!-- Taux d'Engagement -->
            <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6 hover:shadow-md transition-shadow duration-200">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-600">{{ __('Taux d\'Engagement') }}</p>
                        <p class="text-2xl font-bold text-gray-900">{{ $dashboardStats['engagement_rate'] ?? '12.5' }}%</p>
                        <p class="text-xs text-gray-500 mt-1">
                            <span class="text-green-600 font-medium">+5%</span>
                            {{ __('par rapport à la période précédente') }}
                        </p>
                    </div>
                    <div class="p-3 bg-orange-50 rounded-lg">
                        <svg class="w-6 h-6 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"/>
                        </svg>
                    </div>
                </div>
            </div>
        </div>

        <!-- Graphiques et activité -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-8">
            <!-- Graphique des vues -->
            <div class="lg:col-span-2 bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-lg font-semibold text-gray-900">{{ __('Vues par Jour') }}</h3>
                    <button class="text-gray-400 hover:text-gray-600">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 5v.01M12 12v.01M12 19v.01M12 6a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2z"/>
                        </svg>
                    </button>
                </div>
                <div class="h-64 flex items-center justify-center text-gray-500">
                    {{ __('Graphique des vues (Chart.js sera intégré ici)') }}
                </div>
            </div>

            <!-- Activité récente -->
            <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-lg font-semibold text-gray-900">{{ __('Activité Récente') }}</h3>
                    <button class="text-gray-400 hover:text-gray-600">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 5v.01M12 12v.01M12 19v.01M12 6a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2z"/>
                        </svg>
                    </button>
                </div>
                <div class="space-y-4">
                    @forelse($recentActivity as $activity)
                        <div class="flex items-start space-x-3">
                            <div class="w-2 h-2 rounded-full mt-2 
                                {{ $activity['type'] === 'view' ? 'bg-blue-500' : '' }}
                                {{ $activity['type'] === 'contact' ? 'bg-green-500' : '' }}
                                {{ $activity['type'] === 'achievement' ? 'bg-purple-500' : '' }}
                            "></div>
                            <div class="flex-1 min-w-0">
                                <p class="text-sm font-medium text-gray-900">{{ $activity['title'] }}</p>
                                <p class="text-xs text-gray-500">{{ $activity['time'] }}</p>
                            </div>
                        </div>
                    @empty
                        <p class="text-sm text-gray-500">{{ __('Aucune activité récente') }}</p>
                    @endforelse
                </div>
            </div>
        </div>

        <!-- Insights de Performance -->
        @if(count($insights) > 0)
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
            <div class="flex items-center mb-4">
                <svg class="w-5 h-5 text-purple-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"/>
                </svg>
                <h3 class="text-lg font-semibold text-gray-900">{{ __('Insights de Performance') }}</h3>
            </div>
            <p class="text-gray-600 mb-6">{{ __('Recommandations personnalisées pour améliorer votre networking') }}</p>
            
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                @foreach($insights as $insight)
                    <div class="p-4 rounded-lg
                        {{ $insight->type === 'optimization' ? 'bg-blue-50' : '' }}
                        {{ $insight->type === 'expansion' ? 'bg-green-50' : '' }}
                        {{ $insight->type === 'engagement' ? 'bg-purple-50' : '' }}
                    ">
                        <div class="flex items-center space-x-2 mb-2">
                            <svg class="w-4 h-4 
                                {{ $insight->type === 'optimization' ? 'text-blue-600' : '' }}
                                {{ $insight->type === 'expansion' ? 'text-green-600' : '' }}
                                {{ $insight->type === 'engagement' ? 'text-purple-600' : '' }}
                            " fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"/>
                            </svg>
                            <span class="font-medium 
                                {{ $insight->type === 'optimization' ? 'text-blue-900' : '' }}
                                {{ $insight->type === 'expansion' ? 'text-green-900' : '' }}
                                {{ $insight->type === 'engagement' ? 'text-purple-900' : '' }}
                            ">{{ $insight->title }}</span>
                        </div>
                        <p class="text-sm 
                            {{ $insight->type === 'optimization' ? 'text-blue-800' : '' }}
                            {{ $insight->type === 'expansion' ? 'text-green-800' : '' }}
                            {{ $insight->type === 'engagement' ? 'text-purple-800' : '' }}
                        ">{{ $insight->description }}</p>
                        <button wire:click="markInsightAsRead({{ $insight->id }})" 
                                class="mt-2 text-xs text-gray-500 hover:text-gray-700">
                            {{ __('Marquer comme lu') }}
                        </button>
                    </div>
                @endforeach
            </div>
        </div>
        @endif
    </div>
</div>

@push('scripts')
<script>
    // Ici, nous pourrions ajouter Chart.js ou d'autres bibliothèques pour les graphiques
    document.addEventListener('DOMContentLoaded', function() {
        // Initialisation des graphiques
        console.log('Dashboard moderne chargé');
    });
</script>
@endpush
