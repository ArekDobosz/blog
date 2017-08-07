Blog 

A Symfony 3.3.2 project created on June 27, 2017, 10:56 am.

Requirements before first run: <br>
  You have to write in console (to create database and admin account): <br>

    
        $ php bin/console doctrine:database:create
        
        $ php bin/console doctrine:schema:update --force

        $ php bin/console fos:user:create
          example: username: admin
                   email: admin@example.com
                   password: ****
        $ php bin/console fos:user:promote
          example: username: admin
                   role: ROLE_ADMIN
