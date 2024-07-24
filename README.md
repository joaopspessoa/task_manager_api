# Task Manager API

Este projeto é uma API para gerenciar tarefas, construída com PHP, Nginx e PostgreSQL. A seguir estão as instruções para configurar e rodar o projeto usando Docker.

## Requisitos

- [Docker](https://docs.docker.com/get-docker/)
- [Docker Compose](https://docs.docker.com/compose/install/)

## Configuração

### 1. Clonar o Repositório

Clone o repositório do projeto e navegue até o diretório do projeto:

```bash
git clone https://github.com/joaopspessoa/task_manager_api.git
cd task_manager_api
```

### 2. Criar e Iniciar os Contêineres

Crie e inicie os contêineres com Docker Compose:

```bash
docker-compose up -d --build
```

### 3. Instalar Dependências do PHP

Acesse o contêiner da aplicação e instale as dependências do PHP:

```bash
docker-compose exec app composer install
```

### 4. Configurar o Ambiente

Copie o exemplo fornecido:

```bash
cp .env.example .env
```

### 5. Executar Migrações do Banco de Dados

Para configurar o banco de dados, execute as migrações:

```bash
docker-compose exec app php artisan migrate
```

### 6. Acessar a Aplicação

A aplicação estará disponível em [http://localhost:8004](http://localhost:8004).

### 7. Encerrar os Contêineres

Para parar e remover os contêineres, use:

```bash
docker-compose down
```

## Estrutura do `docker-compose.yml`

- **app**: Contêiner para a aplicação PHP.
  - **build**: Configura a construção da imagem do PHP.
  - **context**: Diretório de contexto para a construção.
  - **dockerfile**: Nome do Dockerfile.
  - **volumes**: Monta o diretório do projeto.
  - **environment**: Define variáveis de ambiente.

- **nginx-server**: Contêiner para o servidor Nginx.
  - **image**: Imagem do Nginx.
  - **ports**: Mapeia a porta 80 do contêiner para a porta 8004 do host.
  - **volumes**: Monta o diretório do projeto e a configuração do Nginx.

- **db**: Contêiner para o banco de dados PostgreSQL.
  - **image**: Imagem do PostgreSQL.
  - **environment**: Define variáveis de ambiente para o banco de dados.
  - **ports**: Mapeia a porta 5432 do contêiner para a porta 6543 do host.
  - **volumes**: Monta o diretório para armazenar dados do banco.

- **networks**: Define a rede padrão para os contêineres.

## Dockerfile

O `Dockerfile` configura a imagem para a aplicação PHP, incluindo:

- Instalação de dependências do sistema e PHP.
- Configuração do limite de memória do PHP.
- Configuração de usuário e permissões.
- Definição do diretório de trabalho e usuário do contêiner.

Se precisar de ajuda adicional ou encontrar algum problema, sinta-se à vontade para perguntar!
