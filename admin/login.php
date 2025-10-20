<link href="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
<script src="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<!------ Include the above in your HEAD tag ---------->

<!DOCTYPE html>
<html>
<?php
    include "includes/config.php";
    ob_start();
    session_start();

    if (isset($_POST["login"])) {
        $username = $_POST["user"];
        $userpass = $_POST["pass"]; // Ambil password dalam bentuk plain

        // Query untuk mendapatkan data user berdasarkan username
        $sql_login = mysqli_query($conn, "SELECT * FROM admin WHERE admin_USER = '$username'");

        if (mysqli_num_rows($sql_login) > 0) {
            $row_admin = mysqli_fetch_array($sql_login);
            $hashedpassfromdb = $row_admin['admin_PASS']; // Hash password dari database (MD5)

            // Cek apakah password di database adalah MD5
            if (strlen($hashedpassfromdb) == 32 && ctype_xdigit($hashedpassfromdb)) {
                // Verifikasi password dengan MD5 (sementara)
                if (md5($userpass) === $hashedpassfromdb) {
                    // Jika cocok, migrasikan password ke password_hash yang lebih aman
                    $new_hashed_password = password_hash($userpass, PASSWORD_DEFAULT);

                    // Update password di database
                    $update_sql = "UPDATE admin SET admin_PASS = '$new_hashed_password' WHERE admin_ID = '{$row_admin['admin_ID']}'";
                    mysqli_query($conn, $update_sql);

                    // Set sesi dan lanjutkan login
                    $_SESSION['admin_ID'] = $row_admin['admin_ID'];
                    $_SESSION['admin_USER'] = $row_admin['admin_USER'];
                    header("location:kategori.php");
                    exit();
                } else {
                    echo "<div class='alert alert-danger'>Password salah.</div>";
                }
            } else {
                // Jika password sudah di-hash dengan password_hash, gunakan password_verify()
                if (password_verify($userpass, $hashedpassfromdb)) {
                    // Jika password cocok, buat session
                    $_SESSION['admin_ID'] = $row_admin['admin_ID'];
                    $_SESSION['admin_USER'] = $row_admin['admin_USER'];
                    header("location:kategori.php");
                    exit();
                } else {
                    echo "<div class='alert alert-danger'>Password salah.</div>";
                }
            }
        } else {
            echo "<div class='alert alert-danger'>Username tidak ditemukan.</div>";
        }
    }
?>
<head>
	<title>Login Page</title>
   <!--Made with love by Mutiullah Samim -->
   
	<!--Bootsrap 4 CDN-->
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
    
    <!--Fontawesome CDN-->
	<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.3.1/css/all.css" integrity="sha384-mzrmE5qonljUremFsqc01SB46JvROS7bZs3IO2EmfFsd15uHvIt+Y8vEf7N7fWAU" crossorigin="anonymous">
    
	<!--Custom styles-->
	<link rel="stylesheet" type="text/css" href="styles.css">
    <link rel="stylesheet" type="text/css" href="css/csslogin.css">
</head>
<body>
<div class="container">
	<div class="d-flex justify-content-center h-100">
		<div class="card">
			<div class="card-header">
				<h3>Sign In</h3>
				<div class="d-flex justify-content-end social_icon">
					<span><i class="fab fa-facebook-square"></i></span>
					<span><i class="fab fa-google-plus-square"></i></span>
					<span><i class="fab fa-twitter-square"></i></span>
				</div>
			</div>
			<div class="card-body">
            <form method="POST">
					<div class="input-group form-group">
						<div class="input-group-prepend">
							<span class="input-group-text"><i class="fas fa-user"></i></span>
						</div>
						<input type="text" class="form-control" placeholder="username" name="user">
						
					</div>
					<div class="input-group form-group">
						<div class="input-group-prepend">
							<span class="input-group-text"><i class="fas fa-key"></i></span>
						</div>
						<input type="password" class="form-control" placeholder="password" name="pass">
					</div>
					<div class="row align-items-center remember">
						<input type="checkbox">Remember Me
					</div>
					<div class="form-group">
						<input type="submit" value="Login" class="btn float-right login_btn" name="login">
					</div>
				</form>
			</div>
			<div class="card-footer">
				<div class="d-flex justify-content-center links">
					Don't have an account?<a href="#">Sign Up</a>
				</div>
				<div class="d-flex justify-content-center">
					<a href="#">Forgot your password?</a>
				</div>
			</div>
		</div>
	</div>
</div>
</body>
<?php
mysqli_close($conn);
ob_end_flush();
?>
</html>
