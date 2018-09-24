<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Book
 *
 * @ORM\Table(name="book")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\BookRepository")
 * @ORM\HasLifecycleCallbacks()
 */
class Book
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="titre", type="string", length=255)
     */
    private $titre;
    
    /**
     * @var string
     *
     * @ORM\Column(name="language", type="string", length=20 , nullable=true)
     */
    private $language;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="anneePublication", type="date" , nullable=true)
     */
    private $anneePublication;

    /**
     * @var int
     *
     * @ORM\Column(name="isbn", type="integer", unique=false)
     */
    private $isbn;

    /**
     * @var string
     *
     * @ORM\Column(name="api_id", type="string", length=30, unique=true)
     */
    private $apiId;


    /**
     * @var string
     *
     * @ORM\Column(name="description", type="text", unique=false , nullable=true)
     */
    private $description;

    /**
     * @var string
     *
     * @ORM\Column(name="category", type="string", unique=false , nullable=true)
     */
    private $category;

    /**
     * @var string
     *
     * @ORM\Column(name="search_info", type="text", unique=false , nullable=true)
     */
    private $searchInfo;

    /**
     * @var string
     *
     * @ORM\Column(name="thumbnail", type="text", unique=false , nullable=true)
     */
    private $thumbnail;

    /**
     * @var int
     *
     * @ORM\Column(name="page_count", type="integer" , nullable=true)
     */
    private $pageCount;

    /**
     * @var float
     * @ORM\Column(name="score", type="float" , nullable=true)
     */
    private $rating;

    /**
     * @var int
     *
     * @ORM\Column(name="rating_count", type="integer" , nullable=true)
     */
    private $ratingCount;

    /**
     * @var int
     *
     * @ORM\Column(name="views_count", type="integer")
     */
    private $viewsCount =0;

    /**
     * @var int
     *
     * @ORM\Column(name="in_library_count", type="integer")
     */
    private $inLibraryCount =0;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date", type="datetime")
     */
    private $dateFirstAjout;




    /**
     * Book constructor.
     * @param string $titre
     * @param string $language
     * @param \DateTime $anneePublication
     * @param \DateTime $dateFirstAjout
     * @param int $isbn
     * @param string $apiId
     * @param string $description
     * @param string $searchInfo
     * @param int $pageCount
     */
    public function __construct(string $titre = null, string $language = null, \DateTime $anneePublication = null, int $isbn = null, string $apiId = null, string $description = null, string $searchInfo = null, int $pageCount = null)
    {
        $this->titre = $titre;
        $this->language = $language;
        $this->anneePublication = $anneePublication;
        $this->isbn = $isbn;
        $this->apiId = $apiId;
        $this->description = $description;
        $this->searchInfo = $searchInfo;
        $this->pageCount = $pageCount;

    }


    /**
     * Get id.
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set titre.
     *
     * @param string $titre
     *
     * @return Book
     */
    public function setTitre($titre)
    {
        $this->titre = $titre;

        return $this;
    }

    /**
     * Get titre.
     *
     * @return string
     */
    public function getTitre()
    {
        return $this->titre;
    }


    /**
     * Set anneePublication.
     *
     * @param \DateTime $anneePublication
     *
     * @return Book
     */
    public function setAnneePublication($anneePublication)
    {
        $this->anneePublication = $anneePublication;

        return $this;
    }

    /**
     * Get anneePublication.
     *
     * @return \DateTime
     */
    public function getAnneePublication()
    {
        return $this->anneePublication;
    }

    /**
     * Set isbn.
     *
     * @param string $isbn
     *
     * @return Book
     */
    public function setIsbn($isbn)
    {
        $this->isbn = $isbn;

        return $this;
    }

    /**
     * Get isbn.
     *
     * @return string
     */
    public function getIsbn()
    {
        return $this->isbn;
    }

    /**
     * Set language
     *
     * @param string $language
     *
     * @return Book
     */
    public function setLanguage($language)
    {
        $this->language = $language;

        return $this;
    }

    /**
     * Get language
     *
     * @return string
     */
    public function getLanguage()
    {
        return $this->language;
    }

    /**
     * Set apiId
     *
     * @param string $apiId
     *
     * @return Book
     */
    public function setApiId($apiId)
    {
        $this->apiId = $apiId;

        return $this;
    }

    /**
     * Get apiId
     *
     * @return string
     */
    public function getApiId()
    {
        return $this->apiId;
    }

    /**
     * Set description
     *
     * @param string $description
     *
     * @return Book
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
     * Set searchInfo
     *
     * @param string $searchInfo
     *
     * @return Book
     */
    public function setSearchInfo($searchInfo)
    {
        $this->searchInfo = $searchInfo;

        return $this;
    }

    /**
     * Get searchInfo
     *
     * @return string
     */
    public function getSearchInfo()
    {
        return $this->searchInfo;
    }

    /**
     * Set pageCount
     *
     * @param integer $pageCount
     *
     * @return Book
     */
    public function setPageCount($pageCount)
    {
        $this->pageCount = $pageCount;

        return $this;
    }

    /**
     * Get pageCount
     *
     * @return integer
     */
    public function getPageCount()
    {
        return $this->pageCount;
    }

    /**
     * Set viewsCount
     *
     * @param integer $viewsCount
     *
     * @return Book
     */
    public function setViewsCount($viewsCount)
    {
        $this->viewsCount = $viewsCount;

        return $this;
    }

    /**
     * Get viewsCount
     *
     * @return integer
     */
    public function getViewsCount()
    {
        return $this->viewsCount;
    }

    /**
     * Set dateFirstAjout
     *
     * @param \DateTime $dateFirstAjout
     *
     * @return Book
     * @ORM\PrePersist()
     */
    public function setDateFirstAjout()
    {
        $this->dateFirstAjout =  new \Datetime();

        return $this;
    }

    /**
     * Get dateFirstAjout
     *
     * @return \DateTime
     */
    public function getDateFirstAjout()
    {
        return $this->dateFirstAjout;
    }

    /**
     * Set inLibraryCount
     *
     * @param integer $inLibraryCount
     *
     * @return Book
     */
    public function setInLibraryCount($inLibraryCount)
    {
        $this->inLibraryCount = $inLibraryCount;

        return $this;
    }

    /**
     * Get inLibraryCount
     *
     * @return integer
     */
    public function getInLibraryCount()
    {
        return $this->inLibraryCount;
    }

    /**
     * Set category
     *
     * @param string $category
     *
     * @return Book
     */
    public function setCategory($category)
    {
        $this->category = $category;

        return $this;
    }

    /**
     * Get category
     *
     * @return string
     */
    public function getCategory()
    {
        return $this->category;
    }


    /**
     * Set rating
     *
     * @param float $rating
     *
     * @return Book
     */
    public function setRating($rating)
    {
        $this->rating = $rating;

        return $this;
    }

    /**
     * Get rating
     *
     * @return float
     */
    public function getRating()
    {
        return $this->rating;
    }

    /**
     * Set ratingCount
     *
     * @param integer $ratingCount
     *
     * @return Book
     */
    public function setRatingCount($ratingCount)
    {
        $this->ratingCount = $ratingCount;

        return $this;
    }

    /**
     * Get ratingCount
     *
     * @return integer
     */
    public function getRatingCount()
    {
        return $this->ratingCount;
    }

    /**
     * Set thumbnail
     *
     * @param string $thumbnail
     *
     * @return Book
     */
    public function setThumbnail($thumbnail)
    {
        $this->thumbnail = $thumbnail;

        return $this;
    }

    /**
     * Get thumbnail
     *
     * @return string
     */
    public function getThumbnail()
    {
        return $this->thumbnail;
    }
}
