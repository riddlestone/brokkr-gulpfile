const {src, dest, parallel} = require("gulp");
const image = require("gulp-image");
const sass = require("gulp-sass");
const minifyCSS = require("gulp-csso");
const concat = require("gulp-concat");

exports.images = function() {
    return src(["foo.png","bar/**/*.jpg"])
        .pipe(image())
        .pipe(dest("public/static/img"));
};

exports.main_css = function() {
    return src(["foo.scss","bar/baz.scss"], {sourcemaps: true})
        .pipe(concat("main.css"))
        .pipe(sass())
        .pipe(minifyCSS())
        .pipe(dest("public/static/css", {sourcemaps: true}));
};

exports.main_js = function() {
    return src(["script.js","stuff/**/*.js"], {sourcemaps: true})
        .pipe(concat("main.min.js"))
        .pipe(dest("public/static/js", {sourcemaps: true}))
};

exports.main = parallel(exports.main_css, exports.main_js);

exports.css = parallel(exports.main_css);
exports.js = parallel(exports.main_js);
exports.default = parallel(exports.images, exports.css, exports.js);
