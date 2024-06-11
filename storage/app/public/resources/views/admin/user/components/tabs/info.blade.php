<div class="col-lg-12 col-12 order-2 order-lg-1">
    <div class="card">
        <div class="card-body">
            <h3 class="mb-75">About</h3>
            <div class="mt-2 d-flex">
                <h5 class="mb-75 col-4">Full Name:</h5>
                <p class="card-text col-8 text-capitalize">{{$user->full_name ?? ""}}</p>
            </div>
            <div class="mt-1 d-flex">
                <h5 class="mb-75 col-4">Username:</h5>
                <p class="card-text col-8">{{$user->user_name ?? ""}}</p>
            </div>
            <div class="mt-1 d-flex">
                <h5 class="mb-75 col-4">Email:</h5>
                <p class="card-text col-8">{{$user->email ?? ""}}</p>
            </div>
            <div class="mt-1 d-flex">
                <h5 class="mb-75 col-4">Phone:</h5>
                <p class="card-text col-8">{{$user->store ? $user->store->telephone : ""}}</p>
            </div>
            <div class="mt-1 d-flex">
                <h5 class="mb-75 col-4">Joined:</h5>
                <p class="card-text col-8">{{$user->created_at->format('d/m/Y') ?? ""}}</p>
            </div>
            <div class="mt-1 d-flex">
                <h5 class="mb-75 col-4">Primary Address:</h5>
                <p class="card-text col-8">{{$user->primary_address ?? ""}}</p>
            </div>
        </div>
    </div>
</div>