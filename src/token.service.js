const {
  getToken
} = require('./app-register.service');
const {
  getReportDatasetId,
  getEmebedToken
} = require('./powerbi.service');

const getCredentials = async () => {
  try {
    const token = await getToken();
    const reportData = await getReportDatasetId(token);
    const embedToken = await getEmebedToken(token, reportData.datasetId);
    return {
      embedToken,
      embedUrl: reportData.embedUrl
    };
  } catch (e) {
    console.error(e.response.status, e.response.data);
    throw Error('Cant get credentials.');
  }
}

module.exports = {getCredentials};