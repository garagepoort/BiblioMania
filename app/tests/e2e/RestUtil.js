var request = require('request');
var q = require('q');

request.defaults({
    jar : true
});

exports.doRequest = function(url, method) {
    var deferred = q.defer();

    var options = {
        url: url,
        method: method
    };

    console.log("Calling", url);

    request(options, function(error, message, body) {
        console.log("Done call to", url);

        if (error) {
            console.log(error);
            expect(error).toBeNull();
            deferred.reject(new Error(error));
        } else if (!message) {
            expect(message).not.toBeNull();
            deferred.reject(new Error('message is null'));
        } else if (message.statusCode >= 400) {
            console.log(message.body);
            expect(message.statusCode).toBeLessThan(400);
            deferred.reject(new Error('message statuscode is greater than 400'));
        } else {
            var val = body ? JSON.parse(body) : undefined;
            deferred.resolve(val);
        }
    });

    return deferred.promise;
};