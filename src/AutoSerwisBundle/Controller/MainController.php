<?php

namespace AutoSerwisBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

class MainController extends Controller
{
    /**
     * @Route("/main")
     */
    public function indexAction()
    {
        return $this->render('AutoSerwisBundle:Main:index.html.twig');
    }
}
