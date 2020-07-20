SELECT def.id as def_id, def.default_doc, docs.id as docs_id, docs.title, docs.doc_group, groups.id as groups_id, groups.name, files.id as files_id, files.name as filename
FROM hjb01_ld_default AS def
LEFT JOIN hjb01_ld_docs AS docs ON docs.id = def.default_doc
LEFT JOIN hjb01_ld_groups AS groups ON groups.id = docs.doc_group
LEFT JOIN hjb01_ld_files AS files ON files.id = docs.file