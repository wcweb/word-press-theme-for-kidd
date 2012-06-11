<?php
/**
 * TwentyTen functions and definitions
 *
 * Sets up the theme and provides some helper functions. Some helper functions
 * are used in the theme as custom template tags. Others are attached to action and
 * filter hooks in WordPress to change core functionality.
 *
 * The first function, twentyten_setup(), sets up the theme by registering support
 * for various features in WordPress, such as post thumbnails, navigation menus, and the like.
 *
 * When using a child theme (see http://codex.wordpress.org/Theme_Development and
 * http://codex.wordpress.org/Child_Themes), you can override certain functions
 * (those wrapped in a function_exists() call) by defining them first in your child theme's
 * functions.php file. The child theme's functions.php file is included before the parent
 * theme's file, so the child theme functions would be used.
 *
 * Functions that are not pluggable (not wrapped in function_exists()) are instead attached
 * to a filter or action hook. The hook can be removed by using remove_action() or
 * remove_filter() and you can attach your own function to the hook.
 *
 * We can remove the parent theme's hook only after it is attached, which means we need to
 * wait until setting up the child theme:
 *
 * <code>
 * add_action( 'after_setup_theme', 'my_child_theme_setup' );
 * function my_child_theme_setup() {
 *     // We are providing our own filter for excerpt_length (or using the unfiltered value)
 *     remove_filter( 'excerpt_length', 'twentyten_excerpt_length' );
 *     ...
 * }
 * </code>
 *
 * For more information on hooks, actions, and filters, see http://codex.wordpress.org/Plugin_API.
 *
 * @package WordPress
 * @subpackage Twenty_Ten
 * @since Twenty Ten 1.0
 */


require_once('functions/twentyten.php');
require_once('functions/walker_nav_menu_into_select.php');
require_once('functions/wpmu.php');



add_action( 'init', 'register_my_menus' );
function register_my_menus() {
	register_nav_menus(
		array(
			'primary-menu' => __( 'Primary Menu' ),
			'secondary-menu' => __( 'Secondary Menu' ),
			'footer-menu' => __( 'footer menu' )
		)
	);
}





$themename = "Kindergarten";
$shortname = "kg";

$options = array (

	array(	"name" => "模板设置",
			"type" => "title"),
			
	array(	"type" => "open"),
	
	array(
			"name"=>"garden_name",
			"id" => $shortname."_garden_name",
			"type" => "text",
			"desc" =>"幼儿园名称"),

	array(
			"name"=>"garden_name",
			"id" => $shortname."_admin",
			"type" => "text",
			"desc" =>"幼儿园管理员 管理下属班级博客"),

	array(
			"name"=>"intorPage",
			"id" => $shortname."_intorPage_title",
			"type" => "text",
			"desc" =>"首页 幼儿园简介 片段关联文章id 在文章编辑 》获取短链接地址"),
	array(
			"name"=>"Announcement",
			"id" => $shortname."_Announcement",
			"type" => "text",
			"desc" =>"首页 通知公告 类别 （单页 还是列表好呢？）"),

	array(
			"name"=>"Week-food",
			"id" => $shortname."_week_food",
			"type" => "text",
			"desc" =>"首页 每周食谱 类别 （单页 还是列表好呢？）"),

	array(
			"name"=>"column_one",
			"id" => $shortname."_column_1",
			"type" => "text",
			"desc" =>"首页栏目一"),	
	array(
			"name"=>"column_two",
			"id" => $shortname."_column_2",
			"type" => "text",
			"desc" =>"首页栏目二"),
	array(
			"name"=>"column_three",
			"id" => $shortname."_column_3",
			"type" => "text",
			"desc" =>"首页栏目三"),
	array(
			"name"=>"column_grallery",
			"id" => $shortname."_column_grallery",
			"type" => "text",
			"desc" =>"首页图片列表栏目"),
	array(
			"name"=>"collect news in similar categorys of  sub sites ",
			"id" => $shortname."_news",
			"type" => "text",
			"desc" =>"子站点新闻关联分类 别名 "),	

	
	array(	"type" => "close")
	
);

