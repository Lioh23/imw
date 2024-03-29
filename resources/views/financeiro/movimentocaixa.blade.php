@extends('template.layout')
@section('breadcrumb')
    <x-breadcrumb :breadcrumbs="[
        ['text' => 'Financeiro', 'url' => '/', 'active' => false],
        ['text' => 'Movimento de Caixa', 'url' => '#', 'active' => true],
    ]"></x-breadcrumb>
@endsection
@section('content')
    <div class="container-fluid">

    </div>
    <div class="col-lg-12 col-12 layout-spacing">
        <div class="statbox widget box box-shadow">
            <div class="widget-header">
                <div class="row">
                    <div class="col-xl-12 col-md-12 col-sm-12 col-12">
                        <h4>Filtros para pesquisa</h4>
                    </div>
                </div>
            </div>
            <div class="widget-content widget-content-area">
                <!-- Conteúdo -->
                <form action="">
                    <div class="row">

                        <div class="mb-3 col-lg-6 col-md-6 col-sm-12">
                            <label for="caixa_id">Caixa</label>
                            <select class="form-control select2" data-bs-toggle="select2" width="fit" name="caixa_id"
                                id="caixa_id">
                                <option value="" disabled selected>Selecione</option>
                                <option value="33">Caixa Principal</option>
                            </select>
                        </div>

                        <div class="mb-3 col-lg-6 col-md-6 col-sm-12">
                            <label for="plano_conta_id">Plano de Contas</label>
                            <select class="form-control select2" data-bs-toggle="select2" width="fit"
                                name="plano_conta_id" id="plano_conta_id">
                                <option value="" disabled selected>Selecione</option>
                                <option disabled value="1">1 - ENTRADAS</option>
                                <option disabled value="3">1.01 - DÍZIMOS</option>
                                <option value="110186">1.01.07 - Dízimo dos Clérigos (100% conforme FIW 2022/2023)</option>
                                <option value="110116">1.02.13 - Oferta Missões Distritais</option>
                                <option value="110131">1.02.14 - Oferta de Culto para Missões</option>
                                <option value="110132">1.02.15 - Oferta de Gratidão</option>
                                <option value="110133">1.02.16 - Oferta de Construção</option>
                                <option value="110134">1.02.17 - Oferta para Aquisição de Bens móveis</option>
                                <option value="110135">1.02.18 - Oferta para Aquisição de Bens Imóveis</option>
                                <option value="110181">1.02.19 - Oferta para Aquisição de Cestas Básicas e Cobertores
                                </option>
                                <option value="110168">1.03.04 - INSTITUIÇÕES - Outras IMW</option>
                                <option disabled value="24">1.04 - EMPRÉSTIMOS</option>
                                <option value="25">1.04.01 - EMPRÉSTIMOS - SGF/SRF - Secretaria de Finanças</option>
                                <option value="26">1.04.02 - EMPRÉSTIMOS - FIW - Fundo Imobiliário Wesleyano</option>
                                <option value="27">1.04.03 - EMPRÉSTIMOS - Outras Igrejas</option>
                                <option value="28">1.04.04 - EMPRÉSTIMOS - Outras Secretarias</option>
                                <option value="110083">1.04.05 - EMPRÉSTIMOS - Distrito</option>
                                <option value="29">1.04.99 - EMPRÉSTIMOS - Outros</option>
                                <option value="110147">1.05.07 - OUTRAS RECEITAS - Restituição de IPTU, ITBI e outros
                                </option>
                                <option value="36">1.05.99 - OUTRAS RECEITAS - Outros</option>
                                <option value="110130">1.06.03 - PATRIMONIO - Consorcio Contemplado</option>
                                <option disabled value="40">1.07 - IMPOSTO RETIDO</option>
                                <option value="41">1.07.01 - Imposto de Renda Retido - Clérigos</option>
                                <option value="42">1.07.02 - Imposto de Renda Retido - Terceiros</option>
                                <option value="110165">1.07.03 - IRRF - Repasse Imposto Retido Clérigos das Igrejas</option>
                                <option value="110166">1.07.04 - IRRF - Repasse Imposto Retido Terceiros das Igrejas
                                </option>
                                <option value="110180">1.09.06 - ACAMPAMENTOS - Taxa de Ocupação</option>
                                <option disabled value="110005">1.10 - COTA/OFERTA DAS REGIÕES</option>
                                <option value="110006">1.10.01 - COTA/OFERTA DAS REGIÕES - Ajuda a Clérigos Jubilados
                                </option>
                                <option value="110024">1.10.02 - COTA/OFERTA DAS REGIÕES - Manutenção de Regiões</option>
                                <option value="110091">1.10.03 - SGF/SRF - Fundo Episcopal</option>
                                <option disabled value="110138">1.11 - REPASSES DA SRF - Secretaria Regional de Finanças
                                </option>
                                <option value="110139">1.11.01 - REPASSES DA SRF - Pagamento de Obreiros</option>
                                <option value="110140">1.11.02 - REPASSES DA SRF - Pagamento de Alugueis</option>
                                <option value="110144">1.11.99 - REPASSES DA SRF - Outros</option>
                                <option disabled value="110141">1.12 - REPASSES DA SRM - Secretaria Regional de Missões
                                </option>
                                <option value="110142">1.12.01 - REPASSES DA SRM - Pagamento de Obreiros</option>
                                <option value="110143">1.12.02 - REPASSES DA SRM _ Pagamento de Alugueis</option>
                                <option value="110145">1.12.99 - REPASSES DA SRM - Outros</option>
                                <option value="110113">1.20.08 - RECEBÍVEIS DA SGF/SRF - Cota Regionais (outras cotas)
                                </option>
                                <option value="110177">1.20.09 - RECEBÍVEIS DA SGF/SRF - Receitas de Concílios</option>
                                <option value="110105">1.21.02 - RECEBÍVEIS DA SGA/SRA - Repasse da GIF (Gestão Integrada
                                    Financeira)
                                </option>
                                <option value="110114">1.21.06 - RECEBÍVEIS DA SGA/SRA - Procurações/Estatutos</option>
                                <option value="110146">1.21.07 - RECEBÍVEIS DA SGA/SRA - Reserva Intangível a disposição do
                                    SR - FIW
                                </option>
                                <option value="110164">1.23.03 - RECEBÍVEIS DA SRAS - Metlife</option>
                                <option value="110124">1.24.05 - RECEBÍVEIS DA SGM - Oferta para projetos especiais</option>
                                <option disabled value="110183">1.25 - RECEBÍVEIS DA GIF (Gestão Integrada Financeira)
                                </option>
                                <option value="110184">1.25.01 - Ressarcimento de Empréstimos outras instituições</option>
                                <option value="110185">1.25.02 - Ressarcimento de Empréstimos Outras IMW</option>
                                <option disabled value="2">2 - SAÍDAS</option>
                                <option disabled value="45">2.01 - DESPESAS ADMINISTRATIVAS</option>
                                <option value="46">2.01.01 - DESPESAS ADMINISTRATIVAS - Água</option>
                                <option value="47">2.01.02 - DESPESAS ADMINISTRATIVAS - Luz/Energia</option>
                                <option value="49">2.01.04 - DESPESAS ADMINISTRATIVAS - Telefone Celular</option>
                                <option value="50">2.01.05 - DESPESAS ADMINISTRATIVAS - Combustível e Lubrificantes
                                </option>
                                <option value="51">2.01.06 - DESPESAS ADMINISTRATIVAS - Material de Escritório</option>
                                <option value="63">2.01.07 - DESPESAS ADMINISTRATIVAS - Internet e TV (cabo ou satélite)
                                </option>
                                <option value="64">2.01.08 - DESPESAS ADMINISTRATIVAS - Gás (botija ou encanado)
                                </option>
                                <option value="84">2.01.09 - DESPESAS ADMINISTRATIVAS - Transporte (onibus, van, taxi,
                                    fretes, carretos,
                                    etc)</option>
                                <option value="86">2.01.10 - DESPESAS ADMINISTRATIVAS - Honorários e Prestação de
                                    Serviços</option>
                                <option value="87">2.01.11 - DESPESAS ADMINISTRATIVAS - Impressos</option>
                                <option value="118">2.01.12 - DESPESAS ADMINISTRATIVAS - Correios</option>
                                <option value="119">2.01.13 - DESPESAS ADMINISTRATIVAS - Procurações e Cartórios</option>
                                <option value="120">2.01.14 - DESPESAS ADMINISTRATIVAS - Condominio</option>
                                <option value="121">2.01.15 - DESPESAS ADMINISTRATIVAS - Ajuda de Custo Excedente para
                                    Clérigos</option>
                                <option value="65">2.01.16 - DESPESAS ADMINISTRATIVAS - Anuênio (verba de representação)
                                    para Clérigos
                                </option>
                                <option value="123">2.01.17 - DESPESAS ADMINISTRATIVAS - Alimentação (lanches e
                                    refeições)</option>
                                <option value="124">2.01.18 - DESPESAS ADMINISTRATIVAS - Consumíveis (descartáveis,
                                    copos, talheres,
                                    calices)</option>
                                <option value="130">2.01.19 - DESPESAS ADMINISTRATIVAS - Seguros (incêndio, roubo,
                                    enchente)</option>
                                <option value="110015">2.01.20 - DESPESAS ADMINISTRATIVAS - Hotel e Hospedagem</option>
                                <option value="110110">2.01.22 - DESPESAS ADMINISTRATIVAS - Cantina</option>
                                <option value="110112">2.01.23 - DESPESAS ADMINISTRATIVAS - Viagens (deslocações, refeições
                                    e
                                    hospedagem)</option>
                                <option value="62">2.01.99 - DESPESAS ADMINISTRATIVAS - Outras</option>
                                <option disabled value="52">2.02 - DESPESAS PASTORAIS</option>
                                <option value="53">2.02.01 - DESPESAS PASTORAIS - Subsídios (prebendas)</option>
                                <option value="54">2.02.02 - DESPESAS PASTORAIS - Viagens/Expediente</option>
                                <option value="55">2.02.03 - DESPESAS PASTORAIS - CAW</option>
                                <option value="56">2.02.04 - DESPESAS PASTORAIS - INSS</option>
                                <option value="57">2.02.05 - DESPESAS PASTORAIS - Plano de Saúde</option>
                                <option value="58">2.02.06 - DESPESAS PASTORAIS - Seguros Diversos</option>
                                <option value="59">2.02.07 - DESPESAS PASTORAIS - Abono Natalino</option>
                                <option value="60">2.02.08 - DESPESAS PASTORAIS - Previdência Privada (outra além do
                                    CAW)</option>
                                <option value="61">2.02.99 - DESPESAS PASTORAIS - Outras</option>
                                <option disabled value="67">2.03 - AQUISIÇÕES</option>
                                <option value="68">2.03.01 - AQUISIÇÕES - Equipamentos de Som</option>
                                <option value="69">2.03.02 - AQUISIÇÕES - Equipamentos Eletro-Eletrônicos (Geladeiras,
                                    Frizers, Tvs)
                                </option>
                                <option value="70">2.03.03 - AQUISIÇÕES - Mobiliário (cadeiras, mesas, armários)
                                </option>
                                <option value="71">2.03.04 - AQUISIÇÕES - Veículos</option>
                                <option value="107">2.03.05 - AQUISIÇÕES - Imóveis (predios, residencias, salas)
                                </option>
                                <option value="108">2.03.07 - AQUISIÇÕES - Acampamentos</option>
                                <option value="223">2.03.08 - AQUISIÇÕES - Terrenos</option>
                                <option value="110129">2.03.09 - AQUISIÇÕES - Consórcio</option>
                                <option value="72">2.03.99 - AQUISIÇÕES - Outras</option>
                                <option disabled value="73">2.04 - ALUGUÉIS</option>
                                <option value="74">2.04.01 - ALUGUÉIS - Templos (Locais de Culto)</option>
                                <option value="75">2.04.02 - ALUGUÉIS - Edifício Educacional (Prédios, Salas, Casas,
                                    Escolas)</option>
                                <option value="76">2.04.03 - ALUGUÉIS - Terrenos</option>
                                <option value="77">2.04.04 - ALUGUÉIS - Residencias (excepto pastoral e fins
                                    educacionais)</option>
                                <option value="66">2.04.05 - ALUGUÉIS - Casas Pastorais</option>
                                <option value="78">2.04.99 - ALUGUÉIS - Outros</option>
                                <option disabled value="79">2.05 - CONSERVAÇÃO</option>
                                <option value="80">2.05.01 - CONSERVAÇÃO - Material de Limpeza e Higiene</option>
                                <option value="81">2.05.02 - CONSERVAÇÃO - Manutenção de Equipamentos de Som</option>
                                <option value="82">2.05.03 - CONSERVAÇÃO - Manutenção de Equipamentos (exceto eq. som)
                                </option>
                                <option value="85">2.05.04 - CONSERVAÇÃO - Manutenção de Instalações (pequenos reparos)
                                </option>
                                <option value="109">2.05.05 - CONSERVAÇÃO - Manutenção de Veículos</option>
                                <option value="83">2.05.99 - CONSERVAÇÃO - Outros</option>
                                <option disabled value="95">2.07 - AÇÃO SOCIAL</option>
                                <option value="96">2.07.01 - AÇÃO SOCIAL - Ajuda Financeira</option>
                                <option value="97">2.07.02 - AÇÃO SOCIAL - Medicamentos e Roupas</option>
                                <option value="98">2.07.03 - AÇÃO SOCIAL - Distribuição de Alimentos</option>
                                <option value="125">2.07.04 - AÇÃO SOCIAL - Transporte</option>
                                <option value="99">2.07.99 - AÇÃO SOCIAL - Outras</option>
                                <option disabled value="105">2.09 - EVANGELISMO</option>
                                <option value="148">2.09.01 - EVANGELISMO - Distribuição de Literatura (Revistas,
                                    Jornais, Folhetos,
                                    Bíblias)</option>
                                <option value="149">2.09.02 - EVANGELISMO - Cultos, Campanhas e Cruzadas Evangelisticas
                                </option>
                                <option value="150">2.09.03 - EVANGELISMO - Despesas com Obreiros e Preletores</option>
                                <option value="151">2.09.04 - EVANGELISMO - Divulgação e Publicidade</option>
                                <option value="152">2.09.05 - EVANGELISMO - Pontos de Pregação</option>
                                <option value="153">2.09.06 - EVANGELISMO - Visitações</option>
                                <option value="154">2.09.99 - EVANGELISMO - Outros</option>
                                <option disabled value="110">2.10 - CONSTRUÇÕES</option>
                                <option value="111">2.10.01 - CONSTRUÇÕES - Mão de Obra</option>
                                <option value="112">2.10.02 - CONSTRUÇÕES - Materiais</option>
                                <option value="113">2.10.03 - CONSTRUÇÕES - Reformas em Geral</option>
                                <option value="114">2.10.99 - CONSTRUÇÕES - Outros</option>
                                <option disabled value="126">2.11 - DESPESAS FINANCEIRAS</option>
                                <option value="127">2.11.01 - DESPESAS FINANCEIRAS - Tarifas Bancárias</option>
                                <option value="128">2.11.02 - DESPESAS FINANCEIRAS - Juros</option>
                                <option value="167">2.11.03 - DESPESAS FINANCEIRAS - Financiamentos</option>
                                <option value="110122">2.11.04 - DESPESAS FINANCEIRAS - Cheques Incobráveis</option>
                                <option value="110136">2.11.05 - DESPESAS FINANCEIRAS - Taxa Operacional Uso Máquina Cartão
                                </option>
                                <option value="129">2.11.99 - DESPESAS FINANCEIRAS - Outras</option>
                                <option disabled value="131">2.12 - RH - RECURSOS HUMANOS</option>
                                <option value="132">2.12.01 - RH - RECURSOS HUMANOS - Salários dos Funcionarios</option>
                                <option value="133">2.12.02 - RH - RECURSOS HUMANOS - 13o Salário</option>
                                <option value="134">2.12.03 - RH - RECURSOS HUMANOS - Férias</option>
                                <option value="135">2.12.04 - RH - RECURSOS HUMANOS - Prêmios e Gratificações</option>
                                <option value="136">2.12.05 - RH - RECURSOS HUMANOS - Recisões</option>
                                <option value="137">2.12.06 - RH - RECURSOS HUMANOS - Pensões Alimentícias</option>
                                <option value="138">2.12.07 - RH - RECURSOS HUMANOS - Contribuições Sindicais</option>
                                <option value="139">2.12.08 - RH - RECURSOS HUMANOS - Mensalidades Sindicais</option>
                                <option value="140">2.12.09 - RH - RECURSOS HUMANOS - Fundo de Garantia - FGTS</option>
                                <option value="141">2.12.10 - RH - RECURSOS HUMANOS - Imposto de Renda Retido na Fonte -
                                    IRRF</option>
                                <option value="142">2.12.11 - RH - RECURSOS HUMANOS - INSS/GPS</option>
                                <option value="143">2.12.12 - RH - RECURSOS HUMANOS - Vale Transporte</option>
                                <option value="144">2.12.13 - RH - RECURSOS HUMANOS - Vale Alimentação (cesta basica)
                                </option>
                                <option value="145">2.12.14 - RH - RECURSOS HUMANOS - Assistência Médica e Social
                                </option>
                                <option value="146">2.12.15 - RH - RECURSOS HUMANOS - Seguro de Vida dos Empregados
                                </option>
                                <option value="147">2.12.16 - RH - RECURSOS HUMANOS - PIS sobre folha</option>
                                <option value="110123">2.12.18 - RH - RECURSOS HUMANOS - Vale Refeição (ticket alimentação)
                                </option>
                                <option value="165">2.12.99 - RH - RECURSOS HUMANOS - Outros</option>
                                <option disabled value="155">2.13 - EVENTOS</option>
                                <option value="156">2.13.01 - EVENTOS - Campanhas e Gincanas</option>
                                <option value="157">2.13.02 - EVENTOS - Congressos Wesleyanos</option>
                                <option value="158">2.13.03 - EVENTOS - Congressos Outros</option>
                                <option value="159">2.13.04 - EVENTOS - Concílios Gerais</option>
                                <option value="160">2.13.05 - EVENTOS - Concílios Regionais</option>
                                <option value="161">2.13.06 - EVENTOS - Convenções</option>
                                <option value="162">2.13.07 - EVENTOS - Encontros</option>
                                <option value="163">2.13.08 - EVENTOS - Retiros</option>
                                <option value="166">2.13.09 - EVENTOS - Comemorações e Festividades</option>
                                <option value="164">2.13.99 - EVENTOS - Outros</option>
                                <option disabled value="168">2.14 - MINISTÉRIOS ECLESIÁSTICOS</option>
                                <option value="169">2.14.01 - MINISTÉRIOS ECLESIÁSTICOS - Ajuda a obreiros locais
                                    (exceto clérigos)
                                </option>
                                <option value="110016">2.14.02 - MINISTÉRIOS ECLESIÁSTICOS - Pagamento a Obreiros Jubilados
                                </option>
                                <option value="233">2.14.99 - MINISTÉRIOS ECLESIÁSTICOS - Outros</option>
                                <option disabled value="170">2.15 - IMPOSTOS E TAXAS</option>
                                <option value="172">2.15.02 - IMPOSTOS E TAXAS - IPTU</option>
                                <option value="173">2.15.03 - IMPOSTOS E TAXAS - IPVA</option>
                                <option value="174">2.15.04 - IMPOSTOS E TAXAS - ITBI</option>
                                <option value="175">2.15.05 - IMPOSTOS E TAXAS - Multas</option>
                                <option value="176">2.15.06 - IMPOSTOS E TAXAS - Despesas Legais</option>
                                <option value="110046">2.15.07 - IMPOSTOS E TAXAS - IOF</option>
                                <option value="110167">2.15.08 - IMPOSTOS E TAXAS - IRRF Recolhido</option>
                                <option value="180">2.15.96 - IMPOSTOS E TAXAS - Outros Tributos Municipais</option>
                                <option value="179">2.15.97 - IMPOSTOS E TAXAS - Outros Tributos Estaduais</option>
                                <option value="178">2.15.98 - IMPOSTOS E TAXAS - Outros Tributos Federais</option>
                                <option value="177">2.15.99 - IMPOSTOS E TAXAS - Outros</option>
                                <option disabled value="181">2.16 - INSTITUIÇÕES</option>
                                <option value="182">2.16.01 - INSTITUIÇÕES - Acampamentos</option>
                                <option value="183">2.16.02 - INSTITUIÇÕES - CEFORTE</option>
                                <option value="184">2.16.03 - INSTITUIÇÕES - Casa Bom Pastor</option>
                                <option value="185">2.16.04 - INSTITUIÇÕES - AGEMIW</option>
                                <option value="186">2.16.05 - INSTITUIÇÕES - AWAS - Associação Wesleyana de Assistência
                                    Social (e afins)
                                </option>
                                <option value="188">2.16.06 - INSTITUIÇÕES - Outras Instituições MIssionárias</option>
                                <option value="199">2.16.07 - INSTITUIÇÕES - FUEMIS - Fundo de Expansão Missionária
                                </option>
                                <option value="200">2.16.08 - INSTITUIÇÕES - Outras I.M.W.</option>
                                <option value="201">2.16.09 - INSTITUIÇÕES - CP - Jornal Voz Wesleyana</option>
                                <option value="202">2.16.10 - INSTITUIÇÕES - Outras Igrejas ou Denominações</option>
                                <option disabled value="232">2.16.11 - INSTITUIÇÕES - FIW - Fundo Imobiliário Wesleyano
                                </option>
                                <option value="187">2.16.99 - INSTITUIÇÕES - Outras Instituições</option>
                                <option disabled value="203">2.18 - SECRETARIAS</option>
                                <option value="204">2.18.01 - SECRETARIAS - SRF - Regional de Finanças (COTA ÚNICA)
                                </option>
                                <option value="205">2.18.02 - SECRETARIAS - SRM - Regional de Missões</option>
                                <option value="206">2.18.03 - SECRETARIAS - SRA - Regional de Administração</option>
                                <option value="207">2.18.04 - SECRETARIAS - SREC - Regional de Educação Cristã</option>
                                <option value="208">2.18.05 - SECRETARIAS - SRAS - Regional de Ação Social</option>
                                <option value="209">2.18.06 - SECRETARIAS - SGF - Geral de Finanças</option>
                                <option value="210">2.18.07 - SECRETARIAS - SGM - Geral de Missões (Missões
                                    Estrangeiras)</option>
                                <option value="211">2.18.08 - SECRETARIAS - SGA - Geral de Administração</option>
                                <option value="212">2.18.09 - SECRETARIAS - SGEC - Geral de Educação Cristã</option>
                                <option value="213">2.18.10 - SECRETARIAS - SGAS - Geral de Ação Social</option>
                                <option value="220">2.18.11 - SECRETARIAS - SRF/SRA - IR - Repasse Imposto Retido de
                                    Clérigos</option>
                                <option value="221">2.18.12 - SECRETARIAS - SRF/SRA - IR - Repasse Imposto Retido de
                                    Terceiros</option>
                                <option value="110004">2.18.13 - SECRETARIAS - AGEMIW - PAM - Plano de Adoção Missionária
                                    (Missões)
                                </option>
                                <option value="110090">2.18.14 - SECRETARIAS - SGM - Sustento de Missionários</option>
                                <option value="110118">2.18.15 - SECRETARIAS - SGM/SGF - Estorno de depósito bancário
                                </option>
                                <option value="110125">2.18.16 - SECRETARIAS - SRM - Projetos da Secretaria</option>
                                <option value="110126">2.18.17 - SECRETARIAS - SRM - Conferencia Regional</option>
                                <option value="110127">2.18.18 - SECRETARIAS - SRM - Conferencia Distrital</option>
                                <option value="110178">2.18.20 - SECRETARIAS - SRF - Mudanças Pastorais</option>
                                <option value="110179">2.18.21 - SECRETARIAS - SRF - Custeio de Reuniões e Eventos</option>
                                <option value="110182">2.18.22 - SECRETARIAS - SRF - Oferta de Gratidão</option>
                                <option value="110187">2.18.23 - SECRETARIAS - SRA/FIW 100%</option>
                                <option disabled value="214">2.19 - EMPRÉSTIMOS</option>
                                <option value="215">2.19.01 - EMPRÉSTIMOS - SGF/SRF - Secretaria de Finanças</option>
                                <option value="216">2.19.02 - EMPRÉSTIMOS - FIW - Fundo Imobiliário Wesleyano</option>
                                <option value="217">2.19.03 - EMPRÉSTIMOS - Outras Secretarias</option>
                                <option value="218">2.19.04 - EMPRÉSTIMOS - Outras Igrejas</option>
                                <option value="110115">2.19.05 - EMPRÉSTIMOS - Feito a Pastores</option>
                                <option value="219">2.19.99 - EMPRÉSTIMOS - Outros</option>
                                <option disabled value="226">2.20 - DISTRITOS</option>
                                <option value="227">2.20.01 - DISTRITOS - Cota Distrital</option>
                                <option value="229">2.20.02 - DISTRITOS - Ofertas Distritais</option>
                                <option value="110175">2.20.03 - DISTRITOS - Dízimo dos Clérigos (conforme orientação da
                                    região ou
                                    distrito)</option>
                                <option value="228">2.20.99 - DISTRITOS - Outras despesas</option>
                                <option value="110096">3.02 - TRANSFERÊNCIAS - Depósito em Conta Corrente</option>
                                <option value="110095">3.03 - TRANSFERÊNCIAS - Aplicação Financeira</option>
                                <option value="110137">3.06 - TRANSFERÊNCIAS - Crédito Operação Maquina de Cartão</option>
                                <option value="110097">3.12 - TRANSFERÊNCIAS - Saque ou Cheque</option>
                                <option value="110098">3.13 - TRANSFERÊNCIAS - Baixa de Aplicações Financeiras</option>
                                <option value="110128">3.14 - TRANSFERÊNCIAS - Cheques Devolvidos</option>
                                <option disabled value="110001">4 - ESTORNOS</option>
                            </select>
                        </div>

                        <div class="mb-3 col-lg-3 col-md-3 col-sm-6 pf lgpd">
                            <label for="d1">Data do Inicial</label>
                            <input class="form-control date" id="d1" name="d1" maxlength="20"
                                value="" type="text" placeholder="">
                        </div>

                        <div class="mb-3 col-lg-3 col-md-3 col-sm-6 pf lgpd">
                            <label for="d2">Data do Final</label>
                            <input class="form-control date" id="d2" name="d2" maxlength="20"
                                value="" type="text" placeholder="">
                        </div>

                        <div class="form-group col-lg-1 col-md-2 col-sm-6 mt-4">
                            <button class="btn btn-primary btn-rounded"><i class="fa fa-search" aria-hidden="true"></i>
                                Buscar</button>
                        </div>
                        <div class="form-group col-lg-1 col-md-2 col-sm-6 mt-4">

                            <button class="btn btn-danger btn-rounded" type="button"> <i
                                    class="fas fa-fw fa-eraser"></i> Limpar</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <div class="card mb-3">

            <div class="card-body">
                <div class="row">

                    <div class="col-12">

                        <a href="#"
                            title="Inserir um novo registro" class="btn btn-success right btn-rounded"> <i
                                class="fas fa-plus-circle"></i>
                            Entradas </a>

                        <a href="#"
                            title="Inserir um novo registro" class="btn btn-danger right btn-rounded"> <i
                                class="fas fa-minus-circle"></i>
                            Saída </a>


                        <a href="#"
                            title="Inserir um novo registro" class="btn btn-warning right btn-rounded"> <i
                                class="fas fa-forward"></i>
                            Transferência </a>

                        <a href="#"
                            title="Inserir um novo registro" class="btn btn-primary right btn-rounded"> <i
                                class="fas fa-money-bill-alt"></i> Saldo </a>

                        <table class="table table-striped" style="font-size: 90%; margin-top: 15px;">
                            <thead class="thead-light">
                                <tr>

                                    <th>Data</th>
                                    <th>Caixa</th>
                                    <th>Entrada</th>
                                    <th>Saída</th>
                                    <th>Plano de Conta</th>
                                    <th>Pagante/Favorecido</th>



                                    <th width="150"></th>
                                </tr>
                            </thead>
                            <tbody>

                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="row">
                    <div class="col-12 text-center">
                        <button class="btn btn-success btn-rounded" onclick="exportReportToExcel();"><i class="fa fa-file-excel"
                                aria-hidden="true"></i> Exportar</button>
                    </div>
                </div>
            </div>
        </div>
        {{-- Fim Conteúdo --}}
    </div>
    </div>
    </div>
@endsection
