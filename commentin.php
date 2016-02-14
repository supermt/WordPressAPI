<?php
include('includes.php');

$data = wp_unslash( $_POST );
$result = array();
if(!$data['comment_post_ID']){
	$result['status_msg']='没有评论帖子ID';
	echo json_encode($result);
	exit(0);
}
if(!$wpdb->get_results("SELECT ID
  FROM $wpdb->posts
  WHERE post_type='post'
	AND comment_status='open'")){
		$result['status_msg']='该帖子不能被评论，请联系管理员';
		echo json_encode($result);
		exit(0);
}
if(!$data['comment_content']){
		$result['status_msg']='没有评论内容';
		echo json_encode($result);
		exit(0);
}



$comment_author       = ! isset( $data['comment_author'] )       ? '' : $data['comment_author'];
$comment_author_email = ! isset( $data['comment_author_email'] ) ? '' : $data['comment_author_email'];
$comment_author_url   = ! isset( $data['comment_author_url'] )   ? '' : $data['comment_author_url'];
$comment_author_IP    = ! isset( $data['comment_author_IP'] )    ? '' : $data['comment_author_IP'];
$comment_date     = ! isset( $data['comment_date'] )     ? current_time( 'mysql' )            : $data['comment_date'];
$comment_date_gmt = ! isset( $data['comment_date_gmt'] ) ? get_gmt_from_date( $comment_date ) : $data['comment_date_gmt'];
$comment_post_ID  = $data['comment_post_ID'];
$comment_content  = htmlspecialchars($data['comment_content']);
$comment_karma    = ! isset( $data['comment_karma'] )    ? 0  : $data['comment_karma'];
$comment_approved = ! isset( $data['comment_approved'] ) ? 1  : $data['comment_approved'];
$comment_agent    = ! isset( $data['comment_agent'] )    ? '' : $data['comment_agent'];
$comment_type     = ! isset( $data['comment_type'] )     ? '' : $data['comment_type'];
$comment_parent   = ! isset( $data['comment_parent'] )   ? 0  : $data['comment_parent'];

$user_id  = ! isset( $data['user_id'] ) ? 0 : $data['user_id'];
$compacted = compact( 'comment_post_ID', 'comment_author', 'comment_author_email',
 'comment_author_url', 'comment_author_IP', 'comment_date', 'comment_date_gmt',
 'comment_content', 'comment_karma', 'comment_approved', 'comment_agent',
 'comment_type', 'comment_parent', 'user_id' );
if ( ! $wpdb->insert( $wpdb->comments, $compacted ) ) {
 	$result['status_msg']="数据库响应出错，请联系网站管理人员";
	echo json_encode($result);
	exit(0);
}
 $id = (int) $wpdb->insert_id;
 if ( $comment_approved == 1 ) {
 	wp_update_comment_count( $comment_post_ID );
 }
 $comment = get_comment( $id );

// If metadata is provided, store it.
 if ( isset( $commentdata['comment_meta'] ) && is_array( $commentdata['comment_meta'] ) ) {
 	foreach ( $commentdata['comment_meta'] as $meta_key => $meta_value ) {
 		add_comment_meta( $comment->comment_ID, $meta_key, $meta_value, true );
 	}
 }
 $result['status_msg']='完成,没有错误';
 echo json_encode($result);

?>
