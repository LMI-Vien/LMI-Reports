const gulp = require('gulp');
const cleanCSS = require('gulp-clean-css');
const terser = require('gulp-terser');  // Use terser instead of uglify
const concat = require('gulp-concat');
const rename = require('gulp-rename');

// Paths
const paths = {
  css: [
    'node_modules/bootstrap/dist/css/bootstrap.min.css',
    'node_modules/datatables.net-dt/css/dataTables.dataTables.min.css',
    'node_modules/jquery-ui/dist/themes/base/jquery-ui.css',
    'node_modules/select2/dist/css/select2.min.css',
  ],
  js: [
    'node_modules/jquery-ui/dist/jquery-ui.js',
    'node_modules/datatables.net/js/dataTables.min.js',
    'node_modules/bootstrap/dist/js/bootstrap.bundle.min.js',
    'node_modules/select2/dist/js/select2.min.js',
  ],
  destCss: 'public/assets/site/bundle/css',
  destJs: 'public/assets/site/bundle/js',
  destChartJs: 'public/assets/site/js'
};

// Minify and concat CSS
gulp.task('styles', function () {
  return gulp.src(paths.css)
    .pipe(concat('bundle.css'))
    .pipe(cleanCSS())
    .pipe(rename({ suffix: '.min' }))
    .pipe(gulp.dest(paths.destCss));
});

// Minify and concat JS
gulp.task('scripts', function () {
  return gulp.src(paths.js)
    .pipe(concat('bundle.js'))
    .pipe(terser())
    .pipe(rename({ suffix: '.min' }))
    .pipe(gulp.dest(paths.destJs));
});

gulp.task('copyChartJS', function () {
  return gulp.src('node_modules/chart.js/dist/chart.umd.js')
    .pipe(rename('chart.min.js'))
    .pipe(gulp.dest(paths.destChartJs));
});

// Default task
gulp.task('default', gulp.parallel('styles', 'scripts', 'copyChartJS'));
