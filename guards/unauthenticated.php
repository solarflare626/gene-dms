<?php
//  require_once 'core/init.php';
 
$user = new User();
if($user->isLoggedIn()){
    if($user->data()->group == 2)
        Redirect::to('dashboard-admin.php');
    else if($user->data()->group == 1)
        Redirect::to('dashboard.php');
}

