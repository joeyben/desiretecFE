<?php

namespace App\Models\Offers;

use App\Models\BaseModel;
use App\Models\ModelTrait;
use App\Models\Offers\Traits\Attribute\OfferAttribute;
use App\Models\Offers\Traits\Relationship\OfferRelationship;
use Illuminate\Database\Eloquent\SoftDeletes;
use Modules\Wishes\Entities\Wish;

class Offer extends BaseModel
{
    use ModelTrait,
        SoftDeletes,
        OfferAttribute,
        OfferRelationship {
        // BlogAttribute::getEditButtonAttribute insteadof ModelTrait;
    }

    protected $fillable = [
        'title',
        'description',
        'status',
        'file',
        'agent_id',
        'created_by',
        'wish_id',
        'link'
    ];

    protected $dates = [
        'created_at',
        'updated_at',
    ];

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table;

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
        $this->table = config('module.offers.table');
    }

    /**
     * Offers belongsTo with Wish.
     */
    public function wish()
    {
        return $this->belongsTo(Wish::class);
    }
}
