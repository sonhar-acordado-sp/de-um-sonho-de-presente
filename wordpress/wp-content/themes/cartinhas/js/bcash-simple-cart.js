jQuery(function(){
    var db = window.localStorage;

    // {'item': {'val': 10, 'len': 5, 'desc': ''}}
    var donations = {};

    function add_item() {
        var item = jQuery(this).attr('bcash-item');
        var val = jQuery(this).attr('bcash-value');
        var desc = jQuery(this).attr('bcash-desc');

        if(!donations[item]) {
            donations[item] = {
                'val': parseInt(val, 10),
                'desc': desc
            }
        }
        jQuery(this).removeClass('btn-info');
    }

    function remove_item() {
        var item = jQuery(this).attr('bcash-item');
        delete donations[item];
    }

    function mark_donated() {
        var item = jQuery(this).attr('bcash-item');
        if(donations[item]) {
            jQuery('.btn-'+item).removeClass('btn-info');
        } else {
            jQuery('.btn-'+item).addClass('btn-info');
        }
    }

    var $list = jQuery('.bcash-list');
    function update_list() {
        $list.html('');

        var $item;
        var $text;
        var $remove;
        var $icon;
        for( var att in donations) {
            $text = jQuery('<span>').html('&nbsp;' + donations[att].desc + ' ('+att+')');
            $item = jQuery('<li>');

            $icon = jQuery('<span class="glyphicon glyphicon-remove">');
            $remove = jQuery('<a class="text-danger">').css('cursor', 'pointer');

            $remove.append($icon);
            $remove.attr('bcash-item', att);

            $remove.click(remove_item)
                   .click(mark_donated)
                   .click(update_list)
                   .click(update_total);

            $item.append($remove).append($text)
            $list.append($item);
        }
    }

    var $total = jQuery('.bcash-total');
    function update_total() {
        var val = 0;
        for( var att in donations) {
            val += donations[att].val;
        }

        $total.text('R$ ' + val);
    }

    function conclude_donation() {
        var $form = generate_bcash_form();
        $form.submit();
    }
    jQuery('.bcash-conclude').click(conclude_donation);

    jQuery('button[bcash-value][bcash-item]')
        .each(mark_donated)
        .click(add_item)
        .click(update_list)
        .click(update_total);

    function generate_bcash_form() {
        var $form = jQuery('<form>');
        $form.attr('action', 'https://www.bcash.com.br/checkout/pay/');
        $form.attr('method', 'POST');

        jQuery('<input>').attr('name', 'email_loja')
                         .attr('value', 'fabio.montefuscolo@gmail.com')
                         .appendTo($form);

        // jQuery('<input>').attr('name', 'url_retorno')
        //                  .attr('value', '')
        //                  .appendTo($form);

        var i = 1;
        for(var att in donations) {
            jQuery('<input>').attr('name', 'produto_codigo_' + i)
                             .attr('value', att)
                             .appendTo($form);

            jQuery('<input>').attr('name', 'produto_descricao_' + i)
                             .attr('value', donations[att].desc + ' ('+att+')')
                             .appendTo($form);

            jQuery('<input>').attr('name', 'produto_qtde_' + i)
                             .attr('value', 1)
                             .appendTo($form);

            jQuery('<input>').attr('name', 'produto_valor_' + i)
                             .attr('value', donations[att].val+'.00')
                             .appendTo($form);

            i++;
        }

        return $form;
    }
});
