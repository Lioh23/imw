$(document).ready(function () {
  var maskBehavior = function (val) {
    return val.replace(/\D/g, '').length === 13 ? '+00 (00) 00000-0000' : '+00 (00) 0000-00009';
  },
    options = {
      onKeyPress: function (val, e, field, options) {
        field.mask(maskBehavior.apply({}, arguments), options);
      }
    };

  $('#telefone_preferencial, #telefone_alternativo, #telefone_whatsapp').mask(maskBehavior, options);
});
