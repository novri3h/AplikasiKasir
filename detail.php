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
$nota = $_GET['invoice'];
if(!isset($_GET['invoice'])){
    echo '<script>alert("Data Tidak Di Temukan");history.go(-1);</script>';
}
$liatcust = mysqli_query($conn,"SELECT * FROM pelanggan e, laporan c WHERE no_nota='$nota' and e.idpelanggan=c.idpelanggan");
$checkdb = mysqli_fetch_array($liatcust);
?>
<br>
<a href="laporan.php" class="btn btn-light btn-xs px-3 py-2 mb-2" style="font-weight:500;"><i class="fa fa-chevron-left fa-xs"></i> Kembali</a>
<div class="row">
    <div class="col-sm-6">
    <h6 class="mb-0">Invoice : <?php echo $nota ?></h6>
        <p class="small mb-0">Kasir : <?php echo $user ?></p>
        <p class="small mb-0">Tanggal : <?php echo $checkdb['tgl_sub'] ?></p>
    </div>
    <div class="col-sm-6">
        <p class="small mb-0">Nama : <?php echo $checkdb['nama_pelanggan'] ?></p>
        <p class="small mb-0">Telepon : <?php echo $checkdb['telepon_pelanggan'] ?></p>
        <p class="small mb-0">Alamat : <?php echo $checkdb['alamat_pelanggan'] ?></p>
    </div>
</div>
<table class="table table-sm table-bordered dt-responsive nowrap border-0" id="cart" width="100%">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>Nama Produk</th>
                            <th>Qty</th>
                            <th>Harga</th>
                            <th>Subtotal</th>
                        </tr>
                        </thead>
                        <tbody>
                            <?php
                                 $no=1;
                                 $data_produk=mysqli_query($conn,"SELECT * FROM tb_nota t, produk p
                                 WHERE no_nota='$nota' and t.idproduk=p.idproduk ORDER BY t.idproduk ASC");
                                 while($d=mysqli_fetch_array($data_produk)){
                                    $total = $d['quantity']*$d['harga_jual'];
                                    ?>
                                    
                                    <tr>
                                        <td style="border: 1px solid #dee2e6;"><?php echo $no++ ?></td>
                                        <td style="border: 1px solid #dee2e6;"><?php echo $d['nama_produk'] ?></td>
                                        <td style="border: 1px solid #dee2e6;"><?php echo $d['quantity'] ?></td>
                                        <td style="border: 1px solid #dee2e6;">Rp.<?php echo ribuan($d['harga_jual']) ?></td>
                                        <td style="border: 1px solid #dee2e6;">Rp.<?php echo ribuan($total) ?></td>
                                    </tr>		
                        <?php }?>
					</tbody>
                    <tr>
                        <th class="d-none d-sm-block d-md-block border-0 bg-white"></th>
                        <th class="border-0 bg-white"></th>
                        <th class="border-0 bg-white"></th>
                        <th class="text-right bg-light" style="border: 1px solid #dee2e6;font-weight:600;">Total :</th>
                        <th class="bg-light" style="border: 1px solid #dee2e6;font-weight:600;">Rp.<?php echo ribuan($checkdb['totalbeli']) ?></th>
                    </tr>
                    <tr>
                        <th class="d-none d-sm-block d-md-block border-0 bg-white"></th>
                        <th class="border-0 bg-white"></th>
                        <th class="border-0 bg-white"></th>
                        <th class="text-right bg-light" style="border: 1px solid #dee2e6;font-weight:600;">Bayar :</th>
                        <th class="bg-light" style="border: 1px solid #dee2e6;font-weight:600;">Rp.<?php echo ribuan($checkdb['pembayaran']) ?></th>
                    </tr>
                    <tr>
                        <th class="d-none d-sm-block d-md-block border-0 bg-white"></th>
                        <th class="border-0 bg-white"></th>
                        <th class="border-0 bg-white"></th>
                        <th class="text-right bg-light" style="border: 1px solid #dee2e6;font-weight:600;">Kembali :</th>
                        <th class="bg-light" style="border: 1px solid #dee2e6;font-weight:600;">Rp.<?php echo ribuan($checkdb['kembalian']) ?></th>
                    </tr>
                </table>
                <p class="small mb-0" style="font-weight:600;">Catatan :</p>
                <p class="small text-muted"><?php echo $checkdb['catatan'] ?></p>
<?php include 'template/footer.php';?>