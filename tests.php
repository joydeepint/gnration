<?php

 require_once '_includes/Init.bootstrap.php';
 
 $Init = new Init( 'C:/xampp/htdocs/sf/', 'Settings.ini' );
 $Init->initTimers();
 $Init->bootstrap();
 /*$Init->setup();
 $Init->Timer->end();
 echo $Init->Timer->getTime();*/
 
 $Amazon = Core::library()->load( 'CDN_Amazon', Array( 'hi', 'lol' => 'dude', 's' ) );
 $Amazon->load( 's3' );
 
?>