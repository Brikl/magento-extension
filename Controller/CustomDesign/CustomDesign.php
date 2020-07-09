<?php
namespace Brikl\Studio\Controller\CustomDesign;

class CustomDesign extends \Magento\Framework\App\Action\Action
{
    protected $_pageFactory;

    public function __construct(
        \Magento\Backend\App\Action\Context $context,
        \Magento\Framework\View\Result\PageFactory $pageFactory
    ) {
        $this->_pageFactory = $pageFactory;
        
        return parent::__construct($context);
    }
    
    public function execute()
    {
        $resultPage = $this->_pageFactory->create();
        $resultPage->getConfig()->getTitle()->set((__('Custom Design')));
        return $resultPage;
    }
}
