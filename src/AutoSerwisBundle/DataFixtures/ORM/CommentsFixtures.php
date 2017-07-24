<?php

namespace AutoSerwisBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use AutoSerwisBundle\Entity\Comment;

class CommentsFixtures extends AbstractFixture implements OrderedFixtureInterface {

    public function load(ObjectManager $manager) {
        $comments = array(
            array(
                'post' => 0,
                'author' => 'Emik',
                'createdAt' => '2017-07-05 10:02:32',
                'content' => 'Creating a form requires relatively little code because Symfony form objects are built with a "form builder". The form builders purpose is to allow you to write simple form "recipes" and have it do all the heavy-lifting of actually building the form.'
            ),
            array(
                'post' => 0,
                'author' => 'arqus',
                'createdAt' => '2017-07-05 10:02:32',
                'content' => 'Creating a form requires relatively little code because Symfony form objects are built with a "form builder". The form builders purpose is to allow you to write simple form "recipes" and have it do all the heavy-lifting of actually building the form.'
            ),
            array(
                'post' => 0,
                'author' => 'Emik123',
                'createdAt' => '2017-07-05 10:02:32',
                'content' => 'Creating a form requires relatively little code because Symfony form objects are built with a "form builder". The form builders purpose is to allow you to write simple form "recipes" and have it do all the heavy-lifting of actually building the form.'
            ),
        );
        
        foreach($comments as $comment) {
            $Commnet = new Comment();
            
            $Commnet->setAuthor($this->getReference('user-'.$comment['author']))
                    ->setPost($this->getReference('post-'.$comment['post']))
                    ->setCreatedAt(new \DateTime($comment['createdAt']))
                    ->setContent($comment['content']);
                    
             $manager->persist($Commnet);       
        }
        
        $manager->flush();
        
    }

    public function getOrder() {
            return 2;
    }   
}
