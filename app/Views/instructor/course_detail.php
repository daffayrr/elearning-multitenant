<?= $this->extend('instructor/layout') ?>

<?= $this->section('content') ?>

<div class="mb-4 d-flex justify-content-between align-items-center">
    <a href="/<?= $tenant ?? session('current_tenant_string') ?>/instructor/courses" class="btn btn-outline-secondary btn-sm">
        <i class="fa-solid fa-arrow-left me-1"></i> Kembali ke Manajemen Kelas
    </a>
    <a href="/<?= $tenant ?? session('current_tenant_string') ?>/instructor/course/<?= $course->id ?>/enrollments" class="btn btn-navy btn-sm rounded-pill px-3 shadow-sm">
        <i class="fa-solid fa-user-check me-1"></i> Kelola Pendaftar
    </a>
</div>

<div class="mb-4">
    <div class="card border-0 shadow-sm rounded-3 bg-navy text-white" style="background-color: var(--primary-navy);">
        <div class="card-body p-4">
            <h3 class="fw-bold mb-2 text-white"><?= esc($course->title) ?></h3>
            <p class="mb-0 opacity-75"><?= esc($course->description) ?></p>
        </div>
    </div>
</div>

<?php if(session()->getFlashdata('success')): ?>
    <div class="alert alert-success border-0 shadow-sm mb-4">
        <i class="fa-solid fa-check-circle me-2"></i> <?= session()->getFlashdata('success') ?>
    </div>
<?php endif; ?>

<div class="row g-4">
    <!-- Modules Section -->
    <div class="col-lg-6">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h5 class="fw-bold m-0 text-dark"><i class="fa-solid fa-layer-group me-2 text-primary"></i> Modul & Materi</h5>
            <button type="button" class="btn btn-sm btn-navy rounded-pill px-3" data-bs-toggle="modal" data-bs-target="#addModuleModal">
                <i class="fa-solid fa-plus me-1"></i> Tambah Modul
            </button>
        </div>

        <?php if(empty($modules)): ?>
            <div class="card border-0 shadow-sm rounded-3 text-center p-4">
                <i class="fa-solid fa-folder-open fa-2x text-muted mb-2"></i>
                <p class="text-muted mb-0 small">Belum ada modul materi.</p>
            </div>
        <?php else: ?>
            <div class="card border-0 shadow-sm rounded-3">
                <div class="list-group list-group-flush rounded-3">
                    <?php foreach($modules as $module): ?>
                        <div class="list-group-item p-3">
                            <div class="d-flex justify-content-between align-items-start mb-1">
                                <h6 class="fw-bold mb-0 text-dark"><?= esc($module->title) ?></h6>
                                <span class="badge bg-secondary bg-opacity-10 text-secondary border">Urutan: <?= $module->order ?></span>
                            </div>
                            <p class="text-muted small mb-2"><?= esc($module->description) ?></p>
                            <?php if($module->file_url): ?>
                                <a href="/<?= $tenant ?? session('current_tenant_string') ?>/download/s3?url=<?= urlencode($module->file_url) ?>" target="_blank" class="btn btn-sm btn-outline-primary rounded-pill py-1 px-3">
                                    <i class="fa-solid fa-download me-1"></i> Unduh Materi
                                </a>
                            <?php endif; ?>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        <?php endif; ?>
    </div>

    <!-- Assignments Section -->
    <div class="col-lg-6">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h5 class="fw-bold m-0 text-dark"><i class="fa-solid fa-tasks me-2 text-warning"></i> Tugas & Kuis</h5>
            <button type="button" class="btn btn-sm btn-navy rounded-pill px-3" data-bs-toggle="modal" data-bs-target="#addAssignmentModal">
                <i class="fa-solid fa-plus me-1"></i> Tambah Tugas
            </button>
        </div>

        <?php if(empty($assignments)): ?>
            <div class="card border-0 shadow-sm rounded-3 text-center p-4">
                <i class="fa-solid fa-clipboard-check fa-2x text-muted mb-2"></i>
                <p class="text-muted mb-0 small">Belum ada tugas atau kuis.</p>
            </div>
        <?php else: ?>
            <div class="card border-0 shadow-sm rounded-3">
                <div class="list-group list-group-flush rounded-3">
                    <?php foreach($assignments as $assignment): ?>
                        <div class="list-group-item p-3">
                            <div class="d-flex justify-content-between align-items-start mb-1">
                                <h6 class="fw-bold mb-0 text-dark"><?= esc($assignment->title) ?></h6>
                                <span class="badge <?= $assignment->type === 'quiz' ? 'bg-success' : 'bg-info' ?> bg-opacity-10 text-dark border">
                                    <?= ucfirst($assignment->type) ?>
                                </span>
                            </div>
                            <div class="text-danger small fw-bold mb-2"><i class="fa-regular fa-clock me-1"></i> Tenggat Waktu: <?= date('d M Y, H:i', strtotime($assignment->due_date)) ?></div>
                            <p class="text-muted small mb-2"><?= esc($assignment->description) ?></p>
                            <?php if($assignment->file_url): ?>
                                <a href="/<?= $tenant ?? session('current_tenant_string') ?>/download/s3?url=<?= urlencode($assignment->file_url) ?>" target="_blank" class="btn btn-sm btn-outline-primary rounded-pill py-1 px-3">
                                    <i class="fa-solid fa-paperclip me-1"></i> Lampiran
                                </a>
                            <?php endif; ?>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        <?php endif; ?>
    </div>
