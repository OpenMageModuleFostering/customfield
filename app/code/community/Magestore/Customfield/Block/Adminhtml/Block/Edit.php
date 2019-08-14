<?php

class Magestore_Customfield_Block_Adminhtml_Block_Edit extends Mage_Adminhtml_Block_Widget_Form_Container
{
    public function __construct()
    {
        parent::__construct();
                 
        $this->_objectId = 'id';
        $this->_blockGroup = 'customfield';
        $this->_controller = 'adminhtml_block';
        

        $this->_addButton('saveandcontinue', array(
            'label'     => Mage::helper('adminhtml')->__('Save And Continue Edit'),
            'onclick'   => 'saveAndContinueEdit()',
            'class'     => 'save',
        ), -100);

		 $this->_removeButton('save');
		 $this->_removeButton('back');
		 $this->_removeButton('delete');
		 $this->_removeButton('reset');
		
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
        if( Mage::registry('block_data') && Mage::registry('block_data')->getId() ) {
            return Mage::helper('customfield')->__("Edit Block Content");
        } else {
            return Mage::helper('customfield')->__('Add Block');
        }
    }
}