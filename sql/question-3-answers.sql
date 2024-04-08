SELECT * FROM posts WHERE id = 1;



SELECT * FROM posts WHERE title LIKE '%title 2%';



SELECT * FROM posts ORDER BY title ASC;



INSERT INTO posts (title, description) VALUES
('New Post Title 1', 'New post description 1'),
('New Post Title 2', 'New post description 2'),
('New Post Title 3', 'New post description 3');



UPDATE posts SET title = 'Updated Post' WHERE id = 1;



DELETE FROM posts WHERE id = 2;
