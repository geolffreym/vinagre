Vinagre - Give flavor to your salad (Dev Version)
===================
PHP MVC | MTV pattern based framework. Make the job easy and fast.

Configure Framework
=======

Requirements
------------
* MYSQLi 5.5 >
* PHP 5.5 >

NGINX
-----
    location / {
         try_files $uri $uri/ /ini.php;
    }

    location ~ \.php$ {
        fastcgi_split_path_info ^(.+\.php)(/.+)$;
        fastcgi_pass unix:/var/run/php5-fpm.sock;
        fastcgi_index ini.php;
        include fastcgi_params;
        fastcgi_param   SCRIPT_FILENAME  $document_root$fastcgi_script_name;
        fastcgi_param   SCRIPT_NAME   $fastcgi_script_name;

    }


Environment
----------
In the file public / ini.php should set the enviroment ( desarrolllo , production ) , which is associated directly to the folder / app / enviroment.
For the configuration of the work environment , you must modify the files , autoload.php and config.php in the folder of your working environment.

"app/config.ini"
The config.php contains a number of arrangements for handling different configurations in the framework (cache , databases , mail, security , ftp, etc ).

"app/autoload.php"
The autoload function is provided by the framework Loader , allowing autoloading libraries , helpers , etc. This in order to allow handling different functionalities already own the framework or adapted by the sparks.


Learning
=========

General Topics
--------------
*Pending Documentation*

Languages and Translation
------------------------
*Pending Documentation*

Exceptions
----------
*Pending Documentation*

Libs
----
*Pending Documentation*

Sparks
------
*Pending Documentation*

Security
------
*Pending Documentation*

Traits
-----
*Pending Documentation*

Helpers
-----
*Pending Documentation*

Our App
======

URL
-----
*Pending Documentation*

Controllers
-----------
*Pending Documentation*

Models
-------
*Pending Documentation*

Views
-----
*Pending Documentation*
