<?php 
  require_once 'config/config.php';

  // Function to check if the current page matches the menu item
  function isActive($page) {
    return CURRENT_PAGE === $page ? 'opacity-100' : 'opacity-70';
  }

?>
<nav class="navbar bg-[#1A5F7A] w-full h-20 h-20 flex items-center justify-between p-8 overflow-hidden">
        <div class="navbar-brand flex items-center">
          <a class="navbar-item text-2xl font-bold flex items-center gap-3 text-[#FFF4B7]" href="<?= BASE_URL?>">
          <i class="fa-solid fa-book text-[#57C5B6]"></i>
            <h1 class="font-roboto">OneBooks</h1>
          </a>
        </div>

        <div class="items-wrapper flex items-center gap-8">
          <ul class="navbar-menu flex items-center gap-7 text-[#FFF4B7]  font-bold font-roboto">
            <li><a href="<?= BASE_URL?>" class="<?= isActive('index') ?>">Home</a></li>
            <li><a href="<?= BASE_URL?>/about.php" class="<?= isActive('about') ?>">About</a></li>
            <li><a href="<?= BASE_URL?>/literacy.php" class="<?= isActive('literacy') ?>">literacy Zone</a></li>
            <li><a href="<?= BASE_URL?>/contact.php" class="<?= isActive('contact') ?>">Contact</a></li>
          </ul>

          <div class="cta-wrapper flex items-center gap-8 font-roboto">
            <a href="<?= BASE_URL?>/login" class="cta-btn h-8 px-5 text-[#002B5B] bg-[#80EE98] flex justify-center items-center font-bold rounded-md gap-2">
              <i class="fa-solid fa-right-to-bracket"></i>  
              <button>Login</button>
            </a>
            <a href="<?= BASE_URL?>/register" class="cta-btn px-5 h-8 text-[#002B5B] bg-[#80EE98] flex justify-center items-center font-bold rounded-md gap-2">
              <i class="fa-solid fa-right-to-bracket"></i>  
              <button>Register</button>
            </a>
          </div>
        </div>
    </nav>