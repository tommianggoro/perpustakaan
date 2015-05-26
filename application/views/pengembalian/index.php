<script>
    $(function(){
        $("#no").on('keypress change keyup',function(){
            var keycode = (event.keyCode ? event.keyCode : event.which);
            if(keycode == '13'){
                var no = $(this).val();
                $.ajax({
                    url:"<?php echo site_url('pengembalian/cariTransaksi');?>",
                    type:"POST",
                    dataType:"JSON",
                    data:"no="+no,
                    cache:false,
                    dataType:"JSON",
                    success:function(msg){
                        if (msg.code==500) {
                            alert("data tidak ditemukan");
                        }else{
                            $("#id_cabang").val(msg.result['id_cabang']);
                            $("#pinjam").val(msg.result['tanggal_pinjam']);
                            $("#nama").val(msg.result['nama']);
                            
                            $("#tampil").load("<?php echo site_url('pengembalian/tampil');?>","no="+no);    
                        }
                    }
                });
            }
        });

        
        
        /**
        $("#nominal").attr("disabled",true);
        $("#denda").attr("disabled",true);
        $("#denda").click(function(){
            var denda=$("#denda").val();
            if (denda=="Y") {
                $("#nominal").attr("disabled",false);
                $("#nominal").focus();
            }else{
                $("#nominal").attr("disabled",true);
            }
        });
        **/
        $("#simpan").click(function(){
            var no=$("#no").val();
            var id_cabang=$("#id_cabang").val();
            
            
            if (no == "" || id_cabang == "") {
                alert("Pilih ID Transaksi");
                $("#no").focus();
                return false;
            }else{
                $.ajax({
                    url:"<?php echo site_url('pengembalian/simpan');?>",
                    type:"POST",
                    dataType:"JSON",
                    data:"no="+no,
                    cache:false,
                    success:function(res){
                        alert("Data Berhasil disimpan");
                        location.reload();
                    }
                })
            }
        })
        
        $("#cari").click(function(){
            $("#myModal2").modal("show");
        })
        
        $("#carinis").keyup(function(){
            var nis=$("#carinis").val();
            
            $.ajax({
                url:"<?php echo site_url('pengembalian/cari_by_kode');?>",
                type:"POST",
                data:"nis="+nis,
                cache:false,
                success:function(html){
                    $("#tampilnis").html(html);
                }
            })
        })
        
        
        $(".tambahkan").live("click",function(){
            var no=$(this).attr("no");
            
            $("#no").val(no);
            $("#myModal2").modal("hide");
            $("#no").focus();
        })
    })
</script>


<div class="panel panel-default">
    <div class="panel-heading">
        <?php echo $title;?>
    </div>
    <div class="panel-body">
        <form class="form-horizontal" action="" method="post">
            <div class="col-md-6">
                <div class="form-group">
                    <label class="col-lg-4 control-label">No. Transaksi</label>
                    <div class="col-lg-5">
                        <input type="text" name="no" id="no" class="form-control">
                    </div>
                    
                    <div class="col-lg-2">
                        <a href="#" class="btn btn-primary" id="cari"><i class="glyphicon glyphicon-search"></i></a>
                    </div>
                </div>
                
                <div class="form-group">
                    <label class="col-lg-4 control-label">Tgl. Pinjam</label>
                    <div class="col-lg-7">
                        <input type="text" name="pinjam" id="pinjam" class="form-control" readonly="readonly">
                    </div>
                </div>
                <!--
                <div class="form-group">
                    <label class="col-lg-4 control-label">Tgl. Kembali</label>
                    <div class="col-lg-7">
                        <input type="text" name="kembali" id="kembali" class="form-control" readonly="readonly">
                    </div>
                </div>
                -->
            </div>
            
            <div class="col-md-6">
                <div class="form-group">
                    <label class="col-lg-4 control-label">Kode Cabang</label>
                    <div class="col-lg-7">
                        <input type="text" name="id_cabang" id="id_cabang" class="form-control" readonly="readonly">
                    </div>
                </div>
                
                <div class="form-group">
                    <label class="col-lg-4 control-label">Nama</label>
                    <div class="col-lg-7">
                        <input type="text" name="nama" id="nama" class="form-control" readonly="readonly">
                    </div>
                </div>
            </div>
        </form>
    
    </div>
    
    <div id="tampil"></div>
    
    <div class="panel-footer">
        <button id="simpan" class="btn btn-primary"><i class="glyphicon glyphicon-saved"></i> Simpan</button>
    </div>
</div>



 <!-- Modal -->
<div class="modal fade" id="myModal2" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title">Transaksi Pengembalian</h4>
      </div>
      <div class="modal-body">
        <div class="form-horizontal">
            <div class="form-group">
                <label class="col-lg-5">Cari Kode Cabang Peminjam</label>
                <div class="col-lg-5">
                    <input type="text" id="carinis" class="form-control">
                </div>
            </div>
        </div>
        
        <div id="tampilnis"></div>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->