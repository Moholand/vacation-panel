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