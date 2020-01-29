<?php

namespace App\Models\Offers\Traits\Attribute;

/**
 * Class BlogAttribute.
 */
trait OfferAttribute
{
    /**
     * @return string
     */
    public function getActionButtonsAttribute()
    {
        return '<div class="btn-group action-btn">' .
                $this->getEditButtonAttribute('edit-offer', 'frontend.offers.edit') .
                $this->getDeleteButtonAttribute('delete-offer', 'frontend.offers.destroy') .
                '</div>';
    }
}
