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
            if(isset($_POST['addkategori']))
            {
                $namakategori = htmlspecialchars($_POST['nama_kategori']);    
                $tambahkat = mysqli_query($conn,"INSERT INTO kategori (nama_kategori) values ('$namakategori')");
                if ($tambahkat){
                    echo '<script>alert("Berhasil Menambahkan Data");window.location="kategori.php"</script>';
                } else {
                    echo '<script>alert("Gagal Menambahkan Data");history.go(-1);</script>';
                }
                
            };
            ?>
<div class="card">
    <div class="card-header">
        <div class="card-tittle"><i class="fa fa-table me-2 d-none d-sm-inline-block d-md-inline-block"></i> Data Kategori 
        <?php 
            if(!empty($_GET['edit'])){
                $idkategori = $_GET['edit'];
                $edit = mysqli_query($conn,"SELECT * FROM kategori WHERE idkategori='$idkategori'");
                while($e=mysqli_fetch_array($edit)){
                    $namo= $e['nama_kategori'];
                    echo '<form method="POST" class="float-right">
                    <div class="input-group">
                        <input type="text" name="nama_kategori" class="form-control form-control-sm bg-white"
                        style="border-radius:0.428rem 0px 0px 0.428rem;"
                        placeholder="Masukan Kategori" value="'.$namo.'" required>
                        <div class="input-group-append">
                            <button class="btn btn-success btn-xs p-1" name="update"
                            style="border-radius: 0px 0.428rem 0.428rem 0px;" type="submit">
                                <i class="fas fa-check"></i><span class="d-none d-sm-inline-block d-md-inline-block ml-1">Update</span>
                            </button>
                            <a href="kategori.php" class="btn btn-danger btn-xs py-1 px-2 ml-1"><i class="fas fa-times"></i>
                            <span class="d-none d-sm-inline-block d-md-inline-block ml-1">Batal</span></a>
                        </div>
                    </div>
                </form>';
                }
                if(isset($_POST['update'])){
                    $namakategori = htmlspecialchars($_POST['nama_kategori']);
                    $editup = mysqli_query($conn,"UPDATE kategori SET nama_kategori='$namakategori' WHERE idkategori='$idkategori'");
                    echo '<script>alert("Berhasil Update Kategori");window.location="kategori.php"</script>';
                    }
            } else { ?>
                <form method="POST" class="float-right">
                <div class="input-group">
                    <input type="text" name="nama_kategori" class="form-control form-control-sm bg-white"
                    style="border-radius:0.428rem 0px 0px 0.428rem;"
                    placeholder="Masukan Kategori" required>
                    <div class="input-group-append">
                        <button class="btn btn-primary btn-xs p-1" name="addkategori"
                        style="border-radius: 0px 0.428rem 0.428rem 0px;" type="submit">
                            <i class="fa fa-plus"></i><span class="d-none d-sm-inline-block d-md-inline-block ml-1">Tambah</span>
                        </button>
                    </div>
                </div>
            </form>
            <?php } ?>
        </div>
    </div>
        <div class="card-body">
            <table class="table table-striped table-sm table-bordered dt-responsive nowrap" id="table" width="100%">
                        <thead>
                        <tr>
                            <th>No.</th>
                            <th>Nama Kategori</th>
                            <th>Qty</th>
                            <th>Tanggal</th>
                            <th>Opsi</th>
                        </tr>
                        </thead>
                        <tbody>
                            <?php
                                $no=1;
                                $data_produk=mysqli_query($conn,"SELECT * FROM kategori ORDER BY idkategori ASC");
                                while($d=mysqli_fetch_array($data_produk)){
                                    $idkategori = $d['idkategori'];
                                    ?>
                                    
                                    <tr>
                                        <td><?php echo $no++ ?></td>
                                        <td><?php echo $d['nama_kategori'] ?></td>
                                        <td><?php 
                                            $result1 = mysqli_query($conn,"SELECT Count(idproduk) AS count FROM produk p, kategori k WHERE p.idkategori=k.idkategori and k.idkategori='$idkategori' ORDER BY idproduk ASC");
                                            $cekrow = mysqli_num_rows($result1);
                                            $row1 = mysqli_fetch_assoc($result1);
                                            $count = $row1['count'];
                                            if($cekrow > 0){
                                            echo ribuan($count);
                                            }
                                        ?></td>
                                        <td><?php echo $d['tgl_dibuat'] ?></td>
                                        <td>
                                        <a href="?edit=<?php echo $idkategori ?>" class="btn btn-primary btn-xs">
                                            <i class="fa fa-pen fa-xs mr-1"></i>Edit
                                        </a>
                                            <a class="btn btn-danger btn-xs" href="?hapus=<?php echo $idkategori ?>" 
                                            onclick="javascript:return confirm('Hapus Data produk - <?php echo $d['nama_kategori'] ?> ?');">
                                            <i class="fa fa-trash fa-xs mr-1"></i>Hapus</a>
                                        </td>
                                    </tr>		
                        <?php }?>
					</tbody>
                </table>
        </div>
</div>

<?php 
	if(!empty($_GET['hapus'])){
		$idkategori = $_GET['hapus'];
		$hapus_data = mysqli_query($conn, "DELETE FROM kategori WHERE idkategori='$idkategori'");
        if($hapus_data){
            echo '<script>alert("Berhasi Hapus Kategori");window.location="kategori.php"</script>';
        } else {
            echo '<script>alert("gagal Hapus Kategori");history.go(-1);</script>';
        }
	};
    ?>
<?php include 'template/footer.php';?>
