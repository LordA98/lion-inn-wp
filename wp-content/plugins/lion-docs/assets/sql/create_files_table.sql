CREATE TABLE tableplaceholder (
    id mediumint(9) NOT NULL AUTO_INCREMENT,
    filename VARCHAR(200),
    date_uploaded datetime DEFAULT CURRENT_TIMESTAMP NOT NULL,
    date_updated datetime,
    PRIMARY KEY  (id)
) charsetplaceholder;