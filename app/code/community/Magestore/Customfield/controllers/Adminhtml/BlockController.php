<?php

class Magestore_Customfield_Adminhtml_BlockController extends Mage_Adminhtml_Controller_action
{

	protected function _initAction() {
		$this->loadLayout()
			->_setActiveMenu('customfield/blocks')
			->_addBreadcrumb(Mage::helper('adminhtml')->__('Blocks Manager'), Mage::helper('adminhtml')->__('Block Manager'));
		
		return $this;
	}   
 
	public function indexAction() {
		$this->_initAction()
			->renderLayout();
	}

	public function editAction() {
		$id     = $this->getRequest()->getParam('id');
		$model  = Mage::getModel('customfield/block')->load($id);

		if ($model->getId() || $id == 0) {
			$data = Mage::getSingleton('adminhtml/session')->getFormData(true);
			if (!empty($data)) {
				$model->setData($data);
			}

			Mage::register('block_data', $model);

			$this->loadLayout();
			$this->_setActiveMenu('customfield/blocks');

			$this->_addBreadcrumb(Mage::helper('adminhtml')->__('Block Manager'), Mage::helper('adminhtml')->__('Block Manager'));
			$this->_addBreadcrumb(Mage::helper('adminhtml')->__('Block News'), Mage::helper('adminhtml')->__('Block News'));

			$this->getLayout()->getBlock('head')->setCanLoadExtJs(true);

			$this->_addContent($this->getLayout()->createBlock('customfield/adminhtml_block_edit'))
				->_addLeft($this->getLayout()->createBlock('customfield/adminhtml_block_edit_tabs'));

			$this->renderLayout();
		} else {
			Mage::getSingleton('adminhtml/session')->addError(Mage::helper('customfield')->__('Block does not exist'));
			$this->_redirect('*/*/');
		}
	}
 
	public function newAction() {
		$this->_forward('edit');
	}
 
	public function saveAction() {
		if ($data = $this->getRequest()->getPost()) {
				  			
			$model = Mage::getModel('customfield/block');		
			$model->setData($data)
				->setId($this->getRequest()->getParam('id'));
			
			try {									
				$model->save();
				Mage::getSingleton('adminhtml/session')->addSuccess(Mage::helper('customfield')->__('Block was successfully saved'));
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
        Mage::getSingleton('adminhtml/session')->addError(Mage::helper('customfield')->__('Unable to find block to save'));
        $this->_redirect('*/*/');
	}
 
	public function deleteAction() {
		if( $this->getRequest()->getParam('id') > 0 ) {
			try {
				$model = Mage::getModel('customfield/block');
				 
				$model->setId($this->getRequest()->getParam('id'))
					->delete();
					 
				Mage::getSingleton('adminhtml/session')->addSuccess(Mage::helper('adminhtml')->__('Block was successfully deleted'));
				$this->_redirect('*/*/');
			} catch (Exception $e) {
				Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
				$this->_redirect('*/*/edit', array('id' => $this->getRequest()->getParam('id')));
			}
		}
		$this->_redirect('*/*/');
	}

    public function massDeleteAction() {
        $blocks = $this->getRequest()->getParam('block');
        if(!is_array($blocks)) {
			Mage::getSingleton('adminhtml/session')->addError(Mage::helper('adminhtml')->__('Please select block(s)'));
        } else {
            try {
                foreach ($blocks as $id) {
                    $block = Mage::getModel('customfield/block')->load($id);
                    $block->delete();
                }
                Mage::getSingleton('adminhtml/session')->addSuccess(
                    Mage::helper('adminhtml')->__(
                        'Total of %d record(s) were successfully deleted', count($blocks)
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
        $blockIds = $this->getRequest()->getParam('id');
        if(!is_array($blockIds)) {
            Mage::getSingleton('adminhtml/session')->addError($this->__('Please select block(s)'));
        } else {
            try {
                foreach ($blockIds as $blockId) {
                    $block = Mage::getSingleton('customfield/block')
                        ->load($blockId)
                        ->setStatus($this->getRequest()->getParam('status'))
                        ->setIsMassupdate(true)
                        ->save();
                }
                $this->_getSession()->addSuccess(
                    $this->__('Total of %d record(s) were successfully updated', count($blockIds))
                );
            } catch (Exception $e) {
                $this->_getSession()->addError($e->getMessage());
            }
        }
        $this->_redirect('*/*/index');
    }
  
    public function exportCsvAction()
    {
        $fileName   = 'blocks.csv';
        $content    = $this->getLayout()->createBlock('customfield/adminhtml_block_grid')
            ->getCsv();

        $this->_sendUploadResponse($fileName, $content);
    }
}