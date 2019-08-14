<?php

class Magestore_Customfield_Block_Adminhtml_Customfield_Edit extends Mage_Adminhtml_Block_Widget_Form_Container
{
    public function __construct()
    {
        parent::__construct();
                 
        $this->_objectId = 'id';
        $this->_blockGroup = 'customfield';
        $this->_controller = 'adminhtml_customfield';
        
        $this->_updateButton('save', 'label', Mage::helper('customfield')->__('Save Item'));
        $this->_updateButton('delete', 'label', Mage::helper('customfield')->__('Delete Item'));
		
        $this->_addButton('saveandcontinue', array(
            'label'     => Mage::helper('adminhtml')->__('Save And Continue Edit'),
            'onclick'   => 'saveAndContinueEdit()',
            'class'     => 'save',
        ), -100);

        $this->_formScripts[] = "
            function toggleEditor() {
                if (tinyMCE.getInstanceById('customfield_content') == null) {
                    tinyMCE.execCommand('mceAddControl', false, 'customfield_content');
                } else {
                    tinyMCE.execCommand('mceRemoveControl', false, 'customfield_content');
                }
            }

            function saveAndContinueEdit(){
                editForm.submit($('edit_form').action+'back/edit/');
            }
        ";
    }

    public function getHeaderText()
    {
        if( Mage::registry('customfield_data') && Mage::registry('customfield_data')->getId() ) {
            return Mage::helper('customfield')->__("Edit Item '%s'", $this->htmlEscape(Mage::registry('customfield_data')->getTitle()));
        } else {
            return Mage::helper('customfield')->__('Add Item');
        }
    }
}