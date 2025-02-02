<?php
include './header.php';
// search
if (isset($_GET['ID'])) {
    $MemberID = $_GET['ID'];
    include './db_open.php';
    $sql = " SELECT * FROM members WHERE MemberID='$MemberID'";
    $result = mysqli_query($link, $sql);
    $row = mysqli_fetch_assoc($result);
    $MemberAccount = $row['MemberAccount'];
    $MemberName = $row['MemberName'];
    $MemberTel = $row['MemberTel'];
    $MemberEmail = $row['MemberEmail'];
    mysqli_free_result($result); // 釋放佔用記憶體
    mysqli_close($link);
}
// update
if (isset($_POST['MemberID'])) {
    $MemberID = $_POST['MemberID'];
    $MemberAccount = $_POST['MemberAccount'];
    $MemberName = $_POST['MemberName'];
    $MemberTel = $_POST['MemberTel'];
    $MemberEmail = $_POST['MemberEmail'];

    include './db_open.php';
    $sql = "UPDATE members SET MemberAccount='$MemberAccount', MemberName='$MemberName', MemberTel='$MemberTel', MemberEmail='$MemberEmail' WHERE MemberID='$MemberID'";

    if (mysqli_query($link, $sql)) {
        echo "<script>alert('修改成功');</script>";
    } else {
        echo "<script>alert('修改失敗');</script>";
    }
    mysqli_close($link);  // 關閉資料庫連接
}
?>

<div class="col-lg-12">
    <div class="card alert">
        <div class="card-header">
            <h2>修改會員資料</h2><Br />
        </div>
        <div class="card-body">
            <div class="horizontal-form">
                <form method="POST" enctype="multipart/form-data" action="./updateMembers.php" class="form-horizontal">
                    <div class="form-group">
                        <label class="col-sm-2 control-label">會員編號：</label>
                        <div class="col-sm-10">
                            <input type="text" name="MemberID" class="form-control" value="<?= $MemberID ?>" readonly="readonly">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label">會員帳號：</label>
                        <div class="col-sm-10">
                            <input type="text" name="MemberAccount" class="form-control" value="<?= $MemberAccount ?>">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label">會員姓名：</label>
                        <div class="col-sm-10">
                            <input type="text" name="MemberName" class="form-control" value="<?= $MemberName ?>">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label">會員電話：</label>
                        <div class="col-sm-10">
                            <input type="text" name="MemberTel" class="form-control" value="<?= $MemberTel ?>">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label">會員信箱：</label>
                        <div class="col-sm-10">
                            <input type="email" name="MemberEmail" class="form-control" value="<?= $MemberEmail ?>">
                            <?php
                            // include './db_open.php';
                            // $sql = "SELECT * FROM city ORDER BY cid ASC";
                            // $result = mysqli_query($link, $sql)
                            ?>
                            <!-- <select size="1" name="cid" class="form-control"> -->
                                <?php
                                // while ($row2 = mysqli_fetch_assoc($result)) {
                                //     if ($cid == $row2['cid']) {
                                //         echo '<option value="' . $row2['cid'] . '" selected>' . $row2['cname'] . '</option>';
                                //     } else {
                                //         echo '<option value="' . $row2['cid'] . '">' . $row2['cname'] . '</option>';
                                //     }
                                // }
                                ?>
                            <!-- </select> -->
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-sm-offset-2 col-sm-10">
                            <button type="submit" class="btn btn-primary btn-flat btn-addon m-b-10 m-l-5">
                                <i class="ti-check"></i>確認</button>
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

<?php include './footer.php'; ?>