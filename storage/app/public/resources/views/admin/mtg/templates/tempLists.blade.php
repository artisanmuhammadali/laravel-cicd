<div class="row" id="user-profile">


    @foreach($templates as $m)
    <div class="col-md-10 col-10 copy_content">
    
            {!! $m->content !!}
      
    </div>
    <div class="col-md-2">
        <i class="fa fa-copy btn btn-warning copy_template"></i>
    </div>
    <hr>
    @endforeach
</div>
