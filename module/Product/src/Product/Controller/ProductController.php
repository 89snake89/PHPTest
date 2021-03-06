<?php
namespace Product\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Product\Form\ProductForm;
use Product\Entity\Product;
use Zend\Validator\File\Size;
use Product\Entity\Tags;
use Product\Form\SearchForm;

class ProductController extends AbstractActionController
{
	public function indexAction(){
		$em = $this->getServiceLocator()->get('doctrine.entitymanager.orm_another');
	
		//Form ricerca prodotti
		$searchForm = new SearchForm();
		$searchForm->get('submit')->setValue('Index');
		
		$request = $this->getRequest();
		if($request->isPost()){
			$postData = $request->getPost();
			$resultArray = $em->getRepository("Product\Entity\Product")->findByTag($postData["tag"]); 
			
			$products = array();
			
			foreach ($resultArray as $result){
				$product = new Product();
				$product->exchangeArray($result);
				$products[] = $product;
			}
			
		}else{
			$products = $em->getRepository("Product\Entity\Product")->findAll();
		}
		
		return new ViewModel(array(
				'products' => $products,
				'searchForm' => $searchForm
		));
	}
	
	public function listAction(){
		return $this->indexAction();
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
			
			$File = $this->params()->fromFiles('image');
			
			$form->setData($request->getPost());
			
			if ($form->isValid()) {
				$adapter = new \Zend\File\Transfer\Adapter\Http();
				$this->saveImage ($form, $adapter, $File);
				
				$tagsArray = explode(",", $form->getData()["tags"]);
				foreach ($tagsArray as $tag) {
					$entityTag = new Tags();
					$entityTag->setName($tag);
					$productEntity->getIdTag()->add($entityTag);
					$em->persist($entityTag);
				}
				$productEntity->exchangeArray($form->getData());
				$productEntity->setCreationdate(new \DateTime());
				$productEntity->setImage($adapter->getFileName(null, false));
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
			$oldFileName = $product->getImage();
			
			$tag = new Tags();
			
			foreach ($product->getIdTag() as $tag){
				$tagArrayName[] = $tag->getName();
			}
			
		}
		catch (\Exception $ex) {
			return $this->redirect()->toRoute('product', array(
					'action' => 'list'
			));
		}
		
		$form  = new ProductForm();
		$form->bind($productModel);
		$form->get('tags')->setValue(implode(",", $tagArrayName));
		$form->get('submit')->setAttribute('value', 'Edit');
		
		$request = $this->getRequest();
		if ($request->isPost()) {
			
			$form->setInputFilter($productModel->getInputFilter());
			$form->setData($request->getPost());
			
			if ($form->isValid()) {
				$File = $this->params()->fromFiles('image');
				$product->exchangeArray($request->getPost());
				$adapter = new \Zend\File\Transfer\Adapter\Http();
				$this->deleteImage($oldFileName);
				$this->saveImage ($form, $adapter, $File);
				$product->setImage($adapter->getFileName(null, false));
				foreach ($product->getIdTag() as $tag){
					$em->remove($tag);
				}
				
				$tagsArray = explode(",", $form->get("tags")->getValue());
				
				foreach ($tagsArray as $tag) {
					$entityTag = new Tags();
					$entityTag->setName($tag);
					$product->getIdTag()->add($entityTag);
					$em->persist($entityTag);
				}
				
				$em->persist($product); 
				$em->flush();
				return $this->redirect()->toRoute('product');
			}
			
		}
		
		return array (
				'id' => $id,
				'form' => $form 
		);
	}
	
	/**
	 * Save image method
	 * 
	 * @param form
	 * @param dataError
	 * @param error
	 */
	private function saveImage($form, $adapter, $File) {
		//TODO Try catch per gestire presistenza del file
		$size = new Size ( array (
				'max' => 2000000,
				'min' => 1 
		) ); // max bytes filesize 2MB
		
		$adapter->setValidators(array($size), $File['name']);

		if (!$adapter->isValid()) {
			$dataError = $adapter->getMessages();
			
			$error = array();
			foreach($dataError as $key => $row) {
				$error[] = $row;
			} // set formElementErrors
			$form->setMessages( array (
					'image' => $error 
			));
		} else {
			$adapter->setDestination ( 'public/img/product' );
			$adapter->receive ($File['name']);
			$this->generateAndSaveThumbImage ( $adapter->getFileName (), $adapter->getFileName ( null, false ) );
		}
	}
	
	private function generateAndSaveThumbImage($imagePath, $imageName){
		$thumbnailer = $this->getServiceLocator()->get('WebinoImageThumb');
		$thumb = $thumbnailer->create($imagePath, $options = array(), $plugins = array());
		$thumb->resize(100, 100);
		$thumb->save('public/img/product/thumb/' . $imageName);
	}
	
	private function deleteImage($imageName){
		//TODO: Controlli esistenza immagine Try catch su file
		unlink("public/img/product/" . $imageName);
		unlink("public/img/product/thumb/" . $imageName);
	}
}