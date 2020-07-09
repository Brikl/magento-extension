<?php

namespace Brikl\Studio\Observer;

use Magento\Framework\Event\Observer;
use Magento\Framework\Event\ObserverInterface;

class ProductListCollection implements ObserverInterface
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
        $isEnabled = false;
        $shopId = null;
        $salesChannelId = null;
        $showPrice = true;

        $objectManager = \Magento\Framework\App\ObjectManager::getInstance();

        $collection = $objectManager->create(\Brikl\Studio\Model\ResourceModel\Settings\Collection::class);

        $threeDOnly = null;

        $items = $collection->getItems();

        foreach ($items as $item) {
            $dataItem = $item->getData();
            switch ($dataItem['key']) {
                case 'shop_id':
                    $shopId = $dataItem['value'];
                    break;
                case 'saleschannel_id':
                    $salesChannelId = $dataItem['value'];
                    break;
                case 'isBriklStudioEnabled':
                    $isEnabled = ($dataItem['value'] === '1')? true : false;
                    break;
                case 'showPrice':
                    $showPrice = ($dataItem['value'] === '1')? true : false;
                    break;
            }
        }

        if ($shopId && $isEnabled) {
            $event = $observer->getEvent();
            $_productCollection = $event->getCollection();

            foreach ($_productCollection as $_product) {
                $briklProductId = null;

                $productId = $_product->getId();

                $objectManager = \Magento\Framework\App\ObjectManager::getInstance();

                $collection = $objectManager->create(\Brikl\Studio\Model\ResourceModel\Studio\Collection::class);

                $collection->addFilter('product_id', $productId);
                $items = $collection->getItems();

                foreach ($items as $item) {
                    $dataItem = $item->getData();
                    $briklProductId = $dataItem['brikl_product_id'];
                }

                if ($briklProductId) {
                    $_product->setCanShowPrice(($_product->getCanShowPrice() !== false) && $showPrice);
                    $_product->setData('canShowPrice', ($_product->getCanShowPrice() !== false) && $showPrice);
                    $_product->setData('isStudioCustom', true);
                }
            }
        }
        
        return $this;
    }
}
