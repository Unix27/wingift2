@extends('emails.layouts.email')
@section('content')  
        <tr>
            <td style="font: 18px Arial,sans-serif; line-height: 21px; color: #000; padding: 40px 0px 30px 20px;">
                <b style="-webkit-text-size-adjust:none; font-size: 18px; margin: 0px; display: block; color: #000;">Не переживайте, мы выполним сброс пароля</b>
            </td>
        </tr>

        <tr>
            <td style="font: 14px Arial,sans-serif; line-height: 21px; color: #4F4F4F; padding: 0px 0px 20px 20px;">
                Здравствуйте{{ $login? ', ' . $login: '' }}
            </td>
        </tr>
        

        <tr>
            <td style="font: 14px Arial,sans-serif; line-height: 21px; color: #4F4F4F; padding: 0px 0px 20px 20px;">
                Вы запросили сброс пароля для этого аккаунта:
                <br>
                <span style="color:#969BF3">{{ $email }}</span>
            </td>
        </tr>


        <tr>
            <td style="font: 14px Arial,sans-serif; line-height: 21px; color: #4F4F4F; padding: 0px 0px 20px 20px;">
              Чтобы изменить пароль, нажмите кнопку ниже
            </td>
        </tr>
        
        <tr>
            <td style="font: 14px Arial,sans-serif; line-height: 21px; Margin: 0;margin: 0;">
                <a href="{{ $url }}" style="display: block; width: 180px; height: 40px; line-height: 40px; white-space: nowrap; color:#fff; text-align: center; background-color: #FF8016; border-radius: 7px; text-decoration: none; margin: 0 auto;">Cбросить пароль</a>
            </td>
        </tr>
@endsection