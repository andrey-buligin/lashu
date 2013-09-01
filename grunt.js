/*global module:false*/
module.exports = function(grunt) {

  // Project configuration.
  grunt.initConfig({
    pkg: '<json:package.json>',
    meta: {
      banner: '/*! <%= pkg.title || pkg.name %> - v<%= pkg.version %> - ' +
        '<%= grunt.template.today("yyyy-mm-dd") %>\n' +
        '<%= pkg.homepage ? "* " + pkg.homepage + "\n" : "" %>' +
        '* Copyright (c) <%= grunt.template.today("yyyy") %> <%= pkg.author.name %>;' +
        ' Licensed <%= _.pluck(pkg.licenses, "type").join(", ") %> */'
    },
    lint: {
      files: ['grunt.js', 'js/skins/hanna/*.js']
    },
    concat: {
      slider: {
        src: ['js/galleries/horizontal_slider/jquery.tmpl.min.js',
              'js/galleries/horizontal_slider/jquery.touchwipe.min.js',
              '<config:min.slider.dest>'
              ],
        dest: 'js/galleries/horizontal_slider/slider.min.js'
      },
      main: {
        src: ['js/jquery-1.8.2.min.js', '<config:min.main.dest>'],
        dest: 'js/<%= pkg.name %>.min.js'
      }
    },
    min: {
      slider: {
        src: ['<banner:meta.banner>',
              'js/galleries/horizontal_slider/jquery.imagesloaded.js',
              'js/galleries/horizontal_slider/jquery.elastislide.js',
              'js/galleries/horizontal_slider/slider.js'],
        dest: 'js/galleries/horizontal_slider/slider_custom.min.js'
      },
      book: {
        src: [
              'js/plugins/jquerypp.custom.js',
              'js/plugins/jquery.bookblock.js'],
        dest: 'js/plugins/jquery.bookblock.min.js'
      },
      main: {
        src: ['<banner:meta.banner>',
              'js/plugins/jquery.easing.1.3.js',
              'js/plugins/validation.js',
              'js/skins/hanna/*.js'],
        dest: 'js/<%= pkg.name %>_custom.min.js'
      }
    },
    cssmin: {
      css: {
        src: ['<banner:meta.banner>', 'css/main.css', 'css/normalize.css', 'css/skins/hanna/main.css'],
        dest: 'css/<%= pkg.name %>.css'
      }
    },
    jshint: {
      options: {
        curly: true,
        eqeqeq: true,
        immed: true,
        latedef: true,
        newcap: true,
        noarg: true,
        sub: true,
        undef: true,
        boss: true,
        eqnull: true,
        browser: true
      },
      globals: {
        jQuery: true
      }
    },
    uglify: {}
  });

  grunt.loadNpmTasks('grunt-css');

  // Default task.
  // Minify Main slider files, then cocat with already minified plugins
  // Concat css
  // Concat main files then  minify them and concat it with minified plugins
  grunt.registerTask('default', 'min:slider min:book concat:slider cssmin:css min:main concat:main');

};
