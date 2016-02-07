<?php
namespace Product\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Product\Form\ProductForm;
use Product\Entity\Product;
use Zend\Validator\File\Size;
use Product\Entity\Tags;

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
			
			$productEntity = new Product();
			$product = new \Product\Model\Product();
			$form->setInputFilter($product->getInputFilter());
			
			$File    = $this->params()->fromFiles('image');
			
			$form->setData($request->getPost());
			
			if ($form->isValid()) {
				$size = new Size(array('max'=>2000000, 'min' => 1)); //max bytes filesize 2MB
				$adapter = new \Zend\File\Transfer\Adapter\Http();
				$adapter->setValidators(array($size), $File['name']);
				
				if (!$adapter->isValid()){
					$dataError = $adapter->getMessages();
					
					$error = array();
					foreach($dataError as $key=>$row){
						$error[] = $row;
					} //set formElementErrors
					$form->setMessages(array('image'=>$error ));
				} else {
					$adapter->setDestination('public/img/product');
					$adapter->receive($File['name']);
					$this->generateAndSaveThumbImage($adapter->getFileName(), $adapter->getFileName(null, false));
				}
				$tagsArray = explode(",", $form->getData()["tags"]);
				foreach ($tagsArray as $tag) {
					$entityTag = new Tags();
					$entityTag->setName($tag);
					$productEntity->getIdTag()->add($entityTag);
					$em->persist($entityTag);
				}
				$productEntity->exchangeArray($form->getData());
				$productEntity->setCreationdate(new \DateTime());
				$em->persist($productEntity);
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
			$productModel = new \Product\Model\Product();
			$productModel->exchangeProductEntity($product);
		}
		catch (\Exception $ex) {
			return $this->redirect()->toRoute('product', array(
					'action' => 'list'
			));
		}
		$form  = new ProductForm();
		$form->bind($productModel);
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
	
	private function generateAndSaveThumbImage($imagePath, $imageName){
		$thumbnailer = $this->getServiceLocator()->get('WebinoImageThumb');
		$thumb = $thumbnailer->create($imagePath, $options = array(), $plugins = array());
		$thumb->resize(100, 100);
		$thumb->save('public/img/product/thumb/' . $imageName);
	}
}