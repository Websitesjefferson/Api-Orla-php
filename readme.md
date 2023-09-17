# README - Aplicação PHP

Este é um guia rápido para configurar e iniciar a aplicação PHP que utiliza um banco de dados PostgreSQL hospedado na Render. Siga os passos abaixo para configurar o ambiente e executar as migrações necessárias.

## Configuração do Ambiente

1. **Clonando o Repositório:** Clone o repositório para o seu ambiente local.

```bash
git clone https://github.com/Websitesjefferson/Api-Orla-php.git

Instalando Dependências: Use o Composer para instalar as dependências do projeto.

composer install

2.  O banco de dados PostgreSQL já está configurado na Render, portanto, você não precisa fazer nenhuma configuração adicional.

Reset das Migrações (opcional):

php artisan migrate:reset

Gerando Migrações: Gere as migrações para criar as tabelas no banco de dados:

php artisan migrate

Iniciando a Aplicação
Agora que as migrações foram executadas com sucesso, você pode iniciar a aplicação PHP com o seguinte comando:

php artisan serve

