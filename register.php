<?php 
/**
 * Template Name: RegistrationPage
 */ 
get_header();
?>

<div class="caontainer">
<div class="alert_hide_show"></div>
<?php 
                        
         if (have_posts()) : while (have_posts()) : the_post(); ?>
            <?php the_content(); ?>
            <?php endwhile; endif; ?>
</div>

<script src="<?php echo get_template_directory_uri(); ?>/assets/js/jquery.min.js"></script>
<script src="<?php echo get_template_directory_uri(); ?>/assets/js/jquery.validate.min.js"></script>
<script>
  jQuery(document).ready(function($){
    $("#registerForm").validate({
     rules:{
      firstname:{
        required:true
      },
      lastname: {
        required: true
      },
      user_email:{
        required: true
      },
       username:{
        required: true
      },
     password:{
      required:true
     }
        },
    messages:
      {
      "firstname": "Please enter firstname",
      "lastname": "Please enter lastname",
      "email": "please enter your email id",
      "username": "please enter your username",
      "password": "enter your password",

    },
    submitHandler: function(form,e) {
      e.preventDefault();
       $.ajax({
        url: "<?php echo site_url();?>/wp-admin/admin-ajax.php",
        type: form.method,
        data: $(form).serialize(),
        success: function(response) {
          var responseA = JSON.parse(response);
          if(responseA.status=='sucess'){
            $(".alert_hide_show").addClass("alert-success");
            $(".alert_hide_show").show();
            $(".alert_hide_show").text(responseA.message);
       setTimeout(function() {
                     document.location.href = "<?php echo site_url().'/register'; ?>";
              }, 2500);
          }else{
            $(".alert_hide_show").addClass("alert-danger");
            $(".alert_hide_show").show();
            $(".alert_hide_show").text(responseA.message);
          }
        }            
      });
    }
   });
  })
</script>

<?php get_footer();
?>