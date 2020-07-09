<?php

namespace Brikl\Studio\Controller\Adminhtml\Settings;

class Save extends \Magento\Backend\App\Action
{
    protected $factory;

    protected $resource;

    public function __construct(
        \Magento\Backend\App\Action\Context $context,
        \Brikl\Studio\Model\ResourceModel\Settings\CollectionFactory $settingsFactory,
        \Brikl\Studio\Model\ResourceModel\Settings $settingsResource
    ) {
        parent::__construct($context);

        $this->factory = $settingsFactory;

        $this->resource = $settingsResource;
    }

 

    public function execute()
    {
        try {
            $settingsData = $this->getRequest()->getParams();

            if (is_array($settingsData) && !empty($settingsData)) {
                unset($settingsData['key']);
                unset($settingsData['form_key']);
                foreach ($settingsData as $key => $value) {
                    $collection = $this->factory->create();
                    $collection->addFieldToFilter('key', $key);
    
                    $load = $collection->load();
                    $data = $load->getData();
                    
                    if (count($data) == 0) {
                        $collection = $this->factory->create();
                        $newItem = $collection->getNewEmptyItem();
                        $newItem->setData('key', $key);
                        $newItem->setData('value', $value);
                        $collection->addItem($newItem);
                        $collection->save();
                    } else {
                        $load->setDataToAll('value', $value);
                        $load->save();
                    }
                }
            }

 

            $this->messageManager->addSuccessMessage(__('Rows have been saved successfully'));
        } catch (\Exception $e) {
            $this->messageManager->addErrorMessage(__($e->getMessage()));
        }

        $this->_redirect('*/*/index/');
    }
}
