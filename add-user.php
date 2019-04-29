<?php
//  include 'server.php';
 require_once 'core/init.php';
 include 'guards/authenticated.php';
 include 'guards/admin.php';

 if(Input::exists('post')) {
    if(Token::check(Input::get('token'))) {
        $user = new User();
        $salt = Hash::salt(32);
        $data = array(
            'name' => Input::get('name'),
            'username' => Input::get('username'),
            'password' => Hash::make(Input::get('password'), $salt),
            'salt' => $salt,
            'joined' => date('Y-m-d H:i:s'),
            'group' => 1
        );

        $hold = ['email','address','city','country','postal_code','about_me'];
        foreach ($hold as $key => $value) {
           if(Input::get($value) !== null){
               $data = array_merge($data,array($value => Input::get($value)));
           }
        }

        // print_r($data);
        // die();

        try {
            $user->create($data);
            Redirect::to("dashboard-admin.php");
        } catch(Exception $e) {
            die("$e");
        }
    
       


    }else{
        die("Please Reload Page");
    }

 }else{
    $active_nav = "user";
    $user = new User();
    $profile = $user->data();
 }

 $token = Token::generate();
?>
<!doctype html>
<html lang="en">
<head>
	<meta charset="utf-8" />
	<link rel="icon" type="image/png" sizes="96x96" href="assets/img/icon.png">
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />

	<title>DAMs</title>

	<meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0' name='viewport' />
    <meta name="viewport" content="width=device-width" />


    <!-- Bootstrap core CSS     -->
    <link href="assets/css/bootstrap.min.css" rel="stylesheet" />

    <!-- Animation library for notifications   -->
    <link href="assets/css/animate.min.css" rel="stylesheet"/>

    <!--  Paper Dashboard core CSS    -->
    <link href="assets/css/paper-dashboard.css" rel="stylesheet"/>

    <!--  CSS for Demo Purpose, don't include it in your project     -->
    <link href="assets/css/demo.css" rel="stylesheet" />

    <!--  Fonts and icons     -->
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/latest/css/font-awesome.min.css" rel="stylesheet">
    <link href='https://fonts.googleapis.com/css?family=Muli:400,300' rel='stylesheet' type='text/css'>
    <link href="assets/css/themify-icons.css" rel="stylesheet">

</head>
<body>

<div class="wrapper">

    <?php
        if($user->is_admin())
            include 'includes/admin-sidebar.php'; 
        else
            include 'includes/entity-sidebar.php'; 
     ?>

    <div class="main-panel">
		<nav class="navbar navbar-default">
            <div class="container-fluid">
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar bar1"></span>
                        <span class="icon-bar bar2"></span>
                        <span class="icon-bar bar3"></span>
                    </button>
                    <a class="navbar-brand" href="#">User Profile</a>
                </div>
                <div class="collapse navbar-collapse">
                    <ul class="nav navbar-nav navbar-right">
               
						<li>
                            <a href="logout.php">
								<i class="ti-close"></i>
								<p>Logout</p>
                            </a>
                        </li>
                    </ul>

                </div>
            </div>
        </nav>


        <div class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-8 col-md-offset-2">
                        <div class="card">
                            <div class="header">
                                <h4 class="title">Edit Profile</h4>
                            </div>
                            <div class="content">
                                <form method="post">
                                    <div class="row">
                                        <div class="col-md-5">
                                            <div class="form-group">
                                                <label>Company</label>
                                                <input required type="text" class="form-control border-input" name="name" placeholder="Company" >
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label>Username</label>
                                                <input required type="text" class="form-control border-input" name="username" placeholder="Username" >
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="exampleInputEmail1">Email address</label>
                                                <input required type="email" class="form-control border-input" name="email" placeholder="Email" >
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Password</label>
                                                <input required type="password" class="form-control border-input" name="password" placeholder="Password">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Confirm Password</label>
                                                <input required type="password" class="form-control border-input" name="cpassword" placeholder="Confirm Password" >
                                            </div>
                                        </div>
                                      
                                    </div>

                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label>Address</label>
                                                <input  type="text" class="form-control border-input" name="address" placeholder="Address" >
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label>City</label>
                                                <input  type="text" class="form-control border-input" name="city" placeholder="City" >
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label>Country</label>
                                                <input  type="text" class="form-control border-input" name="country" placeholder="Country" >
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label>Postal Code</label>
                                                <input  type="number" class="form-control border-input" name="postal_code" placeholder="ZIP Code" >
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label>About Me</label>
                                                <textarea   rows="5" class="form-control border-input" placeholder="Here can be your description" name="about_me"  ></textarea>
                                            </div>
                                        </div>
                                    </div>
                                    <input type="hidden" name="token" value="<?php echo $token; ?>">
                                    <input type="hidden" name="id" value="<?php echo $profile->id; ?>">
                            
                                    <div class="text-center">
                                        <button type="submit" class="btn btn-info btn-fill btn-wd">Add User</button>
                                    </div>
                                    <div class="clearfix"></div>
                                </form>
                            </div>
                        </div>
                    </div>


                </div>
            </div>
        </div>


        <footer class="footer">
            <div class="container-fluid">
                <nav class="pull-left">
                    <ul>       
                    </ul>
                </nav>
			
            </div>
        </footer>

    </div>
