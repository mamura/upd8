
# Desafio Técnico - Cadastro de Clientes, Cidades e Representantes

Este projeto foi desenvolvido como parte do processo seletivo para vaga de Desenvolvedor PHP (Laravel). A aplicação permite o cadastro de cidades, representantes e clientes, além de consultar representantes que atendem determinadas cidades ou clientes.

---

## Tecnologias Utilizadas

- PHP 8.x
- Laravel 10.x
- MySQL
- REST API
- Extensão REST Client (VS Code) para testes de API

---

## Requisitos

- PHP >= 8.1
- Composer
- MySQL ou MariaDB
- Node.js (opcional, se desejar frontend)

---

## Instalação e Configuração

```bash
# 1. Clonar o projeto
git clone https://github.com/mamura/upd8.git
cd upd8

# 2. Instalar dependências
composer install

# 3. Copiar o arquivo .env e configurar o banco
cp .env.example .env

# Editar o .env com os dados do seu banco de dados

# 4. Gerar chave da aplicação
php artisan key:generate

# 5. Rodar as migrations e seeders
php artisan migrate --seed

# 6. Subir o servidor
php artisan serve
```

---

## Endpoints da API

A documentação completa da API está disponível no arquivo: [DOCUMENTATION.md](DOCUMENTATION.md)

Você pode testá-la diretamente com a extensão **REST Client** no VS Code usando o arquivo `tests/clients-api.http`.

---

## Testes com REST Client

Arquivo incluso: `tests/clients-api.http`

Basta instalar a extensão REST Client no VS Code e clicar em **"Send Request"** sobre cada requisição.

---

## Scripts SQL Requeridos

1. **Representantes que atendem um cliente:**
```sql
SELECT r.*
FROM representatives r
JOIN city_representative cr ON cr.representative_id = r.id
JOIN clients c ON c.city_id = cr.city_id
WHERE c.id = :client_id;
```

2. **Representantes de uma cidade:**
```sql
SELECT r.*
FROM representatives r
JOIN city_representative cr ON cr.representative_id = r.id
WHERE cr.city_id = :city_id;
```
