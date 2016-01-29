<?php
namespace Product\Controller;

use Zend\Mvc\Controller\AbstractActionController;

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
}