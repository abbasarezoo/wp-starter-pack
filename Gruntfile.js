module.exports = function(grunt) {

    grunt.initConfig({
        pkg: grunt.file.readJSON('package.json'),

        // ====================================================================================================
        // INDIVIDUAL TASKS
        // ====================================================================================================

        // =========================
        // CSS
        // =========================

        // Compile CSS files

        sass: {
            
            options: {
                sourceMap: true
            },

            dist: {
                files: [{
                    expand: true,
                    cwd: '_css-src', // Targets a directory
                    src: ['*.scss'], // Targets file extensions to run the task against
                    dest: 'www/wp-content/themes/wp-starter-pack/', // The directory where the processed CSS files go to
                    ext: '.css' // File extension added after the task is run
                }]
            }

        },

        // Add sourcemap, vendor prefixes and minify output

        postcss: {
            
            options: {
                map: {
                    inline: false, // Save all sourcemaps as separate files
                    annotation: 'www/wp-content/themes/wp-starter-pack/' // The directory where the sourcemaps are written to
                },
                processors: [
                    require('autoprefixer')({browsers: 'last 3 versions'}), // Adds vendor prefixes
                    require('cssnano')() // Minify the CSS
                ]
            },

            dist: {
                src: 'www/wp-content/themes/wp-starter-pack/*.css' // Which css files are processed
            }

        },

        // =========================
        // JAVASCRIPT
        // =========================

        // Concatenate all local Javascript files into a single file

        uglify: {

            compile: {
                files: {
                    'www/wp-content/themes/wp-starter-pack/scripts/main.min.js': ['_js-src/*.js']
                }
            }

        },

        // =========================
        // IMAGES
        // =========================

        // Optimise all images in a specific directory

        imagemin: {
            
            optimise: {
                files: [{
                    expand: true,
                    cwd: '_img-src', // Targets a directory
                    src: ['*.{png,jpg,gif,svg}'], // File types to target
                    dest: 'www/wp-content/themes/wp-starter-pack/images' // The directory where the optimised images go to
                }]
            }

        },

        // ====================================================================================================
        // WATCH TASKS
        // Tasks are registered underneath this block
        // Any task names can be referred to there
        // ====================================================================================================

        watch: {

            php: { 

                files: ['www/wp-content/themes/wp-starter-pack/**/*.php'],
                    options: {
                        spawn: false,
                        livereload:35729,
                        event: ['added', 'changed']
                    },

            },


            css: {

                files: ['_css-src/**/*.scss'], // Looks for any files added or changed in this directory with the .scss extension ...
                tasks: ['css'], // ... and runs the 'css' task ...
                    options: {
                        spawn: false,
                        livereload:35729,
                        event: ['added', 'changed']
                    },

            },

            js: {

                files: ['_js-src/*.js'], // Looks for any files added or changed in this directory with the .js extension ...
                tasks: ['js'], // ... and runs the 'js' task ...
                    options: {
                        spawn: false,
                        livereload:35729,
                        event: ['added', 'changed']
                    },
                    
            },

            img: {

                files: ['_img-src/**'], // Looks for any images added or changed in this directory ...
                tasks: ['img'], // ... and runs the 'img' task ...
                    options: {
                        spawn: false,
                        livereload:35729,
                        event: ['added', 'changed']
                    },
                    
            },

        },

        // ====================================================================================================
        // NOTIFICATIONS
        // Get a notification when the task has ran successfully or when it fails
        // ====================================================================================================

        notify: {
            
            sass: {
                options: {
                    title: "Grunt",
                    message: "CSS compiled"
                }
            },

            uglify: {
                options: {
                    title: "Grunt",
                    message: "JS compiled"
                }
            },

            codekit: {
                options: {
                    title: "Grunt",
                    message: "HTML compiled"
                }
            },

            imagemin: {
                options: {
                    title: "Grunt",
                    message: "Images compressed"
                }
            }

        },

        // ====================================================================================================
        // NOTIFICATIONS
        // Get a notification when the task has ran successfully or when it fails
        // ====================================================================================================


        sasslint: {
            options: {
                configFile: '_css-src/.sass-lint.yml',
                formatter: 'stylish',
               // outputFile: '_css-src/report.xml'
            },
            target: ['_css-src/**/*.scss']
        },



    });

    // ====================================================================================================
    // LOAD TASKS
    // ====================================================================================================

    grunt.loadNpmTasks('grunt-contrib-watch');
    grunt.loadNpmTasks('grunt-contrib-imagemin');
    grunt.loadNpmTasks('grunt-contrib-uglify');
    grunt.loadNpmTasks('grunt-postcss');
    grunt.loadNpmTasks('grunt-sass');
    grunt.loadNpmTasks('grunt-notify');
    grunt.loadNpmTasks('grunt-codekit');

    // ====================================================================================================
    // REGISTER TASKS
    // ====================================================================================================

    grunt.registerTask('css', ['sass', 'postcss', 'notify:sass']);
    grunt.registerTask('js', ['uglify', 'notify:uglify']);
    grunt.registerTask('kit', ['codekit', 'notify:codekit']);
    grunt.registerTask('img', ['imagemin', 'notify:imagemin']);
    grunt.registerTask('lint', ['sasslint']);


};