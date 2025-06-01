
# API - Cadastro de Clientes, Cidades e Representantes

Sistema RESTful para cadastro e relacionamento entre clientes, cidades e representantes.

---

## Endpoints

### Cidades

#### Listar todas as cidades
```
GET /api/cities
```

#### Criar cidade
```
POST /api/cities
Body:
{
  "name": "São Paulo"
}
```

#### Mostrar cidade
```
GET /api/cities/{id}
```

#### Atualizar cidade
```
PUT /api/cities/{id}
Body:
{
  "name": "Nova Cidade"
}
```

#### Remover cidade
```
DELETE /api/cities/{id}
```

---

### Clientes

#### Listar todos os clientes
```
GET /api/clients
```

#### Criar cliente
```
POST /api/clients
Body:
{
  "name": "Empresa X",
  "city_id": 1
}
```

#### Mostrar cliente
```
GET /api/clients/{id}
```

#### Atualizar cliente
```
PUT /api/clients/{id}
Body:
{
  "name": "Empresa Y",
  "city_id": 2
}
```

#### Remover cliente
```
DELETE /api/clients/{id}
```

---

### Representantes

#### Listar representantes
```
GET /api/representatives
```

#### Criar representante
```
POST /api/representatives
Body:
{
  "name": "João",
  "cities": [1, 2]
}
```

#### Mostrar representante
```
GET /api/representatives/{id}
```

#### Atualizar representante
```
PUT /api/representatives/{id}
Body:
{
  "name": "João da Silva",
  "cities": [2, 3]
}
```

#### Remover representante
```
DELETE /api/representatives/{id}
```

---

### Endpoints Especiais

#### Representantes que atendem um cliente
```
GET /api/representatives/by-client/{client_id}
```

#### Representantes de uma cidade
```
GET /api/representatives/by-city/{city_id}
```

---

## Teste com REST Client (VS Code)

Você pode testar todos os endpoints usando o arquivo `tests/clients-api.http` com a extensão **REST Client** no VS Code.

---

## Setup do Projeto

1. Clonar repositório
2. Criar `.env` e configurar banco MySQL
3. Executar:
```bash
composer install
php artisan migrate --seed
php artisan serve
```
