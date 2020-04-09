const {src, dest, parallel, watch} = require("gulp");
const sass = require("gulp-sass");
const minifyCSS = require("gulp-csso");
const concat = require("gulp-concat");
const uglify = require('gulp-uglify');

const main_css_src = [
    "foo.scss",
    "bar/baz.scss"
];
exports.main_css = function main_css() {
    return src(main_css_src, {sourcemaps: true})
        .pipe(concat("main.min.css"))
        .pipe(sass())
        .pipe(minifyCSS())
        .pipe(dest("public/static/css", {sourcemaps: "."}));
};
exports.main_css_watch = function main_css_watch() {
    watch(main_css_src, function (cb) {
        exports.main_css();
        cb();
    });
};

const main_js_src = [
    "script.js",
    "stuff/**/*.js"
];
exports.main_js = function main_js() {
    return src(main_js_src, {sourcemaps: true})
        .pipe(concat("main.min.js"))
        .pipe(uglify())
        .pipe(dest("public/static/js", {sourcemaps: "."}));
};
exports.main_js_watch = function main_js_watch() {
    watch(main_js_src, function (cb) {
        exports.main_js();
        cb();
    });
};

exports.main = parallel(exports.main_css, exports.main_js);
exports.main_watch = parallel(exports.main_css_watch, exports.main_js_watch);

exports.css = parallel(exports.main_css);
exports.css_watch = parallel(exports.main_css_watch);

exports.js = parallel(exports.main_js);
exports.js_watch = parallel(exports.main_js_watch);

exports.default = parallel(exports.css, exports.js);
exports.watch = parallel(exports.css_watch, exports.js_watch);
