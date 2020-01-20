<?php

namespace App\Models\Agents;

use App\Models\Agents\Traits\Attribute\AgentAttribute;
use App\Models\Agents\Traits\Relationship\AgentRelationship;
use App\Models\BaseModel;
use App\Models\ModelTrait;

/**
 * Class Agent.
 */
class Agent extends BaseModel
{
    use ModelTrait,
        AgentAttribute,
        AgentRelationship {
            // AgentAttribute::getEditButtonAttribute insteadof ModelTrait;
    }

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name', 'display_name', 'status', 'avatar', 'user_id', 'telephone', 'email'];

    protected $dates = [
        'created_at',
        'updated_at',
    ];

    /**
     * @param array $attributes
     */
    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
        $this->table = config('module.agents.table');
    }
}
