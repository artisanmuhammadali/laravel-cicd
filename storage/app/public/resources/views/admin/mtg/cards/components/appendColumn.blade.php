<div>
    <select name="attribute[{{$id}}][]" id="select2-basic" data-select2-id="select2-basic" class="attributes_apply form-select  select2 w-100">
        @foreach($attributes as $att)
        @php($selected = $id == $att->id ? 'selected' : '')
        <option class="form-control" value="{{$att->id}}" {{$selected}} data-name="{{$att->name}}">{{$att->name}}</option>
        @endforeach
    </select>
</div>
