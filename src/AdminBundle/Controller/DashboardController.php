<?php

namespace AdminBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

class DashboardController extends Controller
{
    /**
     * @Route(
     *      "/",
     *      name="admin_dashboard"
     * )
     */
    public function indexAction()
    {
        return $this->render('AdminBundle:Dashboard:index.html.twig', array(
            'active' => 'admin_dashboard'
        ));
    }
}
