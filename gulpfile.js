const gulp = require('gulp');
const sass = require('gulp-sass')(require('sass'));
const uglify = require('gulp-uglify');
const sourcemaps = require('gulp-sourcemaps');
const postcss = require('gulp-postcss');
const autoprefixer = require('autoprefixer');
const cssnano = require('cssnano');
const fs = require('fs');
const { exec } = require('child_process');

// Task 1: Atualizar versão e fazer commit
gulp.task('release', (done) => {
    const newVersion = process.argv[4]; // Recebe o valor da versão passada na linha de comando

    if (!newVersion) {
        console.error('Erro: Especifique o número da versão. Exemplo: gulp release --ver 0.1.1');
        done();
        return;
    }

    // Atualiza a versão no package.json
    const packageJson = JSON.parse(fs.readFileSync('./package.json'));
    packageJson.version = newVersion;
    fs.writeFileSync('./package.json', JSON.stringify(packageJson, null, 2));

    // Atualiza a versão no style.css
    const styleCssPath = './style.css';
    let styleCssContent = fs.readFileSync(styleCssPath, 'utf8');
    styleCssContent = styleCssContent.replace(/Version: .*/g, `Version: ${newVersion}`);
    fs.writeFileSync(styleCssPath, styleCssContent);

    // Executa os comandos npm install, git add, git commit e git push com tag
    exec(`npm install && git add . && git commit -m "v${newVersion}" && git tag v${newVersion} && git push && git push origin v${newVersion}`, (err, stdout, stderr) => {
        if (err) {
            console.error(`Erro ao executar comandos git: ${stderr}`);
            done(err);
            return;
        }
        console.log(stdout);
        done();
    });
});

// Task 2: Compilar .scss para .css em ./assets/css
gulp.task('styles', () => {
    return gulp.src('./src/sass/**/*.scss')
        .pipe(sourcemaps.init())
        .pipe(sass().on('error', sass.logError))
        .pipe(postcss([autoprefixer(), cssnano()]))
        .pipe(sourcemaps.write('.'))
        .pipe(gulp.dest('./assets/css'));
});

// Task 3: Minificar arquivos JavaScript em ./src/js e salvar em ./assets/js
gulp.task('scripts', () => {
    return gulp.src('./src/js/**/*.js')
        .pipe(sourcemaps.init())
        .pipe(uglify())
        .pipe(sourcemaps.write('.'))
        .pipe(gulp.dest('./assets/js'));
});

// Task para monitorar alterações
gulp.task('watch', () => {
    gulp.watch('./src/sass/**/*.scss', gulp.series('styles'));
    gulp.watch('./src/js/**/*.js', gulp.series('scripts'));
});

// Tarefa padrão para rodar todas as tasks
gulp.task('default', gulp.series('styles', 'scripts', 'watch'));
