<?php

namespace AutoSerwisBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;

use AutoSerwisBundle\Form\ContactType;

class ContactController extends Controller{
    
    /**
     * @Route(
     *      "/",
     *      name="blog_contact"
     * )
     */
    public function showFormAction() {
        
        $form = $this->createForm(ContactType::class);
        
        return $this->render('AutoSerwisBundle:Contact:showForm.html.twig', array(
            'form' => $form->createView()
        ));
    }
    
}
