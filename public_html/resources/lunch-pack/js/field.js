
lunch.field = {

    init: function () {
        
        var classes = [
            'lunch-field',
            'lunch-field-caution',
            'lunch-field-success'
        ];
        var length = classes.length;

        for (var i = 0; i < length; i++) {
            var el = document.getElementsByClassName(classes[i]),
                len = el.length;

            for (var o = 0; o < len; o++) {
                
                if (el[o].getAttribute('id') === null) {
                    el[o].setAttribute('id', lunch.core.genId());
                }

                if (classes[i] == 'lunch-field') {
                    el[o].setAttribute('onfocus', 'lunch.field.onfocus("' + el[o].getAttribute('id') + '")');
                } else if (classes[i] == 'lunch-field-success') {
                    el[o].setAttribute('onfocus', 'lunch.field.successfocus("' + el[o].getAttribute('id') + '")');
                } else if (classes[i] == 'lunch-field-caution') {
                    el[o].setAttribute('onfocus', 'lunch.field.cautionfocus("' + el[o].getAttribute('id') + '")');
                }
                el[o].setAttribute('onblur', 'lunch.field.onblur("' + el[o].getAttribute('id') + '")');
            }

        }
    },

    onfocus: function (id) {
        var el = document.getElementById(id),
            style =  'color: #555;' +
                'box-shadow: 0px 0px 5px #ccc;' +
                '-moz-box-shadow: 0px 0px 5px #ccc;' +
                '-webkit-box-shadow: 0px 0px 5px #ccc;';

        el.setAttribute('style', style);
    },

    successfocus: function (id) {
        var el = document.getElementById(id),
            style =  'color: #69b076;' +
                'box-shadow: 0px 0px 5px #3eb370;' +
                '-moz-box-shadow: 0px 0px 5px #3eb370;' +
                '-webkit-box-shadow: 0px 0px 5px #3eb370;';

        el.setAttribute('style', style);
    },

    cautionfocus: function (id) {
        var el = document.getElementById(id),
            style =  'color: #ec6d71;' +
                'box-shadow: 0px 0px 5px #ec6d71;' +
                '-moz-box-shadow: 0px 0px 5px #ec6d71;' +
                '-webkit-box-shadow: 0px 0px 5px #ec6d71;';

        el.setAttribute('style', style);

    },

    onblur: function (id) {
        var el = document.getElementById(id);
        el.removeAttribute('style');
    }

};
