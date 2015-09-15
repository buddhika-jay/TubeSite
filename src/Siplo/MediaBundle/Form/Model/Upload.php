<?php
namespace Siplo\MediaBundle\Form\Model;

use Symfony\Component\Validator\Constraints as Assert;

use Siplo\MediaBundle\Entity\Video;

class Upload
{
    /**
     * @Assert\Type(type="Siplo\MediaBundle\Entity\Video")
     * @Assert\Valid()
     */
    protected $Video;
    private $user;


    public function setVideo(Video $video)
    {
        $video->setUser($this->user);
        $this->Video = $video;
    }

    public function getVideo()
    {
        return $this->Video;
    }

    public function __construct($user){
        $this->user=$user;
    }
}