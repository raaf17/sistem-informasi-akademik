<div class="content-wrapper">
  <section class="content">
    <h4><strong>DETAIL DATA MAHASISWA</strong></h4>

    <table class="table">
      <tr>
        <th>Nama Lengkap</th>
        <td><?php echo $detail->nama;?></td>
      </tr>
      <tr>
        <th>NIM</th>
        <td><?php echo $detail->nim;?></td>
      </tr>
      <tr>
        <th>Tanggal Lahir</th>
        <td><?php echo $detail->tgl_lahir;?></td>
      </tr>
      <tr>
        <th>Jurusan</th>
        <td><?php echo $detail->jurusan;?></td>
      </tr>
      <tr>
        <th>Alamat</th>
        <td><?php echo $detail->alamat;?></td>
      </tr>
      <tr>
        <th>Email</th>
        <td><?php echo $detail->email;?></td>
      </tr>
      <tr>
        <th>No. Telepon</th>
        <td><?php echo $detail->no_telp;?></td>
      </tr>
      <tr>
        <td>
          <img src="<?php echo base_url(); ?>assets/foto/<?php echo $detail->foto; ?>" width="90" height="110">
        </td>
        <td></td>
      </tr>
    </table>
    <a href="<?php  echo base_url('mahasiswa/index') ?>" class="btn btn-primary">Kembali</a>
  </section>
</div>