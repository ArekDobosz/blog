<?php

namespace AutoSerwisBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use AutoSerwisBundle\Entity\Tag;

/**
 * Description of TagsFixtures
 *
 * @author Arkadiusz
 */
class TagsFixtures extends AbstractFixture implements OrderedFixtureInterface{
    
    public function load(ObjectManager $manager) {
        
        $tagList = [
            'promocje',
            'oleje',
            'silniki',
            'auto',
            'tuning'          
        ];
        
        foreach($tagList as $tag) {
            $Tag = new Tag();
            
            $Tag->setName($tag);
            
            $manager->persist($Tag);
            $this->addReference('tag_'.$tag, $Tag);
        }
        
        $manager->flush(); 
    }
    
    public function getOrder() {
        return 0;
    }
    
}
