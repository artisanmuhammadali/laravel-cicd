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
                <h3 style=""><span style="color: #5da3dc;">Hello {{$data['name']}}!</span></h3>
            </td>
        </tr>
        <tr>
            <td style="text-align: center;">
            We are pleased to inform you that your seller status on our website has been successfully activated. We have received your payment, and all necessary procedures have been completed to enable you to start selling on our platform.
            </td>
        </tr>
        <tr>
            <td style="text-align: center;padding-top:10px">
            Your dedication and interest in joining our community of sellers are greatly appreciated. We trust that your products or services will contribute positively to our marketplace, enhancing the experience for our users.
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
