<?php

class Magestore_Customfield_Model_Mysql4_Attributevalue extends Mage_Core_Model_Mysql4_Abstract
{
    public function _construct()
    {    
        // Note that the customfield_id refers to the key field in your database table.
        $this->_init('customfield/attributevalue', 'value_id');
    }
	
	public function getAttributeValueId($data)
	{
	
		$select = $this->_getReadAdapter()->select()
            ->from($this->getMainTable())
            ->where($this->getMainTable().'.entity_type_id=?', $data['entity_type_id'])
			->where($this->getMainTable().'.attribute_id=?', $data['attribute_id'])
			->where($this->getMainTable().'.entity_id=?', $data['entity_id']);
		
		$read = $this->_getReadAdapter();	
		$data = $read->fetchRow($select);	
		if($data)
		{
			return $data['value_id'];
		}
		return null;
	}	
	
	public function getAttributeValues($product_id)
	{
		$entity_type_id = Mage::helper('customfield')->getProductEntityTypeId();
		$eav_attribute_table = Mage::helper('customfield')->getTablePrefix() . "eav_attribute";
		$custom_attribute_table = Mage::helper('customfield')->getTablePrefix() . "customfield_attribute";
		
		$select = $this->_getReadAdapter()->select()
            ->from(array('eat'=>$this->getMainTable()))
			->join(array('ea'=>$eav_attribute_table),'eat.attribute_id=ea.attribute_id',array('attribute_code'))
			->join(array('ca'=>$custom_attribute_table),"ea.attribute_code=CONCAT('customfield_',ca.id)",array('type','alias'))
            ->where('eat.entity_type_id=?', $entity_type_id)
			
			->where("ea.attribute_code like 'customfield_%'")
			->where('eat.entity_id=?', $product_id);
		
		$read = $this->_getReadAdapter();	
		$data = $read->fetchAll($select);			
		return $data;
	}	
}