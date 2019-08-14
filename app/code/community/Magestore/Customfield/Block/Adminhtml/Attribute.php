<?php
class Magestore_Customfield_Block_Adminhtml_Attribute extends Mage_Adminhtml_Block_Widget_Grid_Container
{
  public function __construct()
  {
    $this->_controller = 'adminhtml_attribute';
    $this->_blockGroup = 'customfield';
    $this->_headerText = Mage::helper('customfield')->__('Attribute Manager');
    $this->_addButtonLabel = Mage::helper('customfield')->__('Add Attribute');
    parent::__construct();
  }
}