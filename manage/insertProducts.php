<?php
include './header.php';

if (isset($_POST['ProductName'])) {
    if($_POST['ProductName'] != '' && $_POST['ProductType'] != '' && $_POST['ProductCategory'] != '' && $_POST['ProductPrice'] != '' && $_POST['ProductQuantity'] != '' && $_POST['ProductIntroduction'] != ''){

        include './db_open.php';

        $ProductName = $_POST['ProductName'];
        $ProductName = mysqli_real_escape_string($link, $ProductName); // mysqli_real_escape_string() 轉義字串中的特殊字符，包括單引號
        $ProductType = $_POST['ProductType'];
        $ProductCategory = $_POST['ProductCategory'];
        $ProductPrice = $_POST['ProductPrice'];
        $ProductQuantity = $_POST['ProductQuantity'];
        $ProductIntroduction = $_POST['ProductIntroduction'];
        $ItemID = '';
        
        // 先搜尋 product_introduction 有無相同產品名
        $selectItem = "SELECT * FROM product_introduction WHERE ProductName = '$ProductName'";
        $queryResult = mysqli_query($link, $selectItem); // 查詢語句不論有無成功都會返回一個物件，無法用於 if

        // 條件需用 mysqli_fetch_assoc 做判斷
        if ($queryRow = mysqli_fetch_assoc($queryResult)) {
            // 若有重複，提取其 ItemID
            $ItemID = $queryRow['ItemID'];

            // 檢查 ProductType 是否相同
            $sql_checkProductType = "SELECT * FROM products WHERE ItemID = '$ItemID'";
            $checkType = mysqli_fetch_assoc(mysqli_query($link, $sql_checkProductType));
            if($ProductType != $checkType['ProductType']){
                // 若不相同，警告、終止寫入、跳轉
                echo "<script>alert('產品類型不相符');</script>";
                exit ("<script>location.replace('./insertProducts.php');</script>");
            }
        }else{
            // 若無重複，product_introduction 新增此品項
            $sql_1 = "INSERT INTO product_introduction(ProductName, ProductIntroduction) VALUES ('" . $ProductName . "','" . $ProductIntroduction . "')";
            if (mysqli_query($link, $sql_1)) {
                // 新增後再提取 ItemID
                $result = mysqli_query($link, $selectItem);
                $row = mysqli_fetch_assoc($result);
                $ItemID = $row['ItemID'];
            }else{
                echo "<script>alert('品項新增失敗');</script>";
            }
        }

        // 得到 ItemID 後，再將所有寫入 products
        $sql_2 = "INSERT INTO products(ProductName, ItemID, ProductType, ProductCategory, ProductPrice, ProductQuantity) VALUES ('" . $ProductName . "','" . $ItemID . "','" . $ProductType . "','" . $ProductCategory . "','" . $ProductPrice . "','" . $ProductQuantity . "')";
                
        if (mysqli_query($link, $sql_2)){
            
            // if (isset($_FILES['file'])){
            //     if ($_FILES['file']['error']==0 ){
            //         if (file_exists("./images/$id.jpg")) {
            //             unlink("./images/$id.jpg");
            //         }  

            //         // strtolower () 變小寫
            //         // pathinfo ($_FILES['file']['name'],PATHINFO_EXTENSION) 讀取檔案的副檔名
            //         $extentsion= strtolower(pathinfo($_FILES['file']['name'],PATHINFO_EXTENSION));
        
            //         // 若副檔名是 jpg
            //         if ($extentsion=="jpg"){
            //             // $name 放入 編號.副檔名
            //             $name = $id.".".$extentsion;
        
            //             // copy() 函數將暫存的檔案放到指定資料夾
            //             // $_FILES['file']['tmp_name'] 暫存記憶體的檔案
            //             copy($_FILES['file']['tmp_name'],"./images/$name");
            //         }
            //     }
            // }

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
            <h2>新增商品資料</h2><Br />
            <div class="row"></div>
        </div>

        <div class="card-body">
            <div class="horizontal-form">
                <form method="POST" enctype="multipart/form-data" action="./insertProducts.php" class="form-horizontal">
                    <div class="form-group">
                        <label class="col-sm-2 control-label">品項名稱：</label>
                        <div class="col-sm-10">
                            <input type="text" name="ProductName" class="form-control" placeholder="請輸入品項名稱">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label">產品類型：</label>
                        <div class="col-sm-10">
                            <?php
                            include './db_open.php';
                            $sql = "SELECT * FROM product_type ORDER BY TypeID ASC";
                            $option = mysqli_query($link, $sql)
                            ?>
                            <select size="1" name="ProductType" class="form-control">
                                <option selected disabled class="text-center">-- 請選擇產品類型 --</option>
                                <?php
                                while ($row = mysqli_fetch_assoc($option)) {
                                    echo '<option value=' . $row['ProductType'] . '>' . $row['Chinese'] . '</option>';
                                }
                                ?>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label">產品口味：</label>
                        <div class="col-sm-10">
                            <input type="text" name="ProductCategory" class="form-control" value="原味" placeholder="請輸入產品口味">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label">產品價格：</label>
                        <div class="col-sm-10">
                            <input type="number" name="ProductPrice" class="form-control" placeholder="請輸入產品價格">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label">產品數量：</label>
                        <div class="col-sm-10">
                            <input type="number" name="ProductQuantity" class="form-control" placeholder="請輸入產品數量">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label">產品介紹：</label>
                        <div class="col-sm-10">
                            <textarea name="ProductIntroduction" class="form-control" placeholder="請輸入產品介紹" rows="14"></textarea>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label">產品圖片：</label>
                        <div class="col-sm-10">
                            <input type="file" name="ProductImage" class="form-control">
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-sm-offset-2 col-sm-10">
                            <button type="submit" class="btn btn-primary btn-flat btn-addon m-b-10 m-l-5">
                                <i class="ti-check"></i>確認
                            </button>
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

<?php
include './footer.php';
?>