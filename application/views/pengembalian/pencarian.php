<table class="table table-striped">
    <thead>
        <tr>
            <td>No. Transaksi</td>
            <td>Kode Cabang</td>
            <td>Tgl. Peminjaman</td>
            <td></td>
        </tr>
    </thead>
    <?php if($pencarian): ?>
        <?php foreach($pencarian as $row):?>
            <tr>
                <td><?php echo $row->id_transaksi;?></td>
                <td><?php echo $row->id_cabang;?></td>
                <td><?php echo date('d-m-Y',$row->tanggal_pinjam);?></td>
                <td><a href="#" class="tambahkan" no="<?php echo $row->id_transaksi;?>">
                    <i class="glyphicon glyphicon-plus"></i>
                </a></td>
            </tr>
        <?php endforeach;?>
    <?php else: ?>
        <tr>
            <td colspan="4">Data tidak ditemukan.</td>
        </tr>
    <?php endif; ?>
</table>