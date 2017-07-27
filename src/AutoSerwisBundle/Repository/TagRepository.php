<?php

namespace AutoSerwisBundle\Repository;

use Doctrine\ORM\EntityRepository;

class TagRepository extends EntityRepository {
    
    public function getTagsList() {
        
        $qb = $this->createQueryBuilder('t')
                ->select('t.slug, t.name, COUNT(t) as ile')
                ->leftJoin('t.posts', 'p')
                ->groupBy('t.name');
        
        return $qb->getQuery()->getArrayResult();
    }
    
    public function getQueryBuilder() {
        return $qb = $this->createQueryBuilder('t')
                    ->select('t, COUNT(p.id) as ile')
                    ->leftJoin('t.posts', 'p')
                    ->groupBy('t.id');
    }
    
}
