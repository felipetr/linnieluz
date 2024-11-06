Linnie Luz
==========

Tema WordPress desenvolvido para a psicóloga Linnie Luz.

Descrição
---------

Este tema é uma solução personalizada para atender às necessidades específicas da psicóloga Linnie Luz, com um design responsivo e uma interface amigável.

Dependências
------------

O tema utiliza as seguintes bibliotecas:

*   **[Montserrat Font Family](https://fonts.google.com/specimen/Montserrat)**  
    Adicionado via Google Fonts:
    
        <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">
    
*   **[Bootstrap](https://getbootstrap.com/)** - Versão: 5.3.3  
    Adicionado via CDN:
    
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    
*   **[Line Icons](https://lineicons.com/)** - Versão: 5.0  
    Adicionado via CDN:
    
        <link href="https://cdn.lineicons.com/5.0/lineicons.css" rel="stylesheet">

### Dependências do Projeto

* * *

#### Dependências de Desenvolvimento (npm)

*   `@eslint/js`: ^9.14.0
*   `autoprefixer`: ^10.4.20
*   `browser-sync`: ^3.0.3
*   `cbeautifier`: ^0.7.1
*   `eslint`: ^9.14.0
*   `globals`: ^15.12.0
*   `gulp`: ^5.0.0
*   `gulp-bump`: ^3.2.0
*   `gulp-clean-css`: ^4.3.0
*   `gulp-concat`: ^2.6.1
*   `gulp-git`: ^2.11.0
*   `gulp-jsonminify`: ^1.1.0
*   `gulp-postcss`: ^10.0.0
*   `gulp-rename`: ^2.0.0
*   `gulp-sass`: ^5.1.0
*   `gulp-uglify`: ^3.0.2
*   `gulp-zip`: ^6.0.0
*   `sass`: ^1.77.6
##

#### Dependências de Desenvolvimento (Composer)

*   `squizlabs/php_codesniffer`: ^3.10
##

Instalação das Dependências
---------------------------

### Node.js e npm

#### Linux:

    sudo apt-get update
    sudo apt-get install nodejs npm
    
#### Windows:

Baixe o instalador do [site oficial do Node.js](https://nodejs.org/) para Windows e siga as instruções.

#### macOS:

Instale usando [Homebrew](https://brew.sh/) no macOS:

    brew install node
    

### Composer PHP

#### Linux:

    sudo apt-get update
    sudo apt-get install composer
    
#### Windows:

Baixe o instalador do [site oficial do Composer](https://getcomposer.org/download/) para Windows e siga as instruções.

#### macOS:

    brew install composer


Instalação do WordPress
-----------------------

1.  Importe os arquivos do WordPress para a raiz do projeto.
2.  Configure seu servidor PHP para rodar o WordPress.

Instalação do Projeto
---------------------

1.  Execute `npm install` para instalar as dependências do Node.js.
2.  Execute `composer install` para instalar as dependências PHP.

Compilando o Projeto
--------------------

Os arquivos compilados do tema estarão disponíveis na pasta `/dist`. Para compilar automaticamente, use:

    gulp watch

Isso irá observar as alterações nos arquivos e recompilar os arquivos CSS, JSON e JS automaticamente.

Release do Projeto
----------------

Para criar uma release do projeto com uma versão específica (substitua `X.X.X` pela versão desejada):

    gulp release --vX.X.X
    

Obs: O comando `gulp release` automatiza a atualização das dependências no `README.md`, a versão no `package.json`, no arquivo `style.css`, cria um arquivo zip do tema WordPress atualizado, cria uma tag git para o lançamento e a envia para o repositório remoto.

Licença
-------

Este projeto está licenciado sob a Licença Pública Geral GNU v2 ou posterior. Consulte o arquivo [LICENSE](LICENSE) para mais detalhes.

Contato
-------

Para mais informações, entre em contato com [Felipe Travassos](https://felipetravassos.com).

Observação
----------

Este tema não está aberto para contribuição no momento.