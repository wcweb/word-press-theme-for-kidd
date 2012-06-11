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
			<div id="content" role="main" class="front-page">

				<div class="breadcrame">•当前位置: <a href="<?php echo get_current_site()->path; ?>"><span><?php echo get_current_site()->site_name;?></span></a> > 

				<?php global $blog_id ;
				?>

				<a href="<?php echo get_blog_option($blog_id,'siteurl'); ?>"><span> <?php echo get_blog_option($blog_id,'blogname'); ?></span></a> ><span>首页</span>
				</div>


				<div class="front-gird">
				<div class="intro">
						<h2 class="col-head">幼儿园简介</h2>
					
					<?php 
					$introPostID = $kg_intorPage_title;

					$introPage=get_post( $introPostID); 


					$image = "";
					$first_image = $wpdb->get_results(
					
					"SELECT guid FROM $wpdb->posts WHERE post_parent = '$introPostID' "
					."AND post_type = 'attachment' ORDER BY `post_date` ASC LIMIT 0,1"
					
					);
					
					if ($first_image) {
						$image = $first_image[0]->guid;
					}else{
						$image =  get_the_post_thumbnail( $introPostID ); 
					}
					


					?> 
					<div class="intro-Pic">
					<a href="<?php echo $introPage->guid; ?>"  class="pic_more" ><img  src="<?php echo plugin_dir_url('vslider')."vslider/timthumb.php?src=".get_image_abspath($image)."&w=190&h=100&zc=1&q=100" ?>" title="#<?php the_title(); ?> " /><span>点击浏览</span></a>
					</div>
					<div class="intro-Page">
					<p ><?php echo $introPage->post_content; ?></p>
					</div>


				</div>



					
<?php 			
					query_posts('showposts=5&category_name='.$kg_column_1);

						if (have_posts()) : ?>
							<div class="cat">
								<div class="cat_head">
									<p> <span><?php echo get_category_by_slug( $kg_column_1)->name; ?></span>
									<a href="<?php echo get_category_link(get_category_by_slug( $kg_column_1)->term_id) ?>" class="more">浏览更多</a></p>
								</div>
								<div class="cat_img"><img src="<?php bloginfo('template_url'); ?>/images/col_pic_1.gif ?>" alt=""></div>

								<div class="cat_text">
									<ul>
										<?php while (have_posts()) : the_post();?>
										<li>	<a href="<?php the_permalink(); ?>" >|<?php echo get_the_date('Y-m-d'); ?>|&nbsp;&nbsp;<?php the_title();	?></a>	</li>
										<?php endwhile; ?>
									</ul>
								</div>
							</div>
						<?php endif; 
 					wp_reset_query();
					query_posts('showposts=5&category_name='.$kg_column_2);

						if (have_posts()) : ?>
							<div class="cat">
								<div class="cat_head">
									<p> <span><?php echo get_category_by_slug( $kg_column_2)->name; ?></span>
									<a href="<?php echo get_category_link(get_category_by_slug( $kg_column_2)->term_id) ?>" class="more">浏览更多</a></p>
								</div>
								<div class="cat_img"><img src="<?php bloginfo('template_url'); ?>/images/col_pic_2.gif ?>" alt=""></div>

								<div class="cat_text">
									<ul>
										<?php while (have_posts()) : the_post();   ?>

										<li>	<a href="<?php the_permalink(); ?>" >|<?php echo get_the_date('Y-m-d'); ?>| &nbsp;&nbsp;<?php the_title();?></a>	</li>
										<?php endwhile; ?>
									</ul>
								</div>
							</div>
						<?php endif; 

					wp_reset_query();
					query_posts('showposts=5&category_name='.$kg_column_3);

						if (have_posts()) : ?>
							<div class="cat">
								<div class="cat_head">
									<p> <span><?php echo get_category_by_slug( $kg_column_3)->name; ?></span>
									<a href="<?php echo get_category_link(get_category_by_slug( $kg_column_3)->term_id); ?>" class="more">浏览更多</a></p>
								</div>
								<div class="cat_img"><img src="<?php bloginfo('template_url'); ?>/images/col_pic_3.gif ?>" alt=""></div>

								<div class="cat_text">
									<ul>
										<?php while (have_posts()) : the_post();?>
										<li>	<a href="<?php the_permalink(); ?>" >|<?php echo get_the_date('Y-m-d'); ?>| &nbsp;&nbsp;<?php the_title();	?></a>	</li>
										<?php endwhile; ?>
									</ul>
								</div>
							</div>
						<?php endif; ?>



						<div class="cat">
							<?php $sub_news= explode('_',$kg_news); 	?>
							<div class="cat_head">
									<p> <span>班级博客更新</span><a href="<?php echo get_category_link(get_category_by_slug( $kg_news)->term_id); ?>" class="more">浏览更多</a></p>
								</div>
								<div class="cat_img"><img src="<?php bloginfo('template_url'); ?>/images/col_pic_1.gif ?>" alt=""></div>

								<div class="cat_text">
							<ul><?php factory_get_byslug_wpmu($sub_news[1],2,$kg_admin) ?></ul>
							</div>
						</div>
				</div>





				<div class="cat">

<?php 				
					wp_reset_query();

					query_posts('showposts=4&category_name='.$kg_column_grallery);
						if (have_posts()) :

						 ?>

						<p class="col-head" >幼儿园文化活动</p> <a class="more absright" href="<?php echo get_category_link($kg_column_grallery_id); ?>">浏览更多</a>
						
					
						<?php 

						while (have_posts()) : the_post();

								?>
								<?php
									$image = get_image_abspath(catch_that_image());
								?>
								

						<a href="<?php the_permalink(); ?>" ><img  src="<?php echo plugin_dir_url('vslider')."vslider/timthumb.php?src=".$image."&w=160&h=110&zc=1&q=100" ?>" 
						 title="<?php the_title(); ?> " /></a>
								
								
								<?php 
									
								endwhile; ?>
						<?php endif; ?>

						

						




					</div>

			</div><!-- #content -->
		</div><!-- #container -->



<?php get_sidebar(); ?>
<?php get_footer(); ?>
