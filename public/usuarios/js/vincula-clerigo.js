$(document).ready(function() {
    let prevCpf = '';

    $('#cpf').blur(function () {
        const cpf = this.value.replace(/\D/g, '');

        if (prevCpf === cpf) return;

        $('#check_clerigo_container').attr('hidden', true);
        $('#chk_clerigo_id').prop('checked', false);
        
        if (cpf.length === 11) {
           prevCpf = cpf; 

            $.ajax({
                method: "get",
                url: `${window.location.origin}/clerigos/buscar-por-cpf/${cpf}`,
                success: function ({ clerigo }) {
                    $('#check_clerigo_container').removeAttr('hidden');
                    $('#clerigo_nome').text(clerigo.nome);
                    $('#chk_clerigo_id').val(clerigo.id);
                    $('#chk_clerigo_id').data('clerigoId', clerigo.id);
                }
            });
        }
    });

    $('#chk_clerigo_id').on('change', function() {
        if (this.checked) {
            $('#pessoa_id').val($(this).data('clerigoId'));
        } else {
            $('#pessoa_id').val('');
        }
    });
})