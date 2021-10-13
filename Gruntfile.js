module.exports = function( grunt ) {

	// Project configuration.
	grunt.initConfig( {

		// Setting folder templates.
		dirs: {
			css: 'assets/css',
			images: 'assets/images',
			js: 'assets/js',
			php: 'includes'
		},

		// Creates deploy-able plugin
		copy: {
			deploy: {
				src: [
					'**',
					'!.*',
					'!.*/**',
					'!*.md',
					'!*.scss',
					'!.DS_Store',
					'!composer.json',
					'!composer.lock',
					'!Gruntfile.js',
					'!node_modules/**',
					'!npm-debug.log',
					'!package.json',
					'!package-lock.json',
					'!whats-api-notifications/**',
					'!whats-api-notifications.zip',
					'!vendor/**',
					'!tailwind.config.js',
					'!api.http'
				],
				dest: 'whats-api-notifications',
				expand: true,
				dot: true
			}
		},

		// Compress zip
		compress: {
			zip: {
				options: {
					archive: './whats-api-notifications.zip',
					mode: 'zip'
				},
				files: [
					{ src: './whats-api-notifications/**' }
				]
			}
		},

		// Clean
		clean: {
			build: {
				src: [
					'whats-api-notifications/**',
					'whats-api-notifications.zip',
					'languages/*.pot'
				]
			}
		}

	} );

	// Load the plugin that provides the "uglify" task.
	grunt.loadNpmTasks( 'grunt-contrib-watch' );
	grunt.loadNpmTasks( 'grunt-contrib-clean' );
	grunt.loadNpmTasks( 'grunt-contrib-compress' );
	grunt.loadNpmTasks( 'grunt-contrib-copy' );
	grunt.loadNpmTasks( 'grunt-contrib-cssmin' );

	// Default task(s).
	grunt.registerTask( 'build', [
		'clean',
		'copy',
		'compress'
	] );
};
