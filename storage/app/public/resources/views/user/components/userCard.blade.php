<div class="card">
    <div class="card-body">
        <div class="user-avatar-section">
            <div class="d-flex align-items-center flex-column">
                <div class="profile-pic">
                    <label class="-label" for="file">
                        <span class="glyphicon glyphicon-camera"></span>
                        <span>Change Image</span>
                    </label>
                    <img src="{{$auth->main_image}}" id="output" width="100" />
                </div>
                
                <form action="{{route('user.profile.update.avatar')}}" method="POST" class="profileForm" enctype="multipart/form-data" >
                    @csrf
                    <input id="file" name="photo" type="file" class="avatar_img d-none" accept=".jpg , .png , .jpeg" onchange="loadFile(event)"/> 
                    <input type="hidden" name="id" value="{{$auth->id}}">
                    <button type="submit" class="btn btn-primary updateProfile d-none my-50">Update</button>
                </form>
                <div class="user-info text-center mt-2">
                    <h4>{{$auth->user_name}}</h4>
                    <span class="badge bg-light-secondary">Member Since {{$auth->created_at->format('Y/m/d')}}</span>
                </div>
            </div>
        </div>
    </div>
</div>