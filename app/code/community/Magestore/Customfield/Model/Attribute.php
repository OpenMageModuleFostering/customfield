<?php

class Magestore_Customfield_Model_Attribute extends Mage_Core_Model_Abstract
{
    public function _construct()
    {
        parent::_construct();
        $this->_init('customfield/attribute');
    }
	
	public function createProductAttribute()
	{
		try
		{
			//get entity_type_id
			
			$entity_type_id = Mage::helper('customfield')->getProductEntityTypeId();


			$attribute = Mage::getModel("eav/entity_attribute");

			//create a sample attribute
			$data = array();

			//catcss_bgcolor
			$data['id'] = null;
			$data['entity_type_id'] = $entity_type_id;
			$data['attribute_code'] = Mage::helper('customfield')->getCustomAttributeCode($this->getId());
			$data['backend_type'] = "text";
			$data['frontend_input'] = "text";
						
			$attribute->setData($data);
			$attribute->save();	
			
		}
		catch (Mage_Core_Exception $e) {
            $this->_getSession()->addError($e->getMessage());
        }
	}
	
	public function deleteAttributeCode()
	{
		try
		{
			//get entity_type_id
			
			$entity_type_id = Mage::helper('customfield')->getProductEntityTypeId();

			$attribute_code = Mage::helper('customfield')->getCustomAttributeCode($this->getId());
			$attribute = Mage::getModel("eav/entity_attribute")->load($attribute_code,"attribute_code");
			$attribute->delete();
			//create a sample attribute
			$data = array();
		}
		catch (Mage_Core_Exception $e) {
            $this->_getSession()->addError($e->getMessage());
        }
		
	}
	

	public function save_product_attribute($observer)
	{
		
		$observer_data = $observer->getData();
		$request = $observer_data['request'];
		$data = $request->getPost('customfield');
		$product = $observer_data['product'];
		
		$product_id = $product->getId();
		if(!$product_id)
		{
			return;			
		}
		
		$customattributes = Mage::getModel("customfield/attribute")->getCollection();
		$entity_type_id = Mage::helper('customfield')->getProductEntityTypeId();
		foreach($customattributes as $customattribute)
		{
			$attribute_code = Mage::helper('customfield')->getCustomAttributeCode($customattribute->getId());
			$attribute_id = Mage::helper('customfield')->getAttributeId($attribute_code);
			$attribute_type = $customattribute->getType();
			
			$value_id = Mage::getResourceSingleton("customfield/attributevalue")->getAttributeValueId(array('entity_type_id'=>$entity_type_id,'entity_id'=>$product_id,'attribute_id'=>$attribute_id));
			$attributevalue = Mage::getSingleton("customfield/attributevalue")->load($value_id);
			
			//set data
			$attributevalue->setData("entity_type_id",$entity_type_id);
			$attributevalue->setData("attribute_id",$attribute_id);		
			$attributevalue->setData("entity_id",$product_id);
			
			switch($attribute_type)
			{
				case 'text':
					$value = $data[$attribute_code];
					$attributevalue->setData("value",$value);	
					break;
				case 'file':
					$value = Mage::helper('customfield')->upload_file("customfield[" . $attribute_code."]");
					if($value)
						$attributevalue->setData("value",$value);
					break;
			}
						
			$attributevalue->save();
		}
	}
}