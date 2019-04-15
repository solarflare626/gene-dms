
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
                <a href="dashboard-admin.php">
                    <i class="ti-dashboard"></i>
                    <p>Dashboard</p>
                </a>
            </li>
            <li <?php if($active_nav =="indicator") echo 'class="active"' ?>>
                <a href="view-indicators.php">
                    <i class="ti-plus"></i>
                    <p>Add Indicator</p>
                </a>
            </li>
            <li <?php if($active_nav =="forms") echo 'class="active"' ?>>
                <a href="view-forms.php">
                    <i class="ti-notepad"></i>
                    <p>View Forms</p>
                </a>
            </li>
            <li <?php if($active_nav =="requests") echo 'class="active"' ?>>
                <a href="view-requests.php">
                    <i class="ti-notepad"></i>
                    <p>Requests</p>
                </a>
            </li>
            <li <?php if($active_nav =="user") echo 'class="active"' ?>>
                <a href="user-admin.php">
                    <i class="ti-user"></i>
                    <p>User Profile</p>
                </a>
            </li>

            
        </ul>
    </div>
</div>