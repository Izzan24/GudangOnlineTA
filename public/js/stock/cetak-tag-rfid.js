let barang = '';
let tanggal = '';
const rfidData = (faktur) => {
    barang = $('.filter_barang').val() || '';
    tanggal = $('.filter_tanggal').val() || '';
    return $.get(`${base_url}/api/rfid/${faktur || ''}?tanggal=${tanggal}&barang=${barang}`);
}
const getRfidData = () => {
    rfidData().then(res => {
        renderRfidData(res)
    });
}

const renderRfidData = (res) => {
    if ($.fn.DataTable.isDataTable( '#rfid' ) ) {
        $("#rfid").DataTable().destroy();
        $("#rfid tbody").empty();
    }
    
    let $data = "";
    res.forEach((row, index) => {
        $data += `<tr>
                <td width="5%">${++index}</td>
                <td>${row.name} - ${row.identifier_barang}</td>
                <td width="27%">${row.rfid_tag}</td>
                <td width="27%">${row.created_at}</td>
            </tr>`
    });

    $('#rfid tbody').html($data);

    $("#rfid").DataTable({
        columns: [
            { orderable: true },
            { orderable: true },
            { orderable: true },
            { orderable: true },
        ],
        language: {
            url: "//cdn.datatables.net/plug-ins/1.11.5/i18n/id.json",
        },
        destroy:true,
    });
}

const getBarangData = () => {
    $.get(`${base_url}/api/barang`, (res) => {
        $barang_option = "<option value=''>Pilih Barang</option>";
        res.forEach(row => {
            $barang_option += `<option value="${row.code}">${row.code} - ${row.name} (${row.kategori})</option>`;
        });

        $('.barang').html($barang_option);
	});
}

const createRfidTag = async () => {
    const data = dataForm('form#form');

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

    let rfidCheck = await rfidData(data.rfid_tag);
    if(!rfidCheck){
        $.ajax({
            method: "POST",
            url: `${base_url}/api/rfid`,
            data: data,
            success: (res) => {
                getRfidData();
                $('form#form').trigger('reset');
                showCallout('success', 'Berhasil menyimpan data')
            },
            error: () => {
                showCallout('warning', 'Kesalahan pada server')
            },
        });
    }else{
        showAlert("#message",'warning', 'Duplikat RFID Tag!');
        return;
    }

}
