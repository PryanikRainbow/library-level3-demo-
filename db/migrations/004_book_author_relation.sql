-- INSERT INTO books_authors (book_id, author_id)
-- SELECT b.id, a.id 
-- FROM books 
-- JOIN authors a ON b.author = a.name;

INSERT INTO books_authors (book_id, author_id)
SELECT books.id, authors.id 
FROM books 
JOIN authors ON books.author = authors.name;