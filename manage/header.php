<?php
    session_start();
    // session_unset();
    // session_destroy();
    if (!isset($_SESSION['loginSuccess']))
	header('Location: login.php');
?>
<!DOCTYPE html>
<html >	
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>後台管理系統</title>
	
	<!-- ================= Favicon ================== -->
    <!-- Standard -->
    <link rel="shortcut icon" href="./logo/fav.png">
    <!-- Retina iPad Touch Icon-->
    <link rel="apple-touch-icon" sizes="144x144" href="./logo/fav.png">
    <!-- Retina iPhone Touch Icon-->
    <link rel="apple-touch-icon" sizes="114x114" href="./logo/fav.png">
    <!-- Standard iPad Touch Icon--> 
    <link rel="apple-touch-icon" sizes="72x72" href="./logo/fav.png">
    <!-- Standard iPhone Touch Icon--> 
    <link rel="apple-touch-icon" sizes="57x57" href="./logo/fav.png">
	
	<!-- Styles -->
    <link href="./assets/fontAwesome/css/fontawesome-all.min.css" rel="stylesheet">
    <link href="./assets/css/lib/themify-icons.css" rel="stylesheet">
    <link href="./assets/css/lib/mmc-chat.css" rel="stylesheet" />
    <link href="./assets/css/lib/sidebar.css" rel="stylesheet">
    <link href="./assets/css/lib/bootstrap.min.css" rel="stylesheet">
    <link href="./assets/css/lib/nixon.css" rel="stylesheet">
    <link href="./assets/css/style.css" rel="stylesheet">
	
	<style type="text/css">
        *{
            font-weight: 700 !important;
            background-color: #252525 !important;
            color: lightgoldenrodyellow !important;
        }
        
        button{
            background-color: darkgreen !important;
            border: 1px solid darkgreen !important;
            border-radius: 5% !important;
        }
        
        .active{
            background-color: #a0a0a0 !important;
        }
    </style>

    <script>
        function redirectDialog(filename, mode, msg) {
            alert(msg);
            location.replace(filename + "?mode=" + mode);
        }        
        function deleteConfirm(filename, ID) {
            if (confirm("警告：確定刪除編號為 " + ID + " 的資料嗎？") == 1)
                location.replace(filename + "?mode=delete&ID=" + ID);
            else
                return false;
        }
    </script>    
</head>

<body id="color">
    <div class="sidebar sidebar-hide-to-small sidebar-shrink sidebar-gestures">
        <div class="nano">
            <div class="nano-content">
                <ul>
                    <?php
                        $a = explode("/", $_SERVER["SCRIPT_NAME"]);
                        $tempFile = $a[count($a) - 1];
                    ?>                  
                    <li <?php if ($tempFile == "index.php") {echo 'class="active"';}?>>
                        <a href="index.php"><i class="ti-home"></i> 管理系統首頁</a>
                    </li>		 
					<li <?php if ($tempFile == "member.php") {echo 'class="active"';} ?>>
                        <a href="./member.php"><i class="ti-control-record"></i> 1. 會員資料管理</a>
                    </li>	
					<li <?php if ($tempFile == "product.php") {echo 'class="active"';} ?>>
                        <a href="./product.php"><i class="ti-control-record"></i> 2. 商品資料管理</a>
                    </li>	
					<li>
                        <a href="login.php?st=logout"><i class="ti-close"></i> 登出</a>
                    </li>
                </ul>
            </div>
        </div>
    </div>

    <div class="header">
        <div class="pull-left">
            <div class="logo">
                <a href="./index.php">
                    <span style="font-size:18px;color:#fff;">
                        <img id="logoImg" src="logo/logoSmall.png" data-logo_big="logo/logoSmall.png" data-logo_small="logo/logoSmall.png"  />
                        後台管理系統
                    </span>
                </a>
            </div>
            <div class="hamburger sidebar-toggle">
                <span class="ti-menu"></span>
            </div>
        </div>    
    </div>

    <div class="content-wrap" style="background-color: #a0a0a0;">
        <div class="main">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-lg-12 p-0">
                        <div class="page-header">
							<div class="page-title">
								<h1><?=$_SESSION['managerName']?> 您好！登入時間：<?=$_SESSION['lastLoginTime']?></h1>
							</div>
						</div>
                    </div>
                </div>
				<div class="main-content"> 