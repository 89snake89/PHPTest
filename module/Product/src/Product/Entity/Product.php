<?php

namespace Product\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Product
 *
 * @ORM\Table(name="product")
 * @ORM\Entity
 */
class Product
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
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="text", length=65535, nullable=false)
     */
    private $description;

    /**
     * @var string
     *
     * @ORM\Column(name="image", type="string", length=255, nullable=true)
     */
    private $image;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="creationdate", type="datetime", nullable=false)
     */
    private $creationdate;

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
     * Get Description method
     * @return string
     */
    public function getDescription(){
    	return $this->description;
    }
    
    /**
     * Setter method for Description
     * @param string $newDescription
     */
    public function setDescription($newDescription){
    	$this->description = $newDescription;
    }
    
    /**
     * Get Image method
     * @return string
     */
    public function getImage(){
    	return $this->image;
    }
    
    /**
     * Setter method for Image
     * @param string $newImage
     */
    public function setImage($newImage){
    	$this->image = $newImage;
    }
    
    /**
     * Get Creationdate method
     * @return \DateTime
     */
    public function getCreationdate(){
    	return $this->creationdate;
    }
    
    /**
     * Setter method for Creationdate
     * @param \DateTime $newCreationdate
     */
    public function setCreationdate($newCreationdate){
    	$this->creationdate = $newCreationdate;
    }
    
    public function exchangeArray($data){
    	$this->id     = (!empty($data['id'])) ? $data['id'] : null;
    	$this->name = (!empty($data['name'])) ? $data['name'] : null;
    	$this->description  = (!empty($data['description'])) ? $data['description'] : null;
    	$this->image  = (!empty($data['image'])) ? $data['image'] : null;
    }
    
    public function getFormattedDate(){
    	
    }
}

