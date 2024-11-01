/*global define */
/*global window */
/*global console*/
/*global tinymce*/
/*global document*/
/*global tecslider_settings*/
/*global jQuery*/
/*global this*/
jQuery(document).ready(function ($) {
    'use strict';
    var prepend = 'tecslider_';
    var $body = $('body');
    var $settings = $body.find('#tecslider-settings-page');
    var $sidebar = $settings.find('.sidebar');
    var $toggle = $sidebar.find('.toggle');
    /* var $search_btn = $sidebar.find('.search-box'); */
    var $mode_switch = $sidebar.find('.toggle-switch');
    var $mode_text = $sidebar.find('.mode-text');

    $mode_switch.on('click', function (e) {
        e.preventDefault();
        //$settings.toggleClass('dark');
        var mode = 'dark';
        if ($settings.hasClass('dark')) {
            mode = 'light';
            $settings.removeClass('dark').addClass('light');
            $mode_text.html(tecslider_settings.light_mode);
        } else {
            mode = 'dark';
            $settings.removeClass('light').addClass('dark');
            $mode_text.html(tecslider_settings.dark_mode);
        }
        var ajaxdata = {};
        ajaxdata.action = prepend + 'set_dark_light_mode';
        ajaxdata.tecslider_nonce = tecslider_settings.ajax_nonce;
        ajaxdata.mode = mode;
        $.ajax({
            beforeSend: function () {},
            type: 'POST',
            url: tecslider_settings.ajaxurl,
            data: ajaxdata,
            dataType: 'json',
            success: function (data) {
                if ('good' === data.status) {
                    console.log(data.msg);
                } else {
                    /* $settings.toggleClass('dark'); */
                    console.log(data.msg);
                }
            },
            complete: function () {}
        });
    });
    $toggle.on('click', function (e) {
        e.preventDefault();
        $sidebar.toggleClass('close');
    });
    /**
     * Change the active admin tab based on the provided hash.
     *
     * @param {string} hash - The hash value representing the tab to be activated.
     */
    function changeAdminTab(hash) {
        var mwtMain = $('#tecslider-settings-page');
        mwtMain.attr('data-tab', hash);
        mwtMain.find('.mywptrek-admin-page-content.active').removeClass('active');
        var ul = mwtMain.find('.menu ul:first');
        ul.find('li a').removeClass('active');
        $(ul).find('a[href=\\' + hash + ']').addClass('active');
        mwtMain.find(hash).addClass('active');


        $("html, body").animate({
            scrollTop: 0
        }, 1000);
    }
    function doNothing() {
        return;
    }
    function init() {
        var hash = window.location.hash;
        if (hash === '' || hash === 'undefined') {
            doNothing();
        } else {
            changeAdminTab(hash);
        }
    }
    init();
    $('#tecslider-settings-page').on('click', '.menu ul.menu-links li a', function (e) {
        e.preventDefault();
        var href = $(this).attr('href');
        changeAdminTab(href);
    });
    $('body').on('click', '#tecslider-shortcode', function (e) {
        e.preventDefault();
        var $parent = $(this).closest('.mwt-be-block');
        var $code = $(this).find('code');
        var $notification = $parent.find('.mwt-copy-info');

        var tempInput = $('<input>');
        $('body').append(tempInput);
        tempInput.val($code.html()).select();

        try {
            // Copy the selected text to the clipboard
            document.execCommand('copy');
            $notification.show().delay(1500).fadeOut(); // Show and hide the notification
        } catch (err) {
            console.error('Unable to copy text: ', err);
        }
    });
    $('select[name="tecslider_event_type"]').on('change', function() {
        var $parent = $(this).closest('.mywptrek-admin-page-content');
        var $row = $parent.find('.shortcode-custom-events-row');
        if ('custom' === $(this).val()) {
            $row.addClass('mwt-show').removeClass('mwt-hide');
        } else {
            $row.addClass('mwt-hide').removeClass('mwt-show');
        }
    });
    $('.mwt-shortcode-element').on('change', function () {
        // Initialize an empty shortcode
        var shortcode = '[add_mwt_tec_slider ';

        // Loop through all elements with the 'shortcode-element' class
        $('.mwt-shortcode-element').each(function () {
            var elementName = $(this).attr('data-attr');
            var selectedValue = $(this).val();

            // Append the attribute to the shortcode
            if ($(this).hasClass('switch-input')) {
                if ($(this).is(":checked")) {
                    shortcode += elementName + '=true ';
                } else {
                    shortcode += elementName + '=false ';
                }
            } else {
                shortcode += elementName + '="' + selectedValue + '" ';
                if ('custom' === selectedValue) {
                    shortcode += 'cevents="" ';
                }
            }
        });
        shortcode += 'colorscheme="#5a30f3" ';
        // Close the shortcode tag
        shortcode += ']';

        // Update the shortcode in the display element
        $('#tecslider-shortcode code').html(shortcode);
    });
});
