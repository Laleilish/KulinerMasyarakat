// HAMBURGER MENU 
const hamburger = document.getElementById("hamburgerBtn");
const navLinks = document.getElementById("navLinks");
const closeBtn = document.getElementById("closeBtn");

hamburger.addEventListener("click", () => (navLinks.style.left = "0"));
closeBtn.addEventListener("click", () => (navLinks.style.left = "-100%"));

// PROFILE — DESKTOP DROPDOWN / MOBILE PANEL
const profileBtn = document.getElementById("profileBtn");
const profileDropdown = document.getElementById("profileDropdown");
const profilePanel = document.getElementById("profilePanel");
const profileOverlay = document.getElementById("profileOverlay");
const profilePanelClose = document.getElementById("profilePanelClose");

if (profileBtn) {
  const DESKTOP = () => window.innerWidth >= 768;

  // ---- DESKTOP: Dropdown ----
  function openDropdown() {
    profileDropdown.classList.remove("hidden");
  }
  function closeDropdown() {
    profileDropdown.classList.add("hidden");
  }

  // ---- MOBILE: Slide-in Panel ----
  function openPanel() {
    profilePanel.classList.remove("translate-x-full");
    profilePanel.classList.add("translate-x-0");
    profileOverlay.classList.remove("opacity-0", "pointer-events-none");
    profileOverlay.classList.add("opacity-100");
    document.body.style.overflow = "hidden";
  }
  function closePanel() {
    profilePanel.classList.remove("translate-x-0");
    profilePanel.classList.add("translate-x-full");
    profileOverlay.classList.remove("opacity-100");
    profileOverlay.classList.add("opacity-0", "pointer-events-none");
    document.body.style.overflow = "";
  }

  // ---- Toggle berdasarkan breakpoint ----
  profileBtn.addEventListener("click", (e) => {
    e.stopPropagation();
    if (DESKTOP()) {
      profileDropdown.classList.contains("hidden")
        ? openDropdown()
        : closeDropdown();
    } else {
      openPanel();
    }
  });

  // Tutup dropdown kalau klik di luar (desktop)
  document.addEventListener("click", (e) => {
    if (DESKTOP() && !profileBtn.closest(".relative").contains(e.target)) {
      closeDropdown();
    }
  });

  // Tombol close panel (mobile)
  if (profilePanelClose)
    profilePanelClose.addEventListener("click", closePanel);
  if (profileOverlay) profileOverlay.addEventListener("click", closePanel);

  // Escape key — tutup keduanya
  document.addEventListener("keydown", (e) => {
    if (e.key === "Escape") {
      closeDropdown();
      closePanel();
    }
  });

  // Resize: bersihkan state saat pindah breakpoint
  window.addEventListener("resize", () => {
    if (DESKTOP()) closePanel();
    else closeDropdown();
  });
}
