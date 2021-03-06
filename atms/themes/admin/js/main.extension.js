/**
 * @copyright Copyright (c) 2015 Yiister
 * @license https://github.com/yiister/yii2-gentelella/blob/master/LICENSE
 * @link http://gentelella.yiister.ru
 */

GentelellaExtension = {
    'init': function () {
        if (this.getCookie('menuIsCollapsed') == 'true') {
            jQuery('#menu_toggle').trigger('click');
        }


        jQuery('#menu_toggle').click(function() {
            GentelellaExtension.setCookie('menuIsCollapsed', jQuery('body').hasClass('nav-md'), undefined, '/');
        });
    },
    'getCookie': function (name) {
        var cookie = " " + document.cookie;
        var search = " " + name + "=";
        var setStr = null;
        var offset = 0;
        var end = 0;
        if (cookie.length > 0) {
            offset = cookie.indexOf(search);
            if (offset != -1) {
                offset += search.length;
                end = cookie.indexOf(";", offset)
                if (end == -1) {
                    end = cookie.length;
                }
                setStr = unescape(cookie.substring(offset, end));
            }
        }
        return(setStr);
    },
    'setCookie': function (name, value, expires, path, domain, secure) {
        document.cookie = name + "=" + escape(value) +
        ((expires) ? "; expires=" + expires : "") +
        ((path) ? "; path=" + path : "") +
        ((domain) ? "; domain=" + domain : "") +
        ((secure) ? "; secure" : "");
    }
};

jQuery(function() {
    GentelellaExtension.init();
});
