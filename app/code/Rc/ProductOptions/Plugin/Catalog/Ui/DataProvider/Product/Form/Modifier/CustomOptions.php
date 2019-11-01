<?php

namespace Rc\ProductOptions\Plugin\Catalog\Ui\DataProvider\Product\Form\Modifier;

class CustomOptions
{
    const OPTION_IDENTIFIER  = "custom_class"; 
    const OPTION_DESCRIPTION = "description"; 
    const OPTION_DEPENDANT   = "depends_id"; 

    public function afterModifyMeta(
        \Magento\Catalog\Ui\DataProvider\Product\Form\Modifier\CustomOptions $subject,
        $meta
    ) {
        $meta['custom_options']['children']['options']['children']['record']['children']['container_option']['children']['container_common']['children']['custom_class'] =
        $this->getIdentifierFieldConfig(
            100,
            [
                'arguments' => [
                    'data' => [
                        'config' => [
                            'label' => __('Identifier'),
                            'component' => 'Magento_Catalog/component/static-type-input',
                            'valueUpdate' => 'input',
                            'imports' => [
                                'optionId' => '${ $.provider }:${ $.parentScope }.option_id'
                            ]
                        ],
                    ],
                ],
            ]
        );
        $meta['custom_options']['children']['options']['children']['record']['children']['container_option']['children']['container_common']['children']['tooltip_desc'] =
        $this->getDescriptionFieldConfig(
            110,
            [
                'arguments' => [
                    'data' => [
                        'config' => [
                            'label' => __('Description'),
                            'component' => 'Magento_Catalog/component/static-type-input',
                            'valueUpdate' => 'input',
                            'imports' => [
                                'optionId' => '${ $.provider }:${ $.parentScope }.option_id'
                            ]
                        ],
                    ],
                ],
            ]
        );
        $meta['custom_options']['children']['options']['children']['record']['children']['container_option']['children']['container_common']['children']['depends_id'] =
        $this->getIdFieldConfig(
            120,
            [
                'arguments' => [
                    'data' => [
                        'config' => [
                            'label' => __('Id'),
                            'component' => 'Magento_Catalog/component/static-type-input',
                            'valueUpdate' => 'input',
                            'imports' => [
                                'optionId' => '${ $.provider }:${ $.parentScope }.option_id'
                            ]
                        ],
                    ],
                ],
            ]
        );
        return $meta;
    }

    /**
     * Get config for "Option Identifier" fields
     *
     * @param int $sortOrder
     * @param array $options
     * @return array
     */
    protected function getIdentifierFieldConfig($sortOrder, array $options = [])
    {
        return array_replace_recursive(
            [
                'arguments' => [
                    'data' => [
                        'config' => [
                            'label' => __('Identifier'),
                            'componentType' => \Magento\Ui\Component\Form\Field::NAME,
                            'formElement' => \Magento\Ui\Component\Form\Element\Input::NAME,
                            'dataScope' => self::OPTION_IDENTIFIER,
                            'dataType' => \Magento\Ui\Component\Form\Element\DataType\Text::NAME,
                            'sortOrder' => $sortOrder,
                            'validation' => [
                                'required-entry' => false
                            ],
                        ],
                    ],
                ],
            ],
            $options
        );
    }
/**
     * Get config for "Option Description" fields
     *
     * @param int $sortOrder
     * @param array $options
     * @return array
     */
    protected function getDescriptionFieldConfig($sortOrder, array $options = [])
    {
        return array_replace_recursive(
            [
                'arguments' => [
                    'data' => [
                        'config' => [
                            'label' => __('Description'),
                            'componentType' => \Magento\Ui\Component\Form\Field::NAME,
                            'formElement' => \Magento\Ui\Component\Form\Element\Input::NAME,
                            'dataScope' => self::OPTION_DESCRIPTION,
                            'dataType' => \Magento\Ui\Component\Form\Element\DataType\Text::NAME,
                            'sortOrder' => $sortOrder,
                            'validation' => [
                                'required-entry' => false
                            ],
                        ],
                    ],
                ],
            ],
            $options
        );
    }
    /**
     * Get config for "Option Description" fields
     *
     * @param int $sortOrder
     * @param array $options
     * @return array
     */
     protected function getIdFieldConfig($sortOrder, array $options = [])
     {
         return array_replace_recursive(
             [
                 'arguments' => [
                     'data' => [
                         'config' => [
                             'label' => __('Id'),
                             'componentType' => \Magento\Ui\Component\Form\Field::NAME,
                             'formElement' => \Magento\Ui\Component\Form\Element\Input::NAME,
                             'dataScope' => self::OPTION_DEPENDANT,
                             'dataType' => \Magento\Ui\Component\Form\Element\DataType\Text::NAME,
                             'sortOrder' => $sortOrder,
                             'validation' => [
                                 'required-entry' => false
                             ],
                         ],
                     ],
                 ],
             ],
             $options
         );
     }
}