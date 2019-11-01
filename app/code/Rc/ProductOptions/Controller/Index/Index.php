<?php
	/**
	 * Create Product Custom Options
	 *
	 * @category    Rohit Chauhan
	 * @package     Rc_ProductOptions
	 * @author      rohit.chauhan030@gmail.com
	 *
     */
    
    namespace Rc\ProductOptions\Controller\Index;

    use Magento\Framework\App\Action\Action;
    use Magento\Framework\App\Action\Context;
    use Magento\Framework\Controller\Result\JsonFactory; 
    use Magento\Framework\Pricing\Helper\Data;
    use Rc\ProductOptions\Block\Catalog\Category\Categories;

	class Index extends Action
	{   
        protected $resultJsonFactory;
        protected $_formatedPrice;
        protected $_categories;
        protected $_rcHelper;
        
        const FIXED_VALUE = 16.00;
        const MRT_TO_FT   = 3.281;
        const CM_TO_FT    = 30.48;
        const MM_TO_FT    = 304.8;
        const IN_TO_FT    = 12;
        
        const MTR_TO_INCH = 39.37;
        const CM_TO_INCH  = 2.54;
        const MM_TO_INCH  = 25.4;
        const FT_TO_INCH  = 12;

        const FLEX_CATEGORY_ID   = 4;
        const SAV_CATEGORY_ID    = 14; 
        const FABRIC_CATEGORY_ID = 17;
        const POSTER_CATEGORY_ID = 11;

        const FLEX_SIZE_IN_INCH             = 120;
        const SAV_SIZE_IN_INCH              = 48;
        const FABRIC_POSTER_SIZE_IN_INCH    = 60;
        
        const INC_NO = 1;


        public function __construct(
            Context $context,
            JsonFactory $resultJsonFactory,
            Data $formatedPrice,
            Categories $categories,
            \Rc\ProductOptions\Helper\Data $rcHelper
            ){
            $this->resultJsonFactory = $resultJsonFactory;
            $this->_formatedPrice = $formatedPrice;
            $this->_categories = $categories;
            $this->_rcHelper = $rcHelper;
            
            parent::__construct($context);
        }
        
        public function get_numeric($val) {
            if (is_numeric($val)):
                return $val + 0;
            endif;
        return 0;
        }
		
		public function execute()
		{
            $resultJson = $this->resultJsonFactory->create();
            $response   = Null;
            
            $P           = $this->getRequest()->getPost('productPrice');
            $formula  	 = $this->getRequest()->getPost('formula');	
            $optionPrice = $this->getRequest()->getPost('optionPrice');	
            $identifierA = $this->getRequest()->getPost('selectedIdentifierA');
            $identifierB = $this->getRequest()->getPost('selectedIdentifierB');
            $identifierC = $this->getRequest()->getPost('selectedIdentifierC');
            $identifierD = $this->getRequest()->getPost('selectedIdentifierD');
            $identifierE = $this->getRequest()->getPost('selectedIdentifierE');
            $identifierF = $this->getRequest()->getPost('selectedIdentifierF');	
            $identifierG = $this->getRequest()->getPost('selectedIdentifierG');
            $identifierH = $this->getRequest()->getPost('selectedIdentifierH');
            $identifierI = $this->getRequest()->getPost('selectedIdentifierI');
            $identifierJ = $this->getRequest()->getPost('selectedIdentifierJ');
            $identifierK = $this->getRequest()->getPost('selectedIdentifierK');
            $identifierL = $this->getRequest()->getPost('selectedIdentifierL');
            $identifierM = $this->getRequest()->getPost('selectedIdentifierM');
            $identifierN = $this->getRequest()->getPost('selectedIdentifierN');
            $identifierO = $this->getRequest()->getPost('selectedIdentifierO');

            $mesureType   = $this->getRequest()->getPost('mesureType');
            $mesureWidth  = $this->getRequest()->getPost('mesureWidth');
            $mesureHeight = $this->getRequest()->getPost('mesureHeight');
            $rushOrder    = $this->getRequest()->getPost('rush');
            $mounting     = $this->getRequest()->getPost('mounting');
            $productId    = $this->getRequest()->getPost('productId');  

            $finalValue = $this->getCalculatedSize($mesureType,$mesureWidth,$mesureHeight);

            if($optionPrice):
                $explode  = explode('_',$optionPrice);

                if($rushOrder=="yes"):
                    $rushValue = $this->getConvertedValuesToFt($mesureType,$mesureWidth,$mesureHeight,$productId,$P,$rushOrder);
                else:  
                    if($explode[0]=="RO"){
                        $rushValue = $this->getConvertedValuesToFt($mesureType,$mesureWidth,$mesureHeight,$productId,$P,$rushOrder);
                    }else{
                        $rushValue = 0;
                    }
                endif;

                if($mounting):
                    $mountPrice = $this->getMountPrice($mesureType,$mesureWidth,$mesureHeight,$mounting);
                else:  
                    if($explode[0]=="MP" || $explode[0]=="ME"){
                        $mountPrice = $this->getMountPrice($mesureType,$mesureWidth,$mesureHeight,$mounting);
                    }else{
                        $mountPrice = 0; 
                    }
                endif;

                if($identifierA):
                    $A = $identifierA;
                else:  
                    if($explode[0]=="A"){
                        $A = 16.00;
                    }else{
                        $A = 0;
                    }
                endif;

                if($identifierB) :
                    $B = $identifierB;
                else:
                    if($explode[0]=="B"){
                        $B = $explode[1];
                    }else{
                        $B = 0; 
                    }
                endif;

                if($identifierC):
                    $C = $identifierC;
                else:
                    if($explode[0]=="C"){
                        $C = $explode[1];
                    }else{
                        $C = 0;
                    }
                endif;

                if($identifierD):
                    $D = $identifierD;
                else:
                    if($explode[0]=="D"){
                        $D = $explode[1];
                    }else{
                        $D = 0;  
                    }
                endif;

                if($identifierE):
                    $E = $identifierE;
                else:
                    if($explode[0]=="E"){
                        $E = $explode[1];
                    }else{
                        $E = 0; 
                    }
                endif;
                if($identifierF):
                    $F = $identifierF;
                else:
                    if($explode[0]=="F"){
                        $F = $explode[1];
                    }else{
                        $F = 0;
                    }
                endif;

                if($identifierG):
                    $G = $identifierG;
                else:
                    if($explode[0]=="G"){
                        $G = $explode[1];
                    }else{
                        $G = 0;
                    }
                endif; 
                
                if($identifierH):
                    $H = $identifierH;
                else:
                    if($explode[0]=="H"){
                        $H = $explode[1];
                    }else{
                        $H = 0;
                    }
                endif;

                if($identifierI):
                    $I = $identifierI;
                else:
                    if($explode[0]=="I"){
                        $I = $explode[1];
                    }else{
                        $I = 0;
                    }
                endif;
                if($identifierJ):
                    $J = $identifierJ;
                else:
                    if($explode[0]=="J"){
                        $J = $explode[1];
                    }else{
                        $J = 0;
                    }
                endif;

                if($identifierK):
                    $K = $identifierK;
                else:
                    if($explode[0]=="K"){
                        $K = $explode[1];
                    }else{
                        $K = 0;
                    }
                endif;

                if($identifierL):
                    $L = $identifierL;
                else:
                    if($explode[0]=="L"){
                        $L = $explode[1];
                    }else{
                        $L = 0;
                    }
                endif;

                if($identifierM):
                    $M = $identifierM;
                else:
                    if($explode[0]=="M"){
                        $M = $explode[1];
                    }else{
                        $M = 0;
                    }
                endif;

                if($identifierN):
                    $N = $identifierN;
                else:
                    if($explode[0]=="N"){
                        $N = $explode[1];
                    }else{
                        $N = 0;
                    }
                endif;

                if($identifierO):
                    $O = $identifierO;
                else:
                    if($explode[0]=="O"){
                        $O = $explode[1];
                    }else{
                        $O = 0;
                    }
                endif;

                if($mesureType && $mesureWidth && $mesureHeight):
                        $A  = $finalValue;
                endif;

                try{
                    $value = str_split($formula);
                    $formulaValue = array();
                    foreach($value as $_value) {
                        switch($_value){
                            case 'P':
                                $formulaValue[]= $P;
                                break;
                            case 'A':
                                $formulaValue[]= $A;
                                break;
                            case 'B':
                                $formulaValue[]= $B;
                                break;
                            case 'C':
                                $formulaValue[]= $C;
                                break;
                            case 'D':
                                $formulaValue[]= $D;
                                break;
                            case 'E':
                                $formulaValue[]= $E;
                                break;
                            case 'F':
                                $formulaValue[]= $F;
                                break;
                            case 'G':
                                $formulaValue[]= $G;
                                break;
                            case 'H':
                                $formulaValue[]= $H;
                                break;
                            case 'I':
                                $formulaValue[]= $I;
                                break;
                            case 'J':
                                $formulaValue[]= $J;
                                break;
                            case 'K':
                                $formulaValue[]= $K;
                            case 'L':
                                $formulaValue[]= $L;
                                break;
                            case 'M':
                                $formulaValue[]= $M;
                                break;
                            case 'N':
                                $formulaValue[]= $N;
                                break;
                            case 'O':
                                $formulaValue[]= $O;
                                break;
                            default:
                            $formulaValue[]= $_value;
                        }
                    }

                    $string_version = implode('', $formulaValue);
                    $calculatedPrice = eval('return '.$string_version.';');
                    $calculatedPrice = $calculatedPrice+$rushValue+$mountPrice;
                    $finalPrice = $this->_formatedPrice->currency($calculatedPrice, true, false);

                    $response['status_code']    =  '200';
                    $response['result']         =  'success';
                    $response['mi']             =  $mountPrice;
                    $response['ro']             =  $rushValue;
                    $response['identifier']     =  $explode[0];
                    $response['identifierA']    =  $A;
                    $response['identifierB']    =  $B;
                    $response['identifierC']    =  $C;
                    $response['identifierD']    =  $D;
                    $response['identifierE']    =  $E;
                    $response['identifierF']    =  $F;
                    $response['identifierG']    =  $G;
                    $response['identifierH']    =  $H;
                    $response['identifierI']    =  $I;
                    $response['identifierJ']    =  $J;
                    $response['identifierK']    =  $L;
                    $response['identifierM']    =  $M;
                    $response['identifierN']    =  $N;
                    $response['identifierO']    =  $O;
                    $response['finalPrice']     =  $finalPrice;
                    $response['intPrice']       =  $calculatedPrice;

            }catch(\Exception $e){
                $response = array('result'=>'Failed','status code'=>500,'message'=>$e->getMessage());
            }

        endif;

            if($response):
                $resultJson->setData($response);
                return $resultJson;
            else:
                $response = "empty response";
                $resultJson->setData($response);
                return $resultJson;
             endif;
        }

    public function getCalculatedSize($mesureType,$mesureWidth,$mesureHeight){
            //if($mesureType && $mesureWidth && $mesureHeight):
                $finalValue = 0;
                if($mesureType=="meters"){
                    $footWidth  = $this->get_numeric(floatval($mesureWidth*self::MRT_TO_FT)); 
                    $footHeight = $this->get_numeric(floatval($mesureHeight*self::MRT_TO_FT));
                                
                    if(is_float($footWidth)){
                        $footWidth = sprintf("%.2f", round($footWidth,2));
                        $splitedWidth = explode('.',$footWidth);
                        if($splitedWidth[1]>0 && $splitedWidth[1]<=6 || ($splitedWidth[1]>12 && $splitedWidth[1]<=50)):
                                $dotWidth = 0.5;
                        elseif(($splitedWidth[1]>6 && $splitedWidth[1]<=12) || ($splitedWidth[1]>50)):
                                $dotWidth = 1;
                            else:
                                $dotWidth = 0.00;
                            endif;
                        $finalWidth=$splitedWidth[0]+$dotWidth;
                    }else{
                        $finalWidth=$footWidth;
                    }   
                    if(is_float($footHeight)){
                        $footHeight = sprintf("%.2f", round($footHeight,2));
                        $splitedHeight = explode('.',$footHeight);
                        if(($splitedHeight[1]>0 && $splitedHeight[1]<=6) || ($splitedHeight[1]>12 && $splitedHeight[1]<=50)):
                            $dotHeight = 0.5;
                        elseif(($splitedHeight[1]>6 && $splitedHeight[1]<=12) || ($splitedHeight[1]>50)):
                                $dotHeight = 1;
                        else:
                            $dotHeight = 0.0;
                        endif;
                        
                        $finalHeight=$splitedHeight[0]+$dotHeight;
                     }else{
                         $finalHeight= $footHeight;
                     }
                     
                    $sqFoot =  $finalWidth*$finalHeight;
                    if($sqFoot>self::FIXED_VALUE)
                    {
                    $finalValue = $sqFoot;
                    }else{
                        $finalValue = self::FIXED_VALUE;
                    }
                }
                if($mesureType=="cm"){
                    $footWidth  = $mesureWidth/self::CM_TO_FT; 
                    $footHeight = $mesureHeight/self::CM_TO_FT;
                    if(!is_float($this->get_numeric($footWidth))){
                        $footWidth = sprintf("%.2f", round($footWidth,2));
                    }
                    $splitedWidth = explode('.',$footWidth);
                        if($splitedWidth[1]>0 && $splitedWidth[1]<=6 || ($splitedWidth[1]>12 && $splitedWidth[1]<=50)):
                                $dotWidth = 0.5;
                        elseif(($splitedWidth[1]>6 && $splitedWidth[1]<=12) || ($splitedWidth[1]>50)):
                                $dotWidth = 1;
                            else:
                                $dotWidth = 0.00;
                            endif;
                        $finalWidth=$splitedWidth[0]+$dotWidth;
                        
                        if(!is_float($this->get_numeric($footHeight))){
                        $footHeight = sprintf("%.2f", round($footHeight,2));
                        }
                        
                        $splitedHeight = explode('.',$footHeight);
                        if(($splitedHeight[1]>0 && $splitedHeight[1]<=6) || ($splitedHeight[1]>12 && $splitedHeight[1]<=50)):
                            $dotHeight = 0.5;
                        elseif(($splitedHeight[1]>6 && $splitedHeight[1]<=12) || ($splitedHeight[1]>50)):
                                $dotHeight = 1;
                        else:
                            $dotHeight = 0.0;
                        endif;
                        
                    $finalHeight=$splitedHeight[0]+$dotHeight;
                    
                    $sqFoot =  $finalWidth*$finalHeight;

                    if($sqFoot>self::FIXED_VALUE)
                    {
                    $finalValue = $sqFoot;
                    }else{
                        $finalValue = self::FIXED_VALUE;
                    }
                }

                if($mesureType=="mm"){
                    $footWidth  = $mesureWidth/self::MM_TO_FT; 
                    $footHeight = $mesureHeight/self::MM_TO_FT;
                    if(!is_float($this->get_numeric($footWidth))){
                        $footWidth = sprintf("%.2f", round($footWidth,2));
                    }
                    $splitedWidth = explode('.',$footWidth);
                        if($splitedWidth[1]>0 && $splitedWidth[1]<=6 || ($splitedWidth[1]>12 && $splitedWidth[1]<=50)):
                                $dotWidth = 0.5;
                        elseif(($splitedWidth[1]>6 && $splitedWidth[1]<=12) || ($splitedWidth[1]>50)):
                                $dotWidth = 1;
                            else:
                                $dotWidth = 0.00;
                            endif;
                        $finalWidth=$splitedWidth[0]+$dotWidth;
                        
                        if(!is_float($this->get_numeric($footHeight))){
                        $footHeight = sprintf("%.2f", round($footHeight,2));
                        }
                        
                        $splitedHeight = explode('.',$footHeight);
                        if(($splitedHeight[1]>0 && $splitedHeight[1]<=6) || ($splitedHeight[1]>12 && $splitedHeight[1]<=50)):
                            $dotHeight = 0.5;
                        elseif(($splitedHeight[1]>6 && $splitedHeight[1]<=12) || ($splitedHeight[1]>50)):
                                $dotHeight = 1;
                        else:
                            $dotHeight = 0.0;
                        endif;
                        $finalHeight=$splitedHeight[0]+$dotHeight;
                    
                    $sqFoot =  $finalWidth*$finalHeight;
                    if($sqFoot>self::FIXED_VALUE)
                    {
                    $finalValue = $sqFoot;
                    }else{
                        $finalValue = self::FIXED_VALUE;
                    }
                }

                if($mesureType=="in"){
                    $footWidth  = $this->get_numeric(floatval($mesureWidth/self::IN_TO_FT)); 
                    $footHeight = $this->get_numeric(floatval($mesureHeight/self::IN_TO_FT));
                    if(is_float($footWidth)){
                        $footWidth = sprintf("%.2f", round($footWidth,2));
                        $splitedWidth = explode('.',$footWidth);
                        if($splitedWidth[1]>0 && $splitedWidth[1]<=6 || ($splitedWidth[1]>12 && $splitedWidth[1]<=50)):
                                $dotWidth = 0.5;
                        elseif(($splitedWidth[1]>6 && $splitedWidth[1]<=12) || ($splitedWidth[1]>50)):
                                $dotWidth = 1;
                            else:
                                $dotWidth = 0.00;
                            endif;
                        $finalWidth=$splitedWidth[0]+$dotWidth;
                    }else{
                        $finalWidth=$footWidth;
                    }   
                    if(is_float($footHeight)){
                        $footHeight = sprintf("%.2f", round($footHeight,2));
                        $splitedHeight = explode('.',$footHeight);
                        if(($splitedHeight[1]>0 && $splitedHeight[1]<=6) || ($splitedHeight[1]>12 && $splitedHeight[1]<=50)):
                            $dotHeight = 0.5;
                        elseif(($splitedHeight[1]>6 && $splitedHeight[1]<=12) || ($splitedHeight[1]>50)):
                                $dotHeight = 1;
                        else:
                            $dotHeight = 0.0;
                        endif;
                        
                        $finalHeight=$splitedHeight[0]+$dotHeight;
                     }else{
                         $finalHeight= $footHeight;
                     }
                        
                    $sqFoot =  $finalWidth*$finalHeight;
                    if($sqFoot>self::FIXED_VALUE)
                    {
                    $finalValue = $sqFoot;
                    }else{
                        $finalValue = self::FIXED_VALUE;
                    }
                }

                if($mesureType=="ft"){
                    
                        if(!is_float($this->get_numeric($mesureWidth))){
                            $mesureWidth = sprintf("%.2f", round($mesureWidth,2));
                        }

                        $splitedWidth = explode('.',$mesureWidth);
    
                            if($splitedWidth[1]>0 && $splitedWidth[1]<=6 || ($splitedWidth[1]>12 && $splitedWidth[1]<=50)):
                                    $dotWidth = 0.5;
                            elseif(($splitedWidth[1]>6 && $splitedWidth[1]<=12) || ($splitedWidth[1]>50)):
                                    $dotWidth = 1;
                            else:
                                $dotWidth = 0.0;
                            endif;
                            $finalWidth=$splitedWidth[0]+$dotWidth;                   
                    
                    if(!is_float($this->get_numeric($mesureHeight))){
                            $mesureHeight = sprintf("%.2f", round($mesureHeight,2));
                        }
                        $splitedHeight = explode('.',$mesureHeight);

                        if(($splitedHeight[1]>0 && $splitedHeight[1]<=6) || ($splitedHeight[1]>12 && $splitedHeight[1]<=50)):
                            $dotHeight = 0.5;
                        elseif(($splitedHeight[1]>6 && $splitedHeight[1]<=12) || ($splitedHeight[1]>50)):
                                $dotHeight = 1;
                        else:
                            $dotHeight = 0.0;
                        endif;
                    $finalHeight=$splitedHeight[0]+$dotHeight;
                    
                    $sqFoot =  $finalWidth*$finalHeight;
                    if($sqFoot>self::FIXED_VALUE)
                    {
                    $finalValue = $sqFoot;
                    }else{
                        $finalValue = self::FIXED_VALUE;
                    }
                }
            return $finalValue;
            //endif;           
        }

        public function getCalculatedRushOrderSize($productId){
            $_product    = $this->_categories->getProductById($productId);
            $categoryIds = $_product->getCategoryIds();
            $shetSize=0;
            foreach($categoryIds as $categoryId):
                $shetSize = $this->_rcHelper->getRushOrderSheetSize($categoryId);
                if($shetSize>0) 
				 break;
            endforeach;
            /*if(in_array(self::FLEX_CATEGORY_ID,$categoryIds)){
                $result = self::FLEX_SIZE_IN_INCH;
            }
            if(in_array(self::SAV_CATEGORY_ID,$categoryIds)){
                $result = self::SAV_SIZE_IN_INCH;
            }
            if(in_array(self::FABRIC_CATEGORY_ID,$categoryIds)){
                $result = self::FABRIC_POSTER_SIZE_IN_INCH;
            }
            if(in_array(self::POSTER_CATEGORY_ID,$categoryIds)){
                $result = self::FABRIC_POSTER_SIZE_IN_INCH;
            }*/
            return $shetSize;
        }

        public function getConvertedValuesToFt($mesureType,$mesureWidth,$mesureHeight,$productId,$P,$rushOrder){
            $result=0;
                if($rushOrder=="yes" && $mesureWidth && $mesureHeight):
                    $sheetSize = $this->getCalculatedRushOrderSize($productId);
                    $finalValue = 0;
                        if($mesureType=="meters"){
                            $footWidth  = ($mesureWidth*self::MTR_TO_INCH); 
                            $footHeight = ($mesureHeight*self::MTR_TO_INCH); 
                        }
                        if($mesureType=="cm"){
                            $footWidth  = $mesureWidth/self::CM_TO_INCH; 
                            $footHeight = $mesureHeight/self::CM_TO_INCH;
                        }

                        if($mesureType=="mm"){
                            $footWidth  = $mesureWidth/self::MM_TO_INCH; 
                            $footHeight = $mesureHeight/self::MM_TO_INCH;
                        }

                        if($mesureType=="in"){
                            $footWidth  = $mesureWidth; 
                            $footHeight = $mesureHeight;
                        }

                        if($mesureType=="ft"){
                            if(is_float($this->get_numeric($mesureWidth))){
                                $splitedWidth = explode('.',$mesureWidth);
                                $foot         = $splitedWidth[0]*self::FT_TO_INCH;
                                $inch         = $splitedWidth[1];
                                $footWidth    = $foot+$inch;
                            }else{
                               $footWidth = $mesureWidth*self::FT_TO_INCH; 
                            }
                            if(is_float($this->get_numeric($mesureHeight))){
                                $splitedHeight = explode('.',$mesureHeight);
                                $foot          = $splitedHeight[0]*self::FT_TO_INCH;
                                $inch          = $splitedHeight[1];
                                $footHeight    = $foot+$inch;
                            }else{
                               $footHeight = $mesureHeight*self::FT_TO_INCH; 
                            }
                        }
                        if($sheetSize>0):
                                $shetSizeFinal = $this->getDividient($footWidth,$sheetSize);
                                if($shetSizeFinal>0):
                                    $finalValue = (($shetSizeFinal-$footWidth)*$footHeight)/(self::FT_TO_INCH*self::FT_TO_INCH);
                                    $result = $finalValue*$P;
                                endif;
                        endif;
                    endif;
            return $result;

        }

        public function getDividient($footWidth,$sheetSize){
            $result = 0;
            if($footWidth>$sheetSize):
                $quotient = intdiv($footWidth, $sheetSize);
                $reminder = (int)fmod($footWidth,$sheetSize); // Output 1 - 2 - 1.5 
                    if($reminder>0):
                        $count    = $quotient+self::INC_NO;
                        $result   = $sheetSize*$count;
                    endif;
            else:
                $result  = $sheetSize;
            endif;
            
            return $result;
        }

        public function getMountPrice($mesureType,$mesureWidth,$mesureHeight,$mounting){
            $result=0;
                if($mounting && $mesureWidth && $mesureHeight):
                    if($mesureType=="meters"){
                        $footWidth  = ($mesureWidth*self::MTR_TO_FT); 
                        $footHeight = ($mesureHeight*self::MTR_TO_FT); 
                    }
                    if($mesureType=="cm"){
                        $footWidth  = ($mesureWidth/self::CM_TO_FT); 
                        $footHeight = ($mesureHeight/self::CM_TO_FT);
                    }

                    if($mesureType=="mm"){
                        $footWidth  = ($mesureWidth/self::MM_TO_FT); 
                        $footHeight = ($mesureHeight/self::MM_TO_FT);
                    }

                    if($mesureType=="in"){
                        $footWidth  = ($mesureWidth/self::IN_TO_FT); 
                        $footHeight = ($mesureHeight/self::IN_TO_FT);
                    }

                    if($mesureType=="ft"){
                        $footWidth  = $mesureWidth; 
                        $footHeight = $mesureHeight;
                    }
                    
                    $mounting = explode('_',$mounting);
                    $dataFormula = $mounting[0];
                    $dataMount   = $mounting[1];
                    $dataPrice   = $mounting[2];

                    /****ME for Eyelet***/

                    if($dataFormula=="ME"):
                        if($dataMount=="t"){
                            $result = (int) ($footWidth/2)*$dataPrice;
                        }
                        if($dataMount=="tb"){
                            $result = (int) ($footWidth/2)*$dataPrice*2;
                        }
                        if($dataMount=="l" || $dataMount=="r"){
                            $result = (int) ($footHeight/2)*$dataPrice;
                        }
                        if($dataMount=="lr"){
                            $result = (int) ($footHeight/2)*$dataPrice*2;
                        }
                    endif;

                    /****MP for Pole Pocket***/

                    if($dataFormula=="MP"):
                        if($dataMount=="t"){
                            $result = (int) ($footWidth*$dataPrice);
                        }
                        if($dataMount=="tb"){
                            $result = (int) ($footWidth*$dataPrice*2);
                        }
                        if($dataMount=="l" || $dataMount=="r" || $dataMount=="lr"){
                            $result = (int) ($footHeight*$dataPrice*2);
                        }
                    endif;                                     
                endif;
            return $result; 
        }

}