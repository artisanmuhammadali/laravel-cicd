<html lang="en">

<head>
    <title>Download Shipment Labels</title>
</head>
<style type="text/css">
    @import url(https://fonts.googleapis.com/css?family=Open+Sans:400,700);

    body {
        margin: 0;
        padding: 0;
        /* background: #e1e1e1; */
    }

    div,
    p,
    a,
    li,
    td {
        -webkit-text-size-adjust: none;
    }

    .ReadMsgBody {
        width: 100%;
        background-color: #ffffff;
    }

    .ExternalClass {
        width: 100%;
        background-color: #ffffff;
    }

    body {
        width: 100%;
        height: 100%;
        /* background-color: #e1e1e1; */
        margin: 0;
        padding: 0;
        -webkit-font-smoothing: antialiased;
    }

    html {
        width: 100%;
    }

    p {
        padding: 0 !important;
        margin-top: 0 !important;
        margin-right: 0 !important;
        margin-bottom: 0 !important;
        margin-left: 0 !important;
    }

    .fw-bolder {
        font-weight: bold;
    }
    .page-break {
    page-break-after: always;
}

</style>

<body>
    @foreach($orders as $order)
    <div style="box-shadow: rgba(100, 100, 111, 0.2) 0px 7px 29px 0px;">
        <table width="100%" border="0" cellpadding="0" cellspacing="0" align="center" class="fullTable" bgcolor="">
            <tr>
                <td height="20"></td>
            </tr>
            <tr>
                <td
                    style="font-size: 12px;text-transform: capitalize; color: #5b5b5b; font-family: 'Open Sans', sans-serif; line-height: 18px; vertical-align: top; text-align: left;padding-left: 25px;">
                    <span class="fw-bolder">Seller :</span> <span
                        style="color: #5da3dc;">{{$order->seller->user_name}}</span>
                    <br>
                    <!-- <span class="fw-bolder">Full Name : </span>-->
                    {{$order->seller->full_name}}
                    <br>
                    @php($isAddress = $order->seller->sellerAddress ?? null)
                    <!--<span class="fw-bolder">Address :</span> -->
                    @if($isAddress)
                    <!--<span class="fw-bolder">Address :</span> -->
                    {!! $order->seller->sellerAddress->street_number ." ,
                    <br>". $order->seller->sellerAddress->postal_code ." ,
                    <br>".$order->seller->sellerAddress->city ." , <br>".
                    $order->seller->sellerAddress->country !!}
                    @endif
                </td>
                <td
                    style="font-size: 12px;text-transform: capitalize; color: #5b5b5b; font-family: 'Open Sans', sans-serif; line-height: 18px; vertical-align: top; text-align: left;padding-left: 25px;">
                    <span class="fw-bolder">Buyer :</span> <span
                        style="color: #5da3dc;">{{$order->buyer->user_name}}</span>
                    <br>
                    <!-- <span class="fw-bolder">Full Name :</span> -->{{$order->buyer->full_name}}
                    <br>
                    <!-- <span class="fw-bolder">Address :</span> -->
                    <span>
                        {!!$order->deliveryAddress!!}
                    </span>
                </td>
            </tr>
        </table>
    </div>
    @if(($orders->count()) != $loop->iteration)
    <div class="page-break"></div>
    @endif
    @endforeach
</body>

</html>
