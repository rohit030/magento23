<?php
/**
	 * Product Options Rewrite Product Option Block
	 *
	 * @category    Rohit
	 * @package     Rc_ProductOptions
	 * @author      rohitchauhan030@gmail.com
	 *
     */   
namespace Rc\ProductOptions\Block\Catalog\Product\View\Options\Type\Select;

use Magento\Catalog\Block\Product\View\Options\Type\Select\Multiple;
use Magento\Catalog\Model\Product\Option;
use Magento\Framework\View\Element\Html\Select;
/**
 * Represent needed logic for dropdown and multi-select
 */


class MultipleType extends Multiple
{
    protected function _toHtml()
    {
        $option = $this->getOption();
        $optionType = $option->getType();
        $configValue = $this->getProduct()->getPreconfiguredValues()->getData('options/' . $option->getId());
        $require = $option->getIsRequire() ? ' required' : '';
        $extraParams = '';
        $optionIdentifier = $option->getCustomClass();
        $key = "ready";
        $key2= "size";
        $caseTitle = strtolower($option->getTitle());
        if(strpos($caseTitle, $key) !== false){
            $customClass="ready-artwork";
        }elseif(strpos($caseTitle, $key2) !== false){
            $customClass="customize-size";
        }else{
            $customClass=null;
        }

        /** @var Select $select */
        $select = $this->getLayout()->createBlock(
            Select::class
        )->setData(
            [
                'id' => 'select_' . $option->getId(),
                'class' =>$customClass . $require . ' product-custom-option admin__control-select',
            ]
        );
        $select = $this->insertSelectOption($select, $option);
        $select = $this->processSelectOption($select, $option);
        if ($optionType === Option::OPTION_TYPE_MULTIPLE) {
            $extraParams = ' multiple="multiple"';
        }
        if (!$this->getSkipJsReloadPrice()) {
            $extraParams .= ' onchange="opConfig.reloadPrice()"';
        }
        $extraParams .= ' data-selector="' . $select->getName() . '"';
        $extraParams .= ' data-formula ="' .$optionIdentifier . '"';
        $select->setExtraParams($extraParams);
        if ($configValue) {
            $select->setValue($configValue);
        }
        //return parent::_toHtml();
        return $select->getHtml();
    }

    /**
     * Returns select with inserted option give as a parameter
     *
     * @param Select $select
     * @param Option $option
     * @return Select
     */
     protected function insertSelectOption(Select $select, Option $option): Select
     {
         $require = $option->getIsRequire() ? ' required' : '';
         if ($option->getType() === Option::OPTION_TYPE_DROP_DOWN) {
             $select->setName('options[' . $option->getId() . ']')->addOption('', __('-- Please Select --'));
         } else {
             $select->setName('options[' . $option->getId() . '][]');
             $select->setClass('multiselect admin__control-multiselect' . $require . ' product-custom-option');
         }
 
         return $select;
     }
 
     /**
      * Returns select with formated option prices
      *
      * @param Select $select
      * @param Option $option
      * @return Select
      */
     protected function processSelectOption(Select $select, Option $option): Select
     {
         $store = $this->getProduct()->getStore();
         foreach ($option->getValues() as $_value) {
             $isPercentPriceType = $_value->getPriceType() === 'percent';
             $priceStr = $this->_formatPrice(
                 [
                     'is_percent' => $isPercentPriceType,
                     'pricing_value' => $_value->getPrice($isPercentPriceType)
                 ],
                 false
             );
             $select->addOption(
                 $_value->getOptionTypeId(),
                 $_value->getTitle() . ' ' . strip_tags($priceStr) . '',
                 [
                     'price' => $this->pricingHelper->currencyByStore(
                         $_value->getPrice(true),
                         $store,
                         false
                     )
                 ]
             );
         }
 
         return $select;
     }
}