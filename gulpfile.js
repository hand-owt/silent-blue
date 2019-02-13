var gulp = require('gulp');
var plumber = require('gulp-plumber');
var sass = require('gulp-sass');
var npmDist = require('gulp-npm-dist');
var rename = require('gulp-rename');
var bundle = require('gulp-bundle-assets');
var useref = require('gulp-useref');

//watch all file,render selected file
//set base to copy all folder

gulp.task('sass', function () {
    return gulp.src([
        'app/scss/app.scss'
    ], { "base" : 'app/scss/' })
        .pipe(plumber())
        .pipe(sass()) // Using gulp-sass
        .pipe(gulp.dest('app/css'))
});

gulp.task('watch', function(){
    gulp.watch('app/scss/**/*.scss', ['sass']);
});

gulp.task('dev',function(){
    return gulp.src(npmDist(), {base:'./node_modules'})
        .pipe(rename(function(path) {
            path.dirname = path.dirname.replace(/\/dist/, '').replace(/\\dist/, '');
        }))
        .pipe(gulp.dest('app/libs'));
});

gulp.task('build',['copyFile'],function(){
    return gulp.src('app/*.php')
        .pipe(useref())
        .pipe(gulp.dest('dist'));
});
/*use gulp 3.9.1 for use gulp-bundle-assets*/
gulp.task('copyFile',function(){
    return gulp.src('bundle.config.js')
        .pipe(bundle())
        .pipe(gulp.dest('dist'));
});

gulp.task('default', ['watch','sass','dev']);