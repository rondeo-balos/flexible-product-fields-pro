jQuery.noConflict();
(function($) {
    function fpf_field_value( field_name ) {
        if ( jQuery( 'input[name=' + field_name + ']' ).length ) {
            if ( jQuery( 'input[name=' + field_name + ']' ).attr( 'type' ) == 'radio' ) {
                return jQuery('input[name=' + field_name + ']:checked').val();;
            }
            if ( jQuery( 'input[name=' + field_name + ']' ).attr( 'type' ) == 'checkbox' ) {
                if ( jQuery('input[name=' + field_name + ']').is(':checked') ) {
                    return 'checked';
                }
                else {
                    return 'unchecked';
                }
            }
            return jQuery('input[name=' + field_name + ']').val();
        }
        if ( jQuery( 'select[name=' + field_name + ']' ).length ) {
            return jQuery( 'select[name=' + field_name + ']' ).val();
        }
    }

    function fpf_field_change_rules() {
        var hidden_fields = true;
        while ( hidden_fields) {
            hidden_fields = false;
            jQuery.each(fpf_product.fields_rules, function (index, field) {
                var operator = field.operator;
                var show_field = true;
                if (operator == 'or') {
                    show_field = false;
                }
                jQuery.each(field.rules, function (index_rule, value_rule) {
                    var rule_result = false;
                    if ( value_rule.field != '' ) {
                        var field_value = fpf_field_value(value_rule.field);
                        if (typeof fpf_product.fields_rules[value_rule.field] !== 'undefined') {
                            if (!fpf_product.fields_rules[value_rule.field].enabled) {
                                field_value = value_rule.field_value + '1';
                            }
                        }
                        rule_result = (field_value == value_rule.field_value);
                    }
                    if (value_rule.compare == 'is_not') {
                        rule_result = !rule_result;
                    }
                    if (operator == 'and') {
                        show_field = show_field && rule_result;
                    }
                    if (operator == 'or') {
                        show_field = show_field || rule_result;
                    }
                });
                if ( !show_field ) {
                    if ( typeof field.enabled == 'undefined' || field.enabled ) {
                        field.enabled = false;
                        hidden_fields = true;
                        jQuery('#' + index + '_field').parent().hide();
                    }
                }
                else {
                    field.enabled = true;
                    jQuery('#' + index + '_field').parent().show();
                }
            });
        }
    }
    jQuery(document).on('change','select.fpf-input-field,input.fpf-input-field',function(){
        fpf_field_change_rules();
    });

    jQuery(document).ready(function(){
        jQuery('select.fpf-input-field,input.fpf-input-field').change();
    })

})(jQuery);

