INSERT INTO `regras` (`id`, `nome`, `created_at`, `updated_at`, `deleted_at`) VALUES (NULL, 'cota-orcamentaria', '2025-09-09 11:31:04', '2025-09-09 11:31:04', NULL);

INSERT INTO `perfil_regra` (`id`, `perfil_id`, `regra_id`, `created_at`, `updated_at`) VALUES (NULL, '3', '148', '2025-09-09 19:11:34', '2025-09-09 19:11:34');

INSERT INTO `perfil_regra` (`id`, `perfil_id`, `regra_id`, `created_at`, `updated_at`) VALUES (NULL, '1', '148', '2025-09-09 19:11:34', '2025-09-09 19:11:34');

UPDATE `perfil_regra` SET `perfil_id` = '7' WHERE `perfil_regra`.`id` = 1141;

INSERT INTO `perfil_regra` (`id`, `perfil_id`, `regra_id`, `created_at`, `updated_at`) VALUES (NULL, '5', '148', '2025-10-03 20:44:34', '2025-10-03 20:44:34');