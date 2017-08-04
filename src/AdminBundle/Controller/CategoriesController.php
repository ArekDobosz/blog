<?php

namespace AdminBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;

use AutoSerwisBundle\Entity\Category;
use AdminBundle\Form\TagCategoryType;
use AutoSerwisBundle\Entity\Post;

class CategoriesController extends Controller
{
    /**
     * @Route(
     *      "/{page}",
     *      name="admin_categories",
     *      defaults = {"page" = 1},
     *      requirements = {"page" = "\d+"}
     * )
     */
    public function indexAction($page)
    {
        $Categories = $this->getDoctrine()->getRepository('AutoSerwisBundle:Category')->getQueryBuilder();
        
        $paginator = $this->get('knp_paginator');
        $pagination = $paginator->paginate($Categories, $page, 10);
        
        return $this->render('AdminBundle:Taxonomy:index.html.twig', array(
            'pagination' => $pagination,
            'taxPath' => 'admin_category_edit',
            'taxName' => 'Kategorie',
            'deletePath' => 'admin_category_delete'
        ));
    }
    
    /**
     * @Route(
     *      "/edit/{id}",
     *      name="admin_category_edit"
     * )
     */
    public function editAction(Request $request, $id = null) {
        
        if($id == null) {
            $Category = new Category();
            $newForm = true;
        } else {
            $Category = $this->getDoctrine()->getRepository('AutoSerwisBundle:Category')->find($id);
            if($Category == null) {
                throw $this->createNotFoundException('Nie odnaleziono kategorii.');
            }
        }
        
        $form = $this->createForm(TagCategoryType::class, $Category);
        
        if($request->isMethod('POST')){
            $form->handleRequest($request);
            if($form->isValid() && $form->isSubmitted()) {
                $em = $this->getDoctrine()->getManager();
                $em->persist($Category);
                $em->flush();
                
                $msg = isset($msg) ? 'Kategoria została dodana' : 'Kategoria została zaktualizowana';
                $this->get('session')->getFlashBag()->add('success', $msg);
                
                return $this->redirectToRoute('admin_categories');
            }
        }
        
        return $this->render('AdminBundle:Taxonomy:edit.html.twig', array(
            'form' => $form->createView(),
            'taxonomyName' => 'Kategorie',
            'setClass' => 'admin_categories'
        ));
    }
    
    /**
     * @Route(
     *      "/delete/{id}",
     *      name="admin_category_delete"
     * )
     */
    public function deleteAction(Request $request, Category $Category) {
        
        if($Category == null) throw $this->createNotFoundException ('Nie znaleziono kategorii.');
        
        if(!$this->isCsrfTokenValid('deleteTax-'.$Category->getId(), $request->get('token'))) {
            $this->get('session')->getFlashBag()->add('danger', 'Błędny token akcji.');
            return $this->redirectToRoute('admin_categories');
        }
        
        $Posts = $this->getDoctrine()->getRepository('AutoSerwisBundle:Post')->getQueryBuilder(array('category' => $Category->getName()));
        
        $em = $this->getDoctrine()->getManager();
        
        foreach($Posts as $Post){
            $Post->setCategory(null);
            $em->persist($Post);
        }
        
        $em->remove($Category);
        $em->flush();
        
        $this->get('session')->getFlashBag()->add('success', 'Kategoria "'.$Category->getName().'" została usunięta. Posty powiązane z kategorią zostały ustawione na "Bez kategorii."');
        
        return $this->redirectToRoute('admin_categories');       
    }
}
