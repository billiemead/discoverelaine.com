/* INSTRUCTIONS ARE HERE: https://css-tricks.com/gulp-for-wordpress-creating-the-tasks/#top-of-site */
import gulp from 'gulp';

import webpack from 'webpack-stream';
import { src, dest, watch, series, parallel } from 'gulp';
import yargs from 'yargs';
const PRODUCTION = yargs.argv.prod;

/*import sass from 'gulp-sass';*/ /* <<-- this did not work, had to do [npm install node-sass]*/
const sass = require('gulp-sass')(require('sass'));

import cleanCss from 'gulp-clean-css';
import gulpif from 'gulp-if';
import postcss from 'gulp-postcss';
import sourcemaps from 'gulp-sourcemaps';
import autoprefixer from 'autoprefixer';
import del from 'del';
import named from 'vinyl-named';
import imagemin from 'gulp-imagemin';

export const styles = () => {
  return src('src/scss/bundle.scss')
    .pipe(gulpif(!PRODUCTION, sourcemaps.init()))
    .pipe(sass().on('error', sass.logError))
    .pipe(gulpif(PRODUCTION, postcss([ autoprefixer ])))
    .pipe(gulpif(PRODUCTION, cleanCss({compatibility:'ie8'})))
    .pipe(gulpif(!PRODUCTION, sourcemaps.write()))
    .pipe(dest('dist/css'));
}

export const copy = () => {
  return src(['src/**/*','!src/{images,js,scss}','!src/{images,js,scss}/**/*'])
    .pipe(dest('dist'));
}

export const clean = () => del(['dist']);

export const images = () => {
  return src('src/images/**/*.{jpg,jpeg,png,svg,gif}')
    .pipe(gulpif(PRODUCTION, imagemin()))
    .pipe(dest('dist/images'));
}

export const watchForChanges = () => {
  watch('src/scss/**/*.scss', styles);
  watch(['src/**/*','!src/{js,scss}','!src/{js,scss}/**/*'], copy);
  watch('src/js/**/*.js', scripts);
  watch('src/images/**/*.{jpg,jpeg,png,svg,gif}', images);
}

export const scripts = () => {
  return src(['src/js/bundle.js'])
    .pipe(named())
    .pipe(webpack({
      module: {
        rules: [
          {
            test: /\.js$/,
            use: {
              loader: 'babel-loader',
              options: {
                presets: ['@babel/preset-env']
              }
            }
          }
        ]
      },
      mode: PRODUCTION ? 'production' : 'development',
      devtool: !PRODUCTION ? 'inline-source-map' : false,
      output: {
        filename: '[name].js'
      },
    }))
    .pipe(dest('dist/js'));
}

export const dev = series(clean, parallel(styles, images, copy), watchForChanges)
export const build = series(clean, parallel(styles, images, copy))
export default dev;

