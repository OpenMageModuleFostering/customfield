<?php

class Magestore_Customfield_Model_Mysql4_Attribute extends Mage_Core_Model_Mysql4_Abstract
{
    public function _construct()
    {    
        // Note that the customfield_id refers to the key field in your database table.
        $this->_init('customfield/attribute', 'id');
    }
}