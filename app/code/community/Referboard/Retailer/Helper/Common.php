<?php
    /**
     * Created by Smion Li.
     * User: opentop_smionli
     * Date: 2016/11/16
     * Time: 15:03
     */
    require_once(Mage::getBaseDir('lib') . '/Referboard/Referboard_Plugin_Class.php');
    
    
    class Referboard_Retailer_Helper_Common extends Mage_Core_Helper_Abstract
    {
        
        public $api_key;
        public  $referboard;
        public function __construct()
        {
            $this->api_key =  Mage::getStoreConfig('referboard_retailer_options/section/api_key');
    
            if (!empty( $this->api_key)) {
                /**
                 * Only generate button when there is an api key
                 */
                $this->referboard = new Referboard_Plugin_Class($this->api_key);
            }
        }
    
        public function generateReferbutton($product)
        {
            
            if (isset($this->referboard) && isset($product)) {
    
                /**
                 * Firstly need to capture request data
                 */
    
                $referboard_params = $this->referboard->captureReferboardParams($_REQUEST,'cookie');
               
                if(!empty($referboard_params['rf_product']) && $referboard_params['buyer_history'] ==0) {
                    /**
                     * Try to get referboard params in request data, or
                     * If user still has a cookies period
                     */
                    $_SESSION['referboard'] = $referboard_params;
                }
                
                /**
                 * Only generate reerboard refer button when there is api key and product is available
                 */
                $price = !empty($product->getFinalPrice())?$product->getFinalPrice():$product->getPrice();
                
                $image_list = [];
    
                foreach ($product->getMediaGalleryImages() as $image) {
                    $image_list[] = $image->getUrl();
                }
                
                
                $data = [];
                $data['product_id'] = $product->getId();
                $data['product_title'] = $product->getName();
                $data['product_desc']  = $product->getDescription();
                $data['product_image'] = Mage::getModel('catalog/product_media_config')->getMediaUrl($product->getImage());;
                $data['product_image_list'] = $image_list;
                $data['product_price'] = $price;
                $data['product_price_type'] = Mage::app()->getStore()->getCurrentCurrencyCode();;
                $data['product_url'] = $product->getProductUrl();
                $data['product_retailer_id'] = $this->api_key;
                
               // return  $data;
                return $this->referboard->generateReferButtonCode($data,'full');
                
            }
        }
    
        /**
         * Home Page Tracking Code
         * @param array $data
         * @return bool|string false | output string
         */
        public function generateHomePageCode(array $data = [],$type='all'){
            
            if(isset($this->referboard))
            {
                return $this->referboard->generateHomePageCode([],'all');
            }else{
                return '';
            }
        }
        
    }