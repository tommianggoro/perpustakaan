<table class="table table-striped">
    <thead>
        <tr>
            <td>No.</td>
            <td>ID Transaksi</td>
            <td>Tanggal Pengembalian</td>
        </tr>
    </thead>
    <?php $no=0; foreach($lap as $row): $no++;?>
    <tr>
        <td><?php echo $no;?></td>
        <td><a href="<?php echo site_url('laporan/detail_pinjam/'.$row->id_transaksi);?>"><?php echo $row->id_transaksi;?></a></td>
        <td><?php echo date('d-m-Y', $row->tanggal_kembali);?></td>
    </tr>
    <?php endforeach;?>
</table>