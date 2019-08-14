<?php
    require_once(Mage::getBaseDir('lib') . '/Referboard/Referboard_Plugin_Class.php');
class Referboard_Retailer_Model_Observer
{


    public function saveOrder($observer)
    {
    
        $order = $observer->getOrder();
    
        $session_data = isset($_SESSION['referboard'])?$_SESSION['referboard']:null;

        if(!empty($order) && !empty($session_data))
        {
            /**
             * Only save order details when there is an order, and referboard session
             */
    
            $order_id = $order->getIncrementId();
            
            $total_amount = $order->getBaseGrandTotal()-$order->getShippingAmount();
    
            $rf_postback_data = [
                'id'            => $session_data['rf_product'],
                'amount'        => $total_amount,
                'currency'      =>  Mage::getStoreConfig('referboard_retailer_options/section/price_currency'),
                'cid'           => $session_data['rf_user'],
                'rkey'          =>  Mage::getStoreConfig('referboard_retailer_options/section/api_key'),
                'email'         => $order->getCustomerEmail(),
                'buyer_ip'      => !empty($session_data['rf_buyer_ip'])?$session_data['rf_buyer_ip']:$_SERVER['REMOTE_ADDR'],
                'buyer_history' => 0,
                'tid'           => $order_id,
                'extra'         => 'freetext'
            ];
    
            $session_data_json = json_encode($rf_postback_data);
    
            $data_model = Mage::getModel("referboard_retailer/data");
            $data_model->load($order_id);
    
            if(!$data_model->getId()){
                $data_model = Mage::getModel("referboard_retailer/data");
                $data = array(
                    'id' => $order_id,
                    'json_data' => $session_data_json
                );
        
                $data_model->setData($data);
                $data_model->isObjectNew(true);
                $data_model->save();
            }else{
                $data = $data_model->getData();
            }
    
        }
    
        
    }
    
    
    /**
     *
     * Send order details to referboard for saving transaction sale
     * @param $observer
     */
    public function sendOrderToReferboard($observer)
    {
    
       $api_key =  Mage::getStoreConfig('referboard_retailer_options/section/api_key');
        
        if(!empty($api_key))
        {
            /**
             * Only if retailer has set up api key, and then we need to check referboard call back
             */
    
            /**
             * First need to get invoice details
             */
            $invoice = $observer->getEvent()->getInvoice();
            $order = $invoice->getOrder();
            $order_id = $order->getIncrementId();
            $data_model = Mage::getModel("referboard_retailer/data");
            $data_model->load($order_id);
    
            /**
             * Get saved order details from database
             */
            $order_data = $data_model->getData();
    
            /**
             * Delete saved data
             */
            $data_model->delete();
            if(!empty($order_data))
            {
                /**
                 * Only if we can find saved order details from database means this is the sales from referbaord
                 */
        
                $referboard = new Referboard_Plugin_Class($api_key);
                
                
                $referboard_data_json = $order_data['json_data'];
                $referboard_data = json_decode($referboard_data_json,true);
                $total_amount = $order->getBaseGrandTotal()-$order->getShippingAmount();
                $referboard_data['amount'] = $total_amount;
    
                $result = $referboard->sendTransactionData($referboard_data);
 
            }
        }
            
        
       
    
        
      //
    }
    
    
//    public function sendOrderToReferboard(Varien_Event_Observer $observer){
//        $block = $observer->getBlock();
//        $type = $block->getType();
//        if($type=='catalog/product_price'){
//
//        }
//    }

    public function test(){}
}