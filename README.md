## Описание задания

Задание по Backend

Для хранения учетных записей пользователей, в проекте была создана следующая таблица в БД:
Users

```sql
create table users
(
    id int auto_increment,
    name varchar(64) not null,
    email varchar(256) not null,
    created DATETIME not null,
    deleted DATETIME null,
    notes TEXT null,
    constraint users_pk
        primary key (id)
);
 
create unique index users_email_uindex
    on users (email);
 
create unique index users_name_uindex
    on users (name);
```

Необходимо реализовать класс/классы для чтения, создания и изменения записей в таблице users. Необходимо учесть ряд дополнительных бизнес-требований к работе с пользователями:
•	значение поля 'name' (имя пользователя):
- может состоять только из символов a-z и 0-9;
- не может быть короче 8 символов;
- не должно содержать слов из списка запрещенных слов;
- должно быть уникальным;
•	значение поля 'email':
- должно иметь корректный для e-mail адреса формат;
- не должно принадлежать домену из списка "ненадежных" доменов;
- должно быть уникальным;
•	значение поля 'deleted':
- отражает факт "удаления" пользователя (т. н. "soft-delete");
- не может быть меньше значения поля 'created';
- для неудаленного, активного пользователя равно NULL;
- каждое изменение существующей учетной записи пользователя должно журналироваться.

Основным критерием оценки будет являться то, насколько код будет production-ready, в том числе будут оцениваться:
•	архитектура решения и то, насколько она следует принципам SOLID, насколько проста для поддержки и дальнейшего развития;
•	грамотное использование современных возможностей языка PHP;
•	наличие и качество автоматических тестов;
•	стиль кода, использование единого стандарта оформления.
•	Реализация фактической работы с СУБД, журналирования, списков запрещенных слов и ненадежных доменов может быть опущена.
•	Использование сторонних библиотек/фреймворков не возбраняется, но и не является дополнительным плюсом к решению.


## Описание реализации
Проект выполнен в стиле расширения принципов DDD. Помимо выделения слоёв, 
каждая сущность инкапсулирована внутри своей секции, а там внутри **Контейнера**. 
Каждая секция может содержать несколько контейнеров, которые отвечают за работу с конкретной сущностью.
Каждый контейнер содержит Модель или Агрегат, а также интерфейсы и реализации для работы с ними.
Наружу контейнер предоставляет некий интерфейс, для примера сделан фасад UserManager, 
который содержит методы для работы c логикой контейнера.

Второй контейнер - Validation, содержит сервис для валидации данных, а также исключения, которые могут возникнуть при валидации.
Валидация сделана по Шаблон проектирования **Спецификация**. 
Каждая спецификация проверяет одно правило валидации.
Спецификации объединены в цепочку, которая проверяет все правила валидации.
Каждая сущность имеет свою цепочку валидации, которая может быть легко расширена или изменена.

