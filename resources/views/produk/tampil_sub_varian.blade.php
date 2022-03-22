
                <label><b>{{$produk->label_varian}}</b></label><br>
                <div class="btn-group" role="group">
                    @foreach($produk_varian as $pv)
                    <div class="mr-4">
                        <input required <?php echo $pv->stok == 0? 'disabled' : '' ?> type="radio"  class="btn-check" name="sub_varian_id" value="{{$pv->sub_varian_id}}" id="{{$pv->sub_varian_id}}" autocomplete="off">
                        <label class="btn btn-outline-primary" for="{{$pv->sub_varian_id}}">{{$pv->nama_sub_varian}}</label>
                    </div>
                    @endforeach
                </div>
            