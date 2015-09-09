<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Siplo\MediaBundle\Entity\Video as BaseVideo;

/**
 * AppVideo
 *
 * @ORM\Table()
 * @ORM\Entity
 */
class AppVideo extends BaseVideo
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
     * @ORM\ManyToOne(targetEntity="AppUser", inversedBy="videos")
     **/
    private $user;

    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }
}
