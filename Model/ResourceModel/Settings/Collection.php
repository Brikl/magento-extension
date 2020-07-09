<?php
namespace Brikl\Studio\Model\ResourceModel\Settings;

class Collection extends \Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection
{
    protected $_idFieldName = 'id';
    protected $_eventPrefix = 'brikl_settings_collection';
    protected $_eventObject = 'settings_collection';

    /**
     * Define resource model
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init('Brikl\Studio\Model\Settings', 'Brikl\Studio\Model\ResourceModel\Settings');
    }
}
