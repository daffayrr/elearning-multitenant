<?= $this->extend('student/layout') ?>

<?= $this->section('content') ?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h4 class="fw-bold mb-1 text-dark"><?= esc($assignment->title) ?></h4>
        <p class="text-muted small mb-0"><i class="fa-regular fa-clock me-1"></i> Tenggat Waktu: <?= date('d M Y, H:i', strtotime($assignment->due_date)) ?></p>
    </div>
    <div>
        <div class="badge bg-primary fs-5 px-3 py-2 rounded-pill shadow-sm" id="cbt-timer">00:00:00</div>
    </div>
</div>

<div class="row g-4">
    <!-- Left Column: Questions -->
    <div class="col-lg-8">
        <form id="cbtForm" action="/<?= $tenantStringId ?? session('current_tenant_string') ?>/student/exams/submit/<?= $assignment->id ?>" method="POST">
            <?= csrf_field() ?>
            <div class="card border-0 shadow-sm mb-4 rounded-3">
                <div class="card-header bg-white py-3 border-bottom d-flex justify-content-between align-items-center">
                    <h6 class="fw-bold m-0 text-dark"><i class="fa-solid fa-clipboard-question me-2 text-warning"></i> Soal Ujian</h6>
                    <span class="badge bg-light text-dark border">Total: <?= count($questions) ?> Butir</span>
                </div>
                <div class="card-body p-4">
                    <?php if(empty($questions)): ?>
                        <div class="text-center py-5">
                            <i class="fa-solid fa-box-open fa-3x text-muted mb-3"></i>
                            <p class="text-muted">Belum ada soal untuk ujian ini.</p>
                        </div>
                    <?php else: ?>
                        <?php foreach($questions as $index => $q): ?>
                            <div class="question-container" id="question-<?= $index + 1 ?>" style="display: <?= $index === 0 ? 'block' : 'none' ?>;">
                                <div class="mb-4">
                                    <h5 class="fw-bold mb-3"><span class="badge bg-navy me-2"><?= $index + 1 ?></span></h5>
                                    <div class="fs-6 text-dark lh-lg mb-4">
                                        <?= $q->question_text ?>
                                    </div>
                                </div>
                                <div class="options-group">
                                    <?php if($q->type === 'essay'): ?>
                                        <div class="mb-3 mt-4">
                                            <label class="form-label text-muted fw-bold small text-uppercase">Jawaban Anda:</label>
                                            <textarea class="form-control bg-white shadow-sm custom-textarea border-0 p-3" name="answer[<?= $q->id ?>]" rows="6" placeholder="Ketikkan jawaban Anda di sini..." oninput="markAnswered(<?= $index + 1 ?>)"></textarea>
                                        </div>
                                    <?php else: ?>
                                        <?php 
                                            $options = [];
                                            if (!empty($q->options)) {
                                                $decoded = json_decode($q->options, true);
                                                if (is_array($decoded)) {
                                                    $options = $decoded;
                                                }
                                            }
                                        ?>
                                        <?php foreach($options as $key => $opt): ?>
                                            <?php if(!empty($opt)): ?>
                                                <div class="form-check custom-radio mb-3 p-3 border rounded-3 text-dark bg-white shadow-sm" onclick="selectRadio(this)">
                                                    <input class="form-check-input ms-1 mt-1" type="radio" name="answer[<?= $q->id ?>]" id="q<?= $q->id ?>_opt<?= $key ?>" value="<?= $key ?>" onchange="markAnswered(<?= $index + 1 ?>)">
                                                    <label class="form-check-label ms-2 d-block w-100" for="q<?= $q->id ?>_opt<?= $key ?>" style="cursor: pointer;">
                                                        <span class="fw-bold me-2"><?= $key ?>.</span> <?= esc($opt) ?>
                                                    </label>
                                                </div>
                                            <?php endif; ?>
                                        <?php endforeach; ?>
                                    <?php endif; ?>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </div>
                <?php if(!empty($questions)): ?>
                <div class="card-footer bg-white border-top py-3 px-4 d-flex justify-content-between">
                    <button type="button" class="btn btn-outline-secondary px-4" id="btnPrev" onclick="navQuestion(-1)" disabled><i class="fa-solid fa-arrow-left me-1"></i> Sebelumnya</button>
                    <button type="button" class="btn btn-navy px-4" id="btnNext" onclick="navQuestion(1)">Selanjutnya <i class="fa-solid fa-arrow-right ms-1"></i></button>
                </div>
                <?php endif; ?>
            </div>
        </form>
    </div>

    <!-- Right Column: Navigation -->
    <div class="col-lg-4">
        <div class="card border-0 shadow-sm rounded-3 sticky-top" style="top: 100px; z-index: 10;">
            <div class="card-header bg-white py-3 border-bottom">
                <h6 class="fw-bold m-0 text-dark"><i class="fa-solid fa-table-cells-large me-2"></i> Navigasi Soal</h6>
            </div>
            <div class="card-body p-3">
                <div class="d-flex flex-wrap gap-2 mb-4">
                    <?php for($i = 1; $i <= count($questions); $i++): ?>
                        <button type="button" class="btn btn-outline-secondary p-0 fw-bold nav-square" id="nav-btn-<?= $i ?>" onclick="jumpToQuestion(<?= $i ?>)" style="width: 40px; height: 40px;">
                            <?= $i ?>
                        </button>
                    <?php endfor; ?>
                </div>
                
                <div class="alert alert-info small border-0 bg-primary bg-opacity-10 text-primary">
                    <i class="fa-solid fa-circle-info me-1"></i> Pastikan Anda telah menjawab seluruh soal sebelum mengumpulkan ujian.
                </div>
                
                <button type="button" class="btn btn-success w-100 fw-bold rounded-pill shadow-sm" onclick="finishExam()">
                    <i class="fa-solid fa-paper-plane me-1"></i> Kumpulkan Ujian
                </button>
            </div>
        </div>
    </div>
