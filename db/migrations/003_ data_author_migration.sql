INSERT INTO authors (author) 
SELECT DISTINCT author FROM books;