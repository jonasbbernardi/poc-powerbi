const axios = require('axios');
const querystring = require('node:querystring');

const tenant_id     = process.env.TENANT_ID;
const client_id     = process.env.CLIENT_ID;
const client_secret = process.env.CLIENT_SECRET;

const getToken = async () => {
  const url           = `https://login.microsoftonline.com/${tenant_id}/oauth2/v2.0/token`;
  const scope         = 'https://analysis.windows.net/powerbi/api/.default';
  const grant_type    = 'client_credentials';

  const q = querystring.stringify({
    client_id, client_secret, scope, grant_type
  })
  const headers = {'Content-Type': 'application/x-www-form-urlencoded'};

  const resp = await axios.post(url, q, {headers});
  return resp.data?.access_token;
}

module.exports = { getToken };