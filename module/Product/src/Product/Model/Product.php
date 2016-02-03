<?php
namespace Product\Model;

use Zend\InputFilter\InputFilter;
use Zend\InputFilter\InputFilterAwareInterface;
use Zend\InputFilter\InputFilterInterface;

class Product implements InputFilterAwareInterface
{
	public $id;
	public $name;
	public $description;
	public $image;
	
	public function getArrayCopy(){
		return get_object_vars($this);
	}
	
	public function setInputFilter(InputFilterInterface $inputFilter){
		throw new \Exception("Not used");
	}
	
	public function getInputFilter(){
		if (!$this->inputFilter) {
			$inputFilter = new InputFilter();
	
			$inputFilter->add(array(
					'name'     => 'id',
					'required' => true,
					'filters'  => array(
							array('name' => 'Int'),
					),
			));
	
			$inputFilter->add(array(
					'name'     => 'name',
					'required' => true,
					'filters'  => array(
							array('name' => 'StripTags'),
							array('name' => 'StringTrim'),
					),
					'validators' => array(
							array(
									'name'    => 'StringLength',
									'options' => array(
											'encoding' => 'UTF-8',
											'min'      => 1,
											'max'      => 100,
									),
							),
					),
			));
	
			$inputFilter->add(array(
					'name'     => 'description',
					'required' => true,
					'filters'  => array(
							array('name' => 'StripTags'),
							array('name' => 'StringTrim'),
					),
					'validators' => array(
							array(
									'name'    => 'StringLength',
									'options' => array(
											'encoding' => 'UTF-8',
											'min'      => 1,
											'max'      => 255,
									),
							),
					),
			));
			
			$inputFilter->add(array(
					'name'     => 'image',
					'required' => false
			));
	
			$this->inputFilter = $inputFilter;
		}
	
		return $this->inputFilter;
	}
	
	public function exchangeProductEntity($data){
		$this->id     = (!empty($data->getId())) ? $data->getId() : null;
		$this->name = (!empty($data->getName())) ? $data->getName() : null;
		$this->description  = (!empty($data->getDescription())) ? $data->getDescription() : null;
		$this->image  = (!empty($data->getImage())) ? $data->getImage() : null;
	}
}