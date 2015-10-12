module.exports = function (grunt) {
    grunt.initConfig({

        concat: {
            js: {
                src: ['app/assets/main/**/*.js'],
                dest: 'app/assets/concatMain.js'
            }
        },
        uglify: {
            js: {
                src: 'app/assets/concatMain.js',
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
                    'public/assets/main.min.css': ['app/assets/main/**/*.css']
                }
            }
        },
        clean: ['app/assets/concatMain.js']
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
