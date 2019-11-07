var gulp = require('gulp');
var sass = require('gulp-sass');
var build = require('./build');

gulp.task('watch', function () {
	gulp.watch([build.config.path.src + '/sass/**/*.scss', build.config.path.src + '/js/**/*.js'], gulp.series('build-bundle'));
});

gulp.task('watch:scss', function () {
	gulp.watch(build.config.path.src + '/sass/**/*.scss', gulp.series('build-bundle'));
});

gulp.task('watch:js', function () {
	gulp.watch(build.config.path.src + '/js/**/*.js', gulp.series('build-bundle'));
});
