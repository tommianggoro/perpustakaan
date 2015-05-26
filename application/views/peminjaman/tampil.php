<input type="hidden" value="<?php echo $idTemp; ?>" id="idTemp" />
<table class="table table-striped">
    <thead>
        <tr>
            <td>Kode Barang</td>
            <td>Jenis Barang</td>
            <td>Tipe Barang</td>
            <td>Merk Barang</td>
            <td>Jumlah Barang</td>
            <td></td>
        </tr>
    </thead>
    <?php if($tmp): ?>
        <?php foreach($tmp as $tmp):?>
            <tr>
                <td><?php echo $tmp->kode_barang;?></td>
                <td><?php echo $tmp->jenis;?></td>
                <td><?php echo $tmp->nama;?></td>
                <td><?php echo $tmp->merk;?></td>
                <td><input type="number" name="sum" value="<?php echo $tmp->jumlah; ?>" tmp_detail_id="<?php echo $tmp->id; ?>" kode_barang="<?php echo $tmp->kode_barang; ?>"/></td>
                <td><a href="#" class="hapus" kode="<?php echo $tmp->id;?>"><i class="glyphicon glyphicon-trash"></i></a></td>
            </tr>
        <?php endforeach;?>
        <tr>
            <td colspan="2">Total Barang</td>
            <td colspan="2"><input type="text" id="jumlahTmp" readonly="readonly" value="" class="form-control"></td>
        </tr>
    <?php endif; ?>
</table>
<script type="text/javascript">
    sums();

    $('input[name=sum]').on('keyup keydown',function(){
        var idx = $(this).attr('tmp_detail_id');
        var kodeBrg = $(this).attr('kode_barang');
        $.ajax({
            url:"<?php echo site_url('peminjaman/updateTmp');?>",
            type:"POST",
            data:{id : idx, jumlah : $(this).val(), kode_barang : kodeBrg},
            dataType:'JSON',
            cache:false,
            success:function(msg){
                if(msg.code != 200){
                    alert(msg.result);
                }
            }
        });
        sums();
    });

    function sums(){
        var count = 0;
        $('input[name=sum]').each(function(){
            count = count + parseInt($(this).val());
        });
        $('#jumlahTmp').val(parseInt(count));
    }
</script>