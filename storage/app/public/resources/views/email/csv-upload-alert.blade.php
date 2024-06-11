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
                <h3 style="color: #5da3dc;">CSV UPLOADED - VERY FRIENDLY SHARKS</h3>
            </td>
        </tr>
        <tr>
            <td style="text-align: center;font-size: 20px;">
                <h4 style="font-weight: 200;" >Dear {{$data['user_name']}}, {{$data['csv']->status == 'Failed' ? 'Your CSV file has some issue please check your file again and match all things with our platform record.' : 'Your CSV file has been uploaded successfully.'}} </h4>
            </td>
        </tr>
        <tr>
            <td style="text-align: center;">
               <p style="font-weight: 700;"><span style="font-weight: 300;">Total Items Found: </span>{{$data['csv']->total}}</p>
            </td>
        </tr>
        <tr>
            <td style="text-align: center;">
               <p style="font-weight: 700;"><span style="font-weight: 300;">Items Added to your collection: </span> {{$data['csv']->success}}</p>
            </td>
        </tr>
        <tr>
            <td style="text-align: center;">
               <p style="font-weight: 700;"><span style="font-weight: 300;">Items Failed to match with our record: </span> {{$data['csv']->total - $data['csv']->success }}</p>
            </td>
        </tr>
        <tr>
            <td style="justify-content: center;text-align: center; padding-top: 15px;padding-bottom: 15px;">
                <a  href="{{route('user.collection.index','single')}}" style="-webkit-text-size-adjust: none; border-radius: 4px;color: #fff; display: inline-block;overflow: hidden;text-decoration: none; background-color: #2d3748;border-bottom: 8px solid #2d3748;border-left: 18px solid #2d3748;border-right: 18px solid #2d3748;border-top: 8px solid #2d3748;">My Collections</a>
            </td>
        </tr>
         <tr>
            <td style="text-align: center;">
                Thank you for being a valued member of our community!
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