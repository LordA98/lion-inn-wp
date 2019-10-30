SELECT rls.object_id, rls.term_taxonomy_id, posts.ID, posts.post_title, posts.post_mime_type, tax.term_taxonomy_id, tax.term_id, tax.taxonomy, terms.term_id, terms.name, terms.slug
FROM hjb01_term_relationships AS rls
LEFT JOIN hjb01_term_taxonomy AS tax ON tax.term_taxonomy_id = rls.term_taxonomy_id
	AND tax.taxonomy = "mediamatic_wpfolder"
LEFT JOIN hjb01_terms AS terms ON terms.term_id = tax.term_id
LEFT JOIN hjb01_posts AS posts ON posts.ID = rls.object_id
WHERE tax.term_taxonomy_id IS NOT NULL
ORDER BY terms.term_id ASC