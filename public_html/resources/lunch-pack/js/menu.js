
lunch.menu = {

    init: function () {

        var classes = [
            'lunch-menu'
        ];

        var el = document.getElementsByClassName('lunch-menu-button'),
            length = el.length;

        for (var i = 0; i < length; i++) {
            if (el[i].getAttribute('id') === null) {
                el[i].setAttribute('id', lunch.core.genId());
            }

            el[i].setAttribute('onmousedown', 'lunch.menu.mousedown("' + el[i].getAttribute('id') + '")');
        }
        
    },

    mousedown: function (id) {
        var el = document.getElementById(id),
            style,
            list = el.parentNode.getElementsByClassName('lunch-menu-list'),
            length = list.length;

        if (el.getAttribute('enable')) {
            el.removeAttribute('style');
            el.removeAttribute('enable');

            for (var i = 0; i < length; i++) {
                list[i].setAttribute('style', 'display:none;');
            }

        } else {
            style = 'border: solid 1px #bbb; color: #aaa;' +
                'border-bottom: none;'
            el.setAttribute('style', style);
            el.setAttribute('enable', 'true');

            for (var i = 0; i < length; i++) {
                list[i].setAttribute('style', 'display:inline;');
            }
        }
    }

};
