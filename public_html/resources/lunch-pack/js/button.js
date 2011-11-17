
lunch.button = {

    init: function () {

        var classes = ['lunch-button'],
            length = classes.length;

        for (var i = 0; i < length; i++) {
            var el = document.getElementsByClassName(classes[i]),
                len = el.length;

            for (var o = 0; o < len; o++) {

                if (el[o].getAttribute('id') === null) {
                    el[o].setAttribute('id', lunch.core.genId());
                }

                //el[o].setAttribute('onmouseover', 'lunch.button.fover("' + el[o].getAttribute('id') + '");');
                //el[o].setAttribute('onmouseout', 'lunch.button.out("' + el[o].getAttribute('id') + '")');
            }

        }

    },

    fover: function (id) {
        var el = document.getElementById(id);
        el.setAttribute('style', 'background-color: black;');
    },

    out: function (id) {
        var el = document.getElementById(id);
        el.removeAttribute('style');
    }

};

