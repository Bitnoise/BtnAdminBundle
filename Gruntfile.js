/*global module:false*/
module.exports = function(grunt) {

    var assetsBanner = '/*! <%= pkg.name %> - v<%= pkg.version %> <%= grunt.template.today("dd-mm-yyyy HH:mm:ss") %> */\n';

    // Project configuration.
    grunt.initConfig({
        pkg: grunt.file.readJSON('package.json'),

        jshint: {
            options: {
                jshintrc: '.jshintrc'
            },
            bundle: ['Resources/public/js/*.js', '*.json', 'Gruntfile.js']
        },

        phpcs: {
            options: {
                bin: 'bin/phpcs',
                standard: 'PSR2'
            },
            bundle: {
                dir: ['*']
            }
        },

        phpmd: {
            options: {
                bin: 'bin/phpmd',
                reportFormat: 'text',
                rulesets: 'codesize,unusedcode'
            },
            bundle: {
                dir: ['*']
            }
        },

        exec: {
            phpcs_hint: {
                cmd: 'bin/php-cs-fixer fix --level=all --dry-run --diff --verbose .',
                stdout: true,
                stderr: true,
            },
            phpcs_fix: {
                cmd: 'bin/php-cs-fixer fix --level=all .',
                stdout: true,
                stderr: true,
            },
        }

    });

    // These plugins provide necessary tasks.
    grunt.loadNpmTasks('grunt-contrib-jshint');
    grunt.loadNpmTasks('grunt-phpcs');
    grunt.loadNpmTasks('grunt-phpmd');
    grunt.loadNpmTasks('grunt-exec');

    // Default task.
    grunt.registerTask('hint', ['jshint', 'phpcs', 'phpmd', 'exec:phpcs_hint']);
    grunt.registerTask('default', ['hint']);
};

// sudo gem install em-websocket
