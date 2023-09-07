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
            if(isset($_POST['tambahPelanggan']))
            {
                $nama_pelanggan = htmlspecialchars($_POST['nama_pelanggan']);
                $telepon_pelanggan = htmlspecialchars($_POST['telepon_pelanggan']);
                $alamat_pelanggan = htmlspecialchars($_POST['alamat_pelanggan']);

                $tambahkat = mysqli_query($conn,"INSERT INTO pelanggan (nama_pelanggan,telepon_pelanggan,alamat_pelanggan)
                values ('$nama_pelanggan','$telepon_pelanggan','$alamat_pelanggan')");
                if ($tambahkat){
                    echo '<script>alert("Berhasil Menambahkan Data");window.location="pelanggan.php"</script>';
                } else {
                    echo '<script>alert("Gagal Menambahkan Data");history.go(-1);</script>';
                }
                
            };

            if(isset($_POST['updatePelanggan'])){
                $idpelanggan = htmlspecialchars($_POST['idpelanggan']);
                $nama_pelanggan = htmlspecialchars($_POST['nama_pelanggan']);
                $telepon_pelanggan = htmlspecialchars($_POST['telepon_pelanggan']);
                $alamat_pelanggan = htmlspecialchars($_POST['alamat_pelanggan']);

                mysqli_query($conn,"UPDATE pelanggan SET
                nama_pelanggan='$nama_pelanggan',telepon_pelanggan='$telepon_pelanggan',alamat_pelanggan='$alamat_pelanggan'
                WHERE idpelanggan='$idpelanggan' ");
                echo '<script>alert("Berhasil Update data pelanggan");window.location="pelanggan.php"</script>';
            };
            ?>
<div class="card">
    <div class="card-header">
        <div class="card-tittle"><i class="fa fa-table me-2"></i> Data Pelanggan
        <button type="button" class="btn btn-primary btn-xs p-2 float-right" data-toggle="modal" data-target="#addpelanggan">
            <i class="fa fa-plus fa-xs mr-1"></i> Tambah Data</button></div>
    </div>
        <div class="card-body">
            <table class="table table-striped table-sm table-bordered dt-responsive nowrap" id="table" width="100%">
                        <thead>
                        <tr>
                            <th>No.</th>
                            <th>Nama Pelanggan</th>
                            <th>Telepon</th>
                            <th>Alamat</th>
                            <th>Opsi</th>
                        </tr>
                        </thead>
                        <tbody>
                            <?php
                                $no=1;
                                $data_produk=mysqli_query($conn,"SELECT * FROM pelanggan order by idpelanggan ASC");
                                while($d=mysqli_fetch_array($data_produk)){
                                    $idpelanggan = $d['idpelanggan'];
                                    ?>
                                    
                                    <tr>
                                        <td><?php echo $no++ ?></td>
                                        <td><?php echo $d['nama_pelanggan'] ?></td>
                                        <td><?php echo $d['telepon_pelanggan'] ?></td>
                                        <td><?php echo $d['alamat_pelanggan'] ?></td>
                                        <td>
                                            <button type="button" class="btn btn-primary btn-xs"
                                             data-toggle="modal" data-target="#editP<?php echo $idpelanggan ?>">
                                             <i class="fa fa-pen fa-xs mr-1"></i>Edit</button>
                                            <a class="btn btn-danger btn-xs" href="?hapus=<?php echo $idpelanggan ?>" 
                                            onclick="javascript:return confirm('Hapus Data Pelanggan - <?php echo $d['nama_pelanggan'] ?> ?');">
                                            <i class="fa fa-trash fa-xs mr-1"></i>Hapus</a>
                                        </td>
                                    </tr>
                                    
                                    <!-- modal edit -->
                                    <div class="modal fade" id="editP<?php echo $idpelanggan ?>" tabindex="-1" role="dialog" aria-labelledby="ModalTittle2" aria-hidden="true">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                            <form method="post">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="ModalTittle2"><i class="fa fa-user mr-1 text-muted"></i> Edit Pelanggan</h5>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                <div class="form-group mb-2">
                                                    <label>Nama Pelanggan :</label>
                                                    <input type="hidden" name="idpelanggan" class="form-control" value="<?php echo $d['idpelanggan'] ?>">
                                                    <input type="text" name="nama_pelanggan" class="form-control" value="<?php echo $d['nama_pelanggan'] ?>" required>
                                                </div>
                                                <div class="form-group mb-2">
                                                    <label>Telepon :</label>
                                                    <input type="number" name="telepon_pelanggan" class="form-control" value="<?php echo $d['telepon_pelanggan'] ?>" required>
                                                </div>
                                                <div class="form-group mb-2">
                                                    <label>Alamat :</label>
                                                    <input type="text" name="alamat_pelanggan" class="form-control" value="<?php echo $d['alamat_pelanggan'] ?>" required>
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-light btn-xs p-2" data-dismiss="modal">
                                                    <i class="fa fa-times mr-1"></i> Batal</button>
                                                <button type="submit" class="btn btn-primary btn-xs p-2" name="updatePelanggan">
                                                <i class="fa fa-plus-circle mr-1"></i> Simpan</button>
                                            </div>
                                            </form>
                                            </div>
                                        </div>
                                        </div>
                                    <!-- end modal edit -->
                        <?php }?>
					</tbody>
                </table>
        </div>
</div>
<?php 
	if(!empty($_GET['hapus'])){
		$idpelanggan = $_GET['hapus'];
		$hapus_data = mysqli_query($conn, "DELETE FROM pelanggan WHERE idpelanggan='$idpelanggan'");
        if($hapus_data){
            echo '<script>alert("Berhasi Hapus pelanggan");window.location="pelanggan.php"</script>';
        } else {
            echo '<script>alert("gagal Hapus pelanggan");history.go(-1);</script>';
        }
	};
    ?>
<!-- Modal -->
<div class="modal fade" id="addpelanggan" tabindex="-1" role="dialog" aria-labelledby="ModalTittle" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
    <form method="post">
      <div class="modal-header">
        <h5 class="modal-title" id="ModalTittle"><i class="fa fa-shopping-bag mr-1 text-muted"></i> Tambah Produk</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
      <div class="form-group mb-2">
                <label>Nama Pelanggan :</label>
                <input type="text" name="nama_pelanggan" class="form-control" required>
            </div>
            <div class="form-group mb-2">
                <label>Telepon :</label>
                <input type="number" name="telepon_pelanggan" class="form-control" required>
            </div>
            <div class="form-group mb-2">
                <label>Alamat :</label>
                <input type="text" name="alamat_pelanggan" class="form-control" required>
            </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-light btn-xs p-2" data-dismiss="modal">
            <i class="fa fa-times mr-1"></i> Batal</button>
        <button type="reset" class="btn btn-danger btn-xs p-2">
        <i class="fa fa-trash-restore-alt mr-1"></i> Reset</button>
        <button type="submit" class="btn btn-primary btn-xs p-2" name="tambahPelanggan">
        <i class="fa fa-plus-circle mr-1"></i> Simpan</button>
      </div>
      </form>
    </div>
  </div>
</div>
<?php include 'template/footer.php';?>
