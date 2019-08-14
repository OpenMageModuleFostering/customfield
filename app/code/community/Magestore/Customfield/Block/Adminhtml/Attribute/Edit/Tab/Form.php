<?php

class Magestore_Customfield_Block_Adminhtml_Attribute_Edit_Tab_Form extends Mage_Adminhtml_Block_Widget_Form
{
  protected function _prepareForm()
  {
      $form = new Varien_Data_Form();
      $this->setForm($form);
      $fieldset = $form->addFieldset('attribute_form', array('legend'=>Mage::helper('customfield')->__('Attribute information')));
     
      
	 $fieldset->addField('name', 'text', array(
          'label'     => Mage::helper('customfield')->__('Title'),
          'class'     => 'required-entry',
          'required'  => true,
          'name'      => 'name',
      ));
      
	  $fieldset->addField('alias', 'text', array(
          'label'     => Mage::helper('customfield')->__('Alias'),
          'class'     => 'required-entry',
          'required'  => true,
          'name'      => 'alias',
      ));
	  
	  $fieldset->addField('type', 'select', array(
          'label'     => Mage::helper('customfield')->__('Type'),
          'name'      => 'type',
          'values'    => array(
              array(
                  'value'     => 'file',
                  'label'     => Mage::helper('customfield')->__('File'),
              ),

              array(
                  'value'     => 'text',
                  'label'     => Mage::helper('customfield')->__('Text'),
              ),
          ),
      ));
		
    
     
           
      if ( Mage::getSingleton('adminhtml/session')->getAttributeData() )
      {
          $form->setValues(Mage::getSingleton('adminhtml/session')->getAttributeData());
          Mage::getSingleton('adminhtml/session')->setAttributeData(null);
      } elseif ( Mage::registry('attribute_data') ) {
          $form->setValues(Mage::registry('attribute_data')->getData());
      }
      return parent::_prepareForm();
  }
}