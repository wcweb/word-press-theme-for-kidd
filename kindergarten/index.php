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

get_header(); ?>

		<div id="container">
			<div id="content" role="main">
	
			<?php
			/* Run the loop to output the posts.
			 * If you want to overload this in a child theme then include a file
			 * called loop-index.php and that will be used instead.
			 */
			 get_template_part( 'loop', 'index' );

			?>
			

<?php 			
					query_posts('showposts=5&category_name='.$kg_column_1);

						if (have_posts()) : ?>
							<?php while (have_posts()) : the_post();?>
								<a href="<?php the_permalink(); ?>" ><?php the_title();	?></a>	
							<?php endwhile; ?>
						<?php endif; 

					query_posts('showposts=5&category_name='.$kg_column_2);

						if (have_posts()) : ?>
							<?php while (have_posts()) : the_post();?>
								<a href="<?php the_permalink(); ?>" ><?php the_title();	?></a>	
							<?php endwhile; ?>
						<?php endif; 


					query_posts('showposts=5&category_name='.$kg_column_3);

						if (have_posts()) : ?>
							<?php while (have_posts()) : the_post();?>
								<a href="<?php the_permalink(); ?>" ><?php the_title();	?></a>	
							<?php endwhile; ?>
						<?php endif; ?>


			</div><!-- #content -->
		</div><!-- #container -->

<?php 
 wp_reset_query();

if(is_home()) :?>


			<div id="primary" class="widget-area" role="complementary">

				<div class="board">
				
	<?php factory_get_byslug_wpmu("news",2,'teacher') ?>


			</div>


	</div>
<?php endif; // front page ?>


<?php get_sidebar(); ?>
<?php get_footer(); ?>
