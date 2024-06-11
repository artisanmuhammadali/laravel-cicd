
<div class="modal fade pt-3 site-modal" id="addressModal" role="dialog" aria-modal="true">
    <div class="modal-dialog mt-5 modal-lg">
        <div class="modal-content" style="background-color: #e1e1e1">
            <div class="modal-header bg-transparent">
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body px-0  downloadAddress" >
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
                            <table border="0" cellpadding="0" cellspacing="0" align="center" class="fullTable w-75"
                                bgcolor="#ffffff" style="border-radius: 10px 10px 0 0;">
                                <tr class="hiddenMobile">
                                    <td height="40"></td>
                                </tr>
                                <tr class="visibleMobile">
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
                                                                    <td
                                                                        style="font-size: 12px;text-transform: capitalize; color: #5b5b5b; font-family: 'Open Sans', sans-serif; line-height: 18px; vertical-align: top; text-align: left;padding-left: 25px;">
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
                                                            </tbody>
                                                        </table>
                                                        <table border="0" cellpadding="0" cellspacing="0" align="right"
                                                            class="col w-50">
                                                            <tbody>
                                                                <tr>
                                                                    <td
                                                                        style="font-size: 12px;text-transform: capitalize; color: #5b5b5b; font-family: 'Open Sans', sans-serif; line-height: 18px; vertical-align: top; text-align: left;padding-left: 25px;">
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

                    <tr>
                        <td class="d-flex justify-content-center">
                            <table border="0" cellpadding="0" cellspacing="0" align="center" class="fullTable w-75"
                                bgcolor="#ffffff" style="border-radius: 0 0 10px 10px;">
                                <tr class="spacer">
                                    <td height="40"></td>
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
                <button class="btn btn-primary downloadPdf" data-file="shipping-address.pdf" data-class="downloadAddress" >Save</button>
            </div>
        </div>
    </div>
</div>
