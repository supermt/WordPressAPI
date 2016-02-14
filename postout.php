<?php
/*
接口定义如下
入口参数为POST请求，发起方式可以为www-form也可以为x-www-form-urlencoded
single为单页面显示帖子数默认为10
current为当前页面数，比如浏览到第一面，第二面。。。。默认第一页
返回参数为json数组集合
返回一个帖子的这些内容：
作者ID，帖子内容，帖子发布时间，帖子开头
*/
include('includes.php');
$single=! isset( $_POST['single'] ) ? '10' :intval($_POST["single"]);//每个页面的帖子数
$cur_page=! isset( $_POST['current'] ) ? '0' :intval($_POST["current"]-1);//当前页面
$postID=! isset( $_POST['postID'] ) ? '0' :intval($_POST["postID"]);//指定浏览的ID
$post_author=! isset( $_POST['post_author'] ) ? '0' :intval($_POST["post_author"]);//指定作者的帖子
//var_dump($wpdb);
//echo"hello";
if (!$postID){
$cur_page*=$single;
$result=$wpdb->get_results("SELECT post_author,
  ID,
  post_content,
  post_date_gmt AS create_time,
  post_title
  FROM $wpdb->posts
  WHERE post_type='post' AND post_status='publish'
  LIMIT $cur_page,$single");
  if (!$result) echo "no post1";
  echo json_encode($result);
}else {
  $cur_page*=$single;
  $result=$wpdb->get_results("SELECT post_author,
    ID,
    post_content,
    post_date_gmt AS create_time,
    post_title
    FROM $wpdb->posts
    WHERE ID=$postID AND post_status='publish'
    LIMIT $cur_page,$single");
    if (!$result) echo "no post2";
    echo json_encode($result);
}
?>
