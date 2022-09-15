

  DROP TABLE images;
  DROP TABLE messages;

  CREATE TABLE messages(
    id INT AUTO_INCREMENT NOT NULL PRIMARY KEY,
    content VARCHAR(255),
    from_email VARCHAR(255) NOT NULL,
    sent_at datetime DEFAULT CURRENT_TIMESTAMP,
    img_path VARCHAR(255),
    id_room INT NOT NULL

  );