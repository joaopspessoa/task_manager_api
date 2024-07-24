Task Manager API
Este projeto é uma API para gerenciar tarefas, construída com PHP, Nginx e PostgreSQL. Abaixo estão as instruções para configurar e rodar o projeto usando Docker.

Requisitos
Docker
Docker Compose
Configuração do Ambiente
1. Clone o Repositório
Clone o repositório do projeto para o seu ambiente local:

bash
Copiar código
git clone <URL_DO_REPOSITORIO>
cd <DIRETORIO_DO_PROJETO>
2. Crie e Inicie os Contêineres
Crie e inicie os contêineres definidos no docker-compose.yml:

bash
Copiar código
docker-compose up -d
Este comando criará e iniciará os seguintes contêineres:

task_manager_api: Contêiner para a aplicação PHP.
task_manager_nginx: Contêiner para o servidor Nginx.
task_manager_postgres: Contêiner para o banco de dados PostgreSQL.
3. Verifique se os Contêineres Estão em Execução
Para verificar o status dos contêineres, use:

bash
Copiar código
docker-compose ps
4. Instale as Dependências do PHP
Acesse o contêiner task_manager_api e instale as dependências do PHP:

bash
Copiar código
docker-compose exec app bash
composer install
5. Configure o Ambiente
Certifique-se de que o arquivo .env está presente e configurado corretamente no diretório raiz do projeto. Se não houver um arquivo .env, copie o exemplo fornecido:

bash
Copiar código
cp .env.example .env
6. Execute as Migrações do Banco de Dados
Para criar as tabelas do banco de dados e executar as migrações, use:

bash
Copiar código
docker-compose exec app php artisan migrate
7. Acesse a Aplicação
A aplicação estará acessível em http://localhost:8004. Você pode acessar esta URL no seu navegador para interagir com a aplicação.

8. Encerramento dos Contêineres
Quando terminar de trabalhar com o projeto, você pode parar e remover os contêineres com:

bash
Copiar código
docker-compose down
