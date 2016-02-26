<?php

namespace Admin\CommonBundle\Controller;

use Admin\CommonBundle\Entity\Users;
use Admin\CommonBundle\Form\UsersType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class UsersController extends Controller
{
    public function indexAction()
    {
        $repository = $this->getDoctrine()->getRepository('AdminCommonBundle:Users');

        $users = $repository->findAll();

        return $this->render('AdminCommonBundle:Users:index.html.twig', array(
            'users' => $users
        ));
    }

    public function addAction(Request $request)
    {
        $user = new Users();

        $form = $this->createForm(new UsersType(), $user);
        $form->handleRequest($request);

        if($form->isValid()){
            $this->saveUser($user);

            $this->addFlash('notice', 'Запись учпешно добавлена');

            return $this->redirectToRoute('admin_users');
        }

        return $this->render('AdminCommonBundle:Form/Common:add-edit.html.twig', array(
            'form' => $form->createView(),
            'title' => 'Добавление пользователя',
            'itemsArray' => array(
                'Пользователи' => $this->generateUrl('admin_users'),
                'Добавление пользователя' => null
            ),
            'backPath' => 'admin_users'
        ));
    }

    public function editAction(Request $request, $id)
    {
        $repository = $this->getDoctrine()->getRepository('AdminCommonBundle:Users');

        $user = $repository->find($id);

        if(!$user){
            throw $this->createNotFoundException('Пользователь не найден.');
        }

        $form = $this->createForm(new UsersType(), $user);
        $form->handleRequest($request);

        if($form->isValid()){
            $this->saveUser($user);

            $this->addFlash('notice', 'Запись успешно обновлена.');

            return $this->redirectToRoute('admin_users');
        }


        return $this->render('AdminCommonBundle:Form/Common:add-edit.html.twig', array(
            'form' => $form->createView(),
            'title' => 'Редактирование '.$user->getFio(),
            'itemsArray' => array(
                'Пользователи' => $this->generateUrl('admin_users'),
                $user->getFio() => null
            ),
            'backPath' => 'admin_users'
        ));
    }

    public function delAction($id)
    {
        $em = $this->getDoctrine()->getEntityManager();
        $repository = $em->getRepository('AdminCommonBundle:Users');
        $user = $repository->find($id);

        if(!$user){
            throw $this->createNotFoundException('Пользователь не найден.');
        }

        if($user->getId() > 1) {
            $em->remove($user);
            $em->flush();

            $this->addFlash('notice', 'Запись успешно удалена');
        }else{
            $this->addFlash('error', 'Root пользователь не может быть удален');
        }
        return $this->redirectToRoute('admin_users');
    }

    /**
     * @param $user Users
     */
    private function setFile($user)
    {
        $uploader = $this->container->get('admin_common.uploader');

        $uploader->uploadFiles($user);

    }

    /**
     * @param $user Users
     * @return string
     */
    private function encodedPassword($user)
    {
        $encoder = $this->container->get('security.password_encoder');
        $user->setPassword($encoder->encodePassword($user, $user->getPassword()));
    }

    /**
     * @param $user Users
     */
    private function saveUser($user)
    {
        $em = $this->getDoctrine()->getManager();

        $this->setFile($user);
        $this->encodedPassword($user);

        $em->persist($user);
        $em->flush();
    }
}
