<div class="mb-3">
            <input type="number" name="id_kategori" value="{{$kategori->id_kategori}}" hidden>
            <label for="nama" class="form-label">Nama Kategori</label>
            <input type="text" name="nama" value="{{$kategori->nama_kategori}}" class="form-control" id="name" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Status</label>
            <select name="status" class="form-select" aria-label="Default select example">
                <option <?php echo $kategori->status == 1? 'selected':''?> value='1'>Aktif</option>
                <option <?php echo $kategori->status == 0? 'selected':''?> value="0">Tidak Aktif</option>
            </select>
        </div>
        <div class="mb-3">
          <label for="gambar" class="form-label">Gambar Kategori</label>
          <input type="file" name="gambar" id="gambar" class="form-control">
        </div>