# Backend

## Como o Backend funciona

### Stack

- PHP 8.3 com Laravel 11
- PostgreSQL 14.5

### Porque da escolha da Stack?

- Eu trabalho com PHP a alguns anos, então me senti confortável em utilizar ele no backend

## Arquitetura do App
- Eu desenvolvi em formato de API o backend, para que possa ser consumido por qualquer aplicação frontend
### Endpoints
- Employee
  - GET /employees - Lista todos os funcionários
  - GET /employees/id - Lista um funcionário específico
  - POST /employees - Cria um funcionário
  - PUT /employees/id - Atualiza um funcionário
  - DELETE /employees/id - Deleta um funcionário
- Ticket
  - GET /tickets - Lista todos os tickets
  - GET /tickets/id - Lista um ticket específico
  - POST /tickets - Cria um ticket
  - PUT /tickets/id - Atualiza um ticket
  - DELETE /tickets/id - Deleta um ticket
- Report
  - GET /reports/tickets/by/employee/period - Gera um relatório de tickets
  - POST /reports/tickets/generate - Gera um relatório de tickets em PDF

### Produção
- A documentação Swagger <https://app.swaggerhub.com/apis-docs/JHONATTANCURTARELLI1/tickets-api/1.0.0>

## Arquitetura do Backend

- O laravel por padrão trabalha com MVC
- Para não deixar as regras de negócio acopladas nos controllers eu separei em classes Actions, dessa forma é possível
  reutilizar
  a lógica de negócio em outros controllers, como foi o caso no endpoint de gerar o relatório onde eu uso o Action de
  pesquisa de tickets

- Muitos lugares eu aproveitei da injeção de dependência do laravel para poder deixar o código mais isolado e testável

- Criei testes de Feature pois eles são mais comuns no Laravel e são mais fáceis de escrever,
  o laravel deixa isso claro na documentação dele <https://laravel.com/docs/11.x/testing>

- O banco de dados eu utilizei migrations pois é mais fácil a criação e manutenção do banco de dados, mas vou deixar o
  SQL abaixo

- As classes models representam as minhas entidades, mas eu não concentro regrás de negócio nelas por causa do ORM do
  laravel.
  Ele necessita que as models extendam a classe Model do laravel, assim impossibilitando de eu trabalhar com regras de
  negócio diretamente nela.
  Dessa forma utilizei o padrão Actions e nele sim estão concetradas as regras de negócio

### Como é o fluxo de uma requisição

- Ela inicialmente Cai no arquivo index.php que está na pasta public, onde ele inicia a aplicação e chama o Kernel do
  laravel
- O Kernel chama o arquivo de rotas que está na pasta routes/api.php
- O arquivo de rotas tem a responsabilidade de verificar qual rota está sendo procurada e chamar o controller
  responsável bem
  como seu método
- Os dados das requisições passam pelas classes de Request, onde eu posso ter validações personalizadas dentro delas
- Chegando nos controllers ele inicializa a action responsável e a executa passando os dados da request
- Depois que o controller coletou a resposta da Action ele retorna essa informação da response, que antes passa pelos
  resources
- Os resources são responsáveis por formatar a resposta da requisição, eu utilizo eles para padronizar as respostas da
  API

## Pontos que acho importante destacar

- Criei testes de Feature, cada arquivo representa um método de um controller,
  onde eu testo todos os cenários que imaginei de sucesso e tentando prever os erros
- Nos controllers vão ter comentários estranhos, eles são para a biblioteca que estou usando chamada
  darkaonline/l5-swagger gerar o arquivo de documentação da API Swagger
- Para a funcionalidade de gerar um PDF do relatório da pesquisa de tickets eu utilizei a biblioteca
  barryvdh/laravel-dompdf.
  Onde para não dependender diretamente dela eu utilizei o padrão adapter. onde eu tenho a interface PDF que é a que a
  minha aplicação enxerga
  e a implementação dela que é a DomPDFAdapter que é a que faz a comunicação com a biblioteca DomPDF.
  No código eu não utilizo referência direta a biblioteca, então no arquivo app/Providers/Report
  eu faço a injeção de dependência da interface PDF e passo a implementação dela que é a DomPDFAdapter, Assim se
  precisar trocar a biblioteca
  eu só preciso criar uma nova implementação da interface PDF e passar ela no lugar da DomPDFAdapter

## Banco de dados

Este arquivo contém o script para a criação das tabelas `employees` e `tickets` no PostgreSQL 14.5.

```sql
-- Criação da tabela de funcionários
CREATE TABLE employees (
    id SERIAL PRIMARY KEY,           -- Identificador único do funcionário
    name VARCHAR(255) NOT NULL,      -- Nome do funcionário
    cpf CHAR(11) NOT NULL UNIQUE,    -- CPF único
    situation CHAR(1) DEFAULT 'A',   -- Situação (A=Ativo, I=Inativo)
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP, -- Data de criação
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP, -- Data de atualização
    deleted_at TIMESTAMP             -- Data de exclusão (soft delete)
);

-- Criação da tabela de tickets
CREATE TABLE tickets (
    id SERIAL PRIMARY KEY,           -- Identificador único do ticket
    employee_id INTEGER NOT NULL,    -- Identificador do funcionário associado
    quantity INTEGER NOT NULL,       -- Quantidade de tickets
    situation CHAR(1) DEFAULT 'A',   -- Situação do ticket (A=Ativo, I=Inativo)
    delivery_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP, -- Data de entrega
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,    -- Data de criação
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,    -- Data de atualização
    deleted_at TIMESTAMP,            -- Data de exclusão (soft delete)
    CONSTRAINT fk_employee FOREIGN KEY (employee_id) REFERENCES employees (id) -- Chave estrangeira
);
```







