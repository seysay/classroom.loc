# classroom.loc

Завантажити проєкт можна за посиланням https://codeload.github.com/seysay/classroom.loc/zip/refs/heads/master
Розархівувати файл
виконати команду composer install
прописати в .env базу даних - classroom(яка є в архіві) або створити свою базу даних і прописати у .env
Якшо ви створили свою базу даних то винонайте команду php bin/console doctrine:migrations:migrate, якщо використотвуєте потточну базу цей крок можна пропустити
php bin/console doctrine:fixtures:load виконайте команду, для наповнення фековими даними таблицю, якщо ви створили нову базу даних
Щоб запустити веб сторінку вас потрібно запустити команду symfony serve, якшо symfony не встановлений, встановіть https://symfony.com/
