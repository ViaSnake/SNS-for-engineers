<?php

if(isset($_GET['page']) && $_GET['page'] > 0) {
  $page = $_GET['page'];
} else {
  $page = 0;
}

function search($id = "all", $orderby = null, $limit = null, $skip = null) {
  $api = 'https://versatileapi.herokuapp.com/api/text/' . $id;
  if(!empty($orderby) && !parse_url($api, PHP_URL_QUERY)) {
    $api .= '?$orderby=' . urlencode($orderby);
  } elseif (!empty($orderby) && parse_url($api, PHP_URL_QUERY)) {
    $api .= '&$orderby=' . urlencode($orderby);
  }
  if(!empty($limit) && !parse_url($api, PHP_URL_QUERY)) {
    $api .= '?$limit=' . $limit;
  } elseif (!empty($limit) && parse_url($api, PHP_URL_QUERY)) {
    $api .= '&$limit=' . $limit;
  }
  if(!empty($skip) && !parse_url($api, PHP_URL_QUERY)) {
    $api .= '?$skip=' . $skip;
  } elseif (!empty($skip) && parse_url($api, PHP_URL_QUERY)) {
    $api .= '&$skip=' . $skip;
  }
  $response = file_get_contents($api);
  return json_decode($response, true);
}

?>

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

$data = search("all", "updated_at desc", 10, $page * 10);

for($i=0; $i < count($data); $i++) {
  echo "<p>";
  echo date("Y/m/d H:i:s", strtotime($data[$i]["_created_at"]));
  echo "  ";
  echo $data[$i]["_user_id"];
  echo "</p>";
  echo "<p>";
  echo htmlspecialchars($data[$i]["text"], ENT_QUOTES, 'UTF-8');
  echo "</p>";
  echo "<hr>";
}

if($page > 0) {
  echo "<a href=?page=".($page - 1).">前へ</a>";
} else {
  echo "前へ";
}

if($page >= 0) {
  echo "<a href=?page=".($page + 1).">次へ</a>";
} else {
  echo "次へ";
}

?>

</body>
</html>
