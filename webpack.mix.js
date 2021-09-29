//const mix = require('laravel-mix');

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

/*
mix.js('resources/js/app.js', 'public/js').postCss('resources/css/app.css', 'public/css', [
    require('postcss-import'),
    require('tailwindcss'),
    require('autoprefixer'),
]);
*/

const mix = require('laravel-mix');
const hamburgers = require('hamburgers');

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

mix.js('resources/js/index/index.js', 'public/js/index/index.js')
	.js('resources/js/courses/courses.js', 'public/js/courses/courses.js')
	.scripts(['resources/js/auth/register.js'], 'public/js/auth/register.js')
 	.sass('resources/css/welcome.scss', 'public/css/welcome.css')
 	.sass('resources/css/courses.scss', 'public/css/courses.css')
 	.sass('resources/css/course.scss', 'public/css/course.css')
 	.sass('resources/css/account.scss', 'public/css/account.css')
 	.sass('resources/css/auth.scss', 'public/css/auth.css')
 	.options({
        postCss: [
            require('postcss-normalize')
        ]
    })
    .extract(['hamburgers'])
    .js('resources/js/app.js', 'public/js')
    .vue()
/*
    .postCss('resources/css/app.scss', 'public/css', [
        //
    ])
*/;
