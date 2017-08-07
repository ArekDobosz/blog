<?php

namespace AdminBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class UsersType extends AbstractType{
    public function getName() {
        return 'users_form';
    }
    
    public function buildForm(FormBuilderInterface $builder, array $options) {
        
        $builder
                ->add('username', \Symfony\Component\Form\Extension\Core\Type\TextType::class, array(
                    'label' => 'Nazwa'
                ))
                ->add('email', \Symfony\Component\Form\Extension\Core\Type\EmailType::class, array(
                    'label' => 'Email'
                ))
                ->add('enabled', \Symfony\Component\Form\Extension\Core\Type\CheckboxType::class, array(
                    'label' => 'Aktywny profil'
                ))
                ->add('submit', \Symfony\Component\Form\Extension\Core\Type\SubmitType::class, array(
                    'label' => 'Zmień'
                ));
    }
}
