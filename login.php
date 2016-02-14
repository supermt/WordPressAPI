<?php
//路由重构：登陆
/*
接口定义如下
入口参数为POST请求，发起方式为x-www-form-urlencoded
username必需，password必需，rememberme
username需要进行正则验证，防止注入
返回参数为提示字符串和相关数据json包
*/
include('includes.php');
$curl = curl_init();
$username=$_POST['username'];
$user_status=$_POST['rememberme'];
$user_password=$_POST['password'];
curl_setopt_array($curl, array(
  CURLOPT_URL => "http://localhost:8888/wordpress/wp-login.php",
 CURLOPT_RETURNTRANSFER => true,
   CURLOPT_ENCODING => "",
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 30,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => "POST",
  CURLOPT_POSTFIELDS => "log=$username&pwd=$user_password",
));
//var_dump("log=$username&pwd=$user_password");
$response = curl_exec($curl);
$err = curl_error($curl);
$result=array();
curl_close($curl);
if ($err) {
  //echo "cURL Error #:" . $err;
  $result['status_msg']="cURL Error#:".$err;
  $result['user_level']=0;
} else {
  if (!stripos($response,"错误")){
    $result['status_msg']="登陆成功";
    $uid=$wpdb->get_results("SELECT user_id from $wpdb->usermeta WHERE meta_value = '$username'");
    //var_dump($uid[0]->user_id);
    $uid=$uid[0]->user_id;
    $user_level=$wpdb->get_results("SELECT meta_value FROM $wpdb->usermeta WHERE
      meta_key='wp_user_level' AND user_id=$uid");
    $result['user_level']=$user_level[0]->meta_value;
  }else{
    $result['status_msg']="登录失败";
    $result['user_level']=0;
  }
}
  echo json_encode($result);
?>
