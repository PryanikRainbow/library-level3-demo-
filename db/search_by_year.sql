 SELECT id, img, title, author FROM books
WHERE year LIKE  CONCAT('%', ?, '%') LIMIT ? OFFSET ?;