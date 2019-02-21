$api = {
    call: function (action, data, callback) {
        const splits = action.split('/');
        if (splits.length !== 2) {
            throw new Error('Invalid action parameter. Expected format "domain/action"');
        }

        const domain = splits[0];
        action = splits[1];

        $.post('/api/' + domain + '/?XDEBUG_SESSION_START=PHPSTORM&action=' + action, data, callback);
    },

    formData: function (form) {
        const data = $(form).serializeArray();
        const result = {};

        for (const d of data) {
            result[d.name] = d.value;
        }

        return result;
    }
};
