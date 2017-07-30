<?php

namespace AutoSerwisBundle\Repository;

use Doctrine\ORM\EntityRepository;

class CategoryRepository extends EntityRepository {
    
    public function getQueryBuilder() {
        
        return $qb = $this->createQueryBuilder('t')
                ->select('t, COUNT(p.id) as ile')
                ->leftJoin('t.posts', 'p')
                ->groupBy('t.id');
    }
    
}
