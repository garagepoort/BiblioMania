function NotificationRepository(){}

/*
* notification
*       - title
*       - message
*       - type
* */
NotificationRepository.addNotification = function(notification){
    var notifications = sessionStorage.getItem("notifications");
    if(!notifications){
        notifications = [];
    }
    notifications.push(notification);
    sessionStorage.setItem("notifications", notifications);
};

NotificationRepository.showNotifications = function(){
    var notifications = sessionStorage.getItem("notifications");
    if(!notifications){
        notifications = [];
    }
    for (var i = 0; i < notifications.length; i++) {
        var notification = notifications[i];
        showNotification(notification.title, notification.message, notification.type);
    }
};