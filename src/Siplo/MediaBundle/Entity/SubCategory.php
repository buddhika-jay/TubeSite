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
class SubCategory
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
     * @ORM\Column(name="code", type="string", length=255, nullable=true)
     */
    private $code;



    /**
     * @var string
     *
     * @ORM\Column(name="description", type="string", length=2000)
     */
    private $description;

    /**
     * NOTE: This is not a mapped field of entity metadata, just a simple property.
     *
     * @Vich\UploadableField(mapping="sub_category_background", fileNameProperty="background_filename")
     *
     * @var File
     */
    private $backgroundImage;

    /**
     * @var string
     *
     * @ORM\Column(name="background_filename", type="string", length=255)
     */
    private $backgroundFileName;

    /**
     * @ORM\ManyToOne(targetEntity="Category", inversedBy="subCategories")
     * @ORM\JoinColumn(name="category_id", referencedColumnName="id")
     **/
    private $category;

    /**
     * @ORM\ManyToOne(targetEntity="Country", inversedBy="subCategories")
     * @ORM\JoinColumn(name="country_id", referencedColumnName="id")
     **/
    private $country;

    /**
     * @ORM\OneToMany(targetEntity="Photo", mappedBy="subCategory")
     **/
    private $photos;

    /**
     * @ORM\OneToMany(targetEntity="Video", mappedBy="subCategory")
     **/
    private $videos;

    /**
     * @ORM\OneToMany(targetEntity="FurtherDetails", mappedBy="subCategory")
     **/
    private $furtherDetails;

    public function __construct()
    {
        $this->photos = new ArrayCollection();
        $this->videos = new ArrayCollection();
        $this->furtherDetails = new ArrayCollection();
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
     * Set description
     *
     * @param string $description
     * @return SubCategory
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
     * Set description2
     *
     * @param string $description2
     * @return SubCategory
     */
    public function setDescription2($description2)
    {
        $this->description2 = $description2;

        return $this;
    }

    /**
     * Get description2
     *
     * @return string 
     */
    public function getDescription2()
    {
        return $this->description2;
    }

    /**
     * Set backgroundFileName
     *
     * @param string $backgroundFileName
     * @return SubCategory
     */
    public function setBackgroundFileName($backgroundFileName)
    {
        $this->backgroundFileName = $backgroundFileName;

        return $this;
    }

    /**
     * Get backgroundFileName
     *
     * @return string 
     */
    public function getBackgroundFileName()
    {
        return $this->backgroundFileName;
    }

    /**
     * Set category
     *
     * @param \Siplo\MediaBundle\Entity\Category $category
     * @return SubCategory
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
     * Set country
     *
     * @param \Siplo\MediaBundle\Entity\Country $country
     * @return SubCategory
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
     * Add photos
     *
     * @param \Siplo\MediaBundle\Entity\Photo $photos
     * @return SubCategory
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
     * @return SubCategory
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

    /**
     * Set title
     *
     * @param string $title
     * @return SubCategory
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
     * @return SubCategory
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

    public function __toString() {
        return $this->title;
    }

    /**
     * Add furtherDetails
     *
     * @param \Siplo\MediaBundle\Entity\FurtherDetails $furtherDetails
     * @return SubCategory
     */
    public function addFurtherDetail(\Siplo\MediaBundle\Entity\FurtherDetails $furtherDetails)
    {
        $this->furtherDetails[] = $furtherDetails;

        return $this;
    }

    /**
     * Remove furtherDetails
     *
     * @param \Siplo\MediaBundle\Entity\FurtherDetails $furtherDetails
     */
    public function removeFurtherDetail(\Siplo\MediaBundle\Entity\FurtherDetails $furtherDetails)
    {
        $this->furtherDetails->removeElement($furtherDetails);
    }

    /**
     * Get furtherDetails
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getFurtherDetails()
    {
        return $this->furtherDetails;
    }
}
