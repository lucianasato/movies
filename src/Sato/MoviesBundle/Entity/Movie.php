<?php

namespace Sato\MoviesBundle\Entity;

use Gedmo\Mapping\Annotation as Gedmo;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection ;
use Symfony\Component\Validator\Constraints as Assert;
/**
 * Movie
 *
 * @ORM\Table()
 * @ORM\Entity
 */
class Movie
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
	 * @ORM\Column(name="title", type="string", length=255)
	 * @Assert\NotBlank(message = "movie.title.not_blank")
	 */
	private $title;

	/**
	 * @var string
	 *
	 * @ORM\Column(name="description", type="text")
	 * @Assert\NotBlank(message = "movie.description.not_blank")
	 */
	private $description;

	/**
	 * @var string
	 *
	 * @ORM\ManyToOne(targetEntity="Country", inversedBy="movies")
	 * @ORM\JoinColumn(name="country_id", referencedColumnName="id")
	 * 
	 * @Assert\NotNull()
	 */
	private $country_id;

	/**
	 * @var string
	 *
	 * @ORM\ManyToOne(targetEntity="Distributor", inversedBy="distributors")
	 * @ORM\JoinColumn(name="distributor_id", referencedColumnName="id")
	 * 
	 * @Assert\NotNull()
	 */
	private $distributor_id;

	 /**
     * @var \DateTime
     *
     * @ORM\Column(name="release_date", type="date")
     */
	private $release_date ;

	/**
	 * @ORM\ManyToMany(targetEntity="Actor", inversedBy="movies")
	 * @ORM\JoinTable(name="movies_actors")
	 * 
	 * @Assert\Count(
     *      min = "1",
     *      minMessage = "movie.actors.count",
     * )
	 **/
	private $actors ;

	/**
	 * @ORM\ManyToMany(targetEntity="Director", inversedBy="movies")
	 * @ORM\JoinTable(name="movies_directors")
	 * 
	 * @Assert\Count(
     *      min = "1",
     *      minMessage = "movie.directors.count",
     * )
	 **/
	private $directors ;

	/**
	 * @ORM\ManyToMany(targetEntity="Genre", inversedBy="movies")
	 * @ORM\JoinTable(name="movies_genres")
	 * 
	 * @Assert\Count(
     *      min = "1",
     *      minMessage = "movie.genres.count",
     * )
	 **/
	private $genres ;

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
		$this->actors = new ArrayCollection();
		$this->directors = new ArrayCollection();
		$this->genres = new ArrayCollection();
	}

	public function __toString() {
		return $this->title ;
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
	 * Set title
	 *
	 * @param string $title
	 * @return Movie
	 */
	public function setTitle($title)
	{
		$this->title = $title;

		return $this;
	}

	/**
	 * Get title
	 *
	 * @return string 
	 */
	public function getTitle()
	{
		return $this->title;
	}

	/**
	 * Set description
	 *
	 * @param string $description
	 * @return Movie
	 */
	public function setDescription($description)
	{
		$this->description = $description;

		return $this;
	}

	/**
	 * Get description
	 *
	 * @return string 
	 */
	public function getDescription()
	{
		return $this->description;
	}

	/**
	 * Set country_id
	 *
	 * @param \Sato\MoviesBundle\Entity\Country $countryId
	 * @return Movie
	 */
	public function setCountryId(\Sato\MoviesBundle\Entity\Country $countryId = null)
	{
		$this->country_id = $countryId;

		return $this;
	}

	/**
	 * Get country_id
	 *
	 * @return \Sato\MoviesBundle\Entity\Country 
	 */
	public function getCountryId()
	{
		return $this->country_id;
	}

	/**
	 * Set distributor_id
	 *
	 * @param \Sato\MoviesBundle\Entity\Distributor $distributorId
	 * @return Movie
	 */
	public function setDistributorId(\Sato\MoviesBundle\Entity\Distributor $distributorId = null)
	{
		$this->distributor_id = $distributorId;

		return $this;
	}

	/**
	 * Get distributor_id
	 *
	 * @return \Sato\MoviesBundle\Entity\Distributor 
	 */
	public function getDistributorId()
	{
		return $this->distributor_id;
	}

	/**
	 * Add actors
	 *
	 * @param \Sato\MoviesBundle\Entity\Actor $actors
	 * @return Movie
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

	/**
	 * Add directors
	 *
	 * @param \Sato\MoviesBundle\Entity\Director $directors
	 * @return Movie
	 */
	public function addDirector(\Sato\MoviesBundle\Entity\Director $directors)
	{
		$this->directors[] = $directors;

		return $this;
	}

	/**
	 * Remove directors
	 *
	 * @param \Sato\MoviesBundle\Entity\Director $directors
	 */
	public function removeDirector(\Sato\MoviesBundle\Entity\Director $directors)
	{
		$this->directors->removeElement($directors);
	}

	/**
	 * Get directors
	 *
	 * @return \Doctrine\Common\Collections\Collection 
	 */
	public function getDirectors()
	{
		return $this->directors;
	}

	/**
	 * Add genres
	 *
	 * @param \Sato\MoviesBundle\Entity\Genre $genres
	 * @return Movie
	 */
	public function addGenre(\Sato\MoviesBundle\Entity\Genre $genres)
	{
		$this->genres[] = $genres;

		return $this;
	}

	/**
	 * Remove genres
	 *
	 * @param \Sato\MoviesBundle\Entity\Genre $genres
	 */
	public function removeGenre(\Sato\MoviesBundle\Entity\Genre $genres)
	{
		$this->genres->removeElement($genres);
	}

	/**
	 * Get genres
	 *
	 * @return \Doctrine\Common\Collections\Collection 
	 */
	public function getGenres()
	{
		return $this->genres;
	}

    /**
     * Set release_date
     *
     * @param \DateTime $releaseDate
     * @return Movie
     */
    public function setReleaseDate($releaseDate)
    {
        $this->release_date = $releaseDate;

        return $this;
    }

    /**
     * Get release_date
     *
     * @return \DateTime 
     */
    public function getReleaseDate()
    {
        return $this->release_date;
    }
}
