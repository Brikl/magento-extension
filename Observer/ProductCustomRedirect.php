<?php

namespace Brikl\Studio\Observer;

use Magento\Framework\Event\Observer;
use Magento\Framework\Event\ObserverInterface;

class ProductCustomRedirect implements ObserverInterface
{
    /**
     * @var \Magento\Framework\Registry
     */
    protected $registry;

    public function __construct(
        \Magento\Framework\Registry $reg
    ) {
        $this->registry = $reg;
    }

    public function execute(Observer $observer)
    {
        $product = $this->registry->registry('current_product');

        if (!$product) {
            return $this;
        }

        $objectManager = \Magento\Framework\App\ObjectManager::getInstance();

        $collection = $objectManager->create(\Brikl\Studio\Model\ResourceModel\Studio\Collection::class);

        $briklProductId = null;

        $collection->addFilter('product_id', $product->getId());
        $items = $collection->getItems();

        foreach ($items as $item) {
            $dataItem = $item->getData();
            $briklProductId = $dataItem['brikl_product_id'];
        }

        if ($briklProductId) {
            $objectManager = \Magento\Framework\App\ObjectManager::getInstance();

            $collection = $objectManager->create(\Brikl\Studio\Model\ResourceModel\Settings\Collection::class);

            $threeDOnly = null;

            $collection->addFieldToFilter('key', 'isBriklStudioEnabled');
            
            $load = $collection->load();
            $data = $load->getData();

            if (count($data) > 0 && $data[0]['value'] == 1) {
                $layout = $observer->getLayout();
                $layout->getUpdate()->addHandle('catalog_product_view_custom');
            }
        }
        return $this;
    }
}
