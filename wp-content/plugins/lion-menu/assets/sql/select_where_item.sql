SELECT id, name FROM prefixplaceholder_item 
WHERE parent_section = fk_placeholder
ORDER BY rank ASC;