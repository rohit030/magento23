<?php
    /**
	 * Create Product Custom Options
	 *
	 * @category    Rohit Chauhan
	 * @package     Rc_ProductOptions
	 * @author      rohit.chauhan030@gmail.com
	 *
     */
namespace Rc\ProductOptions\Ui\DataProvider\Product\Form\Modifier;


use Magento\Catalog\Model\Locator\LocatorInterface;
use Magento\Store\Model\StoreManagerInterface;
use Magento\Catalog\Model\ProductOptions\ConfigInterface;
use Magento\Catalog\Model\Config\Source\Product\Options\Price as ProductOptionsPrice;
use Magento\Framework\UrlInterface;
use Magento\Framework\Stdlib\ArrayManager;
use Magento\Ui\Component\Modal;
use Magento\Ui\Component\Container;
use Magento\Ui\Component\DynamicRows;
use Magento\Ui\Component\Form\Fieldset;
use Magento\Ui\Component\Form\Field;
use Magento\Ui\Component\Form\Element\Input;
use Magento\Ui\Component\Form\Element\Select;
use Magento\Ui\Component\Form\Element\Checkbox;
use Magento\Ui\Component\Form\Element\ActionDelete;
use Magento\Ui\Component\Form\Element\DataType\Text;
use Magento\Ui\Component\Form\Element\DataType\Number;
use Magento\Framework\Locale\CurrencyInterface;


class CustomOptions extends \Magento\Catalog\Ui\DataProvider\Product\Form\Modifier\CustomOptions
{
    /**#@+
     * Field values
     * 
     */
    const FIELD_IMAGE_NAME = 'image';

    /**
     * Get config for grid for "select" types
     * 
     * @param int $sortOrder
     * @return array
     */
    protected function getSelectTypeGridConfig($sortOrder)
    {
        return [
            'arguments' => [
                'data' => [
                    'config' => [
                        'addButtonLabel' => __('Add Value'),
                        'componentType' => DynamicRows::NAME,
                        'component' => 'Magento_Ui/js/dynamic-rows/dynamic-rows',
                        'additionalClasses' => 'admin__field-wide',
                        'deleteProperty' => static::FIELD_IS_DELETE,
                        'deleteValue' => '1',
                        'renderDefaultRecord' => false,
                        'sortOrder' => $sortOrder,
                    ],
                ],
            ],
            'children' => [
                'record' => [
                    'arguments' => [
                        'data' => [
                            'config' => [
                                'componentType' => Container::NAME,
                                'component' => 'Magento_Ui/js/dynamic-rows/record',
                                'positionProvider' => static::FIELD_SORT_ORDER_NAME,
                                'isTemplate' => true,
                                'is_collection' => true,
                            ],
                        ],
                    ],
                    'children' => [
                        static::FIELD_TITLE_NAME => $this->getTitleFieldConfig(10),
                        static::FIELD_PRICE_NAME => $this->getPriceFieldConfig(20),
                        static::FIELD_PRICE_TYPE_NAME => $this->getPriceTypeFieldConfig(30, ['fit' => true]),
                        static::FIELD_SKU_NAME => $this->getSkuFieldConfig(40),
                        static::FIELD_SORT_ORDER_NAME => $this->getPositionFieldConfig(50),
                        static::FIELD_IMAGE_NAME => $this->getImageFieldConfig(55),
                        static::FIELD_IS_DELETE => $this->getIsDeleteFieldConfig(60)
                    ]
                ]
            ]
        ];
    }

    /**
     * Get config for "Image" fields
     * 
     * @param $sortOrder 
     * @param array $options
     * @return array
     */
    protected function getImageFieldConfig($sortOrder, array $options = [])
    {
        return array_replace_recursive(
            [
                'arguments' => [
                    'data' => [
                        'config' => [
                            'label' => __('Image Name'),
                            'componentType' => Field::NAME,
                            'formElement' => Input::NAME,
                            'dataScope' => static::FIELD_IMAGE_NAME,
                            'dataType' => Text::NAME,
                            'sortOrder' => $sortOrder,
                            'validation' => [
                                'validate-digits' => false
                            ],
                        ],
                    ],
                ],
            ],
            $options
        );
    }
}