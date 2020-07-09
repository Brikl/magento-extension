<?php
namespace Brikl\Studio\Model;

class Settings extends \Magento\Framework\Model\AbstractModel implements \Magento\Framework\DataObject\IdentityInterface
{
    const CACHE_TAG = 'brikl_settings';

    protected $_cacheTag = 'brikl_settings';

    protected $_eventPrefix = 'brikl_settings';

    protected function _construct()
    {
        $this->_init('Brikl\Studio\Model\ResourceModel\Settings');
    }

    public function getIdentities()
    {
        return [self::CACHE_TAG . '_' . $this->getId()];
    }

    public function getDefaultValues()
    {
        $values = [];

        return $values;
    }
}
