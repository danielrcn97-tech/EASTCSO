/* =========================================================
   EASTCSO STUDENT PORTAL — MAIN SCRIPT
   ========================================================= */

document.addEventListener('DOMContentLoaded', function () {

  /* ---------- MOBILE MENU TOGGLE ---------- */
  const hamburger = document.querySelector('.hamburger');
  const navMobile = document.querySelector('.nav-mobile');
  if (hamburger && navMobile) {
    hamburger.addEventListener('click', function () {
      navMobile.classList.toggle('open');
    });
    // close menu when a link inside it is tapped
    navMobile.querySelectorAll('a').forEach(function (link) {
      link.addEventListener('click', function () {
        navMobile.classList.remove('open');
      });
    });
  }

  /* ---------- HERO CAROUSEL (home page) ---------- */
  const slides = document.querySelectorAll('.hero-slide');
  const dots = document.querySelectorAll('.hero-dots span');
  let current = 0;

  function showSlide(index) {
    slides.forEach(function (s) { s.classList.remove('active'); });
    dots.forEach(function (d) { d.classList.remove('active'); });
    slides[index].classList.add('active');
    if (dots[index]) dots[index].classList.add('active');
    current = index;
  }

  if (slides.length > 0) {
    showSlide(0);
    setInterval(function () {
      showSlide((current + 1) % slides.length);
    }, 4500);

    dots.forEach(function (dot, i) {
      dot.addEventListener('click', function () { showSlide(i); });
    });
  }

  /* ---------- LOAD ANNOUNCEMENTS (home / announcements section) ---------- */
  const annContainer = document.getElementById('announcements-list');
  if (annContainer) {
    fetch('php/get_announcements.php')
      .then(function (res) { return res.json(); })
      .then(function (data) {
        if (!data.length) {
          annContainer.innerHTML = '<p style="color:var(--grey)">Hakuna matangazo kwa sasa.</p>';
          return;
        }
        annContainer.innerHTML = data.map(function (a) {
          return '<div class="card" style="margin-bottom:18px;">' +
                   '<h3>' + a.title + '</h3>' +
                   '<p>' + a.body + '</p>' +
                   '<p style="margin-top:8px;font-size:12px;color:#9aa6ba;">' + a.created_at + '</p>' +
                 '</div>';
        }).join('');
      })
      .catch(function () {
        annContainer.innerHTML = '<p style="color:var(--grey)">Imeshindikana kupakia matangazo. (Hakikisha PHP/MySQL inafanya kazi)</p>';
      });
  }

  /* ---------- LOGIN FORM (AJAX to php/login.php) ---------- */
  const loginForm = document.getElementById('login-form');
  if (loginForm) {
    loginForm.addEventListener('submit', function (e) {
      e.preventDefault();
      const msg = document.getElementById('login-msg');
      const formData = new FormData(loginForm);

      fetch('php/login.php', { method: 'POST', body: formData })
        .then(function (res) { return res.json(); })
        .then(function (data) {
          msg.className = 'form-msg ' + (data.success ? 'success' : 'error');
          msg.textContent = data.message;
          if (data.success) {
            setTimeout(function () { window.location.href = 'dashboard.php'; }, 900);
          }
        })
        .catch(function () {
          msg.className = 'form-msg error';
          msg.textContent = 'Hitilafu ya muunganisho. Jaribu tena.';
        });
    });
  }

  /* ---------- CONTACT FORM (AJAX to php/contact_handler.php) ---------- */
  const contactForm = document.getElementById('contact-form');
  if (contactForm) {
    contactForm.addEventListener('submit', function (e) {
      e.preventDefault();
      const msg = document.getElementById('contact-msg');
      const formData = new FormData(contactForm);

      fetch('php/contact_handler.php', { method: 'POST', body: formData })
        .then(function (res) { return res.json(); })
        .then(function (data) {
          msg.className = 'form-msg ' + (data.success ? 'success' : 'error');
          msg.textContent = data.message;
          if (data.success) contactForm.reset();
        })
        .catch(function () {
          msg.className = 'form-msg error';
          msg.textContent = 'Hitilafu ya muunganisho. Jaribu tena.';
        });
    });
  }

});
