DROP TABLE IF EXISTS `reviews`;


CREATE TABLE `reviews` (
    `id` INT(11) UNSIGNED AUTO_INCREMENT NOT NULL,
    `email` TEXT NOT NULL,
    `name` TEXT NOT NULL,
    `text` TEXT NOT NULL,
    `image_path` TEXT,
    `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    `updated_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    PRIMARY KEY (`id`)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8;


INSERT INTO reviews (email, name, image_path, text, created_at)
VALUES
    ('jane@example.com', 'Жанар', '/feedback/public/images/janar.jpeg', 'Өте жақсы қызмет! Заказды тез жүргізділер мен оперативті жеткізді. Тауардың сапасы мені шаттандырды. Келесіде сіздін магазинде сатып аламын.', '2023-08-24 10:15:00'),
    ('amir@example.com', 'Амир', '/feedback/public/images/amir.jpeg', 'Отличнайс көмек! Компанияның қызметкерлері өте көңілді және мақсатты шешу үшін көмек көрсетті. Нәтиже көңілді асырады!', '2023-08-23 16:42:00'),
    ('aynaz@example.com', 'Айназ', '/feedback/public/images/ainaz.jpeg', 'Қолайлы тауар таңдау және асқазан қызмет! Әр ретте заказ жасау кезінде сапасы мен жылдам жеткізуіне кепілдім. Осы дүкенді тапқаным үшін қуаныштымын.', '2023-08-22 09:30:00'),
    ('askar@example.com', 'Асқар', '/feedback/public/images/askar.jpeg', 'Қызметті жақсылау үшін кейінгі үлгілерді көрсетуім бар, бірақ барлық толықтыруларда позитивті көріністер. Деңгейімді және саяхатшылар үшін көбінесе дейін кешірек беретін жеңілдіктерді көрсетуім келеді.', '2023-08-21 14:18:00'),
    ('zere@example.com', 'Зере', '/feedback/public/images/zere.jpeg', 'Мені бұл екінші жыл, мені болмаған. Қолайлы сайт, оперативті қызмет және отличнайс тауар сапасы. Ол жерді таптым үшін қуаныштымын.', '2023-08-20 11:05:00');

CREATE TABLE `admins` (
    `id` INT(11) UNSIGNED AUTO_INCREMENT NOT NULL,
    `email` TEXT NOT NULL,
    `password` TEXT NOT NULL,
    `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    `updated_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    PRIMARY KEY (`id`)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO admins (email, password) VALUES ('admin@gmail.com', 'admin');