module.exports = function (grunt) {
    grunt.initConfig({

        concat: {
            js: {
                src: ['resources/assets/main/angular/angular-charts/Chart.min.js','resources/assets/main/angular/angular-charts/angular-chart.min.js', 'resources/assets/main/**/*.js'],
                dest: 'resources/assets/concatMain.js'
            }
        },
        uglify: {
            js: {
                src: 'resources/assets/concatMain.js',
                dest: 'public/assets/main.min.js'
            }
        },
        cssmin: {
            options: {
                shorthandCompacting: false,
                roundingPrecision: -1
            },
            target: {
                files: {
                    'public/assets/main.min.css': ['resources/assets/main/**/*.css']
                }
            }
        },
        clean: ['resources/assets/concatMain.js']
    });

// load plugins
    grunt.loadNpmTasks('grunt-contrib-watch');
    grunt.loadNpmTasks('grunt-contrib-uglify');
    grunt.loadNpmTasks('grunt-contrib-concat');
    grunt.loadNpmTasks('grunt-contrib-cssmin');
    grunt.loadNpmTasks('grunt-contrib-clean');

// register at least this one task
    grunt.registerTask('default', [ 'concat', 'uglify', 'cssmin', 'clean']);


};
