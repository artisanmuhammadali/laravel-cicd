<html lang="en">

<head>
    <title>Download Order Summaries</title>
</head>
<style type="text/css">
    h2 {
        text-align: center;
        font-size: 22px;
        margin-bottom: 50px;
    }

    body {
        background: #fff;
    }

    .section {
        margin-top: 30px;
        background: #fff;
    }

    .pdf-btn {
        margin-top: 30px;
    }

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

    .visibleMobile {
        display: none;
    }

    .hiddenMobile {
        display: block;
    }

    @media only screen and (max-width: 600px) {
        body {
            width: auto !important;
        }

        table[class=fullTable] {
            width: 96% !important;
            clear: both;
        }

        table[class=fullPadding] {
            width: 85% !important;
            clear: both;
        }

        table[class=col] {
            width: 45% !important;
        }

        .erase {
            display: none;
        }
    }

    @media only screen and (max-width: 420px) {
        table[class=fullTable] {
            width: 100% !important;
            clear: both;
        }

        table[class=fullPadding] {
            width: 85% !important;
            clear: both;
        }

        table[class=col] {
            width: 100% !important;
            clear: both;
        }

        table[class=col] td {
            text-align: left !important;
        }

        .erase {
            display: none;
            font-size: 0;
            max-height: 0;
            line-height: 0;
            padding: 0;
        }

        .visibleMobile {
            display: block !important;
        }

        .hiddenMobile {
            display: none !important;
        }
    }

    .w-100 {
        width: 100%;
    }

    .left-w50 {
        width: 50%;
        float: left;
    }

    .right-w50 {
        width: 50%;
        float: right;
    }

    .fw-bolder {
        font-weight: bold;
    }
    .page-break {
    page-break-after: always;
}
.badge {
  display: inline-block;
  padding: .25em .4em;
  font-size: 75%;
  font-weight: 700;
  line-height: 1;
  text-align: center;
  white-space: nowrap;
  vertical-align: baseline;
  border-radius: .25rem;
  color:white;
}.bg-info {
  background-color: #17a2b8 !important;
}
.bg-warning {
  background-color: #ffc107 !important;
}
.bg-primary {
  background-color: #007bff !important;
}
.bg-secondary {
  background-color: #6c757d !important;
}
.bg-success {
  background-color: #28a745 !important;
}
</style>

