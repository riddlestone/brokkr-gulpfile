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
        .pipe(sass({
            "includePaths": [
                "awesome-css-module"
            ]
        }))
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

const main_other_src = [
    "foo.png",
    "bar/**/*.jpg"
];
exports.main_other = function main_other() {
    return src(main_other_src)
        .pipe(dest("public/static"));
};
exports.main_other_watch = function main_other_watch() {
    watch(main_other_src, function (cb) {
        exports.main_other();
        cb();
    });
};

exports.main = parallel(exports.main_css, exports.main_js, exports.main_other);
exports.main_watch = parallel(exports.main_css_watch, exports.main_js_watch, exports.main_other_watch);

const admin_css_src = [
    "foo.scss",
    "bar/admin.scss"
];
exports.admin_css = function admin_css() {
    return src(admin_css_src, {sourcemaps: true})
        .pipe(concat("admin.min.css"))
        .pipe(sass())
        .pipe(minifyCSS())
        .pipe(dest("public/static/css", {sourcemaps: "."}));
};
exports.admin_css_watch = function admin_css_watch() {
    watch(admin_css_src, function (cb) {
        exports.admin_css();
        cb();
    });
};

const admin_js_src = [
    "admin.js"
];
exports.admin_js = function admin_js() {
    return src(admin_js_src, {sourcemaps: true})
        .pipe(concat("admin.min.js"))
        .pipe(uglify())
        .pipe(dest("public/static/js", {sourcemaps: "."}));
};
exports.admin_js_watch = function admin_js_watch() {
    watch(admin_js_src, function (cb) {
        exports.admin_js();
        cb();
    });
};

exports.admin = parallel(exports.admin_css, exports.admin_js);
exports.admin_watch = parallel(exports.admin_css_watch, exports.admin_js_watch);

exports.css = parallel(exports.main_css, exports.admin_css);
exports.css_watch = parallel(exports.main_css_watch, exports.admin_css_watch);

exports.js = parallel(exports.main_js, exports.admin_js);
exports.js_watch = parallel(exports.main_js_watch, exports.admin_js_watch);

exports.other = parallel(exports.main_other);
exports.other_watch = parallel(exports.main_other_watch);

exports.default = parallel(exports.css, exports.js, exports.other);
exports.watch = parallel(exports.css_watch, exports.js_watch, exports.other_watch);
