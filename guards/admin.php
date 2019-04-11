<?php
 require_once 'core/init.php';
 
    $user = new User();
    
    if($user->data()->group == 1){
        Redirect::to('index.php');
    }

