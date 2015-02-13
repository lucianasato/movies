<?php

namespace Sato\MoviesBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\Common\Collections\ArrayCollection ;

/**
 * Actor
 *
 * @ORM\Table()
 * @ORM\Entity
 */
class Actor
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
     * @Assert\NotBlank()
     * @ORM\Column(name="name", type="string", length=255)
     */
    private $name;

    /**
     * @var \DateTime
     * @ORM\Column(name="birthdate", type="date")
     */
    private $birthdate;

    /**
     * @var integer
     *
     * @ORM\ManyToOne(targetEntity="Country", inversedBy="actors")
     * @ORM\JoinColumn(name="country_id", referencedColumnName="id")
     */
    private $countryId;

    /**
     * @ORM\ManyToMany(targetEntity="Movie", mappedBy="actors")
     * @ORM\JoinTable(name="movies_actors")
     */
    private $movies ;

    public function __construct() {
        $this->movies = new ArrayCollection();
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
     * @return Actor
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
     * Set birthdate
     *
     * @param \DateTime $birthdate
     * @return Actor
     */
    public function setBirthdate($birthdate)
    {
        $this->birthdate = $birthdate;

        return $this;
    }

    /**
     * Get birthdate
     *
     * @return \DateTime 
     */
    public function getBirthdate()
    {
        return $this->birthdate;
    }

    /**
     * Set countryId
     *
     * @param integer $countryId
     * @return Actor
     */
    public function setCountryId($countryId)
    {
        $this->countryId = $countryId;

        return $this;
    }

    /**
     * Get countryId
     *
     * @return integer 
     */
    public function getCountryId()
    {
        return $this->countryId;
    }

    /**
     * Add movies
     *
     * @param \Sato\MoviesBundle\Entity\Movie $movies
     * @return Actor
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
}
