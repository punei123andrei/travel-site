exports.handler = function (event, context, callback) {
  //run some logic
  let body;
  const secret = `
  <h3>Welcome to the secret area</h3>
  <p>The sky is blue</p>
  `;
  if (event.body) {
    body = JSON.parse(event.body);
  } else {
    body = {};
  }
  if (body.password == "javascript") {
    callback(null, {
      statusCode: 200,
      body: secret,
    });
  } else {
    callback(null, {
      statusCode: 401,
    });
  }
};
