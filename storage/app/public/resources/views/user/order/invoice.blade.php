
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

                </style>
                <table width="100%" border="0" cellpadding="0" cellspacing="0" align="center" class="fullTable" bgcolor="#e1e1e1">
                    <tr>
                        <td height="20"></td>
                    </tr>
                    <tr>
                        <td class="d-flex justify-content-center">
                            <table width="600" border="0" cellpadding="0" cellspacing="0" align="center" class="fullTable"
                                bgcolor="#ffffff" style="border-radius: 10px 10px 0 0;">
                                <tr class="hiddenMobile">
                                    <td height="40"></td>
                                </tr>
                                <tr class="visibleMobile">
                                    <td height="30"></td>
                                </tr>

                                <tr>
                                    <td>
                                        <table width="480" border="0" cellpadding="0" cellspacing="0" align="center"
                                            class="fullPadding">
                                            <tbody>
                                                <tr>
                                                    <td>
                                                        <table width="220" border="0" cellpadding="0" cellspacing="0" align="left"
                                                            class="col">
                                                            <tbody>
                                                                <tr>
                                                                    <td align="left"> <img
                                                                            src="{{asset('images/banner/logo/horizontallogo1.png')}}" width="130"
                                                                            height="70" alt="logo" border="0" /></td>
                                                                </tr>
                                                                <tr class="hiddenMobile">
                                                                    <td height="40"></td>
                                                                </tr>
                                                                <tr class="visibleMobile">
                                                                    <td height="20"></td>
                                                                </tr>
                                                                <tr>
                                                                    <td
                                                                        style="font-size: 12px;text-transform: capitalize; color: #5b5b5b; font-family: 'Open Sans', sans-serif; line-height: 18px; vertical-align: top; text-align: left;padding-left: 25px;">
                                                                        Hello, {{$type == "buy" ? $order->buyer->user_name : $order->seller->user_name}}!
                                                                        <br> <span style="text-transform: none;">Thank you for shopping from our platform for your order.</span>
                                                                    </td>
                                                                </tr>
                                                            </tbody>
                                                        </table>
                                                        <table width="220" border="0" cellpadding="0" cellspacing="0" align="right"
                                                            class="col">
                                                            <tbody>
                                                                <tr class="visibleMobile">
                                                                    <td height="20"></td>
                                                                </tr>
                                                                <tr>
                                                                    <td height="5"></td>
                                                                </tr>
                                                                <tr>
                                                                    <td
                                                                        style="font-size: 21px; color: #5da3dc; letter-spacing: -1px; font-family: 'Open Sans', sans-serif; line-height: 1; vertical-align: top; text-align: right;padding-left: 25px;">
                                                                        Invoice
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                <tr class="hiddenMobile">
                                                                    <td height="50"></td>
                                                                </tr>
                                                                <tr class="visibleMobile">
                                                                    <td height="20"></td>
                                                                </tr>
                                                                <tr>
                                                                    <td
                                                                        style="font-size: 12px; color: #5b5b5b; font-family: 'Open Sans', sans-serif; line-height: 18px; vertical-align: top; text-align: right;padding-left: 25px;">
                                                                        <small>ORDER</small> #{{$order->id}}<br />
                                                                        <small>{{now()->format('Y/m/d')}}</small>
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
                <table width="100%" border="0" cellpadding="0" cellspacing="0" align="center" class="fullTable" bgcolor="#e1e1e1">
                    <tbody>
                        <tr>
                            <td class="d-flex justify-content-center">
                                <table width="600" border="0" cellpadding="0" cellspacing="0" align="center" class="fullTable"
                                    bgcolor="#ffffff">
                                    <tbody>
                                        <tr>
                                        <tr class="hiddenMobile">
                                            <td height="60"></td>
                                        </tr>
                                        <tr class="visibleMobile">
                                            <td height="40"></td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <table width="480" border="0" cellpadding="0" cellspacing="0" align="center"
                                                    class="fullPadding">
                                                    <tbody>
                                                        <tr>
                                                            <th style="font-size: 12px; font-family: 'Open Sans', sans-serif; color: #5b5b5b; font-weight: normal; line-height: 1; vertical-align: top; padding: 0 10px 7px 0;padding-left: 25px;"
                                                                width="52%" align="left">
                                                                Card
                                                            </th>
                                                            <th style="font-size: 12px; font-family: 'Open Sans', sans-serif; color: #1e2b33; font-weight: normal; line-height: 1; vertical-align: top; padding: 0 0 7px;"
                                                                align="left">
                                                                Quantity
                                                            </th>
                                                            <th style="font-size: 12px; font-family: 'Open Sans', sans-serif; color: #1e2b33; font-weight: normal; line-height: 1; vertical-align: top; padding: 0 0 7px;"
                                                                align="left">
                                                                Price
                                                            </th>
                                                        </tr>
                                                        <tr>
                                                            <td height="1" style="background: #bebebe;" colspan="4"></td>
                                                        </tr>
                                                        <tr>
                                                            <td height="10" colspan="4"></td>
                                                        </tr>
                                                        @foreach($order->detail as $item)
                                                        <tr>
                                                            <td style="font-size: 12px; font-family: 'Open Sans', sans-serif; color: #5da3dc;  line-height: 18px;  vertical-align: top; padding:10px 0;padding-left: 25px;"
                                                                class="article">
                                                                {{$detail->card->name}}
                                                            </td>
                                                            <td style="font-size: 12px; font-family: 'Open Sans', sans-serif; color: #1e2b33;  line-height: 18px;  vertical-align: top; padding:10px 0;"
                                                                align="left">
                                                                {{$detail->quantity}}
                                                            </td>
                                                            <td style="font-size: 12px; font-family: 'Open Sans', sans-serif; color: #1e2b33;  line-height: 18px;  vertical-align: top; padding:10px 0;"
                                                                align="left">
                                                                {{$detail->price}}
                                                            </td>
                                                            <td style="font-size: 12px; font-family: 'Open Sans', sans-serif; color: #1e2b33;  line-height: 18px;  vertical-align: top; padding:1"></td>
                                                        </tr>
                                                        <tr>
                                                            <td height="1" colspan="4" style="border-bottom:1px solid #e4e4e4"></td>
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
                <table width="100%" border="0" cellpadding="0" cellspacing="0" align="center" class="fullTable" bgcolor="#e1e1e1">
                    <tbody>
                        <tr>
                            <td class="d-flex justify-content-center">
                                <table width="600" border="0" cellpadding="0" cellspacing="0" align="center" class="fullTable"
                                    bgcolor="#ffffff">
                                    <tbody>
                                        <tr>
                                            <td>

                                                <!-- Table Total -->
                                                <table width="480" border="0" cellpadding="0" cellspacing="0" align="center"
                                                    class="fullPadding">
                                                    <tbody>
                                                        <tr>
                                                            <td
                                                                style="font-size: 12px; font-family: 'Open Sans', sans-serif; color: #646a6e; line-height: 22px; vertical-align: top; text-align:right; ">
                                                                Subtotal
                                                            </td>
                                                            <td style="font-size: 12px; font-family: 'Open Sans', sans-serif; color: #646a6e; line-height: 22px; vertical-align: top; text-align:right; white-space:nowrap;"
                                                                width="80">
                                                                @php($postage_price =$order->postage ? $order->postage->price : 0)
                                                                £ {{$order->total - $postage_price}}
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td
                                                                style="font-size: 12px; font-family: 'Open Sans', sans-serif; color: #646a6e; line-height: 22px; vertical-align: top; text-align:right; ">
                                                                Shipping &amp; Handling
                                                            </td>
                                                            <td
                                                                style="font-size: 12px; font-family: 'Open Sans', sans-serif; color: #646a6e; line-height: 22px; vertical-align: top; text-align:right; ">
                                                                £ {{$postage_price}}
                                                            </td>
                                                        </tr>
                                                        @if($type == "sell")
                                                        <tr>
                                                            <td
                                                                style="font-size: 12px; font-family: 'Open Sans', sans-serif; color: rgb(254, 0, 25), 100, 103); line-height: 22px; vertical-align: top; text-align:right; ">
                                                                Platform Fee 
                                                            </td>
                                                            <td
                                                                style="font-size: 12px; font-family: 'Open Sans', sans-serif; color: rgb(254, 0, 25); line-height: 22px; vertical-align: top; text-align:right; ">
                                                                £ -{{$order->platform_fee}}
                                                            </td>
                                                        </tr>
                                                        @endif
                                                        <tr>
                                                            <td
                                                                style="font-size: 12px; font-family: 'Open Sans', sans-serif; color: #000; line-height: 22px; vertical-align: top; text-align:right; ">
                                                                <strong>Grand Total</strong>
                                                            </td>
                                                            <td
                                                                style="font-size: 12px; font-family: 'Open Sans', sans-serif; color: #000; line-height: 22px; vertical-align: top; text-align:right; ">
                                                                <strong>£ 
                                                                @if($type == "buy")    
                                                                    {{$order->total}}
                                                                @else
                                                                {{$order->total -$order->total_commision  + $extraPrice}}
                                                                @endif
                                                                </strong>
                                                            </td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                                <!-- /Table Total -->

                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </td>
                        </tr>
                    </tbody>
                </table>
                <table width="100%" border="0" cellpadding="0" cellspacing="0" align="center" class="fullTable" bgcolor="#e1e1e1">

                    <tr>
                        <td class="d-flex justify-content-center">
                            <table width="600" border="0" cellpadding="0" cellspacing="0" align="center" class="fullTable"
                                bgcolor="#ffffff" style="border-radius: 0 0 10px 10px;">
                                <tr>
                                    <td>
                                        <table width="480" border="0" cellpadding="0" cellspacing="0" align="center"
                                            class="fullPadding">
                                            <tbody>
                                                <tr>
                                                    <td
                                                        style="font-size: 12px; color: #5b5b5b; font-family: 'Open Sans', sans-serif; line-height: 18px; vertical-align: top; text-align: left;padding-left: 25px;">
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
                <button class="btn btn-primary" id="downloadPdf" >Save</button>
            </div>
        </div>
    </div>
</div>
@include('user.components.html-to-pdf',['file'=>'invoice.pdf'])
