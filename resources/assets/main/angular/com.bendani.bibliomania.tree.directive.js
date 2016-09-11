(function () {

    angular.module('com.bendani.bibliomania.tree.directive', [])
        .directive('treeView', [function () {
            return {
                restrict: 'E',
                templateUrl: "../BiblioMania/views/partials/tree-view.html",
                replace: true,
                scope: {
                    treeData: '=',
                    onSelect: '&',
                    initialSelection: '@',
                    treeControl: '='
                },
                link: function ($scope, element, attrs) {
                    $scope.treeRows = [];

                    $scope.$watch('treeData', function(newValue){
                        if($scope.treeData !== undefined){
                            $scope.treeRows = [];
                            for(var i =0; i<$scope.treeData.length; i++){
                                var node = $scope.treeData[i];
                                $scope.treeRows.push.apply($scope.treeRows, getChildrenOfNode(node));
                            }
                        }
                    }, true);

                    $scope.clickBranch = function(branch){
                        console.log("branch selected: " + branch);
                    };

                    function getChildrenOfNode(node){
                        var children = [];
                        children.push(node);
                        for(var i =0; i<node.children.length; i++){
                            var child = node.children[i];
                            children.push.apply(children, getChildrenOfNode(child));
                        }
                        return children;
                    }

                    if ($scope.treeControl != null) {
                        if (angular.isObject($scope.treeControl)) {
                            tree = $scope.treeControl;
                            tree.expand_all = function () {
                                return for_each_branch(function (b, level) {
                                    return b.expanded = true;
                                });
                            };
                            tree.collapse_all = function () {
                                return for_each_branch(function (b, level) {
                                    return b.expanded = false;
                                });
                            };
                            tree.get_first_branch = function () {
                                treeDataLength = $scope.treeData.length;
                                if (treeDataLength > 0) {
                                    return $scope.treeData[0];
                                }
                            };
                            tree.select_first_branch = function () {
                                var b;
                                b = tree.get_first_branch();
                                return tree.select_branch(b);
                            };
                            tree.get_selected_branch = function () {
                                return selected_branch;
                            };
                            tree.get_parent_branch = function (b) {
                                return get_parent(b);
                            };
                            tree.select_branch = function (b) {
                                select_branch(b);
                                return b;
                            };
                            tree.get_children = function (b) {
                                return b.children;
                            };
                            tree.select_parent_branch = function (b) {
                                var p;
                                if (b == null) {
                                    b = tree.get_selected_branch();
                                }
                                if (b != null) {
                                    p = tree.get_parent_branch(b);
                                    if (p != null) {
                                        tree.select_branch(p);
                                        return p;
                                    }
                                }
                            };
                            tree.add_branch = function (parent, new_branch) {
                                if (parent != null) {
                                    parent.children.push(new_branch);
                                    parent.expanded = true;
                                } else {
                                    $scope.treeData.push(new_branch);
                                }
                                return new_branch;
                            };
                            tree.add_root_branch = function (new_branch) {
                                tree.add_branch(null, new_branch);
                                return new_branch;
                            };
                            tree.expand_branch = function (b) {
                                if (b == null) {
                                    b = tree.get_selected_branch();
                                }
                                if (b != null) {
                                    b.expanded = true;
                                    return b;
                                }
                            };
                            tree.collapse_branch = function (b) {
                                if (b == null) {
                                    b = selected_branch;
                                }
                                if (b != null) {
                                    b.expanded = false;
                                    return b;
                                }
                            };
                            tree.get_siblings = function (b) {
                                var p, siblings;
                                if (b == null) {
                                    b = selected_branch;
                                }
                                if (b != null) {
                                    p = tree.get_parent_branch(b);
                                    if (p) {
                                        siblings = p.children;
                                    } else {
                                        siblings = $scope.treeData;
                                    }
                                    return siblings;
                                }
                            };
                            tree.get_next_sibling = function (b) {
                                var i, siblings;
                                if (b == null) {
                                    b = selected_branch;
                                }
                                if (b != null) {
                                    siblings = tree.get_siblings(b);
                                    treeDataLength = siblings.length;
                                    i = siblings.indexOf(b);
                                    if (i < treeDataLength) {
                                        return siblings[i + 1];
                                    }
                                }
                            };
                            tree.get_prev_sibling = function (b) {
                                var i, siblings;
                                if (b == null) {
                                    b = selected_branch;
                                }
                                siblings = tree.get_siblings(b);
                                treeDataLength = siblings.length;
                                i = siblings.indexOf(b);
                                if (i > 0) {
                                    return siblings[i - 1];
                                }
                            };
                            tree.select_next_sibling = function (b) {
                                var next;
                                if (b == null) {
                                    b = selected_branch;
                                }
                                if (b != null) {
                                    next = tree.get_next_sibling(b);
                                    if (next != null) {
                                        return tree.select_branch(next);
                                    }
                                }
                            };
                            tree.select_prev_sibling = function (b) {
                                var prev;
                                if (b == null) {
                                    b = selected_branch;
                                }
                                if (b != null) {
                                    prev = tree.get_prev_sibling(b);
                                    if (prev != null) {
                                        return tree.select_branch(prev);
                                    }
                                }
                            };
                            tree.get_first_child = function (b) {
                                var _ref;
                                if (b == null) {
                                    b = selected_branch;
                                }
                                if (b != null) {
                                    if (((_ref = b.children) != null ? _ref.length : void 0) > 0) {
                                        return b.children[0];
                                    }
                                }
                            };
                            tree.get_closest_ancestor_next_sibling = function (b) {
                                var next, parent;
                                next = tree.get_next_sibling(b);
                                if (next != null) {
                                    return next;
                                } else {
                                    parent = tree.get_parent_branch(b);
                                    return tree.get_closest_ancestor_next_sibling(parent);
                                }
                            };
                            tree.get_next_branch = function (b) {
                                var next;
                                if (b == null) {
                                    b = selected_branch;
                                }
                                if (b != null) {
                                    next = tree.get_first_child(b);
                                    if (next != null) {
                                        return next;
                                    } else {
                                        next = tree.get_closest_ancestor_next_sibling(b);
                                        return next;
                                    }
                                }
                            };
                            tree.select_next_branch = function (b) {
                                var next;
                                if (b == null) {
                                    b = selected_branch;
                                }
                                if (b != null) {
                                    next = tree.get_next_branch(b);
                                    if (next != null) {
                                        tree.select_branch(next);
                                        return next;
                                    }
                                }
                            };
                            tree.last_descendant = function (b) {
                                var last_child;
                                if (b == null) {
                                    debugger;
                                }
                                treeDataLength = b.children.length;
                                if (treeDataLength === 0) {
                                    return b;
                                } else {
                                    last_child = b.children[treeDataLength - 1];
                                    return tree.last_descendant(last_child);
                                }
                            };
                            tree.get_prev_branch = function (b) {
                                var parent, prev_sibling;
                                if (b == null) {
                                    b = selected_branch;
                                }
                                if (b != null) {
                                    prev_sibling = tree.get_prev_sibling(b);
                                    if (prev_sibling != null) {
                                        return tree.last_descendant(prev_sibling);
                                    } else {
                                        parent = tree.get_parent_branch(b);
                                        return parent;
                                    }
                                }
                            };
                            return tree.select_prev_branch = function (b) {
                                var prev;
                                if (b == null) {
                                    b = selected_branch;
                                }
                                if (b != null) {
                                    prev = tree.get_prev_branch(b);
                                    if (prev != null) {
                                        tree.select_branch(prev);
                                        return prev;
                                    }
                                }
                            };
                        }
                    }
                }
            };
        }
    ]);

}).call(this);
