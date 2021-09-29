<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Wingifts</title>
</head>
<body style="margin:0; padding:0; font: 14px Arial,sans-serif; line-height: 21px; color: #4F4F4F; background: #F1F1F1">
    <table border="0" cellpadding="0" cellspacing="0" style="margin:0 auto; padding:0; max-width: 600px; width: 100%; font: 14px Arial,sans-serif; line-height: 21px; color: #4F4F4F; background: #F8FCFE">
        @include('emails.layouts.header')

        @yield('content')
        
        <tr>
            <td style="padding-bottom: 50px;"></td>
        </tr>
    </table>
    <table border="0" cellpadding="0" cellspacing="0" style="margin:0 auto; padding:0; max-width: 600px; width: 100%; font: 14px Arial,sans-serif; line-height: 21px; color: #4F4F4F; background: #FFFFFF">
        <tr>
            <td style="padding-top: 20px;"></td>
        </tr>

		@include('emails.layouts.footer')

		@include('emails.layouts.oferta')
		
		<tr>
            <td style="padding-top: 20px;"></td>
        </tr>
    </table>
</body>
</html>