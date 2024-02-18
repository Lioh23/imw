const createVisitantes = {

    iniciarCampos()
    {
        this.form = $('#form_create_visitantes');
    },

    inicarEventos()
    {
        myself = this;

        this.form.submit(myself.salvarFormulario)
    },

    salvarFormulario(event)
    {
        event.preventDefault();

        const data = $(this).serializeArray().reduce((acc, obj) => {            
            acc[obj.name] = obj.value
            return acc;
        }, {});

        console.log( { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') });
        
        $.ajax({
            type: "POST",
            url: '/visitantes/salvar',
            headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
            data: data,
            beforeSend: function () {
                console.log('enviando...');
            },
            success: function (response) {
                console.log(response)
            },
            error: function (err) {
                console.log(err)
            },
            complete() {
                console.log('foi!');
            }
        });
    },

    iniciar() 
    {
        this.iniciarCampos()
        this.inicarEventos()
    }
}


$(document).ready(function() {
  $('#telefone_preferencial, #telefone_alternativo, #whatsapp').mask('(00) 00000-0000');

  createVisitantes.iniciar();
});
