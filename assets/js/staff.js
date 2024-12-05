document.addEventListener('DOMContentLoaded', function() {
    loadStaffData();

    // Handle Add Staff Form Submit
    document.getElementById('addStaffForm').addEventListener('submit', function(e) {
        e.preventDefault();
        const formData = new FormData(this);
        formData.append('action', 'create');

        fetch('staff_process.php', {
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                alert('Staff berhasil ditambahkan!');
                this.reset();
                $('#addStaffModal').modal('hide');
                loadStaffData();
            }
        })
        .catch(error => console.error('Error:', error));
    });

    // Handle Edit Staff Form Submit
    document.getElementById('editStaffForm').addEventListener('submit', function(e) {
        e.preventDefault();
        const formData = new FormData(this);
        formData.append('action', 'update');

        fetch('staff_process.php', {
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                alert('Staff berhasil diperbarui!');
                $('#editStaffModal').modal('hide');
                loadStaffData();
            }
        })
        .catch(error => console.error('Error:', error));
    });
});

function loadStaffData() {
    fetch('staff_process.php', {
        method: 'POST',
        body: new URLSearchParams({
            'action': 'read'
        })
    })
    .then(response => response.json())
    .then(data => {
        const tbody = document.querySelector('table tbody');
        tbody.innerHTML = '';
        
        data.data.forEach((staff, index) => {
            tbody.innerHTML += `
                <tr>
                    <td>${index + 1}</td>
                    <td>${staff.nama}</td>
                    <td>${staff.username}</td>
                    <td>${staff.email}</td>
                    <td>${staff.telepon}</td>
                    <td>${staff.alamat}</td>
                    <td>
                        <button class="btn btn-sm btn-warning" onclick="editStaff(${staff.id})">
                            <i class="fas fa-edit"></i>
                        </button>
                        <button class="btn btn-sm btn-danger" onclick="deleteStaff(${staff.id})">
                            <i class="fas fa-trash"></i>
                        </button>
                    </td>
                </tr>
            `;
        });
    })
    .catch(error => console.error('Error:', error));
}

function editStaff(id) {
    // Fetch staff data and populate the edit form
    fetch('staff_process.php', {
        method: 'POST',
        body: new URLSearchParams({
            'action': 'read',
            'id': id
        })
    })
    .then(response => response.json())
    .then(data => {
        const staff = data.data.find(s => s.id === id);
        if (staff) {
            document.getElementById('edit_id').value = staff.id;
            document.getElementById('edit_nama').value = staff.nama;
            document.getElementById('edit_username').value = staff.username;
            document.getElementById('edit_email').value = staff.email;
            document.getElementById('edit_telepon').value = staff.telepon;
            document.getElementById('edit_alamat').value = staff.alamat;
            $('#editStaffModal').modal('show');
        }
    })
    .catch(error => console.error('Error:', error));
}

function deleteStaff(id) {
    if (confirm('Apakah Anda yakin ingin menghapus staff ini?')) {
        fetch('staff_process.php', {
            method: 'POST',
            body: new URLSearchParams({
                'action': 'delete',
                'id': id
            })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                alert('Staff berhasil dihapus!');
                loadStaffData();
            }
        })
        .catch(error => console.error('Error:', error));
    }
}
