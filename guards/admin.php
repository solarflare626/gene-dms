<?php
 require_once 'core/init.php';
 
    $user = new User();
    
    if($user->is_entity()){
        Redirect::to('index.php');
    }

