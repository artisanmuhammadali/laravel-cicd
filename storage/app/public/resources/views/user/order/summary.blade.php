
<div class="modal fade pt-3 site-modal" id="invoiceModal" role="dialog" aria-modal="true">
    <div class="modal-dialog mt-5 modal-lg">
        <div class="modal-content" style="background-color: #e1e1e1">
            <div class="modal-header bg-transparent">
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body px-0  downloadBody" >
                <style type="text/css">
                    @import url(https://fonts.googleapis.com/css?family=Open+Sans:400,700);

                    body {
                        margin: 0;
                        padding: 0;
                        background: #e1e1e1;
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
                        background-color: #e1e1e1;
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

                    .visibleMobilePdf {
                        display: none;
                    }

                    .hiddenMobileHide {
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

                    @media only screen and (max-width: 450px) {
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

                        .visibleMobilePdf {
                            display: block !important;
                        }

                        .hiddenMobileHide {
                            display: none !important;
                        }
                    }

                </style>
                <table width="100%" border="0" cellpadding="0" cellspacing="0" align="center" class="fullTable w-100" bgcolor="#e1e1e1">
                    <tr>
                        <td height="20"></td>
                    </tr>
                    <tr>
                        <td class="d-flex justify-content-center">
                            <table border="0" cellpadding="0" cellspacing="0" align="center" class="fullTable w-75"
                                bgcolor="#ffffff" style="border-radius: 10px 10px 0 0;">
                                <tr class="hiddenMobileHide">
                                    <td height="40"></td>
                                </tr>
                                <tr class="visibleMobilePdf">
                                    <td height="30"></td>
                                </tr>

                                <tr>
                                    <td>
                                        <table  border="0" cellpadding="0" cellspacing="0" align="center"
                                            class="fullPadding w-100">
                                            <tbody>
                                                <tr>
                                                    <td>
                                                        <table border="0" cellpadding="0" cellspacing="0" align="left"
                                                            class="col w-50">
                                                            <tbody>
                                                                <tr>
                                                                    <td align="left"> <img
                                                                            src="{{$setting['logo'] ?? ""}}" width="120"
                                                                            height="70" alt="logo" border="0" /></td>
                                                                </tr>
                                                                <tr>
                                                                    <td height="20"></td>
                                                                </tr>
                                                                
                                                                <tr>
                                                                    <td
                                                                        style="font-size: 12px;text-transform: capitalize; color: #5b5b5b; font-family: 'Open Sans', sans-serif; line-height: 18px; vertical-align: top; text-align: left;padding-left: 10px;">
                                                                        <span class="fw-bolder fs-5">Order Detail</span>
                                                                        <br>                                                   
                                                                        <br>                                                   
                                                                        <br>                                                   
                                                                        <span class="fw-bolder">Seller :</span> <span style="color: #5da3dc;">{{$order->seller->user_name}}</span>
                                                                        <br>
                                                                        <!-- <span class="fw-bolder">Full Name : </span>--> {{$order->seller->full_name}}
                                                                        <br>
                                                                        <!--<span class="fw-bolder">Address :</span> -->
                                                                            {!! $order->seller->sellerAddress->street_number ." , <br>". $order->seller->sellerAddress->postal_code ." , <br>".$order->seller->sellerAddress->city ." , <br>". $order->seller->sellerAddress->country !!}
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td height="20"></td>
                                                                </tr>
                                                                <tr>
                                                                    <td
                                                                        style="font-size: 12px; color: #5b5b5b; font-family: 'Open Sans', sans-serif; line-height: 18px; vertical-align: top; text-align: left;padding-left: 10px;">
                                                                        <span class="fw-bolder">No of Items :</span> <span style="color: #5da3dc;">{{count($order->detail)}}</span>
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td
                                                                        style="font-size: 12px;text-transform: capitalize; color: #5b5b5b; font-family: 'Open Sans', sans-serif; line-height: 18px; vertical-align: top; text-align: left;padding-left: 10px;">
                                                                        <span class="fw-bolder">Items Value :</span> 
                                                                        <span style="color: #5da3dc;">
                                                                            £ {{$items_price}}
                                                                        </span>
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td
                                                                        style="font-size: 12px;text-transform: capitalize; color: #5b5b5b; font-family: 'Open Sans', sans-serif; line-height: 18px; vertical-align: top; text-align: left;padding-left: 10px;">
                                                                        <span class="fw-bolder">Platform Fee :</span> 
                                                                        <span style="color: #5da3dc;">£ {{$main->fee + $main->referee_credit}}
                                                                        </span>
                                                                    </td>
                                                                </tr>
                                                            </tbody>
                                                        </table>
                                                        <table border="0" cellpadding="0" cellspacing="0" align="right"
                                                            class="col w-50">
                                                            <tbody>
                                                                <tr class="visibleMobilePdf">
                                                                    <td height="20"></td>
                                                                </tr>
                                                                <tr>
                                                                    <td height="5"></td>
                                                                </tr>
                                                                <tr>
                                                                    <td
                                                                        style="font-size: 21px; color: #5da3dc; letter-spacing: -1px; font-family: 'Open Sans', sans-serif; line-height: 1; vertical-align: top; text-align: right;padding-left: 10px;" class="pe-2">
                                                                        
                                                                        ORDER #{{$order->id}}<br />
                                                                        <small>{{now()->format('Y/m/d')}}</small>
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                <tr class="hiddenMobileHide">
                                                                    <td height="90"></td>
                                                                </tr>
                                                                <tr class="visibleMobilePdf">
                                                                    <td height="75"></td>
                                                                </tr>
                                                                <tr>
                                                                    <td
                                                                        style="font-size: 12px;text-transform: capitalize; color: #5b5b5b; font-family: 'Open Sans', sans-serif; line-height: 18px; vertical-align: top; text-align: left;padding-left: 10px;">
                                                                        <span class="fw-bolder">Buyer :</span> <span style="color: #5da3dc;">{{$order->buyer->user_name}}</span>
                                                                        <br>
                                                                        <!-- <span class="fw-bolder">Full Name :</span> -->{{$order->buyer->full_name}}
                                                                        <br>
                                                                        <!-- <span class="fw-bolder">Address :</span> -->
                                                                        <span>
                                                                            {!!$order->deliveryAddress!!}
                                                                        </span>
                                                                    </td>
                                                                </tr>
                                                            </tbody>
                                                        </table>
                                                        <table border="0" cellpadding="0" cellspacing="0" align="right"
                                                            class="col w-100">
                                                            <tbody>
                                                                <tr class="hiddenMobileHide">
                                                                    <td height="20"></td>
                                                                </tr>
                                                                <tr class="visibleMobilePdf">
                                                                    <td height="5"></td>
                                                                </tr>
                                                                <tr>
                                                                    <td
                                                                        style="font-size: 12px;text-transform: capitalize; color: #5b5b5b; font-family: 'Open Sans', sans-serif; line-height: 18px; vertical-align: top; text-align: left;padding-left: 10px;">
                                                                        <span class="fw-bolder fs-5">Shipping Detail</span>
                                                                        <br>
                                                                        <span>Postage Service :</span> {{$order->postage ? $order->postage->name : "Postage"}}
                                                                        <br>
                                                                        <span>Postage Charges :</span> £ {{$main->shiping_charges ?? 0}}
                                                                        <br>
                                                                        <span>Tracking Id :</span> {{$order->tracking_id ? $order->tracking_id : "N/A"}}
                                                                    </td>
                                                                </tr>
                                                            </tbody>
                                                        </table>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                </table>
                <table width="100%" border="0" cellpadding="0" cellspacing="0" align="center" class="fullTable w-100" bgcolor="#e1e1e1">
                    <tbody>
                        <tr>
                            <td class="d-flex justify-content-center">
                                <table border="0" cellpadding="0" cellspacing="0" align="center" class="fullTable w-75"
                                    bgcolor="#ffffff">
                                    <tbody>
                                        <tr>
                                        <tr class="hiddenMobileHide">
                                            <td height="60"></td>
                                        </tr>
                                        <tr class="visibleMobilePdf">
                                            <td height="40"></td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <table  border="0" cellpadding="0" cellspacing="0" align="center"
                                                    class="fullPadding w-100">
                                                    <tbody>
                                                        <tr>
                                                            <th style="border-bottom: 1px solid #bebebe;font-size: 12px; font-family: 'Open Sans', sans-serif; color: #5b5b5b; font-weight: normal; line-height: 1; vertical-align: top; padding: 0 0px 7px 0;padding-left: 10px;"
                                                                 align="center">
                                                                Card
                                                            </th>
                                                            <th style="border-bottom: 1px solid #bebebe;font-size: 12px; font-family: 'Open Sans', sans-serif; color: #1e2b33; font-weight: normal; line-height: 1; vertical-align: top; padding: 0 0 7px;"
                                                                align="center">
                                                                Set
                                                            </th>
                                                            <th style="border-bottom: 1px solid #bebebe;font-size: 12px; font-family: 'Open Sans', sans-serif; color: #1e2b33; font-weight: normal; line-height: 1; vertical-align: top; padding: 0 2px 7px 0px;"
                                                                align="center">
                                                                Rarity
                                                            </th>
                                                            <th style="border-bottom: 1px solid #bebebe;font-size: 12px; font-family: 'Open Sans', sans-serif; color: #1e2b33; font-weight: normal; line-height: 1; vertical-align: top; padding: 0 0 7px;"
                                                                align="center">
                                                                Chars
                                                            </th>
                                                            <th style="border-bottom: 1px solid #bebebe;font-size: 12px; font-family: 'Open Sans', sans-serif; color: #1e2b33; font-weight: normal; line-height: 1; vertical-align: top; padding: 0 0 7px;"
                                                                align="center">
                                                                Quantity
                                                            </th>
                                                            <th style="border-bottom: 1px solid #bebebe;font-size: 12px; font-family: 'Open Sans', sans-serif; color: #1e2b33; font-weight: normal; line-height: 1; vertical-align: top; padding: 0 0 7px 2px;"
                                                                align="left">
                                                                Price
                                                            </th>
                                                        </tr>
                                                        <tr>
                                                            <td height="10" colspan="4"></td>
                                                        </tr>
                                                        @foreach($order->detail as $item)
                                                        <tr>
                                                            <td style="border-bottom: 1px solid #bebebe;font-size: 12px; font-family: 'Open Sans', sans-serif; color: #5da3dc;  line-height: 18px;  vertical-align: top; padding:10px 0;padding-left: 10px;"
                                                                class="article" align="center">
                                                                {{$item->card->name}}
                                                            </td>
                                                            <td style="border-bottom: 1px solid #bebebe;font-size: 12px; font-family: 'Open Sans', sans-serif; color: #1e2b33;  line-height: 18px;  vertical-align: top; padding:10px 0;text-transform: uppercase;"
                                                                align="center">
                                                                {{$item->card->set_code}}
                                                            </td>
                                                            <td style="border-bottom: 1px solid #bebebe;font-size: 12px; font-family: 'Open Sans', sans-serif; color: #1e2b33;  line-height: 18px;  vertical-align: top; padding:10px 5px;"
                                                                align="center">
                                                                <img loading="lazy" src="{{$item->card->set->icon  ?? ""}}" style="filter: url({{"#".$item->card->rarity."_rarity"}});" height="20" width="20" alt="Angular" title="{{$item->card->set->name}}">
                                                            </td>
                                                            <td style="border-bottom: 1px solid #bebebe;font-size: 12px; font-family: 'Open Sans', sans-serif; color: #1e2b33;  line-height: 18px;  vertical-align: top; padding:10px 0;" align="center">
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
                                                                align="center">
                                                                {{$item->quantity}}
                                                            </td>
                                                            <td style="border-bottom: 1px solid #bebebe;font-size: 12px; font-family: 'Open Sans', sans-serif; color: #1e2b33;  line-height: 18px;  vertical-align: top; padding:10px 0;"
                                                                align="center">
                                                                £ {{$item->price}}
                                                            </td>
                                                            <td style="font-size: 12px; font-family: 'Open Sans', sans-serif; color: #1e2b33;  line-height: 18px;  vertical-align: top; padding:1" align="center"></td>
                                                        </tr>
                                                        @endforeach
                                                    </tbody>
                                                </table>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td height="20"></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </td>
                        </tr>
                    </tbody>
                </table>
                <table width="100%" border="0" cellpadding="0" cellspacing="0" align="center" class="fullTable w-100" bgcolor="#e1e1e1">
                    <tbody>
                        <tr>
                            <td class="d-flex justify-content-center">
                                <table border="0" cellpadding="0" cellspacing="0" align="center" class="fullTable w-75"
                                    bgcolor="#ffffff">
                                    <tbody>
                                        <tr>
                                            <td>

                                                <!-- Table Total -->
                                                <table border="0" cellpadding="0" cellspacing="0" align="center"
                                                    class="fullPadding w-100">
                                                    <tbody>
                                                        <tr>
                                                            <td
                                                                style="padding-right:30px;font-size: 12px; font-family: 'Open Sans', sans-serif; color: #646a6e; line-height: 22px; vertical-align: top; text-align:right; ">
                                                                Subtotal
                                                            </td>
                                                            <td style="padding-right:30px;font-size: 12px; font-family: 'Open Sans', sans-serif; color: #646a6e; line-height: 22px; vertical-align: top; text-align:right; white-space:nowrap;"
                                                                width="80">
                                                                £ {{$items_price}}
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td
                                                                style="padding-right:30px;font-size: 12px; font-family: 'Open Sans', sans-serif; color: #646a6e; line-height: 22px; vertical-align: top; text-align:right; ">
                                                                Shipping &amp; Handling
                                                            </td>
                                                            <td
                                                                style="padding-right:30px;font-size: 12px; font-family: 'Open Sans', sans-serif; color: #646a6e; line-height: 22px; vertical-align: top; text-align:right; ">
                                                                £ {{$main->shiping_charges ?? 0}}
                                                            </td>
                                                        </tr>
                                                        @if(count($extraPayments) > 0)
                                                            @foreach($extraPayments as $extra)
                                                            <tr>
                                                                <td style="padding-right:30px;font-size: 12px; font-family: 'Open Sans', sans-serif; color: rgb(254, 0, 25), 100, 103); line-height: 22px; vertical-align: top; text-align:right; ">
                                                                    <span class="fw-bold">{{$extra->credit_user == $order->buyer_id ? "Return Extra Payment To Buyer" : "Send Extra Payment To Seller"}}</span>
                                                                </td>
                                                                <td style="padding-right:30px;font-size: 12px; font-family: 'Open Sans', sans-serif; line-height: 22px; vertical-align: top; text-align:right; ">£ {{$extra->amount}}</td>
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
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </td>
                        </tr>
                    </tbody>
                </table>
                <table width="100%" border="0" cellpadding="0" cellspacing="0" align="center" class="fullTable w-100" bgcolor="#e1e1e1">

                    <tr>
                        <td class="d-flex justify-content-center">
                            <table border="0" cellpadding="0" cellspacing="0" align="center" class="fullTable w-75"
                                bgcolor="#ffffff" style="border-radius: 0 0 10px 10px;">
                                <tr>
                                    <td>
                                        <table width="480" border="0" cellpadding="0" cellspacing="0" align="center"
                                            class="fullPadding">
                                            <tbody>
                                                <tr>
                                                    <td
                                                        style="font-size: 12px; color: #5b5b5b; font-family: 'Open Sans', sans-serif; line-height: 18px; vertical-align: top; text-align: left;padding-left: 10px;">
                                                        Have a nice day.
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </td>
                                </tr>
                                <tr class="spacer">
                                    <td height="50"></td>
                                </tr>

                            </table>
                        </td>
                    </tr>
                    <tr>
                        <td height="20"></td>
                    </tr>
                </table>


            </div>
            <div class="modal-footer">
                <button class="btn btn-primary downloadPdf" data-file="summary.pdf"  data-class="downloadBody" >Save</button>
            </div>
        </div>
    </div>
</div>
