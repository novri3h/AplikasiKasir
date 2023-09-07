<!-- By : Nadhif Studio -->
<!-- Di Larang Memperjual Source Code ini -->
<?php
	@ob_start();
	session_start();
    include 'config.php';
	if(!isset($_SESSION['status'])){
    } else {
        header('location:index.php');
    };
?>
<!DOCTYPE html>
<html lang="en">
<head>
<link rel="icon" href="favicon.ico">
<link rel="icon" href="icon.ico" type="image/ico">
  <title>APLIKASI KASIR</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="assets/css/bootstrap.min.css">
  <link rel="stylesheet" href="assets/css/style.css">
  <link href="assets/fontawesome/css/all.min.css" rel="stylesheet" type="text/css">
</head>
<body class="bg-light">
<body class="hold-transition login-page" style="background:url(assets/img/photo1.jpg)
no-repeat center center fixed; background-size: cover;
 -webkit-background-size: cover; 
 -moz-background-size: cover; -o-background-size: cover;">
<?php 
    if(isset($_POST['login'])){
        $user = mysqli_real_escape_string($conn,$_POST['username']);
        $pass = mysqli_real_escape_string($conn,$_POST['password']);
        $queryuser = mysqli_query($conn,"SELECT * FROM login WHERE username='$user'");
        $cariuser = mysqli_fetch_assoc($queryuser);
            
            if( password_verify($pass, $cariuser['password']) ) {
                $_SESSION['id_login'] = $cariuser['id_login'];
                $_SESSION['username'] = $cariuser['username'];
                $_SESSION['nama_toko'] = $cariuser['nama_toko'];
                $_SESSION['alamat'] = $cariuser['alamat'];
                $_SESSION['telepon'] = $cariuser['telepon'];
                $_SESSION['status'] = "login";

                if($cariuser){ 
                    echo '<script>alert("Data yang anda masukan benar");window.location="index.php"</script>';
                }else{
                    echo '<script>alert("Data yang anda masukan salah");history.go(-1);</script>';
                }
                echo '<script>alert("Anda Berhasil Login");window.location="index.php"</script>';
            } else {
                echo '<script>alert("Username atau password salah");history.go(-1);</script>';
            }	
        };
  
        ?>
<div class="container">
<br><br><br><br><br><br>

<div class="row justify-content-center">

    <div class="col-sm-8 col-md-6 col-lg-4">
    <h1 class="h3 text-center mb-3" style="font-weight:600;">APLIKASI <span class="text-primary">KASIR</span></h1>
	<img alt="logo" src="assets/img/logo.png" height="110" width="390"/><p>
            <div class="card-body bg-white shadow-sm">
				<form method="POST">
                <label for="user">Username</label>
                <div class="input-group mb-2">
                    <div class="input-group-prepend">
                        <div class="input-group-text"><i class="fa fa-user"></i></div>
                    </div>
                    <input type="text" class="form-control" id="user" name="username" placeholder="Username" required>
                </div>

                <label for="pass">Password</label>
                <div class="input-group mb-2">
                    <div class="input-group-prepend">
                        <div class="input-group-text"><i class="fa fa-lock"></i></div>
                    </div>
                    <input type="password" class="form-control" id="pass" name="password" placeholder="Password" required>
                </div>
                <div class="row">
                <div class="col-6 pr-1 mt-2">
                    <button class="btn btn-danger btn-block" type="reset">
                       <i class="fa fa-trash-restore-alt mr-1"></i> Reset</button>
                </div>
                <div class="col-6 pl-1 mt-2">
                    <button class="btn btn-primary btn-block" name="login" type="submit">
                       <i class="fa fa-sign-in-alt mr-1"></i> Login</button>
                </div>
                </div>
            </form>
        </div>
		<p><!-- BEGIN: Powered by Ipaddress.is -->
<p><span style="text-align:center; display:
block;"><a href="https://www.youtube.com/@NadhifMedia">
<img src="http://www.wieistmeineip.de/ip-address/?size=468x60" border="0" width="390" height="60" alt="IP" /></a><br /></span></p>
<!-- END: Powered by Ipaddress.is -->
        <div class="text-center small mt-4">
            <p class="text-muted">Aplikasi kasir © <?php echo date('Y');?> - By : <a href="https://blog-nadhif.blogspot.com" class="span text-primary">Nadhif Studio</a></p>
        </div>
    </div>

</div>


</div> <!-- end container fluid -->

    <script src="assets/js/jquery.slim.min.js"></script>
    <script src="assets/js/popper.min.js"></script>
    <script src="assets/js/bootstrap.bundle.min.js"></script>
</body>
</html>