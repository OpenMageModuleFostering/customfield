<?php

class Magestore_Customfield_Block_Adminhtml_Attribute_Edit extends Mage_Adminhtml_Block_Widget_Form_Container
{
    public function __construct()
    {
        parent::__construct();
                 
        $this->_objectId = 'id';
        $this->_blockGroup = 'customfield';
        $this->_controller = 'adminhtml_attribute';
        
        $this->_updateButton('save', 'label', Mage::helper('customfield')->__('Save Attribute'));
        $this->_updateButton('delete', 'label', Mage::helper('customfield')->__('Delete Attribute'));
		
        $this->_addButton('saveandcontinue', array(
            'label'     => Mage::helper('adminhtml')->__('Save And Continue Edit'),
            'onclick'   => 'saveAndContinueEdit()',
            'class'     => 'save',
        ), -100);

        $this->_formScripts[] = "
            function toggleEditor() {
                if (tinyMCE.getInstanceById('attribute_content') == null) {
                    tinyMCE.execCommand('mceAddControl', false, 'attribute_content');
                } else {
                    tinyMCE.execCommand('mceRemoveControl', false, 'attribute_content');
                }
            }

            function saveAndContinueEdit(){
                editForm.submit($('edit_form').action+'back/edit/');
            }
        ";
    }

    public function getHeaderText()
    {
        if( Mage::registry('attribute_data') && Mage::registry('attribute_data')->getId() ) {
            return Mage::helper('customfield')->__("Edit Attribute '%s'", $this->htmlEscape(Mage::registry('attribute_data')->getAttributeCode()));
        } else {
            return Mage::helper('customfield')->__('Add Attribute');
        }
    }
}