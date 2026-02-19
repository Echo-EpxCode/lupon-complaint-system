<!-- Other existing footer content above -->

<!-- ========================================== -->
<!-- MODAL: Attachment Viewer (Shared) -->
<!-- ========================================== -->
<div class="modal fade" id="attachmentModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Attachment Preview</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body text-center">
                <!-- Image Container -->
                <div id="modalImageContainer">
                    <img src="" id="modalImageSrc" class="img-fluid" alt="Attachment">
                </div>
                <!-- Download Container -->
                <div id="modalDownloadContainer" class="d-none">
                    <p class="mb-3">This file type cannot be previewed directly.</p>
                    <a href="" id="modalDownloadLink" class="btn btn-success" download>
                        <i class="fas fa-download"></i> Download File
                    </a>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<!-- Custom JS (External File) -->
<script src="../assets/js/script.js"></script>
<script src="../assets/js/complaint-modal.js"></script>


</body>
</html>