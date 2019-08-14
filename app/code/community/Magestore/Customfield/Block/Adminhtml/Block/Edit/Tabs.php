<?php

class Magestore_Customfield_Block_Adminhtml_Block_Edit_Tabs extends Mage_Adminhtml_Block_Widget_Tabs
{

  public function __construct()
  {
      parent::__construct();
      $this->setId('block_tabs');
      $this->setDestElementId('edit_form');
      $this->setTitle(Mage::helper('customfield')->__('Block Information'));
  }

  protected function _beforeToHtml()
  {
      $this->addTab('form_section', array(
          'label'     => Mage::helper('customfield')->__('Block Information'),
          'title'     => Mage::helper('customfield')->__('Block Information'),
          'content'   => $this->getLayout()->createBlock('customfield/adminhtml_block_edit_tab_form')->toHtml(),
      ));
     
      return parent::_beforeToHtml();
  }
}