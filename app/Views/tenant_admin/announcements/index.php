<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>
<div class="d-flex justify-content-between align-items-center mb-4">
    <h3 class="fw-bold mb-0">Pusat Informasi</h3>
    <button type="button" class="btn btn-primary rounded-pill px-4" data-bs-toggle="modal" data-bs-target="#addAnnouncementModal">
        <i class="fa-solid fa-bullhorn me-1"></i> Bagikan Informasi
    </button>
</div>

<?php if(session()->getFlashdata('success')): ?>
    <div class="alert alert-success border-0 shadow-sm mb-4">
        <i class="fa-solid fa-check-circle me-2"></i> <?= session()->getFlashdata('success') ?>
    </div>
<?php endif; ?>

<?php if(empty($announcements)): ?>
    <div class="card border-0 shadow-sm rounded-4 text-center p-5">
        <i class="fa-solid fa-bell-slash fa-3x text-muted mb-3"></i>
        <h5 class="text-dark fw-bold">Belum ada informasi</h5>
        <p class="text-muted mb-0">Klik tombol di atas untuk mulai membagikan informasi.</p>
    </div>
<?php else: ?>
    <div class="row g-4">
        <?php foreach($announcements as $a): ?>
        <div class="col-12">
            <div class="card border-0 shadow-sm rounded-4 h-100">
                <div class="card-body p-4">
                    <div class="d-flex justify-content-between align-items-start mb-3">
                        <div class="d-flex align-items-center gap-3">
                            <div class="bg-primary bg-opacity-10 text-primary rounded-circle d-flex align-items-center justify-content-center" style="width: 48px; height: 48px;">
                                <i class="fa-solid fa-bullhorn fa-lg"></i>
                            </div>
                            <div>
                                <h5 class="fw-bold mb-1 text-dark"><?= esc($a->title) ?></h5>
                                <div class="text-muted small">
                                    <i class="fa-regular fa-clock me-1"></i> <?= date('d M Y H:i', strtotime($a->created_at)) ?> 
                                    <span class="mx-1">&bull;</span>
                                    <i class="fa-regular fa-user me-1"></i> <?= esc($a->author_name ?? 'Admin') ?>
                                    <span class="mx-1">&bull;</span>
                                    <span class="badge bg-secondary bg-opacity-10 text-secondary border">
                                        Target: <?= ucfirst(esc($a->target_role)) ?>
                                    </span>
                                </div>
                            </div>
                        </div>
                        <form action="/<?= $tenantStringId ?? session('current_tenant_string') ?>/admin_tenant/announcements/<?= $a->id ?>/delete" method="POST">
                            <?= csrf_field() ?>
                            <button type="submit" class="btn btn-sm btn-link text-danger p-0" onclick="return confirm('Hapus informasi ini?');">
                                <i class="fa-solid fa-trash"></i>
                            </button>
                        </form>
                    </div>
                    
                    <div class="bg-light p-3 rounded-3 mt-3">
                        <div class="text-dark lh-base" style="white-space: pre-line;">
                            <?= esc($a->content) ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php endforeach; ?>
    </div>
<?php endif; ?>

<!-- Modal Add -->
<div class="modal fade" id="addAnnouncementModal" tabindex="-1">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content border-0 shadow">
      <div class="modal-header border-bottom-0 pb-0">
        <h5 class="modal-title fw-bold">Bagikan Informasi</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <form action="/<?= $tenantStringId ?? session('current_tenant_string') ?>/admin_tenant/announcements" method="POST">
          <?= csrf_field() ?>
          <div class="modal-body">
              <div class="mb-3">
                  <label class="form-label fw-bold text-muted small text-uppercase">Judul Informasi</label>
                  <input type="text" name="title" class="form-control" required>
              </div>
              <div class="mb-3">
                  <label class="form-label fw-bold text-muted small text-uppercase">Target Penerima</label>
                  <select name="target_role" class="form-select" required>
                      <option value="all">Semua (Instruktur & Siswa)</option>
                      <option value="instructor">Hanya Instruktur</option>
                      <option value="student">Hanya Siswa</option>
                  </select>
              </div>
              <div class="mb-3">
                  <label class="form-label fw-bold text-muted small text-uppercase">Isi Informasi</label>
                  <textarea name="content" class="form-control" rows="5" required></textarea>
              </div>
          </div>
          <div class="modal-footer border-top-0 pt-0">
            <button type="button" class="btn btn-light" data-bs-dismiss="modal">Batal</button>
            <button type="submit" class="btn btn-primary px-4"><i class="fa-solid fa-paper-plane me-1"></i> Bagikan</button>
          </div>
      </form>
    </div>
  </div>
</div>
<?= $this->endSection() ?>
