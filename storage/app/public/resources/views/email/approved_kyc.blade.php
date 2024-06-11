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
                Great news! Your KYC/KYB documents have been approved, and you're all set to start trading on Very
                Friendly Sharks. Your journey into the vast ocean of card trading begins now.
            </td>
        </tr>
        <tr>
            <td style="text-align: left;padding-top:10px">
                Before you dive in, please remember to pay for the successful verification of your account; without this
                fee, you cannot put your collection live.
            </td>
        </tr>
        <tr>
            <td style="text-align: left;;padding-top:10px">
                Very Friendly Sharks does not control this fee, as MANGOPAY, our Payment System Provider, forces it. But
                no worries. We will fully refund this amount to your credit from the sales you made on our website. Make
                sure to brush up on <a href="{{getPagesRoute('fees')}}">our fees</a> if you have any questions.
            </td>
        </tr>
        <tr>
            <td style="text-align: left;;padding-top:10px">
                We also recommend brushing up on our <a href="{{getPagesRoute('how-to-sell')}}">Seller's Guide </a> and our <a href="{{getPagesRoute('ccgs')}}">Counterfeit Card
                    Guide</a> to ensure smooth
                sailing ahead. And remember, keeping our waters safe is our top priority, so check out our <a
                    href="{{getPagesRoute('customer-protection')}}">Customer
                    Protection Practices </a> for a secure trading experience.
            </td>
        </tr>


        <tr>
            <td style="text-align: left;padding-top:20px">
                Happy trading, and welcome aboard! Best,
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
