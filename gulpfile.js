const gulp = require("gulp");
const sass = require("gulp-sass")(require("sass"));
const autoprefixer = require("autoprefixer");
const postcss = require("gulp-postcss");
const cleanCSS = require("gulp-clean-css");
const concat = require("gulp-concat");
const uglify = require("gulp-uglify");
const bump = require("gulp-bump");
const git = require("gulp-git");
const fs = require("fs");
const beautify = require("cbeautifier");
const { exec } = require("child_process");
const packageJson = require("./package.json");
const composerJson = require("./composer.json");

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
  const packageJson = JSON.parse(fs.readFileSync("./package.json"));
  const currentVersion = packageJson.version;

  if (version <= currentVersion) {
    console.log(
      `\nVersão ${version} deve ser maior que a versão atual ${currentVersion}\n`
    );
    process.exit(1);
  }
  const readmePath = "README.md";

  console.log("Atualizando README.md...");

  fs.readFile(readmePath, "utf8", (err, data) => {
    if (err) {
      console.error(`Erro ao ler o README.md: ${err}`);
      return done();
    }

    const npmDevDependencies = packageJson.devDependencies || {};
    const npmDependenciesList = Object.keys(npmDevDependencies)
      .map((dep) => {
        return `*   ${dep}: ${npmDevDependencies[dep]}`;
      })
      .join("\n");

    const composerDevDependencies = composerJson["config"]?.platform?.php
      ? composerJson["config"].platform.php
      : {};
    const composerDependenciesList = composerJson["require-dev"] || {};
    const composerDependenciesFormatted = Object.keys(composerDependenciesList)
      .map((dep) => {
        return `*   ${dep}: ${composerDependenciesList[dep]}`;
      })
      .join("\n");

    let updatedData = data;

    const npmRegex =
      /#### Dependências de Desenvolvimento \(npm\)[\s\S]*?#### Dependências de Desenvolvimento \(Composer\)/;
    const composerRegex =
      /#### Dependências de Desenvolvimento \(Composer\)[\s\S]*?$/;

    updatedData = updatedData.replace(
      npmRegex,
      `#### Dependências de Desenvolvimento (npm)\n\nAs seguintes dependências de desenvolvimento estão incluídas no projeto:\n\n${npmDependenciesList.join(
        "\n"
      )}\n\n#### Dependências de Desenvolvimento (Composer)\n\nAs seguintes dependências de desenvolvimento estão incluídas no projeto para o PHP:\n\n${composerDependenciesFormatted.join(
        "\n"
      )}`
    );

    if (!npmRegex.test(data)) {
      updatedData =
        updatedData +
        `\n#### Dependências de Desenvolvimento (npm)\n\nAs seguintes dependências de desenvolvimento estão incluídas no projeto:\n\n${npmDependenciesList.join(
          "\n"
        )}\n\n#### Dependências de Desenvolvimento (Composer)\n\nAs seguintes dependências de desenvolvimento estão incluídas no projeto para o PHP:\n\n${composerDependenciesFormatted.join(
          "\n"
        )}`;
    }

    fs.writeFile(readmePath, updatedData, "utf8", (err) => {
      if (err) {
        console.error(`Erro ao escrever no README.md: ${err}`);
      } else {
        console.log("README.md atualizado com as dependências do projeto!");
      }
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
    .pipe(gulp.dest("dist/js"))
    .on("end", () => {
      console.log(beautify.green("\nScripts minificados com sucesso!\n"));
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
  gulp.watch("src/sass/**/*.scss", compileSass);
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
  const version = getVersionArg();
  git.tag(`v${version}`, `Release version ${version}`, (err) => {
    if (err) {
      console.error(beautify.red(`\nErro ao criar tag git: ${err}\n`));
      process.exit(1);
    }
    git.push("origin", `v${version}`, (err) => {
      if (err) {
        console.error(beautify.red(`\nErro ao enviar tag git: ${err}\n`));
        process.exit(1);
      }
      done();
    });
  });
}

gulp.task("check-version", checkVersion);
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
        console.log(beautify.green("\nArquivos JSON minificados com sucesso!\n"));
        done();
      });
  }

exports.compileSass = compileSass;
exports.minifyScripts = minifyScripts;
exports.minifyJson = minifyJson;
exports.watch = watchFiles;

exports.default = gulp.series(
  gulp.parallel(compileSass, minifyScripts, minifyJson),
  watchFiles
);
