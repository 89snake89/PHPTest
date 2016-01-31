<?php
namespace Product\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Product\Form\ProductForm;
use Product\Entity\Product;

class ProductController extends AbstractActionController
{
	public function indexAction(){
		$em = $this->getServiceLocator()->get('doctrine.entitymanager.orm_another');
	
		$products = $em->getRepository("Product\Entity\Product")->findAll();
		
		return new ViewModel(array(
				'products' => $products,
		));
	}
	
	public function listAction(){
		$em = $this->getServiceLocator()->get('doctrine.entitymanager.orm_another');
	
		$products = $em->getRepository("Product\Entity\Product")->findAll();
		return new ViewModel(array(
				'products' => $products,
		));
	}
	
	public function createAction(){
		$form = new ProductForm();
		$form->get('submit')->setValue('Create');
		
		$request = $this->getRequest();
		if ($request->isPost()) {
			$em = $this->getServiceLocator()->get('doctrine.entitymanager.orm_another');
			$product = new Product();
			$form->setData($request->getPost());
			//TODO Da salvare i tags.
			if ($form->isValid()) {
				$product->exchangeArray($form->getData());
				$em->persist($product);
				$em->flush();
				return $this->redirect()->toRoute('product');
			}
		}
		return array('form' => $form);
	}
	
	public function editAction(){
		$em = $this->getServiceLocator()->get('doctrine.entitymanager.orm_another');
		$id = (int) $this->params()->fromRoute('id', 0);
		if (!$id) {
			return $this->redirect()->toRoute('product', array(
					'action' => 'create'
			));
		}
		
		try {
			$product = $em->getRepository("Product\Entity\Product")->find($id);
		}
		catch (\Exception $ex) {
			return $this->redirect()->toRoute('product', array(
					'action' => 'list'
			));
		}
		$form  = new ProductForm();
		$form->bind($product);
		$form->get('submit')->setAttribute('value', 'Edit');
		
		$request = $this->getRequest();
		if ($request->isPost()) {
			$em = $this->getServiceLocator()->get('doctrine.entitymanager.orm_another');
			$product = new Product();
			$form->setData($request->getPost());
			//TODO Da salvare i tags.
			if ($form->isValid()) {
				$product->exchangeArray($form->getData());
				$em->persist($product);
				$em->flush();
				return $this->redirect()->toRoute('product');
			}
		}
		return array(
				'id' => $id,
				'form' => $form
		);
	}
}