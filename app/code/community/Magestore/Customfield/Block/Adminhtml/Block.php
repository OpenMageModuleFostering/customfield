<?php
class Magestore_Customfield_Block_Adminhtml_Block extends Mage_Adminhtml_Block_Widget_Grid_Container
{
  public function __construct()
  {
    $this->_controller = 'adminhtml_block';
    $this->_blockGroup = 'customfield';
    $this->_headerText = Mage::helper('customfield')->__('Block Manager');
    $this->_addButtonLabel = Mage::helper('customfield')->__('Add Block');
    parent::__construct();
  }
}