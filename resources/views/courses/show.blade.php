@extends('layouts.app')
@section('content')
<div class="container">
	<div class="course">
		<div class="course__header">
			<div class="course__header_theme">{{ $course->category->title }}</div>
			<div class="course__header_title">{{ $course->title }}</div>
            <div class="course__header_rating"><img src="/images/{{ $course->rating }}-star.png"></div>
		</div>
		<div class="course__tab">
			<a href="#description">Описание курса </a>
			@if(count($course->files))
			<a href="#files">Файлы <sup>{{ count($course->files) }}</sup></a>
			@endif
		</div>
		<div class="course__content" id="description">
			<h2 class="title">{{ $course->title }}</h2>
			<div class="course__content_text">
				{!! $course->content !!}
			</div>
		</div>
		@if(count($course->files))
		<div class="course__files" id="files">
			<div class="title">Файлы</div>
			<ul>
				@foreach($course->files as $file)
					@if($file->is_video)
					<li class="js-popup file__video" data-target="video" data-src="{{ url($file->path) }}" data-title="{{ $file->title }}">{{ $file->title }} <a href="#" onclick="event.preventDefault()"><img src="{{ url('/icons/download.svg') }}"> Смотреть</a> </li>
					@else
					<li>{{ $file->title }} <a href="{{ url($file->path) }}" target="_blank"><img src="{{ url('/icons/download.svg') }}"> Скачать</a> </li>
					@endif
				@endforeach
			</ul>
		</div>
		@endif
	</div>
</div>

<div class="popup__wrapper" id="video">
	<div class="popup popup__video">
		<div class="popup__header">
			<img src="{{ url('/icons/close.svg') }}" onclick="closePopup()">
		</div>
		<div class="popup__title"></div>
		<div class="popup__desc"></div>
		<div class="popup__content">
			<video src="" controls="controls"></video>
		</div>
	</div>
</div>
@endsection
@push('styles')
	<link rel="stylesheet" type="text/css" href="/css/course.css">
@endpush
@push('scripts')
<script>
	document.addEventListener('click', function(e) {
		if(e.target.closest('.file__video')) {
			document.querySelector('#video video').setAttribute('src', e.target.closest('.file__video').getAttribute('data-src'));
			document.querySelector('#video .popup__title').innerText = e.target.closest('.file__video').getAttribute('data-title');
		}
	})
</script>
@endpush
