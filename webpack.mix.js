const mix = require('laravel-mix');

/*
 |--------------------------------------------------------------------------
 | Mix Asset Management
 |--------------------------------------------------------------------------
 |
 | Mix provides a clean, fluent API for defining some Webpack build steps
 | for your Laravel applications. By default, we are compiling the CSS
 | file for the application as well as bundling up all the JS files.
 |
 */

mix.js("resources/js/app.js", "public/js")
    .vue()
    .sass("resources/scss/style.scss", "public/css/app.css")
    .postCss("resources/css/app.css", "public/css", [
        require("postcss-import"),
        require("tailwindcss"),
        require("autoprefixer"),
    ])
    .extract(["vue","jquery", "VCalendar", "mitt"])
    .webpackConfig(require("./webpack.config"));

mix.webpackConfig({
         output: {
             chunkFilename: "js/[name].bundle.js",
             publicPath: "/",
         },
     });

if (mix.inProduction()) {
    mix.version();
}

mix.browserSync('http://localhost:8000')
