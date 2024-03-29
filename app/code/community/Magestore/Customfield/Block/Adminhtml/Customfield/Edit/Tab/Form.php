<?php

class Magestore_Customfield_Block_Adminhtml_Customfield_Edit_Tab_Form extends Mage_Adminhtml_Block_Widget_Form
{
  protected function _prepareForm()
  {
      $form = new Varien_Data_Form();
      $this->setForm($form);
      $fieldset = $form->addFieldset('customfield_form', array('legend'=>Mage::helper('customfield')->__('Item information')));
     
      $fieldset->addField('title', 'text', array(
          'label'     => Mage::helper('customfield')->__('Title'),
          'class'     => 'required-entry',
          'required'  => true,
          'name'      => 'title',
      ));

      $fieldset->addField('filename', 'file', array(
          'label'     => Mage::helper('customfield')->__('File'),
          'required'  => false,
          'name'      => 'filename',
	  ));
		
      $fieldset->addField('status', 'select', array(
          'label'     => Mage::helper('customfield')->__('Status'),
          'name'      => 'status',
          'values'    => array(
              array(
                  'value'     => 1,
                  'label'     => Mage::helper('customfield')->__('Enabled'),
              ),

              array(
                  'value'     => 2,
                  'label'     => Mage::helper('customfield')->__('Disabled'),
              ),
          ),
      ));
     
      $fieldset->addField('content', 'editor', array(
          'name'      => 'content',
          'label'     => Mage::helper('customfield')->__('Content'),
          'title'     => Mage::helper('customfield')->__('Content'),
          'style'     => 'width:700px; height:500px;',
          'wysiwyg'   => false,
          'required'  => true,
      ));
     
      if ( Mage::getSingleton('adminhtml/session')->getCustomfieldData() )
      {
          $form->setValues(Mage::getSingleton('adminhtml/session')->getCustomfieldData());
          Mage::getSingleton('adminhtml/session')->setCustomfieldData(null);
      } elseif ( Mage::registry('customfield_data') ) {
          $form->setValues(Mage::registry('customfield_data')->getData());
      }
      return parent::_prepareForm();
  }
}