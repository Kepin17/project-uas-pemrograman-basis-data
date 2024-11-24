<?php
$title = 'Homepage';
ob_start();
?>
<h1 class="text-3xl font-bold text-center">Welcome to the Homepage</h1>
<p class="text-center">This is the homepage content.</p>
<?php
$content = ob_get_clean();
include 'components/layouts/mainLayout.php';
?>
