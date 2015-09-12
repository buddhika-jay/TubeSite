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


    public function setPhoto(Photo $photo)
    {
        $this->photo = $photo;
    }

    public function getPhoto()
    {
        return $this->photo;
    }


}