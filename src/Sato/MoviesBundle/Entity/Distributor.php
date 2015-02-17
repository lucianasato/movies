<?php

namespace Sato\MoviesBundle\Entity;

use Gedmo\Mapping\Annotation as Gedmo;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Distributor
 *
 * @ORM\Table()
 * @ORM\Entity
 */
class Distributor
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255)
     */
    private $name;

    /**
     * @ORM\OneToMany(targetEntity="Movie", mappedBy="distributor_id")
     */
    private $distributors ;

    /**
     * @Gedmo\Timestampable(on="create")
     * @ORM\Column(type="datetime")
     */
    private $createdAt;

    /**
     * @Gedmo\Timestampable(on="update")
     * @ORM\Column(type="datetime")
     */
    private $updatedAt;

    public function __construct() {
        $this->distributors = new ArrayCollection() ;
    }

    public function __toString() {
        return $this->name ;
    }

    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set name
     *
     * @param string $name
     * @return Distributor
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string 
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Add distributors
     *
     * @param \Sato\MoviesBundle\Entity\Movie $distributors
     * @return Distributor
     */
    public function addDistributor(\Sato\MoviesBundle\Entity\Movie $distributors)
    {
        $this->distributors[] = $distributors;

        return $this;
    }

    /**
     * Remove distributors
     *
     * @param \Sato\MoviesBundle\Entity\Movie $distributors
     */
    public function removeDistributor(\Sato\MoviesBundle\Entity\Movie $distributors)
    {
        $this->distributors->removeElement($distributors);
    }

    /**
     * Get distributors
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getDistributors()
    {
        return $this->distributors;
    }
}
