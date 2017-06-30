<?php

namespace AutoSerwisBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

class MainController extends Controller
{
    /**
     * @Route("/")
     */
    public function indexAction()
    {
//        throw new \Exception('nie znaleziono strony');
        return $this->render('AutoSerwisBundle:Main:index.html.twig');
    }
}
