<?php
$ErrorMessage = '';
$varScript = '';
if (isset($_GET['st'])) { //logout 時會給的變數
	if ($_GET['st'] == "logout") {
		session_start();
		unset($_SESSION['loginSuccess']);
		header('Location: login.php');
	}
}

if (isset($_POST['managerAccount'])) {
	if ($_POST['managerAccount'] != '' && $_POST['managerPassword'] != ''){
		$managerAccount = $_POST['managerAccount'];
		$managerPassword = $_POST['managerPassword'];
		require 'db_open.php';
		$sql = "SELECT * FROM manager WHERE managerAccount='$managerAccount'";
		$result = mysqli_query($link, $sql);
		if ($row = mysqli_fetch_assoc($result)) {
			if ($managerPassword == $row['managerPassword']) {
				session_start();
				$_SESSION['loginSuccess'] = $managerAccount;
				$_SESSION['managerName'] = $row['managerName'];
				$_SESSION['lastLoginTime'] = date("Y-m-d H:i:s");
				$sql = "UPDATE manager SET lastLoginTime = '".$_SESSION['lastLoginTime']."' where managerAccount = '$managerAccount'";
				$result = mysqli_query($link, $sql);
				mysqli_close($link);
				header('Location: ./index.php');
			} else {
				$ErrorMessage = "密碼錯誤";
			}
		}else {
			$ErrorMessage = '帳號錯誤';
		}
	}else{
		$ErrorMessage = '帳號密碼不得為空';
	}
}
?>
<!DOCTYPE html>
<html>

<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">

	<title>後端管理系統</title>

	<!-- ================= Favicon ================== -->
	<!-- Standard -->
	<link rel="shortcut icon" href="logo/fav.png">
	<!-- Retina iPad Touch Icon-->
	<link rel="apple-touch-icon" sizes="144x144" href="logo/fav.png">
	<!-- Retina iPhone Touch Icon-->
	<link rel="apple-touch-icon" sizes="114x114" href="logo/fav.png">
	<!-- Standard iPad Touch Icon-->
	<link rel="apple-touch-icon" sizes="72x72" href="logo/fav.png">
	<!-- Standard iPhone Touch Icon-->
	<link rel="apple-touch-icon" sizes="57x57" href="logo/fav.png">

	<!-- Styles -->
	<link href="assets/fontAwesome/css/fontawesome-all.min.css" rel="stylesheet">
	<link href="assets/css/lib/themify-icons.css" rel="stylesheet">
	<link href="assets/css/lib/bootstrap.min.css" rel="stylesheet">
	<link href="assets/css/lib/nixon.css" rel="stylesheet">
	<link href="assets/css/style.css" rel="stylesheet">
</head>

<body class="bg-dark">
	<div class="Nixon-login">
		<div class="container">
			<div class="row">
				<div class="col-lg-6 col-lg-offset-3">
					<div class="login-content">
						<div class="login-logo">
							<h1 class="">Alice 寶貝寵物生活館</h1>
							<h2><img id="" src="logo/logoSmall.png" style="width:50px;height:43px;" />後端管理系統</h2>
						</div>
						<div class="login-form" style="background-color: lightgray;">
							<h4 class="display-4">管理帳號登錄</h4>
							<form method="POST" action="./login.php">
								<div class="form-group">
									<label>帳號</label>
									<input type="text" name="managerAccount" class="form-control" placeholder="帳號">
								</div>
								<div class="form-group">
									<label>密碼</label>
									<input type="password" name="managerPassword" class="form-control" placeholder="密碼">
								</div>
								<div>
									<label>
										<?= $ErrorMessage ?>
									</label>
								</div>
								<button type="submit" class="btn btn-primary btn-flat m-b-30 m-t-30">登入</button>
							</form>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</body>

</html>