<?php
/**
 * The template for displaying the footer.
 *
 * Contains the closing of the id=main div and all content
 * after.  Calls sidebar-footer.php for bottom widgets.
 *
 * @package WordPress
 * @subpackage Twenty_Ten
 * @since Twenty Ten 1.0
 */
?>
	</div><!-- #main -->

	<div id="footer" role="contentinfo">
		<div id="colophon">

<?php
	/* A sidebar in the footer? Yep. You can can customize
	 * your footer with four columns of widgets.
	 */
	get_sidebar( 'footer' );
?>

				<div id="site-info">
				<a href="<?php echo home_url( '/' ); ?>" title="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>" rel="home">
					<img src="<?php bloginfo("template_directory") ?>/images/footer_logo.jpg" />
				</a>
				
				</div><!-- #site-info -->
				<div id="jumpNav">
					<select id="where">
						<option>跳转到相关子站</option>
						<?php wp_nav_menu( array( 'theme_location' => 'footer-menu' ,'echo'  => true,'walker' =>new Walker_Nav_Menu_Into_Select )); ?>

					</select>
					<a href="" id="foot_btn"><img src="<?php bloginfo("template_directory") ?>/images/go.gif" /></a>
				</div>
					<script>
						jQuery(document).ready(function(){ 
							jQuery("#foot_btn").click(function(e){
								location.href =jQuery('#where').val();
								e.preventDefault();
								
							})

						});
					</script>
				<div id="foot-nav">
					<p>	<a href="#" id="">关于我们</a> | <a href="#">条款声明</a> | <a href="#">招聘信息</a>|<a href="#" id="">加盟事业</a> | <a href="#">站点地图</a> | <a href="#">联系我们</a>
					</p>
					<p>tel : 020 3446-8622  /  faq : 02) 123-4567</p>
					<p>版权所有 © 2009 霭德教育集团</p>
				</div>
		</div><!-- #colophon -->
	</div><!-- #footer -->

</div><!-- #wrapper -->

<?php
	/* Always have wp_footer() just before the closing </body>
	 * tag of your theme, or you will break many plugins, which
	 * generally use this hook to reference JavaScript files.
	 */

	wp_footer();
?>
</body>
</html>
