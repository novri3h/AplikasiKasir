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
<?php 
$tgl = date("jmYGi");
$huruf = "AD";
$kodeCart = $huruf . $tgl;
?>
<div class="row mt-3">

<div class="col-lg-3 mb-3">
    <div class="card small mb-3">
        <div class="card-header p-2">
            <div class="card-tittle"><i class="far fa-file mr-1"></i> Informasi Nota</div>
        </div>
        <div class="card-body p-2">
            <div class="row">
                <div class="col-4 mb-2 text-right pt-1 pr-1">No. Nota : </div>
                <div class="col-8 mb-2 pl-0">
                    <input type="text" class="form-control form-control-sm bg-white" value="<?php echo $kodeCart ?>" readonly>
                </div>
                <div class="col-4 mb-2 text-right pt-1 pr-1">Tanggal : </div>
                <div class="col-8 mb-2 pl-0">
                    <input type="text" class="form-control form-control-sm bg-white"  id="date-time" readonly>
                </div>
                <div class="col-4 text-right pt-1 pr-1">Kasir : </div>
                <div class="col-8 pl-0">
                    <input type="text" class="form-control form-control-sm bg-white" value="<?php echo $user ?>" readonly>
                </div>
            </div>
        </div>
    </div>

    <div class="card small mb-3">
        <div class="card-header p-2">
            <div class="card-tittle"><i class="far fa-user mr-1"></i> Informasi Pelanggan 
                <a class="float-right"href="#" onclick="TambahBaru()">
                    Tambah Baru ?
                </a>
            </div>
        </div>
        <div class="card-body p-2">
            <div style="display:none;width: 100%;" id="Tambah1">
            <?php
            if(isset($_POST['alamat_pelanggan']))
            {
                $nama_pelanggan = htmlspecialchars($_POST['nama_pelanggan']);
                $telepon_pelanggan = htmlspecialchars($_POST['telepon_pelanggan']);
                $alamat_pelanggan = htmlspecialchars($_POST['alamat_pelanggan']);

                $tambahPel = mysqli_query($conn,"INSERT INTO pelanggan(nama_pelanggan,telepon_pelanggan,alamat_pelanggan)
                 values ('$nama_pelanggan','$telepon_pelanggan','$alamat_pelanggan')");
                if ($tambahPel){
                    echo '<script>alert("Tambah Data Pelanggan Berhasil");window.location="index.php"</script>';
                } else {
                    echo '<script>alert("Maaf! data yang anda masukan salah.");history.go(-1);</script>';
                }
                
            };
            ?>
                <form method="post">
                    <div class="row">
                        <div class="col-4 mb-2 text-right pt-1 pr-1 text-primary">Pelanggan : </div>
                        <div class="col-8 mb-2 pl-0">
                            <input type="text" class="form-control form-control-sm" name="nama_pelanggan" required>
                        </div>
                        <div class="col-4 mb-2 text-right pt-1 pr-1 text-primary">Telepon : </div>
                        <div class="col-8 mb-2 pl-0">
                            <input type="number" class="form-control form-control-sm" name="telepon_pelanggan" required>
                        </div>
                        <div class="col-4 text-right pt-1 pr-1 text-primary">Alamat : </div>
                        <div class="col-8 pl-0">
                            <input type="text" class="form-control form-control-sm" name="alamat_pelanggan" onchange="form.submit()" required>
                        </div>
                    </div>
                </form>
            </div><!-- end tambah1 -->
            <div id="Ada1">
            <div class="row">
                <div class="col-4 mb-2 text-right pt-1 pr-1">Pelanggan : </div>
                <div class="col-8 mb-2 pl-0">
                <?php 
                    $plgn=mysqli_query($conn, "SELECT * FROM pelanggan order by idpelanggan ASC");
                    $jsArrayp = "var telepon_pelanggan = new Array();";
                    $jsArrayp1 = "var alamat_pelanggan = new Array();";
                    ?>
                    <input type="text" class="form-control form-control-sm bg-white"  list="datalist2"
                 onchange="changeValuePelanggan(this.value)" required>
                 <datalist id="datalist2">
                <?php  
                if(mysqli_num_rows($plgn)) {
                 while($row_p= mysqli_fetch_array($plgn)) {?>
                        <option value="<?php echo $row_p["nama_pelanggan"]?>"> <?php echo $row_p["nama_pelanggan"]?> 
                        <?php 
                                $jsArrayp .= "telepon_pelanggan['" . $row_p['nama_pelanggan'] . "'] = {telepon_pelanggan:'" . addslashes($row_p['telepon_pelanggan']) . "'};";
                                $jsArrayp1 .= "alamat_pelanggan['" . $row_p['nama_pelanggan'] . "'] = {alamat_pelanggan:'" . addslashes($row_p['alamat_pelanggan']) . "'};"; } ?>
                <?php } ?>
                    </datalist>
                </div>
                <div class="col-4 mb-2 text-right pt-1 pr-1">Telepon : </div>
                <div class="col-8 mb-2 pl-0">
                    <input type="text" class="form-control form-control-sm bg-white" id="telepon_pelanggan" readonly>
                </div>
                <div class="col-4 text-right pt-1 pr-1">Alamat : </div>
                <div class="col-8 pl-0">
                    <input type="text" class="form-control form-control-sm bg-white" id="alamat_pelanggan" readonly>
                </div>
            </div>
            </div><!-- end ada1 -->
        </div>
    </div>
</div>

<div class="col-lg-9">
    <form id="myCartNew" method="post">
    <div class="row">
        <div class="col-12 col-lg-2 m-pr-0">
        <?php 
            $barang=mysqli_query($conn, "SELECT * FROM kategori k, produk p WHERE k.idkategori=p.idkategori order by idproduk ASC");
            $jsArray = "var harga_jual = new Array();";
            $jsArray1 = "var nama_produk = new Array();";
            $jsArray2 = "var nama_kategori = new Array();";
            ?>
            <label class="mb-1">Kode Produk</label>
            <div class="input-group">
                <input type="text" name="kode_produk" class="form-control form-control-sm border-right-0" list="datalist1"
                 onchange="changeValue(this.value)"  aria-describedby="basic-addon2" required>
                <datalist id="datalist1">
                <?php  
                if(mysqli_num_rows($barang)) {
                 while($row_brg= mysqli_fetch_array($barang)) {?>
                        <option value="<?php echo $row_brg["kode_produk"]?>"> <?php echo $row_brg["kode_produk"]?> 
                        <?php $jsArray .= "harga_jual['" . $row_brg['kode_produk'] . "'] = {harga_jual:'" . addslashes($row_brg['harga_jual']) . "'};";
                                $jsArray1 .= "nama_produk['" . $row_brg['kode_produk'] . "'] = {nama_produk:'" . addslashes($row_brg['nama_produk']) . "'};";
                                $jsArray2 .= "nama_kategori['" . $row_brg['kode_produk'] . "'] = {nama_kategori:'" . addslashes($row_brg['nama_kategori']) . "'};"; } ?>
                <?php } ?>
                    </datalist>
                    <div class="input-group-append">
                        <span class="input-group-text bg-white border-left-0 pr-1" id="basic-addon2">
                        <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" fill="currentColor" class="bi bi-upc-scan" viewBox="0 0 16 16">
                            <path d="M1.5 1a.5.5 0 0 0-.5.5v3a.5.5 0 0 1-1 0v-3A1.5 1.5 0 0 1 1.5 0h3a.5.5 0 0 1 0 1h-3zM11 .5a.5.5 0 0 1 .5-.5h3A1.5 1.5 0 0 1 16 1.5v3a.5.5 0 0 1-1 0v-3a.5.5 0 0 0-.5-.5h-3a.5.5 0 0 1-.5-.5zM.5 11a.5.5 0 0 1 .5.5v3a.5.5 0 0 0 .5.5h3a.5.5 0 0 1 0 1h-3A1.5 1.5 0 0 1 0 14.5v-3a.5.5 0 0 1 .5-.5zm15 0a.5.5 0 0 1 .5.5v3a1.5 1.5 0 0 1-1.5 1.5h-3a.5.5 0 0 1 0-1h3a.5.5 0 0 0 .5-.5v-3a.5.5 0 0 1 .5-.5zM3 4.5a.5.5 0 0 1 1 0v7a.5.5 0 0 1-1 0v-7zm2 0a.5.5 0 0 1 1 0v7a.5.5 0 0 1-1 0v-7zm2 0a.5.5 0 0 1 1 0v7a.5.5 0 0 1-1 0v-7zm2 0a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5v-7zm3 0a.5.5 0 0 1 1 0v7a.5.5 0 0 1-1 0v-7z"/>
                            </svg></span>
                    </div>
                </div>
        </div>
        <div class="col-6 col-lg-2 pr-0">
            <label class="mb-1">Nama Produk</label>
            <input type="text" class="form-control form-control-sm bg-white" name="nama_produk" id="nama_produk" readonly>
        </div>
        <div class="col-6 col-lg-2 m-pr-0">
            <label class="mb-1">Kategori</label>
            <input type="text" class="form-control form-control-sm bg-white" name="nama_kategori" id="nama_kategori" readonly>
        </div>
        <div class="col-8 col-lg-2 pr-0">
            <label class="mb-1">Harga</label>
            <input type="number" class="form-control form-control-sm bg-white" id="harga_jual"
            value="<?php echo $row_brg['harga_jual'];?>" name="harga_jual" onchange="total()">
        </div>
        <div class="col-4 col-lg-2 m-pr-0">
            <label class="mb-1">Qty</label>
            <input type="number" class="form-control form-control-sm" id="quantity" onchange="total()"
            name="quantity" placeholder="0">
        </div>
        <div class="col-12 col-lg-2">
            <label class="mb-1">Subtotal</label>
            <div class="input-group">
                <input type="number" class="form-control form-control-sm bg-white" id="subtotal" name="subtotal" onchange="total()" readonly>
            <div class="input-group-append">
                <button class="btn btn-danger btn-sm border-0" type="reset"><i class="fa fa-trash-restore-alt"></i></button>
            </div>
            </div>
        </div>
    </div><!-- end row -->
</form>
    <table class="table table-striped table-sm table-bordered dt-responsive nowrap" id="cart" width="100%">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>Nama Kategori</th>
                            <th>Qty</th>
                            <th>Tanggal</th>
                            <th>Opsi</th>
                        </tr>
                        </thead>
                        <tbody>
                            <?php
                                $no=1;
                                $data_produk=mysqli_query($conn,"SELECT * FROM keranjang ORDER BY idcart ASC");
                                while($d=mysqli_fetch_array($data_produk)){
                                    $idcart = $d['idcart'];
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
                                            echo number_format($count);
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
                <div id="date-time1"></div>
</div><!-- end col-lg-9 -->

</div><!-- end row -->
<?php 
if(isset($_POST['selesai'])){
    $ambildata = mysqli_query($conn,"INSERT INTO laporanku (no_transaksi,bayar,kembalian,id_Cart,kode_barang, nama_kategori, harga_jual, quantity, subtotal, tgl_input)
    SELECT no_transaksi,bayar,kembalian,id_Cart,kode_barang, nama_kategori, harga_jual, quantity, subtotal, tgl_input
    FROM keranjang ") or die (mysqli_connect_error()); 
    $hapusdata = mysqli_query($conn,"DELETE FROM keranjang");
    echo '<script>window.location="index.php"</script>';
};

if(!empty($_GET['hapus'])){
    $idcart= $_GET['hapus'];
    $hapus_data = mysqli_query($conn, "DELETE FROM keranjang WHERE idcart ='$idcart'");
    echo '<script>window.location="index.php"</script>';
};

?>
<script type="text/javascript">
      <?php echo $jsArray,$jsArray1,$jsArray2,$jsArrayp,$jsArrayp1; ?>
    function changeValue(kode_produk) {
      document.getElementById("nama_produk").value = nama_produk[kode_produk].nama_produk;
      document.getElementById("nama_kategori").value = nama_kategori[kode_produk].nama_kategori;
      document.getElementById("harga_jual").value = harga_jual[kode_produk].harga_jual;
    };

function total() {
   var harga =  parseInt(document.getElementById('harga_jual').value);
   var jumlah_beli =  parseInt(document.getElementById('quantity').value);
   var jumlah_harga = harga * jumlah_beli;
    document.getElementById('subtotal').value = jumlah_harga;
    document.getElementById("myCartNew").submit();
  }
    
  function totalnya() {
   var harga =  parseInt(document.getElementById('hargatotal').value);
   var pembayaran =  parseInt(document.getElementById('bayarnya').value);
   var kembali = pembayaran - harga;
    document.getElementById('total1').value = kembali;
  }

  function changeValuePelanggan(nama_pelanggan) {
      document.getElementById("telepon_pelanggan").value = telepon_pelanggan[nama_pelanggan].telepon_pelanggan;
      document.getElementById("alamat_pelanggan").value = alamat_pelanggan[nama_pelanggan].alamat_pelanggan;
    };

  function printContent(print){
			var restorepage = document.body.innerHTML;
			var printcontent = document.getElementById(print).innerHTML;
			document.body.innerHTML = printcontent;
			window.print();
			document.body.innerHTML = restorepage;
		}
  </script>

<script type="text/javascript">
timer();
function timer(){
var today = new Date();
var date = today.getFullYear()+'-'+(today.getMonth()+1)+'-'+today.getDate();
var time = today.getHours() + ":" + today.getMinutes() + ":" + today.getSeconds();
var dateTime = date+' '+time;
document.getElementById('date-time').value = dateTime;
document.getElementById('date-time1').innerHTML = dateTime;
setTimeout(timer,1000);
        }
  </script>
  <script>
function TambahBaru() {
  var x = document.getElementById("Ada1");
  if (x.style.display === "none") {
    x.style.display = "block";
  } else {
    x.style.display = "none";
  }
  var y = document.getElementById("Tambah1");
  if (y.style.display === "block") {
    y.style.display = "none";
  } else {
    y.style.display = "block";
  }
}
</script>
<?php include 'template/footer.php';?>
