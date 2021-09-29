// LOCALSTORAGE
this.storeInputs = function(){
    var inputs = document.getElementsByTagName('input');
    console.log(localStorage);
	
	Array.prototype.forEach.call(inputs, function(item){
		item.addEventListener('keyup', function(event){
			let inputName = event.target.name;
			let inputValue = event.target.value;
			
			if(inputName !== '_hjid')
				localStorage.setItem(inputName, inputValue);
		});
  	});
}

storeInputs();

this.setInputs = function(){
	var inputs = getStorage();

	for(var name in inputs){
	    var inp = document.querySelector('input[name=' + name + ']');
	    if (inp) inp.value = inputs[name];
	}
}
setInputs();

function getStorage() {

    var values = [],
        keys = Object.keys(localStorage),
        i = keys.length;

    while ( i-- ) {
	    if(keys[i] !== '_hjid' && keys[i] !== 'gifterWait' && keys[i] !== 'gifterCountdown')
        	values[keys[i]] = localStorage.getItem(keys[i]);
    }

    return values;
}

document.addEventListener('mouseout', function(e) {
        e = e ? e : window.event;
        var from = e.relatedTarget || e.toElement;
        
        // only if mouse leaves window through top first time
        if(e.clientX > window.innerWidth - 100 || e.clientX < 100 || e.clientY > 300 || localStorage.gifterWait)
                return;

        if (!from || from.nodeName == "HTML") {
                $('html').addClass('hidden');
                $('.modals__wrapper').addClass('show');
                $('#modalWait').addClass('show');
                localStorage.setItem('gifterWait', true);
        }
});
// MODALS
this.openModal = function(event){
	//event.preventDefault();
	document.getElementsByTagName( 'html' )[0].classList.toggle('hidden');
	document.getElementsByClassName('modals__wrapper')[0].classList.toggle('show');
	document.getElementById(event.dataset.target).classList.add('show');
}

this.modalClose = function(event){
	event.closest('.modal').classList.toggle('show');
	document.getElementsByTagName( 'html' )[0].classList.toggle('hidden');
	document.getElementsByClassName('modals__wrapper')[0].classList.toggle('show');
}

this.modalCloseAll = function(){
	document.getElementsByTagName( 'html' )[0].classList.remove('hidden');
	document.getElementsByClassName('modals__wrapper')[0].classList.remove('show');
	
	var modals = document.getElementsByClassName("modal");
	Array.prototype.forEach.call(modals, function(item){
		item.classList.remove('show');
  	});
}
// COUNTDOWN

// Set the date we're counting down to
let currentDate = new Date();
currentDate.setMinutes(currentDate.getMinutes() + 5);

var countDownDate = currentDate.getTime();

// Update the count down every 1 second
var x = setInterval(function() {

  var now = new Date().getTime();

  var distance = countDownDate - now;

  var days = Math.floor(distance / (1000 * 60 * 60 * 24));
  var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
  var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
  var seconds = Math.floor((distance % (1000 * 60)) / 1000);

  var countdowns = document.getElementsByClassName("countdown__datetime");
  
  Array.prototype.forEach.call(countdowns, function(item){
	 item.innerHTML = "<span class='num'>" + days + "</span><span class='del'>:</span><span class='num'>" + hours + "</span><span class='del'>:</span><span class='num'>"
  + minutes + "</span><span class='del'>:</span><span class='num'>" + seconds + "</span>";
  });
  
  if (distance < 0) {
    clearInterval(x);
    document.getElementById("countdown__datetime").innerHTML = "EXPIRED";
  }
}, 1000);


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

