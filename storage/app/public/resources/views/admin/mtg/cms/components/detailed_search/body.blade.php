<div class="card ">
    <div class="card-header card-header-primary card-header-icon">
        <h5 class="card-title">Page Body</h5>
        <hr>
    </div>
    <div class="card-body ">
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label>Page Title</label>
                    <input type="text" name="detailSearch_title" class="form-control"
                        value="{{$setting['detailSearch_title'] ?? ''}}">
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label>Page Heading</label>
                    <input type="text" name="detailSeacrh_heading" class="form-control"
                        value="{{$setting['detailSeacrh_heading'] ?? ''}}">
                </div>
            </div>
            <div class="col-md-12">
                <div class="form-group">
                    <label>Page Meta Description</label>
                    <textarea rows="7" name="detailSearch_metaData"
                        class="form-control">{{$setting['detailSearch_metaData'] ?? ''}}</textarea>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label>Product Name label</label>
                    <input type="text" name="detailSeacrh_proname" class="form-control"
                        value="{{$setting['detailSeacrh_proname'] ?? ''}}">
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label>Product Name bottom text</label>
                    <input type="text" name="detailSeacrh_proname_btm" class="form-control"
                        value="{{$setting['detailSeacrh_proname_btm'] ?? ''}}">
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label>Search Within label</label>
                    <input type="text" name="detailSeacrh_namewith" class="form-control"
                        value="{{$setting['detailSeacrh_namewith'] ?? ''}}">
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label>Search Within bottom text</label>
                    <input type="text" name="detailSeacrh_namewith_btm" class="form-control"
                        value="{{$setting['detailSeacrh_namewith_btm'] ?? ''}}">
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label>Format label</label>
                    <input type="text" name="detailSeacrh_format" class="form-control"
                        value="{{$setting['detailSeacrh_format'] ?? ''}}">
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label>Format bottom text</label>
                    <input type="text" name="detailSeacrh_format_btm" class="form-control"
                        value="{{$setting['detailSeacrh_format_btm'] ?? ''}}">
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label>Card Colors label</label>
                    <input type="text" name="detailSeacrh_color" class="form-control"
                        value="{{$setting['detailSeacrh_color'] ?? ''}}">
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label>Card Colors bottom text</label>
                    <input type="text" name="detailSeacrh_color_btm" class="form-control"
                        value="{{$setting['detailSeacrh_color_btm'] ?? ''}}">
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label>Foiling Type label</label>
                    <input type="text" name="detailSeacrh_foil" class="form-control"
                        value="{{$setting['detailSeacrh_foil'] ?? ''}}">
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label>Card Type label</label>
                    <input type="text" name="detailSeacrh_card" class="form-control"
                        value="{{$setting['detailSeacrh_card'] ?? ''}}">
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label>Card Type bottom text</label>
                    <input type="text" name="detailSeacrh_card_btm" class="form-control"
                        value="{{$setting['detailSeacrh_card_btm'] ?? ''}}">
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label>Characterstic label</label>
                    <input type="text" name="detailSeacrh_card_btm" class="form-control"
                        value="{{$setting['detailSeacrh_char'] ?? ''}}">
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label>Convert Mana Cost label</label>
                    <input type="text" name="detailSeacrh_mana" class="form-control"
                        value="{{$setting['detailSeacrh_mana'] ?? ''}}">
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label>Convert Mana Cost bottom text</label>
                    <input type="text" name="detailSeacrh_mana_btm" class="form-control"
                        value="{{$setting['detailSeacrh_mana_btm'] ?? ''}}">
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label>Power & Toughness label</label>
                    <input type="text" name="detailSeacrh_power" class="form-control"
                        value="{{$setting['detailSeacrh_power'] ?? ''}}">
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label>Power & Toughness bottom text</label>
                    <input type="text" name="detailSeacrh_power_btm" class="form-control"
                        value="{{$setting['detailSeacrh_power_btm'] ?? ''}}">
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label>Rarity label</label>
                    <input type="text" name="detailSeacrh_rarity" class="form-control"
                        value="{{$setting['detailSeacrh_rarity'] ?? ''}}">
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label>Rarity label bottom text</label>
                    <input type="text" name="detailSeacrh_rarity_btm" class="form-control"
                        value="{{$setting['detailSeacrh_rarity_btm'] ?? ''}}">
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label>Sets Label</label>
                    <input type="text" name="detailSeacrh_double" class="form-control"
                        value="{{$setting['detailSeacrh_double'] ?? ''}}">
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label>Sets Label bottom text</label>
                    <input type="text" name="detailSeacrh_double_check" class="form-control"
                        value="{{$setting['detailSeacrh_double_check'] ?? ''}}">
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label>Special cards label</label>
                    <input type="text" name="detailSeacrh_special" class="form-control"
                        value="{{$setting['detailSeacrh_special'] ?? ''}}">
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label>Special cards bottom text</label>
                    <input type="text" name="detailSeacrh_special_check" class="form-control"
                        value="{{$setting['detailSeacrh_special_check'] ?? ''}}">
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label>Artist Name label</label>
                    <input type="text" name="detailSeacrh_artist" class="form-control"
                        value="{{$setting['detailSeacrh_artist'] ?? ''}}">
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label>Artist Name bottom text</label>
                    <input type="text" name="detailSeacrh_artist_btm" class="form-control"
                        value="{{$setting['detailSeacrh_artist_btm'] ?? ''}}">
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label>Minimum Condition label</label>
                    <input type="text" name="detailSeacrh_con" class="form-control"
                        value="{{$setting['detailSeacrh_con'] ?? ''}}">
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label>Minimum Condition bottom text</label>
                    <input type="text" name="detailSeacrh_con_btm" class="form-control"
                        value="{{$setting['detailSeacrh_con_btm'] ?? ''}}">
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label>Language label</label>
                    <input type="text" name="detailSeacrh_lang" class="form-control"
                        value="{{$setting['detailSeacrh_lang'] ?? ''}}">
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label>Language bottom text</label>
                    <input type="text" name="detailSeacrh_lang_btm" class="form-control"
                        value="{{$setting['detailSeacrh_lang_btm'] ?? ''}}">
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label>Search button text</label>
                    <input type="text" name="detailSeacrh_btn" class="form-control"
                        value="{{$setting['detailSeacrh_btn'] ?? ''}}">
                </div>
            </div>
        </div>
    </div>
    <div class="card-footer">
        <button type="submit" class="btn btn-primary">submit</button>
    </div>
</div>
