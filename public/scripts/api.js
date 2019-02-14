$api = {
    call: function (action, data, callback) {
        const splits = action.split('/');
        if (splits.length !== 2) {
            throw new Error('Invalid action parameter. Expected format "domain/action"');
        }

        const domain = splits[0];
        action = splits[1];

        $.post('/api/' + domain + '/?action=' + action, data, callback);
    }
};
