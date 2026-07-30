<?= $this->extend('instructor/layout') ?>

<?= $this->section('content') ?>

<div class="mb-4">
    <a href="/<?= $tenantStringId ?? session('current_tenant_string') ?>/instructor/quiz-banks" class="btn btn-outline-secondary btn-sm mb-3">
        <i class="fa-solid fa-arrow-left me-1"></i> Kembali ke Bank Soal
    </a>
    <div class="card border-0 shadow-sm rounded-3 bg-navy text-white" style="background-color: var(--primary-navy);">
        <div class="card-body p-4">
            <h3 class="fw-bold mb-2 text-white"><?= esc($bank->title) ?></h3>
            <p class="mb-0 opacity-75"><?= esc($bank->description) ?></p>
        </div>
    </div>
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

<div class="d-flex justify-content-between align-items-center mb-3">
    <h5 class="fw-bold m-0 text-dark"><i class="fa-solid fa-list-ul me-2 text-primary"></i> Daftar Pertanyaan</h5>
    <div>
        <button type="button" class="btn btn-outline-success rounded-pill px-3 me-2" data-bs-toggle="modal" data-bs-target="#importExcelModal">
            <i class="fa-solid fa-file-excel me-1"></i> Import Excel
        </button>
        <button type="button" class="btn btn-navy rounded-pill px-4" data-bs-toggle="modal" data-bs-target="#addQuestionModal">
            <i class="fa-solid fa-plus me-1"></i> Tambah Pertanyaan
        </button>
    </div>
</div>

<?php if(empty($questions)): ?>
    <div class="card border-0 shadow-sm rounded-3 text-center p-5">
        <i class="fa-solid fa-clipboard-question fa-3x text-muted mb-3"></i>
        <h5 class="text-dark fw-bold">Belum ada pertanyaan</h5>
        <p class="text-muted mb-0">Klik tombol Tambah Pertanyaan untuk mulai mengisi bank soal.</p>
    </div>
<?php else: ?>
    <div class="row g-3">
        <?php foreach($questions as $index => $q): ?>
        <div class="col-12">
            <div class="card border-0 shadow-sm rounded-3">
                <div class="card-body p-4">
                    <div class="d-flex justify-content-between align-items-start mb-3">
                        <div>
                            <span class="badge <?= $q->type === 'essay' ? 'bg-warning text-dark' : 'bg-info text-dark' ?> bg-opacity-10 border mb-2">
                                <?= $q->type === 'essay' ? 'Uraian (Essay)' : 'Pilihan Ganda' ?>
                            </span>
                            <span class="badge bg-secondary bg-opacity-10 text-secondary border mb-2 ms-2">Bobot: <?= $q->points ?></span>
                        </div>
                        <div class="d-flex gap-2">
                            <button type="button" class="btn btn-sm btn-link text-primary p-0" 
                                data-bs-toggle="modal" 
                                data-bs-target="#editQuestionModal"
                                data-id="<?= $q->id ?>"
                                data-type="<?= esc($q->type) ?>"
                                data-text="<?= esc($q->question_text) ?>"
                                data-points="<?= $q->points ?>"
                                data-options="<?= esc($q->options) ?>"
                                data-correct="<?= esc($q->correct_answer) ?>"
                                title="Edit Pertanyaan">
                                <i class="fa-solid fa-pen"></i>
                            </button>
                            <button type="button" class="btn btn-sm btn-link text-danger p-0 ms-2" 
                                data-bs-toggle="modal" 
                                data-bs-target="#deleteQuestionModal"
                                data-id="<?= $q->id ?>"
                                title="Hapus Pertanyaan">
                                <i class="fa-solid fa-trash"></i>
                            </button>
                        </div>
                    </div>
                    
                    <h6 class="fw-bold text-dark lh-base mb-3"><?= ($index + 1) . '. ' . nl2br(esc($q->question_text)) ?></h6>
                    
                    <?php if($q->type === 'multiple_choice' && $q->options): ?>
                        <?php $opts = json_decode($q->options, true); ?>
                        <div class="ms-3 mb-3">
                            <?php foreach(['A', 'B', 'C', 'D'] as $letter): ?>
                                <?php if(isset($opts[$letter])): ?>
                                <div class="mb-1 p-2 rounded <?= $q->correct_answer === $letter ? 'bg-success bg-opacity-10 border border-success' : 'bg-light border' ?>">
                                    <strong><?= $letter ?>.</strong> <?= esc($opts[$letter]) ?>
                                    <?php if($q->correct_answer === $letter): ?>
                                        <i class="fa-solid fa-check text-success ms-2" title="Jawaban Benar"></i>
                                    <?php endif; ?>
                                </div>
                                <?php endif; ?>
                            <?php endforeach; ?>
                        </div>
                    <?php else: ?>
                        <div class="ms-3 mb-3 p-3 bg-light border rounded">
                            <span class="fw-bold text-muted small text-uppercase mb-1 d-block">Kunci / Panduan Jawaban:</span>
                            <?= nl2br(esc($q->correct_answer)) ?>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
        <?php endforeach; ?>
    </div>
