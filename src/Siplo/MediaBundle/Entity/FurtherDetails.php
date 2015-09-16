<?php

namespace Siplo\MediaBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * FurtherDetails
 *
 * @ORM\Table()
 * @ORM\Entity
 */
class FurtherDetails
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
     * @ORM\ManyToOne(targetEntity="SubCategory", inversedBy="furtherDetails")
     **/
    private $subCategory;

    /**
     * @var string
     *
     * @ORM\Column(name="body", type="string", length=2000)
     */
    private $body;


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
     * Set body
     *
     * @param string $body
     * @return FurtherDetails
     */
    public function setBody($body)
    {
        $this->body = $body;

        return $this;
    }

    /**
     * Get body
     *
     * @return string 
     */
    public function getBody()
    {
        return $this->body;
    }

    /**
     * Set subCategory
     *
     * @param string $subCategory
     * @return FurtherDetails
     */
    public function setSubCategory($subCategory)
    {
        $this->subCategory = $subCategory;

        return $this;
    }

    /**
     * Get subCategory
     *
     * @return string 
     */
    public function getSubCategory()
    {
        return $this->subCategory;
    }

    public function __toString() {
        return $this->body;
    }
}
