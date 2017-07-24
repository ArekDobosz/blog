<?php

namespace AdminBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

class CategoriesController extends Controller
{
    /**
     * @Route(
     *      "/",
     *      name="admin_categories"
     * )
     */
    public function indexAction()
    {
        return $this->render('AdminBundle:Categories:index.html.twig', array(
            'active' => 'admin_categories'
        ));
    }
}
