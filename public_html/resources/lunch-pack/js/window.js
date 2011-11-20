lunch.window = {
    
    info: function (titleValue, msgValue) {
        var me = this;
        var el = me.generateBaseElement('info');

        var paragraph = document.createElement('p');
        paragraph.setAttribute('style', 'float:left;');
        paragraph.innerHTML = titleValue;

        var t = document.getElementById('lunch-window-title-info');
        t.appendChild(paragraph);

        var msg = document.createElement('p');
        msg.innerHTML = msgValue;

        var m = document.getElementById('lunch-window-msg');
        m.appendChild(msg);

        var height = el.offsetHeight / 2;
        el.setAttribute('style', 'margin-top: -' + height + 'px;');

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

        var button = document.createElement('input'),
            b_id = lunch.core.genId();
        button.setAttribute('id', b_id);
        button.setAttribute('type', 'button');
        button.setAttribute('value', 'OK');
        button.setAttribute('class', 'lunch-button-success');
        button.setAttribute('style', 'margin:10px;margin-left: 325px;padding-left:20px;padding-right:20px;');
        button.setAttribute('onmouseup', 'lunch.window.hide();');

        wrap.appendChild(title);
        wrap.appendChild(msg);
        wrap.appendChild(button);

        el.appendChild(mask);
        el.appendChild(wrap);
        body.appendChild(el);

        return wrap;
    },


    hide: function () {
        var el = document.getElementById('lunch-window-owner');

        if (el !== null) {
            el.parentNode.removeChild(el);
        }
    }
};
