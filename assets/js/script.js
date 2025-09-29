document.addEventListener("DOMContentLoaded", () => {

  function closeAllDropdowns() {
    document.querySelectorAll(".dropdown.show").forEach(dd => dd.classList.remove("show"));
  }

  // Tạo listener global để đóng dropdown khi click ngoài (cùng như trước)
  window.addEventListener("click", (e) => {
    // nếu click vào phần tử bên trong 1 dropdown thì giữ nguyên, ngược lại đóng hết
    const anyDropdownContains = Array.from(document.querySelectorAll(".dropdown"))
      .some(el => el.contains(e.target));
    if (!anyDropdownContains) closeAllDropdowns();
  });

  // Truy vấn tất cả dropbtn
  const allDropBtns = document.querySelectorAll(".dropbtn");

  // Tìm modal auth (nếu có)
  const authModal = document.getElementById("authModal");
  const authBox = authModal ? authModal.querySelector(".auth-box") : null;
  const closeBtn = authModal ? authModal.querySelector(".auth-box .close") : null;
  const loginTab = document.getElementById("loginTab");
  const registerTab = document.getElementById("registerTab");
  const loginForm = document.getElementById("loginForm");
  const registerForm = document.getElementById("registerForm");

  // For accessibility: focus first input when modal opens
  function focusFirstInputInModal() {
    if (!authBox) return;
    const input = authBox.querySelector('input, textarea, button, select');
    if (input) input.focus();
  }

  // Function to open modal (and close dropdowns)
  function openAuthModal() {
    if (!authModal) return;
    closeAllDropdowns();
    authModal.style.display = "flex";
    document.body.style.overflow = "hidden"; // disable page scroll
    // default to login tab if present
    if (loginTab && loginForm && registerTab && registerForm) {
      loginTab.classList.add("active");
      registerTab.classList.remove("active");
      loginForm.classList.remove("hidden");
      registerForm.classList.add("hidden");
    }
    // small timeout to focus inside modal
    setTimeout(focusFirstInputInModal, 80);
  }

  // Function to close modal
  function closeAuthModal() {
    if (!authModal) return;
    authModal.style.display = "none";
    document.body.style.overflow = "";
  }

  // Attach behavior for each .dropbtn
  allDropBtns.forEach(btn => {
    const text = (btn.textContent || "").trim().toLowerCase();
    const isAuthByClass = btn.classList.contains("open-auth");
    const isAuthByAttr = btn.dataset && btn.dataset.auth === "true";
    const isAuthByText = text.includes("tài khoản") || text.includes("tài-khoản") || text.includes("tài khoản"); // multiple variants

    const isAuthBtn = isAuthByClass || isAuthByAttr || isAuthByText;

    if (isAuthBtn) {

      btn.addEventListener("click", function (ev) {
        ev.preventDefault();
        ev.stopPropagation();
        openAuthModal();
      });
    } else {
      // treat as a normal dropdown toggler if it's inside .dropdown
      const dropdown = btn.closest(".dropdown");
      if (!dropdown) return; // nothing to do

      btn.addEventListener("click", function (ev) {
        ev.stopPropagation();
        // toggle only this dropdown
        dropdown.classList.toggle("show");
        // close other dropdowns
        document.querySelectorAll(".dropdown.show").forEach(dd => {
          if (dd !== dropdown) dd.classList.remove("show");
        });
      });
    }
  });

  /* ================= NÚT LIÊN HỆ NỔI (giữ nguyên) ================= */
  const contactToggle = document.getElementById("contactToggle");
  const contactBox = document.getElementById("contactBox");
  const contactFloat = document.querySelector(".contact-float");
  const closeContact = document.getElementById("closeContact");

  if (contactToggle && contactBox && contactFloat) {
    contactToggle.addEventListener("click", (e) => {
      e.stopPropagation();
      contactBox.style.display = contactBox.style.display === "block" ? "none" : "block";
    });

    // Click ra ngoài thì đóng contactBox
    window.addEventListener("click", (e) => {
      if (contactBox.style.display === "block" && !contactFloat.contains(e.target)) {
        contactBox.style.display = "none";
      }
    });

    // Nút đóng (✖)
    if (closeContact) {
      closeContact.addEventListener("click", () => {
        contactBox.style.display = "none";
      });
    }

    // Hiệu ứng rung chuông khi mouseleave
    contactToggle.addEventListener("mouseleave", () => {
      contactToggle.classList.add("ring");
      contactToggle.addEventListener("animationend", () => contactToggle.classList.remove("ring"), { once: true });
    });
  }

  /* ================= MODAL LOGIN/REGISTER (hoạt động an toàn) ================ */
  if (authModal) {
    // Close button (X)
    if (closeBtn) {
      closeBtn.addEventListener("click", (e) => {
        e.stopPropagation();
        closeAuthModal();
      });
    }

    // Click ngoài authBox (trên overlay) đóng modal
    authModal.addEventListener("click", function (e) {
      if (e.target === authModal) {
        closeAuthModal();
      }
    });

    // ESC để đóng modal
    window.addEventListener("keydown", function (e) {
      if (e.key === "Escape" && authModal.style.display === "flex") {
        closeAuthModal();
      }
    });

    // Tabs login/register (giữ logic cũ)
    if (loginTab && registerTab && loginForm && registerForm) {
      loginTab.addEventListener("click", () => {
        loginTab.classList.add("active");
        registerTab.classList.remove("active");
        loginForm.classList.remove("hidden");
        registerForm.classList.add("hidden");
      });

      registerTab.addEventListener("click", () => {
        registerTab.classList.add("active");
        loginTab.classList.remove("active");
        registerForm.classList.remove("hidden");
        loginForm.classList.add("hidden");
      });
    }
  }

  /* ================= OTHER (unchanged) ================= */
  // Confirm add-to-cart
  document.querySelectorAll(".add-to-cart").forEach(btn => {
    btn.addEventListener("click", function(e) {
      const ok = confirm("🛒 Bạn có chắc muốn thêm sản phẩm này vào giỏ?");
      if (!ok) e.preventDefault();
    });
  });

  // Hover effect for .btn (keep as before)
  document.querySelectorAll(".btn").forEach(btn => {
    btn.addEventListener("mouseenter", () => btn.style.opacity = "0.85");
    btn.addEventListener("mouseleave", () => btn.style.opacity = "1");
  });

  /* ================= TITLE ADJUST (unchanged) ================= */
  function adjustProductTitles() {
    document.querySelectorAll('.card-body .product-title').forEach(h => {
      h.style.fontSize = '';
      const computed = window.getComputedStyle(h);
      const lineHeight = parseFloat(computed.lineHeight) || (parseFloat(computed.fontSize) * 1.2);
      const allowed = lineHeight * 2;
      if (h.scrollHeight <= allowed) return;
      let fs = parseFloat(computed.fontSize);
      while (h.scrollHeight > allowed && fs > 12) {
        fs = fs - 0.5;
        h.style.fontSize = fs + 'px';
      }
    });
  }

  adjustProductTitles();
  window.addEventListener('resize', () => {
    clearTimeout(window.__adjustTitleTimer);
    window.__adjustTitleTimer = setTimeout(adjustProductTitles, 120);
  });

  /* ================= SLIDESHOW BANNER (banner.jpg / banner2.jpg) ================= */
  // logic slideshow: auto rotate every 5s, plusSlides exposed globally for HTML onclick
  (function () {
    let slideIndex = 0;
    let slides = [];
    let autoTimer = null;
    const AUTO_INTERVAL = 5000; // 5s

    function collectSlides() {
      slides = Array.from(document.querySelectorAll('.slideshow-container .mySlides'));
    }

    function showSlide(n) {
      if (!slides || slides.length === 0) return;
      // normalize index
      slideIndex = ((n % slides.length) + slides.length) % slides.length;
      slides.forEach((s, idx) => s.style.display = (idx === slideIndex ? 'block' : 'none'));
    }

    window.plusSlides = function (n) {
      collectSlides();
      if (!slides || slides.length === 0) return;
      // find current if not set
      let current = slideIndex;
      showSlide(current + n);
      resetAutoTimer();
    };

    function nextSlide() {
      showSlide(slideIndex + 1);
    }

    function startAuto() {
      stopAuto();
      autoTimer = setInterval(nextSlide, AUTO_INTERVAL);
    }

    function stopAuto() {
      if (autoTimer) { clearInterval(autoTimer); autoTimer = null; }
    }

    function resetAutoTimer() {
      stopAuto();
      // restart after short delay so user can see chosen slide
      setTimeout(startAuto, 3000);
    }

    // init when DOM ready
    collectSlides();
    if (slides && slides.length > 0) {
      // show first slide and start auto
      showSlide(0);
      startAuto();
      // pause on hover over slideshow container
      const container = document.querySelector('.slideshow-container');
      if (container) {
        container.addEventListener('mouseenter', stopAuto);
        container.addEventListener('mouseleave', startAuto);
      }
    }
  })();

});
