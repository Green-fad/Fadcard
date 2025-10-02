<?php

namespace App\Models;

use App\Traits\Multitenantable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class CrmContact extends Model
{
    use HasFactory, Multitenantable, SoftDeletes;

    protected $fillable = [
        'user_id',
        'vcard_id',
        'name',
        'email',
        'phone',
        'company',
        'title',
        'location',
        'notes',
        'tags',
        'first_contact_at',
        'last_contact_at',
    ];

    protected $casts = [
        'tags' => 'array',
        'first_contact_at' => 'datetime',
        'last_contact_at' => 'datetime',
    ];

    protected $dates = [
        'first_contact_at',
        'last_contact_at',
        'deleted_at',
    ];

    /**
     * Relation avec l'utilisateur propriétaire
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Relation avec la carte de visite d'origine
     */
    public function vcard(): BelongsTo
    {
        return $this->belongsTo(Vcard::class);
    }

    /**
     * Relation avec les interactions CRM
     */
    public function interactions(): HasMany
    {
        return $this->hasMany(CrmInteraction::class, 'contact_id');
    }

    /**
     * Relation avec les rappels
     */
    public function reminders(): HasMany
    {
        return $this->hasMany(CrmReminder::class, 'contact_id');
    }

    /**
     * Scope pour filtrer par tags
     */
    public function scopeWithTag($query, $tag)
    {
        return $query->whereJsonContains('tags', $tag);
    }

    /**
     * Scope pour recherche globale
     */
    public function scopeSearch($query, $search)
    {
        return $query->where(function ($q) use ($search) {
            $q->where('name', 'like', "%{$search}%")
              ->orWhere('email', 'like', "%{$search}%")
              ->orWhere('company', 'like', "%{$search}%")
              ->orWhere('title', 'like', "%{$search}%");
        });
    }

    /**
     * Scope pour les contacts récents
     */
    public function scopeRecent($query, $days = 30)
    {
        return $query->where('created_at', '>=', now()->subDays($days));
    }

    /**
     * Obtenir le nombre total d'interactions
     */
    public function getTotalInteractionsAttribute()
    {
        return $this->interactions()->count();
    }

    /**
     * Obtenir la dernière interaction
     */
    public function getLastInteractionAttribute()
    {
        return $this->interactions()->latest('interaction_date')->first();
    }

    /**
     * Obtenir les rappels en attente
     */
    public function getPendingRemindersAttribute()
    {
        return $this->reminders()
            ->where('is_completed', false)
            ->where('reminder_date', '<=', now())
            ->count();
    }

    /**
     * Marquer le contact comme ayant été contacté
     */
    public function markAsContacted()
    {
        $this->update([
            'last_contact_at' => now(),
        ]);

        if (!$this->first_contact_at) {
            $this->update([
                'first_contact_at' => now(),
            ]);
        }
    }

    /**
     * Ajouter un tag au contact
     */
    public function addTag($tag)
    {
        $tags = $this->tags ?? [];
        if (!in_array($tag, $tags)) {
            $tags[] = $tag;
            $this->update(['tags' => $tags]);
        }
    }

    /**
     * Supprimer un tag du contact
     */
    public function removeTag($tag)
    {
        $tags = $this->tags ?? [];
        $tags = array_filter($tags, function ($t) use ($tag) {
            return $t !== $tag;
        });
        $this->update(['tags' => array_values($tags)]);
    }

    /**
     * Obtenir les statistiques du contact
     */
    public function getStats()
    {
        return [
            'total_interactions' => $this->total_interactions,
            'last_interaction' => $this->last_interaction,
            'pending_reminders' => $this->pending_reminders,
            'days_since_first_contact' => $this->first_contact_at 
                ? $this->first_contact_at->diffInDays(now()) 
                : 0,
            'days_since_last_contact' => $this->last_contact_at 
                ? $this->last_contact_at->diffInDays(now()) 
                : null,
        ];
    }

    /**
     * Créer une interaction automatiquement
     */
    public function addInteraction($type, $title, $description = null, $date = null)
    {
        return $this->interactions()->create([
            'user_id' => $this->user_id,
            'type' => $type,
            'title' => $title,
            'description' => $description,
            'interaction_date' => $date ?? now(),
        ]);
    }

    /**
     * Créer un rappel
     */
    public function addReminder($title, $description = null, $reminderDate = null)
    {
        return $this->reminders()->create([
            'user_id' => $this->user_id,
            'title' => $title,
            'description' => $description,
            'reminder_date' => $reminderDate ?? now()->addDay(),
        ]);
    }
}
