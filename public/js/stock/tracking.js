// Select 
const loadBarangSelect = () => {
    $.get(`${base_url}/api/barang`, (res) => {
        $select = '<option value="">Pilih Barang</option>';
        res.forEach(element => {
            $select += `<option value="${element.code}">${element.name}</option>`
        });
        $('#barang').html($select)
	});
}

const loadLokasiSelect = () => {
    $.get(`${base_url}/api/sub-lokasi`, (res) => {
        $select = '<option value="">Pilih Lokasi</option>';
        res.forEach(element => {
            $select += `<option value="${element.id}">${element.lokasi} - ${element.name}</option>`
        });
        $('#lokasi').html($select)
	});
}

// Data
const loadTrackingData = () => {
    let barang = $('#barang').val() || '';
    let lokasi = $('#lokasi').val() || '';
    $.get(`${base_url}/api/tracking-barang?barang=${barang}&lokasi=${lokasi}`, (res) => {
        renderTrackingData(res);
	});
}

const renderTrackingData = (res) => {
    if ($.fn.DataTable.isDataTable( '#table' ) ) {
        $("#table").DataTable().destroy();
        $("#table tbody").empty();
    }

    let $table = ``;
    if(res.length == 0) $table = `<tr><td colspan="5" class="text-center">Data tracking masih kosong.</td></tr>`
    res.forEach((element, index) => {
        $table += `<tr>
            <td>${index+1}</td>
            <td>${element.name} - ${element.identifier_barang}</td>
            <td>${element.rfid_tag}</td>
            <td>${element.lokasi}</td>
            <td>
                <a href="javascript:void(0)" onclick="showDetailTracking('${element.name} - ${element.identifier_barang}', '${element.rfid_tag}')" class="text-primary">
                    <i class="fas fa-eye"></i>
                </a>
            </td>
        </tr>`;
    });

    $('#table tbody').html($table);

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
// Detail
const showDetailTracking  = (name, rfid_tag) => {
     $.get(`${base_url}/api/tracking-barang/${rfid_tag}`, (res) => {
        $('#modalTracking tbody').empty();
        $('#modalTracking .modal-title').text(`Log History Barang ${name}`);
        $('#modalTracking .modal-title-sub').text(`${rfid_tag}`);
        
        renderTrackingDetail(res);
	});
}

const renderTrackingDetail = (res) => {
    let $table = "";
    res.forEach((element, index) => {
        $table += `<tr>
            <td width="190">${moment(element.created_at).lang("id").format('LL HH:mm:ss')}</td>
            <td width="190" class="${element.color}">
                <i class="${element.icon}"></i> ${element.type.charAt(0).toUpperCase() + element.type.slice(1)}
            </td>
            <td>${element.description}</td>
            </tr>`;
        });

    $('#modalTracking tbody').html($table);
    $('#modalTracking').modal('show');
}