<body>
    @foreach($orders as $order)
    @php(list($extraPayments,$extraPrice) = getExtraPayment($order))
    <div>
        <table width="100%" border="0" cellpadding="0" cellspacing="0" align="center" class="fullTable" bgcolor="">
            <tr>
                <td height="20"></td>
            </tr>
            <tr>
                <td align="left" class="ps-2"> <img src="{{$setting['logo'] ?? ""}}" width="130" height="70" alt="logo"
                        border="0" /></td>
                <td style="font-size: 21px; color: #5da3dc; letter-spacing: -1px; font-family: 'Open Sans', sans-serif; line-height: 1; vertical-align: top; text-align: right;padding-left: 25px;"
                    class="pe-2">

                    ORDER #{{$order->id}}<br />
                    <small>{{now()->format('Y/m/d')}}</small>
                </td>
            </tr>
        </table>
        <table width="100%" border="0" cellpadding="0" cellspacing="0" align="center" class="fullTable" bgcolor="">
            <tr>
                <td
                    style="font-size: 12px;text-transform: capitalize; color: #5b5b5b; font-family: 'Open Sans', sans-serif; line-height: 18px; vertical-align: top; text-align: left;padding-left: 25px;">
                    <span class="fw-bolder fs-5">Order Detail</span>
                    <br>
                    <span class="fw-bolder">Seller :</span> <span
                        style="color: #5da3dc;">{{$order->seller->user_name}}</span>
                    <br>
                    <!-- <span class="fw-bolder">Full Name : </span>-->
                    {{$order->seller->full_name}}
                    <br>
                    @php($isAddress = $order->seller->sellerAddress ?? null)
                    <!--<span class="fw-bolder">Address :</span> -->
                    @if($isAddress)
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
            <tr>
                <td height="20"></td>
            </tr>
            <tr>
                <td
                    style="font-size: 12px; color: #5b5b5b; font-family: 'Open Sans', sans-serif; line-height: 18px; vertical-align: top; text-align: left;padding-left: 25px;">
                    <span class="fw-bolder">No of Items :</span> <span
                        style="color: #5da3dc;">{{$order->detail->sum('quantity')}}</span>
                    <br>
                    <span class="fw-bolder">Items Value :</span>
                    <span style="color: #5da3dc;">
                        @php($postage_price =$order->postage ?
                        $order->postage->price : 0)
                        £ {{$order->total - $postage_price}}
                    </span>
                    <br>
                    <span class="fw-bolder">Platform Fee :</span>
                    <span style="color: #5da3dc;">£ {{$order->platform_fee}}
                    </span>
                </td>

            </tr>
        </table>
        <table width="100%" border="0" cellpadding="0" cellspacing="0" align="center" class="fullTable" bgcolor="">
            <tr>
                <td height="20"></td>
            </tr>
            <tr>
                <td
                    style="font-size: 12px;text-transform: capitalize; color: #5b5b5b; font-family: 'Open Sans', sans-serif; line-height: 18px; vertical-align: top; text-align: left;padding-left: 25px;">
                    <span class="fw-bolder fs-5">Shipping Detail</span>
                    <br>
                    <span>Postage Service :</span>
                    {{$order->postage ? $order->postage->name : "Postage"}}
                    <br>
                    <span>Postage Charges :</span> £ {{$postage_price}}
                    <br>
                    <span>Tracking Id :</span>
                    {{$order->tracking_id ? $order->tracking_id : "N/A"}}
                </td>
            </tr>
        </table>

        <table width="100%" style="margin-top:20px;text-align:center" border="0" cellpadding="0" cellspacing="0" align="center"
            class="fullTable" bgcolor="">
            <tbody>
                <tr>
                    <th style="border-bottom: 1px solid #bebebe;font-size: 12px; font-family: 'Open Sans', sans-serif; color: #5b5b5b; font-weight: normal; line-height: 1; vertical-align: top; padding: 0 10px 7px 0;padding-left: 25px;"
                        >
                        Card
                    </th>
                    <th style="border-bottom: 1px solid #bebebe;font-size: 12px; font-family: 'Open Sans', sans-serif; color: #1e2b33; font-weight: normal; line-height: 1; vertical-align: top; padding: 0 0 7px;"
                        >
                        Set
                    </th>
                    <th style="border-bottom: 1px solid #bebebe;font-size: 12px; font-family: 'Open Sans', sans-serif; color: #1e2b33; font-weight: normal; line-height: 1; vertical-align: top; padding: 0 0 7px;"
                        >
                        Rarity
                    </th>
                    <th style="border-bottom: 1px solid #bebebe;font-size: 12px; font-family: 'Open Sans', sans-serif; color: #1e2b33; font-weight: normal; line-height: 1; vertical-align: top; padding: 0 0 7px;"
                        >
                        Chars
                    </th>
                    <th style="border-bottom: 1px solid #bebebe;font-size: 12px; font-family: 'Open Sans', sans-serif; color: #1e2b33; font-weight: normal; line-height: 1; vertical-align: top; padding: 0 0 7px;"
                        >
                        Quantity
                    </th>
                    <th style="border-bottom: 1px solid #bebebe;font-size: 12px; font-family: 'Open Sans', sans-serif; color: #1e2b33; font-weight: normal; line-height: 1; vertical-align: top; padding: 0 0 7px;"
                        >
                        Price
                    </th>
                </tr>
                <tr>
                    <td height="10" colspan="6"></td>
                </tr>
                @foreach($order->detail as $item)
                <tr>
                    <td style="border-bottom: 1px solid #bebebe;font-size: 12px; font-family: 'Open Sans', sans-serif; color: #5da3dc;  line-height: 18px;  vertical-align: top; padding:10px 0;padding-left: 25px;"
                        class="article">
                        {{$item->card->name}}
                    </td>
                    <td style="border-bottom: 1px solid #bebebe;font-size: 12px; font-family: 'Open Sans', sans-serif; color: #1e2b33;  line-height: 18px;  vertical-align: top; padding:10px 0;text-transform: uppercase;"
                        >
                        {{$item->card->set_code}}
                    </td>
                    <td style="border-bottom: 1px solid #bebebe;font-size: 12px; font-family: 'Open Sans', sans-serif; color: #1e2b33;  line-height: 18px;  vertical-align: top; padding:10px 0;"
                        >
                        <img loading="lazy" src="{{$item->card->set->icon  ?? ""}}"
                            style="filter: url({{"#".$item->card->rarity."_rarity"}});" height="20" width="20"
                            alt="Angular" title="{{$item->card->set->name}}">
                    </td>
                    <td
                        style="border-bottom: 1px solid #bebebe;font-size: 12px; font-family: 'Open Sans', sans-serif; color: #1e2b33;  line-height: 18px;  vertical-align: top; padding:10px 0;">
                        <div class="d-block text-center">

                            <span class="badge col-md-4 col-11 bg-primary">{{$item->collection->condition}}</span>
                            @if($item->collection->foil)
                            <span class="badge col-md-4 col-11 bg-info">Foil</span>
                            <br>
                            @endif
                            @if($item->collection->signed)
                            <span class="badge col-md-5 col-11 bg-warning">Signed</span>
                            @endif
                            @if($item->collection->graded)
                            <span class="badge col-md-5 col-11 bg-success">Graded</span>
                            <br>
                            @endif
                            @if($item->collection->altered)
                            <span class="badge col-md-5 col-11 bg-secondary">Altered</span>
                            @endif
                        </div>
                    </td>
                    <td style="border-bottom: 1px solid #bebebe;font-size: 12px; font-family: 'Open Sans', sans-serif; color: #1e2b33;  line-height: 18px;  vertical-align: top; padding:10px 0;"
                        align="left">
                        {{$item->quantity}}
                    </td>
                    <td style="border-bottom: 1px solid #bebebe;font-size: 12px; font-family: 'Open Sans', sans-serif; color: #1e2b33;  line-height: 18px;  vertical-align: top; padding:10px 0;"
                        align="left">
                        £ {{$item->price}}
                    </td>
                    <td
                        style="font-size: 12px; font-family: 'Open Sans', sans-serif; color: #1e2b33;  line-height: 18px;  vertical-align: top; padding:1">
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>


        <table border="0" cellpadding="0" cellspacing="0" align="center" class="fullPadding w-100"
            style="margin-top:20px">
            <tbody>
                <tr>
                    <td
                        style="padding-right:30px;font-size: 12px; font-family: 'Open Sans', sans-serif; color: #646a6e; line-height: 22px; vertical-align: top; text-align:right; ">
                        Subtotal
                    </td>
                    <td style="padding-right:30px;font-size: 12px; font-family: 'Open Sans', sans-serif; color: #646a6e; line-height: 22px; vertical-align: top; text-align:right; white-space:nowrap;"
                        width="80">
                        @php($postage_price =$order->postage ? $order->postage->price :
                        0)
                        £ {{$order->total - $postage_price}}
                    </td>
                </tr>
                <tr>
                    <td
                        style="padding-right:30px;font-size: 12px; font-family: 'Open Sans', sans-serif; color: #646a6e; line-height: 22px; vertical-align: top; text-align:right; ">
                        Shipping &amp; Handling
                    </td>
                    <td
                        style="padding-right:30px;font-size: 12px; font-family: 'Open Sans', sans-serif; color: #646a6e; line-height: 22px; vertical-align: top; text-align:right; ">
                        £ {{$postage_price}}
                    </td>
                </tr>
                @if(count($extraPayments) > 0)
                @foreach($extraPayments as $extra)
                <tr>
                    <td
                        style="padding-right:30px;font-size: 12px; font-family: 'Open Sans', sans-serif; color: rgb(254, 0, 25), 100, 103); line-height: 22px; vertical-align: top; text-align:right; ">
                        <span
                            class="fw-bold">{{$extra->credit_user == $order->buyer_id ? "Return Extra Payment To Buyer" : "Send Extra Payment To Seller"}}</span>
                    </td>
                    <td
                        style="padding-right:30px;font-size: 12px; font-family: 'Open Sans', sans-serif; line-height: 22px; vertical-align: top; text-align:right; ">
                        £ {{$extra->amount}}</td>
                </tr>
                @endforeach
                @endif
                <tr>
                    <td
                        style="padding-right:30px;font-size: 12px; font-family: 'Open Sans', sans-serif; color: #000; line-height: 22px; vertical-align: top; text-align:right; ">
                        <strong>Grand Total</strong>
                    </td>
                    <td
                        style="padding-right:30px;font-size: 12px; font-family: 'Open Sans', sans-serif; color: #000; line-height: 22px; vertical-align: top; text-align:right; ">
                        <strong>£
                            {{$order->total + $extraPrice}}
                        </strong>
                    </td>
                </tr>
            </tbody>
        </table>

        <table width="480" border="0" cellpadding="0" cellspacing="0" align="center" class="fullPadding">
            <tbody>
                <tr>
                    <td
                        style="font-size: 12px; color: #5b5b5b; font-family: 'Open Sans', sans-serif; line-height: 18px; vertical-align: top; text-align: left;padding-left: 25px;">
                        Have a nice day.
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
    @if(($orders->count()) != $loop->iteration)
    <div class="page-break"></div>
    @endif
    @endforeach
</body>

</html>
