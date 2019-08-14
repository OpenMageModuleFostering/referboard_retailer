<?php
/**
 * Created by Smion Li.
 * User: opentop_smionli
 * Date: 2016/11/16
 * Time: 16:55
 */

class Referboard_Retailer_Model_Resource_Data extends Mage_Core_Model_Resource_Db_Abstract {

    /**
     * Init
     */
    protected function _construct()
    {
        $this->_init('referboard_retailer/data','id');
        $this->_isPkAutoIncrement = false;
    }
}