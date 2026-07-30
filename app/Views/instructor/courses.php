<?= $this->extend('instructor/layout') ?>

<?= $this->section('content') ?>

<?php if(session()->getFlashdata('success')): ?>
    <div class="alert alert-success border-0 shadow-sm mb-4">
        <i class="fa-solid fa-check-circle me-2"></i> <?= session()->getFlashdata('success') ?>
    </div>
<?php endif; ?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h4 class="fw-bold m-0 text-dark">Manajemen Kelas</h4>
    <button type="button" class="btn btn-navy rounded-pill px-4" data-bs-toggle="modal" data-bs-target="#createCourseModal">
        <i class="fa-solid fa-plus me-1"></i> Buat Kelas
    </button>
</div>

<div class="row g-4">
    <?php foreach($courses as $course): ?>
    <div class="col-md-6 col-lg-4">
        <div class="card h-100 border-0 shadow-sm rounded-3">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-start mb-2">
                    <h5 class="fw-bold mb-0 text-dark"><?= esc($course->title) ?></h5>
                    <div class="dropdown">
                        <button class="btn btn-sm btn-link text-muted text-decoration-none" type="button" data-bs-toggle="dropdown">
                            <i class="fa-solid fa-ellipsis-vertical"></i>
                        </button>
                        <ul class="dropdown-menu dropdown-menu-end border-0 shadow">
                            <li>
                                <button type="button" class="dropdown-item" 
                                    data-bs-toggle="modal" 
                                    data-bs-target="#editCourseModal"
                                    data-id="<?= $course->id ?>"
                                    data-title="<?= esc($course->title) ?>"
                                    data-desc="<?= esc($course->description) ?>"
                                    data-key="<?= esc($course->enrollment_key) ?>">
                                    <i class="fa-solid fa-pen text-primary me-2"></i> Edit Kelas
                                </button>
                            </li>
                            <li>
                                <form action="/<?= $tenant ?? session('current_tenant_string') ?>/instructor/course/<?= $course->id ?>/delete" method="POST" class="d-inline">
                                    <?= csrf_field() ?>
                                    <button type="submit" class="dropdown-item text-danger" onclick="return confirm('Yakin ingin menghapus kelas ini?');">
                                        <i class="fa-solid fa-trash me-2"></i> Hapus Kelas
                                    </button>
                                </form>
                            </li>
                        </ul>
                    </div>
                </div>
                <span class="badge bg-primary bg-opacity-10 text-primary border border-primary-subtle mb-2">Course</span>
                <p class="text-muted small mb-4" style="display: -webkit-box; -webkit-line-clamp: 3; -webkit-box-orient: vertical; overflow: hidden;">
                    <?= esc($course->description) ?>
                </p>
            </div>
            <div class="card-footer bg-white border-top-0 pb-3 pt-0 d-flex justify-content-between">
                <a href="/<?= $tenant ?? session('current_tenant_string') ?>/instructor/course/<?= $course->id ?>/preview" class="btn btn-sm btn-light rounded-pill px-3 text-muted border">
                    <i class="fa-solid fa-eye me-1"></i> Mode Siswa
                </a>
                <a href="/<?= $tenant ?? session('current_tenant_string') ?>/instructor/course/<?= $course->id ?>" class="btn btn-sm btn-outline-primary rounded-pill px-3">
                    Kelola <i class="fa-solid fa-arrow-right ms-1"></i>
                </a>
            </div>
        </div>
    </div>
    <?php endforeach; ?>

    <?php if(empty($courses)): ?>
    <div class="col-12">
        <div class="text-center p-5 bg-white border rounded-3 shadow-sm">
            <i class="fa-solid fa-book-open fa-3x text-muted mb-3"></i>
            <h5 class="text-dark fw-bold">Belum ada kelas</h5>
            <p class="text-muted mb-4">Mulai bagikan ilmu dengan membuat kelas pertama Anda.</p>
            <button type="button" class="btn btn-navy rounded-pill px-4" data-bs-toggle="modal" data-bs-target="#createCourseModal">
                Buat Kelas Sekarang
            </button>
        </div>
    </div>
    <?php endif; ?>
