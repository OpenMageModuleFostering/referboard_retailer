<?php
/**
 * Created by Smion Li.
 * User: opentop_smionli
 * Date: 2016/11/16
 * Time: 17:54
 */

class Referboard_Retailer_Model_Resource_Data_Collection extends  Mage_Core_Model_Resource_Db_Collection_Abstract {
    public function _construct()
    {
        $this->_init('referboard_retailer/data','id');
    }
}