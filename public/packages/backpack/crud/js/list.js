/*
*
* Backpack Crud / List
*
*/

jQuery(function($){
    $(document).on('click','.applyBtn, .ranges ul li, #remove_filters_button',function (){
        $.ajax({
            type: 'POST',
            dataType: 'json',
            url: 'subscription/filterSubscribeChangeLabel',
            data: {
                test:'test',
                "_token":$('meta[name="csrf-token"]').attr('content'),
                'from_to_js' : findGetParameter('from_to'),
                'from_to_register_js' : findGetParameter('from_to_register'),
            },
            xhrFields: {
                withCredentials: false
            },
            success: function(data) {
                $('.activation-statuses').html(data)
            },
        });

    })

    console.log(window.location.pathname);
    if(window.location.pathname == '/admin/subscription'){
        $('.container-fluid').css('margin-bottom','10px');
        $.ajax({
            type: 'POST',
            dataType: 'json',
            url: 'subscription/filterSubscribeChangeLabel',
            data: {
                test:'test',
                "_token":$('meta[name="csrf-token"]').attr('content'),
                'from_to_js' : findGetParameter('from_to'),
                'from_to_register_js' : findGetParameter('from_to_register'),
            },
            xhrFields: {
                withCredentials: false
            },
            success: function(data) {
                console.log(data);

                $('.container-fluid').append(`<small class="activation-statuses">${data}</small>`)
            },
        });
    }



});

function findGetParameter(parameterName) {
    var result = null,
        tmp = [];
    location.search
        .substr(1)
        .split("&")
        .forEach(function (item) {
            tmp = item.split("=");
            if (tmp[0] === parameterName) result = decodeURIComponent(tmp[1]);
        });
    return result;
}
