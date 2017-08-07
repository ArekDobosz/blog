<?php

namespace AdminBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use AdminBundle\Form\UsersType;

class UsersController extends Controller {
    
    /**
     * @Route(
     *      "/users/{page}",
     *      name="admin_users",
     *      defaults = {"page" = 1},
     *      requirements = {"page" = "\d+"}
     * )
     */
    public function indexAction($page){
        $Users = $this->get('fos_user.user_manager')->findUsers();
        
        $paginator = $this->get('knp_paginator');
        $pagination = $paginator->paginate($Users, $page, 5);
        
        return $this->render('AdminBundle:Users:index.html.twig', array(
            'pagination' => $pagination
        ));
    }
    
    /**
     * @Route(
     *      "/edit/{id}",
     *      name="admin_user_edit"
     * )
     */
    public function editAction(Request $request, $id) {
        $User = $this->get('fos_user.user_manager')->findUserBy(array('id' => $id));
        if($User == null) {
            throw $this->createNotFoundException('Nie znaleziono użytkownika.');
        }
        
        $form = $this->createForm(UsersType::class, $User);
        
        if($request->isMethod('POST')){
            $form->handleRequest($request);
            if($form->isValid() && $form->isSubmitted()) {
                $em = $this->getDoctrine()->getManager();
                $em->persist($User);
                $em->flush();
                
                $this->get('session')->getFlashBag()->add('success', 'Zmiany zostały zapisane.');
                return $this->redirectToRoute('admin_user_edit', array('id' => $User->getId()));
            }
        }
        
        return $this->render('AdminBundle:Users:edit.html.twig', array(
           'form' => $form->createView(),
            'setClass' => 'admin_users'
        ));
        
    }
    
}
