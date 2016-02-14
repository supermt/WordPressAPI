user
  登陆 /api/login.php POST方法，必需请求参数:username,password,可选参数rememberme(真值为forever)
  注册 /api/signup.php POST方法，必需请求参数:username,password,email
post
  查看帖子 /api/postout.php POST方法，请求参数可选，默认情况：
  single为单页面显示帖子数默认为10
  current为当前页面数默认第一页
  返回参数为json数组，单个帖子实例：
  {
    "post_author": "1",
    "ID": "36",
    "post_content": "直接加密试试",
    "create_time": "2016-01-27 05:28:19",
    "post_title": "测试密码原理"
  }
  发布帖子 /api/postin.php POST方法，必须请求参数：
  post_author,post_title,post_content,user_level
  可选参数默认情况：

  $defaults = array(
		'post_content_filtered' => '',
		'post_excerpt' => '',
		'post_status' => 'publish',
		'post_type' => 'post',
		'comment_status' => '',
		'ping_status' => '',
		'post_password' => '',
		'to_ping' =>  '',
		'pinged' => '',
		'post_parent' => 0,
		'menu_order' => 0,
		'guid' => '',
		'import_id' => 0,
		'context' => '',
	);
  返回参数实例：
  {
    "status_msg": "成功",
    "postID": 44//只有成功时才会返回
  }
  {
    "status_msg": "文章没有标题不能发布"//发布失败
  }

  修改帖子 /api/postin.php 如果在上述请求中加入了ID,就会成为修改请求
  返回参数实例：
  {
    "status_msg": "没有该文章，请重试文章ID"//同上
  }
comment
  查看评论 /api/commentout.php 必须参数:postID,其余同postout

  发布评论 /api/commentin.php 必须参数:postID,comment_content其余同postin
