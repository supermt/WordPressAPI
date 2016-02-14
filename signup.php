<?php
//路由重构：注册
/*
接口定义如下
入口参数为POST请求，发起方式为x-www-form-urlencoded
username必需，password必需，email必需，这些可以不必在客户端先行验证
返回参数为提示字符串
*/
include('includes.php');
$curl = curl_init();
$username=$_POST['username'];
$user_email=$_POST['email'];
$user_password=$_POST['password'];
$user_terms=$_POST["term"];
curl_setopt_array($curl, array(
  CURLOPT_URL => WP_URL."/wp-login.php?action=register",
 CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => "",
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 30,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => "POST",
  CURLOPT_POSTFIELDS => "user_login=$username&user_email=$user_email&user_password=$user_password&redirect_to=&wp-submit=%E6%B3%A8%E5%86%8C",
));
$response = curl_exec($curl);
$err = curl_error($curl);
curl_close($curl);
if ($err) {
  echo "cURL Error #:" . $err;
} else {
  //echo $response;
  if (stripos($response,"错误")) {
    echo "错误";
  }
  else echo "完成";
}
?>
