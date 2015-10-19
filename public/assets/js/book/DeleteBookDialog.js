function DeleteBookDialog(){}

DeleteBookDialog.show = function(bookId){
    ConfirmationDialog.show({
        title: 'Opgelet!',
        message: 'Bent u zeker dat u dit boek wilt verwijderen?',
        type: "type-danger",
        onConfirmAction: function (){
            BookService.deleteBook({
                bookId: bookId,
                showNotifications: true,
                onSuccess: function(){
                    NotificationRepository.addNotification({
                        title: "Boek verwijderd",
                        message: "",
                        type: "danger"
                    })
                    window.location.href = baseUrl + "/getBooks";
                }
            });
        }
    });
};