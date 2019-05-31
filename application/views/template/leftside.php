  <!-- Left side column. contains the logo and sidebar -->
  <aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
      <!-- Sidebar user panel -->

      <!-- search form -->
      <!-- /.search form -->

      <!-- sidebar menu: : style can be found in sidebar.less -->
      <ul class="sidebar-menu" data-widget="tree">
        <li class="header">MENU UTAMA
        </li>
       <li>
          <a href="<?php echo base_url() .'dashboard';?>">
            <i class="fa fa-dashboard"></i> <span>Dashboard</span>
          </a>
        </li>
        <li class="treeview">
          <a href="#">
            <i class="fa fa-gear"></i>
            <span>Master</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">           
           <li class="treeview">
              <a href="#"><i class="fa fa-circle-o"></i> Kendaraan
                <span class="pull-right-container">
                  <i class="fa fa-angle-left pull-right"></i>
                </span>
              </a>
              <ul class="treeview-menu">
                  <li><a href="<?php echo base_url() .'master/merek';?>"><i class="fa fa-circle-o"></i> Merek</a></li>
                  <li><a href="<?php echo base_url() .'master/tipe';?>"><i class="fa fa-circle-o"></i> Tipe</a></li>
                  <li><a href="<?php echo base_url() .'master/warna';?>"><i class="fa fa-circle-o"></i> Warna</a></li>
               </ul>
            </li>
            <li><a href="<?php echo base_url() .'master/jasaservice';?>"><i class="fa fa-circle-o"></i> Jasa Service</a></li>
            <li><a href="<?php echo base_url() .'master/customer';?>"><i class="fa fa-circle-o"></i> Data Customer</a></li>          
            <li><a href="<?php echo base_url() .'master/salesman';?>"><i class="fa fa-circle-o"></i> Data Salesman</a></li>
            <li><a href="<?php echo base_url() .'master/leasing';?>"><i class="fa fa-circle-o"></i> Data Leasing (Finco)</a></li>
            <li><a href="<?php echo base_url() .'master/stokunit';?>"><i class="fa fa-circle-o"></i> Stok Unit</a></li>
         </ul>
        </li>
        <li class="treeview">
          <a href="#">
              <i class="fa fa-tasks"></i>
              <span>Transaksi</span>
              <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
              </span>
          </a>
          <ul class="treeview-menu">  
                  <li><a href="<?php echo base_url() .'transaksi/pembelian';?>"><i class="fa fa-circle-o"></i> Pembelian Kendaraan</a></li>
                  <li><a href="<?php echo base_url() .'transaksi/servicekendaraan';?>"><i class="fa fa-circle-o"></i> Service Kendaraan</a></li>
                  <li><a href="<?php echo base_url() .'transaksi/spk';?>"><i class="fa fa-circle-o"></i> Surat Pesanan Kendaraan (SPK)</a></li>
                  <li><a href="<?php echo base_url() .'transaksi/salesorder';?>"><i class="fa fa-circle-o"></i> Sales Order</a></li>
                  <li><a href="<?php echo base_url() .'transaksi/approvalso';?>"><i class="fa fa-circle-o"></i> Approval Sales Order</a></li>
                  <li><a href="<?php echo base_url() .'transaksi/suratjalan';?>"><i class="fa fa-circle-o"></i> Surat Jalan</a></li>
                  <li><a href="<?php echo base_url() .'transaksi/pembayaran';?>"><i class="fa fa-circle-o"></i> Pembayaran</a></li>
          </ul>
        </li>
        <li class="treeview">
          <a href="#">
              <i class="fa fa-file"></i>
              <span>Laporan</span>
              <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
              </span>
          </a>
          <ul class="treeview-menu">  
                  <li><a href="<?php echo base_url() .'laporan/lapstokgudang';?>"><i class="fa fa-circle-o"></i> Stok Gudang</a></li>
          </ul>
        </li>

      </ul>
    </section>
    <!-- /.sidebar -->
  </aside>
