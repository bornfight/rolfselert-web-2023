// Get config
var path = require('path');
module.exports = function(grunt) {
  
  var config   = grunt.file.readJSON(__dirname + '/config.json');
  
  // Project configuration.
  grunt.initConfig({
    pkg: grunt.file.readJSON('package.json'),

    /*
      Concat
    */
    concat: {
      build: {
        src: [
          'js/vendor/jquery-2.1.4.min.js',
          'js/vendor/jquery.imagelightbox.min.js',
          'js/vendor/lightbox.js',
          'js/vendor/jquery.pjax.js',
          'js/vendor/froogaloop.min.js',
          'js/reo.js'
        ],
        dest: 'js/site.js'
      }
    },

    /*
      Uglify
    */
    uglify: {
        files: {
            src: 'js/site.js',
            dest: 'js/',
            expand: true,
            flatten: true,
            ext: '.min.js'
        }
    },

    /*
      Sass
    */
    sass: {
      dev: {
        options: {
          style: 'nested'
        },
        files : {
          'css/site.css' : 'scss/site.scss'
        }
      }
    },

     /*
      Combine Media Queries
    */
    cmq: {
      dev: {
        files: {
          'css/': [ 'css/*.css' ]
        }
      }
    },

    /*
      Minify CSS
    */
    cssmin: {
      combine: {
        files: {
          'css/site.min.css': [ 'css/site.css' ],
          'css/critical.min.css': [ 'css/critical.css' ]
        }
      }
    },

    /*
      Critial
    */
    criticalcss: {
      custom: {
        options: {
          url: "http://reo.dev",
          width: 1200,
          height: 900,
          outputfile: "css/critical.css",
          filename: path.resolve(path.join(__dirname, 'css/site.min.css')), // Using path.resolve( path.join( ... ) ) is a good idea here
          buffer: 800*1024,
          ignoreConsole: false
        }
      }
    },

    /*
      Watch
    */
    watch : {
      css : {
        files: '**/*.scss',
        tasks: ['sass', 'cssmin']
      },
      js : {
        files: 'js/reo.js',
        tasks: ['concat', 'uglify']
      }
    },

    /*
      Shell Exec
    */
    exec: {

      /*
        Sync DB
      */
      sync_db : {
        cmd : function () {

          var connection  = config.stage_connection,
              
              // Staging Stuff
              stage_url   = config.stage_url,
              stage_db    = config.stage_db.name,
              stage_user  = config.stage_db.user,
              stage_pass  = config.stage_db.pass,
              
              // Local Stuff
              local_url   = config.dev_url,
              local_db    = config.local_db.name,
              local_user  = config.local_db.user,
              local_pass  = config.local_db.pass,
              local_mysql = config.local_mysql,
              commands    = [];
          commands.push('ssh ' + connection + ' "mysqldump -u ' + stage_user + ' -p' + stage_pass + ' ' + stage_db + ' > ' + stage_db +'.sql"');
          
          commands.push('scp ' + connection + ':' + stage_db + '.sql . ');
          
          commands.push("sed -i .bak 's/" + stage_url + "/" + local_url + "/g' " + stage_db + ".sql ");
          
          commands.push(local_mysql + ' -u ' + local_user + ' -p' + local_pass + ' ' + local_db + ' < ' + stage_db + '.sql');
          
          commands.push('rm ' + stage_db + '.sql.bak');
          commands.push('rm ' + stage_db + '.sql');

          return commands.join('&&');
        }
      },
      
      /*
        Sync Assets
      */
      sync_uploads : {
        cmd : function () {
          var connection    = config.stage_connection,
              stage_uploads = config.stage_uploads,
              local_uploads = config.local_uploads,
              command       = '';

          command += 'rsync -chavzP --stats ' + connection + ':' + stage_uploads + ' ' + local_uploads;

          return command;
        }
      },
    }
  });

  // Load Tasks
  grunt.loadNpmTasks('grunt-contrib-uglify');
  grunt.loadNpmTasks('grunt-contrib-sass');
  grunt.loadNpmTasks('grunt-contrib-concat');
  grunt.loadNpmTasks('grunt-contrib-watch');
  grunt.loadNpmTasks('grunt-combine-media-queries');
  grunt.loadNpmTasks('grunt-contrib-cssmin');
  grunt.loadNpmTasks('grunt-criticalcss');
  grunt.loadNpmTasks('grunt-exec');

  // Downsync Tasks
  grunt.registerTask('sync_db', ['exec:sync_db']);
  grunt.registerTask('sync_uploads', ['exec:sync_uploads']);

  // Watcher Tasks
  grunt.registerTask('default', ['watch']);
  
  // Critical
  grunt.registerTask('critical', ['criticalcss']);


};