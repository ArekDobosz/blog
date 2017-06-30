<?php

namespace AutoSerwisBundle\Libs;

class Utils {
    
    static public function sluggify($string) {
        //replace non leter and digits
        $string = preg_replace('~[^\\pL\d]+~u', '-', $string);
        
        //trim
        $string = trim($string);
        
        //transliterate
        $string = iconv('utf-8', 'us-ascii//TRANSLIT', $string);
        
        //remove unwanted characters
        $string = preg_replace('~[^-\w]+~', '', $string);
        
        $string = strtolower($string);
        
        if(empty($string)){
            return null;
        }
        
        return $string;
    }
    
}
