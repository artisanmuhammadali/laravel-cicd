<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
        .button {
            -webkit-text-size-adjust: none; border-radius: 4px;color: #fff; display: inline-block;overflow: hidden;text-decoration: none; background-color: #2d3748;border-bottom: 8px solid #2d3748;border-left: 18px solid #2d3748;border-right: 18px solid #2d3748;border-top: 8px solid #2d3748;
        }

    .button-blue,
    .button-primary {
        
    }
    </style>
    
</head>
<body>
    <table width="100%" cellpadding="0" cellspacing="0" role="presentation">
        <tr style="background: #001d35;">
            <td style="justify-content: start;text-align: start;">
                <a href="{{route('index')}}" style="display: inline-block;">
                    <img width="200" src="https://img.veryfriendlysharks.co.uk/file_XkmW26pUb" class="logo" alt="VFS logo">
                </a>
            </td>
        </tr>
        <tr>
            <td style="text-align: center;font-size: 25px;padding-top: 20px;">
                <h3 style="color: #5da3dc;">ACCOUNT EDITED BY ADMIN - VERY FRIENDLY SHARKS</h3>
            </td>
        </tr>
        <tr>
            <td style="text-align: center;font-size: 20px;">
                <h4 style="color: #5da3dc;">Hello {{$data['user_name']}}! your account info is edited by the admin.</h4>
            </td>
        </tr>
        <tr>
            <td style="text-align: center;">
               <p><span style="font-weight: 700;">First Name:</span>{{$data['first_name']}}</p>
            </td>
        </tr>
        <tr>
            <td style="text-align: center;">
               <p><span style="font-weight: 700;">Last Name:</span>{{$data['last_name']}}</p>
            </td>
        </tr>
        <tr>
            <td style="text-align: center;">
               <p><span style="font-weight: 700;">User Name:</span>{{$data['user_name']}}</p>
            </td>
        </tr>
        <tr>
            <td style="text-align: center;">
               <p><span style="font-weight: 700;">Date of Birth:</span>{{$data['dob']}}</p>
            </td>
        </tr>
        <tr>
            <td style="text-align: center;">
               <p><span style="font-weight: 700;">Referral Limit:</span>{{$data['referal_limit']}}</p>
            </td>
        </tr>
        <tr>
            <td style="text-align: center;">
               <p><span style="font-weight: 700;">Referral Percentage:</span>{{$data['referal_percentage']}}</p>
            </td>
        </tr>
        <tr>
            <td style="justify-content: center;text-align: center; padding-top: 15px;padding-bottom: 15px;">
                <a  href="{{getPagesRoute('sell-cards')}}" style="-webkit-text-size-adjust: none; border-radius: 4px;color: #fff; display: inline-block;overflow: hidden;text-decoration: none; background-color: #2d3748;border-bottom: 8px solid #2d3748;border-left: 18px solid #2d3748;border-right: 18px solid #2d3748;border-top: 8px solid #2d3748;">Guides</a>
            </td>
        </tr>
        <tr>
            <td style="text-align: center;">
                Any problems?
            </td>
        </tr>
        <tr>
            <td style="text-align: center;">
                If you have questions about our platform, you can read through our support articles here. If you have any problems, you can contact us by clicking the button below.
            </td>
        </tr>
        <tr>
            <td style="justify-content: center;text-align: center; padding-top: 15px;padding-bottom: 15px;">
                <a  href="{{route('faqs')}}" style="-webkit-text-size-adjust: none; border-radius: 4px;color: #fff; display: inline-block;overflow: hidden;text-decoration: none; background-color: #2d3748;border-bottom: 8px solid #2d3748;border-left: 18px solid #2d3748;border-right: 18px solid #2d3748;border-top: 8px solid #2d3748;">Contact Us</a>
            </td>
        </tr>
        <tr>
            <td style="text-align: center;">
                Regards,
            </td>
        </tr>
        <tr>
            <td style="text-align: center;padding-bottom: 15px;">
                Very Friendly Sharks
            </td>
        </tr>
        <tr>
            <td></td>
        </tr>
        <tr style="background: #001d35;">
            <td style="justify-content: center;text-align: center; padding-top: 15px;">
                <a  target="blank" href="https://www.facebook.com/VeryFriendlySharks" >
                    <img   src="https://img.veryfriendlysharks.co.uk/file_AOKQhh7yJ" alt="">
                </a>
                <a  target="blank" href="https://twitter.com/SharksVery">
                    <img class="mt-4px" src="https://img.veryfriendlysharks.co.uk/file_r4CuVbiJp" alt="">
                </a>
            </td>
        </tr>
        <tr style="background: #001d35;">
            <td style="justify-content: center;text-align: center;">
                <a href="{{route('index')}}" style="display: inline-block;">
                    <img width="200" src="https://img.veryfriendlysharks.co.uk/file_XkmW26pUb" class="logo" alt="VFS logo">
                </a>
            </td>
        </tr>
        <tr style="background: #001d35;">
            <td style="justify-content: center;text-align: center; color: white; padding-bottom: 15px;">
                © 2021 - {{now()->format('Y')}}  Very Friendly Sharks Ltd
            </td>
        </tr>
    </table>
    
</body>
</html>