<?php endif; ?>

<!-- Modal Import Excel -->
<div class="modal fade" id="importExcelModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content border-0 shadow">
      <div class="modal-header border-bottom-0 pb-0">
        <h5 class="modal-title fw-bold">Import Soal Excel</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form action="/<?= $tenantStringId ?? session('current_tenant_string') ?>/instructor/quiz-banks/<?= $bank->id ?>/import" method="POST" enctype="multipart/form-data">
          <?= csrf_field() ?>
          <div class="modal-body">
              <p class="text-muted small">Gunakan format template Excel yang telah disediakan untuk mengimpor banyak soal secara langsung.</p>
              
              <div class="mb-3 text-center">
                  <a href="/<?= $tenantStringId ?? session('current_tenant_string') ?>/instructor/quiz-banks/download-template" class="btn btn-outline-primary btn-sm rounded-pill">
                      <i class="fa-solid fa-download me-1"></i> Unduh Template Excel
                  </a>
              </div>

              <div class="mb-3">
                  <label class="form-label fw-bold text-muted small text-uppercase">Pilih File Excel (.xlsx)</label>
                  <input type="file" name="excel_file" class="form-control" accept=".xlsx" required>
              </div>
          </div>
          <div class="modal-footer border-top-0 pt-0">
            <button type="button" class="btn btn-light" data-bs-dismiss="modal">Batal</button>
            <button type="submit" class="btn btn-success px-4"><i class="fa-solid fa-upload me-1"></i> Import Sekarang</button>
          </div>
      </form>
    </div>
  </div>
</div>

<!-- Modal Delete Question -->
<div class="modal fade" id="deleteQuestionModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content border-0 shadow">
      <div class="modal-header border-bottom-0 pb-0">
        <h5 class="modal-title fw-bold text-danger">Hapus Pertanyaan</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form id="deleteQuestionForm" method="POST">
          <?= csrf_field() ?>
          <div class="modal-body">
              <p>Apakah Anda yakin ingin menghapus pertanyaan ini? Data yang telah dihapus tidak dapat dikembalikan.</p>
          </div>
          <div class="modal-footer border-top-0 pt-0">
            <button type="button" class="btn btn-light" data-bs-dismiss="modal">Batal</button>
            <button type="submit" class="btn btn-danger px-4">Ya, Hapus</button>
          </div>
      </form>
    </div>
  </div>
</div>

