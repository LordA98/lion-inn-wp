CREATE TABLE tableplaceholder (
    id mediumint(9) NOT NULL AUTO_INCREMENT,
    title VARCHAR(30),
    file mediumint(9),
    date_uploaded datetime DEFAULT CURRENT_TIMESTAMP NOT NULL,
    date_updated datetime,
    doc_group mediumint(9),
    toPublish boolean NOT NULL DEFAULT 1,
    isDefault boolean NOT NULL DEFAULT 0,
    PRIMARY KEY  (id),
    FOREIGN KEY (doc_group) 
        REFERENCES prefixplaceholder_groups(id) 
        ON DELETE CASCADE, 
    FOREIGN KEY (file) 
        REFERENCES prefixplaceholder_files(id) 
        ON DELETE CASCADE
) charsetplaceholder;