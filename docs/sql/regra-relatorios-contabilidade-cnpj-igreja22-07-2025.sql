INSERT INTO `regras` (`id`, `nome`, `created_at`, `updated_at`, `deleted_at`) VALUES (NULL, 'contabilidade-cnpj-igreja', '2025-07-22 18:53:04', '2025-07-22 18:53:04', NULL);
INSERT INTO `perfil_regra` (`id`, `perfil_id`, `regra_id`, `created_at`, `updated_at`) VALUES (NULL, '3', '139', '2025-07-18 18:40:04', '2025-07-18 18:40:04');

UPDATE `regras` SET `nome` = 'regiao-relatorio-cnpj-igreja' WHERE `regras`.`id` = 139;