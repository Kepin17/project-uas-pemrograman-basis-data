<?php
require_once(__DIR__ . '/../../config/connection.php');

if (isset($_POST['books'])) {
    $books = json_decode($_POST['books'], true);
    $output = '';
    
    if (empty($books)) {
        echo '<div class="text-center p-3">
                <i class="fas fa-shopping-cart text-muted mb-2 fa-2x"></i>
                <p class="text-muted mb-0">Keranjang kosong</p>
              </div>';
        exit;
    }

    foreach ($books as $id => $data) {
        // Get book details from database
        $query = "SELECT nama_buku, stok FROM buku WHERE id_buku = ?";
        $stmt = mysqli_prepare($conn, $query);
        mysqli_stmt_bind_param($stmt, "i", $id);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        $book = mysqli_fetch_assoc($result);
        
        $remainingStock = $book['stok'] - $data['qty'];
        $stockClass = $remainingStock <= 5 ? 'text-warning' : 'text-success';

        $output .= '
        <div class="list-group-item book-item" data-id="'.$id.'">
            <div class="d-flex justify-content-between align-items-start">
                <div class="flex-grow-1">
                    <div class="d-flex justify-content-between">
                        <h6 class="mb-1">'.$book['nama_buku'].'</h6>
                        <span class="badge bg-primary ms-2">1 buku</span>
                    </div>
                    <div class="text-muted small">
                        <span class="'.$stockClass.'">Sisa stok: '.$remainingStock.'</span>
                    </div>
                </div>
                <div class="ms-3">
                    <button type="button" class="btn btn-danger btn-sm remove-book" 
                            data-id="'.$id.'" title="Hapus dari keranjang">
                        <i class="fas fa-trash"></i>
                    </button>
                </div>
            </div>
            <input type="hidden" name="books['.$id.']" value="1">
        </div>';
    }

    // Add summary if there are books
    $total_books = count($books);
    $output .= '
    <div class="list-group-item bg-light">
        <div class="d-flex justify-content-between align-items-center">
            <div class="text-muted">Total Buku</div>
            <strong>'.$total_books.' / 3</strong>
        </div>
    </div>';

    echo $output;
}
