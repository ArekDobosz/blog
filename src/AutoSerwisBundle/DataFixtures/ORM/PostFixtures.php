<?php

namespace AutoSerwisBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use AutoSerwisBundle\Entity\Post;

/**
 * Description of PostFixtures
 *
 * @author Arkadiusz
 */
class PostFixtures extends AbstractFixture implements OrderedFixtureInterface{
    
    public function load(ObjectManager $manager) {
        
        $postList = [
            [
            'title' => 'Promocje na otwarcie',
            'content' => 'This example extends the layout template from the layout of your app. The content block is where the main content of each page is rendered. This is why the fos_user_content block has been placed inside of it. This will lead to the desired effect of having the output from the FOSUserBundle actions integrated into our applications layout, preserving the look and feel of the application.',
            'category' => 'promocje',
            'tags' => array('promocje', 'oleje'),
            'author' => 'Admin',
            'createDate' => '2017-06-30 10:23:11'
            ],
            [
            'title' => 'Promocje na otwarcie1',
            'content' => 'This example extends the layout template from the layout of your app. The content block is where the main content of each page is rendered. This is why the fos_user_content block has been placed inside of it. This will lead to the desired effect of having the output from the FOSUserBundle actions integrated into our applications layout, preserving the look and feel of the application.',
            'category' => 'promocje',
            'tags' => array('promocje', 'oleje'),
            'author' => 'Admin',
            'createDate' => '2017-06-30 10:23:11'
            ],
            [
            'title' => 'Promocje na otwarcie2',
            'content' => 'This example extends the layout template from the layout of your app. The content block is where the main content of each page is rendered. This is why the fos_user_content block has been placed inside of it. This will lead to the desired effect of having the output from the FOSUserBundle actions integrated into our applications layout, preserving the look and feel of the application.',
            'category' => 'osobowe',
            'tags' => array('promocje', 'oleje'),
            'author' => 'Admin',
            'createDate' => '2017-06-30 10:23:11'
            ],
            [
            'title' => 'Promocje na otwarcie3',
            'content' => 'This example extends the layout template from the layout of your app. The content block is where the main content of each page is rendered. This is why the fos_user_content block has been placed inside of it. This will lead to the desired effect of having the output from the FOSUserBundle actions integrated into our applications layout, preserving the look and feel of the application.',
            'category' => 'osobowe',
            'tags' => array('tuning', 'oleje'),
            'author' => 'Admin',
            'createDate' => '2017-06-30 10:23:11'
            ],
            [
            'title' => 'Promocje na otwarcie4',
            'content' => 'This example extends the layout template from the layout of your app. The content block is where the main content of each page is rendered. This is why the fos_user_content block has been placed inside of it. This will lead to the desired effect of having the output from the FOSUserBundle actions integrated into our applications layout, preserving the look and feel of the application.',
            'category' => 'odrzutowe',
            'tags' => array('auto', 'tuning'),
            'author' => 'Admin',
            'createDate' => '2017-06-30 10:23:11'
            ],
            [
            'title' => 'Promocje na otwarcie5',
            'content' => 'This example extends the layout template from the layout of your app. The content block is where the main content of each page is rendered. This is why the fos_user_content block has been placed inside of it. This will lead to the desired effect of having the output from the FOSUserBundle actions integrated into our applications layout, preserving the look and feel of the application.',
            'category' => 'odrzutowe',
            'tags' => array('tuning', 'auto'),
            'author' => 'Admin',
            'createDate' => '2017-06-30 10:23:11'
            ],
            [
            'title' => 'Promocje na otwarcie6',
            'content' => 'This example extends the layout template from the layout of your app. The content block is where the main content of each page is rendered. This is why the fos_user_content block has been placed inside of it. This will lead to the desired effect of having the output from the FOSUserBundle actions integrated into our applications layout, preserving the look and feel of the application.',
            'category' => 'wodne',
            'tags' => array('promocje', 'silniki'),
            'author' => 'Admin',
            'createDate' => '2017-06-30 10:23:11'
            ],
            [
            'title' => 'Promocje na otwarcie7',
            'content' => 'This example extends the layout template from the layout of your app. The content block is where the main content of each page is rendered. This is why the fos_user_content block has been placed inside of it. This will lead to the desired effect of having the output from the FOSUserBundle actions integrated into our applications layout, preserving the look and feel of the application.',
            'category' => 'wodne',
            'tags' => array('silniki', 'oleje'),
            'author' => 'Admin',
            'createDate' => '2017-06-30 10:23:11'
            ],
            [
            'title' => 'Promocje na otwarcie8',
            'content' => 'This example extends the layout template from the layout of your app. The content block is where the main content of each page is rendered. This is why the fos_user_content block has been placed inside of it. This will lead to the desired effect of having the output from the FOSUserBundle actions integrated into our applications layout, preserving the look and feel of the application.',
            'category' => 'promocje',
            'tags' => array('silniki', 'oleje'),
            'author' => 'Admin',
            'createDate' => '2017-06-30 10:23:11'
            ],
        ];
        
        foreach($postList as $post) {
            $Post = new Post();
            $Post->setTitle($post['title'])
                    ->setContent($post['content'])
                    ->setAuthor($post['author'])
                    ->setCreateDate(new \DateTime($post['createDate']));
            
            $Post->setCategory($this->getReference('category_'.$post['category']));
            
            foreach($post['tags'] as $tag) {
                $Post->addTag($this->getReference('tag_'.$tag));
            }
            $manager->persist($Post);
        }
        $manager->flush();
    }
    
    public function getOrder() {
        return 1;
    }
}
