<tbody>
    <tr>
        <td class="d-flex justify-content-center">
            <table width="600" border="0" cellpadding="0" cellspacing="0" align="center" class="fullTable"
                bgcolor="#ffffff">
                <tbody>
                    <tr class="hiddenMobile">
                        <td height="20"></td>
                    </tr>
                    <tr class="visibleMobile">
                        <td height="20"></td>
                    </tr>
                    <tr>
                        <td>
                            <table width="480" border="0" cellpadding="0" cellspacing="0" align="center"
                                class="fullPadding">
                                <tbody>
                                    <tr>
                                        <th style="font-size: 12px; font-family: 'Open Sans', sans-serif; color: #5b5b5b; font-weight: normal; line-height: 1; vertical-align: top; padding: 0 10px 7px 0;padding-left: 25px;"
                                            width="52%" align="left">
                                            Area
                                        </th>
                                        <th style="font-size: 12px; font-family: 'Open Sans', sans-serif; color: #1e2b33; font-weight: normal; line-height: 1; vertical-align: top; padding: 0 0 7px;"
                                            align="left">
                                            {{ucfirst($type)}}
                                        </th>
                                    </tr>
                                    <tr>
                                        <td height="1" style="background: #bebebe;" colspan="4"></td>
                                    </tr>
                                    <tr>
                                        <td height="10" colspan="4"></td>
                                    </tr>
                                    @foreach($data as $item)
                                    <tr>
                                        <td style="font-size: 12px; font-family: 'Open Sans', sans-serif; color: #5da3dc;  line-height: 18px;  vertical-align: top; padding:10px 0;padding-left: 25px;"
                                            class="article">
                                            {{$item->Area}}
                                        </td>
                                        @if($type == "spending")
                                        <td style="font-size: 12px; font-family: 'Open Sans', sans-serif; color: #1e2b33;  line-height: 18px;  vertical-align: top; padding:10px 0;"
                                            align="left">
                                            {{$item->Spendings}}
                                        </td>
                                        @else
                                        <td style="font-size: 12px; font-family: 'Open Sans', sans-serif; color: #1e2b33;  line-height: 18px;  vertical-align: top; padding:10px 0;"
                                            align="left">
                                            {{$item->Earnings}}
                                        </td>
                                        @endif
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