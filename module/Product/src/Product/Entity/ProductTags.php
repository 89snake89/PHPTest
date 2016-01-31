<?php

namespace Product\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * ProductTags
 *
 * @ORM\Table(name="product_tags")
 * @ORM\Entity
 */
class ProductTags
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id_product", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="NONE")
     */
    private $idProduct;

    /**
     * @var integer
     *
     * @ORM\Column(name="id_tag", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="NONE")
     */
    private $idTag;

    /**
     * Get IdTag method
     * @return number
     */
    public function getIdTag(){
    	return $this->idTag;
    }
    
    /**
     * Setter method for IdTag
     * @param int $newIdTag
     */
    public function setIdTag($newIdTag){
    	$this->idTag = $newIdTag;
    }
    
    /**
     * Get IdProduct method
     * @return number
     */
    public function getIdProduct(){
    	return $this->idProduct;
    }
    
    /**
     * Setter method for IdProduct
     * @param int $newIdProduct
     */
    public function setIdProduct($newIdProduct){
    	$this->idProduct = $newIdProduct;
    }
}

