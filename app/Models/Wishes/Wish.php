<?php

namespace App\Models\Wishes;

use App\Models\BaseModel;
use App\Models\ModelTrait;
use App\Models\Wishes\Traits\Attribute\WishAttribute;
use App\Models\Wishes\Traits\Relationship\WishRelationship;
use Illuminate\Database\Eloquent\SoftDeletes;

class Wish extends BaseModel
{
    use ModelTrait,
        SoftDeletes,
        WishAttribute,
        WishRelationship {
        // BlogAttribute::getEditButtonAttribute insteadof ModelTrait;
    }

    protected $fillable = [
        'title',
        'airport',
        'destination',
        'earliest_start',
        'latest_return',
        'budget',
        'adults',
        'kids',
        'category',
        'catering',
        'description',
        'duration',
        'status',
        'featured_image',
        'created_by',
        'whitelabel_id',
        'group_id',
        'current',
        'quality',
        'ages',
        'direkt_flug',
        'extra_params'
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
        $this->table = config('module.wishes.table');
    }

    /**
     * Returns the extra_parameters as a clean array.
     *
     * @return array
     */
    public function getExtraParametersAsArray()
    {
        $toReturn = [];
        if (null !== $this->extra_params) {
            $extra_params = json_decode($this->extra_params, true);
            foreach ($extra_params as $key => $extra_param) {
                $toReturn[$key] = explode(', ', $extra_param);
            }
        }

        return $toReturn;
    }
}
