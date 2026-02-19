/**
 * Complaint System - Shared Modal & Popover Logic
 * Include this file in all pages (User, Agent, Admin)
 */

document.addEventListener("DOMContentLoaded", function () {
  // ==========================================
  // 1. Initialize Popovers
  // ==========================================
  var popoverTriggerList = [].slice.call(
    document.querySelectorAll('[data-bs-toggle="popover"]'),
  );

  if (popoverTriggerList.length > 0) {
    var popoverList = popoverTriggerList.map(function (popoverTriggerEl) {
      return new bootstrap.Popover(popoverTriggerEl);
    });
  }

  // ==========================================
  // 2. Attachment Modal Logic
  // ==========================================
  const attachmentModal = document.getElementById("attachmentModal");

  // Only run if modal exists on the page
  if (attachmentModal) {
    const modalImageContainer = document.getElementById("modalImageContainer");
    const modalDownloadContainer = document.getElementById(
      "modalDownloadContainer",
    );
    const modalImageSrc = document.getElementById("modalImageSrc");
    const modalDownloadLink = document.getElementById("modalDownloadLink");

    attachmentModal.addEventListener("show.bs.modal", function (event) {
      const button = event.relatedTarget; // Button that triggered the modal

      // Get data attributes
      const filepath = button.getAttribute("datafilepath");
      const isImage = button.getAttribute("data-isimage") === "true";
      const filename = button.getAttribute("data-filename");

      // Reset contents to prevent showing previous image/file
      if (modalImageSrc) modalImageSrc.src = "";
      if (modalDownloadLink) {
        modalDownloadLink.href = "";
        modalDownloadLink.removeAttribute("download");
      }

      if (isImage && modalImageContainer && modalDownloadContainer) {
        // Show Image, Hide Download
        modalImageContainer.classList.remove("d-none");
        modalDownloadContainer.classList.add("d-none");
        if (modalImageSrc) modalImageSrc.src = filepath;
      } else if (modalImageContainer && modalDownloadContainer) {
        // Hide Image, Show Download
        modalImageContainer.classList.add("d-none");
        modalDownloadContainer.classList.remove("d-none");
        if (modalDownloadLink) {
          modalDownloadLink.href = filepath;
          modalDownloadLink.setAttribute("download", filename);
        }
      }
    });

    // Clear modal content when hidden (optional cleanup)
    attachmentModal.addEventListener("hidden.bs.modal", function () {
      if (modalImageSrc) modalImageSrc.src = "";
      if (modalDownloadLink) modalDownloadLink.href = "";
    });
  }

  // ==========================================
  // 3. Assign Agent Modal Logic (Admin Only)
  // ==========================================
  const assignAgentModal = document.getElementById("assignAgentModal");

  // Only run if assign modal exists (Admin page)
  if (assignAgentModal) {
    assignAgentModal.addEventListener("show.bs.modal", function (event) {
      const button = event.relatedTarget;
      const complaintId = button.getAttribute("data-complaint-id");
      const hiddenInput = document.getElementById("assignComplaintId");

      if (hiddenInput) {
        hiddenInput.value = complaintId;
      }
    });
  }
});
