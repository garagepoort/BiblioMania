angular
    .module('com.bendani.bibliomania.book.detail.first.print.info.directive', [
        'com.bendani.bibliomania.first.print.info.model',
        'com.bendani.bibliomania.first.print.selection.modal.service'
    ])
    .directive('bookDetailFirstPrintInfo', function () {
        return {
            scope: {
                book: '='
            },
            restrict: "E",
            templateUrl: "../BiblioMania/views/partials/book/book-detail-first-print-info-directive.html",
            controller: ['$location','FirstPrintInfo', 'FirstPrintSelectionModalService', 'growl', 'ErrorContainer', BookDetailFirstPrintInfoController],
            controllerAs: 'vm',
            bindToController: true
        };
    });

function BookDetailFirstPrintInfoController($location, FirstPrintInfo, FirstPrintSelectionModalService, growl, ErrorContainer) {
    var vm = this;

    vm.showSelectFirstPrintDialog = showSelectFirstPrintDialog;
    vm.createFirstPrintInfo = createFirstPrintInfo;
    vm.editFirstPrintInfo = editFirstPrintInfo;

    function showSelectFirstPrintDialog() {
        FirstPrintSelectionModalService.show(function (firstPrint) {
            FirstPrintInfo.linkBook({id: firstPrint.id}, {bookId: vm.book.id}, function(){
                vm.book.firstPrintInfo = FirstPrintInfo.get({id: firstPrint.id}, function(){}, ErrorContainer.handleRestError);
                growl.addSuccessMessage('Eerste druk gewijzigd');
            }, ErrorContainer.handleRestError);
        });
    }

    function createFirstPrintInfo(){
        $location.path('/create-first-print-and-link-to-book/'+ vm.book.id);
    }

    function editFirstPrintInfo(){
        $location.path('/edit-first-print/'+ vm.book.firstPrintInfo.id);
    }
}