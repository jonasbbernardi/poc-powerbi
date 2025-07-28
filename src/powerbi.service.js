const axios = require('axios');

const workspaceId   = process.env.WORKSPACEID;
const reportId      = process.env.REPORTID;

const getReportDatasetId = async (token) => {
  const headers = {
    'Content-Type': "application/json",
    'Authorization': `Bearer ${token}`
  }
  const url = `https://api.powerbi.com/v1.0/myorg/groups/${workspaceId}/reports/${reportId}`
  const resp = await axios.get(url, {headers});
  return {
    embedUrl: resp.data.embedUrl,
    datasetId: resp.data.datasetId
  };
}

const getEmebedToken = async (token, datasetId) => {
  const headers = {
    'Content-Type': "application/json",
    'Authorization': `Bearer ${token}`
  }
  const reportData = {
    reports: [ { id: reportId } ],
    datasets: [ { id: datasetId } ],
    targetWorkspaces: [ { id: workspaceId } ]
  }
  const url = "https://api.powerbi.com/v1.0/myorg/GenerateToken";
  const resp = await axios.post(url, reportData, {headers});
  return resp.data?.token;
}

module.exports = {
  getReportDatasetId,
  getEmebedToken
}