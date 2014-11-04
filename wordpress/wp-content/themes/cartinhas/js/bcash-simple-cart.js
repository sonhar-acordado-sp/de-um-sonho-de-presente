jQuery(function()
{
    var $ = jQuery;

    // {'code': {'donations': ['doacao_camiseta']}}
    var items = {};

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
    $('.donation-forms button.donation')
        .each(loadValues)
        .click(addDonation)
        .click(updateList)
        .click(updateTotal);

    function loadValues() {
        var donation = $(this).val();
        var value = parseInt( $(this).attr('data-value'), 10);

        if(donation) {
            values[donation] = value;
        }
    }

    function addDonation() {
        var donation = $(this).val();
        if(current.donations.indexOf(donation) < 0) {
            current.donations.push(donation);
        }
    }

    function removeDonation() {
        var donation = $(this).val();
        var index = current.donations.indexOf(donation);

        if(index >= 0) {
            current.donations.splice(index, 1);
        }
    }

    var $total = $('.donation-forms .bcash-total');
    function updateTotal() {
        total = current.donations.reduce(function(a,b) {
            return a + values[b];
        }, 0);

        $total.text(total);
    }

    var $RMBTN = $('<button class="btn btn-xs btn-danger">')
                .append('<span class="glyphicon glyphicon-remove">')

    var $list = $('.donation-forms .bcash-list');
    function updateList() {
        $list.html('');

        current.donations.forEach(function(donation){
            var $rmbtn = $RMBTN.clone();
            $rmbtn
                .click(removeDonation)
                .click(updateList)
                .click(updateTotal)
                .val(donation);

            var $li = $('<li>')
                    .append($rmbtn)
                    .append('<span>&nbsp;</span>')
                    .append(messages[donation]);

            $list.append($li);
        });
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
        $form.submit();
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
            .then(submitForm);
        }
    }

});
