<?php
namespace Brikl\Studio\Observer;

use Magento\Framework\Event\Observer;
use Magento\Framework\Event\ObserverInterface;
use Magento\Framework\View\Element\Context;
use Brikl\Studio\Model\ResourceModel\Studio\CollectionFactory;

class ProductSaveEvent implements ObserverInterface
{
    public function __construct(
        Context $context
        //other objects
    ) {
        $this->context     = $context;
        $this->_request   = $context->getRequest();
        //other objects
    }
    /**
     * Below is the method that will fire whenever the event runs!
     *
     * @param Observer $observer
     */
    public function execute(Observer $observer)
    {
        $params = $this->_request->getParams();

        if (isset($params['brikl_studio'])) {
            $fieldData = $params['brikl_studio'];
            $fieldData['id'] = $observer->getProduct()->getId();

            if (!isset($params['testing']) || $params['testing'] !== true) {
                $this->_saveToDB($fieldData);
            }
            return $fieldData;
        }
        

        return null;
    }

    private function _saveToDB($fieldData)
    {
        $productId = $fieldData['id'];
        $briklProductId = trim($fieldData['brikl_product_id']);

        $objectManager = \Magento\Framework\App\ObjectManager::getInstance();

        $collection = $objectManager->create(\Brikl\Studio\Model\ResourceModel\Studio\Collection::class);

        $collection->addFilter('product_id', $productId);

        $saveItem = null;

        if ($collection->count() > 0) {
            $items = $collection->getItems();
            foreach ($items as $item) {
                $item->setData('brikl_product_id', $briklProductId);
                $item->save();
                $saveItem = $item;
            }
        } elseif ($briklProductId !== '') {
            $item = $collection->getNewEmptyItem();
            $item->setData('brikl_product_id', $briklProductId);
            $item->setData('product_id', $productId);
            $item->save();
            $saveItem = $item;
        }
    }
}
