<table class="table table-striped">
    <thead>
        <tr>
            <td>Kode Barang</td>
            <td>Jenis Barang</td>
            <td>Merk Barang</td>
        </tr>
    </thead>
    <?php foreach($barang as $row):?>
    <tr>
        <td><?php echo $row->kode_barang;?></td>
        <td><?php echo $row->jenis;?></td>
        <td><?php echo $row->merk;?></td>
    </tr>
    <?php endforeach;?>
</table>