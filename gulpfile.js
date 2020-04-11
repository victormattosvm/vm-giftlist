/*  
    Para o padrão, compilar o SASS e watch apenas escreva "gulp"
    para a versão final do CSS escreva "gulp dist"
*/

const pluginCssFolder = "assets/css";
const pluginScssFolder = "assets/scss";

const pluginJsFolder = "assets/js";

class Gulp {
    constructor() {
        this.self = require("gulp");
        this.sass = require("gulp-sass");
        this.sourcemaps = require("gulp-sourcemaps");
        this.autoprefixer = require("gulp-autoprefixer");
        this.cssmin = require("gulp-clean-css");
        this.rename = require("gulp-rename");
        this.uglify = require("gulp-uglify");
        this.babel = require("gulp-babel");
        this.concat = require("gulp-concat");
        this.errorHandle = require("gulp-error-handle");


        this.gulpCss();
        this.gulpJs();
        this.gulpWatch();
    };

    gulpWatch() {
        this.self.task("watch:css-front", () => this.self.watch(`${pluginScssFolder}/front/*.scss`, ["css-front"]));

        this.self.task("watch:css-admin", () => this.self.watch(`${pluginScssFolder}/admin/*.scss`, ["css-admin"]));


        this.self.task("watch:js-front", () => this.self.watch([`${pluginJsFolder}/front/front.js`], ["js-front"]));

        this.self.task("watch:js-admin", () => this.self.watch([`${pluginJsFolder}/admin/admin.js`], ["js-admin"]));


        this.self.task("default", [
            "css-admin",
            "css-front",
            "js-front",
            "js-admin",
            "watch:css-front",
            "watch:css-admin",
            "watch:js-front",
            "watch:js-admin"
        ]);
    };

    gulpCss() {
        this.self.task("css-front", () => {
            return this.self.src(`${pluginScssFolder}/front/front.scss`)
                .pipe(this.sourcemaps.init())
                .pipe(this.sass())
                .on('error', err => {
                    console.log("ERRO NO SASS");
                    console.error(`Arquivo: ${err.relativePath}`);
                    console.log(`Linha: ${err.line}`);
                    console.log(`Erro: ${err.messageOriginal}`);
                })
                .pipe(this.autoprefixer({
                    browsers: [
                        'ie 9-11',
                        '> 5%',
                        'last 10 versions'
                    ],
                    cascade: true
                }))
                .pipe(this.sourcemaps.write())
                .pipe(this.self.dest(`${pluginCssFolder}/`))
                .pipe(this.cssmin({
                    debug: true,
                }, details => {
                    console.log("CSS Parent Minify");
                    console.log(`Source: ${(details.stats.originalSize/1024).toFixed(2)} Kb`);
                    console.log(`Minify: ${(details.stats.minifiedSize/1024).toFixed(2)} Kb`);
                }))
                .pipe(this.rename({
                    suffix: ".min"
                }))
                .pipe(this.self.dest(`${pluginCssFolder}/`))
        });

        this.self.task("css-admin", () => {
            return this.self.src(`${pluginScssFolder}/admin/admin.scss`)
                .pipe(this.sourcemaps.init())
                .pipe(this.sass())
                .on('error', err => {
                    console.log("ERRO NO SASS");
                    console.error(`Arquivo: ${err.relativePath}`);
                    console.log(`Linha: ${err.line}`);
                    console.log(`Erro: ${err.messageOriginal}`);
                })
                .pipe(this.autoprefixer({
                    browsers: [
                        'ie 9-11',
                        '> 5%',
                        'last 10 versions'
                    ],
                    cascade: true
                }))
                .pipe(this.sourcemaps.write())
                .pipe(this.self.dest(`${pluginCssFolder}/`))
                .pipe(this.cssmin({
                    debug: true,
                }, details => {
                    console.log("CSS Parent Minify");
                    console.log(`Source: ${(details.stats.originalSize/1024).toFixed(2)} Kb`);
                    console.log(`Minify: ${(details.stats.minifiedSize/1024).toFixed(2)} Kb`);
                }))
                .pipe(this.rename({
                    suffix: ".min"
                }))
                .pipe(this.self.dest(`${pluginCssFolder}/`))
        });


    };

    gulpJs() {
        this.self.task("js-front", () => {
            this.self.src([
                    `${pluginJsFolder}/front/front.js`,
                ])
                .pipe(this.sourcemaps.init())
                .pipe(this.babel({
                    presets: ['env']
                }))
                .on('error', err => {
                    console.log("=============================== ERRO NO JS =================================");
                    console.error(`Mensagem: ${err.message}`);
                    console.log(`Posição: ${err.position}`);
                    console.log(err);
                })
                .pipe(this.uglify())
                .pipe(this.concat("front.js"))
                .pipe(this.sourcemaps.write("."))
                .pipe(this.self.dest(`${pluginJsFolder}`))
        });

        this.self.task("js-admin", () => {
            this.self.src([
                    `${pluginJsFolder}/admin/admin.js`,
                ])
                .pipe(this.sourcemaps.init())
                .pipe(this.babel({
                    presets: ['env']
                }))
                .on('error', err => {
                    console.log("=============================== ERRO NO JS =================================");
                    console.error(`Mensagem: ${err.message}`);
                    console.log(`Posição: ${err.position}`);
                    console.log(err);
                })
                .pipe(this.uglify())
                .pipe(this.concat("admin.js"))
                .pipe(this.sourcemaps.write("."))
                .pipe(this.self.dest(`${pluginJsFolder}`))
        });

    };

}

new Gulp();
