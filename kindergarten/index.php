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
				<div class="breadcrame">当前位置: <span>集团首页</span> > 幼儿园 ><span>首页</span> </div>
				<div class="front-gird">
				<div>
						<h2>幼儿园简介</h2>
					<img src="<?php bloginfo('template_url'); ?>/images/info.gif" />
					<p>御景湾幼儿园是 <span>霭德教育集团</span> 旗下幼儿园，隶属珠江御景湾小区配套园所</p>
					<p>霭德教育本着“少成若天性，习惯如自然”、“好习惯，一生幸福”的教育理念，注重四大优秀品质的培养【关爱（Affection）、主动（Initiative）、勤勉（Diligence）、认真（Earnest）】，注重好习惯的养成教育，进而让孩子们更加健康、自信、聪慧与乐群
。</p>
				</div>

					<div>
						<h2>园所新闻</h2> <a class="more">浏览更多</a>
					<img src="<?php bloginfo('template_url'); ?>/images/cat.gif" />
						<?php factory_get_byslug_wpmu("news",2,'teacher') ?>

					</div>
				<div>
						<h2>幼儿园文化活动</h2> <a class="more">浏览更多</a>
					<img src="<?php bloginfo('template_url'); ?>/images/Nursery_index1_19.gif" />
					</div>
					
<?php 			
					query_posts('showposts=5&category_name='.$kg_column_1);

						if (have_posts()) : ?>
							<?php while (have_posts()) : the_post();?>
								<a href="<?php the_permalink(); ?>" ><?php the_time(’m-d-y’) ?><?php the_title();	?></a>	
							<?php endwhile; ?>
						<?php endif; 
 					wp_reset_query();
					query_posts('showposts=5&category_name='.$kg_column_2);

						if (have_posts()) : ?>
							<?php while (have_posts()) : the_post();?>
								<a href="<?php the_permalink(); ?>" ><?php the_date(’m-d-y’) ?><?php the_title();	?></a>	
							<?php endwhile; ?>
						<?php endif; 

						
					query_posts('showposts=5&category_name='.$kg_column_3);

						if (have_posts()) : ?>
							<div class="cat">
								<div class="cat_head">
									<h2>temp <?php echo $kg_column_3; ?></h2><a href="<?php  get_category_by_slug( $kg_column_3)?>">浏览更多</a>
								</div>
								<div class="cat_img"><img src="" alt=""></div>

								<div class="cat_text">
									<ul>
										<?php while (have_posts()) : the_post();?>
										<li>	<a href="<?php the_permalink(); ?>" >|<?php the_date(’Y-m-d’) ?>| <?php the_title();	?></a>	</li>
										<?php endwhile; ?>
									</ul>
								</div>
							</div>
						<?php endif; ?>
				</div>




		<?php
			// A second sidebar for widgets, just because.
			if ( is_active_sidebar( 'secondary-widget-area' ) ) : ?>

				<div id="secondary" class="widget-area" role="complementary">
					<ul class="xoxo">
						<?php dynamic_sidebar( 'secondary-widget-area' ); ?>
					</ul>
				</div><!-- #secondary .widget-area -->

		<?php endif; ?>




			</div><!-- #content -->
		</div><!-- #container -->



<?php get_sidebar(); ?>
<?php get_footer(); ?>
