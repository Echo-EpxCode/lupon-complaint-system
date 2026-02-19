// Sidebar Toggle and Close for Smaller Screens Only
const sidebar = document.getElementById("sidebar");
const sidebarToggle = document.getElementById("sidebarToggle");
const sidebarClose = document.getElementById("sidebarClose");

function toggleSidebar() {
  if (window.innerWidth < 768) {
    sidebar.classList.toggle("show");
    // Update ARIA for accessibility
    const isExpanded = sidebar.classList.contains("show");
    if (sidebarToggle) sidebarToggle.setAttribute("aria-expanded", isExpanded);
  }
}

if (sidebarToggle) {
  sidebarToggle.addEventListener("click", toggleSidebar);
}

if (sidebarClose) {
  sidebarClose.addEventListener("click", toggleSidebar);
}

// Auto-collapse sidebar on mobile load
if (window.innerWidth < 768) {
  sidebar.classList.add("collapsed");
}

// Agent JavaScript Confirmation
document.querySelector("form").addEventListener("submit", function (e) {
  if (!confirm("Are you sure you want to update the status?")) {
    e.preventDefault();
  }
});
