<?php

namespace Siplo\MediaBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\File;
use Vich\UploaderBundle\Mapping\Annotation as Vich;
use Siplo\UserBundle\Entity\SiploUser;

/**
 * @ORM\Entity
 * @Vich\Uploadable
 */
class Photo
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
     */
    private $title;

    /**
     * NOTE: This is not a mapped field of entity metadata, just a simple property.
     *
     * @Vich\UploadableField(mapping="uploaded_photo", fileNameProperty="photoFileName")
     *
     * @var File
     */
    private $photo;

    /**
     * @var string
     *
     * @ORM\Column(name="photo_filename", type="string", length=255)
     */
    private $photoFileName;

    /**
     * @var int
     * @ORM\Column(name="rating")
     */
    private $rating = 0;

    /**
     * @var bool
     * @ORM\Column(name="authorised", type="boolean")
     */
    private $authorised = false;

    /**
     * @ORM\ManyToOne(targetEntity="Country", inversedBy="photos")
     * @ORM\JoinColumn(name="country_id", referencedColumnName="id")
     **/
    private $country;

    /**
     * @ORM\ManyToOne(targetEntity="Category", inversedBy="photos")
     * @ORM\JoinColumn(name="category_id", referencedColumnName="id")
     * @ORM\Column(nullable=true)
     **/
    private $category;

    /**
     * @ORM\ManyToOne(targetEntity="SubCategory", inversedBy="photos")
     * @ORM\Column(nullable=true)
     **/
    private $subCategory;


    /**
     * @ORM\ManyToOne(targetEntity="Siplo\UserBundle\Entity\SiploUser", inversedBy="photos")
     **/
    private $user;


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
     * If manually uploading a file (i.e. not using Symfony Form) ensure an instance
     * of 'UploadedFile' is injected into this setter to trigger the  update. If this
     * bundle's configuration parameter 'inject_on_load' is set to 'true' this setter
     * must be able to accept an instance of 'File' as the bundle will inject one here
     * during Doctrine hydration.
     *
     * @param File|\Symfony\Component\HttpFoundation\File\UploadedFile $photo
     */
    public function setPhoto(File $photo = null)
    {
        $this->photo = $photo;

        if ($photo) {
            // It is required that at least one field changes if you are using doctrine
            // otherwise the event listeners won't be called and the file is lost
            $this->updatedAt = new \DateTime('now');
        }
    }

    /**
     * @return File
     */
    public function getPhoto()
    {
        return $this->photo;
    }


    /**
     * Set title
     *
     * @param string $title
     * @return Photo
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
     * Set photoFileName
     *
     * @param string $photoFileName
     * @return Photo
     */
    public function setPhotoFileName($photoFileName)
    {
        $this->photoFileName = $photoFileName;

        return $this;
    }

    /**
     * Get photoFileName
     *
     * @return string 
     */
    public function getPhotoFileName()
    {
        return $this->photoFileName;
    }

    /**
     * Set country
     *
     * @param \Siplo\MediaBundle\Entity\Country $country
     * @return Photo
     */
    public function setCountry(\Siplo\MediaBundle\Entity\Country $country = null)
    {
        $this->country = $country;

        return $this;
    }

    /**
     * Get country
     *
     * @return \Siplo\MediaBundle\Entity\Country 
     */
    public function getCountry()
    {
        return $this->country;
    }

    /**
     * Set category
     *
     * @param \Siplo\MediaBundle\Entity\Category $category
     * @return Photo
     */
    public function setCategory(\Siplo\MediaBundle\Entity\Category $category = null)
    {
        $this->category = $category;

        return $this;
    }

    /**
     * Get category
     *
     * @return \Siplo\MediaBundle\Entity\Category 
     */
    public function getCategory()
    {
        return $this->category;
    }

    /**
     * Set user
     *
     * @param \Siplo\UserBundle\Entity\SiploUser $user
     * @return Photo
     */
    public function setUser(\Siplo\UserBundle\Entity\SiploUser $user = null)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * Get user
     *
     * @return \Siplo\UserBundle\Entity\SiploUser 
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * Set authorised
     *
     * @param boolean $authorised
     * @return Photo
     */
    public function setAuthorised($authorised)
    {
        $this->authorised = $authorised;

        return $this;
    }

    /**
     * Get authorised
     *
     * @return boolean 
     */
    public function getAuthorised()
    {
        return $this->authorised;
    }

    /**
     * Set rating
     *
     * @param string $rating
     * @return Photo
     */
    public function setRating($rating)
    {
        $this->rating = $rating;

        return $this;
    }

    /**
     * Get rating
     *
     * @return string 
     */
    public function getRating()
    {
        return $this->rating;
    }

    /**
     * Set subCategory
     *
     * @param \Siplo\MediaBundle\Entity\SubCategory $subCategory
     * @return Photo
     */
    public function setSubCategory(\Siplo\MediaBundle\Entity\SubCategory $subCategory = null)
    {
        $this->subCategory = $subCategory;

        return $this;
    }

    /**
     * Get subCategory
     *
     * @return \Siplo\MediaBundle\Entity\SubCategory 
     */
    public function getSubCategory()
    {
        return $this->subCategory;
    }
}
