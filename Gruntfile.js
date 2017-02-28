module.exports = function(grunt) {
    grunt.initConfig({
        phpunit: {
            classes: {
                dir: 'tests/'
            },
            options: {
                bin: 'vendor/bin/phpunit',
                colors: true
            }
        },
        watch: {
            src: {
                files: ['tests/*Test.php'],
                tasks: ['phpunit']
            }
        }
    });

    grunt.loadNpmTasks('grunt-phpunit');
    grunt.loadNpmTasks('grunt-contrib-watch');
    grunt.registerTask('default', ['watch']);
};