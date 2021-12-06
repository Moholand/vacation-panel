// Mark as read Notifications
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