<?php
/**
 * The Sidebar containing the primary and secondary widget areas.
 *
 * @package WordPress
 * @subpackage Twenty_Ten
 * @since Twenty Ten 1.0
 */
?>

		<div id="primary" class="widget-area" role="complementary">


			<ul class="xoxo">
				<li id="sub_category">
					<h3 class="widget-title">目录:</h3>
			    <?php
				    if (is_category()) {
				    $this_category = get_category($cat);
				    }
				    ?>
				    <?php
				    if($this_category->category_parent)
				    $this_category = wp_list_categories('orderby=id&show_count=0
				    &title_li=&use_desc_for_title=1&child_of='.$this_category->category_parent.
				    "&echo=0"); else
				    $this_category = wp_list_categories('orderby=id&depth=1&show_count=0
				    &title_li=&use_desc_for_title=1&child_of='.$this_category->cat_ID.
				    "&echo=0");
				    if ($this_category) { ?> 

				<ul>
				<?php echo $this_category; ?>

				</ul>

				<?php } ?>
			</li>
<?php
	/* When we call the dynamic_sidebar() function, it'll spit out
	 * the widgets for that widget area. If it instead returns false,
	 * then the sidebar simply doesn't exist, so we'll hard-code in
	 * some default sidebar stuff just in case.
	 */
	if ( ! dynamic_sidebar( 'primary-widget-area' ) ) : ?>

			<li id="search" class="widget-container widget_search">
				<?php get_search_form(); ?>
			</li>

			<li id="archives" class="widget-container">
				<h3 class="widget-title"><?php _e( 'Archives', 'twentyten' ); ?></h3>
				<ul>
					<?php wp_get_archives( 'type=monthly' ); ?>
				</ul>
			</li>

			<li id="meta" class="widget-container">
				<h3 class="widget-title"><?php _e( 'Meta', 'twentyten' ); ?></h3>
				<ul>
					<?php wp_register(); ?>
					<li><?php wp_loginout(); ?></li>
					<?php wp_meta(); ?>
				</ul>
			</li>

		<?php endif; // end primary widget area ?>
			</ul>
		</div><!-- #primary .widget-area -->

<?php
	// A second sidebar for widgets, just because.
	if ( is_active_sidebar( 'secondary-widget-area' ) ) : ?>

		<div id="secondary" class="widget-area" role="complementary">
			<ul class="xoxo">
				<?php dynamic_sidebar( 'secondary-widget-area' ); ?>
			</ul>
		</div><!-- #secondary .widget-area -->

<?php endif; ?>



