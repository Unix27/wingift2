@push('styles')
	<link rel="stylesheet" type="text/css" href="/css/courses.css">	
@endpush
@push('scripts')
	<script>
		var category = @json($category);
		var categories = @json($categories);
	</script>
	<script type="text/javascript" src="{{ asset('js/manifest.js') }}"></script>
	<script type="text/javascript" src="{{ asset('js/courses/courses.js') }}"></script>
@endpush
