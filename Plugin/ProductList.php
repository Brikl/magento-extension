<?php
namespace Brikl\Studio\Plugin;

class ProductList
{

    protected $layout;

    public function __construct(
        \Magento\Framework\View\LayoutInterface $layout
    ) {
        $this->layout = $layout;
    }

    public function afterGetProductDetailsHtml(
        \Magento\Catalog\Block\Product\ListProduct $subject,
        $result,
        \Magento\Catalog\Model\Product $product
    ) {
        if ($product->getData('isStudioCustom')) {
            return $this->layout->createBlock('Brikl\Studio\Block\DesignNowButton')
                ->setProduct($product)
                ->setTemplate('Brikl_Studio::html/design_now.phtml')->toHtml();
        }

        return $result;
    }

    public function aroundGetProductPrice(
        \Magento\Catalog\Block\Product\ListProduct $subject,
        \Closure $proceed,
        \Magento\Catalog\Model\Product $product
    ) {

        if ($product->getData('isStudioCustom') && !$product->getData('canShowPrice')) {
            $this->listProductBlock = $subject;
            $priceText = $subject->getLayout()
                ->createBlock('Magento\Framework\View\Element\Template')
                ->setTemplate('Brikl_Studio::html/custom_price.phtml')->toHtml();
            return $priceText;
        }

        return $proceed($product);
    }
}
