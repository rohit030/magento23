<?php


namespace Rc\ProductOptions\Block\Catalog\Product\View\Options\Type\Select;

    /**
     * Represent needed logic for checkbox and radio button option types
     */
    class CheckableOption extends \Magento\Catalog\Block\Product\View\Options\Type\Select\Checkable
    {
        /**
         * @var string
         */
        protected $_template = 'Rc_ProductOptions::catalog/product/composite/fieldset/options/view/checkable.phtml';
    
}
