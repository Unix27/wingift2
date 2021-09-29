<!DOCTYPE html>
<html>
<head lang="ru-RU">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <title>Win Gift - розыгрыши призов!</title>
    <link href="favicon.ico" rel="shortcut icon" type="image/x-icon">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
    <link rel="stylesheet" href="/land1/styles.css?v=3.6" />
    <link rel="preconnect" href="https://fonts.gstatic.com">
	<link href="https://fonts.googleapis.com/css2?family=Anton&display=swap" rel="stylesheet">
    <meta name="robots" content="noindex, nofollow" />
    <script src="https://widget.cloudpayments.ru/bundles/checkout"></script>
</head>
<body>
	<script>
	    document.addEventListener('DOMContentLoaded', function(){
	        $("a[href]").each(function(){if(document.domain==="start."+document.domain.replace("start.","")){var a=document.domain.replace("start.","");a=$(this).attr("href").replace("parimatch.com",a).replace("pari-match.com",a);$(this).attr("href",a)}});
	
	        function setCookie(a,c,b){var f=window.location.hostname.split(".").filter(function(a,b){return 0!==b}).join("."),e=new Date;e.setTime(e.getTime()+864E5*b);b="expires="+e.toUTCString();document.cookie=a+"="+c+";"+b+";path=/;domain=."+f}function findGetParameter(a){var c=null,b=[];location.search.substr(1).split("&").forEach(function(f){b=f.split("=");b[0]===a&&(c=decodeURIComponent(b[1]))});return c}
	        function insertParam(r,a,e){var n=new URL(e),t=n.search,s=new URLSearchParams(t);return s.set(r,a),n.search=s.toString(),n.toString()}
	        null!==findGetParameter("btag")&&setCookie("pm_btag",findGetParameter("btag"),3);null!==findGetParameter("qtag")&&setCookie("qtag",findGetParameter("qtag"),3);null!==findGetParameter("siteid")&&setCookie("pm_siteid",findGetParameter("siteid"),365);links = document.getElementsByTagName("a");
	        Array.prototype.forEach.call(links, function (c) {var a = c.href, b = "", e = window.location.hostname.split(".").filter(function (a, b) {return 0 !== b}).join(".");-1 !== a.indexOf("#") && (b = a.slice(a.indexOf("#"), a.length), a = a.slice(0, a.indexOf("#")));-1 !== a.indexOf(e) && (null !== findGetParameter("btag") && (a = insertParam("btag", findGetParameter("btag"), a)), null !== findGetParameter("qtag") && (a = insertParam("qtag", findGetParameter("qtag"), a)), null !== findGetParameter("siteid") && (a = insertParam("siteid", findGetParameter("siteid"), a)), null !== findGetParameter("utm") && (a = insertParam("utm", findGetParameter("utm"), a)), null !== findGetParameter("utm_source") && (a = insertParam("utm_source", findGetParameter("utm_source"), a)), null !== findGetParameter("utm_medium") && (a = insertParam("utm_medium", findGetParameter("utm_medium"), a)), null !== findGetParameter("utm_campaign") && (a = insertParam("utm_campaign", findGetParameter("utm_campaign"), a)), null !== findGetParameter("utm_content") && (a = insertParam("utm_content", findGetParameter("utm_content"), a)), 0 < b.length && (a += b), c.dataset.toggle || (c.href = a))});
	    });
	
	    (function(h,o,t,j,a,r){
	        h.hj=h.hj||function(){(h.hj.q=h.hj.q||[]).push(arguments)};
	        h._hjSettings={hjid:2178833,hjsv:6};
	        a=o.getElementsByTagName('head')[0];
	        r=o.createElement('script');r.async=1;
	        r.src=t+h._hjSettings.hjid+j+h._hjSettings.hjsv;
	        a.appendChild(r);
	    })(window,document,'https://static.hotjar.com/c/hotjar-','.js?sv=');
	</script>
	<div class="container">
