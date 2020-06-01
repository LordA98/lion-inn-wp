CREATE TABLE tableplaceholder (
    id mediumint(9) NOT NULL AUTO_INCREMENT,
    title VARCHAR(30),
    filename VARCHAR(200),
    date_uploaded datetime DEFAULT CURRENT_TIMESTAMP NOT NULL,
    date_updated datetime,
    doc_group mediumint(9),
    toPublish boolean NOT NULL DEFAULT 1,
    PRIMARY KEY  (id),
    FOREIGN KEY (doc_group) REFERENCES prefixplaceholder_groups(id)
) charsetplaceholder;