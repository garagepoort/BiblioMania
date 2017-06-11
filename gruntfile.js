module.exports = function (grunt) {
    grunt.initConfig({

        less: {
            development: {
                files: {
                    'resources/assets/main/css/custom.css': 'resources/assets/main/css/custom.less',
                    'resources/assets/main/css/statistics.css': 'resources/assets/main/css/statistics.less'
                }
            }
        },

        concat: {
            js: {
                src: ['resources/assets/main/angular/angular-charts/Chart.min.js', 'resources/assets/main/angular/angular-charts/angular-chart.min.js', 'resources/assets/main/**/*.js'],
                dest: 'resources/assets/main.js'
            }
        },
        uglify: {
            js: {
                src: 'resources/assets/main.js',
                dest: 'resources/assets/main.min.js'
            }
        },
        cssmin: {
            options: {
                shorthandCompacting: false,
                roundingPrecision: -1
            },
            target: {
                files: {
                    'resources/assets/main.min.css': ['resources/assets/main/**/*.css']
                }
            }
        },
        //hash: {
        //    js: {
        //        src: 'resources/assets/main.min.js',
        //        dest: 'public/assets/'
        //    },
        //    css: {
        //        src: 'resources/assets/main.min.css',
        //        dest: 'public/assets/'
        //    }
        //},
        filehash: {
            your_target: {
                files: [{
                    cwd: 'resources/assets',
                    src: ['main.min.js', 'main.min.css'],
                    dest: 'public/assets'
                }]
            }
        },
        clean: ['resources/assets/main.js', 'resources/assets/main.*.js', 'resources/assets/main.*.css'],
        injector: {
            options: {
                ignorePath: 'public',
                addRootSlash: false
            },
            local_dependencies: {
                files: {
                    'resources/views/index.php': [
                        'public/packages/bendani/php-common/uiframework/jquery.js',
                        'public/packages/bendani/php-common/uiframework/uiframework.min.js',
                        'public/assets/**/*.js',
                        'public/packages/bendani/php-common/**/*.js',
                        'public/packages/bendani/php-common/**/*.css',
                        'public/assets/**/*.css'
                    ]
                }
            }
        }
    });

// load plugins
    grunt.loadNpmTasks('grunt-contrib-watch');
    grunt.loadNpmTasks('grunt-contrib-uglify');
    grunt.loadNpmTasks('grunt-contrib-less');
    grunt.loadNpmTasks('grunt-contrib-concat');
    grunt.loadNpmTasks('grunt-contrib-cssmin');
    grunt.loadNpmTasks('grunt-contrib-clean');
    grunt.loadNpmTasks('grunt-injector');
    grunt.loadNpmTasks('grunt-file-hash');

// register at least this one task
    grunt.registerTask('default', ['less', 'concat', 'uglify', 'cssmin', 'filehash', 'clean', 'injector']);


};
