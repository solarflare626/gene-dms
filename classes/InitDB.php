<?php
function create_user($data){
    $user = new User();
    try {
        $user->create($data);
        return true;
    } catch(Exception $e) {
        // echo $error, '<br>';
        // die("error");
        die("$e");
    }

}
class InitDB{

    private $_db;
    
    public function __construct() {
        $this->_db = DB::getInstance();
    }

    public static function initialize(){
        $db = DB::getInstance();

        $db->query("
            CREATE TABLE IF NOT EXISTS `groups` (
                `id` int(11) NOT NULL AUTO_INCREMENT,
                `name` varchar(20) NOT NULL,
                `permissions` text NOT NULL,
                PRIMARY KEY (`id`)
            ) 
        ");
       

        $db->query("
            INSERT INTO `groups` (`id`, `name`, `permissions`) VALUES
            (1, 'Standard User', ''),
            (2, 'Administrator', '{\r\n\"admin\": 1,\r\n\"moderator\" : 1\r\n}');
        ");

        $db->query("
            CREATE TABLE IF NOT EXISTS `users` (
                `id` int(11) NOT NULL AUTO_INCREMENT,
                `username` varchar(20) NOT NULL,
                `password` varchar(64) NOT NULL,
                `salt` varchar(32) NOT NULL,
                `name` varchar(50) NOT NULL,
                `joined` datetime NOT NULL,
                `group` int(11) NOT NULL,
                PRIMARY KEY (`id`)
            )
        ");
    
        

        #user_session
        $db->query("
            CREATE TABLE IF NOT EXISTS `users_session` (
                `id` int(11) NOT NULL,
                `user_id` int(11) NOT NULL,
                `hash` varchar(64) NOT NULL
            )
        ");
        

        #requests
        $db->query("
            CREATE TABLE IF NOT EXISTS `requests` (
                `id` int(11) NOT AUTO_INCREMENT,
                `user_id` int(11) NOT NULL,
                `title` varchar(255),
                `message` longtext,
                `created_at` datetime NOT NULL,
                `deleted_at` datetime NOT NULL,
                PRIMARY KEY (`id`)
            )
        ");

        #notifications
        $db->query("
            CREATE TABLE IF NOT EXISTS `notifications` (
                `id` int(11) NOT NULL AUTO_INCREMENT,
                `user_id` int(11) NOT NULL,
                `type` varchar(255),
                `type_id` int(11),
                `is_active` boolean,
                `created_at` datetime NOT NULL,
                `deleted_at` datetime NOT NULL,
                PRIMARY KEY (`id`)
            )
        ");

        

         #indicators
         $db->query("
            CREATE TABLE IF NOT EXISTS `indicators` (
                `id` int(11) NOT NULL AUTO_INCREMENT,
                `name` varchar(255),
                `created_at` datetime,
                `deleted_at` datetime,
                PRIMARY KEY (`id`)
            )
        ");

        #forms
        $db->query("
            CREATE TABLE IF NOT EXISTS `forms` (
                `id` int(11) NOT NULL AUTO_INCREMENT,
                `name` varchar(255),
                `indicator_id` int(11),
                `created_at` datetime,
                `deleted_at` datetime,
                PRIMARY KEY (`id`)
            )
        ");

        #metrics
        $db->query("
            CREATE TABLE IF NOT EXISTS `metrics` (
                `id` int(11) NOT NULL AUTO_INCREMENT,
                `metric` longtext,
                `form_id` int(11),
                `created_at` datetime,
                `deleted_at` datetime,
                PRIMARY KEY (`id`)
            )
        ");

        #request_forms
        $db->query("
            CREATE TABLE IF NOT EXISTS `request_forms` (
                `id` int(11) NOT NULL AUTO_INCREMENT,
                `request_id` int(11),
                `form_id` int(11),
                `is_submitted` boolean,
                `created_at` datetime,
                `deleted_at` datetime,
                PRIMARY KEY (`id`)
            )
        ");


        $salt = Hash::salt(32);
        create_user(array(
            'name' => "admin",
            'username' => "admin",
            'password' => Hash::make("admin", $salt),
            'salt' => $salt,
            'joined' => date('Y-m-d H:i:s'),
            'group' => 2
        ));

        $salt = Hash::salt(32);
        create_user(array(
            'name' => "ched",
            'username' => "ched",
            'password' => Hash::make("ched", $salt),
            'salt' => $salt,
            'joined' => date('Y-m-d H:i:s'),
            'group' => 1
        ));

        $salt = Hash::salt(32);
        create_user(array(
            'name' => "deped",
            'username' => "deped",
            'password' => Hash::make("deped", $salt),
            'salt' => $salt,
            'joined' => date('Y-m-d H:i:s'),
            'group' => 1
        ));

        
    }
}