<?php
namespace Brikl\Studio\Block;

class CustomDesign extends \Magento\Framework\View\Element\Template
{
    protected $mp;

    protected $p;

    protected $pd;

    protected $lang;

    protected $cartId;

    public function __construct(
        \Magento\Framework\View\Element\Template\Context $context
    ) {
        parent::__construct($context);

        $objectManager = \Magento\Framework\App\ObjectManager::getInstance();

        $cart = $objectManager->create(\Magento\Checkout\Model\Cart::class);
        $cart->save();
        $this->cartId = $cart->getQuote()->getId();
        
        $params = $this->getRequest()->getParams();

        $this->lang = (isset($params['lang']))? $params['lang'] : null;
        $this->mp = (isset($params['mp']))? $params['mp'] : null;
        $this->p = (isset($params['p']))? $params['p'] : null;
        $this->pd = (isset($params['pd']))? $params['pd'] : null;
    }
    
    public function getProductData()
    {
        $objectManager = \Magento\Framework\App\ObjectManager::getInstance();

        $collection = $objectManager->create(\Brikl\Studio\Model\ResourceModel\Studio\Collection::class);

        $briklProductId = null;
        $shopId = null;
        $salesChannelId = null;
        $embedHostURI = null;
        $redirectOnAddToCart = null;

        $collection->addFilter('product_id', $this->mp);
        $items = $collection->getItems();

        foreach ($items as $item) {
            $dataItem = $item->getData();
            $briklProductId = $dataItem['brikl_product_id'];
        }

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
                case 'embed_host_uri':
                    $embedHostURI = $dataItem['value'];
                    break;
                case 'redirect_on_add_to_cart':
                    $redirectOnAddToCart = $dataItem['value'];
                    break;
            }
        }

        

        return [
            'redirectOnAddToCart' => $redirectOnAddToCart,
            'embedHostURI' => $embedHostURI,
            'lang' => $this->lang,
            'briklProductId' => $briklProductId,
            'shopId' => $shopId,
            'salesChannelId' => $salesChannelId,
            'pd' => $this->pd,
            'mp' => $this->mp,
            'c' => $this->cartId
        ];
    }
}
