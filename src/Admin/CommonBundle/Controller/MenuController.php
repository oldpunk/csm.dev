<?php

namespace Admin\CommonBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class MenuController extends Controller
{
    public function indexAction(Request $request)
    {
        $path = $request->get('_route');

        return $this->render('AdminCommonBundle:Menu:menu.html.twig', array(
            'path'=> $path
        ));
    }
}
