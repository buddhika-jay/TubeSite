<?php

namespace Siplo\UserBundle\Entity;


use FOS\UserBundle\Entity\User as BaseUser;
use Doctrine\ORM\Mapping as ORM;

use Doctrine\Common\Collections\ArrayCollection;

/**
 * User
 *
 * @ORM\Table()
 * @ORM\Entity
 */
class SiploUser extends BaseUser
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @var string
     *
     * @ORM\Column(name="avatar", type="string", length=255)
     */
    private $avatar = "Hello";

    /**
     * @ORM\OneToMany(targetEntity="Siplo\MediaBundle\Entity\Photo", mappedBy="user")
     **/
    private $photos;

    /**
     * @ORM\OneToMany(targetEntity="Siplo\MediaBundle\Entity\Video", mappedBy="user")
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
     * Set avatar
     *
     * @param string $avatar
     * @return User
     */
    public function setAvatar($avatar)
    {
        $this->avatar = $avatar;

        return $this;
    }

    /**
     * Get avatar
     *
     * @return string 
     */
    public function getAvatar()
    {
        return $this->avatar;
    }

    public function __construct() {
        parent::__construct();
        $this->photos = new ArrayCollection();
        $this->videos = new ArrayCollection();
    }



    /**
     * Add photos
     *
     * @param \Siplo\MediaBundle\Entity\Photo $photos
     * @return SiploUser
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
     * @return SiploUser
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
