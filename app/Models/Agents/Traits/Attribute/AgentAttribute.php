<?php

namespace App\Models\Agents\Traits\Attribute;

/**
 * Class AgentAttribute.
 */
trait AgentAttribute
{
    /*
     * @return string
     */
    public function getActionButtonsAttribute()
    {
        return '<div class="btn-group action-btn">
                    ' . $this->getEditButtonAttribute('edit-agent', 'admin.agents.edit') . '
                    ' . $this->getDeleteButtonAttribute('delete-agent', 'admin.agents.destroy') . '
                </div>';
    }
}
