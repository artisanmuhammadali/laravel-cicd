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
                <h3 style="color: #5da3dc;">ORDER #{{$data['order']->id}} id REFUND CONFIRMATION - VERY FRIENDLY SHARKS</h3>
            </td>
        </tr>
        <tr>
            <td style="text-align: center;font-size: 20px;">
                <h4 style="color: #5da3dc;">Hello {{$data['order']->buyer->user_name}}, we just wanted to let you know that</h4>
            </td>
        </tr>
        
        <tr>
            <td style="text-align: center;">
              The following refund has now been issued and placed back into you Very Friendly Sharks wallet:
            </td>
        </tr>
        <tr>
            <td style="text-align: center;">
               <p><span style="font-weight: 700;">Order Id:</span>{{$data['order']->id}}</p>
            </td>
        </tr>
        <tr>
            <td style="text-align: center;">
               <p><span style="font-weight: 700;">Order Quantity:</span>{{$data['order']->detail->sum('quantity')}}</p>
            </td>
        </tr>
        <tr>
            <td style="text-align: center;">
               <p><span style="font-weight: 700;">Order Price:</span>£ {{$data['order']->total}}</p>
            </td>
        </tr>
        <tr>
            <td style="text-align: center;">
               <p><span style="font-weight: 700;">Seller Fullname:</span>{{$data['order']->seller->full_name}}</p>
            </td>
        </tr>
        <tr>
            <td style="text-align: center;padding-bottom: 20px;">
               <p><span style="font-weight: 700;">Buyer Fullname:</span>{{$data['order']->buyer->full_name}}</p>
            </td>
        </tr>
        <tr>
            <td style="text-align: center;padding-bottom: 20px;">
               <p><span style="font-weight: 700;">Refund Amount:</span>£ {{$data['refund']}}</p>
            </td>
        </tr>
            @include('email.order.components.order-detail')
        <tr>
            <td style="text-align: center;">
                 We’re sorry to see that you’ve had issues with your order but happy to know that the seller has your back. You can check the order details by clicking the button below.
            </td>
        </tr>
        <tr>
            <td style="text-align: center;">
                 Also, while we have you here, did you know whale sharkshave unique spot patterns? 🦈They as unique as fingerprints.
            </td>
        </tr>
        <tr>
            <td style="justify-content: center;text-align: center; padding-top: 15px;padding-bottom: 15px;">
                <a  href="{{route('user.order.detail',[$data['order']->id ,'buy'])}}" style="-webkit-text-size-adjust: none; border-radius: 4px;color: #fff; display: inline-block;overflow: hidden;text-decoration: none; background-color: #2d3748;border-bottom: 8px solid #2d3748;border-left: 18px solid #2d3748;border-right: 18px solid #2d3748;border-top: 8px solid #2d3748;">Order Details</a>
            </td>
        </tr>
        <tr>
            <td style="text-align: center;">
                Make sure to check our guides if you have questions about your refund
            </td>
        </tr>
        <tr>
            <td style="text-align: center;">
              Please check out our community guidelines and FAQs to ensure you have smooth sailing in our waters; heh, get it?
            </td>
        </tr>
        <tr>
            <td style="justify-content: center;text-align: center; padding-top: 15px;padding-bottom: 15px;">
                <a  cellpadding="1" href="{{getPagesRoute('sell-cards')}}" style="-webkit-text-size-adjust: none; border-radius: 4px;color: #fff; display: inline-block;overflow: hidden;text-decoration: none; background-color: #2d3748;border-bottom: 8px solid #2d3748;border-left: 18px solid #2d3748;border-right: 18px solid #2d3748;border-top: 8px solid #2d3748;">Community Guides</a>
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