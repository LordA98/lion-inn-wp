CREATE TABLE tableplaceholder (
    id mediumint(9) NOT NULL AUTO_INCREMENT,
    title VARCHAR(30),
    description VARCHAR(300),
    image_url VARCHAR(100),
    date_created datetime DEFAULT CURRENT_TIMESTAMP NOT NULL,
    date_updated datetime,
    toPublish boolean NOT NULL DEFAULT 1,
    PRIMARY KEY  (id)
) charsetplaceholder;