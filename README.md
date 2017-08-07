Blog 

A Symfony project created on June 27, 2017, 10:56 am.

Requirements before first run: <br>
  You have to write in console: <br>
    /* to create database: */<br>
        $ php bin/console doctrine:database:create
        $ php bin/console doctrine:schema:update --force

    /* to create admin account: */<br>  
        $ php bin/console fos:user:create
          example: username: admin
                   email: admin@example.com
                   password: ****
        $ php bin/console fos:user:promote
          example: username: admin
                   role: ROLE_ADMIN
