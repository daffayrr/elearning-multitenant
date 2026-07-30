<?= $this->extend('instructor/layout') ?>

<?= $this->section('content') ?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h4 class="fw-bold m-0 text-dark"><i class="fa-solid fa-server me-2 text-primary"></i> Bank Soal CBT</h4>
    <button type="button" class="btn btn-navy rounded-pill px-4" data-bs-toggle="modal" data-bs-target="#createBankModal">
        <i class="fa-solid fa-plus me-1"></i> Buat Bank Soal
    </button>
</div>

<?php if(session()->getFlashdata('success')): ?>
    <div class="alert alert-success border-0 shadow-sm mb-4">
        <i class="fa-solid fa-check-circle me-2"></i> <?= session()->getFlashdata('success') ?>
    </div>
<?php endif; ?>

<div class="row g-4">
    <?php foreach($banks as $bank): ?>
    <div class="col-md-6 col-lg-4">
        <div class="card h-100 border-0 shadow-sm rounded-3">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-start mb-2">
                    <h5 class="fw-bold mb-0 text-dark"><?= esc($bank->title) ?></h5>
                    <form action="/<?= $tenantStringId ?? session('current_tenant_string') ?>/instructor/quiz-banks/<?= $bank->id ?>/delete" method="POST" class="d-inline">
                        <?= csrf_field() ?>
                        <button type="submit" class="btn btn-sm btn-link text-danger p-0" onclick="return confirm('Hapus bank soal ini beserta seluruh pertanyaannya?');" title="Hapus Bank Soal">
                            <i class="fa-solid fa-trash"></i>
                        </button>
                    </form>
                </div>
                <p class="text-muted small mb-4" style="display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden;">
                    <?= esc($bank->description) ?>
                </p>
            </div>
            <div class="card-footer bg-white border-top-0 pb-3 pt-0 text-end">
                <a href="/<?= $tenantStringId ?? session('current_tenant_string') ?>/instructor/quiz-banks/<?= $bank->id ?>" class="btn btn-sm btn-outline-primary rounded-pill px-3">
                    Kelola Pertanyaan <i class="fa-solid fa-arrow-right ms-1"></i>
                </a>
            </div>
        </div>
    </div>
    <?php endforeach; ?>

    <?php if(empty($banks)): ?>
    <div class="col-12">
        <div class="text-center p-5 bg-white border rounded-3 shadow-sm">
            <i class="fa-solid fa-database fa-3x text-muted mb-3"></i>
            <h5 class="text-dark fw-bold">Belum ada Bank Soal</h5>
            <p class="text-muted mb-4">Kumpulkan pertanyaan untuk Computer Based Test (CBT) dalam Bank Soal.</p>
            <button type="button" class="btn btn-navy rounded-pill px-4" data-bs-toggle="modal" data-bs-target="#createBankModal">
                Buat Bank Soal Sekarang
            </button>
        </div>
    </div>
    <?php endif; ?>
</div>

<!-- Modal Create Bank -->
<div class="modal fade" id="createBankModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content border-0 shadow">
      <div class="modal-header border-bottom-0 pb-0">
        <h5 class="modal-title fw-bold">Buat Bank Soal Baru</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form action="/<?= $tenantStringId ?? session('current_tenant_string') ?>/instructor/quiz-banks" method="POST">
          <?= csrf_field() ?>
          <div class="modal-body">
              <div class="mb-3">
                  <label class="form-label fw-bold text-muted small text-uppercase">Nama Bank Soal</label>
                  <input type="text" name="title" class="form-control form-control-lg" required placeholder="Contoh: Bank Soal UTS Matematika">
              </div>
              <div class="mb-3">
                  <label class="form-label fw-bold text-muted small text-uppercase">Deskripsi Singkat</label>
                  <textarea name="description" class="form-control" rows="3" placeholder="Keterangan bank soal..."></textarea>
              </div>
          </div>
          <div class="modal-footer border-top-0 pt-0">
            <button type="button" class="btn btn-light" data-bs-dismiss="modal">Batal</button>
            <button type="submit" class="btn btn-navy px-4">Simpan Bank Soal</button>
          </div>
      </form>
    </div>
  </div>
</div>

<?= $this->endSection() ?>
