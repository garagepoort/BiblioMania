angular
    .module('com.bendani.bibliomania.random.fact.directive', [])
    .directive('randomFact', function (){
        return {
            scope: {
                fact: '='
            },
            restrict: "E",
            templateUrl: "../BiblioMania/views/partials/randomfacts/random-fact-directive.html",
            controller: [function(){
                var vm = this;
                vm.getFact = getFact;
                vm.getKey = getKey;
                vm.getIcon = getIcon;

                var iconMap = {
                    'author.birthday': 'fa-birthday-cake',
                    'book.read.one.year': 'fa-book',
                    'book.read.five.year': 'fa-book',
                    'book.read.ten.year': 'fa-book',
                    'book.received.one.year': 'fa-book',
                    'book.received.five.year': 'fa-book',
                    'book.received.ten.year': 'fa-book',
                    'book.released.one.year': 'fa-book',
                    'book.released.five.year': 'fa-book',
                    'book.released.ten.year': 'fa-book',
                    'books.read.month': 'fa-book'
                };

                function getKey() {
                    return vm.fact.key.split('.').join("");
                }

                function getIcon() {
                    return iconMap[vm.fact.key];
                }

                function getFact() {
                    if(vm.fact.key == 'book.read.one.year') {
                        return getStringRead(1);
                    }
                    if(vm.fact.key == 'book.read.five.year') {
                        return getStringRead(5);
                    }
                    if(vm.fact.key == 'book.read.ten.year') {
                        return getStringRead(10);
                    }

                    if(vm.fact.key == 'book.released.one.year') {
                        return getStringRelease(1);
                    }
                    if(vm.fact.key == 'book.released.five.year') {
                        return getStringRelease(5);
                    }
                    if(vm.fact.key == 'book.released.ten.year') {
                        return getStringRelease(10);
                    }

                    if(vm.fact.key == 'book.received.one.year') {
                        return 'Je hebt dit boek 1 jaar geleden verkregen: ' + vm.fact.variables['book'];
                    }
                    if(vm.fact.key == 'book.received.five.year') {
                        return 'Je hebt dit boek 5 jaar geleden verkregen: ' + vm.fact.variables['book'];
                    }
                    if(vm.fact.key == 'book.received.ten.year') {
                        return 'Je hebt dit boek 10 jaar geleden verkregen: ' + vm.fact.variables['book'];
                    }

                    if(vm.fact.key == 'book.suggestion') {
                        return 'Je hebt dit boek meer als 5 jaar geleden gekocht en nog niet gelezen: ' + vm.fact.variables['book'];
                    }

                    if(vm.fact.key == 'author.birthday') {
                        return 'Auteur is jarig! ' + vm.fact.variables['author'];
                    }

                    if(vm.fact.key == 'books.read.month') {
                        var diff = vm.fact.variables['count'] - vm.fact.variables['previousCount'];
                        var stringle = 'Dat zijn evenveel boeken als vorige maand.';
                        if(diff == 1) {
                            stringle = 'Dat is 1 boek meer als vorige maand.';
                        }
                        if(diff > 1) {
                            stringle = 'Dat zijn ' + diff + ' meer boeken als vorige maand.';
                        }
                        if(diff == -1) {
                            stringle = 'Dat is 1 boek minder als vorige maand.';
                        }
                        if(diff < -1) {
                            stringle = 'Dat zijn ' + diff + ' minder boeken als vorige maand.';
                        }
                        if(vm.fact.variables['count'] == 1){
                            return 'Je hebt 1 boek gelezen in ' + monthToString(vm.fact.variables['month']) + ' ' + vm.fact.variables['year'] + '. ' + stringle;
                        }
                        return 'Je hebt ' +  vm.fact.variables['count'] + ' boeken gelezen in ' + monthToString(vm.fact.variables['month']) + ' ' + vm.fact.variables['year'] + '. ' + stringle;
                    }
                }

                function getStringRelease($years){
                    return 'Het volgende boek is exact ' + $years + ' jaar geleden uitgekomen: <b>' + vm.fact.variables['book'] + '</b>';
                }

                function getStringRead($years){
                    return 'Je hebt het volgende boek exact ' + $years + ' jaar geleden uitgelezen: <b>' + vm.fact.variables['book'] + '</b>';
                }


                function monthToString(key){
                    var months = {
                        "1":'januari',
                        "2":'"februari',
                        "3":'maart',
                        "4":'april',
                        "5":'mei',
                        "6":'juni',
                        "7":'juli',
                        "8":'augustus',
                        "9":'september',
                        "10":'oktober',
                        "11":'november',
                        "12":'december'
                    };
                    return months[key];
                }
            }],
            controllerAs: 'vm',
            bindToController: true
        };
    });