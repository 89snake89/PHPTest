<?php
namespace Product\Repository;

use Doctrine\ORM\EntityRepository;

class ProductRepository extends EntityRepository
{
	public function findAll(){
		return $this->findBy(array(), array('creationdate' => 'ASC'));
	}
	
	public function findByTag($tagstring){
		//TODO Cercare in LIKE il tag
	}
}