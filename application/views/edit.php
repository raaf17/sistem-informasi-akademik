<div class="content-wrapper">
  <section class="content">
    <?php foreach ($mahasiswa as $mhs) { ?>
      <form action="<?php echo base_url() . 'mahasiswa/update'; ?>" method="post">
        <div class="form-group">
          <label for="">Nama Mahasiswa</label>
          <input type="hidden" name="id" class="form-control" value="<?php echo $mhs['id'] ?>">
          <input type="text" name="nama" class="form-control" value="<?php echo $mhs['nama'] ?>">
        </div>
        <div class="form-group">
          <label for="">NIM</label>
          <input type="number" name="nim" class="form-control" value="<?php echo $mhs['nim'] ?>">
        </div>
        <div class="form-group">
          <label for="">Tanggal Lahir</label>
          <input type="date" name="tgl_lahir" class="form-control" value="<?php echo $mhs['tgl_lahir'] ?>">
        </div>
        <div class="form-group">
          <label for="">Jurusan</label>
          <select class="form-control" name="jurusan" id="" value="<?php echo $mhs['jurusan'] ?>">
            <option value="Sistem Informasi">Sistem Informasi</option>
            <option value="Teknik Informatika">Teknik Informatika</option>
            <option value="Teknik Komputer">Teknik Komputer</option>
            <option value="Teknologi Informasi">Teknologi Informasi</option>
          </select>
        </div>
        <div class="form-group">
          <label for="">Alamat</label>
          <input type="text" name="alamat" class="form-control" value="<?php echo $mhs['alamat'] ?>">
        </div>
        <div class="form-group">
          <label for="">Email</label>
          <input type="email" name="email" class="form-control" value="<?php echo $mhs['email'] ?>">
        </div>
        <div class="form-group">
          <label for="">No. Telepon</label>
          <input type="text" name="no_telp" class="form-control" value="<?php echo $mhs['no_telp'] ?>">
        </div>

        <button type="reset" class="btn btn-danger">Reset</button>
        <button type="submit" class="btn btn-primary">Simpan</button>
      </form>
    <?php } ?>
  </section>
</div>