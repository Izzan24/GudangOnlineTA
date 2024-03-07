$(document).on("blur", ".required", function (e) {
  e.target.classList.remove("is-invalid");
  $(`#${e.target.id}`).parent().find(".invalid-feedback").remove();

  if (e.target.value == "") {
    $(`#${e.target.id}`).addClass("is-invalid");
    $(`#${e.target.id}`)
        .parent()
        .append(
          `<div class="invalid-feedback">Field ini harus di isi.</div>`
        );
  }
});

const formatSafeNumber = (val = '') => {
  return val.replaceAll(',','');
}

const formatInputNumber = (ele) => {
  let value = formatSafeNumber($(ele).val());

  if(value != "" && !isNaN(value)){
    $(ele).val( parseInt(value).toLocaleString() );
  }else{
    $(ele).val('');
  }
}

const formatInputRupiah = (ele) => {
  if($(ele).val() != ""){
    let rupiah = $(ele).val().replaceAll(',', '');
    $(ele).val(formatRupiah(rupiah));
  }
}

const formatRupiah = (val) => {
  let pecah_nominal = val.split('.');
  if(isNaN(parseInt(pecah_nominal[0]))) return '';
  let desimal = ( !isNaN(pecah_nominal[1]) || pecah_nominal[1] == '' ? `.${pecah_nominal[1]}` : '');
  
  return parseInt(pecah_nominal[0]).toLocaleString()+desimal;
}

$('input').on('keydown', (event) => {
  if (event.which === 13 || event.keyCode === 13 || event.key === "Enter") {
      $(event.target.id).closest('form').submit();
  }
    return true;
});

const showAlert = (element,type, message) => {
    $(element).html(`<div class="alert w-100 alert-${type} show-alert" role="alert">
        ${message}
    </div>`);

    setTimeout(() => {
        $('.show-alert').fadeOut() 
    },  5000);
}

const showCallout = (type, message, timeout) => {
  $(".container-alert .alert").removeClass("alert-warning alert-success alert-danger alert-info");
  $('.container-alert .alert').addClass(`alert-${type}`);
  $('.container-alert .alert').text(message);
  $('.container-alert').css('display','').delay(timeout ?? 3000).fadeOut('smooth');
}

const resetForm = (ele) => {
    $(ele ?? 'form')[0].reset()
}

const dataForm = (form) => {
  return $(form)
    .serializeArray()
    .reduce(function(json, {
      name,
      value
    }) {
      json[name] = value;
      return json;
    }, {});
};

const deleteConfirm = (title, message, buttonText, callback, ...params) => {
  $('#modalGlobal .modal-title').text(title);
  $('#modalGlobal .modal-body').text(message);
  $('#modalGlobal .modal-footer #ok').text(buttonText);
  $('#modalGlobal .modal-footer #ok').click(function(e) {
    $.when(callback(...params)).then((res) => {
        $('#modalGlobal').modal('hide');
    });
    $('#modalGlobal .modal-footer #ok').off('click')
  });

  $('#modalGlobal').modal('show');
}