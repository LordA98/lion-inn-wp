CREATE TABLE tableplaceholder (
    id mediumint(9) NOT NULL AUTO_INCREMENT,
    default_doc mediumint(9),
    PRIMARY KEY  (id),
    FOREIGN KEY (default_doc) 
        REFERENCES prefixplaceholder_docs(id) 
        ON DELETE CASCADE
) charsetplaceholder;