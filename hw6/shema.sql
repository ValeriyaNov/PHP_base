-- Active: 1734675265035@@127.0.0.1@3306@base1
CREATE TABLE base1.users (
	id_user INT PRIMARY KEY AUTO_INCREMENT, 
	user_login VARCHAR(45),
	user_name VARCHAR(45), 
	user_lastname VARCHAR(45), 
	user_birthday_timestamp INT,
	user_password_hash VARCHAR(255),
	user_role VARCHAR(255)) 
	DEFAULT CHARACTER SET = utf8;


	INSERT base1.users (user_login, user_name, user_lastname, user_birthday_timestamp, user_password_hash, user_role) VALUES ('lera', 'Валерия', 'Новик', 787778715, '$2y$10$SJSI78OS9PGRKhMZ2h0gUO1fvt73amqBlljxj6lwG9W920SEa899O','admin');