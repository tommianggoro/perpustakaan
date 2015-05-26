<script>
    $(function(){
        function loadData(args) {
            $("#tampil").load("<?php echo site_url('peminjaman/tampil');?>");
        }
        loadData();
        function kosong(args) {
            //code
            $("#kode").val('');
            $("#jenis").val('');
            $("#type").val('');
            $("#merk").val('');
        }
        
        $("#kodeCabang").change(function(){
            $('#nama').val('');
            $('#nama').val($(this).find('option:selected').attr('name'));
            /**
            var nis = $("#nis").val();
            $.ajax({
                url:"<?php echo site_url('peminjaman/cariCabang');?>",
                type:"POST",
                data:"nis="+nis,
                cache:false,
                success:function(html){
                    $("#nama").val(html);
                }
            });
            **/
        })
        
        $("#kodeCabang").keypress(function(){
            var keycode = (event.keyCode ? event.keyCode : event.which);
            if(keycode == '13'){
                var kode = $("#kodeCabang").val();
                $.ajax({
                    url:"<?php echo site_url('peminjaman/cariBarang');?>",
                    type:"POST",
                    data:"kode="+kode,
                    dataType:'JSON',
                    cache:false,
                    success:function(msg){
                        if(msg.code == 500){
                            alert("Data Tidak Ditemukan");
                            $("#jenis").val('');
                            $("#merk").val('');
                            $("#type").val('');
                        }else{
                            $("#jenis").val(msg.result.jenis);
                            $("#merk").val(msg.result.merk);
                            $("#type").val(msg.result.type);
                            $("#tambah").focus();
                        }
                    }
                });
            }
        });

        $("#kodeCabang").bind('keyup', function(){
            var kode = $(this).val();
            $.ajax({
                url:"<?php echo site_url('peminjaman/cariBarang');?>",
                type:"POST",
                data:"kode="+kode,
                dataType:'JSON',
                cache:false,
                success:function(msg){
                    if(msg.code == 200){
                        $("#jenis").val(msg.result.jenis);
                        $("#merk").val(msg.result.merk);
                        $("#type").val(msg.result.type);
                    }else{
                        $("#jenis").val('');
                        $("#merk").val('');
                        $("#type").val('');
                    }
                }
            });
        });
        
        $("#tambah").click(function(){
            var kode = $("#kode").val();
            var jenis = $("#jenis").val();
            var type = $("#type").val();
            var merk = $("#merk").val();
            
            if (kode == "") {
                alert("Kode Barang Masih Kosong");
                return false;
            }else if (jenis == "") {
                alert("Data tidak ditemukan");
                return false;
            }else{
                $.ajax({
                    url:"<?php echo site_url('peminjaman/tambah');?>",
                    type:"POST",
                    data:{kode : kode, jenis : jenis, type : type, merk : merk},
                    cache:false,
                    success:function(res){
                        if(res.code == 200){
                            loadData();
                            kosong();
                        }else if(res.code == 502){
                            alert("Stock Barang Habis");
                        }else{
                            alert("Oops.. Something's Wrong.");
                        }
                    }
                })    
            }
            
        });
        
        
        $("#simpan").click(function(){
            var nomer = $("#no").val();
            var pinjam = $("#pinjam").val();
            var kode = $("#kodeCabang").val();
            var jumlah = parseInt($("#jumlahTmp").val(),10);
            var idTemp = $("#idTemp").val();
            if(kode == ""){
                alert("Pilih Cabang");
                return false;
            }else if (jumlah <= 0) {
                alert("Tentukan jumlah barang.");
                return false;
            }else{
                $.ajax({
                    url:"<?php echo site_url('peminjaman/sukses');?>",
                    type:"POST",
                    data: {nomer : nomer, pinjam : pinjam, idCabang : kode, jumlah : jumlah, idTemp : idTemp},
                    cache:false,
                    success:function(resp){
                        console.log(resp);
                        /**alert("Transaksi Peminjaman berhasil");
                        location.reload();
                        **/
                    }
                })
            }
            
        });
        
        $(".hapus").live("click",function(){
            var kode = $(this).attr("kode");
            $.ajax({
                url:"<?php echo site_url('peminjaman/hapus');?>",
                type:"POST",
                data:"kode="+kode,
                cache:false,
                success:function(html){
                    loadData();
                }
            });
            return false;
        });
        
        $("#cari").click(function(){
            $("#myModal2").modal("show");
        })
        
        $("#caribuku").keyup(function(){
            var caribuku=$("#caribuku").val();
            
            $.ajax({
                url:"<?php echo site_url('peminjaman/pencarianbuku');?>",
                type:"POST",
                data:"caribuku="+caribuku,
                cache:false,
                success:function(html){
                    $("#tampilbuku").html(html);
                }
            })
        })
        
        /**
        $(".tambah").live("click",function(){
            var kode=$(this).attr("kode");
            var jenis=$(this).attr("jenis");
            var pengarang=$(this).attr("pengarang");
            
            $("#kode").val(kode);
            $("#jenis").val(jenis);
            $("#pengarang").val(pengarang);
            
            $("#myModal2").modal("hide");
        });
        **/
        
    });
