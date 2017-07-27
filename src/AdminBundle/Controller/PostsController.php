<?php

namespace AdminBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;

use AutoSerwisBundle\Entity\Post;
use AdminBundle\Form\PostType;

class PostsController extends Controller
{
    /**
     * @Route(
     *      "/{page}",
     *      name = "admin_posts",
     *      defaults = {"page" = 1},
     *      requirements = {"page" = "\d+"}
     * )
     */
    public function indexAction(Request $request, $page)
    {
        $filters = array(
            'search' => $request->query->get('post_search'),
            'category' => $request->query->get('category'),
            'orderBy' => 'p.createDate',
            'orderDir' => 'DESC'
        );
        
        $currLimit = $request->query->get('limit', 5);
        $posts = $this->getDoctrine()->getRepository('AutoSerwisBundle:Post')->getQueryBuilder($filters);
        $paginator = $this->get('knp_paginator');
        $pagination = $paginator->paginate($posts, $page, $currLimit);
        
        $categories = $this->getDoctrine()->getRepository("AutoSerwisBundle:Category")->findAll();
        
        $limits = [3, 5, 10, 15];
        
        return $this->render('AdminBundle:Posts:index.html.twig', array(
            'pagination' => $pagination,
            'categories' => $categories,
            'selectedCat' => $filters['category'],
            'search' => $filters['search'],
            'limits' => $limits,
            'currLimit' => $currLimit
        ));
    }
    
    /**
     * @Route(
     *      "/search",
     *      name = "admin_post_search"
     * )
     */
    public function searchAction(\Symfony\Component\HttpFoundation\Request $request) {
        return $this->render('AdminBundle:Post:index.html.twig');
    }
    
    /**
     * @Route(
     *      "/edit/{id}",
     *      name = "post_edit", 
     * )
     */
    public function editAction(Request $request, $id = null) {
        
        if($id == null) {
            $newForm = true;
            $Post = new Post();
            $Post->setCreateDate(new \DateTime());
            $Post->setAuthor($this->getUser());
        } else {
            $Post = $this->getDoctrine()->getRepository('AutoSerwisBundle:Post')->find($id);
        }
        
        $form = $this->createForm(PostType::class, $Post);
        
        if($request->isMethod('POST')) {
            $form->handleRequest($request);
            if($form->isSubmitted() && $form->isValid()){
                $em = $this->getDoctrine()->getManager();
                $em->persist($Post);
                $em->flush();
                
                $msg = isset($newForm) ? 'Post został dodany.' : 'Zmiany zostały zapisane.';
                $this->get('session')->getFlashBag()->add('success', $msg);
                $this->redirectToRoute('post_edit', array('id' => $Post->getId()));
            } else {
                $this->get('session')->getFlashBag()->add('warning', 'Aby zapisać zmiany popraw błędy formularza.');
            }
        }
        
        return $this->render('AdminBundle:Posts:edit.html.twig', array(
            'form' => $form->createView(),
            'post' => $Post
        ));
    }
    
    /**
     * @Route(
     *      "/post-delete/{id}",
     *      name = "admin_post_delete",
     *      requirements = {"id" = "\d+"}
     * )
     */
    public function deletePostAction($id){
        
        $this->denyAccessUnlessGranted('ROLE_ADMIN', null, 'Nie masz uprawnień do wykonania tej akcji');
        
        $Post = $this->getDoctrine()->getRepository('AutoSerwisBundle:Post')->find($id);
        
        if($Post == null) {
            throw $this->createNotFoundException('Nie znaleziono posta');
        }
        
        $em = $this->getDoctrine()->getManager();
        $em->remove($Post);
        $em->flush();
        
        $this->get('session')->getFlashBag()->add('success', 'Post został usunięty.');
        
        return $this->redirectToRoute('admin_posts');
    }
}
