<?php
// 設定主目標資料夾
$base_dir = "../images/products/";  // 目標根目錄

// 讀取 'products' 資料夾內的所有資料夾名稱
$folders = [];
if (is_dir($base_dir)) {
    $folders = array_filter(scandir($base_dir), function($item) use ($base_dir) {
        // 排除 "." 和 ".." 這兩個目錄，並檢查是否為資料夾
        return is_dir($base_dir . $item) && $item != "." && $item != "..";
    });
}
?>
<!DOCTYPE html>
<html lang="zh-Hant">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>圖片上傳</title>
</head>
<body>
    <h2>選擇上傳資料夾</h2>
    <form action="upload.php" method="post" enctype="multipart/form-data">
        <!-- 讓使用者選擇現有資料夾，動態生成資料夾選項 -->
        <label for="folder">選擇資料夾：</label>
        <select name="folder" id="folder">
            <option value="">--選擇資料夾--</option>
            <?php
            // 動態生成資料夾選項
            foreach ($folders as $folder) {
                echo "<option value=\"$folder\">$folder</option>";
            }
            ?>
        </select>
        <br><br>
        <label for="new_folder">或是建立新資料夾：</label>
        <input type="text" id="new_folder" name="new_folder" placeholder="新資料夾名稱">
        <br><br>
        <!-- 使用者選擇多個檔案，改成 ProductImage -->
        <label for="ProductImage">選擇檔案：</label>
        <input type="file" name="ProductImage[]" id="ProductImage" multiple>
        <br><br>
        <!-- 將 input type="submit" 改成 button -->
        <button type="submit">上傳檔案</button>
    </form>
</body>
</html>
