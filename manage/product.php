<?php
include './header.php';

if (isset($_GET['mode'])) {
    $mode = $_GET['mode'];
    $ThisFileName = './product.php';

    // Data Region
    switch ($mode) {
        case "delete":
            require './db_open.php';
            $mode = "browse";
            $ProductID = $_GET['ID'];

            // 先取得此項的 ItemID 保存
            $sql_read_Item = "SELECT ItemID FROM products WHERE ProductID = '$ProductID'";
            $row = mysqli_fetch_assoc(mysqli_query($link, $sql_read_Item));
            $ItemID = $row['ItemID'];

            // 刪除此產品
            $sql_del = "DELETE FROM products WHERE ProductID = '" . $ProductID . "'";
            if (mysqli_query($link, $sql_del)) {
                // if (file_exists("../bimg/$id.avif")) {
                //     echo "檔案刪除成功<br/>";
                //     unlink("../bimg/$id.avif");
                // }

                // 檢查此品項還有無產品
                $sql_checkItem = "SELECT * FROM products WHERE ItemID = '$ItemID'";
                $checkItem = mysqli_query($link, $sql_checkItem);

                // 若品項內無產品，product_introduction 刪除此品項
                if(mysqli_num_rows($checkItem) == 0){
                    $sql_delItem = "DELETE FROM product_introduction WHERE ItemID = '" . $ItemID . "'";
                    if(mysqli_query($link, $sql_delItem)){
                        echo "<script>alert('此品項已無產品，已刪除此品項！');</script>";
                    }
                }

                echo "<script>redirectDialog('$ThisFileName','$mode', 'ID: $id 的資料已刪除!');</script>";
            } else {
                echo "<script>redirectDialog('$ThisFileName', '$mode', '刪除失敗');</script>";
            }
            break;
    }
}

require './db_open.php';

// 預設排序方式
$sort = $_GET['sort'] ?? 'CreatedTime_desc';

switch ($sort) {
    case 'ProductID_asc':
        $orderBy = 'ProductID ASC';
        break;
    case 'ProductID_desc':
        $orderBy = 'ProductID DESC';
        break;
    case 'ProductName_asc':
        $orderBy = 'products.ProductName ASC'; // 多張表有同名時需指定
        break;
    case 'ProductName_desc':
        $orderBy = 'products.ProductName DESC'; // 多張表有同名時需指定
        break;
    case 'ItemID_asc':
        $orderBy = 'products.ItemID ASC'; // 多張表有同名時需指定
        break;
    case 'ItemID_desc':
        $orderBy = 'products.ItemID DESC'; // 多張表有同名時需指定
        break;
    case 'ProductType_asc':
        $orderBy = 'ProductType ASC';
        break;
    case 'ProductType_desc':
        $orderBy = 'ProductType DESC';
        break;
    case 'ProductCategory_asc':
        $orderBy = 'ProductCategory ASC';
        break;
    case 'ProductCategory_desc':
        $orderBy = 'ProductCategory DESC';
        break;
    case 'ProductPrice_asc':
        $orderBy = 'ProductPrice ASC';
        break;
    case 'ProductPrice_desc':
        $orderBy = 'ProductPrice DESC';
        break;
    case 'ProductQuantity_asc':
        $orderBy = 'ProductQuantity ASC';
        break;
    case 'ProductQuantity_desc':
        $orderBy = 'ProductQuantity DESC';
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
        $varWhere = " WHERE ProductID = '$varSearch' or products.ProductName like '%$varSearch%' or ProductType like '%$varSearch%' or ProductCategory like '%$varSearch%' or ProductIntroduction like '%$varSearch%' or products.ItemID = '$varSearch' or ProductPrice = '$varSearch' or ProductQuantity = '$varSearch'";
    }
}
$sql = "SELECT * FROM products LEFT JOIN product_introduction ON products.ItemID = product_introduction.ItemID $varWhere ORDER BY $orderBy"; // 按條件搜尋並排序

$result = mysqli_query($link, $sql);
$total_records = mysqli_num_rows($result); // 取得資料的筆數，若無資料則回傳 0

$records_per_page = 10;  // 設定每頁顯示的筆數
$total_pages = ceil($total_records / $records_per_page); // 計算總頁數

$page = $_GET['page'] ?? $page = 1; // 取得 URL 參數的頁數
$offset = ($page - 1) * $records_per_page; // 計算當前頁第一筆資料的位置

