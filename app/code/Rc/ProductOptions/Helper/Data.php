<?php
/**
	* Create Product Custom Options
	*
	* @category    Rohit Chauhan
	* @package     Rc_ProductOptions
	* @author      rohit.chauhan030@gmail.com
	*
*/
namespace Rc\ProductOptions\Helper;

class Data extends \Magento\Framework\App\Helper\AbstractHelper
{
    const IMAGE_WIDTH  = 50;
    const IMAGE_HEIGHT = 50;
    /**
    * @var \Magento\Catalog\Helper\Category
    */
    protected $categoryHelper;

    /**
    * @var \Magento\Catalog\Model\CategoryRepository
    */
    protected $categoryRepository;


    public function __construct(
        \Magento\Catalog\Helper\Category $categoryHelper,
        \Magento\Catalog\Model\CategoryRepository $categoryRepository
    ) {
        $this->categoryHelper = $categoryHelper;
        $this->categoryRepository = $categoryRepository;
    }

    public function getRushOrderSheetSize($categoryId){
        $sheetSize = 0;

        $categoryObj = $this->categoryRepository->get($categoryId);
    
        $rushOrder   = $categoryObj->getData('rc_enable_rush_order');

        if($rushOrder):
            $sheetSize = $categoryObj->getData('rc_sheet_size');
        endif;

        return $sheetSize;  
    }

}