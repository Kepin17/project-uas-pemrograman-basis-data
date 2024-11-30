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
    
    <link rel="stylesheet" href="main.css">
</head>

<style>
  @layer base {
    @font-face {
      font-family: 'Roboto';
      font-weight: 400;
      src: url('https://fonts.gstatic.com/s/roboto/v30/KFOmCnqEu92Fr1Mu4mxM.woff2') format('woff2');
    }
    @font-face {
      font-family: 'Roboto';
      font-weight: 700;
      src: url('https://fonts.gstatic.com/s/roboto/v30/KFOlCnqEu92Fr1MmWUlfBBc4AMP6lbBP.woff2') format('woff2');
    }
  }

  @layer utilities {
    .font-roboto {
      font-family: 'Roboto', sans-serif;
    }
  }

  /* width */
::-webkit-scrollbar {
  width: 20px;
}

/* Track */
::-webkit-scrollbar-track {
  box-shadow: inset 0 0 5px grey; 
  border-radius: 10px;
}
 
/* Handle */
::-webkit-scrollbar-thumb {
  background: #159895; 
  border-radius: 10px;
}

/* Handle on hover */
::-webkit-scrollbar-thumb:hover {
  background: #57C5B6; 
}
</style>

<body>
    <!-- Navbar section-->
    <?php 

    if (!in_array(CURRENT_PAGE, NAV_IGNORE)) {
      include "src/components/fragments/navbar.php";
    }
    
    ?>
    <!-- Content section-->
    <div class="content-wrapper ">
        <?php echo $content; ?>
    </div>

    <!-- Footer section-->
    <?php include 'src/components/fragments/footer.php'; ?>
</body>
</html>
