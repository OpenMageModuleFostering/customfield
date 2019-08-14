<?php

class Magestore_Customfield_Block_Adminhtml_Attribute_Edit_Tabs extends Mage_Adminhtml_Block_Widget_Tabs
{

  public function __construct()
  {
      parent::__construct();
      $this->setId('attribute_tabs');
      $this->setDestElementId('edit_form');
      $this->setTitle(Mage::helper('customfield')->__('Attribute Information'));
  }

  protected function _beforeToHtml()
  {
      $this->addTab('form_section', array(
          'label'     => Mage::helper('customfield')->__('Attribute Information'),
          'title'     => Mage::helper('customfield')->__('Attribute Information'),
          'content'   => $this->getLayout()->createBlock('customfield/adminhtml_attribute_edit_tab_form')->toHtml(),
      ));
     
      return parent::_beforeToHtml();
  }
}