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

//    Action to play video when admin requested
    public function playAction(){
        $id = $this->request->query->get('id');
        $video = $this->em->getRepository('SiploMediaBundle:Video')->find($id);
        return $this->render('AppBundle::video_preview.html.twig', array(
            'video' => $video,
        ));
    }
}