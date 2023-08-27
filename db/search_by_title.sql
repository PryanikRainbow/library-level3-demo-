 SELECT id, img, title, author FROM books
WHERE title LIKE  CONCAT('%', ?, '%') LIMIT ? OFFSET ?;

