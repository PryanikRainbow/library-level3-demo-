CREATE TABLE IF NOT EXISTS `books_authors` (
`book_id` INT NOT NULL,
`author_id` INT NOT NULL,
FOREIGN KEY (`book_id`) REFERENCES `books` (`id`) ON DELETE CASCADE,
FOREIGN KEY (`author_id`) REFERENCES `authors` (`id`) ON DELETE CASCADE,
PRIMARY KEY (`book_id`, `author_id`)
)