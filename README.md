
1) Генерируем `.env` файлы.
   * `./build-env-file` - собирает все переменные и генерит файлы окружений `dev/stage`.
   * `cp ./.env.dev.local ./.env` - определяем для окружения-контейнеров.
   * `cp ./app/.env.dev.dist ./app/.env` - определяем для приложения.
2) `make install` - установит git hook на pre-commit.
3) Запуск.
   * `make init` - Сбилдить и запустить докер-контейнеры, установить пакеты, сгенерировать JWT ключи и так далее.  
      В общем сделать всё что бы приложение работало.

### Основной workflow.
* Находимся в ветке `develop`. `git pull` - актуализировали локальную ветку. Отпочковались - `git checkout -b feature/foo-bar-baz`
* Запустили. `make init`.
* Поработали.
  * Если нужны миграции:
    * `make doctrine-migration-generate` - Генерация пустой миграции.
    * `make doctrine-migration-diff` - Генерация миграции на основании `doctrine mapping`.
    * `make doctrine-migration-migrate` - Применить все миграции.
    * `make doctrine-migration-up` - Накатить миграцию (аргументом будет полное имя класса миграции).
    * `make doctrine-migration-down` - Откатить миграцию (аргументом будет полное имя класса миграции).

### Остальные make команды

| Команда | Описание |
| ------ | --------- |
| `make docker-init` | Запустить систему на докер-контейнерах  |
| `make docker-down-clear` | Остановить докер-контейнеры  | 
| `make composer-install` | Установка необходимых пакетов в приложение |
| `make doctrine-migration-generate` | Генерация пустой миграции |
| `make doctrine-migration-diff` | Генерация миграции на основании `doctrine mapping` |
| `make doctrine-migration-migrate` | Применить миграции |