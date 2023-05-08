# VK_comment_API

Этот проект представляет собой простую систему комментариев с использованием реляционной СУБД и авторизации пользователей через токены доступа.

# Установка и запуск
1. Склонируйте репозиторий с проектом на свой локальный компьютер.
2. Создайте базу данных и пользователя для проекта в MySQL.
3. Откройте файл config/db.php и внесите в него данные для подключения к базе данных.
4. Запустите скрипт db/setup.sql, чтобы создать необходимые таблицы в базе данных.
5. Откройте файл config/auth.php и внесите в него секретный ключ для генерации токенов доступа.
6. Настройте веб-сервер таким образом, чтобы он мог обрабатывать запросы к файлам проекта.