<!-- Modal Add Question -->
<div class="modal fade" id="addQuestionModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-centered">
    <div class="modal-content border-0 shadow">
      <div class="modal-header border-bottom-0 pb-0">
        <h5 class="modal-title fw-bold">Tambah Pertanyaan</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form action="/<?= $tenantStringId ?? session('current_tenant_string') ?>/instructor/quiz-banks/<?= $bank->id ?>/question" method="POST">
          <?= csrf_field() ?>
          <div class="modal-body">
              <div class="row mb-3">
                  <div class="col-md-8">
                      <label class="form-label fw-bold text-muted small text-uppercase">Tipe Pertanyaan</label>
                      <select name="type" class="form-select" id="questionTypeSelect" required>
                          <option value="multiple_choice">Pilihan Ganda (Multiple Choice)</option>
                          <option value="essay">Uraian (Essay)</option>
                      </select>
                  </div>
                  <div class="col-md-4">
                      <label class="form-label fw-bold text-muted small text-uppercase">Bobot Nilai</label>
                      <input type="number" name="points" class="form-control" value="10" required>
                  </div>
              </div>
              
              <div class="mb-3">
                  <label class="form-label fw-bold text-muted small text-uppercase">Pertanyaan</label>
                  <textarea name="question_text" class="form-control" rows="3" required></textarea>
              </div>

              <!-- Multiple Choice Options -->
              <div id="mcqOptionsContainer">
                  <label class="form-label fw-bold text-muted small text-uppercase mb-2">Pilihan Jawaban (A-D)</label>
                  <div class="input-group mb-2">
                      <span class="input-group-text fw-bold">A</span>
                      <input type="text" name="option_a" class="form-control mcq-input" required>
                      <div class="input-group-text">
                          <input class="form-check-input mt-0" type="radio" name="correct_answer" value="A" required checked>
                      </div>
                  </div>
                  <div class="input-group mb-2">
                      <span class="input-group-text fw-bold">B</span>
                      <input type="text" name="option_b" class="form-control mcq-input" required>
                      <div class="input-group-text">
                          <input class="form-check-input mt-0" type="radio" name="correct_answer" value="B">
                      </div>
                  </div>
                  <div class="input-group mb-2">
                      <span class="input-group-text fw-bold">C</span>
                      <input type="text" name="option_c" class="form-control mcq-input" required>
                      <div class="input-group-text">
                          <input class="form-check-input mt-0" type="radio" name="correct_answer" value="C">
                      </div>
                  </div>
                  <div class="input-group mb-3">
                      <span class="input-group-text fw-bold">D</span>
                      <input type="text" name="option_d" class="form-control mcq-input" required>
                      <div class="input-group-text">
                          <input class="form-check-input mt-0" type="radio" name="correct_answer" value="D">
                      </div>
                  </div>
              </div>

              <!-- Essay Option -->
              <div id="essayOptionContainer" style="display:none;">
                  <label class="form-label fw-bold text-muted small text-uppercase">Kunci / Panduan Jawaban</label>
                  <textarea name="essay_answer_key" class="form-control essay-input" rows="3"></textarea>
                  <div class="form-text">Bisa berupa kata kunci atau penjelasan ringkas jawaban benar.</div>
              </div>

          </div>
          <div class="modal-footer border-top-0 pt-0">
            <button type="button" class="btn btn-light" data-bs-dismiss="modal">Batal</button>
            <button type="submit" class="btn btn-navy px-4">Simpan Pertanyaan</button>
          </div>
      </form>
    </div>
  </div>
</div>

