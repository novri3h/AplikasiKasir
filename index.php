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
$bikin_nota = mysqli_query($conn, "SELECT max(no_nota) as kodeTerbesar11 FROM laporan");
$datanya = mysqli_fetch_array($bikin_nota);
$kodenota= $datanya['kodeTerbesar11'];
$urutan = (int) substr($kodenota, 9, 3);
$urutan++;
$tgl = date("jnyGi");
$huruf = "AD";
$kodeCart = $huruf . $tgl . sprintf("%03s", $urutan);
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
                    $jsArrayp2 = "var idpelanggan = new Array();";
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
                                $jsArrayp1 .= "alamat_pelanggan['" . $row_p['nama_pelanggan'] . "'] = {alamat_pelanggan:'" . addslashes($row_p['alamat_pelanggan']) . "'};";
                                $jsArrayp2 .= "idpelanggan['" . $row_p['nama_pelanggan'] . "'] = {idpelanggan:'" . addslashes($row_p['idpelanggan']) . "'};"; } ?>
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

<div class="col-lg-9" id="print">
    <form id="myCartNew" method="post">
    <div class="row print-none">
        <div class="col-12 col-lg-3 m-pr-0">
        <?php
            $barang=mysqli_query($conn, "SELECT * FROM produk ORDER BY idproduk ASC");
            $jsArray = "var harga_jual = new Array();";
            $jsArray1 = "var nama_produk = new Array();";
            $jsArray3 = "var idproduk = new Array();";
            $jsArray4 = "var stock = new Array();";
            ?>
            <label class="mb-1">Kode Produk</label>
            <div class="input-group">
                <input type="text" class="form-control form-control-sm border-right-0" list="datalist1"
                 onchange="changeValue(this.value)"  aria-describedby="basic-addon2" required>
                <datalist id="datalist1">
                <?php
                if(mysqli_num_rows($barang)) {
                 while($row_brg= mysqli_fetch_array($barang)) {?>
                        <option value="<?php echo $row_brg["kode_produk"]?>"> <?php echo $row_brg["kode_produk"]?>
                        <?php $jsArray .= "harga_jual['" . $row_brg['kode_produk'] . "'] = {harga_jual:'" . addslashes($row_brg['harga_jual']) . "'};";
                                $jsArray1 .= "nama_produk['" . $row_brg['kode_produk'] . "'] = {nama_produk:'" . addslashes($row_brg['nama_produk']) . "'};";
                                $jsArray3 .= "idproduk['" . $row_brg['kode_produk'] . "'] = {idproduk:'" . addslashes($row_brg['idproduk']) . "'};";
                                $jsArray4 .= "stock['" . $row_brg['kode_produk'] . "'] = {stock:'" . addslashes($row_brg['stock']) . "'};"; } ?>
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
            <input type="hidden" class="form-control form-control-sm bg-white" name="idproduk" id="idproduk" readonly>
            <input type="text" class="form-control form-control-sm bg-white" id="nama_produk" readonly>
        </div>
        <div class="col-6 col-lg-2 m-pr-0">
            <label class="mb-1">Harga</label>
            <input type="text" class="form-control form-control-sm bg-white" id="harga_jual"
             onchange="total()">
        </div>
        <div class="col-6 col-lg-1 pr-0">
            <label class="mb-1">Stock</label>
            <input type="text" class="form-control form-control-sm bg-white" id="stock" readonly>
        </div>
        <div class="col-6 col-lg-1 m-pr-0">
            <label class="mb-1">Qty</label>
            <input type="number" class="form-control form-control-sm" id="quantity" onchange="total()"
            name="quantity" placeholder="0" required>
        </div>
        <div class="col-lg-3">
            <label class="mb-1">Subtotal</label>
            <div class="input-group">
                <input type="number" class="form-control form-control-sm bg-white" id="subtotal" name="tambahcuy" onchange="total()" readonly>
            <div class="input-group-append">
                <button class="btn btn-danger btn-sm border-0" type="reset">
                    <i class="fa fa-trash-restore-alt"></i> Reset</button>
            </div>
            </div>
        </div>
    </div><!-- end row -->
</form>
<?php
if(isset($_POST['tambahcuy'])){
    $idproduk  = $_POST['idproduk'];
    $quantity  = $_POST['quantity'];
    $cekBarang = mysqli_query($conn, "SELECT * FROM produk WHERE idproduk='$idproduk'");
    $stocknya  = mysqli_fetch_array($cekBarang);
    $stock     = $stocknya['stock'];
    $sisa      = $stock-$quantity;

    if ($stock < $quantity) {
    echo '<script>alert("Oops! Jumlah pengeluaran lebih besar dari stok ...");window.location="index.php"</script>';
    }
    else{
     $insert = mysqli_query($conn, "INSERT INTO keranjang (idproduk,quantity) VALUES ('$idproduk','$quantity')");
      if($insert){
        $upstok = mysqli_query($conn, "UPDATE produk SET stock='$sisa' WHERE idproduk='$idproduk'");
        echo '<script>window.location="index.php"</script>';
     }
         else { echo '<script>alert("ERROR.");history.go;</script>';}
    }
    }
?>

<div class="d-none pt-5 px-4 print-show">
    <div class="row">
        <div class="col-12 text-center mb-2">
            <h1 style="font-size:60px;font-weight:700;"><?php echo $toko ?></h1>
            <h4 class="mb-0"><?php echo $alamat ?></h4>
            <h4 class="mb-2">Tel : <?php echo $telp  ?></h4>
        </div>
        <div class="col-7">
            <h3 class="mb-0" style="text-transform: uppercase;">INVOICE : <?php echo $kodeCart ?></h3>
            <h3 class="mb-0" style="text-transform: uppercase;">KASIR : <?php echo $user ?></h3>
        </div>
        <div class="col-5">
            <div class="row">
                <div class="col-6 text-right mb-1"><h3 class="mb-0">TANGGAL :</h3></div>
                <div class="col-6 pl-1 mb-1"><h3 class="mb-0"><?php echo date('d-m-Y') ?></h3></div>
                <div class="col-6 text-right"><h3 class="mb-0">PUKUL :</h3></div>
                <div class="col-6 pl-1"><h3 class="mb-0" id="jam-print"></h3></div>
            </div>
        </div>
        <div class="col-12 bg-secondary border my-3"></div>
        <div class="col-12 mb-3">
            <div class="row">
                <div class="col-1 text-center"><h3 style="font-weight:700;">QTY</h3></div>
                <div class="col"><h3 style="font-weight:700;">PRODUK</h3></div>
                <div class="col text-center"><h3 style="font-weight:700;">HARGA</h3></div>
                <div class="col text-right"><h3 style="font-weight:700;">SUBTOTAL</h3></div>
            </div>
        </div>
        <?php
            $subtotalcart2= 0;
            $no=1;
            $data_produk1=mysqli_query($conn,"SELECT * FROM keranjang c, produk p
            WHERE p.idproduk=c.idproduk ORDER BY idcart ASC");
            while ($c = $data_produk1->fetch_assoc()) {
                $subtotalcart3 = $c['harga_jual'] * $c['quantity'];
                $subtotalcart2 += $subtotalcart3;
                ?>
        <div class="col-12 mb-2">
            <div class="row">
                <div class="col-1 text-center"><h3><?php echo $c['quantity'] ?></h3></div>
                <div class="col"><h3><?php echo $c['nama_produk'] ?></h3></div>
                <div class="col text-center"><h3>Rp.<?php echo ribuan($c['harga_jual']) ?></h3></div>
                <div class="col text-right"><h3>Rp.<?php echo ribuan($subtotalcart3) ?></h3></div>
            </div>
        </div>
        <?php }?>
        <div class="col-12 bg-secondary border my-3"></div>
        <div class="col-12">
            <h3>Total Belanja <span class="float-right">Rp.<?php echo ribuan($subtotalcart2) ?></span></h3>
            <h3>Tunai <div class="float-right">Rp.<span id="bayarnya1"></span></div></h3>
            <h3>Kembali <div class="float-right">Rp.<span id="total2"></span></div></h3>
        </div>
        <div class="col-12 bg-secondary border my-3"></div>
        <div class="col-12">
            <h4>Catatan : <span id="new_catatan"></span></h4>
        </div>
        <div class="col-12 bg-secondary border my-3"></div>
        <div class="col-12 text-center">
            <h3>* Terima Kasih Telah Berbelanja Di Toko Kami *</h3>
            <p class="h4 text-muted">Powered By.Nadhif Studio</p>
        </div>
    </div><!-- end row -->
</div><!-- end box print -->

    <table class="table table-striped table-sm table-bordered dt-responsive nowrap print-none" id="cart" width="100%">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>Kode Produk</th>
                            <th>Nama Produk</th>
                            <th>Harga</th>
                            <th>Qty</th>
                            <th>Subtotal</th>
                            <th>Opsi</th>
                        </tr>
                        </thead>
                        <tbody>
                            <?php
                                $subtotalcart1= 0;
                                $no=1;
                                $data_produk=mysqli_query($conn,"SELECT * FROM keranjang c, produk p
                                WHERE p.idproduk=c.idproduk ORDER BY idcart ASC");
                                while ($d = $data_produk->fetch_assoc()) {
                                    $idcart = $d['idcart'];
                                    $subtotalcart = $d['harga_jual'] * $d['quantity'];
                                    $subtotalcart1 += $subtotalcart;
                                    ?>

                                    <tr>
                                        <td><?php echo $no++ ?></td>
                                        <td><?php echo $d['kode_produk'] ?></td>
                                        <td><?php echo $d['nama_produk'] ?></td>
                                        <td>Rp.<?php echo ribuan($d['harga_jual']) ?></td>
                                        <td><?php echo $d['quantity'] ?></td>
                                        <td>Rp.<?php echo ribuan($subtotalcart) ?></td>
                                        <td>
                                            <form method="post" class="d-inline-block">
                                            <input type="hidden" name="idpr" value="<?php echo $d['idproduk'] ?>">
                                            <input type="hidden" name="idcc" value="<?php echo $d['idcart'] ?>">
                                                <input type="hidden" name="jml" value="<?php echo $d['quantity'] ?>">
                                                <button type="submit" name="upone" class="btn btn-danger btn-xs"><i class="fa fa-trash fa-xs mr-1"></i>Hapus</a></button>
                                            </form>
                                        </td>
                                    </tr>
                        <?php
                        if(isset($_POST['upone'])){
                            $idcartt = $_POST['idcc'];
                            $idproduk = $_POST['idpr'];
                            $jml = $_POST['jml'];

                            $cekBarang1 = mysqli_query($conn, "SELECT * FROM produk WHERE idproduk='$idproduk'");
                            $stocknya1  = mysqli_fetch_array($cekBarang1);
                            $stockk     = $stocknya1['stock'];
                            //menghitung sisa stok
                            $sisa1    =$stockk+$jml;

                            if ($stockk < $jml) {

                            }
                            //proses
                            else{
                                $insert1 = mysqli_query($conn, "UPDATE produk SET stock='$sisa1' WHERE idproduk='$idproduk'");
                                    if($insert1){
                                        //update stok
                                        $hapus_data = mysqli_query($conn, "DELETE FROM keranjang WHERE idcart ='$idcartt'");
                                        echo '<script>alert("Data Berhasil Di Hapus");window.location="index.php"</script>';
                                    } else {
                                        echo '<script>alert("ERROR.");history.go(-1);</script>';
                                    }
                            }
                            }
                    }?>
					</tbody>
                </table>
                <div class="bg-total p-2 text-right print-none">
                    Rp.<?php echo ribuan($subtotalcart1) ?>
                </div>
                <form method="POST" class="mt-2 print-none">
                    <div class="row">
                        <div class="col-lg-7 mb-2">
                            <textarea name="catatan" class="form-control form-control-sm" id="catatan_baru"
                            placeholder="Catatan Transaksi (Jika Ada)"cols="10" rows="5" onchange="new_catatan()"></textarea>
                        </div>
                        <div class="col-lg-5 mb-2 print-none">
                            <div class="row">
                            <div class="col-5 mb-2 text-right pt-1 pr-2" style="font-weight:500;">Pembayaran :</div>
                                <div class="col-7 mb-2 pl-0">
                                    <input type="hidden" name="no_nota" value="<?php echo $kodeCart ?>">
                                    <input type="hidden" name="idpelanggan" id="idpelanggan" required>
                                    <input type="hidden" name="totalbeli" value="<?php echo $subtotalcart1 ?>" id="hargatotal">
                                    <input type="number" class="form-control form-control-sm bg-white" placeholder="0"
                                    name="pembayaran" id="bayarnya" onchange="totalnya()" required>
                                </div>
                                <div class="col-5 text-right pt-1 pr-2" style="font-weight:500;">Kembalian :</div>
                                <div class="col-7 pl-0">
                                    <input type="text" class="form-control form-control-sm bg-white"
                                    placeholder="0" name="kembalian" id="total1" readonly>
                            </div>
                            </div>
                            <div class="col-12 text-right pr-0 mt-2">
                            <button type="button" class="btn btn-light btn-sm px-3"  onclick="document.title='Invoice#<?php echo $kodeCart ?>';window.print()">
                                    <i class="fa fa-print mr-1"></i> Cetak
                                </button>
                                <button type="reset" class="btn btn-danger btn-sm px-3">
                                    <i class="fa fa-trash-restore-alt mr-1"></i> Reset
                                </button>
                                <button type="submit" name="save" class="btn btn-primary btn-sm px-3">
                                    <i class="far fa-file mr-1"></i> Simpan
                                </button>
                            </div>
                        </div>
                    </div><!-- end row -->
                </form>
                </div><!-- end print -->
</div><!-- end col-lg-9 -->

</div><!-- end row -->
<b><marquee bgcolor="yellow">SELAMAT DATANG DI TOKO HAI-FAMART | SILAHKAN TELITI ULANG BARANG YANG SUDAH DI INPUT | TOKO HAI-FAMART MELAYANI DENGAN SEPENUH HATI DAN SEPENUH JIWA</marquee></b>
<?php
if(isset($_POST['save'])){
    $nonota = $_POST['no_nota'];
    $idpell = $_POST['idpelanggan'];
    $pembayaran= $_POST['pembayaran'];
    $kembalian = $_POST['kembalian'];
    $totalbeli = $_POST['totalbeli'];
    $catatan = htmlspecialchars($_POST['catatan']);

    $updatetkeranjang = mysqli_query($conn,"UPDATE keranjang SET
      no_nota='$nonota'")
     or die (mysqli_connect_error());

     $ambildatacart = mysqli_query($conn,"INSERT INTO tb_nota
     (no_nota,idproduk,quantity)
    SELECT no_nota,idproduk,quantity FROM keranjang")
     or die (mysqli_connect_error());

     $insertlaporan = mysqli_query($conn, "INSERT INTO laporan (no_nota,idpelanggan,catatan,pembayaran,kembalian,totalbeli)
      VALUES ('$nonota','$idpell','$catatan','$pembayaran','$kembalian','$totalbeli')");

    $hapusdatacart = mysqli_query($conn,"DELETE FROM keranjang");

    if($updatetkeranjang&&$ambildatacart&&$insertlaporan ){
        echo '<script>window.location="index.php"</script>';
    } else {
        echo '<script>window.location="index.php"</script>';
    }

}
?>
<script type="text/javascript">
      <?php echo $jsArray,$jsArray1,$jsArray3,$jsArray4,$jsArrayp,$jsArrayp1,$jsArrayp2; ?>
    function changeValue(kode_produk) {
      document.getElementById("nama_produk").value = nama_produk[kode_produk].nama_produk;
      document.getElementById("harga_jual").value = harga_jual[kode_produk].harga_jual;
      document.getElementById("idproduk").value = idproduk[kode_produk].idproduk;
      document.getElementById("stock").value = stock[kode_produk].stock;
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
    document.getElementById('total2').innerHTML = kembali;
    document.getElementById('bayarnya1').innerHTML = pembayaran;
  }

  function changeValuePelanggan(nama_pelanggan) {
      document.getElementById("telepon_pelanggan").value = telepon_pelanggan[nama_pelanggan].telepon_pelanggan;
      document.getElementById("alamat_pelanggan").value = alamat_pelanggan[nama_pelanggan].alamat_pelanggan;
      document.getElementById("idpelanggan").value = idpelanggan[nama_pelanggan].idpelanggan;
    };

    function new_catatan() {
    var c = document.getElementById("catatan_baru").value;
    document.getElementById("new_catatan").innerHTML = c;
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
document.getElementById('jam-print').innerHTML = time;
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
