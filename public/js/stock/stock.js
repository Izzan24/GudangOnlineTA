const loadStokData = () => {
    $.get(`${base_url}/api/stok`, (res) => {
        renderStokData(res);
	});
}

const renderStokData = (res) => {
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
            <td width="15%">${element.unit}</td>
            <td width="15%">${element.stok}</td>
            <td>
                <a href="javascript:void(0)" onclick="loadInStokData('${element.code}','${element.name}');" class="text-primary mr-2">
                    <i class="fas fa-warehouse"></i>
                </a>
                <a href="javascript:void(0)" onclick="loadOutStokData('${element.code}','${element.name}');" class="text-primary mr-2">
                    <i class="fas fa-truck"></i>
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
            { orderable: false },
        ],
        language: {
            url: "//cdn.datatables.net/plug-ins/1.11.5/i18n/id.json",
        },
        destroy:true,
    });

}

const loadInBoundData = () => {
    $.get(`${base_url}/api/barang-masuk`, (res) => {
        var list_faktur = res.map(d => d.faktur);
        $('#faktur_beli').autocomplete({source: list_faktur});
	});
}

const loadOutBoundData = () => {
    $.get(`${base_url}/api/barang-keluar`, (res) => {
        var list_faktur = res.map(d => d.faktur);
        $('#faktur_jual').autocomplete({source: list_faktur});
	});
}

const resetInStokFilter = () => {
    $("#faktur_beli").val('');
    $("#tanggal_beli").val('');
    loadInStokData();
}

const resetOutStokFilter = () => {
    $("#faktur_jual").val('');
    $("#tanggal_jual").val('');
    loadOutStokData();
}

const loadOutStokData = (kode, name) => {
    if(kode){
        $('#modalOutStokBarang .modal-title').html(`List out Stock - <b>${name || ''}</b>`);
        $("#faktur_jual").val('');
        $("#tanggal_jual").val('');
        $("#code").val(kode);
    }
    let kode_search = $("#code").val() ?? kode;
    let faktur_search = $("#faktur_jual").val();
    let date_search = $("#tanggal_jual").val();

    if(!kode_search) return;
    $.get(`${base_url}/api/stok/${kode_search}/${(faktur_search ? faktur_search : "null")}/${date_search}?out=1`, (res) => {
        renderOutStokData(res);
	});
}

const renderOutStokData = (res) => {
    if ($.fn.DataTable.isDataTable( '#out-stok-data' ) ) {
        $("#out-stok-data").DataTable().destroy();
        $("#out-stok-data tbody").empty();
    }

    let $result = "";
    res.forEach((element, i) => {

        $result += `<tr>
            <td width="2%">${++i}</td>
            <td width="15%">${element.tanggal}</td>
            <td>${element.faktur}</td>
            <td width="20%" class="text-right">${parseFloat(element.harga_jual).toLocaleString()}</td>
            <td width="25%">${element.rfid_tag}</td>
        </tr>`
    });

    $("#out-stok-data tbody").html($result);

    $("#out-stok-data").DataTable({
        columns: [
            { orderable: true },
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

    $('#modalOutStokBarang').modal('show');
}


const loadInStokData = (kode, name) => {
    if(kode){
        $('#modalInStokBarang .modal-title').html(`List in Stock - <b>${name || ''}</b>`);
        $("#faktur_beli").val('');
        $("#tanggal_beli").val('');
        $("#code").val(kode);
    }
    let kode_search = $("#code").val() ?? kode;
    let faktur_search = $("#faktur_beli").val();
    let date_search = $("#tanggal_beli").val();

    if(!kode_search) return;
    $.get(`${base_url}/api/stok/${kode_search}/${(faktur_search ? faktur_search : "null")}/${date_search}`, (res) => {
        renderInStokData(res);
	});
}

const renderInStokData = (res) => {
    if ($.fn.DataTable.isDataTable( '#in-stok-data' ) ) {
        $("#in-stok-data").DataTable().destroy();
        $("#in-stok-data tbody").empty();
    }

    let $result = "";
    res.forEach((element, i) => {

        $result += `<tr>
            <td width="2%">${++i}</td>
            <td width="15%">${element.tanggal}</td>
            <td>${element.faktur}</td>
            <td width="20%" class="text-right">${parseFloat(element.harga_beli).toLocaleString()}</td>
            <td width="25%">${element.rfid_tag}</td>
        </tr>`
    });

    $("#in-stok-data tbody").html($result);

    $("#in-stok-data").DataTable({
        columns: [
            { orderable: true },
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

    $('#modalInStokBarang').modal('show');
}