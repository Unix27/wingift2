@extends('layouts.land')

@section('content')
<div class="container land">

<div class="blogger__figure_tablet">
	<img src="/{{ $draw->land_image }}">
</div>

<div class="blogger__figure_mobile">
	<img src="/{{ $draw->land_image }}">
</div>
			  
<div class="main">
	<div class="content__wrapper">
		<div class="container money__wrapper">
			<div class="money-large">
				<div class="winners_wrapper">
					<div class="winners__count">30+</div>
					<div class="winners__label">победителей</div>
				</div>
				<div class="money-large__main">{{ $draw->prize }} <sub>₽</sub></div>
				<div class="money-large__stroke">{{ $draw->prize }} <sub>₽</sub></div>
			</div>
		</div>
		
		
	</div>
	<div class="blogger__figure">
		<img src="/{{ $draw->land_image }}">
	</div>
</div>


<div class="countdown__wrapper countdown-mobile countdown-new">
        @include('draws.countdown')
</div>

@include('shared.reg')
		
<!-- 		common text -->
<div class="text__wrapper">
	{!! $draw->land_text !!}
</div>

<div class="countdown__wrapper countdown-desktop countdown-new">
        @include('draws.countdown')
</div>

<div class="decors__wrapper">
	<img src="/images/land_d1.png" class="decor d1">
	<img src="/images/land_d2.png" class="decor d2">
	<img src="/images/land_d3.png" class="decor d3">
	<img src="/images/land_d4.png" class="decor d4">
	<img src="/images/land_d5.png" class="decor d5">
	<img src="/images/land_d6.png" class="decor d6">
	<img src="/images/land_d7.png" class="decor d7">
	<img src="/images/land_d7.png" class="decor d8">
	<img src="/images/land_d9.png" class="decor d9">
</div>



</div>

@endsection


@include('shared.regjs')


@push('styles')
	<link rel="stylesheet" type="text/css" href="/css/land.css?v=4.2">
@endpush

