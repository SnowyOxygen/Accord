CREATE TABLE groupusers(
    id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
	email_user VARCHAR(255) NOT NULL,
    FOREIGN KEY(email_user) REFERENCES users(email),
    id_group INT NOT NULL,
    FOREIGN KEY(id_group) REFERENCES Groups(id),
    admin BINARY
);