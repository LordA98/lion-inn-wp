CREATE TABLE tableplaceholder (
    id mediumint(9) NOT NULL AUTO_INCREMENT,
    title VARCHAR(30),
    description VARCHAR(300),
    gallery_image_url VARCHAR(100),
    image_count int(9) NOT NULL DEFAULT 0,
    date_created datetime DEFAULT CURRENT_TIMESTAMP NOT NULL,
    date_updated datetime,
    toPublish boolean NOT NULL DEFAULT 1,
    PRIMARY KEY  (id)
) charsetplaceholder;