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

// // LOCALSTORAGE

// this.storeInputs = function(){
//     var inputs = document.getElementsByTagName('input');
//     console.log(localStorage);
  
// 	Array.prototype.forEach.call(inputs, function(item){
// 		item.addEventListener('keyup', function(event){
// 			let inputName = event.target.name;
// 			let inputValue = event.target.value;
      
// 			if(inputName !== '_hjid')
// 				localStorage.setItem(inputName, inputValue);
// 		});
//   	});
// }

// storeInputs();

// this.setInputs = function(){
// 	var inputs = getStorage();

// 	for(var name in inputs){
// 	    document.querySelector('input[name=' + name + ']').value = inputs[name];
// 	}
// }
// setInputs();

// function getStorage() {

//     var values = [],
//         keys = Object.keys(localStorage),
//         i = keys.length;

//     while ( i-- ) {
// 	    if(keys[i] !== '_hjid' && keys[i] !== 'gifterWait' && keys[i] !== 'gifterCountdown')
//         	values[keys[i]] = localStorage.getItem(keys[i]);
//     }

//     return values;
// }


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

var firstnameInput = $('input[name="firstname"]').val();
var lastnameInput = $('input[name="lastname"]').val();
var phoneInput = $('input[name="phone"]').val();
var emailInput = $('input[name="email"]').val();
$('.register__agreement').removeClass('error');
$('.input_email').removeClass('error');
$('.input_phone').removeClass('error');
$('.input_firstname').removeClass('error');
$('.input_lastname').removeClass('error');

 if(firstnameInput.length < 2) {
        $('.input_firstname .error__text').text('Введите свое Имя');
        $('.input_firstname').addClass('error');
        return;
} else  if(lastnameInput.length < 2) {
        $('.input_lastname .error__text').text('Введите свою Фамилию');
        $('.input_lastname').addClass('error');
        return;
} else  if(phoneInput.length < 6) {
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
} else if(!$('.register__agreement input').prop('checked')) {
    $('.register__agreement').addClass('error');
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
      $('.first-step').hide();
      $('.second-step').show();
      $('.register__info').hide();
    }).fail(function (response) {
      console.log(response);
        $('.input_email .error__text').text(response.responseJSON.error);
        $('.input_email').addClass('error');
    });
}




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
    public_id,
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

if (result.success) {
    // сформирована криптограмма
    var email = '', phone = '';
    if ($('#checkSms').is(':checked')) {
        phone = $('#tel').val();
    } else {
        email = $('#email').val();
    }
    
    var data = {
        CardCryptogramPacket: result.packet,
        name: $('#name').val(),
        lastname: $('#lastname').val(),
        email: email,
        accountId: email,
        phone: $('#phone').val(),
    };
    
    $.ajax({
        url: '/api/cloudPayments/charge',
        data: data,
        type: 'post'
    }).done(function (response) {
        response = JSON.parse(response);
        
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
                alert(response.Model.CardHolderMessage);
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