<?php
/**
 * Created by Smion Li.
 * User: opentop_smionli
 * Date: 2016/11/16
 * Time: 16:48
 */

/**
 * Class Referboard_Retailer_Model_Data
 * @author smion@referboard.com
 */
class Referboard_Retailer_Model_Data extends Mage_Core_Model_Abstract {

    /**
     * Define resource model
     */
    protected function  _construct()
    {
        $this->_init('referboard_retailer/data','id');
    }

    public function getTest(){
        $resource = $this->_getResource();
        echo get_class($resource);
    }

    /**
     * If object is new adds creation date
     * @return Referboard_Retailer_Model_Data
     */
    protected function _beforeSave()
    {
        parent::_beforeSave();

        if($this->isObjectNew()){
            $this->setData('created', date("Y-m-d H:i:s"));
        }

        $this->setData('modified', date("Y-m-d H:i:s"));
        return $this;
    }
}