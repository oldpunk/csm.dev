<?php

namespace Admin\CommonBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

class DefaultController extends Controller
{
    /**
     * @Route("/")
     */
    public function indexAction()
    {
        return $this->render('AdminCommonBundle:Default:index.html.twig');
    }

    public function loginAction()
    {
        $authutils = $this->get('security.authentication_utils');

        $error = $authutils->getLastAuthenticationError();
        $name = $authutils->getLastUsername();

        return $this->render(
            'AdminCommonBundle:Default:login.html.twig',
            array(
                'name'=>$name,
                'error'=>$error
            )
        );
    }

}