[Пример контейнера User](https://github.com/Rashudo/wisebits-test/tree/master/app/Containers/AppSection/User)
[Пример контейнера Validation](https://github.com/Rashudo/wisebits-test/tree/master/app/Containers/AppSection/Validation)

Помимо Containers в проекте реализован общий слой Ship, который содержит базовые классы и интерфейсы для контейнеров, он нужен для абстракции от фреймворка и упрощения тестирования.


## Описание контейнера
**Actions** - Юзкейсы

**Criteria** - Критерии для уточнения и фильтрации запросов. Используются в репозиториях. Шаблон - Критерий

**Contracts** - Контракты контейнера

**Data** - DTO, Объекты данных, миграции, фабрики, репозитории

**Events** - События контейнера

**Exceptions** - Ошибки контейнера

**Managers** - Фасады контейнера

**Models** - Модели контейнера. В данном случае, используются Eloquent-модели.

**Providers** - Провайдеры контейнера

**Services** - Сервисы контейнера

**Tasks** - Атомарные команды контейнера

**Tests** - Тесты контейнера (Unit, Functional) 

**Validation** - Валидаторы контейнера

## Описание деталей реализации
- Валидация данных происходит в сервисе валидации, который принимает на вход данные и цепочку спецификаций.
- Для валидации используется Спецификация, так как проверки в задании самые разнообразные, возможно даже с использованием внешних сервисов.
- События изменения/удаления/создания реализованы через события Laravel, которые поджигаются в моделях. Но так как система распределена, события можно забрать у Laravel и поджигать их в соответсвующих Actions.
- SoftDelete реализован через Eloquent, что позволяет легко восстановить удаленные записи.
- Логирование ошибок реализовано через базовые исключения контейнера и могут быть легко расширены.
- Тесты покрывают все слои контейнера. Разделены на Unit (тестирование тасков и событий) и Functional (тестирование юзкейсов).
- Каждый контейнер слабо связан с другими контейнерами, что позволяет легко заменить или расширить функционал.
- Валидатор внедряется в контейнер через контракт, что позволяет легко заменить валидатор на другой, если потребуется.
- Репозиторий может быть легко изменен на другой, если потребуется, так как имплементирует контракт RepositoryInterface.  


## Tests
```
  PASS  App\Containers\AppSection\User\Tests\Unit\CreateUserTaskTest
  ✓ create user task                                                                                                       0.29s  

   PASS  App\Containers\AppSection\User\Tests\Unit\DeleteUserTaskTest
  ✓ delete user task                                                                                                       0.02s  
  ✓ delete user failed task                                                                                                0.01s  

   PASS  App\Containers\AppSection\User\Tests\Unit\FindUserByIdTaskTest
  ✓ find user by id task                                                                                                   0.01s  
  ✓ find user by id with invalid id task                                                                                   0.01s  

   PASS  App\Containers\AppSection\User\Tests\Unit\GetAllUsersTaskTest
  ✓ get all users task                                                                                                     0.01s  
  ✓ get all users with no users task                                                                                       0.01s  

   PASS  App\Containers\AppSection\User\Tests\Unit\UpdateUserTaskTest
  ✓ update user task                                                                                                       0.01s  
  ✓ update user failed task                                                                                                0.01s  

   PASS  App\Containers\AppSection\User\Tests\Unit\UserEventsTest
  ✓ created user event                                                                                                     0.01s  
  ✓ deleted user event                                                                                                     0.01s  
  ✓ updated user event                                                                                                     0.01s  

   PASS  App\Containers\AppSection\User\Tests\Functional\CreateUserActionTest
  ✓ create user action                                                                                                     0.02s  
  ✓ wrong prohibited email domain                                                                                          0.01s  
  ✓ email unique                                                                                                           0.01s  
  ✓ name doesnt contain wrong symbols                                                                                      0.01s  
  ✓ name is not empty                                                                                                      0.01s  
  ✓ name is unique                                                                                                         0.01s  
  ✓ name is not longer than64 symbols                                                                                      0.01s  
  ✓ email is not longer than256 symbols                                                                                    0.01s  
  ✓ name contains bad words                                                                                                0.01s  
  ✓ email is valid                                                                                                         0.01s  

   PASS  App\Containers\AppSection\User\Tests\Functional\DeleteUserActionTest
  ✓ delete user                                                                                                            0.01s  
  ✓ delete non existing user                                                                                               0.01s  

   PASS  App\Containers\AppSection\User\Tests\Functional\FindUserByIdActionTest
  ✓ find user by id                                                                                                        0.03s  
  ✓ find non existing user                                                                                                 0.01s  

   PASS  App\Containers\AppSection\User\Tests\Functional\GetAllUsersActionTest
  ✓ get all users                                                                                                          0.01s  
  ✓ get all users with empty table                                                                                         0.01s  

   PASS  App\Containers\AppSection\User\Tests\Functional\UpdateUserActionTest
  ✓ update user                                                                                                            0.01s  
  ✓ update user only name                                                                                                  0.01s  
  ✓ update user only email                                                                                                 0.01s  
  ✓ user update only note                                                                                                  0.01s  
  ✓ update user with empty data                                                                                            0.01s  
  ✓ update user with invalid email                                                                                         0.01s  
  ✓ update user with invalid id                                                                                            0.01s  
  ✓ update user with prohibited email domain                                                                               0.01s  
  ✓ update user email unique                                                                                               0.01s  
  ✓ update user name doesnt contain wrong symbols                                                                          0.01s     
  ✓ name is unique                                                                                                         0.01s     
  ✓ update user name is not longer than64 symbols                                                                          0.01s     
  ✓ update user email is not longer than256 symbols                                                                        0.01s     
  ✓ update user name contains bad words                                                                                    0.01s     
  ✓ email is valid                                                                                                         0.01s     

  Tests:    43 passed (46 assertions)
  Duration: 0.77s
```
