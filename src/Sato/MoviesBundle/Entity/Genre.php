<?php

namespace Sato\MoviesBundle\Entity;

use Gedmo\Mapping\Annotation as Gedmo;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Genre
 *
 * @ORM\Table()
 * @ORM\Entity
 */
class Genre
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
	 * @ORM\ManyToMany(targetEntity="Movie", mappedBy="genres")
	 * @ORM\JoinTable(name="movies_genres")
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
	 * @return Genre
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
	 * @return Genre
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
