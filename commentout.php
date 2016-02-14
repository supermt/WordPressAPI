<?php

/*
接口定义如下
入口参数为POST请求，发起方式可以为www-form也可以为x-www-form-urlencoded
single为单页面显示评论数
current为当前页面数，比如浏览到第一面，第二面。。。。
postID为希望请求的帖子回复的ID
返回参数为json数组集合
返回一个评论的这些内容：
comment_ID（作为回复依据），
toComment（为0时代表针对帖子，非零时代表针对帖子ID相同的某一条评论），
评论者名，评论发布时间,评论内容
其中作者ID为0时代表匿名评论
*/
include('includes.php');
$single=! isset( $_POST['single'] ) ? '10' :intval($_POST["single"]);
$cur_page=! isset( $_POST['current'] ) ? '0' :intval($_POST["current"]-1);//当前页面
$postID=intval($_POST["postID"]);
if (!$postID){
  echo json_encode(array('status_msg' =>'错误，没有指定id'));
  exit(-1);
}
//var_dump($wpdb);
//echo"hello";
$cur_page*=$single;
$result=$wpdb->get_results("SELECT
  comment_ID,
  comment_parent,
  comment_author,
  comment_date_gmt AS create_time,
  comment_content
  FROM $wpdb->comments
  WHERE comment_post_ID=$postID
  AND comment_approved=1
  LIMIT $cur_page,$single");
  echo json_encode($result);
?>
