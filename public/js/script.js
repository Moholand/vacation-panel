// Mark as read Notifications
axios.defaults.baseURL = 'http://127.0.0.1:8000/';

let bell = document.querySelector('.dropdown-bell');

bell.addEventListener('click', function(e) {
  let userId = document.querySelector('.dropdown-bell').getAttribute("data-user-id");

  axios.post('api/user-notifications-markAsRead', {
    userId
  })
  .then(function (response) {
    bell.classList.add('read');
  });
});

// SideBar Transition
let sidebarShow = document.querySelector('.sidebar-show button');
let sidebarHide = document.querySelector('.sidebar-hide button');
let sidebar = document.querySelector('.sidebar');

sidebarShow.addEventListener('click', function() {
  sidebar.classList.add('show');
});

sidebarHide.addEventListener('click', function() {
  sidebar.classList.remove('show');
});

// Remove alert message from dom
$(document).on('click', '.alert-success .close-message', function() {
  $(this).parent().remove();
});