<?php

namespace App\Models\Wishes;

use App\Models\BaseModel;

class Wish extends BaseModel
{
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
