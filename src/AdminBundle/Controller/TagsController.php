<?php

namespace AdminBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;

use AutoSerwisBundle\Entity\Tag;
use AdminBundle\Form\TagCategoryType;

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
    public function indexAction(Request $request, $page, $id = null)
    {
        $Tags = $this->getDoctrine()->getRepository('AutoSerwisBundle:Tag')->getQueryBuilder();
        
        $paginator = $this->get('knp_paginator');
        $pagination = $paginator->paginate($Tags, $page, 10);
        
        return $this->render('AdminBundle:Taxonomy:index.html.twig', array(
            'pagination' => $pagination,
            'taxPath' => 'admin_tag_edit',
            'taxName' => 'Tagi',
            'deletePath' => 'admin_tag_delete'
        ));
    }
    
    /**
     * @Route(
     *      "/edit/{id}",
     *      name = "admin_tag_edit",
     * )
     */
    public function editTag(Request $request, $id = null){
        
        if($id == null) {
            $Tag = new Tag();
            $newForm = true;
        } else {
            $Tag = $this->getDoctrine()->getRepository('AutoSerwisBundle:Tag')->find($id);
            if($Tag == null) {
                throw $this->createNotFoundException('Nie znaleziono tagu.');
            }
        }
                
        $form = $this->createForm(TagCategoryType::class, $Tag);
        
        if($request->isMethod('POST')){
            $form->handleRequest($request);
            if($form->isValid() && $form->isSubmitted()){
                $em = $this->getDoctrine()->getManager();
                $em->persist($Tag);
                $em->flush();
                
                $msg = isset($newForm) ? 'Tag został dodany do bazy.' : 'Zmiany zostały zapisane.';
                $this->get('session')->getFlashBag()->add('success', $msg);
                return $this->redirectToRoute('admin_tags');
            }
        }
        
        return $this->render('AdminBundle:Taxonomy:edit.html.twig', array(
            'form' => $form->createView(),
            'taxonomyName' => 'Tag'
        ));      
    }
    
    /**
     * @Route(
     *      "/delete/{id}",
     *      name="admin_tag_delete"
     * )
     */
    public function deleteAction(Tag $Tag) {
        
        if($Tag == null) throw $this->createNotFoundException ('Nie znaleziono tagu.');
        
        $em = $this->getDoctrine()->getManager();
        $em->remove($Tag);
        $em->flush();
        
        $this->get('session')->getFlashBag()->add('success', 'Tag "'.$Tag->getName().'" został usunięty.');
        
        return $this->redirectToRoute('admin_tags');
    }
}
