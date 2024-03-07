/**
 * 
 * Code for Index Page
 * 
 */

let tanggal = null;
const loadDataBarangKeluar = () => {
    tanggal = $('.tanggal').val() || '';
    $.get(`${base_url}/api/barang-keluar?tanggal=${tanggal}`).then((res) => {
        renderDataBarangKeluar(res);
    }).fail((e) => {
        showCallout("warning", e.responseJSON.message || 'Terjadi Kesalahan');
    });
}

const renderDataBarangKeluar = (res) => {
    if ($.fn.DataTable.isDataTable( '#table' ) ) {
        $("#table").DataTable().destroy();
        $("#table tbody").empty();
    }
	
    let $result = "";
    res.forEach((element, i) => {
        $result += `<tr>
            <td width="5">${++i}</td>
            <td width="90">${element.tanggal}</td>
            <td>${element.faktur}</td>
            <td width="40">${element.jumlah_item}</td>
            <td width="90" class="text-right">${parseFloat(element.total_harga).toLocaleString()}</td>
            <td>
                <a href="javascript:void(0)" onclick="showDetailBarangKeluar('${element.faktur}')" class="text-primary mr-2">
                    <i class="fas fa-eye"></i>
                </a>
                <a href="javascript:void(0);" onclick="deleteConfirm('Konfirmasi', 'Apakah anda yakin menghapus Faktur ${element.faktur}? Semua data yang bersangkutan akan dihapus.', 'Delete', deleteBarangMasuk, '${element.faktur}');" class="text-primary">
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
            { orderable: false },
        ],
        language: {
            url: "//cdn.datatables.net/plug-ins/1.11.5/i18n/id.json",
        },
        destroy:true,
        initComplete: () => {
            $('#table_filter').append(`<label class="ml-2">
                Tanggal: <input 
                type="date" 
                style="width:180px;" 
                class="form-control form-control-sm tanggal" 
                onchange="loadDataBarangKeluar()" 
                value="${tanggal}">
            </label>`);
        }
    });

}


const deleteBarangMasuk = (faktur) => {
    if(!faktur) return false;
    $.ajax({
        method: "DELETE",
        url: `${base_url}/api/barang-keluar/${faktur}`,
        success: (res) => {
            loadDataBarangKeluar();
            showAlert('#alert', 'success', res);
        },
        error: (e) => {
            showAlert('#alert', 'warning', e.responseJSON.message || 'Kesalahan pada server')
        },
    });
}

const getDetailBarangKeluar = (faktur) => {
    return $.get(`${base_url}/api/barang-keluar/${faktur}`);
}

const showDetailBarangKeluar = (faktur) => {
    getDetailBarangKeluar(faktur).then((res) => {
        renderDetailBarangKeluar(res, faktur);
    }).fail((e) => {
        showCallout("warning", e.responseJSON.message ?? 'Barang tidak ditemukan');
    });
}

const renderDetailBarangKeluar = (res, faktur) => {
    let $result = "";

    $("#data tbody").empty();
    $('#detail-barang').empty();

    res.forEach((element, i) => {
        $result += `<tr>
            <td width="5">${++i}</td>
            <td width="40">${element.barang}</td>
            <td width="40">${element.name}</td>
            <td width="40">${element.qty}</td>
            <td width="40" class="text-right">${parseFloat(element.harga_jual).toLocaleString()}</td>
            <td width="40" class="text-right">${parseFloat(element.subtotal).toLocaleString()}</td>
            <td width="30"><a href="javascript:void(0);" onclick="showDetailBarangKeluarItem('${element.id}', '${element.name}')"><i class="fas fa-list"></i></button></td>
        </tr>`
    });

    $("#data tbody").html($result);

    $('#modalDetailBarang .modal-title').text(`List Barang Keluar - ${faktur|| ''}`);
    $('#modalDetailBarang').modal('show');
}


const showDetailBarangKeluarItem = (id, nama) => {
    $.get(`${base_url}/api/barang-keluar-detail/${id}`).then((res) => {
        $template = '<div class="alert alert-secondary mt-3 mb-0" role="alert">';
        $template += '<ul class="mb-0">';            
        res.forEach(element => {
            $template += `<li>${nama} ${element.identifier_barang} (${element.rfid_tag||''})</li>`;            
        });
        $template += '</ul>';            
        $template += '</div>';
        $('#detail-barang').html($template);
    });
}


/**
 * 
 * Code for Form Page
 * 
 */
let timer = 0;
const barang = [];
const rfid_scanned = [];
const CHANNEL_IDENTIFIER = 'scan';
const EVENT = '1';

const pusher = new Pusher('b67c982cfe9b4de71605', {
    cluster: 'ap1'
});

const scan = () => {
    timer = setTimeout(stop, 60000);

    // Enable pusher logging - don't include this in production
    Pusher.logToConsole = true;

    var channel = pusher.subscribe(CHANNEL_IDENTIFIER);
    channel.bind(EVENT, function(data) {
        clearTimeout(timer);
        timer = setTimeout(stop, 60000);
        addBarangToTemp(data);
    });

    $('.scan').css('display','none');
    $('.stop').css('display','');
}

const stop = () => {
    clearTimeout(timer);

    pusher.unsubscribe(CHANNEL_IDENTIFIER);

    $('.scan').css('display','');
    $('.stop').css('display','none');
}

const inputManualTag = () => {
    let input_rfid_tag = $('#rfid_tag').val();

    addBarangToTemp(input_rfid_tag).then(() => {
        $('#rfid_tag').val('');
    });

}

const addBarangToTemp = (rfid_tag) => {
    return new Promise((resolve, reject) => {
        $.get(`${base_url}/api/rfid/${rfid_tag}`).then((res) => {
            if(Object.keys(res).length){
                if(rfid_scanned.indexOf(String(rfid_tag)) != -1) {
                    resolve(res);
                    return;
                };
                rfid_scanned.push(String(rfid_tag));
                barang.push(res);
                showTempBarangKeluar();
                showCallout("success", 'Barang berhasil ditambahkan');
                resolve(res);
                return;
            }
            showCallout("warning", 'Barang tidak ditemukan');
            resolve(res);
        }).fail((e) => {
            showCallout("warning", 'Barang tidak ditemukan');
            reject(e);
        })
    })
}

const manageBarang = () => {
    let result = [];
    barang.forEach(  
        r => { 
            if( !result[r.barang] ){  
                result[r.barang] = r; 
                result[r.barang].qty = 0;
                result[r.barang].rfid = [];
            }

            result[r.barang].rfid.push(r.rfid_tag);
            result[r.barang].qty++; 
            result[r.barang].subtotal = result[r.barang].qty * result[r.barang].harga_jual;
        }   
    ); 

    return result;
}

const removeTempBarangKeluar = (index) => {
    if(typeof barang[index] != "undefined" && rfid_scanned[index] != "undefined"){
        barang.splice(index, 1);
        rfid_scanned.splice(index, 1);
        showTempBarangKeluar();
    }
}

const showTempBarangKeluar = () => {
    let $log = $inbound = "";
    let allowSubmit = true;
    barang.forEach((element, index) => {
        statusStok = (element.barang_masuk_detail == null || element.barang_keluar_detail != null);
        $log += `<tr>
            <td scope="col">${index+1}</td>
            <td scope="col">${element.name} ${element.identifier_barang}</td>
            <td scope="col">${element.rfid_tag}</td>
            <td scope="col" class="justify-content-between d-flex ${statusStok? "text-danger" : "text-success"}">
                ${statusStok ? "Tidak" : "Ya" }
                <a href="javascript:void(0);" onclick="removeTempBarangKeluar(${index})" class="text-red">
                    <i class="fas fa-trash-alt"></i>
                </a>
            </td>
        </tr>`;

        if(statusStok){
            // allowSubmit = false;
        }
    });

    if(!allowSubmit){
        $("#submit").prop('disabled', true).addClass('btn-secondary').removeClass('btn-primary');
    }else{
        $("#submit").prop('disabled', false).removeClass('btn-secondary').addClass('btn-primary');
    }
    
    $('#log').html($log);

    let result = manageBarang();

    Object.keys(result).forEach((ele, i) => {
        $inbound += `<tr>
        <td scope="col">${++i}</td>
        <td scope="col">${result[ele].barang}</td>
        <td scope="col">${result[ele].name}</td>
        <td scope="col">${parseFloat(result[ele].harga_jual).toLocaleString()}</td>
        <td scope="col">${result[ele].qty}</td>
        <td scope="col">${parseFloat(result[ele].subtotal).toLocaleString()}</td>
        </tr>`;
    });

    $('#data').html($inbound);
}

const simpanBarangKeStok = async (ev) => {
    $(ev).prop('disabled', true).addClass('btn-secondary').removeClass('btn-primary');
    let faktur = $('#faktur').val();
    let tanggal = $('#tanggal').val();
    let temps = manageBarang();

    if(!faktur || !tanggal){
        showCallout("warning", "Faktur dan Tanggal barang Masuk tidak boleh kosong");
        $(ev).prop('disabled', false).addClass('btn-primary').removeClass('btn-secondary');
        return ;
    }

    if(!Object.keys(temps).length){
        showCallout("warning", "Barang tidak boleh kosong");
        $(ev).prop('disabled', false).addClass('btn-primary').removeClass('btn-secondary');
        return;
    }

    let barangKeluar = await getDetailBarangKeluar(faktur);
    if(barangKeluar.length){
        showCallout("warning", "Faktur sudah digunakan");
        $(ev).prop('disabled', false).addClass('btn-primary').removeClass('btn-secondary');
        return;
    }

    let barang_keluar = [];
    Object.keys(temps).forEach(i => barang_keluar.push(temps[i]));
    $.post(`${base_url}/api/barang-keluar`, {faktur, tanggal, barang_keluar}).then((res) => {
        showCallout("success", res);
    }).fail((e) => {
        showCallout("warning", e.responseJSON.message || 'Terjadi Kesalahan');
    }).always(() => {
        $(ev).prop('disabled', false).addClass('btn-primary').removeClass('btn-secondary');
        resetFormBarangTemp();
    });
}

const resetFormBarangTemp = () => {
    stop();
    $('#faktur').val('');
    document.getElementById('tanggal').valueAsDate = new Date();
    $('#log').html('');
    $('#data').html('');
    barang.length = 0;
    rfid_scanned.length = 0;
}