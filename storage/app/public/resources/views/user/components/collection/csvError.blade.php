@if(count($response->correct) > 1)
<div class="row">
    <div class="col-12 mb-3">
        This data from your Csv matched our record please verify it.
        <button type="submit" class="btn btn-primary addToCollection px-3">Add To My Collection</button>
    </div>
</div>
<div class="table-responsive" style="height: 700px">
    <table class="table">
        <tbody>
            @foreach($response->correct as $item)
            <tr class="{{$loop->iteration -1 == 0 ? "csvErrorTr" : ""}}">
                <td>{{$loop->iteration -1 == 0 ? "#" : $loop->iteration -1}}</td>
                @if($item['mtg_card_id'] == "Image")
                <td>Image</td>
                @else
                <td>
                    @php($image=findMtgCard($item['mtg_card_id']))
                    <div class="hover_div me-1">
                        <img class="png img_size_hover" src="{{$image->pn_image}}" width="50">
                    </div>
                </td>
                @endif
                <td>{{$item['A'] ?? ""}}</td>
                <td>{{$item['B'] ?? ""}}</td>
                <td>{{$item['C'] ?? ""}}</td>
                <td>{{$item['D'] ?? "" }}</td>
                <td>{{$item['E'] ?? ""}}</td>
                <td>{{$item['F'] ?? ""}}</td>
                <td>{{$item['G'] ?? ""}}</td>
                <td>{{$item['H'] ?? ""}}</td>
                <td>{{$item['I'] ?? ""}}</td>
                <td>{{$item['J'] ?? ""}}</td>
                <td>{{$item['K'] ?? ""}}</td>
                <td>{{$item['L'] ?? ""}}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
<input type="hidden" value="1" class="checked">
@endif
@if(count($response->error) > 1)
<div class="row">
    <div class="col-12 mb-3">
        This data from your Csv file has same issue please check it again.
        <a href="#" class="btn btn-primary showError px-3">Show Wrong Data</a>
        <a href="#" class="btn btn-primary downloadError px-3">Download Wrong Data</a>
    </div>
</div>
<div class="table-responsive errorData d-none" style="height: 700px">
    <table class="table">
        <tbody>
            @foreach($response->error as $item)
            <tr class="{{$loop->iteration -1 == 0 ? "csvErrorTr" : ""}}">
                <td>{{$loop->iteration -1 == 0 ? "#" : $loop->iteration -1}}</td>
                <td>{{$item['A'] ?? ""}}</td>
                <td>{{$item['B'] ?? ""}}</td>
                <td>{{$item['C'] ?? ""}}</td>
                <td>{{$item['D'] ?? "" }}</td>
                <td>{{$item['E'] ?? ""}}</td>
                <td>{{$item['F'] ?? ""}}</td>
                <td>{{$item['G'] ?? ""}}</td>
                <td>{{$item['H'] ?? ""}}</td>
                <td>{{$item['I'] ?? ""}}</td>
                <td>{{$item['J'] ?? ""}}</td>
                <td>{{$item['K'] ?? ""}}</td>
                <td>{{$item['L'] ?? ""}}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endif
<input type="hidden" class="csvErrorsData" value="{{json_encode($response->error)}}">