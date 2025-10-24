# Тестовое задание

## Описание проекта
Использовался Laravel 12

## Установка и запуск
1. Клонируйте репозиторий:
   ```bash
   git clone https://github.com/maksakoviliya/test-api.git
   cd test-api
   ```
2. Установите зависимости с помощью Composer:
   ```bash
   composer install
   ```
3. Скопируйте файл окружения и настройте его:
   ```bash
   cp .env.example .env
   ```
   Отредактируйте файл `.env`, указав настройки базы данных и другие параметры.
4. Сгенерируйте ключ приложения:
   ```bash
   php artisan key:generate
   ```
5. Выполните миграции и заполните базу данных начальными данными:
   ```bash
   php artisan migrate --seed
   ```
6. Запустите локальный сервер разработки:
   ```bash
   php artisan serve
   ```
   
## Curl команды для тестирования API

### Получение доступных слотов
#### Метод: ```GET /slots/availability```

```bash
curl -X GET "http://localhost/api/slots/availability" -H "Accept: application/json"
```

### Создание холда
####  Метод: ```POST /slots/{id}/hold```

```bash
curl -X POST "http://localhost/api/slots/{id}/hold" -H "Accept: application/json" -H "Idempotency-Key: <UUID>"
```

### Подтверждение холда
####  Метод: POST /holds/{id}/confirm

```bash
curl -X POST "http://localhost/api/holds/{id}/confirm" -H "Accept: application/json"
```

### Отмена холда
#### Метод: DELETE /holds/{id}

```bash
curl -X DELETE "http://localhost/api/holds/{id}" -H "Accept: application/json"
```