function mytheme_add_admin() {

    global $themename, $shortname, $options;

    if ( $_GET['page'] == basename(__FILE__) ) {
    
        if ( 'save' == $_REQUEST['action'] ) {

                foreach ($options as $value) {
                    update_option( $value['id'], $_REQUEST[ $value['id'] ] ); }

                foreach ($options as $value) {
                    if( isset( $_REQUEST[ $value['id'] ] ) ) { update_option( $value['id'], $_REQUEST[ $value['id'] ]  ); } else { delete_option( $value['id'] ); } }

                header("Location: themes.php?page=functions.php&saved=true");
                die;

        } else if( 'reset' == $_REQUEST['action'] ) {

            foreach ($options as $value) {
                delete_option( $value['id'] ); }

            header("Location: themes.php?page=functions.php&reset=true");
            die;

        }
    }

    add_theme_page($themename." Options", "".$themename." Options", 'edit_themes', basename(__FILE__), 'mytheme_admin');
	
}

function mytheme_admin() {

    global $themename, $shortname, $options;

    if ( $_REQUEST['saved'] ) echo '<div id="message" class="updated fade"><p><strong>'.$themename.' settings saved.</strong></p></div>';
    if ( $_REQUEST['reset'] ) echo '<div id="message" class="updated fade"><p><strong>'.$themename.' settings reset.</strong></p></div>';
    
?>
<div class="wrap">
<h2><?php echo $themename; ?> settings</h2>

<form method="post">



<?php foreach ($options as $value) { 
    
	switch ( $value['type'] ) {
	
		case "open":
		?>
        <table width="100%" border="0" style="padding:10px;">
		
        
        
		<?php break;
		
		case "close":
		?>
		
        </table><br />
        
        
		<?php break;
		
		case "title":
		?>
		<table width="100%" border="0" style="background-color:#efefef; padding:5px 10px;"><tr>
        	<td colspan="2"><h3 style="font-family:Georgia,'Times New Roman',Times,serif;"><?php echo $value['name']; ?></h3></td>
        </tr>
                
        
		<?php break;

		case 'text':
		?>
        
        <tr>
            <td width="20%" rowspan="2" valign="middle"><strong><?php echo $value['name']; ?></strong></td>
            <td width="80%"><input style="width:400px;" name="<?php echo $value['id']; ?>" id="<?php echo $value['id']; ?>" type="<?php echo $value['type']; ?>" value="<?php if ( get_settings( $value['id'] ) != "") { echo get_settings( $value['id'] ); } else { echo $value['std']; } ?>" /></td>
        </tr>

        <tr>
            <td><small><?php echo $value['desc']; ?></small></td>
        </tr><tr><td colspan="2" style="margin-bottom:5px;border-bottom:1px dotted #000000;">&nbsp;</td></tr><tr><td colspan="2">&nbsp;</td></tr>

		<?php 
		break;
		
		case 'textarea':
		?>
        
        <tr>
            <td width="20%" rowspan="2" valign="middle"><strong><?php echo $value['name']; ?></strong></td>
            <td width="80%"><textarea name="<?php echo $value['id']; ?>" style="width:400px; height:200px;" type="<?php echo $value['type']; ?>" cols="" rows=""><?php if ( get_settings( $value['id'] ) != "") { echo get_settings( $value['id'] ); } else { echo $value['std']; } ?></textarea></td>
            
        </tr>

        <tr>
            <td><small><?php echo $value['desc']; ?></small></td>
        </tr><tr><td colspan="2" style="margin-bottom:5px;border-bottom:1px dotted #000000;">&nbsp;</td></tr><tr><td colspan="2">&nbsp;</td></tr>

		<?php 
		break;
		
		case 'select':
		?>
        <tr>
            <td width="20%" rowspan="2" valign="middle"><strong><?php echo $value['name']; ?></strong></td>
            <td width="80%"><select style="width:240px;" name="<?php echo $value['id']; ?>" id="<?php echo $value['id']; ?>"><?php foreach ($value['options'] as $option) { ?><option<?php if ( get_settings( $value['id'] ) == $option) { echo ' selected="selected"'; } elseif ($option == $value['std']) { echo ' selected="selected"'; } ?>><?php echo $option; ?></option><?php } ?></select></td>
       </tr>
                
       <tr>
            <td><small><?php echo $value['desc']; ?></small></td>
       </tr><tr><td colspan="2" style="margin-bottom:5px;border-bottom:1px dotted #000000;">&nbsp;</td></tr><tr><td colspan="2">&nbsp;</td></tr>

		<?php
        break;
            
		case "checkbox":
		?>
            <tr>
            <td width="20%" rowspan="2" valign="middle"><strong><?php echo $value['name']; ?></strong></td>
                <td width="80%"><? if(get_settings($value['id'])){ $checked = "checked=\"checked\""; }else{ $checked = ""; } ?>
                        <input type="checkbox" name="<?php echo $value['id']; ?>" id="<?php echo $value['id']; ?>" value="true" <?php echo $checked; ?> />
                        </td>
            </tr>
                        
            <tr>
                <td><small><?php echo $value['desc']; ?></small></td>
           </tr><tr><td colspan="2" style="margin-bottom:5px;border-bottom:1px dotted #000000;">&nbsp;</td></tr><tr><td colspan="2">&nbsp;</td></tr>
            
        <?php 		break;
	
 
} 
}
?>

<!--</table>-->

<p class="submit">
<input name="save" type="submit" value="Save changes" />    
<input type="hidden" name="action" value="save" />
</p>
</form>
<form method="post">
<p class="submit">
<input name="reset" type="submit" value="Reset" />
<input type="hidden" name="action" value="reset" />
</p>
</form>

<?php
}

