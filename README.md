# Documentação Básica do Projeto Livros

## Tecnologias e Versões Utilizadas

- **Backend:** Laravel 10.x (PHP 8.1)
- **Frontend:** React.js 19.x (Node.js 18.x, NPM 9.x)
- **Banco de Dados:** PostgreSQL 8.x
- **API Docs:** Swagger (OpenAPI)
- **Containerização:** Docker 24.x, Docker Compose 2.x

## Estrutura do Projeto

```
livros/
├── livros-api/         # Backend Laravel
│   ├── app/
│   │   ├── Http/
│   │   │   ├── Controllers/   # Controllers das rotas
│   │   │   ├── Requests/      # Validações de request
│   │   │   ├── Resources/     # Formatação de respostas
│   │   │   ├── Repositories/  # Lógica de acesso a dados
│   │   ├── Models/            # Modelos Eloquent
│   │   ├── Exceptions/        # Tratamento de erros customizados
│   ├── database/
│   │   ├── migrations/        # Migrations do banco
│   │   ├── seeders/           # Seeders de dados
│   ├── routes/                # Definição das rotas
│   ├── config/                # Configurações do Laravel
│   ├── Swagger/               # Schemas e configs do Swagger
│   ├── ...
├── livros-ui/          # Frontend React
│   ├── src/
│   │   ├── views/            # Telas principais (CRUD, relatórios)
│   │   ├── components/       # Componentes reutilizáveis
│   │   ├── services/         # Consumo da API
│   │   ├── helpers/          # Funções utilitárias
│   │   ├── ...
│   ├── public/               # Arquivos estáticos
│   ├── ...
├── docker-compose.yml  # Orquestração dos containers
├── Dockerfile          # Build do backend
```

## Organização

- **Separação de camadas:** Controllers, Repositories, Models, Requests e Resources no backend.
- **Validação:** Requests customizados para validação de dados.
- **Tratamento de erros:** Exceptions customizadas e mensagens claras.
- **Documentação:** Swagger com schemas e anotações nos controllers.
- **Frontend modular:** Views para cada entidade, components reutilizáveis, services para API.
- **Relatórios:** View SQL e endpoint dedicado para relatório agrupado.
- **Testes:** Estrutura para testes unitários e de feature no backend.
- **Containerização:** Docker para facilitar setup e deploy.

---

## Configuração do .env

- O arquivo `.env` do backend (livros-api) já vem com exemplos de configuração.
- Principais variáveis:
  - `DB_CONNECTION=pgsql`
  - `DB_HOST=db` (nome do serviço do banco no docker-compose)
  - `DB_PORT=5432`
  - `DB_DATABASE=livros`
  - `DB_USERNAME=postgres`
  - `DB_PASSWORD=secret`
- Ajuste as variáveis conforme necessário para seu ambiente.
- Para o frontend, configure as URLs da API (REACT_APP_API_URL) conforme o ambiente desejado.

---

## Como rodar o projeto

1. Clone o repositório
2. Configure o .env do backend
3. Acesse a pasta raiz do projeto e rode `docker-compose up --build`
4. Se as configuração do banco estiverem certa o build executa as migration e seeders, criando as tabelas e populando o banco
5. Acesse o frontend em `http://localhost:3000` e a API em `http://localhost:8000`
6. Documentação Swagger: `http://localhost:8000/api/documentation`

---

## Scripts e Banco de Dados

- O projeto possui um diretório `livros-api/database/` com todos os scripts necessários para criar o banco de dados (migrations) e popular as tabelas (seeders).
- Para criar o banco e as tabelas, basta rodar os comandos de migration do Laravel dentro do container:
  ```bash
  docker exec -it <nome_do_container_backend> php artisan migrate
  ```
- Para popular as tabelas com dados iniciais, utilize:
  ```bash
  docker exec -it <nome_do_container_backend> php artisan db:seed
  ```
- O banco de dados já está configurado no Docker Compose, pronto para uso.