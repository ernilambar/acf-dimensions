// Env.
require('dotenv').config();

// Config.
const rootPath = './';

// Gulp.
const gulp = require( 'gulp' );

// Delete.
const del = require('del');

// File system.
const fs = require('fs');

// Package.
const pkg = JSON.parse(fs.readFileSync('./package.json'));

// Browser sync.
const browserSync = require('browser-sync').create();

// Deploy files list.
var deploy_files_list = [
	'assets/**',
	'fields/**',
	'languages/**',
	'README.md',
	'acf-dimensions.php'
];

// Watch.
gulp.task( 'watch', function() {
	browserSync.init({
		proxy: process.env.DEV_SERVER_URL,
		open: true
	});

	// Watch PHP files.
	gulp.watch( rootPath + '**/**/*.php' ).on('change', browserSync.reload);
});

// Clean deploy folder.
gulp.task('clean:deploy', function() {
    return del('deploy');
});

// Copy to deploy folder.
gulp.task('copy:deploy', function() {
	return gulp.src(deploy_files_list, {base:'.'})
		.pipe(gulp.dest('deploy/' + pkg.name))
});

// Tasks.
gulp.task( 'default', gulp.series('watch'));

gulp.task( 'deploy', gulp.series('clean:deploy', 'copy:deploy'));
