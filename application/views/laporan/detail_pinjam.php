<legend>Detail Peminjaman</legend>
<div class="col-md-6">
    <div class="form-horizontal">
        <div class="form-group">
            <label class="col-lg-5">ID Transaksi</label>
            <div class="col-lg-5">
                : <?php echo $pinjam['id_transaksi'];?>
            </div>
        </div>
        
        <div class="form-group">
            <label class="col-lg-5">Tanggal Pinjam</label>
            <div class="col-lg-5">
                : <?php echo date('d-m-Y', $pinjam['tanggal_pinjam']);?>
            </div>
        </div>

        <div class="form-group">
            <label class="col-lg-5">Tanggal Kembali</label>
            <div class="col-lg-5">
                : <?php echo $pinjam['tanggal_pinjam'] > 0 ? date('d-m-Y', $pinjam['tanggal_pinjam']) : 'Belom Balik Gan';?>
            </div>
        </div>
    </div>
</div>

<table class="table table-striped">
    <thead>
        <tr>
            <td>Kode Barang</td>
            <td>Jenis Barang</td>
            <td>Merk Barang</td>
        </tr>
    </thead>
    <?php foreach($detail as $row):?>
    <tr>
        <td><?php echo $row->kode_barang;?></td>
        <td><?php echo $row->jenis;?></td>
        <td><?php echo $row->merk;?></td>
    </tr>
    <?php endforeach;?>
</table>