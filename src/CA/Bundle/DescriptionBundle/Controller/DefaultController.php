<?php

namespace CA\Bundle\DescriptionBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction($name)
    {
        return $this->render('CADescriptionBundle:Default:index.html.twig', array('name' => $name));
    }
}
