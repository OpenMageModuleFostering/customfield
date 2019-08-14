<?php

class Magestore_Customfield_Block_Adminhtml_Block_Edit_Tab_Form extends Mage_Adminhtml_Block_Widget_Form
{
  protected function _prepareForm()
  {
      $form = new Varien_Data_Form();
      $this->setForm($form);
      $fieldset = $form->addFieldset('block_form', array('legend'=>Mage::helper('customfield')->__('Block information')));
     
      $fieldset->addField('content', 'editor', array(
          'name'      => 'content',
          'label'     => Mage::helper('customfield')->__('Content'),
          'title'     => Mage::helper('customfield')->__('Content'),
          'style'     => 'width:700px; height:500px;',
          'wysiwyg'   => false,
          'required'  => true,
      ));
     
      if ( Mage::getSingleton('adminhtml/session')->getBlockData() )
      {
          $form->setValues(Mage::getSingleton('adminhtml/session')->getBlockData());
          Mage::getSingleton('adminhtml/session')->setBlockData(null);
      } elseif ( Mage::registry('block_data') ) {
          $form->setValues(Mage::registry('block_data')->getData());
      }
      return parent::_prepareForm();
  }
}