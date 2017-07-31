<?php

namespace AutoSerwisBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;

use AutoSerwisBundle\Form\ContactType;

class ContactController extends Controller{
    
    private $blogEmail = 'botblackd988@gmail.com';
    
    /**
     * @Route(
     *      "/",
     *      name="blog_contact"
     * )
     */
    public function showFormAction(Request $request) {
        
        $form = $this->createForm(ContactType::class);
        
        if($request->isMethod('POST')){
            $form->handleRequest($request);
            if($form->isValid() && $form->isSubmitted()){
                
                $name = $form->get('name')->getData();
                $email = $form->get('email')->getData();
                $msg = $form->get('msg')->getData();
                
                $message = (new \Swift_Message('Pytanie z bloga'))
                        ->setFrom($email)
                        ->setTo($this->blogEmail)
                        ->setBody(
                            $this->renderView(
                                'AutoSerwisBundle:Email:email.html.twig',
                                array(
                                    'name' => $name,
                                    'msg' => $msg
                                )    
                            ),
                            'text/html'
                        );
                
                $this->get('mailer')->send($message);
                
                $this->get('session')->getFlashBag()->add('success', 'Wiadomość została wysłana.');
                return $this->redirectToRoute('blog_contact');
            }
        }
        
        return $this->render('AutoSerwisBundle:Contact:showForm.html.twig', array(
            'form' => $form->createView()
        ));
    }
    
}
