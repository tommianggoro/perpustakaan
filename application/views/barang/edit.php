<legend><?php echo $title;?></legend>
<form class="form-horizontal" action="" method="post" enctype="multipart/form-data" />
    <?php echo validation_errors(); echo $message;?>
    <div class="form-group">
        <label class="col-lg-2 control-label">Kode Barang</label>
        <div class="col-lg-5">
            <input type="text" name="kode" class="form-control" value="<?php echo $barang['kode_barang'];?>" readonly="readonly">
        </div>
    </div>
    
    <div class="form-group">
        <label class="col-lg-2 control-label">Type Barang</label>
        <div class="col-lg-5">
            <select name="type" required class="form-control" >
                <option value="">--PILIH--</option>
                <?php if($jenis): ?>
                    <?php foreach ($jenis as $key => $value) : ?>
                    <?php 
                    $sel = "";
                    if($barang["type"] == $value->id):
                        $sel = "selected='selected'";
                    endif;
                    ?>
                    <option value="<?php echo $value->id; ?>" <?php echo $sel; ?> ><?php echo $value->nama; ?></option>
                <?php endforeach; ?>
            <?php endif; ?>
            </select>
        </div>
    </div>
    
    <div class="form-group">
        <label class="col-lg-2 control-label">Merk Barang</label>
        <div class="col-lg-5">
            <input type="text" name="merk" class="form-control" value="<?php echo $barang['merk'];?>">
        </div>
    </div>
    
    <div class="form-group">
        <label class="col-lg-2 control-label">Jenis Barang</label>
        <div class="col-lg-5">
            <input type="text" name="jenis" class="form-control" value="<?php echo $barang['jenis'];?>">
        </div>
    </div>

     <div class="form-group">
        <label class="col-lg-2 control-label">Jumlah Barang</label>
        <div class="col-lg-5">
            <input type="number" name="jumlah" class="form-control" value="<?php echo $barang['jumlah'];?>">
        </div>
    </div>
        
    <div class="form-group well">
        <button class="btn btn-primary"><i class="glyphicon glyphicon-hdd"></i> Simpan</button>
        <a href="<?php echo site_url('barang');?>" class="btn btn-default">Kembali</a>
    </div>
</form>