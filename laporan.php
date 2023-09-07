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
<div class="row">
<div class="col-6 col-sm-6 col-md-6 col-lg-3 mb-3 pr-0">
            <div class="card-body bg-white py-2 px-1 border-laporan">
                <div class="row mx-auto align-items-center">
                <div class="col-auto m-pr-1">
                    <div class="bg-icon">
                        <i class="fa fa-user"></i>
                    </div>
                </div>
                <div class="col-auto pl-0 pt-2">
                    <div class="text-muted" style="font-size:11px;">
                        Pelanggan
                    </div>
                    <h4 class="1"><?php 
                    $itungpelanggan = mysqli_query($conn,"SELECT COUNT(idpelanggan) as jumlahpelanggan FROM pelanggan");
                    $cekrow1 = mysqli_num_rows($itungpelanggan);
                    $itungpelanggan1 = mysqli_fetch_assoc($itungpelanggan);
                    $itungpelanggan2 = $itungpelanggan1['jumlahpelanggan'];
                    if($cekrow1 > 0){
                        echo  $itungpelanggan2;
                        } ?></h4>
                </div>
                </div>
            </div>
        </div>

        <div class="col-6 col-sm-6 col-md-6 col-lg-3 mb-3 m-pr-0">
            <div class="card-body bg-white py-2 px-1 border-laporan">
                <div class="row mx-auto align-items-center">
                <div class="col-auto m-pr-1">
                    <div class="bg-icon">
                        <i class="fa fa-shopping-cart"></i>
                    </div>
                </div>
                <div class="col-auto pl-0 pt-2">
                    <div class="text-muted" style="font-size:11px;">
                        Terjual
                    </div>
                    <h4 class="1"><?php $itungpeterjual = mysqli_query($conn,"SELECT SUM(quantity) as jumlahterjual FROM tb_nota");
                    $cekrow = mysqli_num_rows($itungpeterjual);
                    $itungpeterjual1 = mysqli_fetch_assoc($itungpeterjual);
                    $itungpeterjual2 = $itungpeterjual1['jumlahterjual'];
                    if($cekrow > 0){
                        echo $itungpeterjual2;
                        } ?></h4>
                </div>
                </div>
            </div>
        </div>

        <div class="col-6 col-sm-6 col-md-6 col-lg-3 mb-3 pr-0">
            <div class="card-body bg-white py-2 px-1 border-laporan">
                <div class="row mx-auto align-items-center">
                <div class="col-auto m-pr-1">
                    <div class="bg-icon">
                        <i class="fa fa-dollar-sign"></i>
                    </div>
                </div>
                <div class="col-auto pl-0 pt-2">
                    <div class="text-muted" style="font-size:11px;">
                        Pendapatan
                    </div>
                    <h4 class="1">Rp.<?php 
                    $data_produk=mysqli_query($conn,"SELECT * FROM tb_nota t, produk p
                    WHERE p.idproduk=t.idproduk ORDER BY idnota ASC");
                    $subtotaldiskon = 0;
                    $x = mysqli_num_rows($data_produk);
                    if($x>0){
                    while($b=mysqli_fetch_array($data_produk)){
                        $totalharga += $b['harga_jual'] * $b['quantity'];
                        $totaldiskon += $b['harga_modal'] * $b['quantity'];
                        $subtotaldiskon = $totalharga - $totaldiskon;
                    }
                } 
                echo ribuan($subtotaldiskon)?>
                </h4>
                </div>
                </div>
            </div>
        </div>

        <div class="col-6 col-sm-6 col-md-6 col-lg-3 mb-3">
            <div class="card-body bg-white py-2 px-1 border-laporan">
                <div class="row mx-auto align-items-center">
                <div class="col-auto m-pr-1">
                    <div class="bg-icon">
                        <i class="fa fa-file-invoice-dollar"></i>
                    </div>
                </div>
                <div class="col-auto pl-0 pt-2">
                    <div class="text-muted" style="font-size:11px;">
                        Total
                    </div>
                    <h4 class="1">Rp.<?php 
                    $itungtotal = mysqli_query($conn,"SELECT SUM(totalbeli) as jumlahtotal FROM laporan");
                    $cekrow3 = mysqli_num_rows($itungtotal);
                    $itungtotal1 = mysqli_fetch_assoc($itungtotal);
                    $itungtotal2 = $itungtotal1['jumlahtotal'];
                    if($cekrow3 > 0){
                        echo ribuan($itungtotal2);
                        } ?></h4>
                </div>
                </div>
            </div>
        </div>

</div><!-- end row -->


<div class="card">
    <div class="card-header">
        <div class="card-tittle">
            <i class="fa fa-table me-2"></i> Data Laporan 
        </div>
    </div>
        <div class="card-body">
            <table class="table table-striped table-sm table-bordered dt-responsive nowrap" id="table" width="100%">
                        <thead>
                        <tr>
                            <th>No.</th>
                            <th>No. Nota</th>
                            <th>Pelanggan</th>
                            <th>Qty</th>
                            <th>Catatan</th>
                            <th>SubTotal</th>
                            <th>Pembayaran</th>
                            <th>Kembalian</th>
                            <th>Tanggal</th>
                            <th>Opli</th>
                        </tr>
                        </thead>
                        <tbody>
                            <?php
                                $no=1;
                                $data_produk=mysqli_query($conn,"SELECT * FROM laporan l, pelanggan e
                                WHERE  e.idpelanggan=l.idpelanggan ORDER BY idlaporan ASC");
                                while($d=mysqli_fetch_array($data_produk)){
                                    $idlaporan= $d['idlaporan'];
                                    $nota= $d['no_nota'];
                                    ?>
                                    
                                    <tr>
                                        <td><?php echo $no++ ?></td>
                                        <td><?php echo $d['no_nota'] ?></td>
                                        <td><?php echo $d['nama_pelanggan'] ?></td>
                                        <td><?php 
                                            $itungtrans = mysqli_query($conn,"SELECT SUM(quantity) as jumlahtrans
                                             FROM tb_nota where no_nota='$nota'");
                                            $itungtrans2 = mysqli_fetch_assoc($itungtrans);
                                            $itungtrans3 = $itungtrans2['jumlahtrans'];
                                            echo $itungtrans3;
                                        ?></td>
                                         <td class="catatan"><?php echo $d['catatan'] ?></td>
                                         <td>Rp.<?php echo ribuan($d['totalbeli']) ?></td>
                                         <td>Rp.<?php echo ribuan($d['pembayaran']) ?></td>
                                         <td>Rp.<?php echo ribuan($d['kembalian']) ?></td>
                                        <td><?php echo $d['tgl_sub'] ?></td>
                                        <td>
                                        <a class="btn btn-primary btn-xs" href="detail.php?invoice=<?php echo $nota ?>">
                                            <i class="fa fa-eye fa-xs mr-1"></i>View</a>
                                            <a class="btn btn-danger btn-xs" href="?hapus=<?php echo $nota ?>" 
                                            onclick="javascript:return confirm('Hapus Data laporan - <?php echo $d['no_nota'] ?> ?');">
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
		$nota = $_GET['hapus'];
		$hapus_data = mysqli_query($conn, "DELETE FROM laporan WHERE no_nota='$nota'");
        $hapus_data1 = mysqli_query($conn, "DELETE FROM tb_nota WHERE no_nota='$nota'");
        if($hapus_data&&$hapus_data1){
            echo '<script>alert("Berhasi Hapus data laporan");window.location="laporan.php"</script>';
        } else {
            echo '<script>alert("gagal Hapus data laporan");history.go(-1);</script>';
        }
	};
    ?>
<?php include 'template/footer.php';?>
