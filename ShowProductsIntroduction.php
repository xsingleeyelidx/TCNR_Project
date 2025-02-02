<?php
// header('Access-Control-Allow-Origin: *'); // 允許所有來源
// header('Access-Control-Allow-Methods: GET, POST'); // 允許的 HTTP 方法
// header('Access-Control-Allow-Headers: Content-Type'); // 允許的頭部

include 'connect_DB.php';
// 設定 sql 查詢語法
$sql = "SELECT * FROM product_introduction ORDER BY ItemID DESC";
$result = mysqli_query($link, $sql);
$myData = []; // 一維陣列
if (mysqli_num_rows($result) > 0) { // 若資料筆數 > 0
    while ($row = mysqli_fetch_assoc($result)) {
        $myData[] = $row;
    }
    echo json_encode($myData);
} else {
    echo '{"state": false, "message": "查詢失敗"}';
}
mysqli_close($link); // 關閉連線
?>