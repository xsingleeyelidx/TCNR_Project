<?php
// input: {"MemberAccount": "test0000", "MemberPassword": "00000000"}  格式範例
$data = file_get_contents('php://input', 'r'); // 從請求中讀取原始資料
$myData = [];
$myData = json_decode($data, true); // 將 JSON 字串解析為 PHP 陣列

// test
// echo $myData['MemberAccount']; // Champion
// echo $myData['MemberPassword']; // 5566

if (isset($myData['MemberAccount']) && isset($myData['MemberPassword'])) {
    if ($myData['MemberAccount'] != "" && $myData['MemberPassword'] != "") {

        include 'connect_DB.php';

        $p_MemberAccount = $myData['MemberAccount'];
        $p_MemberPassword = $myData['MemberPassword'];

        $sql = "SELECT MemberAccount, MemberPassword, MemberName FROM members WHERE MemberAccount='$p_MemberAccount'";
        $result = mysqli_query($link, $sql); // SELECT 語句返回物件，不能作為 if 條件

        // mysqli_fetch_assoc() 返回值或 null，可作為 if 條件
        if ($row = mysqli_fetch_assoc($result)) {
            // echo $row['MemberAccount'];
            // echo $row['MemberPassword'];

            // password_verify() 解碼密碼
            if (password_verify($p_MemberPassword, $row['MemberPassword'])) {
                // 比對正確，產生金鑰 Uid01 存入資料庫
                $uid01 = substr(hash('sha256', uniqid(time())), 3, 5) . substr(hash('sha256', uniqid(time())), 10, 5);
                // 用hash(), uniqid(), time() 多層嵌套產生唯一性的值
                // 可用 substr() 片段擷取做組合，做出規則複雜的金鑰
                $sql = "UPDATE members SET Uid01 = '$uid01' WHERE MemberAccount='$p_MemberAccount'";

                if(mysqli_query($link, $sql)){
                    // 撈取 DB 該使用者資訊(不含密碼)傳至前端
                    $sql = "SELECT MemberID, MemberAccount, MemberName, MemberTel, MemberEmail, Level, Uid01, CreatedTime FROM members WHERE MemberAccount = '$p_MemberAccount'";
                    $result = mysqli_query($link, $sql);
                    $row = mysqli_fetch_assoc($result);
                    echo '{"state": true, "message": "登入成功", "member_data": '. json_encode($row) .'}';
                }else{
                    echo '{"state": false, "message": "登入失敗"}'; // 金鑰寫入失敗
                }
            }else{
                echo '{"state": false, "message": "登入失敗"}'; // 密碼比對錯誤
            }
        }else{
            echo '{"state": false, "message": "登入失敗"}'; // 帳號搜尋錯誤
        }
        mysqli_close($link);
    }else{
        echo '{"state": false, "message": "格式錯誤"}'; // 欄位不得空白
    }
}else{
    echo '{"state": false, "message": "格式錯誤"}'; // 欄位名稱不存在
}
?>