<?php

namespace Product\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Tags
 *
 * @ORM\Table(name="tags", uniqueConstraints={@ORM\UniqueConstraint(name="name", columns={"name"})})
 * @ORM\Entity
 */
class Tags
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255, nullable=false)
     */
    private $name = '0';

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="Product\Entity\Product", mappedBy="idTag")
     */
    private $idProduct;

    /**
     * Constructor
     */
    public function __construct(){
        $this->idProduct = new \Doctrine\Common\Collections\ArrayCollection();
    }
    
    /**
     * Get Id method
     * @return number
     */
    public function getId(){
    	return $this->id;
    }
    
    /**
     * Setter method for Id
     * @param int $newId
     */
    public function setId($newId){
    	$this->id = $newId;
    }
    
    /**
     * Get Name method
     * @return string
     */
    public function getName(){
    	return $this->name;
    }
    
    /**
     * Setter method for Name
     * @param string $newName
     */
    public function setName($newName){
    	$this->name = $newName;
    }
    
    /**
     * Get idProduct method
     * @return \Doctrine\Common\Collections\ArrayCollection
     */
    public function getIdProduct(){
    	return $this->idProduct;
    }
    
    /**
     * Setter method for idProduct
     * @param \Doctrine\Common\Collections\ArrayCollection $idProduct
     */
    public function setIdProduct($idProduct){
    	$this->idProduct = $idProduct;
    }

}

