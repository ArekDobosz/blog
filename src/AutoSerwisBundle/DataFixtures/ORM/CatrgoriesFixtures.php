<?php

namespace AutoSerwisBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use AutoSerwisBundle\Entity\Category;

class CatrgoriesFixtures extends AbstractFixture implements OrderedFixtureInterface{
    
    public function load(ObjectManager $manager){
        
        $catList = array(
            'osobowe' => 'Silniki osobowe',
            'odrzutowe' => 'Silniki odrzutowe',
            'wodne' => 'Silniki wodne',
            'promocje' => 'Promocje'
        );
        
        foreach($catList as $key => $val) {
            $Cat = new Category();
            $Cat->setName($val);
            
            $manager->persist($Cat);
            $this->addReference('category_'.$key, $Cat);
        }
        
        $Cat = new Category();        
        $manager->flush();
    }
    
    public function getOrder() {
        return 0;
    }
    
}