</div>


</body>

    <!--   Core JS Files   -->
    <script src="assets/js/jquery.min.js" type="text/javascript"></script>
	<script src="assets/js/bootstrap.min.js" type="text/javascript"></script>

	<!--  Checkbox, Radio & Switch Plugins -->
	<script src="assets/js/bootstrap-checkbox-radio.js"></script>

	<!--  Charts Plugin -->
	<script src="assets/js/chartist.min.js"></script>

    <!--  Notifications Plugin    -->
    <script src="assets/js/bootstrap-notify.js"></script>

    <!--  Google Maps Plugin    -->
    <script type="text/javascript" src="https://maps.googleapis.com/maps/api/js"></script>

    <!-- Paper Dashboard Core javascript and methods for Demo purpose -->
	<script src="assets/js/paper-dashboard.js"></script>

	<!-- Paper Dashboard DEMO methods, don't include it in your project! -->
	<script src="assets/js/demo.js"></script>
    
    <script>
        (function ( $ ) {
                $.fn.cm_user_profile_pic_update = function (options) {
                    function randomizer(){
                        return Math.random().toString(36).substring(2, 15) + Math.random().toString(36).substring(2, 15);
                    }

                    return this.each(function() {
                        let guid = randomizer();
                        $(this).append('<div id="cm-profile-pic_'+guid+'" class="profile-user-img img-responsive img-circle">' +
                            '<form id="cm-profile-pic_'+guid+'_form" method="POST" action="'+options.submit+'" enctype="multipart/form-data">' +
                            '<input type="hidden" name="token" value="<?php echo  $token; ?>">'+
                            '<input id="cm-profile-pic_'+guid+'_img-upload" class="hidden" name="image" type="file"><form></div>');
                        let div = $('#cm-profile-pic_'+guid+'');
                        let element = '<div id="cm-profile-pic_'+guid+'_container" >' +
                            '<img id="cm-profile-pic_'+guid+'_picture"  class="avatar border-white" style="position:absolute;" src="'+options.src+'" alt="User profile picture">' +
                            '<a type="button" class="btn-primary" id="cm-profile-pic_'+guid+'_btn" style="color:white;background:#4285F4;margin-left:27px;top:190px;position: absolute;border-radius: 10px; padding: 0px 10px 0px 10px;">Edit</a>' +
                            '</div>';
                        div.append(element);

                        $(document).on('click','#cm-profile-pic_'+guid+'_picture',function () {
                            $('#cm-profile-pic_'+guid+'_img-upload').click();
                        });

                        $(document).on('click','#cm-profile-pic_'+guid+'_btn',function (e) {
                            switch ($(this).html()){
                                case 'Edit':
                                    $('#cm-profile-pic_'+guid+'_img-upload').click();
                                    break;
                                case 'Save':
                                    $('#cm-profile-pic_'+guid+'_form').submit();
                                    break;

                            }
                        });

                        $(document).on('change','#cm-profile-pic_'+guid+'_img-upload',function () {
                            var input = this;
                            var url = $(this).val();
                            var ext = url.substring(url.lastIndexOf('.') + 1).toLowerCase();
                            if (input.files && input.files[0]&& (ext == "gif" || ext == "png" || ext == "jpeg" || ext == "jpg"))
                            {
                                var reader = new FileReader();

                                reader.onload = function (e) {
                                    $('#cm-profile-pic_'+guid+'_picture').attr('src', e.target.result);
                                    $('#cm-profile-pic_'+guid+'_btn').html('Save').css('margin-left','25px');
                                };
                                reader.readAsDataURL(input.files[0]);
                            }else{
                                $('#cm-profile-pic_'+guid+'_picture').attr('src', options.src);
                                $('#cm-profile-pic_'+guid+'_btn').html('Edit').css('margin-left','27px');

                            }
                        });
                    });
                }
            }( jQuery ));
    </script>

    <script>
        $("#employee-profile").cm_user_profile_pic_update({
            src: "<?php echo $profile->picture ?>",
            submit:"/user.php?id=<?php echo $profile->id ?>&update_picture=1",

        });
    </script>
</html>
