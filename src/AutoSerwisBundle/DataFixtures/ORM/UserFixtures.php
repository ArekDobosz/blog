<?php

namespace AutoSerwisBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

use AutoSerwisBundle\Entity\User;

class UserFixtures extends AbstractFixture implements OrderedFixtureInterface, ContainerAwareInterface {

    /**
     * @var ContainerInterface
     */
    private $container;
    
    public function setContainer(ContainerInterface $container = null) {
        $this->container = $container;
    }
    
    public function load(ObjectManager $manager) {
        
        $users = array(
            array(
                'username' => 'arqus',
                'email' => 'example@wp.pl',
                'password' => '1234',
                'roles' => 'ROLE_USER',
                'firstName' => 'Arqus',
                'lastName' => 'Robik'
            ),
            array(
                'username' => 'Emik',
                'email' => 'emik@wp.pl',
                'password' => '1234',
                'roles' => 'ROLE_USER',
                'firstName' => 'Emik',
                'lastName' => 'Dobik'
            ),
            array(
                'username' => 'Emik123',
                'email' => 'emik123@wp.pl',
                'password' => '1234',
                'roles' => 'ROLE_USER',
                'firstName' => 'Emikk',
                'lastName' => 'Bobik'
            ),
            array(
                'username' => 'Benek',
                'email' => 'benek@wp.pl',
                'password' => '1234',
                'roles' => 'ROLE_USER',
                'firstName' => 'Benek',
                'lastName' => 'Gruby'
            ),
        );
        
        foreach($users as $user) {
            $User = new User();
            
            $User->setUsername($user['username'])
                    ->setEmail($user['email'])
                    ->setRoles(array($user['roles']))
                    ->setFirstName($user['firstName'])
                    ->setLastName($user['lastName'])
                    ->setEnabled(true)
                    ->setUpdateDate(new \DateTime());
            
            $encoderFacotry = $this->container->get('security.encoder_factory');
            $pass = $encoderFacotry->getEncoder($User)->encodePassword($user['password'], null);           
            $User->setPassword($pass);
            
            $manager->persist($User);
            $this->addReference('user-'.$user['username'], $User);
        }
        
        $manager->flush();
        
    }
       
    public function getOrder() {
        return 0;
    }

}