<!-- Modal Edit Question -->
<div class="modal fade" id="editQuestionModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-centered">
    <div class="modal-content border-0 shadow">
      <div class="modal-header border-bottom-0 pb-0">
        <h5 class="modal-title fw-bold">Edit Pertanyaan</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form id="editQuestionForm" method="POST">
          <?= csrf_field() ?>
          <div class="modal-body">
              <div class="row mb-3">
                  <div class="col-md-8">
                      <label class="form-label fw-bold text-muted small text-uppercase">Tipe Pertanyaan</label>
                      <select name="type" class="form-select" id="editQuestionTypeSelect" required>
                          <option value="multiple_choice">Pilihan Ganda (Multiple Choice)</option>
                          <option value="essay">Uraian (Essay)</option>
                      </select>
                  </div>
                  <div class="col-md-4">
                      <label class="form-label fw-bold text-muted small text-uppercase">Bobot Nilai</label>
                      <input type="number" name="points" id="editQuestionPoints" class="form-control" required>
                  </div>
              </div>
              
              <div class="mb-3">
                  <label class="form-label fw-bold text-muted small text-uppercase">Pertanyaan</label>
                  <textarea name="question_text" id="editQuestionText" class="form-control" rows="3" required></textarea>
              </div>

              <!-- Multiple Choice Options -->
              <div id="editMcqOptionsContainer">
                  <label class="form-label fw-bold text-muted small text-uppercase mb-2">Pilihan Jawaban (A-D)</label>
                  <div class="input-group mb-2">
                      <span class="input-group-text fw-bold">A</span>
                      <input type="text" name="option_a" id="editOptionA" class="form-control edit-mcq-input">
                      <div class="input-group-text">
                          <input class="form-check-input mt-0" type="radio" name="correct_answer" id="editCorrectA" value="A">
                      </div>
                  </div>
                  <div class="input-group mb-2">
                      <span class="input-group-text fw-bold">B</span>
                      <input type="text" name="option_b" id="editOptionB" class="form-control edit-mcq-input">
                      <div class="input-group-text">
                          <input class="form-check-input mt-0" type="radio" name="correct_answer" id="editCorrectB" value="B">
                      </div>
                  </div>
                  <div class="input-group mb-2">
                      <span class="input-group-text fw-bold">C</span>
                      <input type="text" name="option_c" id="editOptionC" class="form-control edit-mcq-input">
                      <div class="input-group-text">
                          <input class="form-check-input mt-0" type="radio" name="correct_answer" id="editCorrectC" value="C">
                      </div>
                  </div>
                  <div class="input-group mb-3">
                      <span class="input-group-text fw-bold">D</span>
                      <input type="text" name="option_d" id="editOptionD" class="form-control edit-mcq-input">
                      <div class="input-group-text">
                          <input class="form-check-input mt-0" type="radio" name="correct_answer" id="editCorrectD" value="D">
                      </div>
                  </div>
              </div>

              <!-- Essay Option -->
              <div id="editEssayOptionContainer" style="display:none;">
                  <label class="form-label fw-bold text-muted small text-uppercase">Kunci / Panduan Jawaban</label>
                  <textarea name="essay_answer_key" id="editEssayKey" class="form-control edit-essay-input" rows="3"></textarea>
              </div>

          </div>
          <div class="modal-footer border-top-0 pt-0">
            <button type="button" class="btn btn-light" data-bs-dismiss="modal">Batal</button>
            <button type="submit" class="btn btn-navy px-4">Update Pertanyaan</button>
          </div>
      </form>
    </div>
  </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Add Question Logic
    const typeSelect = document.getElementById('questionTypeSelect');
    const mcqContainer = document.getElementById('mcqOptionsContainer');
    const essayContainer = document.getElementById('essayOptionContainer');
    const mcqInputs = document.querySelectorAll('.mcq-input');
    const essayInput = document.querySelector('.essay-input');
    const radioInputs = document.querySelectorAll('input[type="radio"][name="correct_answer"]');

    if(typeSelect) {
        typeSelect.addEventListener('change', function() {
            if(this.value === 'essay') {
                mcqContainer.style.display = 'none';
                essayContainer.style.display = 'block';
                mcqInputs.forEach(input => input.removeAttribute('required'));
                radioInputs.forEach(input => input.removeAttribute('required'));
                essayInput.setAttribute('required', 'required');
            } else {
                mcqContainer.style.display = 'block';
                essayContainer.style.display = 'none';
                mcqInputs.forEach(input => input.setAttribute('required', 'required'));
                radioInputs.forEach(input => input.setAttribute('required', 'required'));
                essayInput.removeAttribute('required');
            }
        });
    }

    // Delete Question Logic
    const deleteModal = document.getElementById('deleteQuestionModal');
    if(deleteModal) {
        deleteModal.addEventListener('show.bs.modal', function(event) {
            const button = event.relatedTarget;
            const id = button.getAttribute('data-id');
            const form = document.getElementById('deleteQuestionForm');
            form.action = '/<?= $tenantStringId ?? session('current_tenant_string') ?>/instructor/quiz-banks/question/' + id + '/delete';
        });
    }

    // Edit Question Logic
    const editModal = document.getElementById('editQuestionModal');
    const editTypeSelect = document.getElementById('editQuestionTypeSelect');
    const editMcqContainer = document.getElementById('editMcqOptionsContainer');
    const editEssayContainer = document.getElementById('editEssayOptionContainer');
    const editMcqInputs = document.querySelectorAll('.edit-mcq-input');
    const editEssayInput = document.querySelector('.edit-essay-input');
    const editRadioInputs = document.querySelectorAll('#editMcqOptionsContainer input[type="radio"][name="correct_answer"]');

    if(editTypeSelect) {
        editTypeSelect.addEventListener('change', function() {
            if(this.value === 'essay') {
                editMcqContainer.style.display = 'none';
                editEssayContainer.style.display = 'block';
                editMcqInputs.forEach(input => input.removeAttribute('required'));
                editRadioInputs.forEach(input => input.removeAttribute('required'));
                editEssayInput.setAttribute('required', 'required');
            } else {
                editMcqContainer.style.display = 'block';
                editEssayContainer.style.display = 'none';
                editMcqInputs.forEach(input => input.setAttribute('required', 'required'));
                editRadioInputs.forEach(input => input.setAttribute('required', 'required'));
                editEssayInput.removeAttribute('required');
            }
        });
    }

    if(editModal) {
        editModal.addEventListener('show.bs.modal', function(event) {
            const button = event.relatedTarget;
            const id = button.getAttribute('data-id');
            const type = button.getAttribute('data-type');
            const text = button.getAttribute('data-text');
            const points = button.getAttribute('data-points');
            const optionsRaw = button.getAttribute('data-options');
            const correct = button.getAttribute('data-correct');

            const form = document.getElementById('editQuestionForm');
            form.action = '/<?= $tenantStringId ?? session('current_tenant_string') ?>/instructor/quiz-banks/question/' + id + '/update';

            document.getElementById('editQuestionText').value = text;
            document.getElementById('editQuestionPoints').value = points;
            editTypeSelect.value = type;

            if (type === 'multiple_choice') {
                let opts = {};
                try {
                    if (optionsRaw) opts = JSON.parse(optionsRaw);
                } catch(e) {}
                
                document.getElementById('editOptionA').value = opts.A || '';
                document.getElementById('editOptionB').value = opts.B || '';
                document.getElementById('editOptionC').value = opts.C || '';
                document.getElementById('editOptionD').value = opts.D || '';
                
                if (correct === 'A') document.getElementById('editCorrectA').checked = true;
                if (correct === 'B') document.getElementById('editCorrectB').checked = true;
                if (correct === 'C') document.getElementById('editCorrectC').checked = true;
                if (correct === 'D') document.getElementById('editCorrectD').checked = true;

                editMcqContainer.style.display = 'block';
                editEssayContainer.style.display = 'none';
                editMcqInputs.forEach(input => input.setAttribute('required', 'required'));
                editRadioInputs.forEach(input => input.setAttribute('required', 'required'));
                editEssayInput.removeAttribute('required');
            } else {
                document.getElementById('editEssayKey').value = correct || '';

                editMcqContainer.style.display = 'none';
                editEssayContainer.style.display = 'block';
                editMcqInputs.forEach(input => input.removeAttribute('required'));
                editRadioInputs.forEach(input => input.removeAttribute('required'));
                editEssayInput.setAttribute('required', 'required');
            }
        });
    }
});
</script>

<?= $this->endSection() ?>
