const gulp = require('gulp');
const sass = require('gulp-sass')(require('sass'));
const autoprefixer = require('autoprefixer');
const postcss = require('gulp-postcss')

async function compile_sass() {
    gulp.src('./src/sass/*.scss')
        .pipe(sass().on('error', sass.logError))
        .pipe(postcss([ autoprefixer ]))
        .pipe(gulp.dest('./webapp/public/static/css'));
}

gulp.task('sass:watch', function () {
    gulp.watch('src/sass/**/*.scss', compile_sass);
});
