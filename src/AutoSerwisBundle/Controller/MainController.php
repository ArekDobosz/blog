<?php

namespace AutoSerwisBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;

use AutoSerwisBundle\Entity\Comment;
use AutoSerwisBundle\Form\CommentType;

class MainController extends Controller
{
    private $itemsLimit = 3;
    
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
            'orderDir' => 'DESC',
            'published' => true
        ), $page);
        
        return $this->render('AutoSerwisBundle:Main:index.html.twig', array(
            'pagination' => $pagination,
            'title' => 'Lista postów',
        ));
    }
    
    /**
     * @Route(
     *      "/post/{slug}",
     *      name = "post"
     * )
     */
    public function postAction($slug, Request $Request) {
        $Repo = $this->getDoctrine()->getRepository('AutoSerwisBundle:Post');
        $post = $Repo->findOneBySlug($slug);
        
        if(null === $post) {
            throw $this->createNotFoundException('Nie znaleziono postu');
        }
        
        $Comment = new Comment();
        $Comment->setAuthor($this->getUser())
                ->setPost($post);

        $form = $this->createForm(CommentType::class, $Comment);

        if($Request->isMethod('POST')) {
            $form->handleRequest($Request);
            if($form->isValid() && $form->isSubmitted()) {
                $em = $this->getDoctrine()->getManager();
                $em->persist($Comment);
                $em->flush();

                $this->get('session')->getFlashBag()->add('success', 'Komentarz został dodany.');
                return $this->redirectToRoute('post', array('slug' => $slug));
            }
        }
        
        return $this->render('AutoSerwisBundle:Main:post.html.twig', array(
            'post' => $post,
            'form' => isset($form) ? $form->createView() : null,
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
    
    /**
     * @Route(
     *      "/delete-comment/{id}",
     *      name="delete_comment"
     * )
     */
    public function deleteCommentAction(Request $request, Comment $Comment) {
        
        $this->denyAccessUnlessGranted('ROLE_ADMIN', null, 'Nie masz dostępu do tego zadania.');
        
        if($Comment === null) {
            throw $this->createNotFoundException('Post nie istnieje.');
        } 
        
        if(!$this->isCsrfTokenValid('deleteComment-'.$Comment->getId(), $request->get('token'))) {
//            $this->get('session')->getFlashBag()->add('danger', 'Błędny token akcji.');
            throw $this->createAccessDeniedException('Brak uprawnień do wykonania akcji.');
        }
        
        $em = $this->getDoctrine()->getManager();
        $em->remove($Comment);
        $em->flush();
        
        return new \Symfony\Component\HttpFoundation\JsonResponse(array(
            'satus' => 'ok',
            'msg' => 'Komentarz został usunięty'
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
