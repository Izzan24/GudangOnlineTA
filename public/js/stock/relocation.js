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

const addTrackingTemp = () => {
    if($('#barang').val()){
        addBarangToTemp($('#barang').val());
    }
}

const addBarangToTemp = (rfid_tag) => {
    $.get(`${base_url}/api/rfid/${rfid_tag}`).then((res) => {
        if(Object.keys(res)){
            if(rfid_scanned.indexOf(String(rfid_tag)) != -1)  return
            if(res.barang_masuk_detail == null || res.barang_keluar_detail != null) {
                return showCallout("warning", 'Barang bukan merupakan stok');
            }

            rfid_scanned.push(String(rfid_tag));
            barang.push(res);
            showTempRelocation();
        }
    }).fail((e) => {
        showCallout("warning", 'Barang tidak ditemukan');
    })
}

const removeTempRelocation = (index) => {
    if(typeof barang[index] != "undefined" && rfid_scanned[index] != "undefined"){
        barang.splice(index, 1);
        rfid_scanned.splice(index, 1);
        showTempRelocation();
        if(!barang.length){
            resetFormBarangTemp()
        }
    }
}

const showTempRelocation = () => {
    let $template = "";
    barang.forEach((element, index) => {
        $delete = `<a href="javascript:void(0);" onclick="removeTempRelocation(${index})" class="text-red">
                    <i class="fas fa-trash-alt"></i>
                </a>`;

        $template += `<tr>
            <td scope="col">${index+1}</td>
            <td scope="col">${element.name} - ${element.identifier_barang} (${element.rfid_tag})</td>
            <td scope="col" width="5#%" class="text-center">${$delete}</td>
        </tr>`;

    });

    $('#data').html($template);
    $('#data').parent().css('display','');

}

const simpanBarangKeTracking = async (ev) => {
    $(ev).prop('disabled', true).addClass('btn-secondary').removeClass('btn-primary');
    let lokasi = $('#lokasi').val();

    if(!lokasi){
        showCallout("warning", "Lokasi tidak boleh kosong");
        $(ev).prop('disabled', false).addClass('btn-primary').removeClass('btn-secondary');
        return ;
    }

    if(!barang.length){
        showCallout("warning", "Barang tidak boleh kosong");
        $(ev).prop('disabled', false).addClass('btn-primary').removeClass('btn-secondary');
        return;
    }

    $.post(`${base_url}/api/relocation`, {lokasi, rfid_scanned}).then((res) => {
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
    $('#lokasi').val('');
    $('#data').html('');
    $('#data').parent().css('display','none');
    barang.length = 0;
    rfid_scanned.length = 0;
}

// Select 
const loadBarangSelect = () => {
    $.get(`${base_url}/api/relocation`, (res) => {
        $select = '<option value="">Pilih Barang</option>';
        res.forEach(element => {
            $select += `<option value="${element.rfid_tag}">${element.name} - ${element.identifier_barang}</option>`
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
