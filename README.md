
# SAC
![sacc_screenshot](/doc/sacc.png)

## Sobre
O SAC é um sistema web para gerenciamento de pequenas conferências e eventos. Através dele o administrador pode, de maneira simples e prática, gerir e organizar informações relacionadas ao evento como: incrições, pagamentos e cronograma.


## Instalação

Para rodar o projeto, é necessário as seguintes dependências:

* [PHP](https://www.php.net/downloads.php)
* [MySQL](https://dev.mysql.com/downloads/installer/)
* [Composer](https://getcomposer.org/download/)

Também, é preciso instalar as depensências do projeto usando o Composer:

```shell
$ composer install
```

Crie o banco de dados, e importe as estruturas dos dados em:

> database/sac.sql

Por último, configure o arquivo:

> App/config.php

## Features

### Implementadas

:heavy_check_mark: Login com Moodle
:heavy_check_mark: Gerenciamento de pagamentos
:heavy_check_mark: Gerenciamento de eventos
:heavy_check_mark: Gerenciamento de competições
:heavy_check_mark: Controle de permissão
:heavy_check_mark: Exibição dinâmica do conteúdo no web site

### Implementações futuras

:white_check_mark: Geração de certificados
:white_check_mark: Controle de presença
:white_check_mark: Pagamento online

## Como contribuir

Se você deseja contribuir com o SAC, você pode:

* Criar uma [issue](https://github.com/ccuffs/sac/issues) se tiver alguma ideia ou encontrar um bug.
* Desenvolveu, corrigiu, implementou algo no projeto? Não tenha medo, crie um Pull Request!
* Confira as [issue](https://github.com/ccuffs/sac/issues) do projeto, se houver alguma que você acredite que possa ser útil comente lá, e daremos orientações sobre como dar sequência.

Apoie o projeto, acompanhe o repositório e divulgue para os seus amigos!  :)

## Licença

SAC está licenciado sobre a MIT License.