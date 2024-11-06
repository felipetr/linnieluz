const gulp = require("gulp");
const sass = require("gulp-sass")(require("sass"));
const autoprefixer = require("autoprefixer");
const postcss = require("gulp-postcss");
const cleanCSS = require("gulp-clean-css");
const concat = require("gulp-concat");
const uglify = require("gulp-uglify");
const jsonminify = require("gulp-jsonminify");
const bump = require("gulp-bump");
const git = require("gulp-git");
const fs = require("fs");
const beautify = require("cbeautifier");
const { exec } = require("child_process");
const packageJson = require("./package.json");
const composerJson = require("./composer.json");
const rename = require('gulp-rename');

async function getZip() {
  const zip = await import("gulp-zip");
  return zip.default;
}

function checkVersion(done) {
  const packageJson = JSON.parse(fs.readFileSync("./package.json"));
  console.log(
    `\nVersão atual da aplicação: ${beautify.cyan(packageJson.version)}\n`
  );
  done();
}

function updateReadme(done) {
  console.log("Atualizando README.md...");

  // Obtendo as dependências de desenvolvimento do package.json (npm)
  const npmDependenciesList = Object.keys(
    packageJson.devDependencies || {}
  ).map((dep) => `*   \`${dep}\`: ${packageJson.devDependencies[dep]}`);

  // Obtendo as dependências de desenvolvimento do composer.json (Composer)
  const composerDependenciesList = Object.keys(
    composerJson["require-dev"] || {}
  ).map((dep) => `*   \`${dep}\`: ${composerJson["require-dev"][dep]}`);

  // Gerar o texto das dependências de desenvolvimento npm
  const npmDependenciesText =
    npmDependenciesList.length > 0
      ? npmDependenciesList.join("\n")
      : "Nenhuma dependência de desenvolvimento encontrada.";

  // Gerar o texto das dependências de desenvolvimento Composer
  const composerDependenciesText =
    composerDependenciesList.length > 0
      ? composerDependenciesList.join("\n")
      : "Nenhuma dependência de desenvolvimento encontrada.";

  // Ler o arquivo README.md
  fs.readFile("README.md", "utf8", (err, data) => {
    if (err) {
      console.error("Erro ao ler o README.md:", err);
      done();
      return;
    }

    // Substituir as seções de dependências de desenvolvimento no README.md
    const updatedData = data
      .replace(
        /#### Dependências de Desenvolvimento \(npm\)[\s\S]*?##/,
        `#### Dependências de Desenvolvimento (npm)\n\n${npmDependenciesText}\n##`
      )
      .replace(
        /#### Dependências de Desenvolvimento \(Composer\)[\s\S]*?##/,
        `#### Dependências de Desenvolvimento (Composer)\n\n${composerDependenciesText}\n##`
      );

    // Escrever de volta no README.md
    fs.writeFile("README.md", updatedData, "utf8", (err) => {
      if (err) {
        console.error("Erro ao escrever no README.md:", err);
        done();
        return;
      }
      console.log("README.md atualizado com as dependências!");
      done();
    });
  });
}

function compileSass(done) {
  return gulp
    .src("src/sass/**/*.scss")
    .pipe(
      sass().on("error", (err) => {
        console.error(beautify.red(`\nErro: \n${err.message}\n`));
        this.emit("end");
      })
    )
    .pipe(postcss([autoprefixer()]))
    .pipe(cleanCSS())
    .pipe(
      rename((path) => {
        path.basename = path.basename + ".min";
      })
    )
    .pipe(gulp.dest("dist/assets/css"))
    .on("end", () => {
      console.log(
        beautify.green("\nSass compilado e minificado com sucesso!\n")
      );
      done();
    });
}

function minifyScripts(done) {
  return gulp
    .src("src/js/**/*.js")
    .pipe(
      uglify().on("error", (err) => {
        console.error(
          beautify.red("\nErro ao minificar scripts:\n"),
          err.message
        );
        this.emit("end");
      })
    )
    .pipe(
      rename((path) => {
        path.basename = path.basename + ".min";
      })
    )
    .pipe(gulp.dest("dist/assets/js"))
    .on("end", () => {
      console.log(beautify.green("\nScripts minificados com sucesso!\n"));
      done();
    });
}
function minifyJson(done) {
    return gulp
      .src("src/json/**/*.json") 
      .pipe(jsonminify())
      .pipe(
        rename((path) => {
          path.dirname = "assets/json"; 
        })
      )
      .pipe(gulp.dest("dist"))
      .on("end", () => {
        console.log(beautify.yellow("\nArquivos JSON minificados com sucesso!\n"));
        done();
      });
  }

function runCommand(command, errorMessage, from) {
  return new Promise((resolve, reject) => {
    exec(command, (err, stdout, stderr) => {
      if (err) {
        console.error(beautify.red(`${errorMessage}\n`), stderr, "\n");
        reject(err);
      } else {
        let lowStdout = stdout.toLowerCase();
        let search = "affecting";
        if (from === "phpcbf") {
          search = "were fixed";
        }
        if (lowStdout.includes(search)) {
          if (from === "phpcbf") {
            console.error(beautify.green("\nErros corrigidos:\n"));
          } else {
            console.error(beautify.yellow("\nErros encontrados:\n"));
          }
          console.log(stdout);
        } else {
          if (from === "phpcbf") {
            console.log(
              beautify.green("\nNenhum erro corrigível encontrado.\n")
            );
          } else {
            console.log(beautify.green("\nNenhum erro encontrado.\n"));
          }
        }
        resolve(stdout);
      }
    });
  });
}

