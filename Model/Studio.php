<?php
namespace Brikl\Studio\Model;

class Studio extends \Magento\Framework\Model\AbstractModel implements \Magento\Framework\DataObject\IdentityInterface
{
    const CACHE_TAG = 'brikl_studio';

    protected $_cacheTag = 'brikl_studio';

    protected $_eventPrefix = 'brikl_studio';

    protected function _construct()
    {
        $this->_init('Brikl\Studio\Model\ResourceModel\Studio');
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
