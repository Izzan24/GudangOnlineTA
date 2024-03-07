const loadDataUser = () => {
    $.get(`${base_url}/api/user`).then((res) => {
        renderDataUser(res);
    }).fail((e) => {
        showCallout("warning", e.responseJSON.message || 'Terjadi Kesalahan');
    });
}

const renderDataUser = (res) => {
    if ($.fn.DataTable.isDataTable( '#table' ) ) {
        $("#table").DataTable().destroy();
        $("#table tbody").empty();
    }
	
    let $result = "";
    res.forEach((element, i) => {
        $result += `<tr>
            <td width="5">${++i}</td>
            <td width="40">${element.name}</td>
            <td>${element.username}</td>
            <td><span class="text-primary password" data-pass="${element.password}" onclick="showPassword($(this))">*********</span></td>
            <td>
                <a href="/user/edit/${element.id}" class="text-primary mr-2">
                    <i class="fas fa-edit"></i>
                </a>
                <a href="javascript:void(0);" onclick="deleteConfirm('Konfirmasi', 'Apakah anda yakin menghapus ${element.name}?', 'Delete', deleteUser, '${element.id}');" class="text-primary">
                    <i class="fas fa-trash-alt"></i>
                </a>
            </td>
        </tr>`
    });

    $("#table tbody").html($result);

    $("#table").DataTable({
        columns: [
            { orderable: true },
            { orderable: true },
            { orderable: true },
            { orderable: true },
            { orderable: false },
        ],
        language: {
            url: "//cdn.datatables.net/plug-ins/1.11.5/i18n/id.json",
        },
        destroy:true,
    });
}

const showPassword = (ev) => {
    let element = $(ev);
    if(element.hasClass('showed')){
        element.text('*********');
        element.removeClass('showed');
    }else{
        element.addClass('showed');
        element.text(element.data('pass'));
    }
}

const loadDataFormUser = (id) => {
    if(!id) return;
    $.get(`${base_url}/api/user/${id}`).then((res) => {
        setFormUserData(res);
    }).fail((e) => {
        window.location.href = '/user'
        showCallout("warning", e.responseJSON.message || 'Terjadi Kesalahan');
    });
}

const setFormUserData = (data) => {
    $('#username').val(data.username);
    $('#name').val(data.name);
    $('#password').val(data.password);
}

const saveUser = () => {
    const data = dataForm('form#form');
    $('.required').each(function (e, i) {
            $(i).removeClass("is-invalid");
            $(i).parent().find(".invalid-feedback").remove();

            if($(i).val() == ''){
                $(i).addClass("is-invalid");
                $(i).parent().append(`<div class="invalid-feedback">Field ini harus di isi.</div>`);
            }
        });
        
    $.ajax({
        method: `${id  ? 'PUT': 'POST'}`,
        url: `${base_url}/api/user${id  ? '/'+id : ''}`,
        data: data,
        success: (res) => {
           if(!id) $('form').trigger('reset');
            showAlert("#alert","success", res);
        },
        error: (res) => {
            showAlert("#alert","warning", e.responseJSON || 'Terjadi Kesalahan');
        },
    })
}

const deleteUser = (id) => {
    $.ajax({
        method: "delete",
        url: `${base_url}/api/user/${id}`,
        success: (res) => {
            showAlert('#alert', 'success', res);
            loadDataUser();
        },
        error: (res) => {
            showAlert('#alert', 'warning', res.responseText || 'Kesalahan pada server')
        },
    })
}