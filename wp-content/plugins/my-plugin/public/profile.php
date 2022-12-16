<?php 
//echo "User Id".get_current_user_id();
//die();
if(!defined('ABSPATH')){
    header("Location://http://localhost/bootstrap/");
    die(); 
}

if(isset($_POST['update'])){

    $user_id = esc_sql($_POST['user_id']);
    $fname = esc_sql($_POST['user_fname']);
    $lname = esc_sql($_POST['user_lname']);

    $userdate = array(
        'ID'  => $user_id,
        'first_name'  => $fname,
        'last_name'  => $lname,


    );
   $user = wp_update_user($userdate);

   if(is_wp_error($user)){
        echo "Can not update: ".$user->get_error_message();
   }

}
   
$user_id = get_current_user_id();
$user = get_userdata($user_id);
echo $user;

if($user != false) :
   
    $user_type =  get_usermeta($user_id,'type');
    $fname =  get_usermeta($user_id,'first_name');
    $lname =  get_usermeta($user_id,'last_name');
?>

<h1>Hi <?php echo " $fname  $lname <small>($user_type)</small>"; ?></h1>
<p>Not  <?php echo " $fname  $lname "; ?> <a href="<?php echo wp_logout_url(); ?>">Logout</a> :</p>

<?php 
endif;
?>


<div class="login-form">

<form action="<?php get_the_permalink(); ?>" method="post">

    UserName : <input Type="text" name="user_fname" id="user_fname" value="<?php $fname; ?> "> <br>

    Last Name : <input Type="text" name="user_lname" id="user_lname" value="<?php $lname; ?>"> <br>

    <input Type="hidden" name="user_id" id="user_id" value="<?php $user_id; ?>">    
       

    <input Type="submit" name="update" id="update" value="Update">    

</form>

</div>