<?php

 require_once '../_includes/Init.bootstrap.php';

 $Init = new Init( '/Applications/XAMPP/htdocs/sf/', 'Settings.ini' );
 $Init->initTimers();
 $Init->bootstrap();
 $Init->setup();
 $Init->Timer->end();
 echo $Init->Timer->getTime();

?>