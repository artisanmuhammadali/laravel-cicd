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

            <td style="text-align: center;font-size: 25px;padding-top: 20px;">
                <h3 style=""><span style="color: #5da3dc;">Hello {{$data['name']}}. MangoPay will look at your application soon!</span></h3>
            </td>
        </tr>
        <tr>
            <td style="text-align: center;">
            Hello, thank you for wanting to become an active seller on our platform. Our Payment Service Provider (PSP), MangoPay, is in charge of doing all checks for all of our sellers. The validation process usually takes between 1-2 days.
            </td>
        </tr>
        <tr>
            <td style="text-align: center;padding-top:10px">
                Before you dive in, please remember to pay for the successful verification of your account; without this
                fee, you cannot put your collection live.
            </td>
        </tr>
        <tr>
            <td style="text-align: center;padding-top:10px">
                <strong> If you get approved, we will notify you of this and enable you to sell on the website.</strong> 
            </td>
        </tr>
        <tr>
            <td style="text-align: center;padding-top:10px">
                <strong>All of our sellers are required to read our seller guides found by clicking the button below.</strong> This will ensure that you can safely and smoothly sell on our platform.
            </td>
        </tr>


        <tr>
            <td style="text-align: center;padding-top:20px">While waiting for validation, why not go ahead and start uploading your catalogues and cards into your account? 
            </td>
        </tr>
        <tr>
            <td style="text-align: center;padding-bottom: 15px;">
                Please note that other users won’t be able to see your collection for sale until you’ve been verified.
            </td>
        </tr>
        <tr>
            <td style="text-align: center;">
                Any problems?.
            </td>
        </tr>
        <tr>
            <td style="justify-content: center;text-align: center; padding-top: 15px;padding-bottom: 15px;">
                <a  href="{{route('faqs')}}" style="-webkit-text-size-adjust: none; border-radius: 4px;color: #fff; display: inline-block;overflow: hidden;text-decoration: none; background-color: #2d3748;border-bottom: 8px solid #2d3748;border-left: 18px solid #2d3748;border-right: 18px solid #2d3748;border-top: 8px solid #2d3748;">FAQ's</a>
            </td>
        </tr>
        <tr>
            <td style="text-align: center;">
                If you didn’t request this account deletion please contact us asap by clicking the button below.
            </td>
        </tr>
        <tr>
            <td style="justify-content: center;text-align: center; padding-top: 15px;padding-bottom: 15px;">
                <a  href="{{route('help')}}" style="-webkit-text-size-adjust: none; border-radius: 4px;color: #fff; display: inline-block;overflow: hidden;text-decoration: none; background-color: #2d3748;border-bottom: 8px solid #2d3748;border-left: 18px solid #2d3748;border-right: 18px solid #2d3748;border-top: 8px solid #2d3748;">Contact Us</a>
            </td>
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
