<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>Wingifts</title>
    		<link rel="shortcut icon" href="{{ url('images/favicon.ico') }}" type="image/x-icon">

        <!-- Fonts -->
<!--         <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet"> -->
		
       @stack('styles')
    </head>
    <body>
        <div id="app">
            @include('layouts.header')
            
            @yield('content')
            
            @include('layouts.footer')
        </div>
    </body>
		
	<script>
		var subscribed = @json($subscribed);
		var logged = @json($user);
	</script>
	@stack('scripts')
</html>
<script>
	function closePopup(){
		var popup = document.querySelectorAll('.popup__wrapper.active')[0];
		popup.classList.remove('active');
		
		var html = document.getElementsByTagName('html')[0];
		html.classList.remove('overflow');
	}		

	function initPopupEvents(){

		document.addEventListener('click', function(event) {
			if(event.target.closest('.js-popup')) {
					let element = event.target.closest('.js-popup');
			    let target = element.dataset.target;
			    
			    openPopup(target);
			}
		})
		
	}
	function openPopup(id) {
		let popup = document.getElementById(id);
			    popup.classList.add('active');
			    
    			var html = document.getElementsByTagName('html')[0];
					html.classList.add('overflow');
	}
	@if(session()->has('thanks'))
		openPopup('thanks');
	@endif
	
	@if(session()->has('thanks-feedback'))
		openPopup('thanks-feedback');
	@endif

	@if($errors->has('feedback_phone') || $errors->has('feedback_name') || $errors->has('feedback_email'))
		openPopup('feedback');
	@endif
	
	initPopupEvents();
</script>