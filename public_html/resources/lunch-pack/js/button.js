
lunch.button = {

    init: function () {

        var classes = [
                'lunch-button',
                'lunch-button-caution',
                'lunch-button-success',
                'lunch-button-info'
            ],
            length = classes.length;

        for (var i = 0; i < length; i++) {
            var el = document.getElementsByClassName(classes[i]),
                len = el.length;

            for (var o = 0; o < len; o++) {

                if (el[o].getAttribute('id') === null) {
                    el[o].setAttribute('id', lunch.core.genId());
                }

                if (classes[i] === 'lunch-button') {
                    el[o].setAttribute('onmousedown', 'lunch.button.mousedown("' + el[o].getAttribute('id') + '");');
                } else if (classes[i] === 'lunch-button-caution') {
                    el[o].setAttribute('onmousedown', 'lunch.button.cautiondown("' + el[o].getAttribute('id') + '");');
                } else if (classes[i] === 'lunch-button-success') {
                    el[o].setAttribute('onmousedown', 'lunch.button.successdown("' + el[o].getAttribute('id') + '")');
                } else if (classes[i] === 'lunch-button-info') {
                    el[o].setAttribute('onmousedown', 'lunch.button.infodown("' + el[o].getAttribute('id') + '")');
                }

                el[o].setAttribute('onmouseup', 'lunch.button.mouseup("' + el[o].getAttribute('id') + '");');
            }

        }

    },

    mousedown: function (id) {
        var el = document.getElementById(id),
            style = 'border: solid 1px #ccc; color: #aaa;';

        el.setAttribute('style', style);
    },

    cautiondown: function (id) {
        var el = document.getElementById(id),
            style = 'border: solid 1px #e9546b; color: #f5b1aa;';

        el.setAttribute('style', style);
    },

    successdown: function (id) {
        var el = document.getElementById(id),
            style = 'border: solid 1px #3eb370; color: #98d98e;';

        el.setAttribute('style', style); 
    },

    infodown: function (id) {
        var el = document.getElementById(id),
            style = 'border: solid 1px #007ad2; color: #89c3eb;';

        el.setAttribute('style', style);
    },

    mouseup: function (id) {
        var el = document.getElementById(id);
        el.removeAttribute('style');
    }
    
};

