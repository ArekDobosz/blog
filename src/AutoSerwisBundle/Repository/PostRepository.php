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
        
        if(!empty($params['published'])) {           
            $qb->andWhere('p.createDate <= :today and p.createDate IS NOT NULL')
            ->setParameter('today', new \DateTime());
        }
        
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
        
        if(!empty($params['category'])) {
            if($params['category'] != -1) {
                $qb->andWhere('c.id = :category')
                    ->setParameter('category', $params['category']);
            } else {
                $qb->andWhere($qb->expr()->isNull('p.category'));
            }
        }
        
        return $qb;
    }
    
    public function topCommented($limit) {
        
        return $this->createQueryBuilder('p')
                ->select('p.title, p.slug, COUNT(c) as commentsCount')
                ->leftJoin('p.comments', 'c')
                ->groupBy('p.title')
                ->having('commentsCount > 0')
                ->orderBy('commentsCount', 'DESC')
                ->setMaxResults($limit)
                ->getQuery()->getArrayResult(); 
    }
}
