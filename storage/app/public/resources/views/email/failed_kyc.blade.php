<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{$data['subject']}}</title>

</head>

<body>
    <table width="100%" cellpadding="0" cellspacing="0" role="presentation">
        <tr style="background: #001d35;">
            <td style="justify-content: start;text-align: start;">
                <a href="{{route('index')}}" style="display: inline-block;">
                    <img width="200" src="https://img.veryfriendlysharks.co.uk/file_XkmW26pUb" class="logo"
                        alt="VFS logo">
                </a>
            </td>
        </tr>
        <tr>

            <td style="text-align: left;font-size: 25px;padding-top: 20px;">
                <h3 style="">Dear <span style="color: #5da3dc;">{{$data['name']}}</span></h3>
            </td>
        </tr>
        <tr>
            <td style="text-align: left;">
                We're reaching out to inform you that your recent KYC/KYB verification attempt was unsuccessful. But
                don't worry, this is often a quick fix!
            </td>
        </tr>
        <tr>
            <td style="text-align: left;padding-top:10px">
                To ensure a smooth verification process, please take a clearer picture of your document and re-upload it
                to our system. A well-lit, high-resolution image can make all the difference.
            </td>
        </tr>
        <tr>
            <td style="text-align: left;;padding-top:10px">
                Please keep in mind that Very Friendly Sharks doesn’t vet this process as it’s done through Mangopay
                (our Payment Service Provider).
            </td>
        </tr>
        <tr>
            <td style="text-align: left;;padding-top:10px">
                If you encounter any further issues, or if your documents continue to be rejected, don't hesitate to <a
                    href="{{route('help')}}">contact us directly</a>. If you do so, please make sure to paste the error you are receiving
                and explain what you’ve tried to fix it when re-uploading the document.
            </td>
        </tr>
        <tr>
            <td style="text-align: left;;padding-top:10px">
                We'll liaise with our Mangopay, to resolve the matter as swiftly as possible. We appreciate your
                cooperation and are here to help you every step of the way.
            </td>
        </tr>


        <tr>
            <td style="text-align: left;padding-top:20px">
            Best regards,
            </td>
        </tr>
        <tr>
            <td style="text-align: left;padding-bottom: 15px;">
                The Very Friendly Sharks Team
            </td>
        </tr>
        <tr>
            <td></td>
        </tr>
        <tr style="background: #001d35;">
            <td style="justify-content: center;text-align: center; padding-top: 15px;">
                <a target="blank" href="https://www.facebook.com/VeryFriendlySharks">
                    <img src="https://img.veryfriendlysharks.co.uk/file_AOKQhh7yJ" alt="">
                </a>
                <a target="blank" href="https://twitter.com/SharksVery">
                    <img class="mt-4px" src="https://img.veryfriendlysharks.co.uk/file_r4CuVbiJp" alt="">
                </a>
            </td>
        </tr>
        <tr style="background: #001d35;">
            <td style="justify-content: center;text-align: center;">
                <a href="{{route('index')}}" style="display: inline-block;">
                    <img width="200" src="https://img.veryfriendlysharks.co.uk/file_XkmW26pUb" class="logo"
                        alt="VFS logo">
                </a>
            </td>
        </tr>
        <tr style="background: #001d35;">
            <td style="justify-content: center;text-align: center; color: white; padding-bottom: 15px;">
                © 2021 - {{now()->format('Y')}} Very Friendly Sharks Ltd
            </td>
        </tr>
    </table>

</body>

</html>
