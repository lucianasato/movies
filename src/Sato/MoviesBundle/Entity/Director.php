<?php

namespace Sato\MoviesBundle\Entity;

use Gedmo\Mapping\Annotation as Gedmo;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection ;

/**
 * Director
 *
 * @ORM\Table()
 * @ORM\Entity
 */
class Director
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
	 * @var \DateTime
	 *
	 * @ORM\Column(name="birthdate", type="date")
	 */
	private $birthdate;

	/**
     * @var integer
     *
     * @ORM\ManyToOne(targetEntity="Country", inversedBy="directors")
     * @ORM\JoinColumn(name="country_id", referencedColumnName="id")
     */
	private $countryId;

	/**
	 * @ORM\ManyToMany(targetEntity="Movie", mappedBy="directors")
	 * @ORM\JoinTable(name="movies_directors")
	 */
	private $movies;

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
	 * @return Director
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
	 * @return Director
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
	 * @return Director
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
	 * @return Director
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
