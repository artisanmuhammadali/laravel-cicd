<div class="row">
    <div class="col-12 mb-3 mt-2">
        <b>{{count($response->correct) -1}}</b> record found out of <b>{{$response->total}}</b> from your Excel/Csv.
        <button type="submit" class="btn btn-primary addToCollection px-3">Confirm</button>
    </div>
</div>
<div class="table-responsive" style="height: 700px">
    <table class="table">
        <tbody>
            @foreach($response->correct as $item)
            @if($loop->iteration -1 == 0)
            <tr class="{{$loop->iteration -1 == 0 ? "csvErrorTr" : ""}}">
                <td>#</td>
                <td>Name</td>
                <td>Set Code</td>
                @if(request()->mtg_card_type == "sealed")
                <td>Image</td>
                <td>Type</td>
                @else
                <td>Rarity</td>
                @endif
                <td>Weight</td>
                <td>Title</td>
                <td>Meta Description</td>
                <td>Heading</td>
                <td>Sub Heading</td>
            </tr>
            @else
            <tr>
                <td>{{$loop->iteration -1}}</td>
                <td>{{$item->name}}</td>
                <td>{{$item->set_code}}</td>
                @if(request()->mtg_card_type == "sealed")
                <td><img src="{{$item->image ?? 'https://veryfriendlysharks.co.uk/images/All.svg'}}" width="50" alt=""></td>
                <td>{{$item->other_cards_type}}</td>
                @else
                <td>{{$item->rarity}}</td>
                @endif
                <td>{{$item->weight}}</td>
                <td>{{$item->title}}</td>
                <td>{{$item->meta_description}}</td>
                <td>{{$item->heading}}</td>
                <td>{{$item->sub_heading}}</td>
            </tr>
            @endif
            @endforeach
        </tbody>
    </table>
</div>
<input type="hidden" value="1" class="checked">
{{-- @if(count($response->error) > 1)
<div class="row">
    <div class="col-12 mb-3 mt-2">
        This data from your Excel/Csv file has same issue please check it again.
        <a href="#" class="btn btn-primary showError px-3">Show Wrong Data</a>
        <a href="#" class="btn btn-primary downloadError px-3">Download Wrong Data</a>
    </div>
</div>
<div class="table-responsive errorData d-none" style="height: 700px">
    <table class="table">
        <tbody>
            @foreach($response->error as $item)
            @if($loop->iteration -1 == 0)
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
            </tr>
            @else
            <tr>
                <td>{{$loop->iteration}}</td>
                <td><img src="{{$item->image}}" alt=""></td>
                <td>{{$item->name}}</td>
                <td>{{$item->set_code}}</td>
                <td>{{$item->other_cards_type}}</td>
                <td>{{$item->title}}</td>
                <td>{{$item->meta_description}}</td>
                <td>{{$item->heading}}</td>
                <td>{{$item->sub_heading}}</td>
                <td>{{$item->weight}}</td>
            </tr>
            @endif
            @endforeach
        </tbody>
    </table>
</div>
@endif
@php($errors = $response->error->slice(1))
<input type="hidden" class="csvErrorsData" value="{{json_encode($errors)}}"> --}}