<?php
include './header.php';

// DELETE data
if (isset($_GET['mode'])) {
    $mode = $_GET['mode'];

    // Data Region
    switch ($mode) {
        case "delete":
        $id = $_GET['ID'];
        $mode = "browse";
        require './db_open.php';
        $sql = "DELETE FROM members WHERE MemberID='" . $id . "'";

        if (mysqli_query($link, $sql)) {
            echo "<script>redirectDialog('$ThisFileName','$mode', 'ID: $id 的資料已刪除!');</script>";
        } else {
            echo "<script>redirectDialog('$ThisFileName', '$mode', '刪除失敗');</script>";
        }
        break;
    }
}

require './db_open.php';

// 預設排序方式
$sort = $_GET['sort'] ?? 'MemberID_asc';

switch ($sort) {
    case 'MemberID_asc':
        $orderBy = 'MemberID ASC';
        break;
    case 'MemberID_desc':
        $orderBy = 'MemberID DESC';
        break;
    case 'MemberAccount_asc':
        $orderBy = 'MemberAccount ASC';
        break;
    case 'MemberAccount_desc':
        $orderBy = 'MemberAccount DESC';
        break;
    case 'MemberName_asc':
        $orderBy = 'MemberName ASC';
        break;
    case 'MemberName_desc':
        $orderBy = 'MemberName DESC';
        break;
    case 'MemberTel_asc':
        $orderBy = 'MemberTel ASC';
        break;
    case 'MemberTel_desc':
        $orderBy = 'MemberTel DESC';
        break;
    case 'MemberEmail_asc':
        $orderBy = 'MemberEmail ASC';
        break;
    case 'MemberEmail_desc':
        $orderBy = 'MemberEmail DESC';
        break;
    case 'CreatedTime_asc':
        $orderBy = 'CreatedTime ASC';
        break;
    case 'CreatedTime_desc':
        $orderBy = 'CreatedTime DESC';
        break;
}

//search
$varSearch = "";
$varWhere = "";
if (isset($_GET['Search'])){
    $varSearch = $_GET['Search'];
    if ($varSearch != "") {
        $varWhere = " where MemberID = '$varSearch' or MemberAccount like '%$varSearch%' or MemberName like '%$varSearch%' or MemberTel like '%$varSearch%' or MemberEmail like '%$varSearch%' or CreatedTime like '%$varSearch%'";
    }
}

$sql = "SELECT * FROM members $varWhere ORDER BY $orderBy";

$result = mysqli_query($link, $sql);
$total_records = mysqli_num_rows($result); // 取得資料的筆數，若無資料則回傳 0

$records_per_page = 10;  // 設定每頁顯示的筆數
$total_pages = ceil($total_records / $records_per_page); // 計算總頁數

