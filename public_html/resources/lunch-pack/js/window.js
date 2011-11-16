lunch.window = {
    
    info: function (titleValue, msgValue) {
        var me = this;
        var el = me.generateBaseElement('info');

        var paragraph = document.createElement('p');
        paragraph.innerHTML = titleValue;

        var t = document.getElementById('lunch-window-title-info');
        t.appendChild(paragraph);

        var msg = document.createElement('p');
        msg.innerHTML = msgValue;

        var m = document.getElementById('lunch-window-msg');
        m.appendChild(msg);
    },

    generateBaseElement: function (type) {
        var me = this;
        var body = document.getElementsByTagName('body').item(0);

        var el = document.createElement('div');
        el.setAttribute('id', 'lunch-window-owner');

        var mask = document.createElement('div');
        mask.setAttribute('class', 'lunch-window-mask');
        mask.setAttribute('onclick', 'lunch.window.hide();');

        var wrap = document.createElement('div');
        wrap.setAttribute('class', 'lunch-window-wrap');

        var title = document.createElement('div');
        title.setAttribute('id', 'lunch-window-title-' + type);

        var msg = document.createElement('div');
        msg.setAttribute('id', 'lunch-window-msg');

        wrap.appendChild(title);
        wrap.appendChild(msg);

        el.appendChild(mask);
        el.appendChild(wrap);
        body.appendChild(el);
    },


    hide: function () {
        var el = document.getElementById('lunch-window-owner');

        if (el !== null) {
            el.parentNode.removeChild(el);
        }
    }
};
