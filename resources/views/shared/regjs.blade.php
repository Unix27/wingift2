@push('styles')
	<link rel="stylesheet" type="text/css" href="/css/auth.css">
	<style>
		.error__text {
			display: none;
		}
		.error .error__text {
			display: block;
		}
	</style>
@endpush

@push('scripts')
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.inputmask/5.0.5/jquery.inputmask.min.js"></script>
<!-- 	<script src="/js/card.js"></script> -->
	<script src="https://widget.cloudpayments.ru/bundles/checkout"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/card/2.5.0/card.min.js"></script>
	<script>
		const public_id = "{{ config('services.cloud_payments.public_id') }}";
	</script>
	<script src="{{ asset('js/auth/register.js') }}"></script>
@endpush
