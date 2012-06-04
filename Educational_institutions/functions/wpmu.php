<?php
/*

参数说明

$how_many: 要显示的多少篇最新文章

$how_long: 显示时间区间0为禁止该功能

$titleOnly:如果是true(只显示文章标题)或false(显示文章标题和站点名称)

$begin_wrap: 自定义HTML标签,如：<li>

$end_wrap: 自定义HTML标签,如:</li>

使用方法: wpmu_recent_posts_mu(5, 30, true, '<li>', '</li>'); 

>> 在过去的30天显示最新的5篇文章, 并且只显示文章标题。
*/

function wpmu_recent_posts_mu($how_many=10, $how_long=0, $titleOnly=true, $begin_wrap="\n<li>", $end_wrap="</li>") {
	global $wpdb;
	global $table_prefix;
	$counter = 0;

	//首先通过判断是否显示时间区间来分别使用不同的SQl语句
	if ($how_long > 0) {
		$blogs = $wpdb->get_col("SELECT blog_id FROM $wpdb->blogs WHERE
			public = '1' AND archived = '0' AND mature = '0' AND spam = '0' AND deleted = '0'
			AND last_updated >= DATE_SUB(CURRENT_DATE(), INTERVAL $how_long DAY)
			ORDER BY last_updated DESC");
	} else {
		$blogs = $wpdb->get_col("SELECT blog_id FROM $wpdb->blogs WHERE
			public = '1' AND archived = '0' AND mature = '0' AND spam = '0' AND deleted = '0'
			ORDER BY last_updated DESC");
	}
        //如果存在多站点ID
	if ($blogs) {

		echo "<ul>";
		foreach ($blogs as $blog) {
			// 下面是需要使用的数据表
			$blogOptionsTable = $wpdb->base_prefix.$blog."_options";
		    	$blogPostsTable = $wpdb->base_prefix.$blog."_posts";
			$options = $wpdb->get_results("SELECT option_value FROM
				$blogOptionsTable WHERE option_name IN ('siteurl','blogname')
				ORDER BY option_name DESC");
		        // 为最新文章获取标题和ID号
			if ($how_long > 0) {
				$thispost = $wpdb->get_results("SELECT ID, post_title
					FROM $blogPostsTable WHERE post_status = 'publish'
					AND ID > 1
					AND post_type = 'post'
					AND post_date >= DATE_SUB(CURRENT_DATE(), INTERVAL $how_long DAY)
					ORDER BY id DESC LIMIT 0,1");
			} else {
				$thispost = $wpdb->get_results("SELECT ID, post_title
					FROM $blogPostsTable WHERE post_status = 'publish'
					AND ID > 1
					AND post_type = 'post'
					ORDER BY id DESC LIMIT 0,1");
			}
			// 如果存在将输入内容
			if($thispost) {
				// 获取子站点文章链接
				$thispermalink = get_blog_permalink($blog, $thispost[0]->ID);
				if ($titleOnly == false) {
					echo $begin_wrap.'<a href="'
					.$thispermalink.'">'.$thispost[0]->post_title.'</a> <br/> by <a href="'
					.$options[0]->option_value.'">'
					.$options[1]->option_value.'</a>'.$end_wrap;
					$counter++;
					} else {
						echo $begin_wrap.'<a href="'.$thispermalink
						.'">'.$thispost[0]->post_title.'</a>'.$end_wrap;
						$counter++;
					}
			}
			// 对文章数量进行判断。
			if($counter >= $how_many) {
				break;
			}
		}
		echo "</ul>";
	}
}



//根据时间显示最新的分类文章内容，每个站点显示一篇内容
//$blog_id   子站点ID
//$catid   分类ID

function filter_where( $where = '' ) {
	// posts in the last 30 days
	$where .= " AND post_date > '" . date('Y-m-d', strtotime('-30 days')) . "'";
	return $where;
}

function get_cat_blogposts_wpmu($blog_id,$catid,$user,$count=1){


	$user= $user != null ? "&author_name=".$user : "&author_name=admin";
	// 幼教部首页 不区分admin 还是幼儿园管理teacher
    wp_reset_query();
    switch_to_blog($blog_id);
    global $post;

    ?>
	<?php

	add_filter( 'posts_where', 'filter_where' );
	$query = new WP_Query( $query_string );

 	$my_query2 = new WP_Query('showposts='.$count.'&order=desc&orderby=date&cat='.$catid.$user);

 	remove_filter( 'posts_where', 'filter_where' );

	 while ($my_query2->have_posts()) : $my_query2->the_post();

	?>
 	<li class="post_link"><a href="<?php the_permalink() ?>" rel="bookmark"><?php the_title(); ?></a> </li>
   <?php endwhile; ?>
   <?php restore_current_blog();

}

// $how_many只能限制 各个网站的cat数量？
function factory_get_byslug_wpmu($slug,$how_many=1,$user=null){
	global $wpdb;
	global $blog_id;
	$how_many_blog = $wpdb->get_results("SELECT * from $wpdb->blogs");

	foreach ($how_many_blog as $keyc => $vc)
	{
		if($vc->blog_id !=1&&$vc->blog_id !=$blog_id)  //排除主站点ID
		{
			$id_cat[$keyc] = $vc->blog_id;
		}
	}

	foreach ($id_cat as $ksc => $volsc)
	{

	     $most_cat = $wpdb->get_results("SELECT  * from ian_".$volsc."_terms where slug = '".$slug."'");
	     foreach ($most_cat as $ks => $vs)
	     {
	         get_cat_blogposts_wpmu($volsc,$vs->term_id,$user,$how_many); //方法调用
	     }
	 }

}



?>