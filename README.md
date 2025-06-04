<h1 align="center">
API SALES AND SELLERS
</h1>

## Sobre
API REST utilizando Laravel que gerencia uma API de controle de vendas.

## Tecnologias utilizadas
- Laravel
- Migrate
- Laravel Horizon (E-mails)
- Redis (fila)
- Job
- Comando personalizado (Para executar filas)
- Agedamento de fila
- Mysql

## Rodando projeto
### Pré-requisitos
- Git
- Docker

### Passo a Passo
- 1- Clonar o repositório
```
https://github.com/nepogabriel/tray-laravel-api.git
```

- 2- Entre no diretório 
```bash
cd nome-do-diretorio
```

- 3- Configure variáveis de ambiente
```bash
cp .env.example .env
```

- 4- Instale as dependências
```bash
docker run --rm \
    -u "$(id -u):$(id -g)" \
    -v "$(pwd):/var/www/html" \
    -w /var/www/html \
    laravelsail/php84-composer:latest \
    composer install --ignore-platform-reqs
```

- 5- Inicie o container
```bash
./vendor/bin/sail up -d
```

- 6- Acesse o container
```bash
docker exec -it tray-laravel-api bash
```

- 7- Dentro do container execute para gerar uma chave do laravel
```bash
php artisan key:generate
```

- 8- Dentro do container execute para criar as tabelas do banco de dados
```bash
php artisan migrate
```

- **Observação:** Caso apresente erro ao criar as tabelas do banco de dados, tente os comandos abaixo e execute novamente o comando para criação das tabelas. 
``` bash
# Primeiro comando
docker exec -it tray-laravel-api-mysql bash

# Segundo comando
composer update
```

- 9- Este projeto usa seeders, dentro do container use o comando abaixo
``` bash
php artisan db:seed
```

- 10- Link de acesso
```
http://localhost:8181/api/
```

### Banco de dados
- Porta externa: 33071
- Porta interna: 3306
- Banco de dados: db_tray
- Usuário: root
- Senha:

# Documentação (Endpoints)
- http://localhost:8181/docs/api

## 👥 Contribuidor
Gabriel Ribeiro.
🌐 https://linkedin.com/in/gabriel-ribeiro-br/