function phpLint(fix = "phpcs") {
  const command = `for /r .\\dist\\ %f in (*.php) do ${fix} --standard=PSR12 %f`;
  const fixUpper = fix.toUpperCase();
  const errorMessage = `Erro ao executar ${fixUpper}:`;
  return runCommand(command, errorMessage, fix);
}

function jsLint(fix = "") {
  return new Promise((resolve, reject) => {
    exec(`npx eslint src/**/*.js${fix}`, (err, stdout, stderr) => {
      if (stdout.toLowerCase().includes("error")) {
        console.error(beautify.red("\nErros encontrados:\n"), stdout, "\n");
      } else {
        console.log(beautify.green("\nNenhum erro encontrado.\n"));
      }
      resolve(stdout);
    });
  });
}

// Função para assistir mudanças nos arquivos
function watchFiles() {
  gulp.watch("src/sass/**/*.sass", compileSass);
  gulp.watch("src/json/**/*.json", minifyJson);
  gulp.watch("src/js/**/*.js", minifyScripts);
}

// Função para pegar o argumento de versão
function getVersionArg() {
  const versionArg = process.argv.find((arg) => arg.startsWith("--v"));
  if (!versionArg) {
    console.log(
      beautify.yellow("\nPor favor, passe a versão como argumento --vX.X.X\n")
    );
    process.exit(1);
  }
  return versionArg.replace("--v", "");
}

function updatePackageJson(done) {
  const version = getVersionArg();
  const packageJson = JSON.parse(fs.readFileSync("./package.json"));
  const currentVersion = packageJson.version;

  if (version <= currentVersion) {
    console.log(
      `\nVersão ${version} deve ser maior que a versão atual ${currentVersion}\n`
    );
    process.exit(1);
  }

  gulp
    .src("./package.json")
    .pipe(bump({ version }))
    .pipe(gulp.dest("./"))
    .on("end", () => {
      exec("npm install", (err, stdout, stderr) => {
        if (err) {
          console.error(
            beautify.red("\nErro ao rodar npm install:" + ` ${stderr}\n`)
          );
          process.exit(1);
        }

        console.log(beautify.green("package-lock.js atualizado"));
        console.log(stdout);
        done();
      });
    });
}

function updateStyleCss(done) {
  const version = getVersionArg();
  const styleCssPath = "dist/style.css";

  fs.readFile(styleCssPath, "utf8", (err, data) => {
    if (err) process.exit(1);
    const updatedData = data.replace(
      /Version:\s*[0-9.]+/,
      `Version: ${version}`
    );
    fs.writeFile(styleCssPath, updatedData, "utf8", (err) => {
      if (err) {
        console.error(
          beautify.red("\nErro ao atualizar o arquivo style.css: " + err + "\n")
        );
        process.exit(1);
      }
      console.log(beautify.green("\nstyle.css atualizado!\n"));
      done();
    });
  });
}

// Função para criar o arquivo zip
async function createZip(done) {
  const zip = await getZip();
  const version = getVersionArg();
  return gulp
    .src("dist/**/*")
    .pipe(zip(`linnieluz_v${version}.zip`))
    .pipe(gulp.dest("release"))
    .on("end", () => {
      console.log(beautify.green("\nArquivo de Release gerado!\n"));
      done();
    });
}

function tagGit(done) {
    const version = getVersionArg();  // Recuperando a versão desejada
    const newVersion = `v${version}`;  // Formato da tag
  
    // Comando a ser executado
    const command = `npm install && git add . && git commit -m "v${newVersion}" && git tag ${newVersion} && git push && git push origin ${newVersion}`;
  
    console.log(`Executando comando para criar e enviar tag Git: ${command}`);
  
    exec(command, (err, stdout, stderr) => {
      if (err) {
        console.error(beautify.red(`\nErro ao executar comandos: ${err.message}\n`));
        process.exit(1);
      }
      if (stderr) {
        console.error(beautify.red(`\nErro no processo: ${stderr}\n`));
        process.exit(1);
      }
  
      console.log(beautify.green(`\Tag criada com sucesso! Tag v${version} criada e enviada.\n`));
      done();
    });
  }

gulp.task("check-version", checkVersion);
gulp.task("update-readme", updateReadme);
gulp.task("php-lint", () => phpLint("phpcs"));
gulp.task("php-fix", () => phpLint("phpcbf"));
gulp.task("js-lint", () => jsLint());
gulp.task("js-fix", () => jsLint(" --fix"));
gulp.task(
  "release",
  gulp.series(
    updateReadme,
    updatePackageJson,
    updateStyleCss,
    createZip,
    tagGit
  )
);


exports.compileSass = compileSass;
exports.minifyScripts = minifyScripts;
exports.minifyJson = minifyJson;
exports.watch = watchFiles;

exports.default = gulp.series(
  gulp.parallel(compileSass, minifyScripts, minifyJson),
  watchFiles
);