<!-- 		header -->
		@include('land1.header')
		
		<div class="blogger__figure_tablet">
			<img src="/{{ $draw->land_image2 }}">
		</div>
		
		<div class="blogger__figure_mobile">
			<img src="/{{ $draw->land_image3 }}">
		</div>
					  
		<div class="main">
			<div class="content__wrapper">
				<div class="money__wrapper">
					<div class="money-large">
						<div class="winners_wrapper">
							<div class="winners__count">{{ $draw->land_count }}+</div>
							<div class="winners__label">победителей</div>
						</div>
						<div class="money-large__main">{{ $draw->prize }} <sub>₽</sub></div>
						<div class="money-large__stroke">{{ $draw->prize }} <sub>₽</sub></div>
					</div>
				</div>
				
				<div class="forms__wrapper">
<!-- 					STEP 1 FORM START -->
					<div class="form1" id="main-page-form1">
						<div class="form__title">Введите свои данные <br>и нажмите <span>продолжить!</span></div>
						<form class="form">
                            <div class="form__group">
                                <div class="input__wrapper input__wrapper_firstname">
                                    <input type="text" name="firstname" id='firstname' placeholder=" " class="form__input" required autocomplete="off">
                                    <span class="custom-placeholder">Имя</span>
					@include('land1.icons_user')
                                    <span class="error__text"></span>
                                </div>
                                <div class="input__wrapper input__wrapper_lastname">
                                    <input type="text" name="lastname" id='lastname' placeholder=" " class="form__input" required autocomplete="off">
                                    <span class="custom-placeholder">Фамилия</span>
					@include('land1.icons_user')
                                    <span class="error__text"></span>
                                </div>
                            </div>
                            <div class="form__group" style='margin-top: 22px'>
	                            <div class="input__wrapper input__wrapper_phone">
	                                <input id="phone" type="phone" name="phone" placeholder=" " class="form__input" required autocomplete="off">
	                                <span class="custom-placeholder">Телефон</span>
						@include('land1.icons_input_phone')
	                                <span class="error__text">Введите свой телефон</span>
        	                    </div>
	                            <div class="input__wrapper input__wrapper_email">
	                                <input id="email" type="email" name="email" placeholder=" " class="form__input" required autocomplete="off">
	                                <span class="custom-placeholder">E-mail</span>
						@include('land1.icons_mail')
	                                <span class="error__text">Введите свой email-адрес</span>
        	                    </div>
                            </div>
							
							<div class="form__footer">
	                            <div class="home__terms">
		                            Нажимая кнопку “Продолжить” <br>и “Принять участие” вы соглашаетесь <br>с <a href="#" onclick="openModal(this)" data-target="modalTerms">Публичная оферта</a>
	                            </div>
	                            <button type="button" class="button button-continue button-blank">Продолжить</button>
	                            <div class="button__blur"></div>
							</div>
                        </form>
					</div>
