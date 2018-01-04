<?php 
/**
 * Template Name: LoginPage 
 */ 
get_header();


?>


<div class="caontainer">
<?php 
                            
         if (have_posts()) : while (have_posts()) : the_post(); ?>
            <?php the_content(); ?>
            <?php endwhile; endif; ?>
  </div>
<script src="<?php echo get_template_directory_uri(); ?>/assets/js/jquery.min.js"></script>
<script src="<?php echo get_template_directory_uri(); ?>/assets/js/jquery.validate.min.js"></script>
<script>
	jQuery(document).ready(function($){
		$("#loginForm").validate({
		 rules:{
			username:{
				required:true
			},
			password: {
				required: true
			}
		},
		messages:
	    {
			"username": "Please enter username",
			"password": "Please enter password",
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
						document.location.href = "<?php echo site_url().'/dashboard'; ?>";
					}else if(responseA.status=="warning"){
						$(".alert_hide_show").addClass("alert-warning");
						$(".alert_hide_show").show();
						$(".alert_hide_show").text(responseA.message);
						$("#login_form")[0].reset();
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
<?php get_footer();?>