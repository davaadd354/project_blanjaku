<div class="mb-3">
          <input type="number" name="id_slider" value="{{$slider->id_slider}}" hidden>
          <label for="judul" class="form-label">Judul Slider</label>
          <input type="text" name="judul" value="{{$slider->judul}}" class="form-control" id="judul" required>
        </div>
        <div class="mb-3">
          <label for="link_slider" class="form-label">Link Promosi Slider</label>
          <input type="text" name="link" value="{{$slider->link}}" class="form-control" id="link_slider" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Status</label>
            <select name="status" class="form-select" aria-label="Default select example">
                <option value='1' <?php echo $slider->status == 1? 'selected':''?>>Aktif</option>
                <option value="0" <?php echo $slider->status == 0? 'selected':''?>>Tidak Aktif</option>
            </select>
        </div>
        <div class="mb-3">
          <label for="gambar" class="form-label">Gambar Slider</label>
          <input type="file" name="gambar" id="gambar" class="form-control">
        </div>