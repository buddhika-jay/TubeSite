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
     * @var string
     *
     * @ORM\Column(name="code", type="string", length=255)
     */
    private $code;

    /**
     * NOTE: This is not a mapped field of entity metadata, just a simple property.
     *
     * @Vich\UploadableField(mapping="country_background", fileNameProperty="backgroundImageFileName")
     *
     * @var File
     */
    private $backgroundImage;

    /**
     * @var string
     *
     * @ORM\Column(name="backgroundImage_filename", type="string", length=255)
     */
    private $backgroundImageFileName;

    /**
     *
     * @Vich\UploadableField(mapping="country_flag", fileNameProperty="flagFileName")
     *
     * @var File
     */
    private $flag;

    /**
     * @var string
     *
     * @ORM\Column(name="flag_filename", type="string", length=255)
     */
    private $flagFileName;

    /**
     * @ORM\Column(type="datetime")
     *
     * @var \DateTime
     */
    private $updatedAt;

    /**
     * @ORM\OneToMany(targetEntity="Photo", mappedBy="country")
     **/
    private $photos;

    /**
     * @ORM\OneToMany(targetEntity="Video", mappedBy="country")
     **/
    private $videos;


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
     * Set code
     *
     * @param string $code
     * @return Country
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

    public function setFlag(File $flag = null)
    {
        $this->flag = $flag;

        if ($flag) {
            // It is required that at least one field changes if you are using doctrine
            // otherwise the event listeners won't be called and the file is lost
            $this->updatedAt = new \DateTime('now');
        }
    }

    /**
     * @return File
     */
    public function getFlag()
    {
        return $this->flag;
    }

    /**
     * Set updatedAt
     *
     * @param \DateTime $updatedAt
     * @return Country
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
     * Set backgroundImageFileName
     *
     * @param string $backgroundImageFileName
     * @return Country
     */
    public function setBackgroundImageFileName($backgroundImageFileName)
    {
        $this->backgroundImageFileName = $backgroundImageFileName;

        return $this;
    }

    /**
     * Get backgroundImageFileName
     *
     * @return string 
     */
    public function getBackgroundImageFileName()
    {
        return $this->backgroundImageFileName;
    }

    /**
     * Set flagFileName
     *
     * @param string $flagFileName
     * @return Country
     */
    public function setFlagFileName($flagFileName)
    {
        $this->flagFileName = $flagFileName;

        return $this;
    }

    /**
     * Get flagFileName
     *
     * @return string 
     */
    public function getFlagFileName()
    {
        return $this->flagFileName;
    }

    public function __construct() {
        $this->photos = new ArrayCollection();
    }

    /**
     * Add photos
     *
     * @param \Siplo\MediaBundle\Entity\Photo $photos
     * @return Country
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
     * @return Country
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
}
