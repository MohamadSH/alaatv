var gulp = require('gulp');
// const elixir = require('laravel-elixir');
//
// require('laravel-elixir-vue-2');

/*
 |--------------------------------------------------------------------------
 | Elixir Asset Management
 |--------------------------------------------------------------------------
 |
 | Elixir provides a clean, fluent API for defining some basic Gulp tasks
 | for your Laravel application. By default, we are compiling the Sass
 | file for our application, as well as publishing vendor resources.
 |
 */

// elixir(mix => {
//     mix.sass('app.scss')
//        .webpack('app.js');
// });
var exec = require('child_process').exec;
gulp.task('deploy', function (cb) {
    exec('./s-deploy.sh', function (err, stdout, stderr) {
        console.log(stdout);
        console.log(stderr);
        cb(err);
    });
});

gulp.task('watch', function (){
    gulp.watch('*.php', ['deploy']);
    gulp.watch('app/*.php', ['deploy']);
    gulp.watch('app/**/*.php', ['deploy']);
    gulp.watch('app/**/**/*.php', ['deploy']);
    gulp.watch('app/**/**/**/*.php', ['deploy']);

    gulp.watch('routes/*.php', ['deploy']);
    gulp.watch('config/*.php', ['deploy']);


    gulp.watch('resources/**/*.php', ['deploy']);
    gulp.watch('resources/**/**/*.php', ['deploy']);
    gulp.watch('resources/**/**/**/*.php', ['deploy']);
    gulp.watch('resources/**/**/**/**/*.php', ['deploy']);
    // gulp.watchAll(['deploy']);
});