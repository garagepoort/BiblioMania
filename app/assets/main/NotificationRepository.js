function NotificationRepository(){}

NotificationRepository.getNotifications = function() {
    if(!sessionStorage.getItem("notifications")){
        var notifications = [];
        NotificationRepository.setNotifications(notifications);
    }
    return JSON.parse(sessionStorage.getItem("notifications"));
}

NotificationRepository.setNotifications = function(notifications) {
    sessionStorage.setItem("notifications", JSON.stringify(notifications));
}

/*
* notification
*       - title
*       - message
*       - type
* */
NotificationRepository.addNotification = function(notification){
    var notifications = NotificationRepository.getNotifications();
    notifications.push(notification);
    NotificationRepository.setNotifications(notifications);
};

NotificationRepository.showNotification = function(notification){
    showNotification(notification.title, notification.message, notification.type);
};

NotificationRepository.showNotifications = function(){
    var notifications = NotificationRepository.getNotifications();
    if(!notifications){
        notifications = [];
    }
    for (var i = 0; i < notifications.length; i++) {
        var notification = notifications[i];
        showNotification(notification.title, notification.message, notification.type);
        notification.remove = true;
    }
    notifications = notifications.filter(function (notification) {
        if (notification.remove) {
            return false;
        }
        return true;
    });

    NotificationRepository.setNotifications(notifications);
};