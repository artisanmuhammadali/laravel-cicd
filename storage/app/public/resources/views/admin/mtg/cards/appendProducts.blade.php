<div>
    <form method="POST" action="{{route('admin.mtg.cards.selected.products')}}" class="" enctype="multipart/form-data">
        @csrf
        <div class="row">


            <table class="table table-striped">
                <thead>
                    <tr>
                        <th scope="col">
                            <input class="select_all" name="" type="checkbox" checked="checked" value="1" id="" name="">
                        </th>
                        <th scope="col">#</th>
                        <th scope="col">Image</th>
                        <th scope="col">Title</th>
                        <th scope="col">Attributes</th>
                        <th scope="col">collector Number</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($cards as $card)
                    <tr>
                        <th scope="row"><input class="" name="ids[]" type="checkbox" checked="checked"
                                value="{{$card->id}}" id="card-{{$card->id}}" name="ids">
                        </th>
                        <td >
                            {{$loop->iteration}}
                        </td>
                        <th>
                            <div class="">
                                <img class="myDIV h4Btn" src="{{$card->png_image}}" width="50px">
                                <div class="hide hand h4" style="left: 391px; top: 4px;">
                                    <img class="rounded-3 lozad" alt="very friendly shark" width="250" src="{{$card->png_image}}">
                                </div>
                            </div>
                        </th>
                        <td>{{$card->name}}</td>
                        <td>
                            @foreach($card->attributes as $att)
                            <span class="badge bg-primary">{{$att->name}}</span>
                            @endforeach
                            
                        </td>
                        <td>{{$card->collector_number}}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>

        </div>
        <div>
            <button class="btn btn-primary scroll-submit" type="submit" style="display: inline-block;">Submit</button>
        </div>
    </form>
</div>
