<?php

namespace App\Models\Wishes\Traits\Relationship;

use App\Models\Access\User\User;
use App\Models\Agents\Agent;
use App\Models\Comments\Comment;
use App\Models\Contact\Contact;
use App\Models\Groups\Group;
use App\Models\Messages\Message;
use App\Models\Offers\Offer;
use BrianFaust\Categories\Models\Category;

/**
 * Class WishRelationship.
 */
trait WishRelationship
{
    /**
     * Wishes belongsTo with User.
     */
    public function owner()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    /**
     * Wishes belongsTo with Group.
     */
    public function agent()
    {
        return $this->belongsTo(Agent::class, 'agent_id');
    }


    /**
     * Wishes belongsTo with Group.
     */
    public function group()
    {
        return $this->belongsTo(Group::class, 'group_id');
    }

    /**
     * Wishes belongsTo with Whitelabel.
     */
    public function whitelabel()
    {
        return $this->belongsTo(config('access.whitelabel'));
    }

    /**
     * Wishes HasMany  Offers.
     */
    public function offers()
    {
        return $this->hasMany(Offer::class);
    }

    /**
     * Wishes HasMany  Messages.
     */
    public function messages()
    {
        return $this->hasMany(Message::class);
    }

    /**
     * Wishes HasMany  Messages.
     */
    public function sellerMessages()
    {
        return $this->hasMany(Message::class)->where('agent_id', '!=', null);
    }

    /**
     * Wishes HasMany  Comments.
     */
    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    /**
     * Wishes HasMany  Contacts.
     */
    public function contacts()
    {
        return $this->hasMany(Contact::class, 'wish_id')->where('email', '!=', 'no data');
    }

    /**
     * Wishes HasMany  Callback.
     */
    public function callbacks()
    {
        return $this->hasMany(Contact::class, 'wish_id')->where('email', '=', 'no data');
    }

    /**
     * @return mixed
     */
    public function categories()
    {
        return $this->belongsToMany(Category::class, config('access.categories_wish_table'), 'wish_id', 'category_id');
    }

    /**
     * Alias to eloquent many-to-many relation's attach() method.
     *
     * @param mixed $category
     */
    public function attachCategory($category)
    {
        if (\is_object($category)) {
            $category = $category->getKey();
        }

        if (\is_array($category)) {
            $category = $category['id'];
        }

        $this->categories()->attach($category);
    }

    /**
     * Alias to eloquent many-to-many relation's attach() method.
     *
     * @param mixed $whitelabel
     */
    public function attachWhitelabel($whitelabel)
    {
        if (\is_object($whitelabel)) {
            $whitelabel = $whitelabel->getKey();
        }

        if (\is_array($whitelabel)) {
            $whitelabel = $whitelabel['id'];
        }

        $this->whitelabels()->attach($whitelabel);
    }

    /**
     * Attach multiple whitelabels to a wish.
     *
     * @param mixed $whitelabels
     */
    public function attachWhitelabels($whitelabels)
    {
        foreach ($whitelabels as $whitelabel) {
            $this->attachWhitelabel($whitelabel);
        }
    }

    public function getTotalOffersAttribute()
    {
        return $this->hasMany(Offer::class)->count();
    }
}
