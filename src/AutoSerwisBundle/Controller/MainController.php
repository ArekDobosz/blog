<?php

namespace AutoSerwisBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

class MainController extends Controller
{
    private $itemsLimit = 4;
    
    /**
     * @Route(
     *      "/{page}",
     *      name = "main_page",
     *      defaults = {"page" = 1},
     *      requirements = {"page" = "\d+"}     
     * )
     */
    public function indexAction($page)
    {
        $pagination = $this->getPaginatedPost(array(
            'orderBy' => 'p.createDate',
            'orderDir' => 'ASC'
        ), $page);
        
        return $this->render('AutoSerwisBundle:Main:index.html.twig', array(
            'pagination' => $pagination,
            'title' => 'Lista postów'
        ));
    }
    
    /**
     * @Route(
     *      "/post/{slug}",
     *      name = "post"
     * )
     */
    public function postAction($slug) {
        $Repo = $this->getDoctrine()->getRepository('AutoSerwisBundle:Post');
        $post = $Repo->findOneBySlug($slug);
        
        if(null === $post) {
            throw $this->createNotFoundException('Nie znaleziono postu');
        }
        
        return $this->render('AutoSerwisBundle:Main:post.html.twig', array(
            'post' => $post
        ));
    }
    
    /**
     * @Route(
     *      "/category/{slug}/{page}",
     *      name = "category",
     *      defaults = {"page" = 1},
     *      requirements = {"page" = "\d+"}
     * )
     */
    public function categoryAction($slug, $page) {
     
        $pagination = $this->getPaginatedPost(array(
            'categorySlug' => $slug
        ), $page);
        
        $categoryRepo = $this->getDoctrine()->getRepository('AutoSerwisBundle:Category');
        $Cat = $categoryRepo->findOneBySlug($slug);
        
        
        return $this->render('AutoSerwisBundle:Main:index.html.twig', array(
            'pagination' => $pagination,
            'title' => 'Posty w kategorii: <strong>'.$Cat->getName().'</strong>'
        ));
    }
    
    /**
     * @Route(
     *      "/tag/{slug}/{page}",
     *      name = "tag",
     *      defaults = {"page" = 1},
     *      requirements = {"page" = "\d+"}
     * )
     */
    public function tagAction($slug, $page) {
        
        $pagination = $this->getPaginatedPost(array(
            'tagSlug' => $slug
        ), $page);
        
        return $this->render('AutoSerwisBundle:Main:index.html.twig', array(
            'pagination' => $pagination,
            'title' => 'Wpisy z tagiem: <strong>'.$slug.'</strong>'
        ));
    }
    
    /**
     * @Route(
     *      "/search/{page}",
     *      name = "search",
     *      defaults = {"page" = 1},
     *      requirements = {"page" = "\d+"}
     * )
     */
    public function searchAction(\Symfony\Component\HttpFoundation\Request $Request , $page) {
        
        $search = $Request->query->get('search');
        
        $pagination = $this->getPaginatedPost(array(
            'search' => $search,
            'orderBy' => 'p.createDate',
        ), $page);
        
        return $this->render('AutoSerwisBundle:Main:index.html.twig', array(
            'title' => 'Wyniki wyszukiwania: '.$search,
            'pagination' => $pagination,
            'search' => $search
        ));
    }
    
    private function getPaginatedPost($params, $page) {
        
        $Repo = $this->getDoctrine()->getRepository('AutoSerwisBundle:Post');
        $posts = $Repo->getQueryBuilder($params);
        
        $paginator = $this->get('knp_paginator');
        $pagination = $paginator->paginate($posts, $page, $this->itemsLimit);
        
        return $pagination;
    }
}
