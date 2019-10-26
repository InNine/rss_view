var gulp = require('gulp'),
    babel = require('gulp-babel'),
    concat = require('gulp-concat'),
    sass = require('gulp-sass'),
    browserSync = require('browser-sync'),
    del = require('del'),
    cache = require('gulp-cache'),
    autoprefixer = require('gulp-autoprefixer'),
    spritesmith = require('gulp.spritesmith'),
    buffer = require('vinyl-buffer'),
    merge = require('merge-stream'),
    sourcemaps = require('gulp-sourcemaps'),
    svgSprite = require('gulp-svg-sprite'),
    svgmin = require('gulp-svgmin'),
    cheerio = require('gulp-cheerio'),
    terser = require('gulp-terser'),
    replace = require('gulp-replace');

gulp.task('spriteClean', function () {
    return del.sync('../web/images/sprite.png', {
        force: true,
    });
});

gulp.task('removeSvg', function () {
    return del.sync('../web/images/icons/sprite.svg', {
        force: true,
    });
});

gulp.task('sprite', ['spriteClean'], function () {
    var spriteData = gulp.src('../web/images/*.png').pipe(spritesmith({
        imgName: '../web/images/sprite.png',
        imgPath: '../web/images/sprite.png?v=' + Math.floor((new Date()).getTime() / 1000),
        cssName: '_sprite.scss',
        algorithm: 'binary-tree'
    }));
    var imgStream = spriteData.img
        .pipe(buffer())
        .pipe(gulp.dest('app/assets/images/'));
    var cssStream = spriteData.css
        .pipe(gulp.dest('app/scss/'));
    return merge(imgStream, cssStream);
});

gulp.task('svgSprite', ['removeSvg'], function () {
    return gulp.src('../web/icons/*.svg')
        .pipe(svgmin({
            js2svg: {
                pretty: true
            }
        }))
        .pipe(cheerio({
            run: function ($) {
                $('[fill]').removeAttr('fill');
                $('[stroke]').removeAttr('stroke');
                $('[style]').removeAttr('style');
            },
            parserOptions: {
                xmlMode: true
            }
        }))
        .pipe(replace('&gt;', '>'))
        .pipe(svgSprite({
            mode: {
                symbol: {
                    sprite: "sprite.svg",
                }
            }
        }))
        .pipe(gulp.dest('../web/icons'));
});

gulp.task('sass', function () {
    return gulp.src('../web/scss/**/*.scss')
        .pipe(sourcemaps.init())
        .pipe(sass({
            outputStyle: 'compressed'
        }).on('error', sass.logError))
        .pipe(autoprefixer(['last 15 versions', '> 1%', 'ie 8', 'ie 7'], {
            cascade: true
        }))
        .pipe(sourcemaps.write('.'))
        .pipe(gulp.dest('../web/css'))
        .pipe(browserSync.reload({
            stream: true
        }))
});

gulp.task('scripts', function () {
    gulp.src('../web/js/modules/**/*.js')
        .pipe(sourcemaps.init())
        .pipe(babel({
            presets: ['@babel/env']
        }))
        .pipe(concat('all.js'))
        .pipe(terser())
        .pipe(sourcemaps.write('.'))
        .on('error', function (err) { console.log( err ) })
        .pipe(gulp.dest('../web/js'));

    gulp.src('../web/js/vendor/*.js')
        .pipe(concat('vendor.js'))
        .pipe(terser())
        .pipe(sourcemaps.write('.'))
        .on('error', function (err) { console.log( err ) })
        .pipe(gulp.dest('../web/js'));
});

gulp.task('browser-sync', function () {
    browserSync({
        proxy: "http://rss.test/",
        open: true,
        notify: false
    });
});

gulp.task('watch', ['browser-sync'], function () {
    gulp.watch('../web/scss/**/*.scss', ['sass']);
    gulp.watch('../web/js/**/*.js', ['scripts']);
    gulp.watch('../web/icons/*.svg', ['svgSprite']);
    gulp.watch('../views/**/*.php', browserSync.reload);
    gulp.watch('../web/js/**/*.js', browserSync.reload);
});

gulp.task('clear', function (callback) {
    return cache.clearAll();
});

gulp.task('default', ['watch']);
