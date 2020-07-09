<?php
/**
 * Copyright © 2020 BRIKL. All rights reserved.
 */

namespace Brikl\Studio\Model\ResourceModel\Settings;

/**
 * Class CollectionFactory
 * @package Jmango360\Japi\Model\ResourceModel\Fulltext
 */
class CollectionFactory
{

    /**
     * Object Manager instance
     *
     * @var \Magento\Framework\ObjectManagerInterface
     */
    protected $_objectManager = null;

    /**
     * Instance name to create
     *
     * @var string
     */
    protected $_instanceName = null;

    /**
     * Factory constructor
     *
     * @param \Magento\Framework\ObjectManagerInterface $objectManager
     * @param string $instanceName
     */
    public function __construct(
        \Magento\Framework\ObjectManagerInterface $objectManager,
        $instanceName = \Brikl\Studio\Model\ResourceModel\Settings\Collection::class
    ) {
        $this->_objectManager = $objectManager;
        $this->_instanceName = $instanceName;
    }

    /**
     * {@inheritdoc)
     */
    public function create(array $data = [])
    {
        return $this->_objectManager->create($this->_instanceName, $data);
    }
}