add_action('admin_menu', 'mytheme_add_admin'); 




//define thumbnails size

// if ( function_exists( 'add_theme_support' ) ) {
// 	add_theme_support( 'post-thumbnails' );
//         set_post_thumbnail_size( 150, 150 ); // default Post Thumbnail dimensions   
// }

// if ( function_exists( 'add_image_size' ) ) { 
// 	add_image_size( 'archive-thumb', 400, 400, true ); //(cropped)
// }


if ( function_exists('register_sidebar') )
	register_sidebar(array(
        'before_widget' => '<li id="%1$s" class="widget %2$s">',
        'after_widget' => '</li>',
        'before_title' => '',
        'after_title' => '',
    ));
	

	
//define comment fields
// function my_fields($fields) {
//  $fields =  array(
// 		 'Name'  => '<p class="comment-form-field comment-form-Name"><label for="Name">' . __( 'Name' ) . '</label> ' . ( $req ? '<span class="required">*</span>' : '' ) .
// 							'<input id="Name" name="Name" type="text" value="' . esc_attr(  $commenter['comment_author_Name'] ) . '" size="13"' . $aria_req . ' /></p>',
// 		'Email'  => '<p class="comment-form-field comment-form-Email"><label for="Email">' . __( 'Email' ) . '</label> ' . ( $req ? '<span class="required">*</span>' : '' ) .
// 							'<input id="Email" name="Email" type="text" value="' . esc_attr(  $commenter['comment_author_Email'] ) . '" size="13"' . $aria_req . ' /></p>',
// 		'Country'  => '<p class="comment-form-field comment-form-Country"><label for="Country">' . __( 'Country' ) . '</label> ' . ( $req ? '<span class="required">*</span>' : '' ) .
// 							'<input id="Country" name="Country" type="text" value="' . esc_attr(  $commenter['comment_author_Country'] ) . '" size="13"' . $aria_req . ' /></p>',
//         'Gender' => '<p class="comment-form-field comment-form-Gender">' . '<label for="Gender">' . __( 'Gender' ) . '</label> ' . ( $req ? '<span class="required">*</span>' : '' ) .
//                     '<input id="Gender" name="Gender" type="text" value="' . esc_attr( $commenter['comment_Gender'] ) . '" size="13"' . $aria_req . ' /></p>',
//         'Company'  => '<p class="comment-form-field comment-form-Company"><label for="Company">' . __( 'Company' ) . '</label> ' . ( $req ? '<span class="required">*</span>' : '' ) .
//                     '<input id="Company" name="Company" type="text" value="' . esc_attr(  $commenter['comment_author_Company'] ) . '" size="13"' . $aria_req . ' /></p>',
//         'Tel'    => '<p class="comment-form-field comment-form-Tel"><label for="Tel">' . __( 'Tel' ) . '</label>' .
//                     '<input id="Tel" name="Tel" type="text" value="' . esc_attr( $commenter['comment_author_Tel'] ) . '" size="13" /></p>',
					
