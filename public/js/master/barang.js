const loadBarangData = () => {
    $.get(`${base_url}/api/barang`, (res) => {
        renderBarangData(res);
	});
}

const renderBarangData = (res) => {
    if ($.fn.DataTable.isDataTable( '#table' ) ) {
        $("#table").DataTable().destroy();
        $("#table tbody").empty();
    }
	
    let $result = "";
    res.forEach((element, i) => {
        $result += `<tr>
            <td width="5">${++i}</td>
            <td width="40">${element.code}</td>
            <td>${element.name}</td>
            <td width="40">${element.kategori}</td>
            <td width="50">${element.satuan}</td>
            <td width="90" class="text-right">${parseFloat(element.harga_beli).toLocaleString()}</td>
            <td width="90" class="text-right">${parseFloat(element.harga_jual).toLocaleString()}</td>
            <td>
                <a href="/barang/edit/${element.code}" class="text-primary mr-2">
                    <i class="fas fa-edit"></i>
                </a>
                <a href="javascript:void(0);" onclick="deleteConfirm('Konfirmasi', 'Apakah anda yakin menghapus ${element.name}?', 'Delete', deleteBarang, '${element.code}');" class="text-primary">
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

$(document).on("blur", "#code", function (e) {
  e.target.classList.remove("is-invalid");
  $(`#${e.target.id}`).parent().find(".invalid-feedback").remove();

  if (e.target.value != "") {
    getBarangByCode(e.target.value)
    .then((res) => {
        if(Object.keys(res).length){
            $(`#${e.target.id}`).val('')
            showAlert('#alert', 'warning', 'Kode barang sudah dipakai!');
        }
    });
  }
});

const getBarang = (code) => {
    $('.card-title').text(code ? 'Edit Barang' : 'Tambah Barang');

    $.when(getKategoriSelect(), getSatuanSelect())
    .then((select_kategori, select_satuan) => {
        $kategori_option = $satuan_option = "";

        select_kategori.forEach((kategori) => {
            $kategori_option += `<option value="${kategori.id}">${kategori.name}</option>`
        });
        $('#kategori').append($kategori_option);

        select_satuan.forEach((satuan) => {
            $satuan_option += `<option value="${satuan.id}">${satuan.name}</option>`
        });
        $('#satuan').append($satuan_option);
        
        if(code){
            getBarangByCode(code)
            .then((res) => {
                $('#name').val(res.name);
                $('#harga_jual').val(res.harga_jual).trigger('keyup');
                $('#harga_beli').val(res.harga_beli).trigger('keyup');

                if($('#kategori option[value="'+res.kategori+'"]').length){
                    $('#kategori option[value="'+res.kategori+'"]').prop('selected', true);
                }else{
                    $('#kategori').append(`<option value="${res.kategori}" selected>${res.kategori_name}</option>`)
                }

                if($('#satuan option[value="'+res.satuan+'"]').length){
                    $('#satuan option[value="'+res.satuan+'"]').prop('selected', true);
                }else{
                    $('#satuan').append(`<option value="${res.satuan}" selected>${res.satuan_name}</option>`)
                }
                
            })
            .fail(() => {
                alert('Data tidak dapat ditemukan');
                window.location.href = '/barang';
            });
        }

    })
}

const getKategoriSelect = async () => {
    return $.get(`${base_url}/api/kategori`);
}

const getSatuanSelect = async () => {
    return $.get(`${base_url}/api/satuan`);
}

const getBarangByCode = async (code) => {
    return await $.get(`${base_url}/api/barang/${code}`);
}

const saveBarang = () => {
    const data = dataForm('form#form');
    data.harga_jual = data.harga_jual.replaceAll(',','');
    data.harga_beli = data.harga_beli.replaceAll(',','');

    $('.required').each(function (e, i) {
        $(i).removeClass("is-invalid");
        $(i).parent().find(".invalid-feedback").remove();

        if($(i).val() == ''){
            $(i).addClass("is-invalid");
            $(i).parent().append(`<div class="invalid-feedback">Field ini harus di isi.</div>`);
        }
    });
   
    if($('form#form').find('.is-invalid').length){
        return;
    }

    $.ajax({
        method: `${id ? "PUT" : "POST"}`,
        url: `${base_url}/api/barang/${id}`,
        data: data,
        success: (res) => {
            if(!id) resetForm();
            $("html, body").animate({ scrollTop: 0 }, "fast");
            showAlert('#alert', 'success', 'Berhasil menyimpan data')
        },
        error: () => {
            $("html, body").animate({ scrollTop: 0 }, "fast");
            showAlert('#alert', 'warning', 'Kesalahan pada server')
        },
    });
}

const deleteBarang = (id) => {
    $.ajax({
        method: "DELETE",
        url: `${base_url}/api/barang/${id}`,
        success: (res) => {
            showAlert('#alert', 'success', 'Berhasil menghapus data');
            loadBarangData();
        },
        error: () => {
            showAlert('#alert', 'warning', 'Kesalahan pada server')
        },
    });
}