</div>

<!-- Modal Add Module -->
<div class="modal fade" id="addModuleModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content border-0 shadow">
      <div class="modal-header border-bottom-0 pb-0">
        <h5 class="modal-title fw-bold">Tambah Modul Materi</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form action="/<?= $tenant ?? session('current_tenant_string') ?>/instructor/course/<?= $course->id ?>/module" method="POST" enctype="multipart/form-data">
          <?= csrf_field() ?>
          <div class="modal-body">
              <div class="mb-3">
                  <label class="form-label fw-bold text-muted small text-uppercase">Judul Modul</label>
                  <input type="text" name="title" class="form-control" required>
              </div>
              <div class="mb-3">
                  <label class="form-label fw-bold text-muted small text-uppercase">Deskripsi</label>
                  <textarea name="description" class="form-control" rows="2"></textarea>
              </div>
              <div class="mb-3">
                  <label class="form-label fw-bold text-muted small text-uppercase">Urutan</label>
                  <input type="number" name="order" class="form-control" value="1">
              </div>
              <div class="mb-3">
                  <label class="form-label fw-bold text-muted small text-uppercase">File Materi (PDF, Video, dll)</label>
                  <input type="file" name="material_file" class="form-control">
              </div>
          </div>
          <div class="modal-footer border-top-0 pt-0">
            <button type="button" class="btn btn-light" data-bs-dismiss="modal">Batal</button>
            <button type="submit" class="btn btn-navy px-4">Simpan Modul</button>
          </div>
      </form>
    </div>
  </div>
</div>

<!-- Modal Add Assignment -->
<div class="modal fade" id="addAssignmentModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content border-0 shadow">
      <div class="modal-header border-bottom-0 pb-0">
        <h5 class="modal-title fw-bold">Tambah Tugas / Kuis</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form action="/<?= $tenant ?? session('current_tenant_string') ?>/instructor/course/<?= $course->id ?>/assignment" method="POST" enctype="multipart/form-data">
          <?= csrf_field() ?>
          <div class="modal-body">
              <div class="mb-3">
                  <label class="form-label fw-bold text-muted small text-uppercase">Judul Tugas</label>
                  <input type="text" name="title" class="form-control" required>
              </div>
              <div class="mb-3">
                  <label class="form-label fw-bold text-muted small text-uppercase">Tipe</label>
                  <select name="type" class="form-select" id="assignmentTypeSelect" required>
                      <option value="submission">Pengumpulan File (Submission)</option>
                      <option value="quiz">Kuis Sederhana (Quiz)</option>
                      <option value="essay">Uraian (Essay)</option>
                      <option value="cbt">Computer Based Test (CBT)</option>
                  </select>
              </div>
              <div class="mb-3" id="qbankSelectContainer" style="display:none;">
                  <label class="form-label fw-bold text-muted small text-uppercase">Pilih Bank Soal</label>
                  <select name="question_bank_id" class="form-select">
                      <option value="">-- Pilih Bank Soal --</option>
                      <?php if(isset($questionBanks) && !empty($questionBanks)): ?>
                          <?php foreach($questionBanks as $qb): ?>
                              <option value="<?= $qb->id ?>"><?= esc($qb->title) ?></option>
                          <?php endforeach; ?>
                      <?php endif; ?>
                  </select>
              </div>
              <div class="mb-3">
                  <label class="form-label fw-bold text-muted small text-uppercase">Instruksi / Deskripsi</label>
                  <textarea name="description" class="form-control" rows="2"></textarea>
              </div>
              <div class="mb-3">
                  <label class="form-label fw-bold text-muted small text-uppercase">Tenggat Waktu (Due Date)</label>
                  <input type="datetime-local" name="due_date" class="form-control" required>
              </div>
              <div class="mb-3" id="attachmentContainer">
                  <label class="form-label fw-bold text-muted small text-uppercase">Lampiran (Opsional)</label>
                  <input type="file" name="assignment_file" class="form-control">
              </div>
          </div>
          <div class="modal-footer border-top-0 pt-0">
            <button type="button" class="btn btn-light" data-bs-dismiss="modal">Batal</button>
            <button type="submit" class="btn btn-navy px-4">Simpan Tugas</button>
          </div>
      </form>
    </div>
  </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const typeSelect = document.getElementById('assignmentTypeSelect');
    const qbankContainer = document.getElementById('qbankSelectContainer');
    const attachmentContainer = document.getElementById('attachmentContainer');

    if(typeSelect) {
        typeSelect.addEventListener('change', function() {
            if(this.value === 'cbt') {
                qbankContainer.style.display = 'block';
                attachmentContainer.style.display = 'none';
            } else {
                qbankContainer.style.display = 'none';
                attachmentContainer.style.display = 'block';
            }
        });
    }
});
</script>

<?= $this->endSection() ?>
