@push('styles')
	<link rel="stylesheet" type="text/css" href="/css/auth.css">
@endpush
@push('scripts')
	<script src="https://cdnjs.cloudflare.com/ajax/libs/card/2.5.0/card.min.js"></script>
	<script>
		document.addEventListener('DOMContentLoaded', function(){
			new Card({
			    form: document.querySelector('#form'),
			    container: '.card__wrapper',
			    formatting: true,
			});
		});


	</script>
@endpush
