<?php

namespace AdminBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;


class PostType extends AbstractType {
    
    public function getName() {
        return 'post_form';
    }
    
    public function buildForm(FormBuilderInterface $builder, array $options) {
        
        $builder
                ->add('title', TextType::class, array(
                    'label' => 'Tytuł'
                ))
                ->add('content', TextareaType::class, array(
                    'label' => 'Treść posta',
                ))
                ->add('thumbnailFile', FileType::class, array(
                    'label' => 'Miniaturka',
                    'data_class' => null
                ))
                ->add('createDate', DateTimeType::class, array(
                    'label' => 'Data publikacji',
                    'date_widget' => 'single_text',
                    'time_widget' => 'single_text'
                ))
                ->add('category', EntityType::class, array(
                    'label' => 'Kategoria',
                    'class' => 'AutoSerwisBundle:Category',
                    'choice_label' => 'name'
                ))
                ->add('tags', EntityType::class, array(
                    'label' => 'Tagi',
                    'class' => 'AutoSerwisBundle:Tag',
                    'choice_label' => 'name',
                    'multiple' => 'true',
                    'expanded' => 'true'
                ))
                ->add('submit', SubmitType::class, array(
                    'label' => 'Zapisz'
                ));       
    }
    
    public function setDefaultOptions(OptionsResolver $resolver){
        $resolver->setDefaults(array(
           'data_class' => 'AutoSerwis\Bundle\Entity\Post' 
        ));
    }
    
}
