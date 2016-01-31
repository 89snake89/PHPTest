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


}

