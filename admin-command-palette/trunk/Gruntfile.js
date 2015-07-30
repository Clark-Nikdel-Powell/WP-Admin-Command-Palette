/*global module:false*/
module.exports = function(grunt) {

  // Project configuration.
  grunt.initConfig({
    // Metadata.
    pkg: grunt.file.readJSON('package.json'),
    concat: {
      admin: {
        dest: 'admin/js/admin.js',
        src: [
          'admin/js/pre/vendor/fuse.js',
          'admin/js/pre/vendor/mousetrap.js',
          'admin/js/pre/vendor/mousetrap-bind-global.js',
          'admin/js/pre/vendor/ractive.js',
          'admin/js/pre/intro.js',
          'admin/js/pre/acp-modal.js',
          'admin/js/pre/acp-search.js',
          'admin/js/pre/acp-results-traversal.js',
          'admin/js/pre/acp-keyboard-shortcuts.js',
          'admin/js/pre/admin.js',
          'admin/js/pre/outro.js',
        ]
      }
    },
    uglify: {
      options: {
        mangle: false,
      },
      admin: {
        files: {
          'admin/js/admin.min.js': ['admin/js/admin.js']
        }
      },
      public: {
        files: {
          'public/js/admin.min.js': ['public/js/pre/admin.js']
        }
      }
    },
    jshint: {
      options: {
        devel: true,
        curly: true,
        eqeqeq: true,
        immed: true,
        latedef: true,
        newcap: true,
        noarg: true,
        sub: true,
        undef: true,
        unused: false,
        boss: true,
        eqnull: true,
        browser: true,
        globals: {
          $: false,
          'jQuery': false,
          'acp_user_options': false,
          'acp_search_data': false,
          'Fuse': false,
          'Ractive': false,
          'Mousetrap': false,
          'acpAjax': false
        }
      },
      admin: {
        src: ['admin/js/admin.js']
      },
      public: {
        src: ['public/js/public.js']
      },
    },
    sass: {
      admin: {
        options: {
          style: 'compressed',
          sourcemap: 'auto'
        },
        files: {
          'admin/css/acp-admin.css': ['admin/css/pre/acp-admin.scss']
        }
      },
      public: {
        options: {
          style: 'compressed',
          sourcemap: 'auto'
        },
        files: {
          'public/css/acp-public.css': ['public/css/pre/acp-public.scss']
        }
      }
    },
    watch: {
      sass_admin: {
        files: 'admin/css/pre/**/*.{scss,sass}',
        tasks: ['sass:admin']
      },
      sass_public: {
        files: 'public/css/pre/**/*.{scss,sass}',
        tasks: ['sass:public']
      },
      js_admin: {
        files: 'admin/js/pre/**/*.js',
        tasks: ['concat:admin', 'jshint:admin', 'uglify:admin']
      },
      js_public: {
        files: 'public/js/pre/**/*.js',
        tasks: ['concat:public', 'jshint:public', 'uglify:public']
      }
    }
  });

  // These plugins provide necessary tasks.
  grunt.loadNpmTasks('grunt-contrib-concat');
  grunt.loadNpmTasks('grunt-contrib-uglify');
  grunt.loadNpmTasks('grunt-contrib-jshint');
  grunt.loadNpmTasks('grunt-contrib-sass');
  grunt.loadNpmTasks('grunt-contrib-watch');

  // Default task.
  grunt.registerTask('default', ['jshint', 'uglify']);

};
