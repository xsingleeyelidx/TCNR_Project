<?php
// 使用 file_get_contents('php://input')、json_decode($data, true) 處理原始 JSON 請求資料
// 常見於 RESTful API 的後端處理邏輯中
// 使用場合
// 1. 處理 JSON API：當後端需要接收前端通過 POST 或 PUT 發送的 JSON 資料
// 2. 接收非標準資料：例如自定義二進位流或 XML 格式
// 3. 跳過 PHP 自動處理：例如不希望表單資料自動解析到 $_POST 的情況
// 注意事項
// 1. 只能讀取一次：php://input 是個一次性流，讀取後無法再次使用。如需多次訪問，需將其保存到變量中
// 2. 性能問題：若內容非常大，應避免使用 php://input，改用流處理
// 3. 安全性檢查：對於未經處理的原始資料，解析和使用時需謹慎，避免安全漏洞，例如 JSON 或 XML 注入攻擊
// GPT 範例亦有處理 XML 資料
// $xmlData = file_get_contents('php://input'); // 從請求中讀取 XML 資料
// $xml = simplexml_load_string($xmlData); // 將 XML 解析為 SimpleXMLElement


// input: {"RegisterAccount": "champion", "RegisterPassword": "5566", "RegisterName": "大佑池玖", "RegisterTel": "0988555666", "RegisterEmail": "test@gmail.com"}  格式範例


$data = file_get_contents('php://input', 'r'); // 從請求中讀取原始資料
// file_get_contents() 將檔案讀入一個字串中
// php://input 是 PHP 的特殊輸入流，允許直接讀取原始的 HTTP 請求主體 (request body)

$myData = [];
$myData = json_decode($data, true); // 將 JSON 字串解析為 PHP 陣列
// json_decode() 將 JSON 字串轉為 PHP 物件或陣列
// 第二參數可為 true / false。true 將物件轉為關聯陣列回傳，false 則不轉換直接回傳物件

// test
// echo $myData['RegisterAccount']; // Champion
// echo $myData['RegisterPassword']; // 5566
// echo $myData['RegisterName']; // 大佑池玖
// echo $myData['RegisterTel']; // 0988555666
// echo $myData['RegisterEmail']; // test@gmail.com

// 註冊判定
if (isset($myData['RegisterAccount'])) {
    if ($myData['RegisterAccount'] != "" && $myData['RegisterPassword'] != "" && $myData['RegisterName'] != "" && $myData['RegisterTel'] != "" && $myData['RegisterEmail'] != "") {

        include 'connect_DB.php';

        $p_RegisterAccount = $myData['RegisterAccount'];

        // 檢查有無重複帳號
        $sql_checkAccount = "SELECT MemberAccount FROM members WHERE MemberAccount='$p_RegisterAccount'";
        $result = mysqli_query($link, $sql_checkAccount);
        if ($row = mysqli_fetch_assoc($result)) {
            exit('{"state": false, "message": "此帳號已被註冊"}');
        };
        
        // 密碼加密
        // $p_RegisterPassword = $myData['RegisterPassword']; // 原始未加密
        $p_RegisterPassword = password_hash($myData['RegisterPassword'], PASSWORD_DEFAULT); // password_hash() 用於安全地對密碼進行雜湊
        // 第一參數為要演算的密碼字串，第二參數為使用的雜湊演算法(如下)
        // PASSWORD_DEFAULT：預設為 bcrypt
        // PASSWORD_BCRYPT ：使用 bcrypt 演算法，產生 60 字元的雜湊值
        // PASSWORD_ARGON2I、PASSWORD_ARGON2ID：使用 Argon2 演算法（需要 PHP 7.2+）
        $p_RegisterName = $myData['RegisterName'];
        $p_RegisterTel = $myData['RegisterTel'];
        $p_RegisterEmail = $myData['RegisterEmail'];

        // 資料表記得注意密碼欄位長度，需放得下加密後的位數
        $sql = "INSERT INTO members(MemberAccount, MemberPassword, MemberName, MemberTel, MemberEmail) VALUES ('$p_RegisterAccount', '$p_RegisterPassword', '$p_RegisterName', '$p_RegisterTel', '$p_RegisterEmail')";

        if (mysqli_query($link, $sql)) {
            echo '{"state": true, "message": "註冊成功！"}'; // JSON 格式
        }else{
            echo '{"state": false, "message": "註冊失敗'.$sql.mysqli_error($link).'"}';
        }
        mysqli_close($link);
    }else{
        // echo '{"state": false, "message": "欄位不得空白！"}';
        echo '{"state": false, "message": "格式錯誤"}'; // 不須返回詳細說明，API 本是給特定對象使用
    }
}else{
    // echo '{"state": false, "message": "欄位名稱不存在！"}';
    echo '{"state": false, "message": "格式錯誤"}'; // 給對方前應說明正確格式，若無法傳遞代表傳遞者不是你給的人
}
?>