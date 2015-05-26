<legend><?php echo $title;?></legend>
<?php echo validation_errors();?>
<?php echo $message;?>

<form class="form-horizontal" action="" method="post" enctype="multipart/form-data">
    <div class="form-group">
        <label class="col-lg-2 control-label">Kode</label>
        <div class="col-lg-5">
            <input type="text" name="kode" class="form-control" value="<?php echo $cabang['kode'];?>" readonly="readonly">
        </div>
    </div>
    <div class="form-group">
        <label class="col-lg-2 control-label">Nama</label>
        <div class="col-lg-5">
            <input type="text" name="nama" class="form-control" value="<?php echo $cabang['nama'];?>" required>
        </div>
    </div>
    <div class="form-group">
        <label class="col-lg-2 control-label">Uker</label>
        <div class="col-lg-5">
            <input type="text" name="uker" class="form-control" value="<?php echo $cabang['uker'];?>" required>
        </div>
    </div>
    <div class="form-group">
        <label class="col-lg-2 control-label">PIC</label>
        <div class="col-lg-5">
            <input type="text" name="pic" class="form-control" value="<?php echo $cabang['pic'];?>" required>
        </div>
    </div>
    <div class="form-group well">
        <button class="btn btn-primary"><i class="glyphicon glyphicon-hdd"></i> Update</button>
        <a href="<?php echo site_url('cabang');?>" class="btn btn-default">Kembali</a>
    </div>
</form>