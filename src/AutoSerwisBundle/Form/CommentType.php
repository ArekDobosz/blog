<?php

namespace AutoSerwisBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use AutoSerwisBundle\Entity\Comment;

class CommentType extends AbstractType {
    
    public function getName() {
        return 'comment_form';
    }
   
    public function buildForm(FormBuilderInterface $builder, array $options) {
        
        $builder
                ->add('content', \Symfony\Component\Form\Extension\Core\Type\TextareaType::class, array(
                    'label' => 'Treść komentarza',
                    'attr' => array(

                    )
                ))
                ->add('submit', \Symfony\Component\Form\Extension\Core\Type\SubmitType::class, array(
                    'label' => 'Dodaj komentarz'
                ));       
    }
    
    public function configureOptions(OptionsResolver $resolver) {
        $resolver->setDefaults(array(
            'data_class' => Comment::class
        ));
    }
    
}
