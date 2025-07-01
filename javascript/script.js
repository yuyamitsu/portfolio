'use strict';

  const navToggle = document.querySelector('.navToggle');
  const navWrapper = document.querySelector('.navWrapper');
  const navLinks = document.querySelectorAll('.navList a');

  navToggle.addEventListener('click', () => {
    navToggle.classList.toggle('active');
    navWrapper.classList.toggle('active');
  });

  // メニューリンクをクリックしたら閉じる
  navLinks.forEach(link => {
    link.addEventListener('click', () => {
      navToggle.classList.remove('active');
      navWrapper.classList.remove('active');
    });
  });

