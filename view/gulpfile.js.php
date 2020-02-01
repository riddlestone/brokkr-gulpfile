<?php
/**
 * @var array $portals
 */
$types = [
    'css' => [],
    'js' => [],
    'other' => [],
];
?>
const {src, dest, parallel, watch} = require("gulp");
const sass = require("gulp-sass");
const minifyCSS = require("gulp-csso");
const concat = require("gulp-concat");
const uglify = require('gulp-uglify');

<?php foreach($portals as $portal => $paths) : ?>
<?php if(!empty($paths['css'])) : ?>
<?php $types['css'][] = $portal; ?>
const <?php echo $portal; ?>_css_src = <?php echo json_encode($paths['css'], JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT); ?>;
exports.<?php echo $portal; ?>_css = function () {
    return src(<?php echo $portal; ?>_css_src, {sourcemaps: true})
        .pipe(concat(<?php echo json_encode($portal . '.min.css') ?>))
        .pipe(sass())
        .pipe(minifyCSS())
        .pipe(dest("public/static/css", {sourcemaps: "."}));
};
exports.<?php echo $portal; ?>_css_watch = function () {
    watch(<?php echo $portal; ?>_css_src, function (cb) {
        exports.<?php echo $portal; ?>_css();
        cb();
    });
};

<?php endif; ?>
<?php if(!empty($paths['js'])) : ?>
<?php $types['js'][] = $portal; ?>
const <?php echo $portal; ?>_js_src = <?php echo json_encode($paths['js'], JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT); ?>;
exports.<?php echo $portal; ?>_js = function () {
    return src(<?php echo $portal; ?>_js_src, {sourcemaps: true})
        .pipe(concat("main.min.js"))
        .pipe(uglify())
        .pipe(dest("public/static/js", {sourcemaps: "."}));
};
exports.<?php echo $portal; ?>_js_watch = function () {
    watch(<?php echo $portal; ?>_js_src, function (cb) {
        exports.<?php echo $portal; ?>_js();
        cb();
    });
};

<?php endif; ?>
<?php if(!empty($paths['other'])) : ?>
<?php $types['other'][] = $portal; ?>
const <?php echo $portal; ?>_other_src = <?php echo json_encode($paths['other'], JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT); ?>;
exports.<?php echo $portal; ?>_other = function () {
    return src(<?php echo $portal; ?>_other_src)
        .pipe(dest("public/static"));
};
exports.<?php echo $portal; ?>_other_watch = function () {
    watch(<?php echo $portal; ?>_other_src, function (cb) {
        exports.<?php echo $portal; ?>_other();
        cb();
    });
};

<?php endif; ?>
exports.<?php echo $portal; ?> = parallel(<?php echo implode(", ", array_map(function ($type) use ($portal) {
    return 'exports.' . $portal . '_' . $type;
}, array_filter(['css', 'js', 'other'], function ($type) use ($paths) {
    return !empty($paths[$type]);
}))); ?>);
exports.<?php echo $portal; ?>_watch = parallel(<?php echo implode(", ", array_map(function ($type) use ($portal) {
    return 'exports.' . $portal . '_' . $type . '_watch';
}, array_filter(['css', 'js', 'other'], function ($type) use ($paths) {
    return !empty($paths[$type]);
}))); ?>);

<?php endforeach; ?>
<?php if(!empty($types['css'])) : ?>
exports.css = parallel(<?php echo implode(", ", array_map(function ($portal) {
    return "exports." . $portal . "_css";
}, $types['css'])); ?>);
exports.css_watch = parallel(<?php echo implode(", ", array_map(function ($portal) {
    return "exports." . $portal . "_css_watch";
}, $types['css'])); ?>);

<?php endif; ?>
<?php if(!empty($types['js'])) : ?>
exports.js = parallel(<?php echo implode(", ", array_map(function ($portal) {
    return "exports." . $portal . "_js";
}, $types['js'])); ?>);
exports.js_watch = parallel(<?php echo implode(", ", array_map(function ($portal) {
    return "exports." . $portal . "_js_watch";
}, $types['js'])); ?>);

<?php endif; ?>
<?php if(!empty($types['other'])) : ?>
exports.other = parallel(<?php echo implode(", ", array_map(function ($portal) {
    return "exports." . $portal . "_other";
}, $types['other'])); ?>);
exports.other_watch = parallel(<?php echo implode(", ", array_map(function ($portal) {
    return "exports." . $portal . "_other_watch";
}, $types['other'])); ?>);

<?php endif; ?>
exports.default = parallel(<?php echo implode(', ', array_map(function ($type) {
    return 'exports.' . $type;
}, array_keys(array_filter($types)))); ?>);
exports.watch = parallel(<?php echo implode(', ', array_map(function ($type) {
    return 'exports.' . $type . '_watch';
}, array_keys(array_filter($types)))); ?>);
