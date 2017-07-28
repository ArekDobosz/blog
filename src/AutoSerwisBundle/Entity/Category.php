<?php

namespace AutoSerwisBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="AutoSerwisBundle\Repository\CategoryRepository")
 * @ORM\Table(name="category")
 */
class Category extends AbstractTaxonomy{
   
    /**
     * @ORM\OneToMany(
     *      targetEntity = "Post",
     *      mappedBy = "category"
     * ) 
     */
    protected $posts;
}
