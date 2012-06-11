<?php
/**
 * The template for displaying Category Archive pages.
 *
 * @package WordPress
 * @subpackage Twenty_Ten
 * @since Twenty Ten 1.0
 */

get_header(); ?>

		<div id="container">
			<div id="content" role="main">
			<div class="breadcrame">•当前位置: <a href="<?php echo get_current_site()->path; ?>"><span><?php echo get_current_site()->site_name;?></span></a> > 

				<?php global $blog_id ;
				?>

				<a href="<?php echo get_blog_option($blog_id,'siteurl'); ?>"><span> <?php echo get_blog_option($blog_id,'blogname'); ?></span></a> >
				<?php   
					printf( $kg_garden_name.'<span>' . single_cat_title( '', false ) . '</span>' );
				?> 
			</div>
			<h1 class="page-title"><?php
					printf( '<span>' . single_cat_title( '', false ) . '</span>' );
				?>
			</h1>
				<div class="categories">
				<?php
					// $category_description = category_description();
					// if ( ! empty( $category_description ) )
					// 	echo '<div class="archive-meta">' . $category_description . '</div>';

				/* Run the loop for the category page to output the posts.
				 * If you want to overload this in a child theme then include a file
				 * called loop-category.php and that will be used instead.
				 */
				 get_template_part( 'loop', 'category' );
				?>
				</div>

				
			</div><!-- #content -->
		</div><!-- #container -->

<?php get_sidebar(); ?>
<?php get_footer(); ?>
