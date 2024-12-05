document.addEventListener('DOMContentLoaded', function() {
    loadActivePeminjaman();
    loadRiwayatPengembalian();

    // Event listener untuk perubahan peminjaman
    document.getElementById('peminjaman_id').addEventListener('change', function() {
        if (this.value) {
            loadDetailPeminjaman(this.value);
        } else {
            resetDetailPeminjaman();
        }
    });

    // Event listener untuk perubahan kondisi buku
    document.getElementById('kondisi_buku').addEventListener('change', function() {
        updateDenda();
    });

    // Handle form submission
    document.getElementById('returnForm').addEventListener('submit', function(e) {
        e.preventDefault();
        processPengembalian();
    });
});

function loadActivePeminjaman() {
    fetch(BASE_URL + '/pages/Pengembalian/pengembalian_process.php?action=get_active_loans')
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                const select = document.getElementById('peminjaman_id');
                select.innerHTML = '<option value="">Pilih Peminjam</option>';
                
                data.data.forEach(loan => {
                    select.innerHTML += `
                        <option value="${loan.id}">
                            ${loan.nama_peminjam} - ${loan.judul_buku}
                        </option>
                    `;
                });
            }
        })
        .catch(error => console.error('Error:', error));
}

function loadDetailPeminjaman(id) {
    fetch(`${BASE_URL}/pages/Pengembalian/pengembalian_process.php?action=get_loan_detail&id=${id}`)
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                const loan = data.data;
                document.getElementById('detail_nama').textContent = loan.nama_peminjam;
                document.getElementById('detail_buku').textContent = loan.judul_buku;
                document.getElementById('detail_tgl_pinjam').textContent = formatDate(loan.tanggal_pinjam);
                document.getElementById('detail_batas_kembali').textContent = formatDate(loan.tanggal_kembali);
                document.getElementById('detail_terlambat').textContent = 
                    `${loan.days_late} hari (Denda: Rp ${formatNumber(loan.late_fee)})`;
                
                updateDenda(loan.late_fee);
            }
        })
        .catch(error => console.error('Error:', error));
}

function updateDenda(lateFee = 0) {
    const kondisi = document.getElementById('kondisi_buku').value;
    let dendaKondisi = 0;
    
    switch (kondisi) {
        case 'rusak':
            dendaKondisi = 100000;
            break;
        case 'hilang':
            dendaKondisi = 500000;
            break;
    }
    
    document.getElementById('denda_terlambat').textContent = `Rp ${formatNumber(lateFee)}`;
    document.getElementById('denda_kondisi').textContent = `Rp ${formatNumber(dendaKondisi)}`;
    document.getElementById('total_denda').textContent = `Rp ${formatNumber(lateFee + dendaKondisi)}`;
}

function processPengembalian() {
    const formData = new FormData();
    formData.append('action', 'process_return');
    formData.append('peminjaman_id', document.getElementById('peminjaman_id').value);
    formData.append('kondisi_buku', document.getElementById('kondisi_buku').value);

    fetch(BASE_URL + '/pages/Pengembalian/pengembalian_process.php', {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            alert('Pengembalian berhasil diproses!');
            resetForm();
            loadActivePeminjaman();
            loadRiwayatPengembalian();
        } else {
            alert('Error: ' + data.message);
        }
    })
    .catch(error => console.error('Error:', error));
}

function loadRiwayatPengembalian() {
    fetch(BASE_URL + '/pages/Pengembalian/pengembalian_process.php?action=get_history')
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                const tbody = document.getElementById('riwayatPengembalian');
                tbody.innerHTML = '';
                
                data.data.forEach(item => {
                    tbody.innerHTML += `
                        <tr>
                            <td>${formatDate(item.tanggal_pengembalian)}</td>
                            <td>${item.nama_peminjam}</td>
                            <td>${item.judul_buku}</td>
                            <td>${formatKondisi(item.kondisi_saat_kembali)}</td>
                            <td>Rp ${formatNumber(item.total_denda)}</td>
                        </tr>
                    `;
                });
            }
        })
        .catch(error => console.error('Error:', error));
}

function resetDetailPeminjaman() {
    document.getElementById('detail_nama').textContent = '-';
    document.getElementById('detail_buku').textContent = '-';
    document.getElementById('detail_tgl_pinjam').textContent = '-';
    document.getElementById('detail_batas_kembali').textContent = '-';
    document.getElementById('detail_terlambat').textContent = '-';
    updateDenda();
}

function resetForm() {
    document.getElementById('returnForm').reset();
    resetDetailPeminjaman();
}

function formatDate(dateString) {
    const options = { 
        year: 'numeric', 
        month: 'long', 
        day: 'numeric',
        hour: '2-digit',
        minute: '2-digit'
    };
    return new Date(dateString).toLocaleDateString('id-ID', options);
}

function formatNumber(number) {
    return new Intl.NumberFormat('id-ID').format(number);
}

function formatKondisi(kondisi) {
    const kondisiMap = {
        'bagus': 'Bagus',
        'rusak': 'Rusak',
        'hilang': 'Hilang'
    };
    return kondisiMap[kondisi] || kondisi;
}
