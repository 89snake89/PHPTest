<?php
namespace Product\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Album
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
	 * @ORM\Column(name="description", type="string", nullable=false)
	 */
	private $description;
	
	/**
	 * @var string
	 *
	 * @ORM\Column(name="image", type="string", length=255, nullable=false)
	 */
	private $image;
	
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
	 * Get album method
	 * @return string
	 */
	public function getName(){
		return $this->name;
	}
	
	/**
	 * Get description method
	 * @return string
	 */
	public function getDescription(){
		return $this->description;
	}
	
	/**
	 * Get image method
	 * @return string
	 */
	public function getImage(){
		return $this->image;
	}
	
	/**
	 * Set name method
	 * @param unknown $newName
	 */
	public function setName($newName){
		$this->name = $newName;
	}
	
	/**
	 * Set description method
	 * @param unknown $newImage
	 */
	public function setDescription($newDescription){
		$this->description = $newDescription;
	}
	
	/**
	 * Set description method
	 * @param unknown $newDescription
	 */
	public function setImage($newImage){
		$this->image = $newImage;
	}
	
	public function exchangeArray($data){
		$this->id     = (!empty($data['id'])) ? $data['id'] : null;
		$this->name = (!empty($data['name'])) ? $data['name'] : null;
		$this->description  = (!empty($data['description'])) ? $data['description'] : null;
		$this->image  = (!empty($data['image'])) ? $data['image'] : null;
	}
}