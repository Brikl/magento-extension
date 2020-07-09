<?php
namespace Brikl\Studio\Model\ResourceModel\Studio;

class Collection extends \Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection
{
    protected $_idFieldName = 'studio_id';
    protected $_eventPrefix = 'brikl_studio_collection';
    protected $_eventObject = 'studio_collection';

    /**
     * Define resource model
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init('Brikl\Studio\Model\Studio', 'Brikl\Studio\Model\ResourceModel\Studio');
    }

    public function getFields()
    {
        $fields = $this->getConnection()->describeTable($this->getMainTable());
        return $fields;
    }
}
