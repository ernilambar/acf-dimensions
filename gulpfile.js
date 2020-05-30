// Config.
var rootPath   = './';
var projectURL = 'http://staging.local/';

// Gulp.
var gulp = require( 'gulp' );

// Gulp plugins.
var gulpPlugins = require( 'gulp-load-plugins' )();

// File system.
var fs = require('fs');

// Package.
var pkg = JSON.parse(fs.readFileSync('./package.json'));

// Delete.
var del = require('del');

// Browser sync.
var browserSync = require('browser-sync').create();

// Deploy files list.
var deploy_files_list = [
	'assets/**',
	'fields/**',
	'languages/**',
	'readme.txt',
	pkg.main_file
];

// Watch.
gulp.task( 'watch', function() {
    browserSync.init({
        proxy: projectURL,
        open: true
    });

    // Watch PHP files.
    gulp.watch( rootPath + '**/**/*.php' ).on('change',browserSync.reload);
});

// Make pot file.
gulp.task('pot', function() {
	const { run } = gulpPlugins;
	return run('wpi18n makepot --domain-path=languages --exclude=vendors,deploy').exec();
})

// Add text domain.
gulp.task('language', function() {
	const { run } = gulpPlugins;
	return run('wpi18n addtextdomain').exec();
})

// Clean deploy folder.
gulp.task('clean:deploy', function() {
    return del('deploy')
});

// Copy to deploy folder.
gulp.task('copy:deploy', function() {
	const { zip } = gulpPlugins;
	return gulp.src(deploy_files_list,{base:'.'})
	    .pipe(gulp.dest('deploy/' + pkg.name))
	    .pipe(zip(pkg.name + '.zip'))
	    .pipe(gulp.dest('deploy'))
});

// Tasks.
gulp.task( 'default', gulp.series('watch'));

gulp.task( 'textdomain', gulp.series('language', 'pot'));

gulp.task( 'build', gulp.series('textdomain'));

gulp.task( 'deploy', gulp.series('clean:deploy', 'copy:deploy'));