</div>

<style>
    .custom-radio { transition: all 0.2s ease; border-color: var(--border-color) !important; }
    .custom-radio:hover { background-color: var(--table-hover) !important; border-color: var(--primary-navy) !important; }
    .custom-radio.selected { background-color: var(--active-blue) !important; border-color: var(--primary-navy) !important; }
    .custom-textarea { border: 1px solid var(--border-color) !important; transition: all 0.2s ease; }
    .custom-textarea:focus { border-color: var(--primary-navy) !important; box-shadow: 0 0 0 0.2rem rgba(13, 33, 65, 0.1) !important; }
    .nav-square.active { background-color: var(--primary-navy) !important; color: white !important; border-color: var(--primary-navy) !important; }
    .nav-square.answered { background-color: #198754 !important; color: white !important; border-color: #198754 !important; }
    .nav-square.answered.active { box-shadow: 0 0 0 0.25rem rgba(25, 135, 84, 0.5); }
    .bg-navy { background-color: var(--primary-navy); }
    .btn-navy { background-color: var(--primary-navy); color: white; }
    .btn-navy:hover { background-color: #1a3a6c; color: white; }
</style>

<script>
    let currentQuestion = 1;
    const totalQuestions = <?= count($questions) ?>;

    function selectRadio(element) {
        document.querySelectorAll('.custom-radio').forEach(el => el.classList.remove('selected'));
        element.classList.add('selected');
        const radio = element.querySelector('input[type="radio"]');
        if (radio) {
            radio.checked = true;
            radio.dispatchEvent(new Event('change'));
        }
    }

    function markAnswered(index) {
        const navBtn = document.getElementById('nav-btn-' + index);
        if (navBtn) {
            navBtn.classList.add('answered');
        }
    }

    function updateNavButtons() {
        document.querySelectorAll('.nav-square').forEach(btn => btn.classList.remove('active'));
        const activeBtn = document.getElementById('nav-btn-' + currentQuestion);
        if (activeBtn) activeBtn.classList.add('active');

        const btnPrev = document.getElementById('btnPrev');
        const btnNext = document.getElementById('btnNext');
        
        if (btnPrev) btnPrev.disabled = currentQuestion === 1;
        if (btnNext) btnNext.disabled = currentQuestion === totalQuestions;
    }

    function showQuestion(index) {
        document.querySelectorAll('.question-container').forEach(el => el.style.display = 'none');
        const qContainer = document.getElementById('question-' + index);
        if (qContainer) {
            qContainer.style.display = 'block';
            currentQuestion = index;
            updateNavButtons();
            
            // Highlight selected option if returning to a question
            const selectedInput = qContainer.querySelector('input[type="radio"]:checked');
            if(selectedInput) {
                document.querySelectorAll('.custom-radio').forEach(el => el.classList.remove('selected'));
                selectedInput.closest('.custom-radio').classList.add('selected');
            } else {
                document.querySelectorAll('.custom-radio').forEach(el => el.classList.remove('selected'));
            }
        }
    }

    function navQuestion(dir) {
        let next = currentQuestion + dir;
        if (next >= 1 && next <= totalQuestions) {
            showQuestion(next);
        }
    }

    function jumpToQuestion(index) {
        showQuestion(index);
    }

    function finishExam() {
        if(confirm('Apakah Anda yakin ingin menyelesaikan dan mengumpulkan ujian ini? Anda tidak dapat mengubah jawaban setelah ini.')) {
            document.getElementById('cbtForm').submit();
        }
    }

    // Initialize
    document.addEventListener('DOMContentLoaded', () => {
        if (totalQuestions > 0) {
            updateNavButtons();
        }
        
        // Timer simulation (90 mins)
        let time = 90 * 60;
        setInterval(() => {
            if (time <= 0) {
                document.getElementById('cbtForm').submit();
                return;
            }
            time--;
            let h = Math.floor(time / 3600);
            let m = Math.floor((time % 3600) / 60);
            let s = Math.floor(time % 60);
            document.getElementById('cbt-timer').innerText = 
                String(h).padStart(2, '0') + ':' + 
                String(m).padStart(2, '0') + ':' + 
                String(s).padStart(2, '0');
        }, 1000);
    });
</script>

<?= $this->endSection() ?>
