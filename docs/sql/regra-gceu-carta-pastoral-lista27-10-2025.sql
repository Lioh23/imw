
INSERT INTO `regras` (`id`, `nome`, `created_at`, `updated_at`, `deleted_at`) VALUES (NULL, 'gceu-carta-pastoral-cadastrar', current_timestamp(), current_timestamp(), NULL);

INSERT INTO perfil_regra (id, perfil_id, regra_id, created_at, updated_at)
SELECT NULL, '1', r.id, current_timestamp(), current_timestamp()
FROM regras r
WHERE r.nome = 'gceu-carta-pastoral-cadastrar'
ORDER BY r.id DESC
LIMIT 1;

INSERT INTO perfil_regra (id, perfil_id, regra_id, created_at, updated_at)
SELECT NULL, '7', r.id, current_timestamp(), current_timestamp()
FROM regras r
WHERE r.nome = 'gceu-carta-pastoral-cadastrar'
ORDER BY r.id DESC
LIMIT 1;


INSERT INTO `regras` (`id`, `nome`, `created_at`, `updated_at`, `deleted_at`) VALUES (NULL, 'gceu-carta-pastoral-atualizar', current_timestamp(), current_timestamp(), NULL);

INSERT INTO perfil_regra (id, perfil_id, regra_id, created_at, updated_at)
SELECT NULL, '1', r.id, current_timestamp(), current_timestamp()
FROM regras r
WHERE r.nome = 'gceu-carta-pastoral-atualizar'
ORDER BY r.id DESC
LIMIT 1;

INSERT INTO perfil_regra (id, perfil_id, regra_id, created_at, updated_at)
SELECT NULL, '7', r.id, current_timestamp(), current_timestamp()
FROM regras r
WHERE r.nome = 'gceu-carta-pastoral-atualizar'
ORDER BY r.id DESC
LIMIT 1;


INSERT INTO `regras` (`id`, `nome`, `created_at`, `updated_at`, `deleted_at`) VALUES (NULL, 'gceu-carta-pastoral-excluir', current_timestamp(), current_timestamp(), NULL);

INSERT INTO perfil_regra (id, perfil_id, regra_id, created_at, updated_at)
SELECT NULL, '1', r.id, current_timestamp(), current_timestamp()
FROM regras r
WHERE r.nome = 'gceu-carta-pastoral-excluir'
ORDER BY r.id DESC
LIMIT 1;

INSERT INTO perfil_regra (id, perfil_id, regra_id, created_at, updated_at)
SELECT NULL, '7', r.id, current_timestamp(), current_timestamp()
FROM regras r
WHERE r.nome = 'gceu-carta-pastoral-excluir'
ORDER BY r.id DESC
LIMIT 1;


INSERT INTO `regras` (`id`, `nome`, `created_at`, `updated_at`, `deleted_at`) VALUES (NULL, 'gceu-carta-pastoral-visualizar-html', current_timestamp(), current_timestamp(), NULL);

INSERT INTO perfil_regra (id, perfil_id, regra_id, created_at, updated_at)
SELECT NULL, '1', r.id, current_timestamp(), current_timestamp()
FROM regras r
WHERE r.nome = 'gceu-carta-pastoral-visualizar-html'
ORDER BY r.id DESC
LIMIT 1;

INSERT INTO perfil_regra (id, perfil_id, regra_id, created_at, updated_at)
SELECT NULL, '7', r.id, current_timestamp(), current_timestamp()
FROM regras r
WHERE r.nome = 'gceu-carta-pastoral-visualizar-html'
ORDER BY r.id DESC
LIMIT 1;