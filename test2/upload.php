<?php
// 設定目標資料夾，位於 upload.php 的上一層資料夾中的 images/products 資料夾
$base_dir = "../images/products/";  // 目標根目錄

// 檢查是否選擇了現有的子資料夾或建立新的資料夾
if (isset($_POST["folder"]) && $_POST["folder"] != "") {
    // 使用者選擇了現有資料夾
    $target_dir = $base_dir . $_POST["folder"] . "/";  // 目標資料夾為選擇的資料夾
} elseif (isset($_POST["new_folder"]) && $_POST["new_folder"] != "") {
    // 使用者輸入了新資料夾名稱
    $new_folder = $_POST["new_folder"];
    $target_dir = $base_dir . $new_folder . "/";  // 目標資料夾為新的資料夾
    // 如果資料夾不存在，則建立新資料夾
    if (!file_exists($target_dir)) {
        mkdir($target_dir, 0777, true);  // 0777 是設定資料夾的權限，`true` 允許建立多層資料夾
    }
} else {
    echo "請選擇或建立一個資料夾。<br>";
    exit;
}

// 取得上傳的檔案數量
$total_files = count($_FILES["ProductImage"]["name"]);  // 將 fileToUpload 改成 ProductImage
$uploadOk = 1;  // 上傳標誌，預設為 1（上傳成功）

// 遍歷每個檔案
for ($i = 0; $i < $total_files; $i++) {
    $target_file = $target_dir . basename($_FILES["ProductImage"]["name"][$i]);  // 改為 ProductImage
    $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

    // 檢查檔案是否為圖片
    if (isset($_POST["submit"])) {
        $check = getimagesize($_FILES["ProductImage"]["tmp_name"][$i]);  // 改為 ProductImage
        if ($check !== false) {
            echo "檔案 " . $_FILES["ProductImage"]["name"][$i] . " 是圖片 - " . $check["mime"] . ".<br>";
        } else {
            echo "檔案 " . $_FILES["ProductImage"]["name"][$i] . " 不是圖片。<br>";
            $uploadOk = 0;
        }
    }

    // 檢查圖片檔案是否已經存在
    if (file_exists($target_file)) {
        echo "檔案 " . $_FILES["ProductImage"]["name"][$i] . " 已經存在。<br>";  // 改為 ProductImage
        $uploadOk = 0;
    }

    // 限制檔案大小 (最大 5MB)
    if ($_FILES["ProductImage"]["size"][$i] > 5000000) {  // 改為 ProductImage
        echo "檔案 " . $_FILES["ProductImage"]["name"][$i] . " 太大了。<br>";  // 改為 ProductImage
        $uploadOk = 0;
    }

    // 限制允許的檔案格式
    if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif") {
        echo "檔案 " . $_FILES["ProductImage"]["name"][$i] . " 格式不正確，只能上傳 JPG, JPEG, PNG, GIF 格式。<br>";  // 改為 ProductImage
        $uploadOk = 0;
    }

    // 檢查是否有錯誤
    if ($uploadOk == 0) {
        echo "檔案 " . $_FILES["ProductImage"]["name"][$i] . " 未能上傳。<br>";  // 改為 ProductImage
    } else {
        // 嘗試將檔案移動到目標資料夾
        if (move_uploaded_file($_FILES["ProductImage"]["tmp_name"][$i], $target_file)) {  // 改為 ProductImage
            echo "檔案 " . $_FILES["ProductImage"]["name"][$i] . " 已經成功上傳。<br>";  // 改為 ProductImage
        } else {
            echo "檔案 " . $_FILES["ProductImage"]["name"][$i] . " 上傳時發生錯誤。<br>";  // 改為 ProductImage
        }
    }
}
?>
