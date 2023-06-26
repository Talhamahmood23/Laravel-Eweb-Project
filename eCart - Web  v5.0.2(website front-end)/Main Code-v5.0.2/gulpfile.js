const gulp = require('gulp');
const concat = require('gulp-concat');
const terser = require('gulp-terser');
const sourcemaps = require('gulp-sourcemaps');
const postcss = require('gulp-postcss');
const cssnano = require('cssnano');
const autoprefixer = require('autoprefixer');
const { src, dest,  parallel } = require('gulp');

const jspathheader = [
  'public/themes/eCart_02/js/jquery-3.5.1.min.js',
  'public/themes/eCart_02/js/bootstrap.bundle.min.js',
  'public/themes/eCart_02/js/jquery-ui.min.js',
  'public/themes/eCart_02/js/intlTelInput.js',
  'public/themes/eCart_02/js/sweetalert.min.js',
  'public/themes/eCart_02/js/select2.min.js',
  // 'public/themes/eCart_02/js/jquery.combostars.js',
  'public/themes/eCart_02/js/alertify.min.js',
];

const jspathfooter = [
  'public/themes/eCart_02/js/cartajax.js',
  'public/themes/eCart_02/js/plugins.js',
  'public/themes/eCart_02/js/semantic.min.js',
  'public/themes/eCart_02/js/switcherdemo.js',
  'public/themes/eCart_02/js/spectrum.min.js',
  'public/themes/eCart_02/js/script.js',
  // 'public/themes/eCart_02/js/lazy.js',

]

const cssPath = [
  'public/themes/eCart_02/css/select2.min.css',
  'public/themes/eCart_02/css/semantic.min.css',
  'public/themes/eCart_02/css/bootstrap.min.css',
  'public/themes/eCart_02/css/jquery-ui.min.css',
  'public/themes/eCart_02/css/plugin.css',
  'public/themes/eCart_02/css/switcherdemo.css',
  'public/themes/eCart_02/css/spectrum.min.css',
  'public/themes/eCart_02/css/custom.css',
  'public/themes/eCart_02/css/sweetalert.min.css',
  'public/themes/eCart_02/css/alertify.min.css',

];



function jsTask() {
  return src(jspathheader)
    .pipe(sourcemaps.init())
    .pipe(concat('headerbundle.js'))
    .pipe(terser())
    .pipe(sourcemaps.write('.'))
    .pipe(dest('public/themes/eCart_02/js'));
}

function jsTask2() {
  return src(jspathfooter)
    .pipe(sourcemaps.init())
    .pipe(concat('footerbundle.js'))
    .pipe(terser())
    .pipe(sourcemaps.write('.'))
    .pipe(dest('public/themes/eCart_02/js'));
}

function cssTask() {
  return src(cssPath)
    .pipe(sourcemaps.init())
    .pipe(concat('bundle.css'))
    .pipe(postcss([autoprefixer(), cssnano()])) //not all plugins work with postcss only the ones mentioned in their documentation
    .pipe(sourcemaps.write('.'))
    .pipe(dest('public/themes/eCart_02/css'));
}


exports.cssTask = cssTask;
exports.jsTask = jsTask;
exports.jsTask2 = jsTask2;
exports.default = parallel(cssTask, jsTask,jsTask2)