const loadLokasiData = () => {
    $.get(`${base_url}/api/sub-lokasi`).then(res => {
        renderLokasiTable(res);
    })
}

const renderLokasiTable = (res) => {
    if ($.fn.DataTable.isDataTable( '#table' ) ) {
        $("#table").DataTable().destroy();
        $("#table tbody").empty();
    }

    $template = ``;
    res.forEach((element, index) => {
        $template += `<tr>
            <td width="3%">${++index}</td>
            <td>${element.lokasi || ''} - ${element.name}</td>
            <td width="15%">
                <a href="javascript:void(0);" onclick="editSubLokasi('${element.id}','${element.name}')" class="text-primary mr-2">
                    <i class="fas fa-edit"></i>
                </a>
                <a href="javascript:void(0);" onclick="deleteConfirm('Konfirmasi', 'Apakah anda yakin menghapus ${element.name}?', 'Delete', deleteSubLokasi, ${element.id});" class="text-primary">
                    <i class="fas fa-trash-alt"></i>
                </a>
            </td>
        </tr>`
    });
    $("#table tbody").html($template);
    $("#table").DataTable({
        columns: [
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

const getLokasiData = async () => {
    return await $.get(`${base_url}/api/lokasi`)
}

const renderLokasiData = async (clickButton = false) => {
    console.log(clickButton);
    if ($.fn.DataTable.isDataTable( '#lokasi' ) ) {
        $("#lokasi").DataTable().destroy();
        $("#lokasi tbody").empty();
    }
	
    let $result = "";
    getLokasiData().then(res => {
        res.forEach((element, i) => {
            $result += `<tr>
                <td width="3%">${++i}</td>
                <td>${element.name}</td>
                <td width="15%">
                    <a href="javascript:void(0);" onclick="editLokasi('${element.id}','${element.name}')" class="text-primary mr-2">
                        <i class="fas fa-edit"></i>
                    </a>
                    <a href="javascript:void(0);" onclick="deleteConfirm('Konfirmasi', 'Apakah anda yakin menghapus ${element.name}?', 'Delete', deleteLokasi, ${element.id});" class="text-primary">
                        <i class="fas fa-trash-alt"></i>
                    </a>
                </td>
            </tr>`;
        });
        $("#lokasi tbody").html($result);
    })


    $("#lokasi").DataTable({
        columns: [
            { orderable: true },
            { orderable: true },
            { orderable: false },
        ],
        language: {
            url: "//cdn.datatables.net/plug-ins/1.11.5/i18n/id.json",
        },
        destroy:true,
    });

    if(clickButton == true){
        $('#modalLokasi').modal('show');
    }
}

const renderLokasiSelect = () => {
    $select = "<option value=''>Pilih Lokasi</option>";
    return new Promise((resolve, reject) => {
        getLokasiData().then((res) => {
            res.forEach(element => {
                $select += `<option value='${element.id}'>${element.name}</option>`;
            });
            $('#select-lokasi').html($select);

            resolve(true);
        });
    })
}

const addLokasi = () => {
    resetForm('#modalLokasi form');
    $('#modalLokasi label[for="name"]').html(`Tambah Ruangan`);
    renderLokasiData(true);
}

const editLokasi = (id, name) => {
    $('#modalLokasi label[for="name"]').html(`Edit Ruangan ${name}`);
    $('#modalLokasi #id').val(id);
    $('#modalLokasi #name').val(name);
}

const saveLokasi = (ev) => {
    const data = dataForm(ev);

    $('#modalLokasi .required').each(function (e, i) {
        if($(i).val() == ''){
            $(i).addClass("is-invalid");
            $(i).parent().append(`<div class="invalid-feedback">Field ini harus di isi.</div>`);
        }else{
            $(i).removeClass("is-invalid");
            $(i).parent().find(".invalid-feedback").remove();
        }
    });
   
    if($(ev).find('.is-invalid').length){
        return;
    }

    $.ajax({
        method: `${data.id ? "PUT" : "POST"}`,
        url: `${base_url}/api/lokasi${data.id ? "/"+data.id : ""}`,
        data: data,
        success: (res) => {
            resetForm('#modalLokasi form');
            $('#modalLokasi #id').val('');
            $('#modalLokasi label[for="name"]').html(`Tambah Ruangan`);
            renderLokasiData();
            showAlert('#alertModalLokasi', 'success', 'Berhasil menyimpan data')
        },
        error: () => {
            showAlert('#alertModalLokasi', 'warning', 'Kesalahan pada server')
        },
    });
}

const deleteLokasi = (id) => {
    $.ajax({
        method: `DELETE`,
        url: `${base_url}/api/lokasi/${id}`,
        success: (res) => {
            renderLokasiData();
            showAlert('#alertModalLokasi', 'success', 'Berhasil menghapus data')
        },
        error: () => {
            showAlert('#alertModalLokasi', 'warning', 'Kesalahan pada server')
        },
    });
}

/**
 * 
 * Sub Lokasi Code
 * 
 */

const addSubLokasi = () => {
    resetForm('#modalSubLokasi form');
    $('#modalSubLokasi form #id').val('');
    $('#modalSubLokasi .modal-title').html(`Input Sub Lokasi`);
    renderLokasiSelect();
    
    $('#modalSubLokasi').modal('show');
}

const editSubLokasi = (id) => {
    resetForm('#modalSubLokasi form');

    renderLokasiSelect();
    return new Promise((resolve, reject) => {
        $.get(`${base_url}/api/sub-lokasi/${id}`).then(res => {
             $('#modalSubLokasi .modal-title').html(`Edit Sub Lokasi ${res.lokasi} - ${res.name}`);
             $('#modalSubLokasi form #id').val(`${res.id}`);
             $('#modalSubLokasi form #sub-lokasi-name').val(`${res.name}`);
              if($('#select-lokasi option[value="'+res.parent+'"]').length){
                 $('#select-lokasi option[value="'+res.parent+'"]').prop('selected', true);
             }else{
                 $('#select-lokasi').append(`<option value="${res.parent}" selected>${res.lokasi}</option>`)
             }
    
            $('#modalSubLokasi').modal('show');
            resolve(res);
        })
    })
}

const saveSubLokasi = (ev) => {
    const data = dataForm(ev);

    $('#modalSubLokasi .required').each(function (e, i) {
        if($(i).val() == ''){
            $(i).addClass("is-invalid");
            $(i).parent().append(`<div class="invalid-feedback">Field ini harus di isi.</div>`);
        }else{
            $(i).removeClass("is-invalid");
            $(i).parent().find(".invalid-feedback").remove();
        }
    });
   
    $.ajax({
        method: `${data.id ? "PUT" : "POST"}`,
        url: `${base_url}/api/sub-lokasi${data.id ? "/"+data.id : ""}`,
        data: data,
        success: (res) => {
            resetForm('#modalSubLokasi form');
            $('#modalSubLokasi #id').val('');
            loadLokasiData();
            $('#modalSubLokasi').modal('hide');
            showAlert('#alert', 'success', 'Berhasil menyimpan data')
        },
        error: () => {
            showAlert('#alert', 'warning', 'Kesalahan pada server')
        },
    });
}


const deleteSubLokasi = (id) => {
    $.ajax({
        method: `DELETE`,
        url: `${base_url}/api/sub-lokasi/${id}`,
        success: (res) => {
            loadLokasiData();
            showAlert('#alert', 'success', 'Berhasil menghapus data')
        },
        error: () => {
            showAlert('#alert', 'warning', 'Kesalahan pada server')
        },
    });
}