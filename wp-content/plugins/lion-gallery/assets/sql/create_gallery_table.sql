CREATE TABLE tableplaceholder (
    id mediumint(9) NOT NULL AUTO_INCREMENT,
    title VARCHAR(30),
    filename VARCHAR(200),
    section ENUM ('general', 'menu', 'events', 'gallery') NOT NULL DEFAULT 'general',
    parent_doc mediumint(9),
    date_uploaded datetime DEFAULT CURRENT_TIMESTAMP NOT NULL,
    date_updated datetime,
    toPublish boolean NOT NULL DEFAULT 1,
    views int(9) NOT NULL DEFAULT 0,
    PRIMARY KEY  (id)
) charsetplaceholder;