(function($){
    'use strict';
    $.fn.configs = function(){
    };
    $.configs = {
        defaults: function(){
            $.configs.defaults = {
                'showOnReady': false,
                'alwaysShow': true,
                'threshold': 10,
                'interval': '',
                'defaultClass': 'warning',
                'limitReachedClass': 'danger label-important',
                'separator': ' / ',
                'preText': '',
                'postText': '',
                'showMaxLength': true,
                'placement': 'bottom-right-inside',
                'message': null,
                'showCharsTyped': true,
                'validate': false,
                'utf8': false,
                'appendToParent': false,
                'twoCharLinebreak': true,
                'allowOverMax': false,
                'previousClass': '',
            };
            $.configs.title = {
                "showOnReady": false,
                "alwaysShow": true,
                "threshold": 10,
                "interval": {
                    0: {
                        "limitChars": 15,
                        "bsClass": "danger",
                        "message" : "Too short."
                    },
                    1: {
                        "limitChars": 60,
                        "bsClass": 'warning',
                        "message" : "Could be better."
                    },
                    2: {
                        "limitChars": 90,
                        "bsClass": "success",
                        "message" : "This is the right length."
                    },
                    3: {
                        "limitChars": 110,
                        "bsClass": "warning",
                        "message" : "Too Long"
                    },                    
                },
                "previousClass": '',
                "defaultClass": 'warning',
                "limitReachedClass": 'danger label-important ',
                "separator": ' / ',
                "preText": '',
                "postText": '',
                "showMaxLength": true,
                "placement": 'bottom-right-inside',
                "message": null,
                "showCharsTyped": true,
                "utf8": false,
                "appendToParent": false,
                "twoCharLinebreak": true,
                "allowOverMax": false
            };
            $.configs.metaDescription = {
                "showOnReady": false,
                "alwaysShow": true,
                "threshold": 10,
                "interval": {
                    0: {
                        "limitChars": 15,
                        "bsClass": "danger",
                        "message" : "Too short."
                    },
                    1: {
                        "limitChars": 70,
                        "bsClass": 'warning',
                        "message" : "Could be better."
                    },
                    2: {
                        "limitChars": 110,
                        "bsClass": "success",
                        "message" : "This is the right length."
                    },
                    3: {
                        "limitChars": 139,
                        "bsClass": "warning",
                        "message" : "Too Long"
                    },                      
                },
                "previousClass": '',
                "defaultClass": 'warning',
                "limitReachedClass": 'danger label-important ',
                "separator": ' / ',
                "preText": '',
                "postText": '',
                "showMaxLength": true,
                "placement": 'bottom-right-inside',
                "message": null,
                "showCharsTyped": true,
                "utf8": false,
                "appendToParent": false,
                "twoCharLinebreak": true,
                "allowOverMax": false
            };
        }
    };
    $.configs.defaults();
})(jQuery);