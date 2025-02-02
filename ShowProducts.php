<?php
// header('Access-Control-Allow-Origin: *'); // 允許所有來源
// header('Access-Control-Allow-Methods: GET, POST'); // 允許的 HTTP 方法
// header('Access-Control-Allow-Headers: Content-Type'); // 允許的頭部

include 'connect_DB.php';

$sql = "SELECT * FROM products ORDER BY ProductID DESC"; // 原始查詢
// $sql = "SELECT ProductID, products.ProductName, products.ItemID, ProductType, ProductCategory, ProductPrice, ProductQuantity, ProductIntroduction FROM products left join product_introduction on products.ItemID=product_introduction.ItemID ORDER BY ProductID DESC";
$result = mysqli_query($link, $sql);
$myData = []; // 一維陣列
if (mysqli_num_rows($result) > 0) { // 若資料筆數 > 0
    // $myData[] = json_decode('{"state": true, "message": "查詢成功"}');
    while ($row = mysqli_fetch_assoc($result)) {
        $myData[] = $row; // 變二維陣列
    }
    echo json_encode($myData);
} else {
    echo '{"state": false, "message": "查詢失敗"}';
}
mysqli_close($link); // 關閉連線

?>