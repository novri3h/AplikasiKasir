<!-- Aplikasi e-Laboratory dengan PHP7 dan MySQLi
*******************************************************
* Developer    : Tri Hartono
* Company      : Nadhif Studio
* Release Date : 03 Agustus 2023
* Website      : bit.ly/M-UMKM
* E-mail       : nadhif.studio@gmail.com
* Phone        : +62-8953-3130-9434
-->

<?php include 'template/header.php';?>
<br>

<?php
if(isset($_POST['update'])){
    $id = htmlspecialchars($_POST['id_login']);
    $user = htmlspecialchars($_POST['username']);
    $toko = htmlspecialchars($_POST['nama_toko']);
    $alamat = htmlspecialchars($_POST['alamat']);
    $telp = htmlspecialchars($_POST['telepon']);
    $pass = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $result = mysqli_query($conn, "UPDATE login SET username='$user', password='$pass',nama_toko='$toko',alamat='$alamat',telepon='$telp'
     WHERE id_login = '$id' ") or die(mysqli_connect_error());
    if(!$result){
        echo '<script>alert("data gagal di update");history.go(-1);</script>';
        } else{
            echo '<script>alert("data berhasil di update");window.location="pengaturan.php"</script>';
}
}?>

<div class="card">
    <div class="card-header">
        <div class="card-tittle"><i class="fa fa-cog me-2"></i> Account Settings</div>
    </div>
    <form method="post">
        <div class="card-body">
            <div class="row">
                <div class="col-sm-6 col-md-6 mb-2">
                    <input type="hidden" name="id_login" value="<?php echo $id ?>">
                    <label for="namatoko">Nama Toko<span class="text-danger">*</span></label>
                    <input name="nama_toko" type="text" class="form-control" value="<?php echo $toko ?>" id="namatoko" placeholder="nama toko" required>
                </div>
                <div class="col-sm-6 col-md-6 mb-2">
                    <label for="username">Username<span class="text-danger">*</span></label>
                    <input name="username" type="text" class="form-control" value="<?php echo $user; ?>" id="username" placeholder="username" required>
                </div>
                <div class="col-sm-6 col-md-6 mb-2">
                    <label for="telepon">Telepon<span class="text-danger">*</span></label>
                    <input name="telepon" type="number" class="form-control" value="<?php echo $telp ?>" id="telepon" placeholder="0821xxx" required>
                </div>
                <div class="col-sm-6 col-md-6 mb-2">
                    <label for="password">Password<span class="text-danger">*</span></label>
                    <input name="password" type="password" class="form-control" id="password" placeholder="password" required>
                </div>
                <div class="col-sm-12 col-md-12">
                    <label for="alamat">Alamat<span class="text-danger">*</span></label>
                    <textarea name="alamat" class="form-control" id="alamat" cols="30" rows="10" required><?php echo $alamat ?></textarea>
                </div>
            </div>
        </div>
        <div class="card-footer text-right">
            <button type="submit" name="update" class="btn btn-primary px-3">Update</button>
        </div>
    </form>
</div>


<?php include 'template/footer.php';?>