$page = $_GET['page'] ?? $page = 1; // 取得 URL 參數的頁數
$offset = ($page - 1) * $records_per_page; // 計算當前頁第一筆資料的位置
mysqli_data_seek($result, $offset); // 移到此記錄
?>
<div class="col-lg-12">
    <div class="card alert">
        <div class="card-header">
            <h2>會員資料管理</h2><Br />
            <div class="row">
                <div class="col-lg-2">
                    <a href="./insertMembers.php">
                    <button type="button" class="btn btn-primary btn-flat btn-addon m-b-10 m-l-20">
                            <i class="ti-plus"></i>新增會員資料
                        </button>
                    </a>
                </div>
                <div class="col-lg-6" style="float:right;">
                    <div class="basic-form">
                        <!-- sorting -->
                        <form method="GET" action="./member.php">
                            <div class="form-group">
                                <div class="input-group input-group-default" style="margin-bottom: 5px;">
                                    <input type="text" placeholder="Search Round" name="Search" value="<?=$varSearch?>" class="form-control">
                                    <span class="input-group-btn">
                                        <button class="btn btn-primary btn-group-right" type="submit" style="margin-left: 5px; background-color: navy!important">
                                            <i class="ti-search"></i> 查詢
                                        </button>
                                    </span>
                                </div>
                                <div class="input-group input-group-default">
                                    <!-- <label for="sort" class="form-label">排序方式：</label> -->
                                    <select name="sort" id="sort" class="form-control text-center">
                                        <option value="MemberID_asc">會員編號（小到大）</option>
                                        <option value="MemberID_desc">會員編號（大到小）</option>
                                        <option value="MemberAccount_asc">會員帳號（升序）</option>
                                        <option value="MemberAccount_desc">會員帳號（降序）</option>
                                        <option value="MemberName_asc">會員名稱（升序）</option>
                                        <option value="MemberName_desc">會員名稱（降序）</option>
                                        <option value="MemberTel_asc">會員電話（升序）</option>
                                        <option value="MemberTel_desc">會員電話（降序）</option>
                                        <option value="MemberEmail_asc">會員信箱（升序）</option>
                                        <option value="MemberEmail_desc">會員信箱（降序）</option>
                                        <option value="CreatedTime_asc">註冊時間（舊到新）</option>
                                        <option value="CreatedTime_desc">註冊時間（新到舊）</option>
                                    </select>
                                    <span class="input-group-btn">
                                        <button class="btn btn-primary btn-group-right" type="submit" style="margin-left: 5px; background-color: navy!important">
                                            <i class="ti-search"></i> 排序
                                        </button>
                                    </span>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <div class="card-body">
            <table class="table table-responsive table-striped m-t-30">
                <thead>
                    <tr style="border-top:1px solid #e7e7e7;">
                        <th>會員編號</th>
                        <th>會員帳號</th>
                        <th>會員姓名</th>
                        <th>會員電話</th>
                        <th>會員信箱</th>
                        <th>註冊時間</th>
                        <th>共<?= $total_records ?>筆資料</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $j = 1;
                    while ($row = mysqli_fetch_assoc($result) and $j <= $records_per_page) {
                        echo "<tr>\n";
                        echo "<th scope=\"row\">" . $row['MemberID'] . "</th>\n";
                        echo "<td>" . $row["MemberAccount"] . "</td>\n";
                        echo "<td>" . $row["MemberName"] . "</td>\n";
                        echo "<td>" . $row["MemberTel"] . "</td>\n";
                        echo "<td>" . $row["MemberEmail"] . "</td>\n";
                        echo "<td>" . $row["CreatedTime"] . "</td>\n";

                        echo "<td><a href=\"./updateMembers.php?mode=update&ID=" . $row['MemberID'] . "\"><button type=\"button\" class=\"btn btn btn-info btn btn-flat btn-addon btn-sm m-b-5 m-l-5\"><i class=\"ti-pencil-alt\"></i>修改</button></a>\n";
                        echo "<button type=\"button\" class=\"btn btn btn-default btn btn-flat btn-addon btn-sm m-b-5 m-l-5\" onclick=\"javascript:deleteConfirm('member.php', '" . $row["MemberID"] . "')\"><i class=\"ti-trash\"></i>刪除</button></td>";
                        echo '</tr>';
                        $j++;
                    }
                    mysqli_free_result($result); // 釋放佔用記憶體
                    mysqli_close($link);
                    ?>
                    <?php
                    echo "<tr>\n";
                    echo "<td colspan=5>\n";

                    // 若頁數 > 第一頁，顯示上一頁
                    if ($page > 1) {
                        echo "<a href='./member.php?page=".($page - 1)."&Search=".$varSearch."' style=\"color: #000\">上一頁</a>｜";
                    }

                    // 中間頁數標籤
                    for ($i = 1; $i <= $total_pages; $i++)
                        if ($i != $page)
                            echo "<a href=\"./member.php?page=". $i ."&Search=".$varSearch."\" style=\"color: #000\">".$i ."</a>　";
                        else
                            echo $i."　";

                    // 若頁數 < 末頁，顯示下一頁
                    if ($page < $total_pages) {   
                        echo "｜<a href=\"./member.php?page=".($page + 1)."&Search=".$varSearch."\" style=\"color: #000\">下一頁</a> ";
                    }
                    echo "</td>\n";
                    echo "</tr>";
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</div><!-- /# column -->

<?php include './footer.php'; ?>