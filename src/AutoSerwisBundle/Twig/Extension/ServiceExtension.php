<?php

namespace AutoSerwisBundle\Twig\Extension;

class ServiceExtension extends \Twig_Extension {
    
    /**
     * @var \Doctrine\Bundle\DoctrineBundle\Registry 
     */
    private $doctrine;
    
    /**
     * @var \Twig_Environment
     */
    private $environment;
    
    private $categoriesList;
    
    public function __construct(\Doctrine\Bundle\DoctrineBundle\Registry $doctrine) {
        $this->doctrine = $doctrine;
    }
    
    public function initRuntime(\Twig_Environment $environment) {
        $this->environment = $environment;
    }
    
    public function getFunctions() {
        
        return array(
            new \Twig_SimpleFunction('test', array($this, 'testFilter')),
            new \Twig_SimpleFunction('printMenu', array($this, 'printMenu'), array('is_safe' => array('html'))),
            new \Twig_SimpleFunction('tagsCloud', array($this, 'getTags'), array('is_safe' => array('html'))),
            new \Twig_SimpleFunction('topCommented', array($this, 'topCommented'), array('is_safe' => array('html')))
        );
        
    }
    
    public function getFilters() {
        
        return array(
           new \Twig_SimpleFilter('cutPost', array($this, 'postCuter'), array('is_safe' => array('html')))  
        );
    }
    
    public function printMenu() {
        
        if(!isset($this->categoriesList)) {
            
            $Repo = $this->doctrine->getRepository('AutoSerwisBundle:Category');
            $this->categoriesList = $Repo->findAll();
        }       
        
        return $this->environment->render('AutoSerwisBundle:Templates:categoriesList.html.twig', array(
           'categories' => $this->categoriesList 
        ));        
    }
    
    public function getTags($minFont = 1, $maxFont = 3, $limit = 20) {
        
        $Repo = $this->doctrine->getRepository('AutoSerwisBundle:Tag');
        $tags = $Repo->getTagsList();
        $tags = $this->prepareTagsCloud($tags, $limit = 20, $minFont, $maxFont);
        
        return $this->environment->render('AutoSerwisBundle:Templates:tagsCloud.html.twig', array(
            'tags' => $tags
        ));      
    }
    
    protected function prepareTagsCloud($tagsList, $limit, $minFontSize, $maxFontSize){
        $occs = array_map(
                    function($row){
                        return (int)$row['ile']; 
                    }, 
                    $tagsList);
                    
        $minOcc = min($occs);
        $maxOcc = max($occs);
        
        $spread = $maxOcc - $minOcc;
        
        $spread = ($spread == 0) ? 1 : $spread;
        
        usort($tagsList, function($a, $b){
            $ao = $a['ile'];
            $bo = $b['ile'];
            
            if($ao === $bo) return 0;
            
            return ($ao < $bo) ? 1 : -1;
        });
        
        $tagsList = array_slice($tagsList, 0, $limit);
        
        shuffle($tagsList);
        
        foreach($tagsList as &$row){
            $row['fontSize'] = round(($minFontSize + ($row['ile'] - $minOcc) * ($maxFontSize - $minFontSize) / $spread), 2);
        }

        return $tagsList;
    }
    
    public function postCuter($text, $length = 200) {
        
        $text = strip_tags($text);
        
        $text = substr($text, 0, $length).'...';
        
        return '<p>'.$text.'</p>';
    }
    
    public function topCommented ($limit = 3) {
        
        $Repo = $this->doctrine->getRepository('AutoSerwisBundle:Post');
        
        $topCommentedPosts = $Repo->topCommented($limit);
        
        return $this->environment->render('AutoSerwisBundle:Templates:topCommented.html.twig', array(
            'posts' => $topCommentedPosts
        ));
        
    }
}
