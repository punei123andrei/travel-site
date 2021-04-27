exports.handler = function (event, contntext, callback) {
  callback(null, {
    statusCode: 200,
    body: "welcome to the secret area",
  });
};
