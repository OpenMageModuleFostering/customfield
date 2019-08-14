<?php
class Magestore_Customfield_IndexController extends Mage_Core_Controller_Front_Action
{
    public function indexAction()
    {
    	
    	/*
    	 * Load an object by id 
    	 * Request looking like:
    	 * http://site.com/customfield?id=15 
    	 *  or
    	 * http://site.com/customfield/id/15 	
    	 */
    	/* 
		$customfield_id = $this->getRequest()->getParam('id');

  		if($customfield_id != null && $customfield_id != '')	{
			$customfield = Mage::getModel('customfield/customfield')->load($customfield_id)->getData();
		} else {
			$customfield = null;
		}	
		*/
		
		 /*
    	 * If no param we load a the last created item
    	 */ 
    	/*
    	if($customfield == null) {
			$resource = Mage::getSingleton('core/resource');
			$read= $resource->getConnection('core_read');
			$customfieldTable = $resource->getTableName('customfield');
			
			$select = $read->select()
			   ->from($customfieldTable,array('customfield_id','title','content','status'))
			   ->where('status',1)
			   ->order('created_time DESC') ;
			   
			$customfield = $read->fetchRow($select);
		}
		Mage::register('customfield', $customfield);
		*/

			
		$this->loadLayout();     
		$this->renderLayout();
    }
}