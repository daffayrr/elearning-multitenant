<?= $this->extend('student/layout') ?>

<?= $this->section('content') ?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h4 class="fw-bold m-0 text-dark"><i class="fa-solid fa-compass me-2 text-primary"></i> Eksplorasi Kelas</h4>
</div>

<?php if(session()->getFlashdata('success')): ?>
    <div class="alert alert-success border-0 shadow-sm mb-4">
        <i class="fa-solid fa-check-circle me-2"></i> <?= session()->getFlashdata('success') ?>
    </div>
<?php endif; ?>

<?php if(session()->getFlashdata('error')): ?>
    <div class="alert alert-danger border-0 shadow-sm mb-4">
        <i class="fa-solid fa-triangle-exclamation me-2"></i> <?= session()->getFlashdata('error') ?>
    </div>
<?php endif; ?>

<div class="row g-4">
    <?php foreach($courses as $course): ?>
    <?php 
        $status = $enrollmentStatus[$course->id] ?? null;
    ?>
    <div class="col-md-6 col-lg-4">
        <div class="card h-100 border-0 shadow-sm rounded-3">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-start mb-2">
                    <h5 class="fw-bold mb-0 text-dark"><?= esc($course->title) ?></h5>
                    <?php if($course->enrollment_key): ?>
                        <i class="fa-solid fa-key text-warning" title="Membutuhkan Kunci Pendaftaran"></i>
                    <?php else: ?>
                        <i class="fa-solid fa-lock-open text-muted" title="Bebas Pendaftaran (Menunggu Persetujuan)"></i>
                    <?php endif; ?>
                </div>
                <span class="badge bg-primary bg-opacity-10 text-primary border border-primary-subtle mb-3">Course</span>
                <p class="text-muted small mb-0" style="display: -webkit-box; -webkit-line-clamp: 3; -webkit-box-orient: vertical; overflow: hidden;">
                    <?= esc($course->description) ?>
                </p>
            </div>
            <div class="card-footer bg-white border-top-0 pb-3 pt-0">
                <?php if($status === 'approved'): ?>
                    <a href="/<?= $tenant ?? session('current_tenant_string') ?>/student/course/<?= $course->id ?>" class="btn btn-outline-primary rounded-pill w-100">
                        <i class="fa-solid fa-door-open me-1"></i> Buka Kelas
                    </a>
                <?php elseif($status === 'pending'): ?>
                    <button class="btn btn-warning rounded-pill w-100 text-dark" disabled>
                        <i class="fa-solid fa-hourglass-half me-1"></i> Menunggu Persetujuan
                    </button>
                <?php elseif($status === 'rejected'): ?>
                    <button class="btn btn-danger rounded-pill w-100" disabled>
                        <i class="fa-solid fa-ban me-1"></i> Pendaftaran Ditolak
                    </button>
                <?php else: ?>
                    <button type="button" class="btn btn-navy rounded-pill w-100" 
                        data-bs-toggle="modal" 
                        data-bs-target="#enrollModal"
                        data-id="<?= $course->id ?>"
                        data-title="<?= esc($course->title) ?>"
                        data-has-key="<?= empty($course->enrollment_key) ? 'false' : 'true' ?>">
                        <i class="fa-solid fa-user-plus me-1"></i> Daftar Kelas
                    </button>
                <?php endif; ?>
            </div>
        </div>
    </div>
    <?php endforeach; ?>

    <?php if(empty($courses)): ?>
    <div class="col-12">
        <div class="text-center p-5 bg-white border rounded-3 shadow-sm">
            <i class="fa-solid fa-box-open fa-3x text-muted mb-3"></i>
            <h5 class="text-dark fw-bold">Belum ada kelas</h5>
            <p class="text-muted mb-4">Instruktur belum membuat kelas di tenant ini.</p>
        </div>
    </div>
    <?php endif; ?>
</div>

<!-- Modal Enroll -->
<div class="modal fade" id="enrollModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content border-0 shadow">
      <div class="modal-header border-bottom-0 pb-0">
        <h5 class="modal-title fw-bold">Daftar Kelas</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form id="enrollForm" method="POST">
          <?= csrf_field() ?>
          <div class="modal-body">
              <p class="text-muted">Anda akan mendaftar ke kelas <strong id="enrollCourseTitle" class="text-dark"></strong>.</p>
              
              <div id="enrollKeyContainer" style="display:none;" class="mb-3">
                  <label class="form-label fw-bold text-muted small text-uppercase">Kunci Pendaftaran (Enrollment Key)</label>
                  <input type="text" name="enrollment_key" id="enrollment_key_input" class="form-control form-control-lg">
                  <div class="form-text">Kelas ini membutuhkan kunci pendaftaran dari instruktur.</div>
              </div>
              <div id="enrollNoKeyContainer" style="display:none;" class="alert alert-info border-0 text-sm">
                  <i class="fa-solid fa-circle-info me-1"></i> Kelas ini dapat didaftar secara gratis. Pendaftaran Anda akan diproses dan menunggu persetujuan dari instruktur.
              </div>
          </div>
          <div class="modal-footer border-top-0 pt-0">
            <button type="button" class="btn btn-light" data-bs-dismiss="modal">Batal</button>
            <button type="submit" class="btn btn-navy px-4">Daftar Sekarang</button>
          </div>
      </form>
    </div>
  </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const enrollModal = document.getElementById('enrollModal');
    if (enrollModal) {
        enrollModal.addEventListener('show.bs.modal', function (event) {
            const button = event.relatedTarget;
            const id = button.getAttribute('data-id');
            const title = button.getAttribute('data-title');
            const hasKey = button.getAttribute('data-has-key') === 'true';

            const form = document.getElementById('enrollForm');
            form.action = '/<?= $tenant ?? session('current_tenant_string') ?>/student/course/' + id + '/enroll';
            
            document.getElementById('enrollCourseTitle').innerText = title;
            
            const keyContainer = document.getElementById('enrollKeyContainer');
            const noKeyContainer = document.getElementById('enrollNoKeyContainer');
            const keyInput = document.getElementById('enrollment_key_input');
            
            if (hasKey) {
                keyContainer.style.display = 'block';
                noKeyContainer.style.display = 'none';
                keyInput.setAttribute('required', 'required');
            } else {
                keyContainer.style.display = 'none';
                noKeyContainer.style.display = 'block';
                keyInput.removeAttribute('required');
                keyInput.value = '';
            }
        });
    }
});
</script>

<?= $this->endSection() ?>
