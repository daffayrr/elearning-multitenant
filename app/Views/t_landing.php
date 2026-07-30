<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cloud LMS Multi-Tenant</title>
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
    <script src="https://cdn.jsdelivr.net/npm/@tailwindplus/elements@1" type="module"></script>
</head>

<body>

    <div class="bg-white">
        <header class="absolute inset-x-0 top-0 z-50">
            <nav aria-label="Global" class="flex items-center justify-between p-6 lg:px-8">
                <div class="flex lg:flex-1">
                    <a href="#" class="-m-1.5 p-1.5">
                        <span class="sr-only">LMS Multi-Tenant</span>
                        <img src="https://toscaflow.id/uploads/logo/1777701079_46ba47bebcd16f265c44.png" alt=""
                            class="h-8 w-auto" />
                    </a>
                </div>
                <div class="flex lg:hidden">
                    <button type="button" command="show-modal" commandfor="mobile-menu"
                        class="-m-2.5 inline-flex items-center justify-center rounded-md p-2.5 text-gray-700">
                        <span class="sr-only">Open main menu</span>
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" data-slot="icon"
                            aria-hidden="true" class="size-6">
                            <path d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5" stroke-linecap="round"
                                stroke-linejoin="round" />
                        </svg>
                    </button>
                </div>
                <div class="hidden lg:flex lg:gap-x-12">
                    <a href="#" class="text-sm/6 font-semibold text-gray-900">Produk</a>
                    <a href="#feature" class="text-sm/6 font-semibold text-gray-900">Fitur</a>
                    <a href="#" class="text-sm/6 font-semibold text-gray-900">Institusi</a>
                    <a href="#" class="text-sm/6 font-semibold text-gray-900">Tentang Kami</a>
                </div>
                <div class="hidden lg:flex lg:flex-1 lg:justify-end gap-x-4">
                    <a href="/register-institution" class="text-sm/6 font-semibold text-indigo-600 hover:text-indigo-500">Daftar Institusi</a>
                    <a href="/login" class="text-sm/6 font-semibold text-gray-900">Log in <span
                            aria-hidden="true">&rarr;</span></a>
                </div>
            </nav>
            <el-dialog>
                <dialog id="mobile-menu" class="backdrop:bg-transparent lg:hidden">
                    <div tabindex="0" class="fixed inset-0 focus:outline-none">
                        <el-dialog-panel
                            class="fixed inset-y-0 right-0 z-50 w-full overflow-y-auto bg-white p-6 sm:max-w-sm sm:ring-1 sm:ring-gray-900/10">
                            <div class="flex items-center justify-between">
                                <a href="#" class="-m-1.5 p-1.5">
                                    <span class="sr-only">LMS Multi-Tenant</span>
                                    <img src="https://toscaflow.id/uploads/logo/1777701079_46ba47bebcd16f265c44.png"
                                        alt="" class="h-8 w-auto" />
                                </a>
                                <button type="button" command="close" commandfor="mobile-menu"
                                    class="-m-2.5 rounded-md p-2.5 text-gray-700">
                                    <span class="sr-only">Close menu</span>
                                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"
                                        data-slot="icon" aria-hidden="true" class="size-6">
                                        <path d="M6 18 18 6M6 6l12 12" stroke-linecap="round" stroke-linejoin="round" />
                                    </svg>
                                </button>
                            </div>
                            <div class="mt-6 flow-root">
                                <div class="-my-6 divide-y divide-gray-500/10">
                                    <div class="space-y-2 py-6">
                                        <a href="#"
                                            class="-mx-3 block rounded-lg px-3 py-2 text-base/7 font-semibold text-gray-900 hover:bg-gray-50">Produk</a>
                                        <a href="#feature"
                                            class="-mx-3 block rounded-lg px-3 py-2 text-base/7 font-semibold text-gray-900 hover:bg-gray-50">Fitur</a>
                                        <a href="#"
                                            class="-mx-3 block rounded-lg px-3 py-2 text-base/7 font-semibold text-gray-900 hover:bg-gray-50">Institusi</a>
                                        <a href="#"
                                            class="-mx-3 block rounded-lg px-3 py-2 text-base/7 font-semibold text-gray-900 hover:bg-gray-50">Tentang Kami</a>
                                    </div>
                                    <div class="py-6">
                                        <a href="/register-institution"
                                            class="-mx-3 block rounded-lg px-3 py-2.5 text-base/7 font-semibold text-indigo-600 hover:bg-gray-50">Daftar Institusi</a>
                                        <a href="/login"
                                            class="-mx-3 block rounded-lg px-3 py-2.5 text-base/7 font-semibold text-gray-900 hover:bg-gray-50">Log
                                            in</a>
                                    </div>
                                </div>
                            </div>
                        </el-dialog-panel>
                    </div>
                </dialog>
            </el-dialog>
        </header>

        <div class="relative isolate px-6 pt-14 lg:px-8">
            <div aria-hidden="true"
                class="absolute inset-x-0 -top-40 -z-10 transform-gpu overflow-hidden blur-3xl sm:-top-80">
                <div style="clip-path: polygon(74.1% 44.1%, 100% 61.6%, 97.5% 26.9%, 85.5% 0.1%, 80.7% 2%, 72.5% 32.5%, 60.2% 62.4%, 52.4% 68.1%, 47.5% 58.3%, 45.2% 34.5%, 27.5% 76.7%, 0.1% 64.9%, 17.9% 100%, 27.6% 76.8%, 76.1% 97.7%, 74.1% 44.1%)"
                    class="relative left-[calc(50%-11rem)] aspect-1155/678 w-144.5 -translate-x-1/2 rotate-30 bg-linear-to-tr from-[#ff80b5] to-[#9089fc] opacity-30 sm:left-[calc(50%-30rem)] sm:w-288.75">
                </div>
            </div>
            <div class="mx-auto max-w-2xl py-32 sm:py-48 lg:py-56">
                <div class="hidden sm:mb-8 sm:flex sm:justify-center">
                    <div
                        class="relative rounded-full px-3 py-1 text-sm/6 text-gray-600 ring-1 ring-gray-900/10 hover:ring-gray-900/20">
                        Memperkenalkan platform e-learning modern. <a href="#feature" class="font-semibold text-indigo-600"><span
                                aria-hidden="true" class="absolute inset-0"></span>Pelajari lebih lanjut <span
                                aria-hidden="true">&rarr;</span></a>
                    </div>
                </div>
                <div class="text-center">
                    <h1 class="text-5xl font-semibold tracking-tight text-balance text-gray-900 sm:text-7xl">Platform E-Learning Multi-Tenant</h1>
                    <p class="mt-8 text-lg font-medium text-pretty text-gray-500 sm:text-xl/8">Sistem LMS berbasis cloud yang tangguh dan dinamis, dirancang khusus untuk memfasilitasi kebutuhan institusi modern dengan ekosistem pembelajaran terintegrasi.</p>
                    <div class="mt-10 flex items-center justify-center gap-x-6">
                        <a href="/register-institution"
                            class="rounded-md bg-indigo-600 px-3.5 py-2.5 text-sm font-semibold text-white shadow-xs hover:bg-indigo-500 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">Buat Tenant Baru</a>
                        <a href="/login" class="text-sm/6 font-semibold text-gray-900">Login Tenant <span
                                aria-hidden="true">→</span></a>
                    </div>
                </div>
            </div>
            <div aria-hidden="true"
                class="absolute inset-x-0 top-[calc(100%-13rem)] -z-10 transform-gpu overflow-hidden blur-3xl sm:top-[calc(100%-30rem)]">
                <div style="clip-path: polygon(74.1% 44.1%, 100% 61.6%, 97.5% 26.9%, 85.5% 0.1%, 80.7% 2%, 72.5% 32.5%, 60.2% 62.4%, 52.4% 68.1%, 47.5% 58.3%, 45.2% 34.5%, 27.5% 76.7%, 0.1% 64.9%, 17.9% 100%, 27.6% 76.8%, 76.1% 97.7%, 74.1% 44.1%)"
                    class="relative left-[calc(50%+3rem)] aspect-1155/678 w-144.5 -translate-x-1/2 bg-linear-to-tr from-[#ff80b5] to-[#9089fc] opacity-30 sm:left-[calc(50%+36rem)] sm:w-288.75">
                </div>
            </div>
        </div>
    </div>

    <!-- FEATURE SECTION -->
    <div class="overflow-hidden bg-white py-24 sm:py-32" id="feature">
        <div class="mx-auto max-w-7xl px-6 lg:px-8">
            <div
                class="mx-auto grid max-w-2xl grid-cols-1 gap-x-8 gap-y-16 sm:gap-y-20 lg:mx-0 lg:max-w-none lg:grid-cols-2">
                <div class="lg:pt-4 lg:pr-8">
                    <div class="lg:max-w-lg">
                        <h2 class="text-base/7 font-semibold text-indigo-600">Fitur Unggulan</h2>
                        <p class="mt-2 text-4xl font-semibold tracking-tight text-pretty text-gray-900 sm:text-5xl">Ekosistem Pembelajaran Lengkap</p>
                        <p class="mt-6 text-lg/8 text-gray-700">Dapatkan pengalaman belajar dan mengajar terbaik dengan fitur lengkap, dari manajemen kursus hingga sistem ujian yang terintegrasi.
                        </p>
                        <dl class="mt-10 max-w-xl space-y-8 text-base/7 text-gray-600 lg:max-w-none">
                            <div class="relative pl-9">
                                <dt class="inline font-semibold text-gray-900">
                                    <svg viewBox="0 0 20 20" fill="currentColor" data-slot="icon" aria-hidden="true"
                                        class="absolute top-1 left-1 size-5 text-indigo-600">
                                        <path
                                            d="M5.5 17a4.5 4.5 0 0 1-1.44-8.765 4.5 4.5 0 0 1 8.302-3.046 3.5 3.5 0 0 1 4.504 4.272A4 4 0 0 1 15 17H5.5Zm3.75-2.75a.75.75 0 0 0 1.5 0V9.66l1.95 2.1a.75.75 0 1 0 1.1-1.02l-3.25-3.5a.75.75 0 0 0-1.1 0l-3.25 3.5a.75.75 0 1 0 1.1 1.02l1.95-2.1v4.59Z"
                                            clip-rule="evenodd" fill-rule="evenodd" />
                                    </svg>
                                    Multi-Tenant Terisolasi.
                                </dt>
                                <dd class="inline">Setiap institusi memiliki lingkungan pembelajaran mandiri, aman, dan dapat disesuaikan dengan kebutuhan.</dd>
                            </div>
                            <div class="relative pl-9">
                                <dt class="inline font-semibold text-gray-900">
                                    <svg viewBox="0 0 20 20" fill="currentColor" data-slot="icon" aria-hidden="true"
                                        class="absolute top-1 left-1 size-5 text-indigo-600">
                                        <path
                                            d="M10 1a4.5 4.5 0 0 0-4.5 4.5V9H5a2 2 0 0 0-2 2v6a2 2 0 0 0 2 2h10a2 2 0 0 0 2-2v-6a2 2 0 0 0-2-2h-.5V5.5A4.5 4.5 0 0 0 10 1Zm3 8V5.5a3 3 0 1 0-6 0V9h6Z"
                                            clip-rule="evenodd" fill-rule="evenodd" />
                                    </svg>
                                    Manajemen Kursus & Kelas.
                                </dt>
                                <dd class="inline">Buat kursus, kelola pendaftaran siswa, dan pantau perkembangan pembelajaran dengan mudah dan efisien.</dd>
                            </div>
                            <div class="relative pl-9">
                                <dt class="inline font-semibold text-gray-900">
                                    <svg viewBox="0 0 20 20" fill="currentColor" data-slot="icon" aria-hidden="true"
                                        class="absolute top-1 left-1 size-5 text-indigo-600">
                                        <path
                                            d="M4.632 3.533A2 2 0 0 1 6.577 2h6.846a2 2 0 0 1 1.945 1.533l1.976 8.234A3.489 3.489 0 0 0 16 11.5H4c-.476 0-.93.095-1.344.267l1.976-8.234Z" />
                                        <path
                                            d="M4 13a2 2 0 1 0 0 4h12a2 2 0 1 0 0-4H4Zm11.24 2a.75.75 0 0 1 .75-.75H16a.75.75 0 0 1 .75.75v.01a.75.75 0 0 1-.75.75h-.01a.75.75 0 0 1-.75-.75V15Zm-2.25-.75a.75.75 0 0 0-.75.75v.01c0 .414.336.75.75.75H13a.75.75 0 0 0 .75-.75V15a.75.75 0 0 0-.75-.75h-.01Z"
                                            clip-rule="evenodd" fill-rule="evenodd" />
                                    </svg>
                                    Sistem Ujian Terintegrasi (CBT).
                                </dt>
                                <dd class="inline">Fasilitas ujian online dengan bank soal, penilaian otomatis, dan laporan hasil belajar yang komprehensif.</dd>
                            </div>
                        </dl>
                    </div>
                </div>
                <img width="2432" height="1442"
                    src="https://tailwindcss.com/plus-assets/img/component-images/project-app-screenshot.png"
                    alt="Product screenshot"
                    class="w-3xl max-w-none rounded-xl shadow-xl ring-1 ring-gray-400/10 sm:w-228 md:-ml-4 lg:ml-0" />
            </div>
        </div>
    </div>

    <!-- TECH STACK INFO -->
    <div class="bg-white py-24 sm:py-32">
        <div class="mx-auto max-w-7xl px-6 lg:px-8">
          <h2 class="text-center text-lg/8 font-semibold text-gray-900">Dipercaya oleh berbagai institusi terkemuka</h2>
          <div class="mx-auto mt-10 grid max-w-lg grid-cols-4 items-center gap-x-8 gap-y-10 sm:max-w-xl sm:grid-cols-6 sm:gap-x-10 lg:mx-0 lg:max-w-none lg:grid-cols-5 opacity-50">
            <img width="158" height="48" src="https://tailwindcss.com/plus-assets/img/logos/158x48/transistor-logo-gray-900.svg" alt="Transistor" class="col-span-2 max-h-12 w-full object-contain lg:col-span-1" />
            <img width="158" height="48" src="https://tailwindcss.com/plus-assets/img/logos/158x48/reform-logo-gray-900.svg" alt="Reform" class="col-span-2 max-h-12 w-full object-contain lg:col-span-1" />
            <img width="158" height="48" src="https://tailwindcss.com/plus-assets/img/logos/158x48/tuple-logo-gray-900.svg" alt="Tuple" class="col-span-2 max-h-12 w-full object-contain lg:col-span-1" />
            <img width="158" height="48" src="https://tailwindcss.com/plus-assets/img/logos/158x48/savvycal-logo-gray-900.svg" alt="SavvyCal" class="col-span-2 max-h-12 w-full object-contain sm:col-start-2 lg:col-span-1" />
            <img width="158" height="48" src="https://tailwindcss.com/plus-assets/img/logos/158x48/statamic-logo-gray-900.svg" alt="Statamic" class="col-span-2 col-start-2 max-h-12 w-full object-contain sm:col-start-auto lg:col-span-1" />
          </div>
        </div>
      </div>

    <!-- CTA SECTION -->
    <div class="bg-white">
        <div class="mx-auto max-w-7xl py-24 sm:px-6 sm:py-32 lg:px-8">
          <div class="relative isolate overflow-hidden bg-gray-900 px-6 pt-16 shadow-2xl sm:rounded-3xl sm:px-16 md:pt-24 lg:flex lg:gap-x-20 lg:px-24 lg:pt-0">
            <svg viewBox="0 0 1024 1024" aria-hidden="true" class="absolute top-1/2 left-1/2 -z-10 size-256 -translate-y-1/2 mask-[radial-gradient(closest-side,white,transparent)] sm:left-full sm:-ml-80 lg:left-1/2 lg:ml-0 lg:-translate-x-1/2 lg:translate-y-0">
              <circle r="512" cx="512" cy="512" fill="url(#759c1415-0410-454c-8f7c-9a820de03641)" fill-opacity="0.7" />
              <defs>
                <radialGradient id="759c1415-0410-454c-8f7c-9a820de03641">
                  <stop stop-color="#7775D6" />
                  <stop offset="1" stop-color="#E935C1" />
                </radialGradient>
              </defs>
            </svg>
            <div class="mx-auto max-w-md text-center lg:mx-0 lg:flex-auto lg:py-32 lg:text-left">
              <h2 class="text-3xl font-semibold tracking-tight text-balance text-white sm:text-4xl">Tingkatkan efisiensi pembelajaran Anda.</h2>
              <p class="mt-6 text-lg/8 text-pretty text-gray-300">Bergabunglah dengan ratusan institusi yang telah menggunakan platform e-learning kami untuk menyukseskan pembelajaran digital.</p>
              <div class="mt-10 flex items-center justify-center gap-x-6 lg:justify-start">
                <a href="/register-institution" class="rounded-md bg-white px-3.5 py-2.5 text-sm font-semibold text-gray-900 shadow-xs hover:bg-gray-100 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-white"> Buat Tenant Baru </a>
                <a href="/login" class="text-sm/6 font-semibold text-white hover:text-gray-100">
                  Login Institusi
                  <span aria-hidden="true">→</span>
                </a>
              </div>
            </div>
            <div class="relative mt-16 h-80 lg:mt-8">
              <img width="1824" height="1080" src="https://tailwindcss.com/plus-assets/img/component-images/dark-project-app-screenshot.png" alt="App screenshot" class="absolute top-0 left-0 w-228 max-w-none rounded-md bg-white/5 ring-1 ring-white/10" />
            </div>
          </div>
        </div>
      </div>

      <!-- FOOTER SECTION -->
      <footer class="bg-white">
        <div class="mx-auto max-w-7xl px-4 py-16 sm:px-6 lg:px-8">
          <div class="lg:flex lg:items-start lg:gap-8">
            <div class="text-teal-600">
              <img
                class="h-8"
                fill="none"
              >
            </img>
            </div>
      
            <div class="mt-8 grid grid-cols-2 gap-8 lg:mt-0 lg:grid-cols-5 lg:gap-y-16">
              <div class="col-span-2">
                <div>
                  <img class="text-2xl font-bold text-gray-900" src="https://toscaflow.id/uploads/logo/1777701079_46ba47bebcd16f265c44.png"></img>
      
                  <p class="mt-4 text-gray-500">
                    Platform e-learning terdepan untuk institusi pendidikan dan korporat, menawarkan ekosistem mandiri dengan performa terbaik.
                  </p>
                </div>
              </div>
      
              <div class="col-span-2 lg:col-span-3 lg:flex lg:items-end">
                
              </div>
      
              <div class="col-span-2 sm:col-span-1">
                <p class="font-medium text-gray-900">Layanan</p>
      
                <ul class="mt-6 space-y-4 text-sm">
                  <li>
                    <a href="#" class="text-gray-700 transition hover:opacity-75"> Manajemen LMS </a>
                  </li>
      
                  <li>
                    <a href="#" class="text-gray-700 transition hover:opacity-75"> Pelatihan IT </a>
                  </li>
      
                  <li>
                    <a href="#" class="text-gray-700 transition hover:opacity-75"> Server Khusus </a>
                  </li>
                </ul>
              </div>
      
              <div class="col-span-2 sm:col-span-1">
                <p class="font-medium text-gray-900">Perusahaan</p>
      
                <ul class="mt-6 space-y-4 text-sm">
                  <li>
                    <a href="#" class="text-gray-700 transition hover:opacity-75"> Tentang Kami </a>
                  </li>
      
                  <li>
                    <a href="#" class="text-gray-700 transition hover:opacity-75"> Tim Kami </a>
                  </li>
      
                  <li>
                    <a href="#" class="text-gray-700 transition hover:opacity-75"> Karir </a>
                  </li>
                </ul>
              </div>
      
              <div class="col-span-2 sm:col-span-1">
                <p class="font-medium text-gray-900">Bantuan</p>
      
                <ul class="mt-6 space-y-4 text-sm">
                  <li>
                    <a href="#" class="text-gray-700 transition hover:opacity-75"> Kontak </a>
                  </li>
      
                  <li>
                    <a href="#" class="text-gray-700 transition hover:opacity-75"> FAQ </a>
                  </li>
      
                  <li>
                    <a href="#" class="text-gray-700 transition hover:opacity-75"> Live Chat </a>
                  </li>
                </ul>
              </div>
      
              <div class="col-span-2 sm:col-span-1">
                <p class="font-medium text-gray-900">Legal</p>
      
                <ul class="mt-6 space-y-4 text-sm">
                  <li>
                    <a href="#" class="text-gray-700 transition hover:opacity-75"> Syarat & Ketentuan </a>
                  </li>
      
                  <li>
                    <a href="#" class="text-gray-700 transition hover:opacity-75"> Kebijakan Privasi </a>
                  </li>
                </ul>
              </div>
      
              <ul class="col-span-2 flex justify-start gap-6 lg:col-span-5 lg:justify-end">
                <!-- Social Icons -->
                <li>
                  <a
                    href="#"
                    rel="noreferrer"
                    target="_blank"
                    class="text-gray-700 transition hover:opacity-75"
                  >
                    <span class="sr-only">Facebook</span>
                    <svg class="size-6" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                      <path fill-rule="evenodd" d="M22 12c0-5.523-4.477-10-10-10S2 6.477 2 12c0 4.991 3.657 9.128 8.438 9.878v-6.987h-2.54V12h2.54V9.797c0-2.506 1.492-3.89 3.777-3.89 1.094 0 2.238.195 2.238.195v2.46h-1.26c-1.243 0-1.63.771-1.63 1.562V12h2.773l-.443 2.89h-2.33v6.988C18.343 21.128 22 16.991 22 12z" clip-rule="evenodd" />
                    </svg>
                  </a>
                </li>
              </ul>
            </div>
          </div>
      
          <div class="mt-8 border-t border-gray-100 pt-8">
            <div class="sm:flex sm:justify-between">
              <p class="text-xs text-gray-500">&copy; 2026. Cloud LMS. All rights reserved.</p>
            </div>
          </div>
        </div>
      </footer>

</body>

</html>