mysqli_data_seek($result, $offset); // 移到此記錄
// mysqli_data_seek() 函數將結果指標調整到結果集中的任意一行，回傳為布靈值
// 第二參數規定偏移量，範圍須在 0 和 行總數 - 1 之間
?>
<div class="col-lg-12">
    <div class="card alert">
        <div class="card-header">
            <h2>商品資料管理</h2><Br />
            <div class="row">
                <div class="col-lg-2">
                    <a href="./insertProducts.php">
                        <button type="button" class="btn btn-primary btn-flat btn-addon m-b-10 m-l-20">
                            <i class="ti-plus"></i>新增商品資料
                        </button>
                    </a>
                </div>
                <div class="col-lg-6" style="float:right;">
                    <div class="basic-form">
                        <!-- sorting -->
                        <form method="GET" action="./product.php">
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
                                        <option value="ProductID_asc">產品編號（小到大）</option>
                                        <option value="ProductID_desc">產品編號（大到小）</option>
                                        <option value="ProductName_asc">產品名稱（升序）</option>
                                        <option value="ProductName_desc">產品名稱（降序）</option>
                                        <option value="ItemID_asc">品項編號（小到大）</option>
                                        <option value="ItemID_desc">品項編號（大到小）</option>
                                        <option value="ProductType_asc">產品類型（升序）</option>
                                        <option value="ProductType_desc">產品類型（降序）</option>
                                        <option value="ProductCategory_asc">產品口味（升序）</option>
                                        <option value="ProductCategory_desc">產品口味（降序）</option>
                                        <option value="ProductPrice_asc">產品價格（小到大）</option>
                                        <option value="ProductPrice_desc">產品價格（大到小）</option>
                                        <option value="ProductQuantity_asc">產品數量（少到多）</option>
                                        <option value="ProductQuantity_desc">產品數量（多到少）</option>
                                        <option value="CreatedTime_asc">建立時間（舊到新）</option>
                                        <option value="CreatedTime_desc">建立時間（新到舊）</option>
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
                        <th>產品編號</th>
                        <th>品項名稱</th>
                        <th>品項編號</th>
                        <th>產品類型</th>
                        <th>產品口味</th>
                        <th>產品價格</th>
                        <th>產品數量</th>
                        <th>共<?= $total_records ?>筆資料</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $j = 1;
                    while ($row = mysqli_fetch_assoc($result) and $j <= $records_per_page) {
                        echo "<tr>\n";
                        echo "<th scope=\"row\">" . $row['ProductID'] . "</th>\n";
                        echo "<td>" . $row['ProductName'] . "</td>\n";
                        echo "<td>" . $row['ItemID'] . "</td>\n";
                        echo "<td>" . $row['ProductType'] . "</td>\n";
                        echo "<td>" . $row['ProductCategory'] . "</td>\n";
                        echo "<td>" . $row['ProductPrice'] . "</td>\n";
                        echo "<td>" . $row['ProductQuantity'] . "</td>\n";

                        echo "<td><a href=\"./updateProducts.php?mode=update&ID=" . $row['ProductID'] . "\"><button type=\"button\" class=\"btn btn btn-info btn btn-flat btn-addon btn-sm m-b-5 m-l-5\"><i class=\"ti-pencil-alt\"></i>細項</button></a>\n";
                        echo "<button type=\"button\" class=\"btn btn btn-default btn btn-flat btn-addon btn-sm m-b-5 m-l-5\" onclick=\"javascript:deleteConfirm('product.php', '" . $row["ProductID"] . "')\"><i class=\"ti-trash\"></i>刪除</button></td>";
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
                        echo "<a href='./product.php?page=".($page - 1)."&Search=".$varSearch."' style=\"color: #000\">上一頁</a>｜";
                    }

                    // 中間頁數標籤
                    for ($i = 1; $i <= $total_pages; $i++)
                        if ($i != $page)
                            echo "<a href=\"./product.php?page=". $i ."&Search=".$varSearch."\" style=\"color: #000\">".$i ."</a>　";
                        else
                            echo $i."　";

                    // 若頁數 < 末頁，顯示下一頁
                    if ($page < $total_pages) {   
                        echo "｜<a href=\"./product.php?page=".($page + 1)."&Search=".$varSearch."\" style=\"color: #000\">下一頁</a> ";
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