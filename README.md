# Guestbook_symfony
тестове завдання на сімфоні Гостьова книга
після загрузки проекту введіть в консолі:

composer install
npm install
npm run build
npx webpack  

створіть базу даних: я вкористовував я створвав через OpenServer phpmyadmin (my_sql  кодування:utf8_general_ci) 
підключіть базу в файлі проекту .env в строці - DATABASE_URL=mysql://root:@127.0.0.1:3306/НАЗВА ВАЩОЇ БАЗИ ДАНИХ?serverVersion=5.7

extension = php_intl.dll    - добавити, або розкоментувати цей рядок в php.ini для того щоб працювала зміна мови

загрузіть міграції в базу
php bin/console make:migration
php bin/console doctrine:migrations:migrate

загрузіть фікстури
php bin/console doctrine:fixtures:load

symfony server:start - запуск сервера
php bin/console messenger:consume async - запуск черг для мейлера
в проекті я використовував тестовий мейл сервіс https://mailtrap.io/ тому повідомлення приходять на аккаунт мейлера(для повноцінної роботи потрібно підключити справжній мейл сервіс)
майл сервіс підключається в файлі .env в строці MAILER_DSN=smtp://5c84ad86e9aa19:145d84eda9a13b@sandbox.smtp.mailtrap.io:2525
