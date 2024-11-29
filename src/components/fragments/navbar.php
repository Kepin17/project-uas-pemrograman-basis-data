<?php 
  require_once 'config/config.php';
  $currentPage = str_replace(BASE_URL , "", "$_SERVER[REQUEST_URI]");
?>

<nav class="navbar bg-[#1A5F7A] w-full h-20 h-20 flex items-center justify-between p-8 overflow-hidden">
        <div class="navbar-brand flex items-center">
          <a class="navbar-item text-2xl font-bold flex items-center gap-3 text-[#002B5B]" href="<?= BASE_URL?>">
          <i class="fa-solid fa-book text-[#57C5B6]"></i>
            <h1 class="font-roboto">OneBooks</h1>
          </a>
        </div>

        

        <div class="items-wrapper flex items-center gap-8">
          <ul class="navbar-menu flex items-center gap-7 text-[#002B5B] font-bold font-roboto">
            <li><a href="<?= BASE_URL?>" class="<?php echo $currentPage === "/" ? 'text-[#57C5B6]' : ''; ?>">Home</a></li>
            <li><a href="index.php" class="<?php echo $currentPage === 'About.php' ? 'text-[#57C5B6]' : ''; ?>">About</a></li>
            <li><a href="index.php" class="<?php echo $currentPage === 'Literacy.php' ? 'text-[#57C5B6]' : ''; ?>">literacy Zone</a></li>
            <li><a href="index.php" class="<?php echo $currentPage === 'Contact.php' ? 'text-[#57C5B6]' : ''; ?>">Contact</a></li>
          </ul>

          <div class="cta-wrapper flex items-center gap-8 font-roboto">
            <a href="" class="cta-btn h-8 px-5 text-[#002B5B] bg-[#80EE98] flex justify-center items-center font-bold rounded-md gap-2">
              <i class="fa-solid fa-right-to-bracket"></i>  
              <button>
              Login</button>
            </a>
            <a href="" class="cta-btn px-5 h-8 text-[#002B5B] bg-[#80EE98] flex justify-center items-center font-bold rounded-md gap-2">
              <i class="fa-solid fa-right-to-bracket"></i>  
              <button>Register</button>
            </a>
          </div>
        </div>
    </nav>