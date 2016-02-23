<?php
namespace Product\Form;

use Zend\Form\Form;

class SearchForm extends Form
{
	public function __construct(){
		parent::__construct("product");
		
		$this->add(array(
				'name' => 'tag',
				'type' => 'Text',
				'options' => array(
						'label' => 'Tag',
				),
		));
		
		$this->add(array(
				'name' => 'submit',
				'type' => 'Submit',
				'attributes' => array(
						'value' => 'Go',
						'id' => 'submitbutton',
				),
		));
	}
}