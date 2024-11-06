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
    

Instalação
----------

Para instalar as dependências do tema, execute o seguinte comando:

    npm install

Compilação
----------

Os arquivos compilados do tema estarão disponíveis na pasta `/dist`. Para compilar automaticamente, use:

    gulp watch

Isso irá observar as alterações nos arquivos e recompilar o CSS e o JS automaticamente.

Dependências do Projeto
-----------------------

As seguintes dependências de desenvolvimento estão incluídas no projeto:

*   `autoprefixer`: ^10.4.13
*   `browser-sync`: ^2.27.10
*   `cssnano`: ^5.1.15
*   `gulp`: ^4.0.2
*   `gulp-concat`: ^2.6.1
*   `gulp-postcss`: ^9.0.0
*   `gulp-sass`: ^5.1.0
*   `gulp-sourcemaps`: ^3.0.0
*   `gulp-uglify`: ^3.0.2
*   `sass`: ^1.77.6

Como Gerar um Release
---------------------

Para criar um release e gerar um arquivo zipado da versão atual, use a task `gulp release` com o parâmetro `--ver` especificando o número da versão desejada:

    gulp release --ver 0.1.2

Essa task atualizará o número da versão no `package.json` e no `style.css`, criará um commit e tag no Git, e gerará um arquivo zip com o nome `linnieluz-v0.1.2.zip` na pasta `/release`.

Licença
-------

Este projeto está licenciado sob a Licença Pública Geral GNU v2 ou posterior. Consulte o arquivo [LICENSE](LICENSE) para mais detalhes.

Contato
-------

Para mais informações, entre em contato com [Felipe Travassos](https://felipetravassos.com).

Observação
----------

Este tema não está aberto para contribuição no momento.