</script>

<legend><?php echo $title;?></legend>
<div class="panel panel-default">
    <div class="panel-body">
        <form class="form-horizontal" action="<?php echo site_url('peminjaman/simpan');?>" method="post">
            <div class="col-md-6">
                <div class="form-group">
                    <label class="col-lg-4 control-label">No. Transaksi</label>
                    <div class="col-lg-7">
                        <input type="text" id="no" name="no" class="form-control" value="<?php echo $noauto;?>" readonly="readonly">
                    </div>
                </div>
                
                <div class="form-group">
                    <label class="col-lg-4 control-label">Tgl Pinjam</label>
                    <div class="col-lg-7">
                        <input type="text" id="pinjam" name="pinjam" class="form-control" value="<?php echo $tanggalpinjam;?>" readonly="readonly">
                    </div>
                </div>
                
                <!--
                <div class="form-group">
                    <label class="col-lg-4 control-label">Tgl Kembali</label>
                    <div class="col-lg-7">
                        <input type="text" id="kembali" name="kembali" class="form-control" value="<?php echo $tanggalkembali;?>" readonly="readonly">
                    </div>
                </div>
                -->
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label class="col-lg-4 control-label">Kode Cabang</label>
                    <div class="col-lg-7">
                        <select name="kode" class="form-control" id="kodeCabang">
                            <option></option>
                            <?php foreach($anggota as $anggota):?>
                                <option value="<?php echo $anggota->kode;?>" name="<?php echo $anggota->nama; ?>"><?php echo $anggota->kode;?></option>
                            <?php endforeach;?>
                        </select>
                    </div>
                </div>
                
                <div class="form-group">
                    <label class="col-lg-4 control-label">Nama Cabang</label>
                    <div class="col-lg-7">
                        <input type="text" name="nama" id="nama" class="form-control" readonly="readOnly">
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>

<div class="panel panel-success">
    <div class="panel-heading">
        Data Barang
    </div>
    
    <div class="panel-body">
        <div class="form-inline">
            <div class="form-group">
                <label>Kode Barang</label>
                <input type="text" class="form-control" placeholder="Kode Barang" id="kode">
            </div>
            <div class="form-group">
                <label class="sr-only">Nama Barang</label>
                <input type="text" class="form-control" placeholder="Jenis Barang" id="jenis" readonly="readonly">
                <input type="hidden" class="form-control" placeholder="Merk Barang" id="merk" readonly="readonly">
                <input type="hidden" class="form-control" placeholder="Type Barang" id="type" readonly="readonly">
            </div>
            <div class="form-group">
                <button id="tambah" class="btn btn-primary"><i class="glyphicon glyphicon-plus"></i></button>
            </div>
            <!--
            <div class="form-group">
                <button id="cari" class="btn btn-default"><i class="glyphicon glyphicon-search"></i></button>
            </div>
            -->
        </div>
    </div>
    
    <div id="tampil"></div>
    
    <div class="panel-footer">
        <button id="simpan" class="btn btn-primary"><i class="glyphicon glyphicon-hdd"></i> Simpan</button>
    </div>
</div>




 <!-- Modal -->
<div class="modal fade" id="myModal2" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title">Cari Barang</h4>
      </div>
      <div class="modal-body">
        <div class="form-horizontal">
            <label class="col-lg-5 control-label">Cari Nama Barang</label>
            <div class="col-lg-5">
                <input type="text" name="caribuku" id="caribuku" class="form-control">
            </div>
        </div>
        
        <div id="tampilbuku"></div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary" id="konfirmasi">Hapus</button>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
