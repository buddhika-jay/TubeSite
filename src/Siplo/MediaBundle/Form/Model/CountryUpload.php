<?php
namespace Siplo\MediaBundle\Form\Model;

use Symfony\Component\Validator\Constraints as Assert;

use Siplo\MediaBundle\Entity\Country;

class CountryUpload
{
    /**
     * @Assert\Type(type="Siplo\MediaBundle\Entity\Country")
     * @Assert\Valid()
     */
    protected $Country;


    public function setCountry(Country $country)
    {
        $this->Country = $country;
    }

    public function getCountry()
    {
        return $this->Country;
    }


}