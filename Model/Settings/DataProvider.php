<?php

namespace Brikl\Studio\Model\Settings;

// use Brikl\Studio\Model\ResourceModel\Embeded\CollectionFactory;
use Magento\Framework\Api\FilterBuilder;

class DataProvider extends \Magento\Ui\DataProvider\AbstractDataProvider
{
    /**
     * @var ResourceModel\Settings\CollectionFactory
     */
    protected $rowCollection;

    /**
     * @var DataPersistorInterface
     */
    protected $dataPersistor;

    /**
     * @var array
     */
    protected $loadedData;

    /**
     * @param string $name
     * @param string $primaryFieldName
     * @param string $requestFieldName
     * @param CollectionFactory $embededCollectionFactory
     */
    public function __construct(
        $name,
        $primaryFieldName,
        $requestFieldName,
        \Brikl\Studio\Model\ResourceModel\Settings\Collection $collection,
        \Brikl\Studio\Model\ResourceModel\Settings\CollectionFactory $settingsCollectionFactory
    ) {
        $this->collection = $collection;
        $this->rowCollection = $settingsCollectionFactory;
        parent::__construct($name, $primaryFieldName, $requestFieldName);
    }

    /**
     * Get data
     *
     * @return array
     */
    public function getData()
    {
        if (isset($this->loadedData)) {
            return $this->loadedData;
        }

        $collection = $this->rowCollection->create();

        $items = $collection->getItems();

        $this->loadedData[0] = [];

        foreach ($items as $item) {
            $data = $item->getData();
            $this->loadedData[0][$data['key']] = $data['value'];
            //$this->loadedData[$item->getId()] = $item->getData();
        }

        if (count($this->loadedData[0]) === 0) {
            $this->loadedData[0]['isBriklStudioEnabled'] = '0';
        }

        return $this->loadedData;
    }
}
