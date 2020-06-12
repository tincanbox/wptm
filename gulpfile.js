const CONFIG = require('./workspace.config.js');
const path = require('path');

// Webpack
const webpack_stream = require('webpack-stream');
const webpack_config_factory = require('./webpack.config.factory.js');

// Gulp
const gulp = require('gulp');
const gulp_clean_css = require('gulp-clean-css');
const gulp_sass = require('gulp-sass');
const gulp_rename = require('gulp-rename');
const gulp_debug = require('gulp-debug');
const gulp_sourcemaps = require("gulp-sourcemaps");

gulp_sass.compiler = require('node-sass');

// Others
const del = require('del');
const browsersync = require('browser-sync');

// Helper
function bind_config(type, ...cbs){
  return gulp[type].apply(gulp, cbs.map((f) => {
    return () => {
      return new Promise(async (res, rej) => {
        try{
          let r = await f.apply(gulp, [CONFIG, res, rej]);
          return res(r);
        }catch(e){
          rej(e);
        }
      });
    };
  }));
}

function generate_src_list(C, glob_type){
  return (Object.keys(C.build.ENTRY).map((k) => {
      return (C.build.ENTRY[k] + (glob_type ? ("/" + C.build.ASSET_GLOB[glob_type.toUpperCase()]) : ""));
    })).concat(C.build.EXCLUDE.map((r) => ('!**/' + r + '/**/*'))).filter(r => r);
}

// fetch command line arguments
const arg = (li => {
  let arg = {}, a, opt, ori, cur;
  for (a = 0; a < li.length; a++) {
    ori = li[a].trim(); opt = ori.replace(/^\-+/, '');
    if (opt === ori) { // argument value
      if (cur) arg[cur] = opt;
      cur = null;
    } else { // argument name
      arg[(cur = opt)] = true;
    }
  }
  return arg;
})(process.argv);
console.log("CLI arg", arg);

//-------------------------
// Base Tasks
//-------------------------

gulp.task('clean', bind_config("series",
  (C) => {
    return del.sync([C.build.DESTINATION]);
  })
);

gulp.task("server", bind_config("series",
  (C) => {
    browsersync({
      port: 3033,
      server: {
        baseDir: C.build.DESTINATION
      }
    });
  })
);

gulp.task('watch', bind_config("series",
  (C) => {
    gulp.watch(generate_src_list(C, 'template'), gulp.series('bundle-webpack'));
    gulp.watch(generate_src_list(C, 'script'), gulp.series('bundle-webpack'));
    // watching .scss, .sass, .css files
    gulp.watch(generate_src_list(C, 'style'), gulp.series('bundle-style'));
  })
);

//-------------------------
// Bundling Tasks
//-------------------------

gulp.task('bundle-webpack', bind_config("parallel",
  (C, res, rej) => {
    let wcf = webpack_config_factory(arg);
    return gulp.src(generate_src_list(C))
      .pipe(webpack_stream(wcf))
      .pipe(gulp.dest(C.build.DESTINATION))
  })
);

// Handling style-related files.
// Disable this if you want to use Webpack as the sass-bundler.
gulp.task('bundle-style', bind_config("parallel",
  (C, res, rej) => {
    // transcompiling and minifying a SCSS files.
    return gulp.src(generate_src_list(C, 'style'))
      .pipe(gulp_debug())
      .pipe(gulp_sourcemaps.init())
      .pipe(gulp_sass())
      .pipe(gulp_rename({extname: '.min.css'}))
      .pipe(gulp_clean_css())
      .pipe(gulp_sourcemaps.write())
      .pipe(gulp.dest(C.build.DESTINATION));
  })
);

//-------------------------
// Group up tasks.
//-------------------------

gulp.task('build', gulp.parallel('bundle-webpack', 'bundle-style'));
gulp.task('pack', gulp.series('clean', 'build'));
gulp.task('default', gulp.series('pack', 'watch', 'server'));