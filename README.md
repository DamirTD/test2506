# Task API (Symfony + Docker)

## Быстрый старт

1. **Склонируйте репозиторий и перейдите в папку backend:**
   ```sh
   cd backend
   ```

2. **Создайте файл `.env.docker` (если его нет) со следующим содержимым:**
   ```env
   APP_ENV=dev
   APP_SECRET=ваш_секрет
   DATABASE_URL="pgsql://postgres:password@database:5432/todo_db?serverVersion=15&charset=utf8"
   ```

3. **Соберите и запустите проект через Docker Compose:**
   ```sh
   docker compose up --build
   ```
   Приложение будет доступно на [http://localhost:8000](http://localhost:8000)

4. **Примените миграции (один раз после первого запуска):**
   ```sh
   docker compose exec app php bin/console doctrine:migrations:migrate --no-interaction
   ```

5. **Тестируйте API**
   - Коллекция находится в файле: `backend/tasks.postman_collection.json`
   - Импортируйте её в Postman(или др.) и используйте для тестирования CRUD, фильтрации, пагинации.

---

## Реализовано из ТЗ
- **REST API для задач** (CRUD: создание, чтение, обновление, удаление)
- **Фильтрация по статусу** и **пагинация** (GET /api/tasks?status=...&page=...&limit=...)
- **Валидация входящих данных** (Symfony Validator)
- **CQRS-архитектура** (отдельные Handler для команд и запросов)
- **Тонкие контроллеры, бизнес-логика в сервисах**
- **Логирование ошибок (Monolog)**
- **Централизованная обработка ошибок (единый JSON-ответ)**
- **Postman-коллекция для тестирования**

---

## Примечания
- Для запуска требуется Docker и Docker Compose.
- Все переменные окружения для Docker указываются в `.env.docker`.