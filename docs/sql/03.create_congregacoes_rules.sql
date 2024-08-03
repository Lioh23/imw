INSERT INTO regras (nome) values
	('congregacao-index'),
	('congregacao-cadastrar'),
	('congregacao-atualizar'),
	('congregacao-editar'),
	('congregacao-excluir');

INSERT INTO perfil_regra (perfil_id, regra_id)
select
	 (select id from perfils where nome = 'Administrador') perfil_id
	,regras.id regra_id
FROM regras WHERE nome LIKE 'congregacao-%';

INSERT INTO perfil_regra (perfil_id, regra_id)
select
	 (select id from perfils where nome = 'Pastor') perfil_id
	,regras.id regra_id
FROM regras WHERE nome LIKE 'congregacao-%';

INSERT INTO perfil_regra (perfil_id, regra_id)
select
	 (select id from perfils where nome = 'Secretario') perfil_id
	,regras.id regra_id
FROM regras WHERE nome LIKE 'congregacao-%';

INSERT INTO perfil_regra (perfil_id, regra_id)
select
	 (select id from perfils where nome = 'Administrador do Sistema') perfil_id
	,regras.id regra_id
FROM regras WHERE nome LIKE 'congregacao-%';