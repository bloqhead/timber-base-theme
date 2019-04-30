/*global module:false*/
module.exports = function(grunt) {
    require('time-grunt')(grunt);
    grunt.initConfig({
        pkg: grunt.file.readJSON('package.json'),

        // Sass / Scss
        sass: {
            options: {
                loadPath: [ 'node_modules' ],
                style: 'expanded',
                lineNumbers: false,
            },
            dist: {
                files: {
                    'assets/css/style.css' : 'assets/scss/style.scss',
                    'assets/css/grid.css': 'assets/scss/grid.scss'
                }
            },
        },

        // PostCSS
        postcss: {
            options: {
                map: true,
                processors: [
                    require('pixrem')(),
                    require('autoprefixer')({
                        browsers: 'last 4 versions'
                    })
                ]
            },
            dist: {
                src: 'assets/css/style.css'
            },
            grid: {
                src: 'assets/css/grid.css'
            }
        },

        // Combine media queries
        cmq: {
            dist: {
                files: {
                    './assets/css': 'assets/css/style.css',
                    './assets/css': 'assets/css/grid.css'
                }
            }
        },

        // CSSMin
        cssmin: {
            dist: {
                files: {
                    'assets/css/style.min.css': [
                        'assets/css/style.css'
                    ],
                    'assets/css/grid.min.css': [
                        'assets/css/grid.css'
                    ]
                }
            }
        },

        // Concatenation
        concat: {
            dist: {
                files: {
                    'assets/js/build.js': [
                        'assets/js/vendor/**/*.js',
                        '!assets/js/vendor/jquery.js',
                        '!assets/js/vendor/mentor/*.js',
                        'assets/js/modules/**/*.js',
                        '!assets/js/build.js',
                        '!assets/js/build.min.js'
                    ]
                },
                options: {
                    separator: ';'
                }
            }
        },

        // Uglify
        uglify: {
            options: {
                mangle: false
            },
            dist: {
              files: {
                'assets/js/build.min.js': [
                    'assets/js/build.js'
                ]
              }
            }
        },

        // Browsersync
        browserSync: {
            dist: {
                files: {
                    src: [
                        'assets/js/**/*.js',
                        'assets/scss/**/*.scss',
                        '*.html',
                        '*.php',
                        '*.twig'
                    ]
                },
                options: {
                    port: '<%= pkg.browsersync_port %>',
                    open: 'ui',
                    watchTask: true,
                    injectChanges: true
                }
            }
        },

        // Watch
        watch: {
            scripts: {
                files: [
                    'assets/js/**/*.js',
                    '!assets/js/vendor/**/*.js',
                    '!assets/js/modules/*.js',
                    '!assets/js/build.js',
                    '!assets/js/build.min.js'
                ],
                tasks: [ 'concat' ],
                options: {
                    livereload: 35728
                }
            },
            styles: {
                files: [
                    'assets/scss/**/*.scss'
                ],
                tasks: [ 'sass', 'cmq', 'postcss' ],
                options: {
                    livereload: 35729
                }
            },
            options: {
                livereload: true,
                livereloadOnError: false,
                // this blocks time-grunt from displaying
                // https://github.com/sindresorhus/time-grunt/issues/90
                nospawn: true
            }
        }
    });

    grunt.loadNpmTasks('grunt-newer');
    grunt.loadNpmTasks('grunt-contrib-concat');
    grunt.loadNpmTasks('grunt-contrib-uglify');
    grunt.loadNpmTasks('grunt-contrib-watch');
    grunt.loadNpmTasks('grunt-contrib-sass');
    grunt.loadNpmTasks('grunt-postcss');
    grunt.loadNpmTasks('grunt-combine-media-queries');
    grunt.loadNpmTasks('grunt-contrib-cssmin');
    grunt.loadNpmTasks('grunt-browser-sync');

    // Default task
    grunt.registerTask('default', [ 'sass:dist', 'cmq:dist', 'postcss:dist', 'postcss:grid', 'concat' ]);

    // BrowserSync
    grunt.registerTask('browsersync', [ 'browserSync', 'dev' ]);

    // Build for distribution (prior to launch)
    grunt.registerTask('build', [ 'default', 'cssmin'/*, 'uglify'*/]);
};
