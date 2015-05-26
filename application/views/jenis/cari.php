<div class="nav navbar-nav navbar-right">
    <form class="navbar-form navbar-left" role="search" action="<?php echo site_url('jenis/cari');?>" method="post">
        <div class="form-group">
            <label>Cari Jenis</label>
            <input type="text" class="form-control" placeholder="Search" name="cari" value="<?php echo isset($cari) ? $cari : '';?>">
        </div>
        <button type="submit" class="btn btn-default"><i class="glyphicon glyphicon-search"></i> Cari</button>
    </form>
</div>
<a href="<?php echo site_url('jenis/tambah');?>" class="btn btn-primary"><i class="glyphicon glyphicon-plus"></i> Tambah</a>
<hr>
<?php echo $message;?>
<Table class="table table-striped">
    <thead>
        <tr>
            <td>ID.</td>
            <td>Nama</td>
            <td>Dibuat</td>
            <td colspan="2"></td>
        </tr>
    </thead>
    <?php foreach($jenis as $row ):?>
    <tr>
        <td><?php echo $row->id;?></td>
        <td><?php echo $row->nama;?></td>
        <td><?php echo date('d-m-Y', $row->dibuat);?></td>
        <td><a href="<?php echo site_url('jenis/edit/'.$row->id);?>"><i class="glyphicon glyphicon-edit"></i></a></td>
        <td><a href="#" class="hapus" kode="<?php echo $row->id;?>"><i class="glyphicon glyphicon-trash"></i></a></td>
    </tr>
    <?php endforeach;?>
</Table>

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
                url:"<?php echo site_url('jenis/hapus');?>",
                type:"POST",
                data:"kode="+kode,
                cache:false,
                success:function(html){
                    location.href="<?php echo site_url('jenis/index/delete_success');?>";
                }
            });
        });
    });
    
</script>