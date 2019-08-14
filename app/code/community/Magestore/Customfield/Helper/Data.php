<?php

class Magestore_Customfield_Helper_Data extends Mage_Core_Helper_Abstract
{
	public static function getBlockOptions()
	{
		$options = array();
		$collection = Mage::getModel('customfield/block')->getCollection();	
		foreach($collection as $block)
		{
			$options[$block->getId()] = $block->getName();
		}
		return $options;
	}
	
	public static function getBlockOptions2()
	{
		$options = array();
		$collection = Mage::getModel('customfield/block')->getCollection();	
		foreach($collection as $block)
		{
			$temp = array();
			$temp['label'] =  $block->getName();
			$temp['value'] =  $block->getId();	
			$options[] = $temp;		
		}
		return $options;
	}
	
	public static function getCustomAttributeCode($custom_attribute_id)
	{
		return "customfield_".$custom_attribute_id;
	}
	
	public function getProductEntityTypeId()
	{
		//get entity_type_id
		$entity_type = Mage::getSingleton("eav/entity_type")->loadByCode("catalog_product");
		$entity_type_id = $entity_type->getId();
		return 	$entity_type_id;
	}
	
	public function getAttributeId($attribute_code)
	{
		$attribute = Mage::getSingleton("eav/entity_attribute")->load($attribute_code,"attribute_code");
		return $attribute->getId();
	}
	
	public function getTablePrefix()
	{
		$tableName = Mage::getResourceModel('customfield/block')->getTable('block');	
		
		$prefix = str_replace('customfield_block','',$tableName);
		
		return $prefix;
	}
	
	public function upload_file($attibute_name)
	{
		
		//$new_file_name = $category_name.$this->getFileExtension($attibute_name);
		
		$path = Mage::getBaseDir('media') . DS . 'catalog' . DS . 'customfield' . DS;
	
		if(!is_dir($path))
		{
			mkdir($path);
			chmod($path,0777);
		}
				
		
        try {
            $uploader = new Varien_File_Uploader($attibute_name);
            //$uploader->setAllowedExtensions(array('jpg','jpeg','gif','png'));
            $uploader->setAllowRenameFiles(false);
            $uploader->save($path);

			$uploaded_name = $uploader->getUploadedFileName();
            
			return $uploaded_name;
        } catch (Exception $e) {
            
            
        }		
	}
}