const gulp = require('gulp');
const sass = require('gulp-sass')(require('sass'));
const uglify = require('gulp-uglify');
const sourcemaps = require('gulp-sourcemaps');
const postcss = require('gulp-postcss');
const autoprefixer = require('autoprefixer');
const cssnano = require('cssnano');
const fs = require('fs');
const jsonminify = require('gulp-jsonminify');
const zip = require('gulp-zip');
const { exec } = require('child_process');
gulp.task('release', (done) => {
    const newVersion = process.argv[4];

    if (!newVersion) {
        console.error('Erro: Especifique o número da versão. Exemplo: gulp release --ver 0.1.1');
        done();
        return;
    }

    const packageJson = JSON.parse(fs.readFileSync('./package.json'));
    packageJson.version = newVersion;
    fs.writeFileSync('./package.json', JSON.stringify(packageJson, null, 2));

    const styleCssPath = './dist/style.css';
    let styleCssContent = fs.readFileSync(styleCssPath, 'utf8');
    styleCssContent = styleCssContent.replace(/Version: .*/g, `Version: ${newVersion}`);
    fs.writeFileSync(styleCssPath, styleCssContent);

    exec(`npm install && git add . && git commit -m "v${newVersion}" && git tag v${newVersion} && git push && git push origin v${newVersion}`, (err, stdout, stderr) => {
        if (err) {
            console.error(`Erro ao executar comandos git: ${stderr}`);
            done(err);
            return;
        }
        console.log(stdout);
        done();
    });

    gulp.task('release', (done) => {
        const newVersion = process.argv[4];
    
        if (!newVersion) {
            console.error('Erro: Especifique o número da versão. Exemplo: gulp release --ver 0.1.1');
            done();
            return;
        }
    
        console.log('Atualizando o package.json ...');
        const packageJson = JSON.parse(fs.readFileSync('./package.json'));
        packageJson.version = newVersion;
        fs.writeFileSync('./package.json', JSON.stringify(packageJson, null, 2));
        console.log('Atualizando o style.css ...');
        const styleCssPath = './dist/style.css';
        let styleCssContent = fs.readFileSync(styleCssPath, 'utf8');
        styleCssContent = styleCssContent.replace(/Version: .*/g, `Version: ${newVersion}`);
        fs.writeFileSync(styleCssPath, styleCssContent);
        console.log('Gerando tag git...');
        exec(`npm install && git add . && git commit -m "v${newVersion}" && git tag v${newVersion} && git push && git push origin v${newVersion}`, (err, stdout, stderr) => {
            if (err) {
                console.error(`Erro ao executar comandos git: ${stderr}`);
                done(err);
                return;
            }
            
            console.log(stdout);
            console.log(`Gerando arquivo linnieluz-v${newVersion}.zip ...`);
            gulp.src('./dist/**/*')
                .pipe(zip(`linnieluz-v${newVersion}.zip`))
                .pipe(gulp.dest('./release'))
                .on('end', done);
        });
    });
});

gulp.task('styles', () => {
    return gulp.src('./src/sass/**/*.scss')
        .pipe(sourcemaps.init())
        .pipe(sass().on('error', sass.logError))
        .pipe(postcss([autoprefixer(), cssnano()]))
        .pipe(sourcemaps.write('.'))
        .pipe(gulp.dest('./dist/assets/css'));
});

gulp.task('scripts', () => {
    return gulp.src('./src/js/**/*.js')
        .pipe(sourcemaps.init())
        .pipe(uglify())
        .pipe(sourcemaps.write('.'))
        .pipe(gulp.dest('./dist/assets/js'));
});
gulp.task('json', () => {
    return gulp.src('./src/json/**/*.json')
        .pipe(jsonminify())
        .pipe(gulp.dest('./dist/assets/json'));
});
gulp.task('watch', () => {
    gulp.watch('./src/sass/**/*.scss', gulp.series('styles'));
    gulp.watch('./src/js/**/*.js', gulp.series('scripts'));
    gulp.watch('./src/json/**/*.json', gulp.series('json'));
});

gulp.task('default', gulp.series('styles', 'scripts', 'watch'));
