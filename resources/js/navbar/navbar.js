const hamburger = document.getElementById('hamburgerBtn');
const navLinks  = document.getElementById('navLinks');
const closeBtn  = document.getElementById('closeBtn');

hamburger.addEventListener('click', () => navLinks.style.left = '0');
closeBtn.addEventListener('click', () => navLinks.style.left = '-100%');

// Profile Dropdown Toggle (desktop only)
const profileBtn = document.getElementById('profileBtn');
const profileDropdown = document.getElementById('profileDropdown');

if (profileBtn && profileDropdown) {
    // Only enable dropdown on desktop (screen width >= 768px)
    const handleProfileClick = (e) => {
        e.stopPropagation();
        profileDropdown.classList.toggle('hidden');
    };

    profileBtn.addEventListener('click', handleProfileClick);

    // Close dropdown when clicking outside (desktop only)
    document.addEventListener('click', (e) => {
        if (!profileBtn.contains(e.target) && !profileDropdown.contains(e.target)) {
            profileDropdown.classList.add('hidden');
        }
    });

    // Prevent dropdown from closing when clicking inside
    profileDropdown.addEventListener('click', (e) => {
        e.stopPropagation();
    });

    // Close dropdown when resizing to mobile
    window.addEventListener('resize', () => {
        if (window.innerWidth < 768) {
            profileDropdown.classList.add('hidden');
        }
    });
}
