<?php
 require_once 'core/init.php';
 
    $user = new User();

    if($user->data()->group == 2){
        Redirect::to('index.php');
    }
