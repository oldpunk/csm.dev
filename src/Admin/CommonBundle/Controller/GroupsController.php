<?php

namespace Admin\CommonBundle\Controller;

use Admin\CommonBundle\Entity\Groups;
use Admin\CommonBundle\Form\GroupsType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class GroupsController extends Controller
{
    public function indexAction()
    {
        $repository = $this->getDoctrine()->getRepository('AdminCommonBundle:Groups');

        $groups = $repository->findAll();

        return $this->render('AdminCommonBundle:Groups:index.html.twig', array('groups' => $groups));
    }

    public function addAction(Request $request)
    {
        $group = new Groups();

        $form = $this->createForm(new GroupsType(), $group);
        $form->handleRequest($request);

        if($form->isValid()){
            $em = $this->getDoctrine()->getManager();
            $em->persist($group);
            $em->flush();

            $this->addFlash('notice', 'Запись успешно добавлена');

            return $this->redirectToRoute('admin_groups');
        }

        return $this->render('AdminCommonBundle:Form/Common:add-edit.html.twig', array(
            'form' => $form->createView(),
            'title' => 'Добавление Группы',
            'itemsArray' => array(
                'Группы' => $this->generateUrl('admin_groups'),
                'Добавление группы' => null
            ),
            'backPath' => 'admin_groups'
        ));
    }

    public function editAction(Request $request, $id)
    {
        $repository = $this->getDoctrine()->getRepository('AdminCommonBundle:Groups');
        $group = $repository->find($id);

        if(!$group){
            throw $this->createNotFoundException('Данная группа не найдена');
        }

        $form = $this->createForm(new GroupsType(), $group);
        $form->handleRequest($request);

        if($form->isValid()){
            $em = $this->getDoctrine()->getManager();

            $em->persist($group);
            $em->flush();

            $this->addFlash('notice', 'Изменения сохранены');

            return $this->redirectToRoute('admin_groups');
        }

        return $this->render('AdminCommonBundle:Form/Common:add-edit.html.twig', array(
            'form' => $form->createView(),
            'title' => 'Редактирование '.$group->getTitle(),
            'itemsArray' => array(
                'Группы' => $this->generateUrl('admin_groups'),
                $group->getTitle() => null
            ),
            'backPath' => 'admin_groups'
        ));
    }

    public function delAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $repository = $em->getRepository('AdminCommonBundle:Groups');

        $group = $repository->find($id);

        if(!$group){
            throw $this->createNotFoundException('Данная группа не найдена');
        }

        $em->remove($group);
        $em->flush();

        $this->addFlash('notice', 'Запись удалена');

        return $this->redirectToRoute('admin_groups');
    }

}
