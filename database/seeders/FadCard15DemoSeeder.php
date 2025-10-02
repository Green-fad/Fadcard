<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Vcard;
use App\Models\VcardAnalytics;
use App\Models\CrmContact;
use App\Models\CrmInteraction;
use App\Models\CrmReminder;
use App\Models\AiInsight;
use App\Models\UserAchievement;
use App\Models\UserPoints;
use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;

class FadCard15DemoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Créer un utilisateur de démonstration
        $demoUser = User::firstOrCreate(
            ['email' => 'demo@fadcard.com'],
            [
                'name' => 'Jean Dupont',
                'password' => Hash::make('demo123'),
                'email_verified_at' => now(),
                'total_points' => 1250,
                'current_level' => 3,
                'last_activity_at' => now(),
                'preferences' => [
                    'dashboard_widgets' => [
                        ['id' => 'stats_views', 'type' => 'stat', 'title' => 'Vues Totales', 'order' => 1],
                        ['id' => 'stats_contacts', 'type' => 'stat', 'title' => 'Contacts Ajoutés', 'order' => 2],
                        ['id' => 'stats_cards', 'type' => 'stat', 'title' => 'Cartes Actives', 'order' => 3],
                        ['id' => 'chart_views', 'type' => 'chart', 'title' => 'Vues par Jour', 'order' => 4],
                    ],
                    'notifications' => [
                        'email_new_view' => true,
                        'email_new_contact' => true,
                        'push_achievements' => true,
                    ]
                ]
            ]
        );

        // Créer des cartes de visite de démonstration
        $vcards = [
            [
                'url_alias' => 'jean-dupont-ceo',
                'name' => 'Jean Dupont',
                'occupation' => 'CEO & Fondateur',
                'description' => 'Entrepreneur passionné par l\'innovation technologique et le networking digital.',
                'first_name' => 'Jean',
                'last_name' => 'Dupont',
                'email' => 'jean.dupont@techcorp.com',
                'phone' => '+33123456789',
                'company' => 'TechCorp Solutions',
                'job_title' => 'Directeur Général',
                'location' => 'Paris, France',
                'status' => 1,
                'total_views' => 1247,
                'total_interactions' => 89,
                'last_viewed_at' => now()->subHours(2),
                'analytics_enabled' => true,
            ],
            [
                'url_alias' => 'jean-dupont-designer',
                'name' => 'Jean Dupont - Designer',
                'occupation' => 'Designer UX/UI',
                'description' => 'Créateur d\'expériences utilisateur exceptionnelles et d\'interfaces modernes.',
                'first_name' => 'Jean',
                'last_name' => 'Dupont',
                'email' => 'jean.design@portfolio.com',
                'phone' => '+33123456789',
                'company' => 'Freelance',
                'job_title' => 'Designer UX/UI Senior',
                'location' => 'Paris, France',
                'status' => 1,
                'total_views' => 634,
                'total_interactions' => 45,
                'last_viewed_at' => now()->subDays(1),
                'analytics_enabled' => true,
            ],
            [
                'url_alias' => 'jean-dupont-consultant',
                'name' => 'Jean Dupont - Consultant',
                'occupation' => 'Consultant en Transformation Digitale',
                'description' => 'Expert en accompagnement des entreprises dans leur transformation numérique.',
                'first_name' => 'Jean',
                'last_name' => 'Dupont',
                'email' => 'jean.consulting@digital.com',
                'phone' => '+33123456789',
                'company' => 'Digital Transform',
                'job_title' => 'Consultant Senior',
                'location' => 'Lyon, France',
                'status' => 1,
                'total_views' => 892,
                'total_interactions' => 67,
                'last_viewed_at' => now()->subHours(5),
                'analytics_enabled' => true,
            ]
        ];

        foreach ($vcards as $vcardData) {
            $vcard = Vcard::firstOrCreate(
                ['url_alias' => $vcardData['url_alias']],
                array_merge($vcardData, ['user_id' => $demoUser->id])
            );

            // Générer des analytics pour chaque carte
            $this->generateAnalytics($vcard);
        }

        // Créer des contacts CRM de démonstration
        $this->generateCrmContacts($demoUser);

        // Créer des insights IA
        $this->generateAiInsights($demoUser);

        // Créer des achievements
        $this->generateAchievements($demoUser);

        // Créer l'historique des points
        $this->generatePointsHistory($demoUser);
    }

    private function generateAnalytics(Vcard $vcard)
    {
        $sources = ['direct', 'qr_code', 'social', 'email', 'referral'];
        $countries = ['France', 'Canada', 'Belgique', 'Suisse', 'Maroc'];
        $cities = ['Paris', 'Montreal', 'Bruxelles', 'Genève', 'Casablanca'];

        // Générer des vues pour les 30 derniers jours
        for ($i = 30; $i >= 0; $i--) {
            $date = now()->subDays($i);
            $viewsCount = rand(5, 50);

            for ($j = 0; $j < $viewsCount; $j++) {
                VcardAnalytics::create([
                    'vcard_id' => $vcard->id,
                    'visitor_ip' => $this->generateRandomIp(),
                    'visitor_country' => $countries[array_rand($countries)],
                    'visitor_city' => $cities[array_rand($cities)],
                    'user_agent' => $this->generateRandomUserAgent(),
                    'referrer' => rand(0, 1) ? 'https://google.com' : null,
                    'source_type' => $sources[array_rand($sources)],
                    'viewed_at' => $date->addMinutes(rand(0, 1439)),
                ]);
            }
        }
    }

    private function generateCrmContacts(User $user)
    {
        $contacts = [
            [
                'name' => 'Marie Dubois',
                'email' => 'marie.dubois@innovatetech.com',
                'phone' => '+33145678901',
                'company' => 'InnovateTech',
                'title' => 'Directrice Marketing',
                'location' => 'Paris, France',
                'notes' => 'Rencontrée lors de la conférence TechParis 2024. Très intéressée par nos solutions.',
                'tags' => ['client', 'marketing', 'tech'],
                'first_contact_at' => now()->subDays(15),
                'last_contact_at' => now()->subDays(2),
            ],
            [
                'name' => 'Thomas Martin',
                'email' => 'thomas.martin@startuplab.fr',
                'phone' => '+33156789012',
                'company' => 'StartupLab',
                'title' => 'CTO',
                'location' => 'Lyon, France',
                'notes' => 'Développeur passionné, cherche des partenariats techniques.',
                'tags' => ['prospect', 'tech', 'startup'],
                'first_contact_at' => now()->subDays(8),
                'last_contact_at' => now()->subDays(1),
            ],
            [
                'name' => 'Sophie Laurent',
                'email' => 'sophie.laurent@talentboost.com',
                'phone' => '+33167890123',
                'company' => 'TalentBoost',
                'title' => 'Consultante RH',
                'location' => 'Marseille, France',
                'notes' => 'Spécialiste en recrutement tech, excellents contacts dans le secteur.',
                'tags' => ['partenaire', 'rh', 'recrutement'],
                'first_contact_at' => now()->subDays(22),
                'last_contact_at' => now()->subDays(5),
            ],
            [
                'name' => 'Pierre Moreau',
                'email' => 'pierre.moreau@digitalagency.com',
                'phone' => '+33178901234',
                'company' => 'Digital Agency',
                'title' => 'Directeur Créatif',
                'location' => 'Bordeaux, France',
                'notes' => 'Agence créative spécialisée en branding digital. Collaboration possible.',
                'tags' => ['prospect', 'design', 'agence'],
                'first_contact_at' => now()->subDays(12),
                'last_contact_at' => now()->subDays(3),
            ]
        ];

        foreach ($contacts as $contactData) {
            $contact = CrmContact::create(array_merge($contactData, ['user_id' => $user->id]));

            // Générer des interactions pour chaque contact
            $this->generateCrmInteractions($contact, $user);

            // Générer des rappels
            $this->generateCrmReminders($contact, $user);
        }
    }

    private function generateCrmInteractions(CrmContact $contact, User $user)
    {
        $interactionTypes = ['email', 'call', 'meeting', 'note', 'view'];
        $interactions = [
            ['type' => 'email', 'title' => 'Email de présentation envoyé', 'description' => 'Présentation de nos services et demande de rendez-vous.'],
            ['type' => 'call', 'title' => 'Appel téléphonique', 'description' => 'Discussion de 30 minutes sur les besoins et opportunités.'],
            ['type' => 'meeting', 'title' => 'Rendez-vous en personne', 'description' => 'Réunion dans nos bureaux pour présentation détaillée.'],
            ['type' => 'note', 'title' => 'Note de suivi', 'description' => 'Contact très intéressé, à recontacter dans 2 semaines.'],
        ];

        foreach ($interactions as $index => $interactionData) {
            CrmInteraction::create([
                'contact_id' => $contact->id,
                'user_id' => $user->id,
                'type' => $interactionData['type'],
                'title' => $interactionData['title'],
                'description' => $interactionData['description'],
                'interaction_date' => now()->subDays(rand(1, 20)),
            ]);
        }
    }

    private function generateCrmReminders(CrmContact $contact, User $user)
    {
        $reminders = [
            [
                'title' => 'Relancer ' . $contact->name,
                'description' => 'Faire un suivi sur la proposition envoyée la semaine dernière.',
                'reminder_date' => now()->addDays(rand(1, 7)),
                'is_completed' => false,
            ],
            [
                'title' => 'Préparer présentation pour ' . $contact->company,
                'description' => 'Adapter notre présentation aux besoins spécifiques identifiés.',
                'reminder_date' => now()->addDays(rand(3, 10)),
                'is_completed' => false,
            ]
        ];

        foreach ($reminders as $reminderData) {
            CrmReminder::create(array_merge($reminderData, [
                'contact_id' => $contact->id,
                'user_id' => $user->id,
            ]));
        }
    }

    private function generateAiInsights(User $user)
    {
        $insights = [
            [
                'type' => 'optimization',
                'title' => 'Optimisation du contenu',
                'description' => 'Votre carte "CEO Profile" a 40% plus de vues. Considérez utiliser un design similaire pour vos autres cartes.',
                'priority' => 2,
                'is_read' => false,
                'generated_at' => now()->subHours(6),
            ],
            [
                'type' => 'expansion',
                'title' => 'Expansion géographique',
                'description' => 'Vos cartes sont populaires en Europe. Pensez à créer du contenu multilingue pour toucher plus d\'audience.',
                'priority' => 1,
                'is_read' => false,
                'generated_at' => now()->subHours(12),
            ],
            [
                'type' => 'engagement',
                'title' => 'Amélioration de l\'engagement',
                'description' => 'Les cartes avec vidéo ont 60% plus d\'interactions. Ajoutez une vidéo de présentation à vos cartes principales.',
                'priority' => 3,
                'is_read' => false,
                'generated_at' => now()->subDays(1),
            ],
            [
                'type' => 'performance',
                'title' => 'Performance exceptionnelle',
                'description' => 'Votre taux de conversion contact-to-meeting est de 25%, soit 3x la moyenne du secteur.',
                'priority' => 1,
                'is_read' => true,
                'generated_at' => now()->subDays(2),
            ]
        ];

        foreach ($insights as $insightData) {
            AiInsight::create(array_merge($insightData, ['user_id' => $user->id]));
        }
    }

    private function generateAchievements(User $user)
    {
        $achievements = [
            [
                'badge_type' => 'networker_pro',
                'badge_name' => 'Networker Pro',
                'badge_description' => 'Ajouté plus de 50 contacts à votre réseau',
                'badge_icon' => 'users',
                'points_earned' => 100,
                'earned_at' => now()->subDays(10),
            ],
            [
                'badge_type' => 'content_creator',
                'badge_name' => 'Créateur de Contenu',
                'badge_description' => 'Créé plus de 5 cartes de visite uniques',
                'badge_icon' => 'edit',
                'points_earned' => 75,
                'earned_at' => now()->subDays(15),
            ],
            [
                'badge_type' => 'analytics_master',
                'badge_name' => 'Maître des Analytics',
                'badge_description' => 'Atteint plus de 1000 vues sur vos cartes',
                'badge_icon' => 'trending-up',
                'points_earned' => 150,
                'earned_at' => now()->subDays(5),
            ]
        ];

        foreach ($achievements as $achievementData) {
            UserAchievement::create(array_merge($achievementData, ['user_id' => $user->id]));
        }
    }

    private function generatePointsHistory(User $user)
    {
        $pointsActions = [
            ['action_type' => 'card_created', 'points' => 25, 'description' => 'Création d\'une nouvelle carte de visite'],
            ['action_type' => 'card_viewed', 'points' => 1, 'description' => 'Votre carte a été vue'],
            ['action_type' => 'contact_added', 'points' => 10, 'description' => 'Nouveau contact ajouté'],
            ['action_type' => 'profile_completed', 'points' => 50, 'description' => 'Profil complété à 100%'],
            ['action_type' => 'first_interaction', 'points' => 15, 'description' => 'Première interaction sur votre carte'],
            ['action_type' => 'milestone_reached', 'points' => 100, 'description' => 'Milestone de 1000 vues atteint'],
        ];

        for ($i = 0; $i < 50; $i++) {
            $action = $pointsActions[array_rand($pointsActions)];
            UserPoints::create([
                'user_id' => $user->id,
                'action_type' => $action['action_type'],
                'points' => $action['points'],
                'description' => $action['description'],
                'earned_at' => now()->subDays(rand(1, 30)),
            ]);
        }
    }

    private function generateRandomIp()
    {
        return rand(1, 255) . '.' . rand(1, 255) . '.' . rand(1, 255) . '.' . rand(1, 255);
    }

    private function generateRandomUserAgent()
    {
        $userAgents = [
            'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/91.0.4472.124 Safari/537.36',
            'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/91.0.4472.124 Safari/537.36',
            'Mozilla/5.0 (iPhone; CPU iPhone OS 14_6 like Mac OS X) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/14.0 Mobile/15E148 Safari/604.1',
            'Mozilla/5.0 (Android 11; Mobile; rv:89.0) Gecko/89.0 Firefox/89.0',
        ];

        return $userAgents[array_rand($userAgents)];
    }
}
