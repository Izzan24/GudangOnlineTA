const loadKategoriData = () => {
    $.get(`${base_url}/api/kategori`, (res) => {
        renderKategoriData(res);
	});
}

const renderKategoriData = (res) => {
    if ($.fn.DataTable.isDataTable( '#table' ) ) {
        $("#table").DataTable().destroy();
        $("#table tbody").empty();
    }
	
    let $result = "";
    res.forEach((element, i) => {
        $result += `<tr>
            <td width="3%">${++i}</td>
            <td>${element.name}</td>
            <td>
                <a href="/kategori/edit/${element.id}" class="text-primary mr-2">
                    <i class="fas fa-edit"></i>
                </a>
                <a href="javascript:void(0);" onclick="deleteConfirm('Konfirmasi', 'Apakah anda yakin menghapus ${element.name}?', 'Delete', deleteKategori, ${element.id});" class="text-primary">
                    <i class="fas fa-trash-alt"></i>
                </a>
            </td>
        </tr>`;
    });

    $("#table tbody").html($result);

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

const getKategori = (id) => {
    if(!id){
        $('.card-title').text('Tambah Kategori');
    }else{
        $('.card-title').text('Edit Kategori');
        $.get(`${base_url}/api/kategori/${id}`)
        .then((res) => {
            $('#name').val(res.name);
        })
        .fail(() => { alert('Data tidak dapat ditemukan'); window.location.href = '/kategori'; });
    }
}

const saveKategori = () => {
    const data = dataForm('form#form');
    $('.required').each(function (e, i) {
        if($(i).val() == ''){
            $(i).addClass("is-invalid");
            $(i).parent().append(`<div class="invalid-feedback">Field ini harus di isi.</div>`);
        }else{
            $(i).removeClass("is-invalid");
            $(i).parent().find(".invalid-feedback").remove();
        }
    });
   
    if($('form#form').find('.is-invalid').length){
        return;
    }

    $.ajax({
        method: `${id ? "PUT" : "POST"}`,
        url: `${base_url}/api/kategori/${id}`,
        data: data,
        success: (res) => {
            if(!id) resetForm();
            showAlert('#alert', 'success', 'Berhasil menyimpan data')
        },
        error: () => {
            showAlert('#alert', 'warning', 'Kesalahan pada server')
        },
    });
}

const deleteKategori = async (id) => {
    return new Promise((resolve, reject) => {
        $.ajax({
            method: "DELETE",
            url: `${base_url}/api/kategori/${id}`,
            success: (res) => {
                showAlert('#alert', 'success', 'Berhasil menghapus data');
                loadKategoriData();
                resolve(true);
            },
            error: () => {
                showAlert('#alert', 'warning', 'Kesalahan pada server')
            },
        });
    })
    
}