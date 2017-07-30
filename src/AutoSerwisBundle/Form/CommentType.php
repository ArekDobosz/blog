<?php

namespace AutoSerwisBundle\Form;

use AutoSerwisBundle\Entity\Comment;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CommentType extends AbstractType {
    
    public function getName() {
        return 'comment_form';
    }
   
    public function buildForm(FormBuilderInterface $builder, array $options) {
        
        $builder
                ->add('content', TextareaType::class, array(
                    'label' => 'Treść komentarza',
                    'attr' => array(

                    )
                ))
                ->add('submit', SubmitType::class, array(
                    'label' => 'Dodaj komentarz'
                ));       
    }
    
    public function configureOptions(OptionsResolver $resolver) {
        $resolver->setDefaults(array(
            'data_class' => Comment::class
        ));
    }
    
}
