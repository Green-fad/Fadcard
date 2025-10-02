<?php

namespace App\Models;

use App\Traits\Multitenantable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\DB;

class VcardAnalytics extends Model
{
    use HasFactory, Multitenantable;

    protected $fillable = [
        'vcard_id',
        'visitor_ip',
        'visitor_country',
        'visitor_city',
        'user_agent',
        'referrer',
        'source_type',
        'viewed_at',
    ];

    protected $casts = [
        'viewed_at' => 'datetime',
    ];

    /**
     * Relation avec la carte de visite
     */
    public function vcard(): BelongsTo
    {
        return $this->belongsTo(Vcard::class);
    }

    /**
     * Enregistrer une nouvelle vue
     */
    public static function recordView($vcardId, $request)
    {
        $analytics = new self();
        $analytics->vcard_id = $vcardId;
        $analytics->visitor_ip = $request->ip();
        $analytics->user_agent = $request->userAgent();
        $analytics->referrer = $request->header('referer');
        $analytics->source_type = self::determineSourceType($request);
        $analytics->viewed_at = now();

        // Géolocalisation basique (peut être améliorée avec un service externe)
        $analytics->visitor_country = self::getCountryFromIp($request->ip());
        $analytics->visitor_city = self::getCityFromIp($request->ip());

        $analytics->save();

        // Mettre à jour les compteurs de la carte
        $vcard = Vcard::find($vcardId);
        if ($vcard) {
            $vcard->increment('total_views');
            $vcard->update(['last_viewed_at' => now()]);
        }

        return $analytics;
    }

    /**
     * Déterminer le type de source
     */
    private static function determineSourceType($request)
    {
        $referrer = $request->header('referer');
        $userAgent = $request->userAgent();

        // QR Code (détection basique)
        if (strpos($userAgent, 'QR') !== false || $request->has('qr')) {
            return 'qr_code';
        }

        // Réseaux sociaux
        if ($referrer) {
            $socialPlatforms = ['facebook.com', 'twitter.com', 'linkedin.com', 'instagram.com'];
            foreach ($socialPlatforms as $platform) {
                if (strpos($referrer, $platform) !== false) {
                    return 'social';
                }
            }
        }

        // Email
        if ($request->has('utm_source') && $request->get('utm_source') === 'email') {
            return 'email';
        }

        // Lien direct ou autre
        return $referrer ? 'referral' : 'direct';
    }

    /**
     * Obtenir le pays depuis l'IP (implémentation basique)
     */
    private static function getCountryFromIp($ip)
    {
        // Ici, vous pourriez intégrer un service comme GeoIP ou MaxMind
        // Pour l'instant, retour d'une valeur par défaut
        return 'Unknown';
    }

    /**
     * Obtenir la ville depuis l'IP (implémentation basique)
     */
    private static function getCityFromIp($ip)
    {
        // Ici, vous pourriez intégrer un service comme GeoIP ou MaxMind
        // Pour l'instant, retour d'une valeur par défaut
        return 'Unknown';
    }

    /**
     * Obtenir les statistiques par période
     */
    public static function getStatsByPeriod($vcardId, $period = '7days')
    {
        $startDate = match ($period) {
            '24hours' => now()->subDay(),
            '7days' => now()->subWeek(),
            '30days' => now()->subMonth(),
            '90days' => now()->subDays(90),
            '1year' => now()->subYear(),
            default => now()->subWeek(),
        };

        return self::where('vcard_id', $vcardId)
            ->where('viewed_at', '>=', $startDate)
            ->selectRaw('DATE(viewed_at) as date, COUNT(*) as views')
            ->groupBy('date')
            ->orderBy('date')
            ->get();
    }

    /**
     * Obtenir les statistiques par source
     */
    public static function getStatsBySource($vcardId, $period = '30days')
    {
        $startDate = now()->subDays(30);

        return self::where('vcard_id', $vcardId)
            ->where('viewed_at', '>=', $startDate)
            ->selectRaw('source_type, COUNT(*) as views')
            ->groupBy('source_type')
            ->orderByDesc('views')
            ->get();
    }

    /**
     * Obtenir les statistiques par pays
     */
    public static function getStatsByCountry($vcardId, $period = '30days')
    {
        $startDate = now()->subDays(30);

        return self::where('vcard_id', $vcardId)
            ->where('viewed_at', '>=', $startDate)
            ->whereNotNull('visitor_country')
            ->selectRaw('visitor_country, COUNT(*) as views')
            ->groupBy('visitor_country')
            ->orderByDesc('views')
            ->limit(10)
            ->get();
    }

    /**
     * Obtenir les vues uniques (par IP)
     */
    public static function getUniqueViews($vcardId, $period = '30days')
    {
        $startDate = now()->subDays(30);

        return self::where('vcard_id', $vcardId)
            ->where('viewed_at', '>=', $startDate)
            ->distinct('visitor_ip')
            ->count();
    }

    /**
     * Obtenir les heures de pointe
     */
    public static function getPeakHours($vcardId, $period = '30days')
    {
        $startDate = now()->subDays(30);

        return self::where('vcard_id', $vcardId)
            ->where('viewed_at', '>=', $startDate)
            ->selectRaw('HOUR(viewed_at) as hour, COUNT(*) as views')
            ->groupBy('hour')
            ->orderByDesc('views')
            ->get();
    }

    /**
     * Obtenir le taux de croissance
     */
    public static function getGrowthRate($vcardId, $period = '30days')
    {
        $days = match ($period) {
            '7days' => 7,
            '30days' => 30,
            '90days' => 90,
            default => 30,
        };

        $currentPeriod = self::where('vcard_id', $vcardId)
            ->where('viewed_at', '>=', now()->subDays($days))
            ->count();

        $previousPeriod = self::where('vcard_id', $vcardId)
            ->where('viewed_at', '>=', now()->subDays($days * 2))
            ->where('viewed_at', '<', now()->subDays($days))
            ->count();

        if ($previousPeriod === 0) {
            return $currentPeriod > 0 ? 100 : 0;
        }

        return round((($currentPeriod - $previousPeriod) / $previousPeriod) * 100, 2);
    }

    /**
     * Scope pour filtrer par période
     */
    public function scopePeriod($query, $period)
    {
        $startDate = match ($period) {
            '24hours' => now()->subDay(),
            '7days' => now()->subWeek(),
            '30days' => now()->subMonth(),
            '90days' => now()->subDays(90),
            '1year' => now()->subYear(),
            default => now()->subWeek(),
        };

        return $query->where('viewed_at', '>=', $startDate);
    }

    /**
     * Scope pour filtrer par source
     */
    public function scopeBySource($query, $source)
    {
        return $query->where('source_type', $source);
    }
}
