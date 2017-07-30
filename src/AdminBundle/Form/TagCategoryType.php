<?php

namespace AdminBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;


class TagCategoryType extends AbstractType {
    
    public function getName() {
        return 'tag_category_form';
    }
    
    public function buildForm(FormBuilderInterface $builder, array $options) {
        
        $builder
                ->add('name', TextType::class, array(
                    'label' => 'Nazwa'
                ))
                ->add('slug', TextType::class, array(
                    'label' =>'Slug'
                ))
                ->add('submit', SubmitType::class, array(
                    'label' => 'Zapisz'
                ));        
    }
}