$(document).ready(function() {
    $('#registration').validate({
        rules: {
            email: {
                required: true,
                email: true
            },
            password: {
                required: true,
            }
        },
        messages: {
            email: {
                required: "Please enter email",
                email: "Неверно введена почта. Попробуйте еще раз."
            },
            password: {
                required: "Please enter password",
            }
        },
        submitHandler: function(form) {
            form.submit();
        }
    });
  $('#main-page-form2').hide();
  
  // VALIDATE EMAIL FIRST STEP
  $('#main-page-form1 button').click((e) => {
    e.preventDefault();
    
    var emailInput = $('input[name="email"]').val();
    
    if(emailInput.length < 4) {
        $('.input__wrapper_email .error__text').text('Введите свой email-адрес');
        $('.input__wrapper_email').addClass('error');
        return;
    } else if(emailInput.indexOf('@') === -1) {
        $('.input__wrapper_email .error__text').text('Неверный формат email-адреса');
        $('.input__wrapper_email').addClass('error');
        return;
    } else {
        let data = {
	        email: emailInput
        };
        $.ajax({
//                url: 'http://gifter.parabee8.beget.tech/api/cloudPayments/is_subscribed',
            url: 'https://wingift.org/api/cloudPayments/is_subscribed',
            data: data,
            type: 'POST'
        }).done(function (response) {
	        console.log(response);
        	$('.input__wrapper_email').removeClass('error');
        	$('#main-page-form1').hide();
			$('#main-page-form2').show();
        }).fail(function (response) {
	        console.log(response);
            $('.input__wrapper_email .error__text').text(response.responseJSON.error);
            $('.input__wrapper_email').addClass('error');
        });
    }

    
  })

  $('#card-number').inputmask({"mask": "9999 9999 9999 9999"});
  $('#card-expiry').inputmask({"mask": "99/99"});
  $('#card-cvc').inputmask({"mask": "999"});
  new Card({
    form: document.querySelector('#form'),
    container: '.card-wrapper',
    formatting: true,
  });

// START NEW SCRIPT
const countdown_total = 220000; // max subscribers
let countdown_start = localStorage.gifterCountdown? +localStorage.gifterCountdown + randomInteger(25, 100) : 176482;

$('.countdown_total').text(prettify(countdown_total));

updateCounter(countdown_start); // current subscribers

function updateCounter(countdown__current) {
    let percent = 100 * countdown__current / countdown_total;

    $('.countdown-hint__number').text(prettify(countdown__current));
    $('.countdown__fill').css('width', percent + '%');

    let increment = 3; // maximum added value
    let interval = randomInteger(250, 2000); // increment interval
    let next_value = randomInteger(countdown__current, countdown__current + increment);

    if(next_value > countdown_total)
        next_value = countdown_total;
    else if (next_value === countdown_total)
        return;

    localStorage.setItem('gifterCountdown', next_value);
    
    setTimeout(() => {
        updateCounter(next_value)
    }, interval);
}

function prettify(num) {
    var n = num.toString();
    return n.replace(/(\d{1,3}(?=(?:\d\d\d)+(?!\d)))/g, "$1" + ' ');
}

function randomInteger(min, max) {
    // получить случайное число от (min-0.5) до (max+0.5)
    let rand = min - 0.5 + Math.random() * (max - min + 1);
    return Math.round(rand);
}

$('.error__icon').on('mouseover', function() {
    $(this).parents('.input__wrapper').find('.error__text').addClass('show');
});
$('.error__icon').on('mouseout', function() {
    $(this).parents('.input__wrapper').find('.error__text').removeClass('show');
});
// END NEW SCRIPT
});

// SET NAME FROM FIRST STEP TO CARD
$('.button-continue').click((e) => {
    // TRANSLITERATION FIELDS
    let card_owner = rus_to_latin(document.querySelector('input[name=firstname]').value + ' ' + document.querySelector('input[name=lastname]').value);
    
    // SET VALUE TO CARD NAME FIELD
    document.querySelector('#name').value = document.querySelector('input[name=firstname]').value || document.querySelector('input[name=lastname]').value? card_owner : '';
    
    // SET VALUE TO CARD NAME HIDDEN INPUT
    $('input[data-cp="name"]').val(document.querySelector('#name').value);
    
    // WRITE NAME TO CARD IMAGE
    if(document.querySelector('#name').value)
        document.querySelector('.jp-card-name').textContent = document.querySelector('#name').value;
});

// $('.button-submit').click((e) => {
//     document.querySelector('#form').submit();
// });
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


$(document).on("click", ".button-submit", function (e) {
    console.log(e);
    e.preventDefault();
    //Проверяем ошибки в форме
    //При ошибках в файле validation-pay-card добавляется класс card__field--error
/*
    var form_valid = true;
    $(this).find('.card__field').each(function() {
        form_valid = form_valid && !$(this).hasClass('card__field--error');
    });
    if (!form_valid) {
        return false;
    }
*/
    /* Создание checkout */
    var checkout = new cp.Checkout(
        // public id из личного кабинета
        'pk_56f9f45a0b1e11a9db817df98ccd4',
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
            email: email,
            accountId: email,
            phone: phone,
            amount: 1.00,
            currency: 'RUB',
            PublicID: 'pk_56f9f45a0b1e11a9db817df98ccd4',
            APISecret: 'b37047daf0845dce25116b42390d26d7'
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
                // if (response['acs_form']) {
                //     window.openAcs(response['acs_form']);
                // } else {
                //     console.error(response);
                //     alert('Произошла ошибка при оплате');
                // }
                
                if (response.Model.AcsUrl) {
                    // var data = {
                    //     MD: response.Model.TransactionId,
                    //     PaReq: response.Model.PaReq,
                    //     TermUrl: 'http://gl.parabee8.beget.tech'
                    // };

                    // $.ajax({
                    //     url: response.Model.AcsUrl,
                    //     data: data,
                    //     crossDomain: true,
                    //     type: 'post',
                    //     dataType: 'jsonp'
                    // }).done(function (resp) {
                    //     console.log(resp)
                    // });
                    // console.log(response.Model.PaReq);
                    $('#secure input[name="MD"]').val(response.Model.TransactionId);
                    $('#secure input[name="PaReq"]').val(response.Model.PaReq);
                    $('#secure input[name="TermUrl"]').val(/*document.location.origin*/'https://wingift.org/api/land/sherra-a');
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
