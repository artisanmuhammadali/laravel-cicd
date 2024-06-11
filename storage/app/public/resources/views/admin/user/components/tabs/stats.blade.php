<div class="col-lg-12">
    <div class="row match-height">
        @if($user->role != 'buyer')
        <div class="col-lg-3">
            <div class="card">
                <div class="card-body pb-50" style="position: relative;">
                    <div class="row">
                        <div class="col-12">
                            <h6>Lifetime Earning</h6>
                            <h2 class="fw-bolder mb-1 text-site-primary">£{{$earning}}</h2>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-3">
            <div class="card">
                <div class="card-body pb-50" style="position: relative;">
                    <div class="row">
                        <div class="col-12">
                            <h6>Lifetime Seller Vfs Commision</h6>
                            <h2 class="fw-bolder mb-1 text-site-primary">£{{$saleRevenue}}</h2>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @endif
        @if($user->role != 'seller')
        <div class="col-lg-3">
            <div class="card">
                <div class="card-body pb-50" style="position: relative;">
                    <div class="row">
                        <div class="col-12">
                            <h6>Lifetime Spendings</h6>
                            <h2 class="fw-bolder mb-1 text-site-primary">£{{$spending}}</h2>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-3">
            <div class="card">
                <div class="card-body pb-50" style="position: relative;">
                    <div class="row">
                        <div class="col-12">
                            <h6>Lifetime Buyer Vfs Commision</h6>
                            <h2 class="fw-bolder mb-1 text-site-primary">£{{$purchaseRevenue}}</h2>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @endif
        
        
    </div>
</div>
<div class="col-md-12">
    <div class="card w-100">
        <div class="card-body">
            <div>
                <div class="toolbar w-100">
                    <form method="GET" action="{{route('admin.user.detail',['id'=>$id , 'view'=>'user-stats'])}}">
                        <div class="row">
                            <div class="col-md-5 mb-2">
                                <div class="form-group">
                                    <label> Date</label>
                                    <input type="text" name="date" id="fp-range"
                                        class="form-control flatpickr-range  flatpickr-input"
                                        placeholder="YYYY-MM-DD" readonly="readonly"
                                        value="{{$date}}">
                                </div>
                            </div>
                            <div class="col-md-5 mb-2">
                                <div class="form-group">
                                    <label>Type</label>
                                    <select name="type" class="form-control text-capitalize">
                                        @foreach(getFilterTypes('time') as $item)
                                        <option class="text-capitalize" value="{{$item}}">{{$item}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-2 text-center mt-2">
                                <button type="submit" class="btn btn-primary ">
                                    Filter
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@if($user->role != 'buyer')
    <div class="col-lg-6 col-12 ">
        <div class="card">
            <div class="card-header border-bottom ">
                <h4 class="card-title text-capitalize">User Earnings</h4>

            </div>
            <div class="card-body mt-2">

                <div class="table-responsive">
                    <table class="table table-hover datatables">
                        <thead>
                            <tr>
                                <th>Date</th>
                                <th>Total Buyers Spending</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($earningArray as $item)
                            <tr>
                                <td>
                                    {{$item['Area'] ?? 'Area'}}
                                </td>
                                <td>
                                    {{$item['Earnings'] ?? '0'}}
                                </td>

                            </tr>
                            @endforeach
                        </tbody>
                    </table>

                </div>
            </div>

        </div>
    </div>
    <div class="col-lg-6 col-12 ">
        <div class="card">
            <div
                class="card-header d-flex justify-content-between align-items-sm-center align-items-start flex-sm-row flex-column">
                <div class="header-left">
                    <h4 class="card-title">Earning</h4>
                </div>
            </div>
            <div class="card-body">
                <canvas class="bar-chart-ex2 chartjs" data-height="400"></canvas>
            </div>
        </div>
    </div>
@endif
@if($user->role != 'seller')
    <div class="col-lg-6 col-12">
        <div class="card">
            <div class="card-header border-bottom ">
                <h4 class="card-title text-capitalize">User Spending</h4>

            </div>
            <div class="card-body mt-2">

                <div class="table-responsive">
                    <table class="table table-hover datatables">
                        <thead>
                            <tr>
                                <th>Date</th>
                                <th>Total Buyers Spending</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($spendingArray as $item)
                            <tr>
                                <td>
                                    {{$item['Area'] ?? 'Area'}}
                                </td>
                                <td>
                                    {{$item['Spendings'] ?? '0'}}
                                </td>

                            </tr>
                            @endforeach
                        </tbody>
                    </table>

                </div>
            </div>

        </div>
    </div>
    <div class="col-lg-6 col-12 ">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-sm-center align-items-start flex-sm-row flex-column">
                <div class="header-left">
                    <h4 class="card-title">Spending</h4>
                </div>
            </div>
            <div class="card-body">
                <canvas class="bar-chart-ex1 chartjs" data-height="400"></canvas>
            </div>
        </div>
    </div>
@endif
