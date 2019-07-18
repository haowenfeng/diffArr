<?php 

include "./vendor/autoload.php";
use Rogervila\ArrayDiffMultidimensional;
use Rogervila\HttpClient;
if (isset($_POST['url1']) && isset($_POST['url2'])) {
	if (empty($_POST['url1']) || empty($_POST['url2'])) {
		echo '<script>alert("请填写请求链接")</script>';
	}
}
$postfields = array();
if (isset($_POST['method'])) {
	if ($_POST['method'] == 'post') {
		if (empty($_POST['fields'])) {
			echo '<script>alert("缺少参数")</script>';
		}
		$postfields = $_POST['fields'];
	}
	$oldRet = HttpClient::curl_http($_POST['url1'], $_POST['method'], $postfields);
	// var_dump($oldRet);exit;
	$newRet = HttpClient::curl_http($_POST['url2'], $_POST['method'], $postfields);
	if ($oldRet && $newRet) {
		$diff = new ArrayDiffMultidimensional();
		$c = json_decode($oldRet, true);
		$d = json_decode($newRet, true);
		sort($c);
		sort($d);
	}
}


// if ($a && $b) {
// 	$c = json_decode($a, true);
// 	$d = json_decode($b, true);
// }
// var_dump($diff->compare($c, $d));  
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>接口对比测试演示</title>
	<style>
		.container{
			width: 1500px;
			height: auto;
			border: 1px solid black;
		}
		form{
			width: 1400px;
			margin: 20px auto;
		}
		form>textarea{
			margin-top: 20px;
			width: 600px;
			height: 100px;
		}
		.url{
			width: 400px;
			margin-top: 10px;
		}
		#content{
			width: 1500px;
			height: auto;
			margin-bottom: 20px;
		}
		#left{
			width: 740px;
			float: left;
			border: 1px solid red;
			word-wrap: break-word;
    		word-break: break-all;
    		white-space: normal;
			height: auto;
		}
		#right{
			width:740px;
			float: left;
			border: 1px solid red;
			word-wrap: break-word;
			word-break: break-all;
			white-space: normal;
			height: auto;
		}
		#diffcontent{
			width: 1500px;
			padding: 20px;
			word-wrap: break-word;
			height: auto;
			clear: both;
		}
		#diffcontent>pre{
			color: red;
		}
	</style>
</head>
<body>
	<div class="container">
		<form action="" method="post">
			<input type="text" name="url1" placeholder="老接口" class="url"><br>
			<input type="text" name="url2" placeholder="新接口" class="url">
			<br>
			<input type="radio" name="method" value="get" checked>get
			<input type="radio" name="method" value="post">post
			<br>
			<textarea name="fields"></textarea>
			<input type="submit" name="对比">

		</form>

		<div id="content">
			<div id="left">
				<pre style="width: 739px;word-wrap: break-word;word-break: break-all;"><?php print_r(isset($c) && !empty($c) ? $c : "")?></pre>
			</div>
			<div id="right">
				<pre style="width: 739px;word-wrap: break-word;word-break: break-all;"><?php print_r(isset($d) && !empty($d) ? $d : "")?></pre>
			</div>
		</div>
		<div id="diffcontent">
			<?php if (isset($c) && !empty($c) && isset($d) && !empty($d)) {?>
				<h3>返回值中的不同：</h3>
				<pre><?php  print_r($diff->compare($c, $d))?></pre>
			<?php }?>
		</div>
	</div>
</body>
</html>