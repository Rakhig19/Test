<?php 
if(!defined('ABSPATH')){
    header("Location://http://localhost/bootstrap/");
    die(); 
}
?>

<div class="login-form">

<form action="<?php get_the_permalink(); ?>" method="post">

    UserName : <input Type="text" name="username" id="login_username"> <br>

    Password : <input Type="text" name="pass" id="login_pass"> <br>

    <input Type="submit" name="user_login" id="user_login" value="login">    

</form>

</div>