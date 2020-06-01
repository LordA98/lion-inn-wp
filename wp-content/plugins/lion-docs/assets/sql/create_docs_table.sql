CREATE TABLE tableplaceholder (
    id mediumint(9) NOT NULL AUTO_INCREMENT,
    title VARCHAR(30),
    filename VARCHAR(200),
    date_uploaded datetime DEFAULT CURRENT_TIMESTAMP NOT NULL,
    date_updated datetime,
    toPublish boolean NOT NULL DEFAULT 1,
    PRIMARY KEY  (id)
) charsetplaceholder;