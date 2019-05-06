<?php
//  include 'server.php';
 require_once 'core/init.php';
 include 'guards/authenticated.php';

 if(Input::exists('post')) {
    if(Token::check(Input::get('token'))) {
        $user = new User(Input::get('id'));

        if(Input::get("update_picture")==1){
            $image=$_FILES['image']['name']; 
            $expimage=explode('.',$image);
            $imageexptype=$expimage[1];
            $date = date('m/d/Yh:i:sa', time());
            $rand=rand(10000,99999);
            $encname=$date.$rand;
            $imagename=md5($encname).'.'.$imageexptype;
            $imagepath="assets/img/profile/".$imagename;
            move_uploaded_file($_FILES["image"]["tmp_name"],$imagepath);

            // die("imagepath:".$imagepath);
            $user->update(array(
                'picture' => $imagepath,
            ),Input::get('id'));

            $user_id = Input::get('id');
            $user = new User($user_id);
            $profile = $user->data();
            Redirect::to("user.php?id=".$profile->id);

        }else{
            $user->update(array(
                'name' => Input::get('name'),
                'username' => Input::get('username'),
                'email' => Input::get('email'),
                'address' => Input::get('address'),
                'city' => Input::get('city'),
                'country' => Input::get('country'),
                'postal_code' => Input::get('postal_code'),
                'about_me' => Input::get('about_me')
            ),Input::get('id'));

            
            $user_id = Input::get('id');
            $user = new User($user_id);
            $profile = $user->data();

            $cur_user = new User();
            if( !$cur_user->is_admin() &&  $cur_user->data()->id != $user->data()->id){
                Redirect::to('index.php');
            }
            Redirect::to("user.php?id=".$profile->id);
            
        }
        
        

    }else{
        die("Please Reload Page");
    }

 }else if(Input::exists('get')) {
    $user_id = Input::get('id');
    $user = new User($user_id);
    $profile = $user->data();

    $cur_user = new User();
    if( !$cur_user->is_admin() &&  $cur_user->data()->id != $user->data()->id){
        Redirect::to('index.php');
    }
 }else{
    $active_nav = "user";
    $user = new User();
    $profile = $user->data();
 }
 $active_nav = "user";
 $token = Token::generate();

$name = $profile->name;
$username = $profile->username;
$email = $profile->email;
$address = $profile->address;
$city = $profile->city;
$country = $profile->country;
$postal_code = $profile->postal_code;
$about_me = $profile->about_me;
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
        if((new User)->is_admin())
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
                    <div class="col-lg-4 col-md-5">
                        <div class="card card-user">
                            <div class="image">
                                <img src="assets/img/background.jpg" alt="..."/>
                            </div>
                            <div class="content">
                                <div class="author">
                                <div id="employee-profile" class="img img-bordered img-responsive" style="height: 200px; width: 200px;"> </div>
                                  <div style="position:absolute;margin-left:35%;bottom:20%;">
                                    <h4 class="title" ><?php echo $profile->name; ?><br />
                                        <a href="#"><small><?php echo "@".$profile->name;?></small></a>
                                    </h4>
                                  </div>
                                  
                                </div>
                                <p class="description text-center">
                     
                                </p>
                            </div>
                            <hr>
                        </div>
                        <div class="card">
                        </div>
                    </div>
                    <div class="col-lg-8 col-md-7">
                        <div class="card">
                            <div class="header">
                                <h4 class="title">Edit Profile</h4>
                            </div>
                            <div class="content">
                                <form method="post" action="user.php?id=<?php echo $profile->id ?>"">
                                    <div class="row">
                                        <div class="col-md-5">
                                            <div class="form-group">
                                                <label>Company</label>
                                                <input required type="text" class="form-control border-input" name="name" placeholder="Company" value="<?php echo $profile->name;?>">
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label>Username</label>
                                                <input required type="text" class="form-control border-input" name="username" placeholder="Username" value="<?php echo $profile->username; ?>"">
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="exampleInputEmail1">Email address</label>
                                                <input required type="email" class="form-control border-input" name="email" placeholder="Email" value="<?php echo $profile->email;?>">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label>Address</label>
                                                <input required type="text" class="form-control border-input" name="address" placeholder="Address" value="<?php echo $profile->address;?>">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label>City</label>
                                                <input required type="text" class="form-control border-input" name="city" placeholder="City" value="<?php echo $profile->city;?>">
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label>Country</label>
                                                <input required type="text" class="form-control border-input" name="country" placeholder="Country" value="<?php echo $profile->country;?>">
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label>Postal Code</label>
                                                <input required type="number" class="form-control border-input" name="postal_code" placeholder="ZIP Code" value="<?php echo $profile->postal_code;?>">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label>About Me</label>
                                                <textarea  required rows="5" class="form-control border-input" placeholder="Here can be your description" name="about_me" value="<?php echo $profile->about_me;?>" ><?php echo $profile->about_me;?></textarea>
                                            </div>
                                        </div>
                                    </div>
                                    <input type="hidden" name="token" value="<?php echo $token; ?>">
                                    <input type="hidden" name="id" value="<?php echo $profile->id; ?>">
                            
                                    <div class="text-center">
                                        <button type="submit" class="btn btn-info btn-fill btn-wd">Update Profile</button>
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
