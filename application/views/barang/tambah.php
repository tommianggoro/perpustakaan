<legend><?php echo $title;?></legend>
<form class="form-horizontal" action="" method="post" enctype="multipart/form-data" />
    <?php echo validation_errors(); echo $message;?>
    <div class="form-group">
        <label class="col-lg-2 control-label">Kode Barang</label>
        <div class="col-lg-5">
            <input type="text" name="kode" class="form-control" value="<?php echo set_value('kode'); ?>">
        </div>
    </div>
    
    <div class="form-group">
        <label class="col-lg-2 control-label">Type Barang</label>
        <div class="col-lg-5">
            <input type="text" name="type" class="form-control" value="<?php echo set_value('type'); ?>">
        </div>
    </div>
    
    <div class="form-group">
        <label class="col-lg-2 control-label">Merk Barang</label>
        <div class="col-lg-5">
            <input type="text" name="merk" class="form-control" value="<?php echo set_value('merk'); ?>">
        </div>
    </div>
    
    <div class="form-group">
        <label class="col-lg-2 control-label">Jenis Barang</label>
        <div class="col-lg-5">
            <input type="text" name="jenis" class="form-control" value="<?php echo set_value('jenis'); ?>">
        </div>
    </div>
    
    <div class="form-group well">
        <button class="btn btn-primary"><i class="glyphicon glyphicon-hdd"></i> Simpan</button>
        <a href="<?php echo site_url('barang');?>" class="btn btn-default">Kembali</a>
    </div>
</form>