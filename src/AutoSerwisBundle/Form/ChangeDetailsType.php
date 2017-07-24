<?php

namespace AutoSerwisBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ChangeDetailsType extends AbstractType {
    
    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder->add('firstName', TextType::class, array(
                    'label' => 'Imię'
                ))
                ->add('lastName', TextType::class, array(
                    'label' => 'Nazwisko'
                ))
                ->add('avatarFile', FileType::class, array(
                    'label' => 'Avatar',
                    'required' => false,
                    'data_class' => null
                ));
    }
    
    public function getParent() {
        return 'FOS\UserBundle\Form\Type\ProfileFormType';
    }
    
    public function getBlockPrefix() {
        return 'serwis_bundle_changeDetails';
    }
    
    public function getName()
    {
        return $this->getBlockPrefix();
    }    
}
