INSERT INTO `regras` (`id`, `nome`, `created_at`, `updated_at`, `deleted_at`) VALUES (NULL, 'distrito-cota-orcamentaria', '2025-10-03 17:10:04', '2025-10-03 17:10:04', NULL);

INSERT INTO `perfil_regra` (`id`, `perfil_id`, `regra_id`, `created_at`, `updated_at`) VALUES (NULL, '1', '149', '2025-10-03 17:15:34', '2025-10-03 17:15:34');
INSERT INTO `perfil_regra` (`id`, `perfil_id`, `regra_id`, `created_at`, `updated_at`) VALUES (NULL, '2', '149', '2025-10-03 17:15:34', '2025-10-03 17:15:34');
INSERT INTO `perfil_regra` (`id`, `perfil_id`, `regra_id`, `created_at`, `updated_at`) VALUES (NULL, '9', '149', '2025-10-03 17:15:34', '2025-10-03 17:15:34');

UPDATE `perfil_regra` SET `perfil_id` = '3' WHERE `perfil_regra`.`id` = 1143;