//     );
// 					//Company: Gender:*Tel:
// return $fields;
// }
//add_filter('comment_form_default_fields','my_fields');

function par_pagenavi($range = 4){
 
	global $paged, $wp_query;
	if($wp_query->max_num_pages==1)$wp_query->max_num_pages=$range;

	if ( !$max_page ) {$max_page = $wp_query->max_num_pages;}
 
	if($max_page > 1){if(!$paged){$paged = 1;}
 
	if($paged != 1){echo "<a href='" . get_pagenum_link(1) . "' class='extend' title='跳转到首页'> 返回首页 </a>";}
 
	previous_posts_link(' 上一页 ');
 
    if($max_page > $range){
 
		if($paged < $range){for($i = 1; $i <= ($range + 1); $i++){echo "<a href='" . get_pagenum_link($i) ."'";
 
		if($i==$paged)echo " class='current'";echo ">$i</a>";}}
 
    elseif($paged >= ($max_page - ceil(($range/2)))){
 
		for($i = $max_page - $range; $i <= $max_page; $i++){echo "<a href='" . get_pagenum_link($i) ."'";
 
		if($i==$paged)echo " class='current'";echo ">$i</a>";}}
 
	elseif($paged >= $range && $paged < ($max_page - ceil(($range/2)))){
 
		for($i = ($paged - ceil($range/2)); $i <= ($paged + ceil(($range/2))); $i++){echo "<a href='" . get_pagenum_link($i) ."'";if($i==$paged) echo " class='current'";echo ">$i</a>";}}}
 
    else{for($i = 1; $i <= $max_page; $i++){echo "<a href='" . get_pagenum_link($i) ."'";
 
    if($i==$paged)echo " class='current'";echo ">$i</a>";}}
 
	next_posts_link(' 下一页 ');
 
    if($paged != $max_page){echo "<a href='" . get_pagenum_link($max_page) . "' class='extend' title='跳转到最后一页'> 最后一页 </a>";}}
 
}


function get_image_path ($post_id = null) {
	if ($post_id == null) {
		global $post;
		$post_id = $post->ID;
	}
	$theImageSrc = get_post_meta($post_id, 'Image', true);
	echo 'fuck';
	var_dump( get_post_meta(41, 'attachment',true));
	global $blog_id;
	if (isset($blog_id) && $blog_id > 0) {
		$imageParts = explode('/files/', $theImageSrc);
		if (isset($imageParts[1])) {
			$theImageSrc = '/blogs.dir/' . $blog_id . '/files/' . $imageParts[1];
		}
	}
	return $theImageSrc;
}

function get_image_abspath($src,$post_id = null) {
	if ($post_id == null) {
		global $post;
		$post_id = $post->ID;
	}

		$theImageSrc = $src;
	global $blog_id;
	if (isset($blog_id) && $blog_id > 0) {
		$imageParts = explode('/files/', $theImageSrc);
		if (isset($imageParts[1])) {
			$theImageSrc = '/wp-content/blogs.dir/' . $blog_id . '/files/' . $imageParts[1];
		}
	}
	return $theImageSrc;
}

function catch_that_image() {
  global $post, $posts;
  $first_img = '';
  ob_start();
  ob_end_clean();
  $output = preg_match_all('/<img.+src=[\'"]([^\'"]+)[\'"].*>/i', $post->post_content, $matches);
  $first_img = $matches [1] [0];

  if(empty($first_img)){ //Defines a default image
    $first_img = "/images/default.jpg";
  }
  return $first_img;
}