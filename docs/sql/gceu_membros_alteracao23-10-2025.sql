ALTER TABLE `gceu_membros` ADD `created_at` TIMESTAMP NOT NULL AFTER `gceu_funcao_id`, ADD `updated_at` TIMESTAMP NOT NULL AFTER `created_at`;

ALTER TABLE `gceu_membros` CHANGE `membro_id` `membro_id` CHAR(36) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL;