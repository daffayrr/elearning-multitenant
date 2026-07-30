<?= $this->extend('instructor/layout') ?>

<?= $this->section('content') ?>

<div class="mb-4">
    <a href="/<?= $tenantStringId ?? session('current_tenant_string') ?>/instructor/scoring" class="btn btn-outline-secondary btn-sm mb-3">
        <i class="fa-solid fa-arrow-left me-1"></i> Kembali ke Daftar Penilaian
    </a>
    
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h4 class="fw-bold m-0 text-dark"><i class="fa-solid fa-table-list me-2 text-primary"></i> Tabel Nilai: <?= esc($course->title) ?></h4>
        <a href="/<?= $tenantStringId ?? session('current_tenant_string') ?>/instructor/scoring/<?= $course->id ?>/export" class="btn btn-success rounded-pill px-4 shadow-sm">
            <i class="fa-solid fa-file-excel me-1"></i> Export Excel
        </a>
    </div>
</div>

<div class="card border-0 shadow-sm rounded-3">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-bordered table-hover mb-0 align-middle text-center">
                <thead class="table-light">
                    <tr>
                        <th class="py-3 text-start px-4 align-middle" style="min-width: 250px;">Nama Siswa</th>
                        <?php foreach($assignments as $ass): ?>
                            <th class="py-3 align-middle" style="min-width: 150px;">
                                <div class="fw-bold text-dark text-truncate" style="max-width: 150px;" title="<?= esc($ass->title) ?>">
                                    <?= esc($ass->title) ?>
                                </div>
                                <span class="badge bg-secondary bg-opacity-10 text-secondary border mt-1">
                                    <?= ucfirst($ass->type) ?>
                                </span>
                            </th>
                        <?php endforeach; ?>
                        <?php if(empty($assignments)): ?>
                            <th class="py-3 text-muted fw-normal">Belum ada tugas/kuis di kelas ini</th>
                        <?php endif; ?>
                    </tr>
                </thead>
                <tbody>
                    <?php if(empty($students)): ?>
                    <tr>
                        <td colspan="<?= count($assignments) + 1 ?>" class="text-center py-5 text-muted">Belum ada siswa terdaftar di tenant ini.</td>
                    </tr>
                    <?php else: ?>
                        <?php foreach($students as $student): ?>
                        <tr>
                            <td class="text-start px-4">
                                <div class="fw-bold text-dark"><?= esc($student->full_name) ?></div>
                                <div class="text-muted small"><?= esc($student->email) ?></div>
                            </td>
                            
                            <?php foreach($assignments as $ass): ?>
                                <?php 
                                    $key = $student->id . '_' . $ass->id;
                                    $sub = $submissions[$key] ?? null;
                                    $score = $sub && $sub->score !== null ? $sub->score : '-';
                                ?>
                                <td>
                                    <?php if($score === '-'): ?>
                                        <span class="text-muted">-</span>
                                    <?php else: ?>
                                        <span class="badge <?= $score >= 70 ? 'bg-success' : 'bg-danger' ?> bg-opacity-10 <?= $score >= 70 ? 'text-success border-success' : 'text-danger border-danger' ?> border px-3 py-2" style="font-size: 14px;">
                                            <?= $score ?>
                                        </span>
                                    <?php endif; ?>
                                </td>
                            <?php endforeach; ?>
                            
                            <?php if(empty($assignments)): ?>
                                <td>-</td>
                            <?php endif; ?>
                        </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<div class="mt-4 text-muted small">
    <i class="fa-solid fa-circle-info me-1"></i>
    Tabel ini menampilkan nilai dari seluruh siswa yang terdaftar di sistem. Untuk mengedit atau memberi nilai manual pada tugas uraian (essay) dan pengumpulan (submission), Anda dapat mengkliknya langsung pada modul tugas masing-masing di halaman <a href="/<?= $tenantStringId ?? session('current_tenant_string') ?>/instructor/courses">Manajemen Kelas</a> (Fitur penilaian manual per tugas akan tersedia pada pembaruan mendatang).
</div>

<?= $this->endSection() ?>
