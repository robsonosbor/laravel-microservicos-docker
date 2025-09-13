# Microserviços com PHP (Lumen/Laravel)

Implementação do desafio de microserviços usando **PHP + Lumen**:
- `gateway` (porta 8700): valida Bearer Token e faz proxy para os serviços.
- `product-service` (porta 8100): catálogo com CRUD e SQLite.
- `order-service` (porta 8200): simula pedidos consultando o catálogo **via Gateway**.

## Requisitos
- PHP 8.2+
- Composer

## Passo a passo

### 1) Product Service
```bash
cd product-service
composer install
cp .env.example .env
mkdir -p database && touch database/database.sqlite
php artisan migrate
php -S localhost:8100 -t public
```

### 2) Order Service
```bash
cd order-service
composer install
cp .env.example .env
php -S localhost:8200 -t public
```

### 3) API Gateway
```bash
cd gateway
composer install
cp .env.example .env
php -S localhost:8700 -t public
```

### Token
Envie `Authorization: Bearer secret123` no header.

### Exemplos
```bash
curl -X POST http://localhost:8700/products \
  -H "Authorization: Bearer secret123" \
  -H "Content-Type: application/json" \
  -d '{"name":"Teclado","description":"Mecânico","price":199.9}'

curl -H "Authorization: Bearer secret123" http://localhost:8700/products

curl -X POST http://localhost:8700/orders \
  -H "Authorization: Bearer secret123" \
  -H "Content-Type: application/json" \
  -d '{"productIds":[1,2]}'
```
