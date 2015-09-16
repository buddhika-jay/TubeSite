<?php

namespace Siplo\MediaBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\File;
use Vich\UploaderBundle\Mapping\Annotation as Vich;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * @ORM\Entity
 * @Vich\Uploadable
 */
class Category
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
     * @var string
     *
     * @ORM\Column(name="background_filename", type="string", length=255)
     */
    private $backgroundFileName;

    /**
     * @ORM\OneToMany(targetEntity="Photo", mappedBy="category")
     **/
    private $photos;

    /**
     * @ORM\OneToMany(targetEntity="Video", mappedBy="category")
     **/
    private $videos;

    /**
     * @ORM\OneToMany(targetEntity="SubCategory", mappedBy="category")
     **/
    private $subCategories;

    /**
     * @ORM\ManyToMany(targetEntity="Country", mappedBy="categories")
     **/
    private $countries;


    /**
     * @return string
     */
    public function getBackgroundFileName()
    {
        return $this->backgroundFileName;
    }

    /**
     * @param string $backgroundFileName
     */
    public function setBackgroundFileName($backgroundFileName)
    {
        $this->backgroundFileName = $backgroundFileName;
    }

    /**
     * @var string
     *
     * @ORM\Column(name="code", type="string", length=255)
     */
    private $code;


    /**
     * @ORM\Column(type="datetime")
     *
     * @var \DateTime
     */
    private $updatedAt;

    /**
     * NOTE: This is not a mapped field of entity metadata, just a simple property.
     *
     * @Vich\UploadableField(mapping="category_background", fileNameProperty="background_filename")
     *
     * @var File
     */
    private $backgroundImage;

    /**
     * If manually uploading a file (i.e. not using Symfony Form) ensure an instance
     * of 'UploadedFile' is injected into this setter to trigger the  update. If this
     * bundle's configuration parameter 'inject_on_load' is set to 'true' this setter
     * must be able to accept an instance of 'File' as the bundle will inject one here
     * during Doctrine hydration.
     *
     * @param File|\Symfony\Component\HttpFoundation\File\UploadedFile $image
     */
    public function setBackgroundImage(File $image = null)
    {
        $this->backgroundImage = $image;

        if ($image) {
            // It is required that at least one field changes if you are using doctrine
            // otherwise the event listeners won't be called and the file is lost
            $this->updatedAt = new \DateTime('now');
        }
    }

    /**
     * @return File
     */
    public function getBackgroundImage()
    {
        return $this->backgroundImage;
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
     * @return Category
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
     * Set code
     *
     * @param string $code
     * @return Category
     */
    public function setCode($code)
    {
        $this->code = $code;

        return $this;
    }

    /**
     * Get code
     *
     * @return string 
     */
    public function getCode()
    {
        return $this->code;
    }

    /**
     * Set updatedAt
     *
     * @param \DateTime $updatedAt
     * @return Category
     */
    public function setUpdatedAt($updatedAt)
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    /**
     * Get updatedAt
     *
     * @return \DateTime 
     */
    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->photos = new ArrayCollection();
        $this->videos = new ArrayCollection();
        $this->countries = new ArrayCollection();
        $this->subCategories = new ArrayCollection();
    }

    /**
     * Add photos
     *
     * @param \Siplo\MediaBundle\Entity\Photo $photos
     * @return Category
     */
    public function addPhoto(\Siplo\MediaBundle\Entity\Photo $photos)
    {
        $this->photos[] = $photos;

        return $this;
    }

    /**
     * Remove photos
     *
     * @param \Siplo\MediaBundle\Entity\Photo $photos
     */
    public function removePhoto(\Siplo\MediaBundle\Entity\Photo $photos)
    {
        $this->photos->removeElement($photos);
    }

    /**
     * Get photos
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getPhotos()
    {
        return $this->photos;
    }

    /**
     * Add videos
     *
     * @param \Siplo\MediaBundle\Entity\Video $videos
     * @return Category
     */
    public function addVideo(\Siplo\MediaBundle\Entity\Video $videos)
    {
        $this->videos[] = $videos;

        return $this;
    }

    /**
     * Remove videos
     *
     * @param \Siplo\MediaBundle\Entity\Video $videos
     */
    public function removeVideo(\Siplo\MediaBundle\Entity\Video $videos)
    {
        $this->videos->removeElement($videos);
    }

    /**
     * Get videos
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getVideos()
    {
        return $this->videos;
    }

    public function __toString() {
        return $this->title;
    }

    /**
     * Add countries
     *
     * @param \Siplo\MediaBundle\Entity\Country $countries
     * @return Category
     */
    public function addCountry(\Siplo\MediaBundle\Entity\Country $countries)
    {
        $this->countries[] = $countries;

        return $this;
    }

    /**
     * Remove countries
     *
     * @param \Siplo\MediaBundle\Entity\Country $countries
     */
    public function removeCountry(\Siplo\MediaBundle\Entity\Country $countries)
    {
        $this->countries->removeElement($countries);
    }

    /**
     * Get countries
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getCountries()
    {
        return $this->countries;
    }

    /**
     * Add subCategories
     *
     * @param \Siplo\MediaBundle\Entity\SubCategory $subCategories
     * @return Category
     */
    public function addSubCategory(\Siplo\MediaBundle\Entity\SubCategory $subCategories)
    {
        $this->subCategories[] = $subCategories;

        return $this;
    }

    /**
     * Remove subCategories
     *
     * @param \Siplo\MediaBundle\Entity\SubCategory $subCategories
     */
    public function removeSubCategory(\Siplo\MediaBundle\Entity\SubCategory $subCategories)
    {
        $this->subCategories->removeElement($subCategories);
    }

    /**
     * Get subCategories
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getSubCategories()
    {
        return $this->subCategories;
    }
}
