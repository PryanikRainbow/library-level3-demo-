 SELECT id, img, title, author FROM books
WHERE author LIKE  CONCAT('%', ?, '%') LIMIT ? OFFSET ?;