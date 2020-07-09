<?php

namespace Brikl\Studio\Ui\DataProvider\Product\Form\Modifier;

use Magento\Catalog\Ui\DataProvider\Product\Form\Modifier\AbstractModifier;
use Magento\Catalog\Model\Locator\LocatorInterface;
use Magento\Ui\Component\Form\Fieldset;
use Magento\Ui\Component\Form\Field;
use Magento\Ui\Component\Form\Element\Select;
use Magento\Ui\Component\Form\Element\Input;
use Magento\Ui\Component\Form\Element\DataType\Text;

class Fields extends AbstractModifier
{
    public function __construct(LocatorInterface $locator)
    {
        $this->locator = $locator;
    }

    public function modifyMeta(array $meta)
    {
        $meta = array_replace_recursive(
            $meta,
            [
                'brikl_studio' => [
                    'arguments' => [
                        'data' => [
                            'config' => [
                                'label' => __('BRIKL Studio'),
                                'collapsible' => true,
                                'componentType' => Fieldset::NAME,
                                'dataScope' => 'data.brikl_studio',
                                'sortOrder' => 120
                            ],
                        ],
                    ],
                    'children' => $this->getFields()
                ],
            ]
        );
        return $meta;
    }

    public function modifyData(array $data)
    {
        $product   = $this->locator->getProduct();
        $productId = $product->getId();

        $objectManager = \Magento\Framework\App\ObjectManager::getInstance();

        $collection = $objectManager->create(\Brikl\Studio\Model\ResourceModel\Studio\Collection::class);

        $fields = $collection->getFields();

        $collection->addFieldToFilter('product_id', $productId);
        $items = $collection->getItems();

        $defaults = [];

        foreach ($fields as $field) {
            $defaults[$field["COLUMN_NAME"]] = $field["DEFAULT"] ;
        }

        $data[strval($productId)]['brikl_studio'] = $defaults;

        foreach ($items as $item) {
            $dataItem = $item->getData();
            $data[strval($productId)]['brikl_studio'] = $dataItem;
        }

        return $data;
    }

    protected function getFields()
    {
        return [
            'brikl_product_id'    => [
                'arguments' => [
                    'data' => [
                        'config' => [
                            'label'         => __('Product Id'),
                            'componentType' => Field::NAME,
                            'formElement'   => Input::NAME,
                            'dataScope'     => 'brikl_product_id',
                            'dataType'      => Text::NAME,
                            'sortOrder'     => 10
                        ],
                    ],
                ],
            ]
        ];
    }
}
