
<?php 
 $user = new User();
 $reqs = (new Request)->fetchAll("WHERE is_read = 0 AND user_id = ". $user->data()->id);

 $_reqs = (new Request)->fetchAll("where user_id = ". $user->data()->id);

 $unsubmitted_rfs = 0;

 foreach ($_reqs as $index => $request) {
     foreach ($request->requestForms() as $i => $rf) {
         if($rf->data()->is_submitted == 0){
            $unsubmitted_rfs++;
         }
         
     }
     
 }
?>
<div class="sidebar" data-background-color="white" data-active-color="danger">

    <!--
		Tip 1: you can change the color of the sidebar's background using: data-background-color="white | black"
		Tip 2: you can change the color of the active button using the data-active-color="primary | info | success | warning | danger"
	-->

    <div class="sidebar-wrapper">
        <div class="logo">
            <a href="" class="simple-text">
                DAMs
            </a>
        </div>

        <ul class="nav">
            <li <?php if($active_nav =="dashboard") echo 'class="active"' ?> >
                <a href="dashboard.php">
                    <i class="ti-dashboard"></i>
                    <p>Dashboard</p>
                </a>
            </li>
            <li <?php if($active_nav =="requests") echo 'class="active"' ?>>
                <a href="requests.php">
                    <i class="ti-notepad"></i>
                    <p>Requests
                    <?php 
                            $req_count = count($reqs) ;
                            if($req_count> 0)
                                echo '<span class="badge badge-pill badge-danger">'.$req_count.'</span>';
                    ?>
                    </p>
                </a>
            </li>
            <li <?php if($active_nav =="request-forms") echo 'class="active"' ?>>
                <a href="request-forms.php">
                    <i class="ti-notepad"></i>
                    <p>Request Forms
                    <?php 
                            
                        if($unsubmitted_rfs > 0)
                            echo '<span class="badge badge-pill badge-danger">'.$unsubmitted_rfs.'</span>';
                    ?>
                    </p>
                </a>
            </li>
            <li <?php if($active_nav =="user") echo 'class="active"' ?>>
                <a href="user.php">
                    <i class="ti-user"></i>
                    <p>User Profile</p>
                </a>
            </li>

            
        </ul>
    </div>
</div>