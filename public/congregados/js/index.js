$(document).ready(function () {
    // pega os valores dos parametros de pesquisa
    function getSearchParameters() {
        return {
            search: $('#searchInput').val(),
            status: $('input[name="status"]:checked').val(),
        }
    }

    // ativa as ações dos botões na datatable
    function activeActions() {
        $('.btn-confirm-delete').on('click', function () {
            const formId = $(this).data('form-id')
            swal({
                title: 'Deseja realmente apagar os registros deste congregado?',
                type: 'error',
                showCancelButton: true,
                confirmButtonText: "Deletar",
                confirmButtonColor: "#d33",
                cancelButtonText: "Cancelar",
                cancelButtonColor: "#3085d6",
                padding: '2em'
            }).then(function (result) {
                if (result.value) document.getElementById(formId).submit()
            })
        })
    }

    // passa as opções customizadas para o DataTable
    const optionsDataTable = {
        ajax: {
            url: $('#datatable').data('url'),
            data: function (d) {
                d.parameters = getSearchParameters();
            }
        },
        columns: [
            { data: 'nome', name: 'nome' },
            {
                data: 'congregacao',
                name: 'congregacao',
                render: function (data, type, row, meta) {
                    return data ? data.nome : 'N/A';
                }
            },
        ],
        columnDefs: [
            {
                targets: 0,
                orderable: 1,
                render: function (data, type, row, meta) {
                    if (row.deleted_at) {
                        return `<span class="badge badge-danger"> ${row.nome} </span>`
                    } else if (row.has_errors) {
                        return `<span class="badge badge-warning"> ${row.nome} </span>`
                    } else {
                        return row.nome
                    }
                }
            },
            {
                targets: 2,
                orderable: 0,
                render: function (data, type, row, meta) {
                    return `${row.actions}`
                }
            }
        ],
    }

    // inicia o DataTable
    const dataTable = initDataTable(
        '#datatable', // selector
        optionsDataTable, // options
        function () { // drawCallback
            activeActions();
        }
    );

    // atrela a pesquisa pelo formulário ao datatable
    $('#searchForm').on('submit', function (e) {
        e.preventDefault();
        dataTable.ajax.reload();
    });
});
