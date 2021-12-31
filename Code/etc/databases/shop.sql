CREATE TABLE `products` (
                           `id` CHAR(36) NOT NULL,
                           `name` VARCHAR(255) NOT NULL,
                           `price` decimal NOT NULL,
                           `created_at` datetime NOT NULL,
                           `updated_at` datetime,
                           PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
