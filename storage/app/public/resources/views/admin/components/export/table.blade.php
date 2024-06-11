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
                                    @foreach($header as $head)
                                        <th style="font-size: 12px; font-family: 'Open Sans', sans-serif; color: #5b5b5b; font-weight: normal; line-height: 1; vertical-align: top; padding: 0 10px 7px 0;padding-left: 25px;"
                                            align="left">
                                            {{$head}}
                                        </th>
                                    @endforeach
                                    </tr>
                                    <tr>
                                        <td height="1" style="background: #bebebe;" colspan="4"></td>
                                    </tr>
                                    <tr>
                                        <td height="10" colspan="4"></td>
                                    </tr>
                                    @if(count($data) > 0)
                                    @foreach($data as  $items)
                                    <tr>
                                        @foreach($items as $item)
                                        <td style="font-size: 12px; font-family: 'Open Sans', sans-serif; color: #5da3dc;  line-height: 18px;  vertical-align: top; padding:10px 0;padding-left: 25px;"
                                            class="article">
                                            {{$item}}
                                        </td>
                                        @endforeach
                                        <td style="font-size: 12px; font-family: 'Open Sans', sans-serif; color: #1e2b33;  line-height: 18px;  vertical-align: top; padding:1"></td>
                                    </tr>
                                    <tr>
                                        <td height="1" colspan="4" style="border-bottom:1px solid #e4e4e4"></td>
                                    </tr>
                                    @endforeach
                                    @else
                                    <tr>
                                        <td
                                            style="font-size: 30px; color: #5b5b5b; font-family: 'Open Sans', sans-serif; line-height: 100px; vertical-align: top; text-align: left;padding-left: 25px;">
                                            No Record Found
                                        </td>
                                    </tr>
                                    @endif
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