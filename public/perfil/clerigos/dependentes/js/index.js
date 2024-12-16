$(document).ready(function() {
  $('.btn-confirm-delete').on('click', function() {
    const formId = $(this).data('form-id')
    swal({
      title: 'Deseja realmente apagar os registros deste dependente?',
      type: 'error',
      showCancelButton: true,
      confirmButtonText: "Deletar",
      confirmButtonColor: "#d33",
      cancelButtonText: "Cancelar",
      cancelButtonColor: "#3085d6",
      padding: '2em'
    }).then(function(result) {
      if (result.value) document.getElementById(formId).submit()
    })
  })

  initDataTable('#datatable', { serverSide: false });
});