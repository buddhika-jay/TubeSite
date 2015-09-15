<?php
namespace Siplo\MediaBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\File;
use Vich\UploaderBundle\Mapping\Annotation as Vich;

/**
 * @ORM\Entity
 * @Vich\Uploadable
 */
class Video
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    // ..... other fields

    /**
     * NOTE: This is not a mapped field of entity metadata, just a simple property.
     *
     * @Vich\UploadableField(mapping="uploaded_video", fileNameProperty="VideoName")
     *
     * @var File
     */
    private $videoFile;
    /**
     * NOTE: This is not a mapped field of entity metadata, just a simple property.
     *
     * @Vich\UploadableField(mapping="video_thumbnail", fileNameProperty="thumbName")
     *
     * @var File
     */
    private $thumbnail;

    /**
     * @ORM\Column(type="string", length=255)
     *
     * @var string
     */
    private $VideoTitle;

    /**
     * @var bool
     * @ORM\Column(name="authorised", type="boolean")
     */
    private $authorised = false;

    /**
     * @ORM\ManyToOne(targetEntity="Country", inversedBy="videos")
     * @ORM\JoinColumn(name="country_id", referencedColumnName="id")
     **/
    private $country;

    /**
     * @ORM\ManyToOne(targetEntity="Category", inversedBy="videos")
     * @ORM\JoinColumn(name="category_id", referencedColumnName="id")
     **/
    private $category;

    /**
     * @ORM\ManyToOne(targetEntity="Siplo\UserBundle\Entity\SiploUser", inversedBy="photos")
     **/
    private $user;

    /**
     * @ORM\Column(type="string", length=255)
     *
     * @var string
     */
    private $videoName;

    /**
     * @ORM\Column(type="string", length=255)
     *
     * @var string
     */
    private $thumbName='thumb';


    /**
     * @ORM\Column(type="datetime")
     *
     * @var \DateTime
     */
    private $updatedAt;

    /**
     * @return string
     */
    public function getVideoTitle()
    {
        return $this->VideoTitle;
    }

    /**
     * @param string $VideoTitle
     */
    public function setVideoTitle($VideoTitle)
    {
        $this->VideoTitle = $VideoTitle;
    }


    /**
     * @return string
     */
    public function getThumbName()
    {
        return $this->thumbName;
    }

    /**
     * @param string $thumbName
     */
    public function setThumbName($thumbName)
    {
        $this->thumbName = $thumbName;
    }

    /**
     * @return File
     */
    public function getThumbnail()
    {
        return $this->thumbnail;
    }

    /**
     * If manually uploading a file (i.e. not using Symfony Form) ensure an instance
     * of 'UploadedFile' is injected into this setter to trigger the  update. If this
     * bundle's configuration parameter 'inject_on_load' is set to 'true' this setter
     * must be able to accept an instance of 'File' as the bundle will inject one here
     * during Doctrine hydration.
     *
     * @param File|\Symfony\Component\HttpFoundation\File\UploadedFile $thumbnail
     */
    public function setThumbnail($thumbnail)
    {
        $this->thumbnail = $thumbnail;
        if ($thumbnail) {
            // It is required that at least one field changes if you are using doctrine
            // otherwise the event listeners won't be called and the file is lost
            $this->updatedAt = new \DateTime('now');
        }
    }


    /**
     * If manually uploading a file (i.e. not using Symfony Form) ensure an instance
     * of 'UploadedFile' is injected into this setter to trigger the  update. If this
     * bundle's configuration parameter 'inject_on_load' is set to 'true' this setter
     * must be able to accept an instance of 'File' as the bundle will inject one here
     * during Doctrine hydration.
     *
     * @param File|\Symfony\Component\HttpFoundation\File\UploadedFile $video
     */
    public function setVideoFile(File $video = null)
    {
        $this->videoFile = $video;

        if ($video) {
            // It is required that at least one field changes if you are using doctrine
            // otherwise the event listeners won't be called and the file is lost
            $this->updatedAt = new \DateTime('now');
        }
    }

    /**
     * @return File
     */
    public function getVideoFile()
    {
        return $this->videoFile;
    }

    /**
     * @param string $videoName
     */
    public function setVideoName($videoName)
    {
        $this->videoName = $videoName;
    }

    /**
     * @return string
     */
    public function getVideoName()
    {
        return $this->videoName;
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
     * Set updatedAt
     *
     * @param \DateTime $updatedAt
     * @return Video
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
     * Set country
     *
     * @param \Siplo\MediaBundle\Entity\Country $country
     * @return Video
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
     * @return Video
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
     * @return Video
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
     * @return Video
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
}
