<?php
namespace Product\Repository;

use Doctrine\ORM\EntityRepository;
use Doctrine\Common\Collections\Criteria;
use Product\Entity\Product;

class ProductRepository extends EntityRepository
{
	public function findAll(){
		return $this->findBy(array(), array('creationdate' => 'ASC'));
	}
	
	public function findByTag($tagstring){
		$criteria = new Criteria();
		$criteria->andWhere(Criteria::expr()->contains('t.name', "%".$tagstring."%"));
				 
		$queryBuilder = $this->_em->createQueryBuilder()
					->select('p')->distinct(true)
					->from($this->getEntityName(), "p")
					->leftJoin(
							'Product\Entity\ProductTags',
							'pt',
							\Doctrine\ORM\Query\Expr\Join::WITH,
							'p.id = pt.idProduct'
							)
					->leftJoin(
							'Product\Entity\Tags',
							't',
							\Doctrine\ORM\Query\Expr\Join::WITH,
							't.id = pt.idTag'
							)
					->addCriteria($criteria)
					->orderBy("p.creationdate", "ASC")->getQuery();
		
		return $queryBuilder->getArrayResult();
	}
}