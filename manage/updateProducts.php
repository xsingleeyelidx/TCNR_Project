<?php
include './header.php';
// search product
if (isset($_GET['ID'])) {
    $ProductID = $_GET['ID'];
    include './db_open.php';
    
    $sql = "SELECT ProductID, products.ProductName, products.ItemID, ProductType, ProductCategory, ProductPrice, ProductQuantity, ProductIntroduction FROM products left join product_introduction on products.ItemID=product_introduction.ItemID WHERE ProductID='$ProductID'";
    $result = mysqli_query($link, $sql);
    
    if ($row = mysqli_fetch_assoc($result)) {
        $ProductName = $row['ProductName'];
        $ItemID = $row['ItemID'];
        $ProductType = $row['ProductType'];
        $ProductCategory = $row['ProductCategory'];
        $ProductPrice = $row['ProductPrice'];
        $ProductQuantity = $row['ProductQuantity'];
        $ProductIntroduction = $row['ProductIntroduction'];
    }else{
        echo "<script>alert('查詢失敗');</script>";
    }
    mysqli_free_result($result); // 釋放佔用記憶體
    mysqli_close($link);
}
// update
if (isset($_POST['ProductID'])) {
    if($_POST['ProductName'] != '' && $_POST['ProductType'] != '' && $_POST['ProductCategory'] != '' && $_POST['ProductPrice'] != '' && $_POST['ProductQuantity'] != '' && $_POST['ProductIntroduction'] != ''){

        $ProductID = $_POST['ProductID'];
        $ProductName = $_POST['ProductName'];
        $ItemID = $_POST['ItemID'];
        $ProductType = $_POST['ProductType'];
        $ProductCategory = $_POST['ProductCategory'];
        $ProductPrice = $_POST['ProductPrice'];
        $ProductQuantity = $_POST['ProductQuantity'];
        $ProductIntroduction = $_POST['ProductIntroduction'];
    
        include './db_open.php';
        $sql_1 = "UPDATE products SET ProductCategory='$ProductCategory', ProductPrice='$ProductPrice', ProductQuantity='$ProductQuantity' WHERE ProductID='$ProductID'";
        // products 的 ProductName & ProductType 有同品項不同口味，需另立句更改，達成不同口味商品一同修改品項名&種類
        $sql_2 = "UPDATE products SET ProductName='$ProductName', ProductType='$ProductType' WHERE ItemID='$ItemID'";
        $sql_3 = "UPDATE product_introduction SET ProductName='$ProductName', ProductIntroduction='$ProductIntroduction' WHERE ItemID='$ItemID'";
    
        if (mysqli_query($link, $sql_1) && mysqli_query($link, $sql_2) && mysqli_query($link, $sql_3)) {
            echo "<script>alert('修改成功');</script>";
        } else {
            echo "<script>alert('修改失敗');</script>";
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
            <h2>修改商品資料</h2><Br />
        </div>
        <div class="card-body">
            <div class="horizontal-form">
                <form method="POST" enctype="multipart/form-data" action="./updateProducts.php" class="form-horizontal">
                    <div class="form-group">
                        <label class="col-sm-2 control-label">產品編號：</label>
                        <div class="col-sm-10">
                            <input type="number" name="ProductID" class="form-control" value="<?= $ProductID ?>" readonly="readonly">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label">品項名稱：</label>
                        <div class="col-sm-10">
                            <input type="text" name="ProductName" class="form-control" value="<?= $ProductName ?>">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label">品項編號：</label>
                        <div class="col-sm-10">
                            <input type="number" name="ItemID" class="form-control" value="<?= $ItemID ?>" readonly="readonly">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label">產品類型：</label>
                        <div class="col-sm-10">
                            <?php
                            include './db_open.php';
                            $sql = "SELECT * FROM product_type ORDER BY TypeID ASC";
                            $result = mysqli_query($link, $sql)
                            ?>
                            <select size="1" name="ProductType" class="form-control">
                                <option selected disabled class="text-center">-- 請選擇產品類型 --</option>
                                <?php
                                while ($row2 = mysqli_fetch_assoc($result)) {
                                    if ($ProductType == $row2['ProductType']) {
                                        echo '<option value="' . $row2['ProductType'] . '" selected>' . $row2['Chinese'] . '</option>';
                                    } else {
                                        echo '<option value="' . $row2['ProductType'] . '">' . $row2['Chinese'] . '</option>';
                                    }
                                }
                                mysqli_free_result($result); // 釋放佔用記憶體
                                mysqli_close($link);
                                ?>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label">產品口味：</label>
                        <div class="col-sm-10">
                            <input type="text" name="ProductCategory" class="form-control" value="<?= $ProductCategory ?>">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label">產品價格：</label>
                        <div class="col-sm-10">
                            <input type="number" name="ProductPrice" class="form-control" value="<?= $ProductPrice ?>">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label">產品數量：</label>
                        <div class="col-sm-10">
                            <input type="number" name="ProductQuantity" class="form-control" value="<?= $ProductQuantity ?>">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label">產品介紹：</label>
                        <div class="col-sm-10">
                            <textarea name="ProductIntroduction" class="form-control" rows="14"><?= $ProductIntroduction ?></textarea>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label">產品圖片：</label>
                        <div class="col-sm-10">
                            <!-- <input type="email" name="ProductIntroduction" class="form-control" placeholder="請輸入產品介紹"> -->
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-sm-offset-2 col-sm-10">
                            <button type="submit" class="btn btn-primary btn-flat btn-addon m-b-10 m-l-5">
                                <i class="ti-check"></i>確認</button>
                            <a href="./product.php">
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