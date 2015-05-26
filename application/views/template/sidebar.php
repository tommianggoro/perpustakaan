<div class="panel-group" id="accordion">
    <div class="panel panel-default">
        <div class="panel-heading">
            <h4 class="panel-title">
            <a data-toggle="collapse" data-parent="#accordion" href="#collapseOne"><span class="glyphicon glyphicon-folder-close">
            </span> Master</a>
            </h4>
        </div>
        <div id="collapseOne" class="panel-collapse collapse <?php echo in_array($this->uri->segment(1),array('cabang', 'barang', 'petugas', 'jenis')) ? 'in' : ''; ?>">
            <div class="panel-body">
                <table class="table">
                    <tr>
                        <td>
                            <span class="glyphicon glyphicon-pencil text-primary"></span> <a href="<?php echo site_url('cabang');?>">Cabang</a>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <span class="glyphicon glyphicon-book text-success"></span> <a href="<?php echo site_url('barang');?>">Barang</a>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <span class="glyphicon glyphicon-pencil text-success"></span> <a href="<?php echo site_url('jenis');?>">Jenis</a>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <span class="glyphicon glyphicon-user"></span> <a href="<?php echo site_url('petugas');?>">Petugas</a>
                        </td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
    <div class="panel panel-default">
        <div class="panel-heading">
            <h4 class="panel-title">
            <a data-toggle="collapse" data-parent="#accordion" href="#collapseTwo"><span class="glyphicon glyphicon-th">
            </span> Transaksi</a>
            </h4>
        </div>
        <div id="collapseTwo" class="panel-collapse collapse <?php echo in_array($this->uri->segment(1),array('peminjaman', 'pengembalian')) ? 'in' : ''; ?>">
            <div class="panel-body">
                <table class="table">
                    <tr>
                        <td>
                            <span class="glyphicon glyphicon-saved"></span><a href="<?php echo site_url('peminjaman');?>"> Peminjaman</a></span>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <span class="glyphicon glyphicon-save"></span> <a href="<?php echo site_url('pengembalian');?>"> Pengembalian</a>
                        </td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
    <div class="panel panel-default">
        <div class="panel-heading">
            <h4 class="panel-title">
            <a data-toggle="collapse" data-parent="#accordion" href="#collapseFour"><span class="glyphicon glyphicon-file">
            </span> Laporan</a>
            </h4>
        </div>
        <div id="collapseFour" class="panel-collapse collapse <?php echo $this->uri->segment(1) == 'laporan' && in_array($this->uri->segment(2),array('anggota', 'buku', 'peminjaman', 'pengembalian', 'detail_pinjam')) ? 'in' : ''; ?>">
            <div class="panel-body">
                <table class="table">
                    <tr>
                        <td>
                            <span class="glyphicon glyphicon-tasks"></span><a href="<?php echo site_url('laporan/peminjaman');?>"> Data Peminjaman</a>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <span class="glyphicon glyphicon-list-alt"></span><a href="<?php echo site_url('laporan/pengembalian');?>"> Data Pengembalian</a>
                        </td>
                    </tr>
                </table>
            </div>
        </div>
    </div>

    <div class="panel panel-default">
        <div class="panel-heading">
            <h4 class="panel-title">
            <a href="<?php echo site_url('auth/logout');?>"><span class="glyphicon glyphicon-off">
            </span> Logout</a>
            </h4>
        </div>
    </div>
</div>