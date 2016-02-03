<?php
namespace Product\Form;

use Zend\Form\Form;
use Zend\InputFilter\File;
use Zend\Form\Element;

class ProductForm extends Form
{
	public function __construct($name = null){
		// we want to ignore the name passed
		parent::__construct('person');
		
		$this->add(array(
				'name' => 'id',
				'type' => 'Hidden',
		));
		$this->add(array(
				'name' => 'name',
				'type' => 'Text',
				'options' => array(
						'label' => 'Name',
				),
		));
		$this->add(array(
				'name' => 'description',
				'type' => 'Text',
				'options' => array(
						'label' => 'Description',
				),
		));

		// File Input
		$file = new Element\File('image');
		$file->setLabel('Image')
		->setAttribute('id', 'image-file');
		$this->add($file);
		
		$this->add(array(
				'name' => 'tags',
				'type' => 'Hidden',
				'attributes' => array(
						'required' => 'required',
						'id'   => 'tags-input'
				),
		));
		$this->add(array(
				'name' => 'submit',
				'type' => 'Submit',
				'attributes' => array(
						'value' => 'Go',
						'id' => 'submitbutton',
				),
				'options' => array(
						'label' => 'Create',
				),
		));
	}
}