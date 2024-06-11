<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    
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
                <h3 style="color: #5da3dc;">SUPPORT TICKET {{$data['desk_id']}} - VERY FRIENDLY SHARKS</h3>
            </td>
        </tr>
        <tr>
            <td style="text-align: center;font-size: 15px;">
                <h4>Hello!</h4>
            </td>
        </tr>
        <tr>
            <td style="text-align: center;font-size: 15px;">
                <h4> Dear {{$data['username']}},</h4>
            </td>
        </tr>
        <tr>
            <td style="text-align: center;">
               Hello, we’re sorry to hear you’re having some problems. We’ve received the ticket below and one of our support sharks 🦈 will be with you swiftly and promptly.
            </td>
        </tr>
        <tr>
            <td style="text-align: center;font-weight: 700;">
               Ticket Details:
            </td>
        </tr>
        <tr>
            <td style="text-align: center;">
               <p><span style="font-weight: 700;">Ticket Number:</span>{{$data['desk_id']}}</p>
            </td>
        </tr>
        <tr>
            <td style="text-align: center;">
               <p><span style="font-weight: 700;">Created By:</span> {{$data['email']}}</p>
            </td>
        </tr>
        <tr>
            <td style="text-align: center;">
               <p><span style="font-weight: 700;">Subject:</span>{{$data['subject']}}</p>
            </td>
        </tr>
        <tr>
            <td style="text-align: center;">
               <p><span style="font-weight: 700;">Date/Time:</span>{{$data['date']}}</p>
            </td>
        </tr>
        <tr>
            <td style="text-align: center;">
                While you’re waiting for your reply, you might be interested in having a look at our FAQs and our guidelines below.
            </td>
        </tr>
        <tr>
            <td style="justify-content: center;text-align: center; padding-top: 15px;padding-bottom: 15px;">
                <a  href="{{route('faqs')}}" style="-webkit-text-size-adjust: none; border-radius: 4px;color: #fff; display: inline-block;overflow: hidden;text-decoration: none; background-color: #2d3748;border-bottom: 8px solid #2d3748;border-left: 18px solid #2d3748;border-right: 18px solid #2d3748;border-top: 8px solid #2d3748;">FAQ's</a>
            </td>
        </tr>
        <tr>
            <td style="justify-content: center;text-align: center; padding-top: 15px;padding-bottom: 15px;">
                <a  href="{{getPagesRoute('sell-cards')}}" style="-webkit-text-size-adjust: none; border-radius: 4px;color: #fff; display: inline-block;overflow: hidden;text-decoration: none; background-color: #2d3748;border-bottom: 8px solid #2d3748;border-left: 18px solid #2d3748;border-right: 18px solid #2d3748;border-top: 8px solid #2d3748;">Guides</a>
            </td>
        </tr>
         <tr>
            <td style="text-align: center;">
                Thank you for using our application!
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