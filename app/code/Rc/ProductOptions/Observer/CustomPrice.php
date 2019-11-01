<?php
	/**
	 * Rohit Hello CustomPrice Observer
	 *
	 * @category    Rohit Chauhan
	 * @package     Rc_ProductOptions
	 * @author      rohit.chauhan030@gmail.com
	 *
	 */
	namespace Rc\ProductOptions\Observer;

	use Magento\Framework\Event\ObserverInterface;
    use Magento\Framework\App\RequestInterface;
    use Magento\Framework\Event\Observer;

	class CustomPrice implements ObserverInterface
	{
		protected $_request;
		protected $logger;
		protected $option;
        
        public function __construct(RequestInterface $request,\Psr\Log\LoggerInterface $logger,\Magento\Catalog\Model\Product\Option $option)
        {
			$this->_request = $request;
			$this->logger = $logger;
			$this->option = $option;
        }
		public function execute(Observer $observer) {
			$item  = $observer->getEvent()->getData('quote_item');			
			$item = ( $item->getParentItem() ? $item->getParentItem() : $item );
			$customPrice = $this->_request->getPost('caculated_price'); //set your price here
			$measureWidth   = $this->_request->getPost('measure_width'); //set your price here
			$measureHeight  = $this->_request->getPost('measure_height'); //set your price here
			$_product = $item->getProduct();
			$options  = $_product->getTypeInstance(true)->getOrderOptions($_product);
        	$customOptions = $options['options'];
			foreach($customOptions as $key=>$option):
				if ($option['label']=="Width"):
					//$this->logger->info($key."==insidewidth==>".$option['option_id']);
					$item->getOptionByCode('option_'.$option['option_id'])->setValue($measureWidth);
				endif;
				if ($option['label']=="Height"):
					//$this->logger->info($key."==insideheight==>".$option['option_id']);	
					$item->getOptionByCode('option_'.$option['option_id'])->setValue($measureHeight);
				endif;				
			endforeach;

            if($customPrice):
                $price = $customPrice;
            else:
                $price = $item->getBasePrice(); 
			endif;
			
			$item->setCustomPrice($price);
			$item->setOriginalCustomPrice($price);
			$item->getProduct()->setIsSuperMode(true);
		}

	}