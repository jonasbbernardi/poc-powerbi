const express = require('express');
const path = require('path');
require('dotenv').config();

const service = require('./token.service');

const app = express();
app.use(express.json());

app.get('/token', async (req, res) => {
  try {
    const credentials = await service.getCredentials();
    return res.json(credentials);
  } catch (error) {
    return res.json({
      status: 'error',
      message: error.message || error.error_description
    })
  }
});

app.use(express.static(path.join(__dirname, "../public"), {}));

const port = process.env.PORT || 8000
app.listen(port, function() {
  console.log("Express server listening on port " + port);
});