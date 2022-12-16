<?php 
if(!defined('ABSPATH')){
    header("Location://http://localhost/bootstrap/");
    die(); 
}
    if(isset($_POST['register'])){

        global $wpdb;


        $fName = $wpdb ->escape($_POST['user_fname']);
        $LName = $wpdb ->escape($_POST['user_lname']);
        $UName = $wpdb ->escape($_POST['user_name']);
        $Email = $wpdb ->escape($_POST['email']);
        $UPass = $wpdb ->escape($_POST['u_pwd']);
        $CName = $wpdb ->escape($_POST['c_pwd']);

        if($UPass == $CName ){

           //wp_insert_user
            $user_data = array(

                'user_login' =>$UName,
                'user_email' =>$Email,
                'first_name' =>$fName,
                'last_name' =>$LName,
                'display_name' =>$FName.' '.$LName,
                'user_pass' =>$UPass,
                
            );

           $result = wp_insert_user($user_data);
            
           //wp_create_user
           //$result = wp_create_user($UName,$UPass,$Email);
           if(!is_wp_error($result)){
                echo "user created Id".$result;
            // add custom field form user data - value stored user_meta table 
            add_user_meta($result,'type','Faclty');
            update_user_meta($result,'show_admin_bar_front',false);

           }else{
                echo $result->get_error_message();
           }

        }else{
            echo "password not match";
        }
       
    }
?>
<div class= "form-wrapper">
   
     <div class="regi-form">
        <form action="<?php get_the_permalink(); ?>" method="post">

            First Name : <input Type="text" name="user_fname" id="user_fname"> <br>

            Last Name : <input Type="text" name="user_lname" id="user_lname"> <br>

            User Name : <input Type="text" name="user_name" id="user_name"> <br>

            Email : <input Type="text" name="email" id="email"> <br>

            Password : <input Type="password" name="u_pwd" id="u_pwd"> <br>

            Confirm Password  : <input Type="password" name="c_pwd" id="c_pwd"> <br>

            <input Type="submit" name="register" id="register" value="Register"> <br>
        </form>
    </div>
</div>