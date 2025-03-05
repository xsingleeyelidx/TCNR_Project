<?php
// input: {"uid01": "xx"}
$data = file_get_contents('php://input', 'r');
$myData = [];
$myData = json_decode($data, true); // 將 json 拆成字串陣列

if(isset($myData['uid01'])){
    if($myData['uid01'] != ''){

        include 'connect_DB.php';

        $p_uid01 = $myData['uid01'];

        $sql = "SELECT MemberID, MemberAccount, MemberName, MemberTel, MemberEmail, Level, Uid01, CreatedTime FROM members WHERE Uid01 = '$p_uid01'";
        $result = mysqli_query($link, $sql);

        // 改用 mysqli_num_rows() 為確認條件
        if(mysqli_num_rows($result) == 1){
            $row = mysqli_fetch_assoc($result);
            echo '{"state": true, "message": "驗證成功", "member_data": ' . json_encode($row) . '}';
        }else{
            echo '{"state": false, "message": "驗證失敗"}';
        }
        mysqli_close($link);
    }else{
        echo '{"state": false, "message": "格式錯誤"}'; // 欄位不得空白
    }
}else{
    echo '{"state": false, "message": "格式錯誤"}'; // 欄位錯誤
}
?>