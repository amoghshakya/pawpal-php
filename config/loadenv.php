<?php
     // Start a PHP block to execute server-side code

     // Parse the .env file located in the parent directory
     // and store its key-value pairs in the $env array
     $env = parse_ini_file(dirname(__DIR__) . '/.env');

     // Check if the .env file was successfully parsed
     if ($env !== false) {
         // Loop through each key-value pair in the $env array
         // and assign them to the $_ENV superglobal array for global access
         foreach ($env as $key => $value) {
             $_ENV[$key] = $value;
         }
     }
     ?>