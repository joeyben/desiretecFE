<?php

namespace App\Models\Offers\Traits\Relationship;

use App\Models\Access\User\User;
use App\Models\Agents\Agent;
use App\Models\OfferFiles\OfferFile;
use App\Models\Wishes\Wish;

/**
 * Class OfferRelationship.
 */
trait OfferRelationship
{
    /**
     * Offers belongsTo with User.
     */
    public function owner()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    /**
     * Offers belongsTo with Wish.
     */
    public function wish()
    {
        return $this->belongsTo(Wish::class, 'wish_id');
    }

    /**
     * Offers belongsTo with Wish.
     */
    public function agent()
    {
        return $this->belongsTo(Agent::class, 'agent_id');
    }

    /**
     * Offers HasMany  OfferFiles.
     */
    public function offerFiles()
    {
        return $this->hasMany(OfferFile::class, 'offer_id', 'id');
    }
}
