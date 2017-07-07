<?php

namespace AutoSerwisBundle\Repository;

use Doctrine\ORM\EntityRepository;

class PostRepository extends EntityRepository{
    
    public function getQueryBuilder(array $params = array()) {
        
        $qb = $this->createQueryBuilder('p')
                ->select('p, c, t, a')
                ->leftJoin('p.category', 'c')
                ->leftJoin('p.author', 'a')
                ->leftJoin('p.tags', 't');
        
        if(!empty($params['orderBy'])) {
            $orderDir = !empty($params['orderDir']) ? $params['orderDir'] : 'ASC';
            $qb->orderBy($params['orderBy'], $orderDir);
        }
        
        if(!empty($params['categorySlug'])) {
            $qb->where('c.slug = :categorySlug')
                    ->setParameter('categorySlug', $params['categorySlug']);
        }
        
        if(!empty($params['tagSlug'])) {
            $qb->andWhere('t.slug = :tagSlug')
                    ->setParameter('tagSlug', $params['tagSlug']);
        }
        
        if(!empty($params['search'])) {
            $search = '%'.$params['search'].'%';
            $qb->andWhere('p.content LIKE :search OR p.title LIKE :search')
                    ->setParameter('search', $search);
        }
        
        return $qb;
    }
    
}
