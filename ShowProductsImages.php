<?php
$mainDirectory = './images/products'; // 主資料夾路徑

// 讀取主資料夾內的 ItemID 子資料夾
$ItemDirectory = array_filter(scandir($mainDirectory), function($item) use ($mainDirectory) {
    return is_dir($mainDirectory . '/' . $item) && $item != '.' && $item != '..';
});

$ImagesBox = [];  // 圖片路徑容器

foreach ($ItemDirectory as $ItemID) {
    
    $ItemID_Folder = $mainDirectory . '/' . $ItemID; // 設定每個 ItemID 子資料夾路徑
    // echo '【'.$ItemID_Folder.'】、'; // test

    // 讀取每個 PID 資料夾中的檔案
    $files = array_filter(scandir($ItemID_Folder), function($file) use ($ItemID_Folder) {
        // 過濾圖片檔案（假設是 .jpg, .jpeg, .png, .gif）
        return preg_match('/\.(jpg|jpeg|png|gif)$/i', $file);
    });
    // echo '【' . var_dump($files) . '】、'; // test

    // // 將該 PID 資料夾中的所有圖片路徑添加到對應的 PID 鍵中
    // if (count($files) > 0) {
    //     $ImagesBox[$ItemID] = array_map(function($file) use ($ItemID_Folder) {
    //         return $ItemID_Folder . '/' . $file;
    //     }, $files);
    // }

    $files = array_values($files); // 重置索引值

    if (count($files) > 0) {
        $ImagesBox[$ItemID] = [];

        // 使用自訂值作為鍵
        foreach ($files as $index => $file) {
            $key = 'Img_' . ($index + 1); // Img_1, Img_2...
            $ImagesBox[$ItemID][$key] = $ItemID_Folder . '/' . $file;
        }
    }
}

// 設定回傳 JSON 格式的標頭
header('Content-Type: application/json');
echo json_encode($ImagesBox);
?>