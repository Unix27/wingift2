@php
	$login = isset($login)? $login: null;
	$password = isset($password)? $password: null;
@endphp
@extends('emails.layouts.email')
@section('content')        
        <tr>
            <td style="font: 18px Arial,sans-serif; line-height: 21px; color: #000; padding: 40px 0px 30px 20px;">
                <b style="-webkit-text-size-adjust:none; font-size: 18px; margin: 0px; display: block; color: #000;">Здравствуйте{{ $login? ', ' . $login: '' }}!</b>
            </td>
        </tr>

        <tr>
            <td style="font: 14px Arial,sans-serif; line-height: 21px; color: #4F4F4F; padding: 0px 0px 20px 20px;">
                Вы зарегестрированы на сайте <a href="{{ url('/') }}" style="color:#969BF3; text-decoration: none;">wingift.org</a>
            </td>
        </tr>


        <tr>
            <td style="font: 14px Arial,sans-serif; line-height: 21px; Margin: 0;margin: 0; padding: 0px 0px 20px 20px;">
                <b>WINGIFT</b> – сервис созданный командой разработчиков, которые объединились с целью сделать розыгрыши в соц. сетях максимально честными и прозрачными.
            </td>
        </tr>
        
        <tr>
            <td style="font: 14px Arial,sans-serif; line-height: 21px; color: #4F4F4F; padding: 0px 0px 20px 20px;">
                Подробнее о нас вы сможете узнать <a href="{{ url('/') }}" style="color:#969BF3; text-decoration: none;">на сайте</a>
            </td>
        </tr>

        <tr>
            <td style="font: 14px Arial,sans-serif; line-height: 21px; Margin: 0;margin: 0; padding: 0px 0px 20px 20px;">
                Ваши данные для входа в личный кабинет:
            </td>
        </tr>

        <tr>
            <td style="font: 14px Arial,sans-serif; line-height: 21px; Margin: 0;margin: 0; padding: 0px 0px 10px 0px; text-align: center;">
                Логин: <b style="color:#000000;">{{ $login }}</b>
            </td>
        </tr>

        <tr>
            <td style="font: 14px Arial,sans-serif; line-height: 21px; Margin: 0;margin: 0; padding: 0px 0px 20px 0px; text-align: center;">
                Пароль: <b style="color:#000000;">{{ $password }}</b>
            </td>
        </tr>
        
        <tr>
            <td style="font: 14px Arial,sans-serif; line-height: 21px; Margin: 0;margin: 0;">
                <a href="{{ url('/login') }}" style="display: block; width: 180px; height: 40px; line-height: 40px; white-space: nowrap; color:#fff; text-align: center; background-color: #FF8016; border-radius: 7px; text-decoration: none; margin: 0 auto;">Перейти на сайт</a>
            </td>
        </tr>
@endsection
        