<?php
namespace Siplo\MediaBundle\Form\Model;

use Symfony\Component\Validator\Constraints as Assert;

use Siplo\MediaBundle\Entity\Category;

class CategoryUpload
{
    /**
     * @Assert\Type(type="Siplo\MediaBundle\Entity\Category")
     * @Assert\Valid()
     */
    protected $Category;


    public function setCategory(Category $category)
    {
        $this->Category = $category;
    }

    public function getCategory()
    {
        return $this->Category;
    }


}