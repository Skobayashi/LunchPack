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

        var height = el.offsetHeight / 2;
        el.setAttribute('style', 'margin-top: -' + height + 'px;');

        var button = document.createElement('input'),
            b_id = lunch.core.genId();
        button.setAttribute('id', b_id);
        button.setAttribute('type', 'button');
        button.setAttribute('value', 'OK');
        button.setAttribute('class', 'lunch-button-success');
        button.setAttribute('style', 'margin:10px;margin-left: 325px;padding-left:20px;padding-right:20px;');
        button.setAttribute('onmouseup', 'lunch.window.hide();');

        el.appendChild(button);

    },

    alert: function (titleValue, msgValue) {
        var me = this,
            el = me.generateBaseElement('alert');

        var paragraph = document.createElement('p');
        paragraph.innerHTML = titleValue;

        var t = document.getElementById('lunch-window-title-alert');
        t.appendChild(paragraph);

        var msg = document.createElement('p');
        msg.innerHTML = msgValue;

        var m = document.getElementById('lunch-window-msg');
        m.appendChild(msg);

        var height = el.offsetHeight / 2;
        el.setAttribute('style', 'margin-top: -' + height + 'px;');

        var button = document.createElement('input'),
            b_id = lunch.core.genId();
        button.setAttribute('id', b_id);
        button.setAttribute('type', 'button');
        button.setAttribute('value', 'OK');
        button.setAttribute('class', 'lunch-button-caution');
        button.setAttribute('style', 'margin:10px;margin-left: 325px;padding-left:20px;padding-right:20px;');
        button.setAttribute('onmouseup', 'lunch.window.hide();');

        el.appendChild(button);
        
    },

    confirm: function (titleValue, msgValue, func) {
        var me = this,
            el = me.generateBaseElement('confirm');

        lunch.window.func = function () {
            func();
            lunch.window.hide();
        };

        var paragraph = document.createElement('p');
        paragraph.innerHTML = titleValue;

        var t = document.getElementById('lunch-window-title-confirm');
        t.appendChild(paragraph);

        var msg = document.createElement('p');
        msg.innerHTML = msgValue;

        var m = document.getElementById('lunch-window-msg');
        m.appendChild(msg);

        var height = el.offsetHeight / 2;
        el.setAttribute('style', 'margin-top: -' + height + 'px;');

        var button = document.createElement('input'),
            negative = document.createElement('input'),
            buttons = document.createElement('div');
        
        buttons.setAttribute('style', 'float:left;margin-left: 211px;');

        button.setAttribute('id', lunch.core.genId());
        button.setAttribute('type', 'button');
        button.setAttribute('value', 'OK');
        button.setAttribute('class', 'lunch-button-info');
        button.setAttribute('style', 'margin:10px;padding-left:20px;padding-right:20px;');
        button.setAttribute('onmouseup', 'lunch.window.func();');

        negative.setAttribute('id', lunch.core.genId());
        negative.setAttribute('type', 'button');
        negative.setAttribute('value', 'Cancel');
        negative.setAttribute('class', 'lunch-button-info');
        negative.setAttribute('style', 'margin:10px;margin-left:5px;padding-left:20px;padding-right:20px;');
        negative.setAttribute('onmouseup', 'lunch.window.hide();');

        buttons.appendChild(button);
        buttons.appendChild(negative);

        el.appendChild(buttons);
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

        return wrap;
    },


    hide: function () {
        var el = document.getElementById('lunch-window-owner');

        if (el !== null) {
            el.parentNode.removeChild(el);
        }
    },

    func: function () {
        
    }
};