</div>

<!-- Modal Create Course -->
<div class="modal fade" id="createCourseModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content border-0 shadow">
      <div class="modal-header border-bottom-0 pb-0">
        <h5 class="modal-title fw-bold">Buat Kelas Baru</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form action="/<?= $tenant ?? session('current_tenant_string') ?>/instructor/courses" method="POST">
          <?= csrf_field() ?>
          <div class="modal-body">
              <div class="mb-3">
                  <label class="form-label fw-bold text-muted small text-uppercase">Nama Kelas</label>
                  <input type="text" name="title" class="form-control form-control-lg" required placeholder="Contoh: Matematika Lanjut">
              </div>
              <div class="mb-3">
                  <label class="form-label fw-bold text-muted small text-uppercase">Kunci Pendaftaran (Enrollment Key)</label>
                  <input type="text" name="enrollment_key" class="form-control" placeholder="Biarkan kosong jika bebas pendaftaran">
                  <div class="form-text">Siswa yang memasukkan kunci ini akan langsung disetujui (enrollment otomatis).</div>
              </div>
              <div class="mb-3">
                  <label class="form-label fw-bold text-muted small text-uppercase">Deskripsi Singkat</label>
                  <textarea name="description" class="form-control" rows="4" placeholder="Tuliskan deskripsi kelas..."></textarea>
              </div>
          </div>
          <div class="modal-footer border-top-0 pt-0">
            <button type="button" class="btn btn-light" data-bs-dismiss="modal">Batal</button>
            <button type="submit" class="btn btn-navy px-4">Simpan Kelas</button>
          </div>
      </form>
    </div>
  </div>
</div>

<!-- Modal Edit Course -->
<div class="modal fade" id="editCourseModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content border-0 shadow">
      <div class="modal-header border-bottom-0 pb-0">
        <h5 class="modal-title fw-bold">Edit Kelas</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form id="editCourseForm" method="POST">
          <?= csrf_field() ?>
          <div class="modal-body">
              <div class="mb-3">
                  <label class="form-label fw-bold text-muted small text-uppercase">Nama Kelas</label>
                  <input type="text" name="title" id="edit_course_title" class="form-control form-control-lg" required>
              </div>
              <div class="mb-3">
                  <label class="form-label fw-bold text-muted small text-uppercase">Kunci Pendaftaran (Enrollment Key)</label>
                  <input type="text" name="enrollment_key" id="edit_course_enrollment_key" class="form-control" placeholder="Biarkan kosong jika bebas pendaftaran">
                  <div class="form-text">Siswa yang memasukkan kunci ini akan langsung disetujui (enrollment otomatis).</div>
              </div>
              <div class="mb-3">
                  <label class="form-label fw-bold text-muted small text-uppercase">Deskripsi Singkat</label>
                  <textarea name="description" id="edit_course_description" class="form-control" rows="4"></textarea>
              </div>
          </div>
          <div class="modal-footer border-top-0 pt-0">
            <button type="button" class="btn btn-light" data-bs-dismiss="modal">Batal</button>
            <button type="submit" class="btn btn-navy px-4">Simpan Perubahan</button>
          </div>
      </form>
    </div>
  </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const editCourseModal = document.getElementById('editCourseModal');
    if (editCourseModal) {
        editCourseModal.addEventListener('show.bs.modal', function (event) {
            const button = event.relatedTarget;
            const id = button.getAttribute('data-id');
            const title = button.getAttribute('data-title');
            const desc = button.getAttribute('data-desc');
            const key = button.getAttribute('data-key');

            const form = document.getElementById('editCourseForm');
            form.action = '/<?= $tenant ?? session('current_tenant_string') ?>/instructor/course/' + id + '/update';
            
            document.getElementById('edit_course_title').value = title;
            document.getElementById('edit_course_description').value = desc;
            document.getElementById('edit_course_enrollment_key').value = key;
        });
    }
});
</script>

<?= $this->endSection() ?>
