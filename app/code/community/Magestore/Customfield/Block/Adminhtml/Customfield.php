<?php
class Magestore_Customfield_Block_Adminhtml_Customfield extends Mage_Adminhtml_Block_Widget_Grid_Container
{
  public function __construct()
  {
    $this->_controller = 'adminhtml_customfield';
    $this->_blockGroup = 'customfield';
    $this->_headerText = Mage::helper('customfield')->__('Item Manager');
    $this->_addButtonLabel = Mage::helper('customfield')->__('Add Item');
    parent::__construct();
  }
}