var woof_custom_variety_do_submit = false;
function woof_init_custom_variety() {
    jQuery('.woof_show_custom_variety_search').keyup(function (e) {
        
        var val = jQuery(this).val();
        var uid = jQuery(this).data('uid');
        if (e.keyCode == 13 /*&& val.length > 0*/) {
            woof_custom_variety_do_submit = true;
            woof_custom_variety_direct_search('woof_custom_variety', val);
            return true;
        }

        //save new word into woof_current_values
        if (woof_autosubmit) {
            woof_current_values['woof_custom_variety'] = val;
        } else {
            woof_custom_variety_direct_search('woof_custom_variety', val);
        }


        //if (woof_is_mobile == 1) {
        if (val.length > 0) {
            jQuery('.woof_custom_variety_search_go.' + uid).show(222);
        } else {
            jQuery('.woof_custom_variety_search_go.' + uid).hide();
        }
        //}

        //http://easyautocomplete.com/examples
        if (val.length >= 3 && woof_custom_variety_autocomplete) {
            //http://stackoverflow.com/questions/1574008/how-to-simulate-target-blank-in-javascript
            jQuery('.easy-autocomplete a').life('click', function () {
                
                if(!how_to_open_links){
                    window.open(jQuery(this).attr('href'), '_blank');
                    return false;
                }
                
                return true;
            });
            //***
            //http://easyautocomplete.com/examples
            var input_id = jQuery(this).attr('id');
            var options = {
                url: function (phrase) {
					//alert(woof_ajaxurl+'yyy');
                    return woof_ajaxurl;
                },
                //theme: "square",
                getValue: function (element) {
                    jQuery("#" + input_id).parents('.woof_show_custom_variety_search_container').find('.woof_show_custom_variety_search_loader').hide();
                    jQuery("#" + input_id).parents('.woof_show_custom_variety_search_container').find('.woof_custom_variety_search_go').show();
                    return element.name;
                },
                ajaxSettings: {
                    dataType: "json",
                    method: "POST",
                    data: {
                        action: "woof_custom_variety_autocomplete",
                        dataType: "json"
                    }
                },
                preparePostData: function (data) {
                    jQuery("#" + input_id).parents('.woof_show_custom_variety_search_container').find('.woof_custom_variety_search_go').hide();
                    jQuery("#" + input_id).parents('.woof_show_custom_variety_search_container').find('.woof_show_custom_variety_search_loader').show();
                    //***
                    data.phrase = jQuery("#" + input_id).val();
                    data.auto_res_count = jQuery("#" + input_id).data('auto_res_count');
                    data.auto_search_by = jQuery("#" + input_id).data('auto_search_by');
                    return data;
                },
                template: {
                    type: woof_post_links_in_autocomplete ? 'links' : 'iconRight',
                    fields: {
                        iconSrc: "icon",
                        link: "link"
                    }
                },
                list: {
                    maxNumberOfElements: jQuery("#" + input_id).data('auto_res_count') > 0 ? jQuery("#" + input_id).data('auto_res_count') : woof_custom_variety_autocomplete_items,
                    onChooseEvent: function () {
                        woof_custom_variety_do_submit = true;

                        if (woof_post_links_in_autocomplete) {
                            return false;
                        } else {
                            woof_custom_variety_direct_search('woof_custom_variety', jQuery("#" + input_id).val());
                        }

                        return true;
                    },
                    showAnimation: {
                        type: "fade", //normal|slide|fade
                        time: 333,
                        callback: function () {
                        }
                    },
                    hideAnimation: {
                        type: "slide", //normal|slide|fade
                        time: 333,
                        callback: function () {
                        }
                    }

                },
                requestDelay: 400
            };
            try {
                jQuery("#" + input_id).easyAutocomplete(options);
            } catch (e) {
                console.log(e);
            }
            jQuery("#" + input_id).focus();
        }
    });

    //+++
    jQuery('.woof_custom_variety_search_go').life('click', function () {
        var uid = jQuery(this).data('uid');
        woof_custom_variety_do_submit = true;
        woof_custom_variety_direct_search('woof_custom_variety', jQuery('.woof_show_custom_variety_search.' + uid).val());
    });
}

function woof_custom_variety_direct_search(name, slug) {
     slug = encodeURIComponent(slug);
    jQuery.each(woof_current_values, function (index, value) {
        if (index == name) {
            delete woof_current_values[name];
            return;
        }
    });

    if (slug != 0) {
        woof_current_values[name] = slug;
    }

    woof_ajax_page_num = 1;
    if (woof_autosubmit || woof_custom_variety_do_submit) {
        woof_custom_variety_do_submit = false;
        woof_submit_link(woof_get_submit_link());
    }
}


