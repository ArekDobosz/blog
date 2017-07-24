<?php

namespace AdminBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

class TagsController extends Controller
{
    /**
     * @Route(
     *      "/",
     *      name="admin_tags"
     * )
     */
    public function indexAction()
    {
        return $this->render('AdminBundle:Tags:index.html.twig');
    }
}
