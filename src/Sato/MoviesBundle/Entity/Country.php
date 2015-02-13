<?php

namespace Sato\MoviesBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Country
 *
 * @ORM\Table()
 * @ORM\Entity
 */
class Country
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
     * @ORM\OneToMany(targetEntity="Movie", mappedBy="country_id")
     */
    private $movies ;

    /**
     * @ORM\OneToMany(targetEntity="Actor", mappedBy="country_id")
     */
    private $actors ;

    public function __construct() {
        $this->movies = new ArrayCollection() ;
        $this->actors = new ArrayCollection() ;
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
     * @return Country
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
     * Add movies
     *
     * @param \Sato\MoviesBundle\Entity\Movie $movies
     * @return Country
     */
    public function addMovie(\Sato\MoviesBundle\Entity\Movie $movies)
    {
        $this->movies[] = $movies;

        return $this;
    }

    /**
     * Remove movies
     *
     * @param \Sato\MoviesBundle\Entity\Movie $movies
     */
    public function removeMovie(\Sato\MoviesBundle\Entity\Movie $movies)
    {
        $this->movies->removeElement($movies);
    }

    /**
     * Get movies
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getMovies()
    {
        return $this->movies;
    }

    /**
     * Add actors
     *
     * @param \Sato\MoviesBundle\Entity\Actor $actors
     * @return Country
     */
    public function addActor(\Sato\MoviesBundle\Entity\Actor $actors)
    {
        $this->actors[] = $actors;

        return $this;
    }

    /**
     * Remove actors
     *
     * @param \Sato\MoviesBundle\Entity\Actor $actors
     */
    public function removeActor(\Sato\MoviesBundle\Entity\Actor $actors)
    {
        $this->actors->removeElement($actors);
    }

    /**
     * Get actors
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getActors()
    {
        return $this->actors;
    }
}
