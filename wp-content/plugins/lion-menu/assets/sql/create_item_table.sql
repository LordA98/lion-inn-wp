CREATE TABLE tableplaceholder (
    id mediumint(9) NOT NULL AUTO_INCREMENT,
    name VARCHAR(200),
    rank int(3) NOT NULL,
    date_created datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
    date_updated datetime, 
    author int(3) NOT NULL,
    editor int(3),
    price decimal(5,2),
    type ENUM ('item', 'subtitle', 'note') NOT NULL DEFAULT 'item',
    description VARCHAR(1000),
    isVegetarian boolean,
    isGlutenFree boolean,
    toPublish boolean NOT NULL DEFAULT 1,
    parent_section mediumint(9) NOT NULL,
    PRIMARY KEY  (id),
    FOREIGN KEY (parent_section) REFERENCES prefixplaceholder_section(id)
    ON DELETE CASCADE
) charsetplaceholder;