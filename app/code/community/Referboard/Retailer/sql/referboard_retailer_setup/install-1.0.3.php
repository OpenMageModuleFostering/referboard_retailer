<?php
/**
 * Created by Smion Li.
 * User: opentop_smionli
 * Date: 2016/11/16
 * Time: 16:09
 */

/**
 * Referboard Retailer Data Installation Script
 * @author smion@referboard.com
 */


/* @var $installer Mage_Core_Model_Resource_Setup */
$installer = $this;

/**
 * Creating
 */

$table = $installer->getConnection()->newTable($installer->getTable('referboard_retailer/data'))
    ->addColumn('id',Varien_Db_Ddl_Table::TYPE_INTEGER, 10,
        array(
            'unsigned' => true,
            'identity' => true,
            'nullable' => false,
            'primary' => true,
        ), 'Entity Id')

    ->addColumn('type',Varien_Db_Ddl_Table::TYPE_VARCHAR, 20,
        array(
            'nullable' => false,
            'default' => 'order'
        ), 'Type')

    ->addColumn('value',Varien_Db_Ddl_Table::TYPE_VARCHAR, 255,
        array(
            'nullable' => false,
            'default' => ''
        ), 'Value')

    ->addColumn('json_data',Varien_Db_Ddl_Table::TYPE_TEXT, null,
        array(
            'nullable' => false,
        ), 'JSON Data')

    ->addColumn('created',Varien_Db_Ddl_Table::TYPE_DATETIME, null,
        array(
            'nullable' => true,
            'default' => null
        ), 'Creation Time')

    ->addColumn('modified',Varien_Db_Ddl_Table::TYPE_DATETIME, null,
        array(
            'nullable' => true,
            'default' => null
        ), 'Updated Time')

    ->addIndex(
        $installer->getIdxName($installer->getTable('referboard_retailer/data'),array('type'),Varien_Db_Adapter_Interface::INDEX_TYPE_INDEX),
        array('type'),array('type'=>Varien_Db_Adapter_Interface::INDEX_TYPE_INDEX))

    ->setComment('Referboard Retailer Item')
    ;

Mage::log("init this:".$installer->getTable('referboard_retailer/data'),null,'mylogfile.log',true);


if (!$installer->getConnection()->isTableExists($installer->getTable('referboard_retailer/data'))) {
    Mage::log("init this start:".$installer->getTable('referboard_retailer/data'),null,'mylogfile.log',true);

    $result = $installer->getConnection()->createTable($table);
    Mage::log("init this end:".$result,null,'mylogfile.log',true);

}