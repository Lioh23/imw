INSERT INTO `regras` (`id`, `nome`, `created_at`, `updated_at`, `deleted_at`) VALUES (NULL, 'gceu-igreja-relatorios', current_timestamp(), current_timestamp(), NULL);

INSERT INTO perfil_regra (id, perfil_id, regra_id, created_at, updated_at)
SELECT NULL, '1', r.id, current_timestamp(), current_timestamp()
FROM regras r
WHERE r.nome = 'gceu-igreja-relatorios'
ORDER BY r.id DESC
LIMIT 1;

INSERT INTO perfil_regra (id, perfil_id, regra_id, created_at, updated_at)
SELECT NULL, '7', r.id, current_timestamp(), current_timestamp()
FROM regras r
WHERE r.nome = 'gceu-igreja-relatorios'
ORDER BY r.id DESC
LIMIT 1;

INSERT INTO perfil_regra (id, perfil_id, regra_id, created_at, updated_at)
SELECT NULL, '4', r.id, current_timestamp(), current_timestamp()
FROM regras r
WHERE r.nome = 'gceu-igreja-relatorios'
ORDER BY r.id DESC
LIMIT 1;

INSERT INTO perfil_regra (id, perfil_id, regra_id, created_at, updated_at)
SELECT NULL, '12', r.id, current_timestamp(), current_timestamp()
FROM regras r
WHERE r.nome = 'gceu-igreja-relatorios'
ORDER BY r.id DESC
LIMIT 1;

INSERT INTO perfil_regra (id, perfil_id, regra_id, created_at, updated_at)
SELECT NULL, '13', r.id, current_timestamp(), current_timestamp()
FROM regras r
WHERE r.nome = 'gceu-igreja-relatorios'
ORDER BY r.id DESC
LIMIT 1;