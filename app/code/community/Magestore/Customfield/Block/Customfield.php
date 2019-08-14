<?php
class Magestore_Customfield_Block_Customfield extends Mage_Core_Block_Template
{
	public function _prepareLayout()
    {
		return parent::_prepareLayout();
    }
    
     public function getCustomBlockHtml()
	 {
		$product_id = Mage::getSingleton('catalog/session')->getLastViewedProductId();
		
		$attributeValues = Mage::getResourceSingleton("customfield/attributevalue")->getAttributeValues($product_id);
						
		$block = Mage::getSingleton("customfield/block")->load(1);
		$block_content = $block->getContent();
		
		if($attributeValues)
		{
			foreach($attributeValues as $attributeValue)
			{
				$value = $attributeValue['value'];
				$alias = $attributeValue['alias'];	
				$type = $attributeValue['type'];	
				$value = $this->getElementHtml($value,$type);
				$block_content = str_replace("{".$alias."}",$value,$block_content);				
			}
			$block_content = preg_replace("/{.*}/", "", $block_content );
		}
		else
		{
			$block_content = "";
		}
		
		
		
		
		return $block_content;
	 }
	 
	 public function getElementHtml($value,$type)
	 {
		
		$html ="";
		switch($type)
		{
			case 'text':
				$html =  $value;
			break;			
			case 'file':
				
				$html = "<a target='_blank' href='". Mage::getBaseUrl("media") . "/catalog/customfield/" .$value ."'>" . $value . "</a>";
			break;
		}
		
		return $html;
	 }
	 
	
}