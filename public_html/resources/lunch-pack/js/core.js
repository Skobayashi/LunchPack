var lunch = {};

lunch.core = {

    id: 1,

    init: function () {
        
        if (lunch.button !== undefined) {
            lunch.button.init();
        }

    },

    genId: function () {
        var id = 'lunch-' + lunch.core.id;
        lunch.core.id += 1;
        return id;
    }
};
