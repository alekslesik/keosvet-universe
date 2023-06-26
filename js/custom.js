var currentUrl = window.location.href;
var pageTitle = document.getElementsByTagName('h1')[0];

if (currentUrl.includes('/services/osveshchenie/') === true) {
  pageTitle.style.display = 'none';
}