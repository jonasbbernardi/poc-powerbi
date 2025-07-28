function showError(error) {
  console.error(error);
  const content = document.querySelector('#content');
  content.className = "buttons disabled";
  document.querySelector('#report-container .loading').style = "display: none";
  document.querySelector('#report-container .report-error').innerHTML = error;
  document.querySelector('#report-container .report-error').style = "display: block";
  throw Error(error);
}

function getConfigurations() {
  var xmlHttp = new XMLHttpRequest();
  xmlHttp.open( "GET", '/token', false );
  xmlHttp.send( null );
  console.log(xmlHttp.statusText);
  const response = JSON.parse(xmlHttp.responseText);
  if(!!response.status) throw Error(response.message);

  const embedConfiguration = {
    type: 'report',
    tokenType: 1,
    embedUrl: response.embedUrl,
    accessToken: response.embedToken
  };

  return embedConfiguration;
}

function addEventListeners(report) {
  document.querySelector('#content .print-report').addEventListener('click', (e) => {
    e.preventDefault();
    report.print().catch(console.error);
  });
  document.querySelector('#content .reload-report').addEventListener('click', (e) => {
    e.preventDefault();
    report.reload().catch(console.error);
  });
  document.querySelector('#content .fullscreen-report').addEventListener('click', (e) => {
    e.preventDefault();
    report.fullscreen();
  });
}

function embedPowerBi() {
  const reportContainer = document.getElementById('report-container');
  const embedConfiguration = getConfigurations();
  const report = powerbi.embed(reportContainer, embedConfiguration);
  addEventListeners(report);
  const content = document.querySelector('#content');
  content.className = "buttons";
}

function load() {
  try{
    embedPowerBi();
  } catch(error) {
    showError(error)
  }
}

window.onload = load;