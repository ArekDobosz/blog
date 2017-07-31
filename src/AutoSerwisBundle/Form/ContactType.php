<?php

namespace AutoSerwisBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class ContactType extends AbstractType {
    
    public function getName() {
        return 'contact_form';
    }
    
    public function buildForm(FormBuilderInterface $builder, array $options) {
        
        $builder 
                ->add('name', \Symfony\Component\Form\Extension\Core\Type\TextType::class, array(
                    'label' => 'Imię',
                    'required' => true,
                    'constraints' => array(
                        new \Symfony\Component\Validator\Constraints\Length(array('min' => 3, 'max' => 25))
                    ),
                    'mapped' => false
                ))
                ->add('email', \Symfony\Component\Form\Extension\Core\Type\EmailType::class, array(
                    'label' => 'E-mail',
                    'required' => true,
                    'constraints' => array(
                        new \Symfony\Component\Validator\Constraints\Email()
                    ),
                    'mapped' => false
                ))
                ->add('msg', \Symfony\Component\Form\Extension\Core\Type\TextareaType::class, array(
                    'label' => 'Treść wiadomości',
                    'required' => true,
                    'constraints' => array(
                        new \Symfony\Component\Validator\Constraints\Length(array('min' => 3, 'max' => 500))
                    ),
                    'mapped' => false
                ))
                ->add('submit', \Symfony\Component\Form\Extension\Core\Type\SubmitType::class, array(
                    'label' => 'Wyślij wiadomość'
                ));   
    }
    
}
