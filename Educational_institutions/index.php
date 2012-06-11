<?php
/**
 * The main template file.
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * E.g., it puts together the home page when no home.php file exists.
 * Learn more: http://codex.wordpress.org/Template_Hierarchy
 *
 * @package WordPress
 * @subpackage Twenty_Ten
 * @since Twenty Ten 1.0
 */

get_header(); 



global $options;
foreach ($options as $value) {
	if (get_settings( $value['id'] ) === FALSE) { $$value['id'] = $value['std']; } else { $$value['id'] = get_settings( $value['id'] ); }
}


?>

		<div id="container">

			<div id="content" role="main">

 <div class="featured">

	        <div class="slider-wrapper theme-default">
            <div class="ribbon"></div>
				<div id="slider" class="nivoSlider">
					<?php 			
					query_posts('showposts=5&category_name='.$ftfl_frsilder_cat);

						if (have_posts()) : ?>
						<?php while (have_posts()) : the_post();
								$image = "";
								$first_image = $wpdb->get_results(
								
								"SELECT guid FROM $wpdb->posts WHERE post_parent = '$post->ID' "
								."AND post_type = 'attachment' ORDER BY `post_date` ASC LIMIT 0,1"
								
								);
								
								if ($first_image) {
									$image = $first_image[0]->guid;
								
								?>
								<!-- <a href="http://dev7studios.com"><img src="images/up.jpg" alt="" title="This is an example of a caption" /></a> -->

						<a href="<?php the_permalink(); ?>" ><img  src="<?php echo plugin_dir_url('vslider')."vslider/timthumb.php?src=".$image."&w=580&h=300&zc=1&q=100" ?>" width="580" height="300px" title="#<?php the_title(); ?> " /></a>
								
								
								<?php 
								}
								endwhile; ?>
						<?php endif; ?>

						</div>

						<?php rewind_posts(); ?>
						<?php while (have_posts()) : the_post();?>


						 

							            <div id="<?php the_title(); ?>" class="nivo-html-caption"><a href="<?php the_permalink(); ?>" ><?php the_title(); ?>
							            	</a>
							            	<small><?php the_time('F jS, Y') ?></small>
            </div>

						<?php endwhile; ?>
			</div>

				
	<script>
	jQuery(document).ready(function(){ 
	            if(jQuery('#slider')){jQuery('#slider').nivoSlider({controlNav:true});}
	        })
	</script>
       
        <div class="ffix"></div>
    </div><!-- #featured -->


			</div><!-- #content -->
		</div><!-- #container -->

<?php 
 wp_reset_query();

if(is_home()) :?>


			<div id="primary" class="widget-area" role="complementary">

				<div class="board">
				
	<?php factory_get_byslug_wpmu("news",2)?>


			</div>


	</div>
<?php endif; // front page ?>

<?php if(!is_front_page()) :?>
<?php get_sidebar(); ?>
<?php endif;  ?>



<?php get_footer(); ?>
