<?php
/**
	 * Create Product Custom Attributes
	 *
	 * @category  Rohit Chauhan
	 * @package   Rc_ProductFileAttribute
	 * @author    rohit.chauhan030@gmail.com
	 *
**/

namespace Rc\ProductFileAttribute\Block;
use Magento\Framework\View\Element\Template\Context;
use Magento\Framework\View\Element\Template;
use Magento\Framework\Registry;
use Magento\Downloadable\Helper\File;
use Magento\Framework\File\Size;

class MediaFile extends Template
{
    protected $_registry;
    protected $_file;
    protected $_size;

    public function __construct(
    Context $context,
    Registry $registry,
    File $file,
    Size $size,
    array $data = [])
	{
        $this->_registry = $registry;
        $this->_file = $file;
        $this->_size = $size;
		parent::__construct($context);
    }

    public function getCurrentProduct()
    {        
        return $this->_registry->registry('current_product');
    } 
    
    public function getProductMediaFile()
    {        
        return $this->getCurrentProduct()->getMediaFile();
    } 

    public function getMediaTitle()
    {        
       $mediaFile = $this->getProductMediaFile();
       
       $media = explode('.',basename($mediaFile));
       $result = ucwords(str_replace("-"," ",$media[0]));
       $result = ucwords(str_replace("_"," ",$result));
       return $result;
    } 

    public function getMediaFilePath()
    {        
       $mediaFile = $this->getProductMediaFile();      
       $mediaUrl  = $this->getUrl('pub/media/catalog/product/file');
       $result    = $mediaUrl.$mediaFile;
       return $result;
    } 

    public function getMediaSize()
    {      
        $extension = " KB";  
        $media = $this->getProductMediaFile();
        $dir = "catalog/product/file/";
        $filePath = $dir.$media;
        $fileSize = round($this->_file->getFileSize($filePath)/1024);
        if($fileSize>=1024){
            $fileSize = round(($fileSize/1024),1);
            $extension = " MB";  
        }
        
        $result = $fileSize.$extension;

        return $result;
    } 

    public function getProductVedioUrl()
    {        
        return $this->getCurrentProduct()->getVedioUrl();
    } 

    
    
}
