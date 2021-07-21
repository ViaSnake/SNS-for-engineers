<!DOCTYPE html>
<html lang="ja">
<head>
	<meta charset="utf=8">
	<title>SNS for engineers</title>
</head>
<body>
	<h1>SNS for engineers</h1>
	<p><a href="https://qiita.com/HawkClaws/items/599d7666f55e79ef7f56">エンジニア・プログラマにしか使えないSNSを作ってみた話</a></p>
	<hr>

<?php
$api = "https://versatileapi.herokuapp.com/api/text/all";
$json = file_get_contents($api);
$data = json_decode($json, true);
$page = -1;

if(isset($_GET['page']) && $_GET['page'] > 0) {
  $page = $_GET['page'];
  $page = $page * -10;
}

for($i=count($data)+$page; $i > count($data)+$page-10; $i--) {
  echo "<p>";
  echo $data[$i]["id"];
  echo "</p>";
  echo "<p>";
  echo htmlspecialchars($data[$i]["text"], ENT_QUOTES, 'UTF-8');
  echo "</p>";
  echo "<hr>";
}

$max_page = count($data);

if($_GET['page'] > 0) {
  echo "<a href=?page=".($_GET['page'] - 1).">前へ</a>";
} else {
  echo "前へ";
}

if($_GET['page'] <= $max_page) {
  echo "<a href=?page=".($_GET['page'] + 1).">次へ</a>";
} else {
  echo "次へ";
}
?>

</body>
</html>
