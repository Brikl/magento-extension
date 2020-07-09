<?php

namespace Brikl\Studio\Block\Adminhtml\Settings\Edit;

use Magento\Framework\View\Element\UiComponent\Control\ButtonProviderInterface;

class SaveButton extends GenericButton implements ButtonProviderInterface
{
    public function getButtonData()
    {
        return [

            'label' => __('Save Settings'),

            'class' => 'save primary',

            'on_click' => "",

            'data_attribute' => [
                'mage-init' => ['button' => ['event' => 'save']],
                'form-role' => 'save',
            ],

            'sort_order' => 90,

        ];
    }
}
