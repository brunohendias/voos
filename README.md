# Voos

## Sobre o projeto
Api feita para agrupar uma lista de voos pelo tipo de tarifa

## Como rodar a aplicação
### Preparando a aplicação
- Crie o arquivo .env baseado no arquivo .env.development
- Rode os comandos abaixo na raiz do projeto
- Instalando as dependencias do projeto.
```
    composer install
```
- Gerando a chave APP_KEY.
```
    php artisan key:generate
```

### Subindo a aplicação
- Metodo padrão
```
    php artisan serve
```
- Laravel Sail (Docker)
```
    sail up -d
```

- [Postman collection](https://www.getpostman.com/collections/1cb840188e4db92b9602)

## Dependencias para rodar o Sail
### Linux
- Composer
- Docker
- Docker-compose
### Windows
- [Composer](https://getcomposer.org/Composer-Setup.exe)
- [WSL 2](https://docs.microsoft.com/pt-br/windows/wsl/install-win10)
- [Docker desktop](https://hub.docker.com/editions/community/docker-ce-desktop-windows)