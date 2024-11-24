<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $title ?? 'My PHP Project'; ?></title>
    <!-- Link CDN Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>

    <!-- link CDN Fontawsome -->
     
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.1/css/all.min.css" integrity="sha512-5Hs3dF2AEPkpNAR7UiOHba+lRSJNeM2ECkwxUIxC1Q/FLycGTbNapWXB4tP889k5T5Ju8fs4b1P5z/iB4nMfSQ==" crossorigin="anonymous" referrerpolicy="no-referrer" />

</head>
<body>
    <!-- Navbar section-->
    <?php include 'components/fragments/navbar.php'; ?>

    <!-- Content section-->
    <div class="container mx-auto mt-5">
        <?php echo $content; ?>
    </div>
</body>
</html>
