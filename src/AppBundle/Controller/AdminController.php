<?php
/**
 * Created by PhpStorm.
 * User: buddhika
 * Date: 9/13/15
 * Time: 9:38 PM
 */

namespace AppBundle\Controller;
use JavierEguiluz\Bundle\EasyAdminBundle\Controller\AdminController as BaseAdminController;
use Siplo\UserBundle\Entity\SiploUser as User;


class AdminController extends  BaseAdminController
{
    public function createNewUsersEntity()
    {
        return $this->container->get('fos_user.user_manager')->createUser();
    }

    public function prePersistUsersEntity(User $user)
    {
        $this->container->get('fos_user.user_manager')->updateUser($user, false);
    }

    public function preUpdateUsersEntity(User $user)
    {
        $this->container->get('fos_user.user_manager')->updateUser($user, false);
    }
}