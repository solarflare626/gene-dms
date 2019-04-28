<?php
 require_once 'core/init.php';
 
    $user = new User();

    if($user->is_admin()){
        Redirect::to('index.php');
    }
