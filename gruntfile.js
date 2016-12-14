/*
 * grunt
 * http://gruntjs.com/
 *
 * Copyright (c) 2013 "Cowboy" Ben Alman
 * Licensed under the MIT license.
 * https://github.com/gruntjs/grunt/blob/master/LICENSE-MIT
 */

(function () {
  'use strict';
  module.exports = function(grunt) {

    var pkg = grunt.file.readJSON('package.json');

    // Load dependancies
    var dep, dependencies, _i, _len;

    dependencies = Object.keys(pkg.devDependencies).filter(function(o) {
      return (/^grunt-.+/).test(o);
    });

    for (_i = 0, _len = dependencies.length; _i < _len; _i++) {
      dep = dependencies[_i];
      grunt.loadNpmTasks(dep);
    }

    grunt.initConfig({

      pkg: pkg,
      // Manage Sass compilation
      sass: {
        dist: {
          options: {
            quiet: false,
            cacheLocation: '<%= pkg.pathlocal.scss %>/.sass-cache'
          },
          files: {
            '<%= pkg.pathlocal.css %>/style.css': '<%= pkg.pathlocal.scss %>/style.scss'
          }
        }
      },
      // JShint to show errors in this file
      jshint: {
        all: ['Gruntfile.js']
      },
      // Watch for changes to files
      watch: {
        css: {
          files: ['<%= pkg.pathlocal.scss %>/**/*.scss'],
          tasks: ['sass' , 'copy']
        }//,
        //theme: {
          //files: ['remote/**/*'],
          //tasks: ['sync']
        //}
      },
      // BrowserSync when files have changed
      browserSync: {
            dev: {
                bsFiles: {
                    src : [
                        '<%= pkg.pathlocal.theme %>/css/style.css'
                        //'<%= pkg.path.js %>/*.js'
                    ]
                },
                options: {
                    watchTask: true,
                    proxy: '<%= pkg.site.devurl %>'
                }
            }
        },
        'sftp-deploy': {
          theme: {
            auth: {
              host: '<%= pkg.site.liveip %>',
              port: 22,
              authKey: 'FoundIn.ftppass'
            },
            cache: '/www/shares/sftpCache-theme-<%= pkg.site.devurl %>.json',
            src: '<%= pkg.pathlocal.theme %>',
            dest: '<%= pkg.pathlive.theme %>',
            //exclusions: ['/www/Sites/hws/webroot/wp-content/uploads'],
            //serverSep: '/',
            concurrency: 4,
            progress: true
          },
          plugins: {
            auth: {
              host: '<%= pkg.site.liveip %>',
              port: 22,
              authKey: 'FoundIn.ftppass'
            },
            cache: '/www/shares/sftpCache-plugins-<%= pkg.site.devurl %>.json',
            src: '<%= pkg.pathlocal.plugins %>',
            dest: '<%= pkg.pathlive.plugins %>',
            //exclusions: ['/www/Sites/hws/webroot/wp-content/uploads'],
            //serverSep: '/',
            concurrency: 4,
            progress: true
          }
        },
        concat: {
          options: {
            seperator: 'rn'
          },
        dist: {
          src:['<%= pkg.pathlocal.js %>/libs/*.js' , '<%= pkg.pathlocal.js %>/vendor/*.js'],
          dest: '<%= pkg.pathlocal.js %>/main.js'
        }
      },
      uglify:{
        options: {
          banner: '/*! <%= pkg.name %> <%= grunt.template.today("dd-mm-yyyy") %>; */'
        },
        dist: {
          files: {
            '<%= pkg.pathlocal.js %>/main.min.js': ['<%= concat.dist.dest %>']
          }
        }
      },
      copy: {
        main: {
          expand: true,
          cwd: 'library/css/',
          src: ['style.css'],
          dest: ''
        },
      },
    });

    grunt.registerTask('default', ['jshint', 'browserSync', 'watch', 'concat' , 'uglify']);
    grunt.registerTask('deploy-theme', ['sftp-deploy:theme']);
    grunt.registerTask('deploy-plugins', ['sftp-deploy:plugins']);
    grunt.registerTask('javascript' , ['concat' , 'uglify']);
    grunt.registerTask('try' , ['copy']);
    //grunt.registerTask('deploy', ['jshint', 'sftp-deploy:build']);
  };
}());
