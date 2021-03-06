CREATE TABLE tableplaceholder (
    id mediumint(9) NOT NULL AUTO_INCREMENT,
    name VARCHAR(30),
    level mediumint NOT NULL DEFAULT 1,
    parent_group mediumint(9),
    toPublish boolean NOT NULL DEFAULT 1,
    PRIMARY KEY  (id),
    FOREIGN KEY (parent_group) REFERENCES prefixplaceholder_groups(id)
    ON DELETE CASCADE
) charsetplaceholder;