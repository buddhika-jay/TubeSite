<?php

namespace Siplo\UserBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;

class SiploUserBundle extends Bundle
{
    public function getParent(){
        return 'FOSUserBundle';
    }
}
