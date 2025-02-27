
CREATE OR REPLACE VIEW vw_estatistica_escolidade AS
select count(*) as total, base.escolaridade, base.distrito_id, base.regiao_id, base.instituicao, base.escolaridade_id
from (
        select
            mm.nome, mf.descricao as escolaridade, mm.distrito_id, mm.regiao_id, mm.escolaridade_id, ii.nome as instituicao
        from
            membresia_membros as mm
            inner join membresia_rolpermanente as mr on mr.membro_id = mm.id
            and mr.dt_exclusao is null
            inner join membresia_formacoes as mf on mf.id = mm.escolaridade_id
            inner join instituicoes_instituicoes as ii on mm.distrito_id = ii.id
    ) as base
group by
    escolaridade,
    distrito_id,
    regiao_id,
    instituicao,
    escolaridade_id
order by total desc
