<?php

class Magestore_Customfield_Block_Adminhtml_Attribute_Edit_Tab_Customfield extends Mage_Adminhtml_Block_Widget_Form
{
   public function _prepareLayout()
    {
        parent::_prepareLayout();
      $form = new Varien_Data_Form();
      $this->setForm($form);
      $fieldset = $form->addFieldset('customfield_form', array('legend'=>Mage::helper('customfield')->__('Custom Fields')));
     
	$attributes = Mage::getSingleton("customfield/attribute")->getCollection();

	$product_id = Mage::registry('current_product')->getId();
	$attributevalues = Mage::getResourceSingleton("customfield/attributevalue")->getAttributeValues($product_id);
	
	
	
	$data = array();
	if($attributevalues)
	{
		foreach($attributevalues as $attributevalue)
		{			
			$data["customfield[". $attributevalue['attribute_code'] . "]"]= $attributevalue['value'];
		}
	}
	
	
	foreach($attributes as $attribute)
	{	  
		$type = $attribute->getType();
		
		$attribute_code = Mage::helper('customfield')->getCustomAttributeCode($attribute->getId());
		$attribute_code = "customfield[" . $attribute_code . "]";
		
		$note = "";
		if($type == 'file')
		{			
			if(isset($data[$attribute_code]))
			{	
				$note = $data[$attribute_code];
			}
		}
		
		$fieldset->addField($attribute_code, $type, array(
		  'label'     => Mage::helper('customfield')->__($attribute->getName()),
		  
		  'required'  => false,
		  'name'      => $attribute_code,
		  'note'      => $note,
	    ));
		
	}	
      

       $form->setValues($data);    
       $this->setForm($form);
      
  }
}