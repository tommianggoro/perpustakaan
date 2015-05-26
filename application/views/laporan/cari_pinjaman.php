<table class="table table-striped">
    <thead>
        <tr>
            <td>No.</td>
            <td>ID Transaksi</td>
            <td>Kode Cabang</td>
            <td>Nama Cabang</td>
            <td>Tanggal Pinjam</td>
            <td>Tanggal Kembali</td>
        </tr>
    </thead>
    <?php $no=0; foreach($lap as $row): $no++;?>
    <tr>
        <td><?php echo $no;?></td>
        <td><a href="<?php echo site_url('laporan/detail_pinjam/'.$row->id_transaksi);?>"><?php echo $row->id_transaksi;?></a></td>
        <td><?php echo $row->id_cabang;?></td>
        <td><?php echo $row->nama;?></td>
        <td><?php echo date('d-m-Y',$row->tanggal_pinjam);?></td>
        <td><?php echo $row->tanggal_kembali > 0 ? date('d-m-Y',$row->tanggal_kembali) : 'Belum Kembali';?></td>
    </tr>
    <?php endforeach;?>
</table>