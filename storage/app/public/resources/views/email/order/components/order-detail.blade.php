<table width="100%" cellpadding="0" cellspacing="0" role="presentation">
    <thead>
        <th>
            Card
        </th>
        <th>
            Name
        </th>
        <th>
            Language
        </th>
        <th>
            Characterstics
        </th>
        <th>
            Notes
        </th>
        <th>
            Quantity
        </th>
        <th>
            Price
        </th>

    </thead>
    <tbody>
        @foreach($data['order']->detail as $detail)
    <tr style="padding-bottom: 20px;">
        <td style="width: 0px;">
            <img class="" src="{{$detail->card->png_image}}"
                width="50">
        </td>
        <td style="text-align: center;">{{$detail->card->name}}</td>
        <td style="text-align: center;">
            @if($detail->collection->mtg_card_type == "completed")
            @foreach(json_decode($detail->collection->language) as $key =>$lang)
            <span style="    padding: 8px;border-radius: 5px;background-color: aqua;text-align: center;text-transform: capitalize !important;">{{$key}}</span>
            @endforeach
            @else
            <span
                style="    padding: 8px;border-radius: 5px;background-color: aqua;text-align: center;text-transform: capitalize !important;">{{$detail->collection->language}}</span>
            @endif
        </td>
        <td style="text-align:center;display: grid;margin-top: 20px;">
            <span style="  padding: 5px;border-radius: 5px;background-color: coral;text-align: center;text-transform: capitalize !important;margin: 2px;">{{$detail->collection->condition}}</span>
            @if($detail->collection->foil)
            <span style="  padding: 5px;border-radius: 5px;background-color: antiquewhite;text-align: center;text-transform: capitalize !important;margin: 2px;">Foil</span>
            @endif
            @if($detail->collection->signed)
            <span style="padding: 5px;border-radius: 5px;background-color: blueviolet;text-align: center;text-transform: capitalize !important;margin: 2px;">Signed</span>
            @endif
            @if($detail->collection->graded)
            <span style="padding: 5px;border-radius: 5px;background-color: burlywood;text-align: center;text-transform: capitalize !important;margin: 2px;">Graded</span>
            @endif
            @if($detail->collection->altered)
            <span style="padding: 5px;border-radius: 5px;background-color: cadetblue;text-align: center;text-transform: capitalize !important;margin: 2px;">Altered</span>
            @endif
        </td>
        <td style="text-align: center;">
            {!! Str::limit($detail->collection->note, 20,'..') !!}
        </td>
        <td style="text-align: center;">
            {{$detail->quantity}}
        </td>
        <td style="text-align: center;">
            {{$detail->price}}
        </td>

    </tr>
    @endforeach
    </tbody>
</table>