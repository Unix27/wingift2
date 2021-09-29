@push('styles')
	<link rel="stylesheet" type="text/css" href="/css/auth.css">
	<style>
		.error__text {
			display: none;
		}
		.input.error .error__text {
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
		document.addEventListener('DOMContentLoaded', function(){
			$('#card-number').inputmask({"mask": "9999 9999 9999 9999"});
			$('#card-expiry').inputmask({"mask": "99/99"});
			$('#card-cvc').inputmask({"mask": "999"});
			new Card({
			    form: document.querySelector('#form'),
			    container: '.card__wrapper',
			    formatting: true,
			});
		});
		

// TRANSLITERATION FUNCTION	
this.rus_to_latin = function(str) {

var ru = {
		'а': 'a', 'б': 'b', 'в': 'v', 'г': 'g', 'д': 'd', 
		'е': 'e', 'ё': 'e', 'ж': 'j', 'з': 'z', 'и': 'i', 
		'к': 'k', 'л': 'l', 'м': 'm', 'н': 'n', 'о': 'o', 
		'п': 'p', 'р': 'r', 'с': 's', 'т': 't', 'у': 'u', 
		'ф': 'f', 'х': 'h', 'ц': 'c', 'ч': 'ch', 'ш': 'sh', 
		'щ': 'shch', 'ы': 'y', 'э': 'e', 'ю': 'u', 'я': 'ya'
}, n_str = [];

str = str.replace(/[ъь]+/g, '').replace(/й/g, 'i');

for ( var i = 0; i < str.length; ++i ) {
	 n_str.push(
					ru[ str[i] ]
			 || ru[ str[i].toLowerCase() ] == undefined && str[i]
			 || ru[ str[i].toLowerCase() ].toUpperCase()
	 );
}

return n_str.join('');
}

$('#card-expiry').change(function(e) {
    let val = this.value.split('/');
    $('input[data-cp="expDateMonth"]').val(val[0]);
    $('input[data-cp="expDateYear"]').val(val[1]);
});

$('#card-number').change(function(e) {
    $('input[data-cp="cardNumber"]').val(this.value);
});

$('#card-cvc').change(function(e) {
    console.log(this.value);
    $('input[data-cp="cvv"]').val(this.value);
});

$('#name').change(function(e) {
    $('input[data-cp="name"]').val(this.value);
});

$('.button-continue').click((e) => {


	var phoneInput = $('input[name="phone"]').val();

	var emailInput = $('input[name="email"]').val();
    
    if(phoneInput.length < 6) {
        $('.input_phone .error__text').text('Введите свой телефон');
        $('.input_phone').addClass('error');
        return;
    } else if(emailInput.length < 4) {
        $('.input_email .error__text').text('Введите свой email-адрес');
        $('.input_email').addClass('error');
        return;
    } else if(emailInput.indexOf('@') === -1 || emailInput.indexOf('@') === emailInput.length - 1) {
        $('.input_email .error__text').text('Неверный формат email-адреса');
        $('.input_email').addClass('error');
        return;
    } else {
        let data = {
	        email: emailInput
        };
        $.ajax({
            url: 'https://wingift.org/api/cloudPayments/is_subscribed',
            data: data,
            type: 'POST'
        }).done(function (response) {
        	$('.input_email').removeClass('error');
        	$('.first-step').hide();
					$('.second-step').show();
        }).fail(function (response) {
	        console.log(response);
            $('.input_email .error__text').text(response.responseJSON.error);
            $('.input_email').addClass('error');
        });
		}
		
    // TRANSLITERATION FIELDS
    let card_owner = rus_to_latin(document.querySelector('input[name=firstname]').value);
    let card_owner2 = rus_to_latin(document.querySelector('input[name=lastname]').value);
    
    // SET VALUE TO CARD NAME FIELD
    document.querySelector('#name').value = card_owner;
    document.querySelector('#lastname').value = card_owner2;
    
    // SET VALUE TO CARD NAME HIDDEN INPUT
    $('input[data-cp="name"]').val(card_owner);
    $('input[data-cp="lastname"]').val(card_owner2);
    
    // WRITE NAME TO CARD IMAGE
    if(document.querySelector('#name').value)
	document.querySelector('.jp-card-name').textContent = document.querySelector('#name').value + ' ' + document.querySelector('#lastname').value;
});

$(document).on("click", ".button-submit", function (e) {
    console.log(e);
		e.preventDefault();
		
    /* Создание checkout */
    var checkout = new cp.Checkout(
        // public id из личного кабинета
        'pk_44e5bb5c25c802f9dcb57f9e48b4e',
        // тег, содержащий поля данных карты
        document.getElementById("form"));
        createCryptogram(checkout);
});

window.order_cost = 1;
var createCryptogram = function (checkout) {
    var result = checkout.createCryptogramPacket();
    $('.input__wrapper.error').each(function() {
        $(this).removeClass('error');
    });
    
    console.log(result);

    if (result.success) {
        // сформирована криптограмма
        var email = '', phone = '';
        if ($('#checkSms').is(':checked')) {
            phone = $('#tel').val();
        } else {
            email = $('#email').val();
        }
        var data = {
            action: 'sendCryptogram',
            CardCryptogramPacket: result.packet,
            name: $('#name').val(),
            lastname: $('#lastname').val(),
            email: email,
            accountId: email,
            phone: phone,
            amount: 1.00,
            currency: 'RUB',
            PublicID: 'pk_44e5bb5c25c802f9dcb57f9e48b4e',
            APISecret: '5226c78433e95b954c1b3ffde7e6f6c7'
        };
        $.ajax({
            url: 'https://api.cloudpayments.ru/payments/cards/charge',
            data: data,
            type: 'post',
            dataType: 'json'
        }).done(function (response) {
            if (response['Success']) {
                window.location.href = response['success_url']
            }
            else {
                
                if (response.Model.AcsUrl) {
                    $('#secure input[name="MD"]').val(response.Model.TransactionId);
                    $('#secure input[name="PaReq"]').val(response.Model.PaReq);
                    $('#secure input[name="TermUrl"]').val(document.location.origin);
                    $('#secure').attr('action', response.Model.AcsUrl);
                    $('#secure').submit();
                } else {
                    console.error(response);
                    alert('Произошла ошибка при оплате');
                }
            }
        });
    } else {
        Object.keys(result.messages).forEach(function(key) {
            $('.input__wrapper_' + key + ' .error__text').text(result.messages[key]);
            $('.input__wrapper_' + key).addClass('error');
        });
    }
};

	</script>
@endpush

