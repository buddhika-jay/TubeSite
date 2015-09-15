<?php
namespace Siplo\MediaBundle\Form\Model;

use Symfony\Component\Validator\Constraints as Assert;

use Siplo\MediaBundle\Entity\Photo;

class PhotoUpload
{
    /**
     * @Assert\Type(type="Siplo\MediaBundle\Entity\Photo")
     * @Assert\Valid()
     */
    protected $photo;
    private $user;


    public function setPhoto(Photo $photo)
    {
        $this->photo = $photo;
        $photo->setUser($this->user);
    }

    public function getPhoto()
    {
        return $this->photo;
    }

    public function __construct($user){
        $this->user=$user;
    }


}