jQuery(function()
{
    var $ = jQuery;

    var $list = $('.donation-forms .bcash-list');
    var $rmTpl = $('<button class="btn btn-xs btn-danger">').append('<span class="glyphicon glyphicon-remove">');
    var $total = $('.donation-forms .bcash-total');
    var $buttons = $('.donation-forms button.donation');

    // {'code': {'donations': ['doacao_camiseta']}}
    var items = {};

    try {
        if(localStorage.getItem('cartinhas')) {
            items = JSON.parse(localStorage.getItem('cartinhas'));
        }
    } catch(e) {
        console.log(e);
    }

    // {'donations': ['doacao_camiseta']}
    var current;

    var total = 0;
    var values = {
        'doacao_alimentacao': null,
        'doacao_transporte': null,
        'doacao_camiseta': null
    };

    var messages = {
        'doacao_alimentacao': 'Doação para alimentação',
        'doacao_transporte': 'Doação para transporte',
        'doacao_camiseta': 'Doação para camiseta'
    };

    // inicializa os items
    var current_code = $('input[name=codigo-cartinha]').val();
    if (items[current_code])
    {
        current = items[current_code];
    }
    else
    {
        current = {'donations': [ ]};
        items[current_code] = current;
    }

    // inicializa eventos

    $buttons.click(toggleDonation)
            .click(updateList)
            .click(updateTotal)
            .click(markSelected)
            .click(updateStorage);

    $buttons.each(markSelected)
            .each(updateList)
            .each(loadValues)
            .each(updateTotal);

    window.addEventListener('storage', function(evt) {
        if(evt.key !== 'cartinhas'
           || evt.url === document.location.href) {
            return;
        }

        items = JSON.parse(evt.newValue);
        if(!items) {
            items = {};
            items[current_code] = {'donations': []};
        }

        current = items[current_code];

        $buttons.each(markSelected)
                .each(updateList)
                .each(loadValues)
                .each(updateTotal);
    }, false);

    function updateStorage() {
        var str = JSON.stringify(items);
        localStorage.setItem('cartinhas', str);
    }

    function markSelected() {
        $buttons.each(function(i, el) {
            var donation = $(this).val();

            if(current.donations.indexOf(donation) >= 0) {
                $(this).removeClass('btn-info').addClass('btn-success');
            } else {
                $(this).removeClass('btn-success').addClass('btn-info');
            }
        })
    }

    function loadValues() {
        var donation = $(this).val();
        var value = parseInt( $(this).attr('data-value'), 10);

        if(
           donation) {
            values[donation] = value;
        }};


    function toggleDonation() {
        var donation = $(this).val();
        var index = current.donations.indexOf(donation);

        if(index < 0) {
            current.donations.push(donation);
        } else {
            current.donations.splice(index, 1);
        }
    }

    function removeDonation() {
        var donation = $(this).val();

        for(var att in items) {
            var item = items[att];

            var index = item.donations.indexOf(donation);
            if(index >= 0) {
                item.donations.splice(index, 1);
            }
        }
    }

    function updateTotal() {
        total = 0;
        for(var att in items) {
            total = items[att].donations.reduce(function(a,b) {
                return a + values[b];
            }, total);
        }

        $total.text(total);
    }

    function updateList() {
        $list.html('');
        var donations;

        for(var code in items) {
            donations = items[code]['donations'];

            donations.forEach(function(donation){
                var $rmbtn = $rmTpl.clone();
                $rmbtn
                    .click(removeDonation)
                    .click(updateList)
                    .click(updateTotal)
                    .click(markSelected)
                    .click(updateStorage)
                    .val(donation);

                var $a = $('<a>').attr('href', '/cartinha/' + code ).text(' (' + code + ')')

                var $li = $('<li>')
                        .append($rmbtn)
                        .append('<span>&nbsp;</span>')
                        .append(messages[donation])
                        .append($a);

                $list.append($li);
            });
        }
    }

    function generateForm(data) {
        var $form = $('<form>');
        $form.attr('method', 'POST');
        $form.attr('action', 'https://www.bcash.com.br/checkout/pay/');

        for(var att in data){
            $('<input>')
                .attr('name', att)
                .attr('type', 'hidden')
                .val(data[att])
                .appendTo($form);
        }
        return $form;
    }

    function submitForm($form) {
        $form.addClass('hidden');
        $form.appendTo(document.body);
        $form.submit();
    }

    function emptyStorage($form) {
        delete localStorage['cartinhas'];
        return $form;
    }

    var $conclude = $('.donation-forms .bcash-conclude')
                    .click(concludeDonation);
    function concludeDonation() {
        if(total > 0) {
            jQuery.ajax({
                url: '/api/sign_bcash_form',
                data: items,
                dataType: 'json',
                method: 'POST'
            })
            .then(generateForm)
            .then(emptyStorage)
            .then(submitForm);
        }
    }
});
