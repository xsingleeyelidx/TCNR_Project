<?php
include './header.php';

if (isset($_POST['MemberName'])) {
    if ($_POST['MemberAccount'] != '' && $_POST['MemberPassword'] != '' && $_POST['MemberName'] != '' && $_POST['MemberTel'] != '' && $_POST['MemberEmail'] != '') {
        $MemberAccount = $_POST['MemberAccount'];
        // $MemberPassword = $_POST['MemberPassword']; // 原始未加密
        $MemberPassword = password_hash($_POST['MemberPassword'], PASSWORD_DEFAULT); // password_hash() 用於安全地對密碼進行雜湊
        $MemberName = $_POST['MemberName'];
        $MemberTel = $_POST['MemberTel'];
        $MemberEmail = $_POST['MemberEmail'];
    
        include './db_open.php';
        $sql = "INSERT INTO members(MemberAccount, MemberPassword, MemberName, MemberTel, MemberEmail) VALUES ('" . $MemberAccount . "','" . $MemberPassword . "','" . $MemberName . "','" . $MemberTel . "','" . $MemberEmail . "')";
    
        if (mysqli_query($link, $sql)) {
            echo "<script>alert('新增成功');</script>";
        } else {
            echo "<script>alert('新增失敗');</script>";
        }
        
        mysqli_close($link);  // 關閉資料庫連接
    }else{
        echo "<script>alert('欄位不得空白');</script>";
    }
}
?>

<div class="col-lg-12">
    <div class="card alert">
        <div class="card-header">
            <h2>新增會員資料</h2><Br />
            <div class="row"></div>
        </div>

        <div class="card-body">
            <div class="horizontal-form">
                <form method="POST" enctype="multipart/form-data" action="./insertMembers.php" class="form-horizontal">
                    <div class="form-group">
                        <label class="col-sm-2 control-label">會員帳號：</label>
                        <div class="col-sm-10">
                            <input type="text" name="MemberAccount" class="form-control" placeholder="請輸入會員帳號">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label">會員密碼：</label>
                        <div class="col-sm-10">
                            <input type="text" name="MemberPassword" class="form-control" placeholder="請輸入會員密碼">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label">會員姓名：</label>
                        <div class="col-sm-10">
                            <input type="text" name="MemberName" class="form-control" placeholder="請輸入會員名稱">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label">會員電話：</label>
                        <!-- <label class="col-sm-2 control-label">居住地：</label> -->
                        <div class="col-sm-10">
                            <input type="text" name="MemberTel" class="form-control" placeholder="請輸入會員電話">
                            <?php
                            // include './db_open.php';
                            // $sql = "SELECT * FROM city ORDER BY cid ASC";
                            // $result = mysqli_query($link, $sql)
                            ?>
                            <!-- <select size="1" name="cid" class="form-control"> -->
                                <?php
                                // while ($row = mysqli_fetch_assoc($result)) {
                                //     echo '<option value=' . $row['cid'] . '>' . $row['cname'] . '</option>';
                                // }
                                ?>
                            <!-- </select> -->
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label">會員信箱：</label>
                        <div class="col-sm-10">
                            <input type="email" name="MemberEmail" class="form-control" placeholder="請輸入會員信箱">
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-sm-offset-2 col-sm-10">
                            <button type="submit" class="btn btn-primary btn-flat btn-addon m-b-10 m-l-5">
                                <i class="ti-check"></i>確認
                            </button>
                            <a href="./member.php">
                                <button type="button" class="btn btn-default btn-flat btn-addon m-b-10 m-l-5">
                                    <i class="ti-close"></i>離開
                                </button>
                            </a>
                        </div>
                    </div>
                </form>
            </div>
        </div>

    </div>
</div><!-- /# column -->

<?php
include './footer.php';
?>