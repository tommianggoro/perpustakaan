<div class="nav navbar-nav navbar-right">
    <form class="navbar-form navbar-left" role="search" action="<?php echo site_url('barang/cari');?>" method="post">
        <div class="form-group">
            <label>Cari Kode Barang</label>
            <input type="text" class="form-control" placeholder="Search" name="cari" value="<?php echo isset($cari) ? $cari : '';?>">
        </div>
        <button type="submit" class="btn btn-default"><i class="glyphicon glyphicon-search"></i> Cari</button>
    </form>
</div>
<a href="<?php echo site_url('barang/tambah');?>" class="btn btn-primary"><i class="glyphicon glyphicon-plus"></i> Tambah</a>
<hr>
<?php echo $message;?>
<Table class="table table-striped">
    <thead>
        <tr>
            <td>No.</td>
            <td>Kode Barang</td>
            <td>Jenis</td>
            <td>Merk</td>
            <td>Type</td>
            <td>Jumlah</td>
            <td>Dibuat</td>
            <td colspan="2"></td>
        </tr>
    </thead>
    <?php $no=0; foreach($barang as $row ): $no++;?>
    <tr>
        <td><?php echo $no;?></td>
        <td><?php echo $row->kode_barang;?></td>
        <td><?php echo $row->jenis;?></td>
        <td><?php echo $row->merk;?></td>
        <td><?php echo $row->nama;?></td>
        <td><?php echo $row->jumlah;?></td>
        <td><?php echo date('d-m-Y', $row->dibuat);?></td>
        <td><a href="<?php echo site_url('barang/edit/'.$row->kode_barang);?>"><i class="glyphicon glyphicon-edit"></i></a></td>
        <td><a href="#" class="hapus" kode="<?php echo $row->kode_barang;?>"><i class="glyphicon glyphicon-trash"></i></a></td>
    </tr>
    <?php endforeach;?>
</Table>
<?php echo $pagination;?>

<script>
    $(function(){
        $(".hapus").click(function(){
            var kode=$(this).attr("kode");
            
            $("#idhapus").val(kode);
            $("#myModal").modal("show");
        });
        
        $("#konfirmasi").click(function(){
            var kode=$("#idhapus").val();
            
            $.ajax({
                url:"<?php echo site_url('barang/hapus');?>",
                type:"POST",
                data:"kode="+kode,
                cache:false,
                success:function(html){
                    location.href="<?php echo site_url('barang/index/delete_success');?>";
                }
            });
        });
    });
    
</script>