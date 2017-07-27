<?php

namespace AdminBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;

use AutoSerwisBundle\Entity\Tag;
use AdminBundle\Form\TagType;

class TagsController extends Controller
{
    /**
     * @Route(
     *      "/{page}",
     *      name="admin_tags",
     *      defaults = {"page" = 1},
     *      requirements = {"page" = "\d+"}
     * )
     */
    public function indexAction(Request $request, $page)
    {
        $Tags = $this->getDoctrine()->getRepository('AutoSerwisBundle:Tag')->getQueryBuilder();
        
        $paginator = $this->get('knp_paginator');
        $pagination = $paginator->paginate($Tags, $page, 20);
        
//        if($request->isMethod('POST')){
//            $Tag = $this->getDoctrine()->getRepository('AutoSerwisBundle:Tag')->find(50);
//            $Tag->setName($request->request->all['tag_form']['tag_name']);
//            
//            $em = $this->getDoctrine()->getManager();
//            $em->persist($Tag);
//            $em->flush();
//            
//            $this->redirectToRoute('admin_tags');
//        }
        
        return $this->render('AdminBundle:Tags:index.html.twig', array(
            'pagination' => $pagination 
        ));
    }
    
    /**
     * @Route(
     *      "/edit/{id}",
     *      name = "admin_tag_edit",
     * )
     */
    public function editTag(Request $request, $id){
        
        if($id == null) {
            $Tag = new Tag();
            $newForm = true;
        } else {
            $Tag = $this->getDoctrine()->getRepository('AutoSerwisBundle:Tag')->find($id);
        }
        
        if($Tag == null) {
            throw $this->createNotFoundException('Nie znaleziono tagu.');
        }
        
        $form = $this->createForm(TagType::class, $Tag);
        
        if($request->isMethod('POST')){
            $form->handleRequest($request);
            if($form->isValid() && $form->isSubmitted()){
                $em = $this->getDoctrine()->getManager();
                $em->persist($Tag);
                $em->flush();
                
                $msg = isset($newForm) ? 'Tag został dodany do bazy.' : 'Zmiany zostały zapisane.';
                $this->get('session')->getFlashBag()->add('success', $msg);
            }
        }
        
        return $this->render('AdminBundle:Tags:edit.html.twig', array(
            'form' => $form->createView()
        ));
        
    }
}
