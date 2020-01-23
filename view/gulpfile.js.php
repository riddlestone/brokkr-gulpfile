<?php
/**
 * @var array $portals
 */

$imagePaths = call_user_func_array('array_merge', array_map(function($portal){
    return !empty($portal['img']) ? $portal['img'] : [];
}, $portals));


?>
const {src, dest, parallel} = require("gulp");
<?php if(!empty($imagePaths) : ?>const image = require("gulp-image");<?php endif; ?>
const sass = require("gulp-sass");
const minifyCSS = require("gulp-csso");
const concat = require("gulp-concat");

<?php if(!empty($imagePaths)) : ?>
exports.images = function() {
    return src(<?php echo json_encode($imagePaths, JSON_UNESCAPED_SLASHES); ?>)
        .pipe(image())
        .pipe(dest("public/static/img"));
};
<?php endif; ?>

<?php foreach($portals as $portal => $paths) : ?>
exports.<?php echo $portal; ?>_css = function() {
    return src(<?php echo json_encode($paths['css'], JSON_UNESCAPED_SLASHES); ?>, {sourcemaps: true})
        .pipe(concat(<?php echo json_encode($portal . '.css') ?>))
        .pipe(sass())
        .pipe(minifyCSS())
        .pipe(dest("public/static/css", {sourcemaps: true}));
};

exports.<?php echo $portal; ?>_js = function() {
    return src(<?php echo json_encode($paths['js'], JSON_UNESCAPED_SLASHES); ?>, {sourcemaps: true})
        .pipe(concat("<?php echo $portal; ?>.min.js"))
        .pipe(dest("public/static/js", {sourcemaps: true}))
};

exports.<?php echo $portal; ?> = parallel(exports.<?php echo $portal; ?>_css, exports.<?php echo $portal; ?>_js);

<?php endforeach; ?>
exports.css = parallel(<?php echo implode(', ', array_map(function($portal){ return sprintf('exports.%s_css', $portal); }, array_keys($portals))); ?>);
exports.js = parallel(<?php echo implode(', ', array_map(function($portal){ return sprintf('exports.%s_js', $portal); }, array_keys($portals))); ?>);
exports.default = parallel(exports.images, exports.css, exports.js);
