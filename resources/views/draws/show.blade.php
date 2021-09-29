@extends('layouts.app')
@section('content')
<div class="container">
	<div class="draw">
		<div class="draw__img">
                        <img src="/{{ $draw->image }}">
		</div>

		<div class="draw__container">
			<div class="draw__header">
				<div class="draw__header_title">{{ $draw->title }}</div>
			</div>
			<div class="draw__prize">
				{{ $draw->prize }} ₽
			</div>
			<div class="draw__item_date">
				<img src="{{ url('/icons/calendar.svg') }}">
				до {{ $draw->end_date }}
			</div>
			<div class="draw__content">
				{!! $draw->extras !!}
			</div>
		</div>

	</div>

	<div class="draw__item_link">
		<a href="{{ $draw->link }}" class="button main-button small-button">Подробнее</a>
	</div>
</div>

@endsection
@push('styles')
	<link rel="stylesheet" type="text/css" href="/css/welcome.css">
@endpush
