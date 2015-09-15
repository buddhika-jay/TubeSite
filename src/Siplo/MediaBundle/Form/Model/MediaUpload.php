<?php
/**
 * Created by PhpStorm.
 * User: buddhika
 * Date: 9/15/15
 * Time: 10:19 AM
 */

namespace Siplo\MediaBundle\Form\Model;


class MediaUpload
{
    private $user;
    public function __construct($user){
        $this->user=$user;
    }
}