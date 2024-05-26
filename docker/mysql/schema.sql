CREATE TABLE `user_system` (
  `id` int(11) PRIMARY KEY NOT NULL AUTO_INCREMENT,
  `username` varchar(255) NOT NULL,
  `first_name` varchar(255) NOT NULL,
  `last_name` varchar(255) NOT NULL,
  `email` varchar(255) UNIQUE NOT NULL,
  `password` varchar(255) NOT NULL,
  `phone` varchar(255) NOT NULL,
  `birth_date` timestamp NOT NULL,
  `profile_image` varchar(255) DEFAULT null,
  `isAdmin` boolean DEFAULT false,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE `store` (
  `id` int(11) PRIMARY KEY NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE `store_users` (
  `id` int(11) PRIMARY KEY NOT NULL AUTO_INCREMENT,
  `store_id` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `first_name` varchar(255) NOT NULL,
  `last_name` varchar(255) NOT NULL,
  `email` varchar(255) UNIQUE NOT NULL,
  `phone` varchar(255) NOT NULL,
  `birth_date` timestamp NOT NULL,
  `profile_image` varchar(255) DEFAULT null,
  `isActive` boolean DEFAULT false,
  `roles` varchar(255) DEFAULT null,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE `roles` (
  `id` int(11) PRIMARY KEY NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL
);

CREATE TABLE `store_user_roles` (
  `store_user_id` int(11) PRIMARY KEY NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `role_id` int(11) NOT NULL
);

CREATE TABLE `ci_sessions` (
  `id` varchar(128) NOT NULL,
  `ip_address` varchar(45) NOT NULL,
  `timestamp` int(10) NOT NULL DEFAULT '0',
  `data` blob NOT NULL
);

ALTER TABLE
  `store_users`
ADD
  FOREIGN KEY (`store_id`) REFERENCES `store` (`id`) ON DELETE CASCADE;

ALTER TABLE
  `store_user_roles`
ADD
  FOREIGN KEY (`user_id`) REFERENCES `store_users` (`id`) ON DELETE CASCADE;

ALTER TABLE
  `store_user_roles`
ADD
  FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE;