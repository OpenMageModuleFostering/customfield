<?php

class Magestore_Customfield_Adminhtml_AttributeController extends Mage_Adminhtml_Controller_action
{

	protected function _initAction() {
		$this->loadLayout()
			->_setActiveMenu('customfield/attributes')
			->_addBreadcrumb(Mage::helper('adminhtml')->__('Attributes Manager'), Mage::helper('adminhtml')->__('Attribute Manager'));
		
		return $this;
	}   
 
	public function indexAction() {
		$this->_initAction()
			->renderLayout();
	}

	public function editAction() {
		$id     = $this->getRequest()->getParam('id');
		$model  = Mage::getModel('customfield/attribute')->load($id);

		if ($model->getId() || $id == 0) {
			$data = Mage::getSingleton('adminhtml/session')->getFormData(true);
			if (!empty($data)) {
				$model->setData($data);
			}

			Mage::register('attribute_data', $model);

			$this->loadLayout();
			$this->_setActiveMenu('customfield/attributes');

			$this->_addBreadcrumb(Mage::helper('adminhtml')->__('Attribute Manager'), Mage::helper('adminhtml')->__('Attribute Manager'));
			$this->_addBreadcrumb(Mage::helper('adminhtml')->__('Attribute News'), Mage::helper('adminhtml')->__('Attribute News'));

			$this->getLayout()->getBlock('head')->setCanLoadExtJs(true);

			$this->_addContent($this->getLayout()->createBlock('customfield/adminhtml_attribute_edit'))
				->_addLeft($this->getLayout()->createBlock('customfield/adminhtml_attribute_edit_tabs'));

			$this->renderLayout();
		} else {
			Mage::getSingleton('adminhtml/session')->addError(Mage::helper('customfield')->__('Attribute does not exist'));
			$this->_redirect('*/*/');
		}
	}
 
	public function newAction() {
		$this->_forward('edit');
	}
 
	public function saveAction() {
		if ($data = $this->getRequest()->getPost()) {  			
			$model = Mage::getModel('customfield/attribute');		
			$model->setData($data)
				->setId($this->getRequest()->getParam('id'));
			
			try {
				
				$model->save();
				
				if(!$this->getRequest()->getParam('id'))
				{
					$model->createProductAttribute();
				}
				
				Mage::getSingleton('adminhtml/session')->addSuccess(Mage::helper('customfield')->__('Attribute was successfully saved'));
				Mage::getSingleton('adminhtml/session')->setFormData(false);

				if ($this->getRequest()->getParam('back')) {
					$this->_redirect('*/*/edit', array('id' => $model->getId()));
					return;
				}
				$this->_redirect('*/*/');
				return;
            } catch (Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
                Mage::getSingleton('adminhtml/session')->setFormData($data);
                $this->_redirect('*/*/edit', array('id' => $this->getRequest()->getParam('id')));
                return;
            }
        }
        Mage::getSingleton('adminhtml/session')->addError(Mage::helper('customfield')->__('Unable to find attribute to save'));
        $this->_redirect('*/*/');
	}
 
	public function deleteAction() {
		$id = $this->getRequest()->getParam('id');
		if( $id > 0 ) {
			try {
				$model = Mage::getModel('customfield/attribute');

				Mage::getModel('customfield/attribute')->load($id)->deleteAttributeCode();
								
				$model->setId($this->getRequest()->getParam('id'))
					->delete();
					 
				Mage::getSingleton('adminhtml/session')->addSuccess(Mage::helper('adminhtml')->__('Attribute was successfully deleted'));
				$this->_redirect('*/*/');
			} catch (Exception $e) {
				Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
				$this->_redirect('*/*/edit', array('id' => $this->getRequest()->getParam('id')));
			}
		}
		$this->_redirect('*/*/');
	}

    public function massDeleteAction() {
        $attributeIds = $this->getRequest()->getParam('id');
        if(!is_array($attributeIds)) {
			Mage::getSingleton('adminhtml/session')->addError(Mage::helper('adminhtml')->__('Please select attribute(s)'));
        } else {
            try {
                foreach ($attributeIds as $attributeId) {
                    $attribute = Mage::getModel('customfield/attribute')->load($attributeId);
                    $attribute->delete();
                }
                Mage::getSingleton('adminhtml/session')->addSuccess(
                    Mage::helper('adminhtml')->__(
                        'Total of %d record(s) were successfully deleted', count($attributeIds)
                    )
                );
            } catch (Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
            }
        }
        $this->_redirect('*/*/index');
    }
	
    public function massStatusAction()
    {
        $attributeIds = $this->getRequest()->getParam('attribute');
        if(!is_array($attributeIds)) {
            Mage::getSingleton('adminhtml/session')->addError($this->__('Please select attribute(s)'));
        } else {
            try {
                foreach ($attributeIds as $attributeId) {
                    $attribute = Mage::getSingleton('customfield/attribute')
                        ->load($attributeId)
                        ->setStatus($this->getRequest()->getParam('status'))
                        ->setIsMassupdate(true)
                        ->save();
                }
                $this->_getSession()->addSuccess(
                    $this->__('Total of %d record(s) were successfully updated', count($attributeIds))
                );
            } catch (Exception $e) {
                $this->_getSession()->addError($e->getMessage());
            }
        }
        $this->_redirect('*/*/index');
    }
  
    public function exportCsvAction()
    {
        $fileName   = 'attributes.csv';
        $content    = $this->getLayout()->createBlock('customfield/adminhtml_attribute_grid')
            ->getCsv();

        $this->_sendUploadResponse($fileName, $content);
    }

    public function exportXmlAction()
    {
        $fileName   = 'attributes.xml';
        $content    = $this->getLayout()->createBlock('customfield/adminhtml_attribute_grid')
            ->getXml();

        $this->_sendUploadResponse($fileName, $content);
    }

    protected function _sendUploadResponse($fileName, $content, $contentType='application/octet-stream')
    {
        $response = $this->getResponse();
        $response->setHeader('HTTP/1.1 200 OK','');
        $response->setHeader('Pragma', 'public', true);
        $response->setHeader('Cache-Control', 'must-revalidate, post-check=0, pre-check=0', true);
        $response->setHeader('Content-Disposition', 'attachment; filename='.$fileName);
        $response->setHeader('Last-Modified', date('r'));
        $response->setHeader('Accept-Ranges', 'bytes');
        $response->setHeader('Content-Length', strlen($content));
        $response->setHeader('Content-type', $contentType);
        $response->setBody($content);
        $response->sendResponse();
        die;
    }
}