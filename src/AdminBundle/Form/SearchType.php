<?php

namespace AdminBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class SearchType extends AbstractType{
    
    public function getName() {
        return 'search_form';
    }
    
    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder
                ->add('');
    }
    
}