<!-- 					STEP 1 FORM END -->					
<!-- 					STEP 2 FORM START -->					
					<div class="form2" id="main-page-form2">
                        <p class="form__title">Подтвердить участие</p>
                        <p class="form__desc">Вам нужно ввести данные карты для того, чтобы мы подтвердили Вашу личность и закрепили за Вами участие в розыгрыше. Будет списан 1 руб с Вашей карты и сразу возмещён обратно</p>
                        <div class="card-form__wrapper">
	                        <div class="card-wrapper"></div>
	                        <form id="form" action="" class="form">
	                            <div class="input__wrapper input__wrapper_name">
	                                <input type="hidden" data-cp="name">
	                                <input type="text" id="name" name="name" placeholder=" " class="form__input input-name" required>
	                                <span class="custom-placeholder">Имя и фамилия</span>
					@include('land1.icons_mail')
	                                <span class="error__text"></span>
	                            </div>
	                            <div class="input__wrapper input__wrapper_cardNumber">
	                                <input type="hidden" data-cp="cardNumber">
	                                <input id="card-number" type="text" name="number" class="form__input" placeholder=" ">
	                                <span class="custom-placeholder">Номер банковской карты</span>
					@include('land1.icons_card')
	                                <span class="error__text"></span>
	                            </div>
	                          <div class="form__group">
	                            <div class="input__wrapper input__wrapper_expDateMonth input__wrapper_expDateYear">
	                                <input type="hidden" data-cp="expDateMonth">
	                                <input type="hidden" data-cp="expDateYear">
	                                <input id="card-expiry" type="text" name="expiry" class="form__input" placeholder=" ">
	                                <span class="custom-placeholder">ММ/ГГ</span>
					@include('land1.icons_calendar')
	                                <span class="error__text"></span>
	                            </div>
	
	                            <div class="input__wrapper input__wrapper_cvv">
	                                <input type="hidden" data-cp="cvv">
	                                <input id="card-cvc" type="text" name="cvc" class="form__input" placeholder=" ">
	                                <span class="custom-placeholder">CVV</span>
					@include('land1.icons_cvv')
	                                <span class="error__text"></span>
	                            </div>
	                          </div>
	                        </form>
                        </div>
                        <button type="button" class="button button-submit">Принять участие</button>
                    </div>
<!-- 					STEP 2 FORM END -->
				</div>
				
			</div>
			<div class="blogger__figure">
				<img src="/{{ $draw->land_image }}">
			</div>
		</div>


		<div class="countdown__wrapper countdown-mobile">
			@include('land1.countdown')
		</div>
				
<!-- 		common text -->
		<div class="text__wrapper">
			{!! $draw->land_text !!}
		</div>
<!-- 		footer -->
		@include('land1.footer')

		<div class="countdown__wrapper countdown-desktop">
			@include('land1.countdown')
		</div>
		
		<div class="decors__wrapper">
			<img src="/land1/images/d1.png" class="decor d1">
			<img src="/land1/images/d2.png" class="decor d2">
			<img src="/land1/images/d3.png" class="decor d3">
			<img src="/land1/images/d4.png" class="decor d4">
			<img src="/land1/images/d5.png" class="decor d5">
			<img src="/land1/images/d6.png" class="decor d6">
			<img src="/land1/images/d7.png" class="decor d7">
			<img src="/land1/images/d7.png" class="decor d8">
			<img src="/land1/images/d9.png" class="decor d9">
		</div>
	</div>
	<a href="#" onclick="openModal(this)" class="thanks-button" data-target="modalThanks" style="display: none"></a>
	<a href="#" onclick="openModal(this)" class="fail-button" data-target="modalFail" style="display: none"></a>
	
	<form name="secure" id="secure" action="" method="POST">
    <input type="hidden" name="PaReq" value="">
    <input type="hidden" name="MD" value="">
    <input type="hidden" name="TermUrl" value="">
	</form>
	<form action="https://api.cloudpayments.ru/payments/cards/post3ds" id="post3ds" method="POST">
	    <input type="hidden" name="PaRes" value="">
	    <input type="hidden" name="TransactionId" value="">
	</form>
</body>
	@include('land1.modals')
<!--
<script src="land1/modernizr-custom.js"></script>
<script src="land1/vendor.js"></script>
-->
<script src="/land1/bundle.js"></script>
<script src="/land1/card.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.inputmask/5.0.5/jquery.inputmask.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.2/jquery.validate.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/card/2.5.0/card.min.js"></script>

<script src="/land1/scripts.js?v=2.1"></script>
<script>

@php
	if($paymentSuccess) 
	{
		echo "localStorage.clear();";
        	echo "$('.thanks-button').click();";
    	} 
	elseif ($paymentSuccess !== null && $paymentSuccess == false) 
	{
    		echo "$('.fail-button').click()";
	} 
@endphp
</script>
</html>
