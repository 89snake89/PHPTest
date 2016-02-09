<?php

namespace Product\Entity;
use Zend\InputFilter\InputFilter;
use Zend\InputFilter\InputFilterAwareInterface;
use Zend\InputFilter\InputFilterInterface;

use Doctrine\ORM\Mapping as ORM;

/**
 * Product
 *
 * @ORM\Table(name="product")
 * @ORM\Entity(repositoryClass="Product\Repository\ProductRepository")
 */
class Product implements InputFilterAwareInterface
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
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="Product\Entity\Tags", inversedBy="idProduct")
     * @ORM\JoinTable(name="product_tags",
     *   joinColumns={
     *     @ORM\JoinColumn(name="id_product", referencedColumnName="id")
     *   },
     *   inverseJoinColumns={
     *     @ORM\JoinColumn(name="id_tag", referencedColumnName="id")
     *   }
     * )
     */
    private $idTag;

    /**
     * Constructor
     */
    public function __construct(){
        $this->idTag = new \Doctrine\Common\Collections\ArrayCollection();
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
    
    /**
     * Get idTags method
     * @return \Doctrine\Common\Collections\ArrayCollection
     */
    public function getIdTag(){
    	return $this->idTag;
    }
    
    /**
     * Setter method for idTag
     * @param \Doctrine\Common\Collections\ArrayCollection $idProduct
     */
    public function setIdTag($idTag){
    	$this->idTag = $idTag;
    }
    
    public function exchangeArray($data){
    	$this->id     = (!empty($data['id'])) ? $data['id'] : null;
    	$this->name = (!empty($data['name'])) ? $data['name'] : null;
    	$this->description  = (!empty($data['description'])) ? $data['description'] : null;
    	$this->image  = (!empty($data['image'])) ? $data['image'] : null;
    }
    
    
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
    
    public function getFormattedDate(){
    	 
    }

}

