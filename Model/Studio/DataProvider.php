<?php

namespace Brikl\Studio\Model\Embeded;

// use Brikl\Studio\Model\ResourceModel\Embeded\CollectionFactory;

class DataProvider extends \Magento\Ui\DataProvider\AbstractDataProvider
{
    /**
     * @var ResourceModel\Data\Collection
     */
    protected $collection;

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
        \Brikl\Studio\Model\ResourceModel\Studio\CollectionFactory $embededCollectionFactory
    ) {
        $this->collection = $embededCollectionFactory->create();
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

        $items = $this->collection->getItems();
        
        $count = $this->collection->count();

        foreach ($items as $item) {
            $data = $item->getData();
            $this->loadedData[$data['product_id']] = $data;
        }

        return $this->loadedData;
    }
}
