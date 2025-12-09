<aside id="sidebar" class="fixed inset-y-0 left-0 flex-wrap w-64 px-4 pb-4 lg:m-4 overflow-y-auto bg-white shadow-xl rounded-2xl transform transition-transform xl:translate-x-0 custom-scrollbar z-99 -translate-x-full top-2 bottom-2 lg:top-0 lg:bottom-0">
    <!-- Logo Sticky -->
    <div id="logo" class="sticky top-0 z-10 bg-white flex flex-col">
      <a href="/" class="flex items-center px-4 py-5 text-slate-700">
        <img src="/img/logo.png" class="h-8" alt="Logo" />
      </a>
      <hr class="h-[1px] w-full border-none bg-gradient-to-r from-transparent via-slate-400 to-transparent opacity-40">
    </div>

    <!-- Tambahkan padding bawah agar tidak tertutup elemen sticky -->
    <ul class="space-y-2 pb-16 mt-3">
      <li>
        <a href="/" class="{{ Request::is('/') ? 'active' : '' }} flex items-center px-4 py-2 rounded-lg transition hover:bg-gray-200">
          <i class="fas fa-tv text-blue-500 w-6"></i>
          <span class="ml-2">Dashboard</span>
        </a>
      </li>
      <li x-data="{ open: {{ Request::is('master*') || Request::is('users*') || Request::is('branches*') || Request::is('pillars*') ? 'true' : 'false' }} }">
          <button 
              @click="open = !open" 
              class="{{ Request::is('master*') || Request::is('users*') || Request::is('branches*') || Request::is('pillars*') ? 'active' : '' }} 
              flex items-center justify-between px-4 py-2 w-full rounded-lg transition hover:bg-gray-200">

              <div class="flex items-center">
                  <i class="fa-solid fa-server text-emerald-500 w-6"></i>
                  <span class="ml-2">Data Master</span>
              </div>

              <i 
                  :class="open ? 'rotate-90' : ''" 
                  class="fas fa-chevron-right transition-transform duration-300">
              </i>
          </button>

          <ul 
              x-show="open" 
              x-transition
              class="pl-6 space-y-2 rounded-lg overflow-hidden mt-2"
          >
              <li>
                  <a 
                      href="/users" 
                      class="{{ Request::is('users*') ? 'active' : '' }} flex items-center px-4 py-2 rounded-lg transition hover:bg-gray-200">
                      
                      <i class="fas fa-users text-orange-500 w-6"></i>
                      <span class="ml-2">Data Users</span>
                  </a>
              </li>
              <li>
                  <a 
                      href="/branches" 
                      class="{{ Request::is('branches*') ? 'active' : '' }} flex items-center px-4 py-2 rounded-lg transition hover:bg-gray-200">
                      
                      <i class="fa-solid fa-code-branch text-orange-500 w-6"></i>
                      <span class="ml-2">Data Cabang</span>
                  </a>
              </li>
              @if (Auth::user()->role == "credit" || "admin")
                <li>
                    <a 
                        href="/pillars" 
                        class="{{ Request::is('pillars*') ? 'active' : '' }} flex items-center px-4 py-2 rounded-lg transition hover:bg-gray-200">
                        
                        <i class="fa-solid fa-layer-group text-orange-500 w-6"></i>
                        <span class="ml-2">Data Pilar</span>
                    </a>
                </li>
              @endif
          </ul>
      </li>

      <li>
        <a href="#" class="flex items-center px-4 py-2 rounded-lg transition hover:bg-gray-200">
          <i class="fa-solid fa-database text-purple-500 w-6"></i>
          <span class="ml-2">Database</span>
        </a>
      </li>
      <li x-data="{ open: {{ Request::is('loans*') || Request::is('loan_reports*') ? 'true' : 'false' }} }">
          <button 
              @click="open = !open" 
              class="{{ Request::is('loans*') || Request::is('loan_register*') ? 'active' : '' }} 
              flex items-center justify-between px-4 py-2 w-full rounded-lg transition hover:bg-gray-200">

              <div class="flex items-center">
                  <i class="fa-solid fa-credit-card text-green-500 w-6 -ml-1"></i>
                  <span class="ml-3">Data Kredit</span>
              </div>

              <i 
                  :class="open ? 'rotate-90' : ''" 
                  class="fas fa-chevron-right transition-transform duration-300">
              </i>
          </button>

          <ul 
              x-show="open" 
              x-transition
              class="pl-6 space-y-2 rounded-lg overflow-hidden mt-2"
          >
              @if (Auth::user()->role == "credit" || "admin")
                <li>
                    <a 
                        href="/loans" 
                        class="{{ Request::is('loans*') ? 'active' : '' }} flex items-center px-4 py-2 rounded-lg transition hover:bg-gray-200">
                        
                        <i class="fa-solid fa-list text-orange-500 w-6"></i>
                        <span class="ml-2">Register Kredit</span>
                    </a>
                </li>
              @endif

              @if (Auth::user()->role == "credit" || "admin")
                <li>
                    <a 
                        href="/loan_reports" 
                        class="{{ Request::is('loan_reports*') ? 'active' : '' }} flex items-center px-4 py-2 rounded-lg transition hover:bg-gray-200">
                        
                        <i class="fa-solid fa-file-lines text-orange-500 w-6"></i>
                        <span class="ml-2">Laporan Kredit</span>
                    </a>
                </li>
              @endif
          </ul>
      </li>
      <li>
        <a href="#" class="flex items-center px-4 py-2 rounded-lg transition hover:bg-gray-200">
          <i class="fa-solid fa-location-dot text-yellow-500 w-6"></i>
          <span class="ml-2">Data Kunjungan</span>
        </a>
      </li>
      <li>
        <a href="#" class="flex items-center px-4 py-2 rounded-lg transition hover:bg-gray-200">
          <i class="fa-solid fa-clipboard-list text-sky-500 w-6"></i>
          <span class="ml-2">Data Rencana Kerja</span>
        </a>
      </li>
      <li>
        <a href="#" class="flex items-center px-4 py-2 rounded-lg transition hover:bg-gray-200">
          <i class="fa-solid fa-square-poll-vertical text-fuchsia-500 w-6"></i>
          <span class="ml-2">Data Laporan</span>
        </a>
      </li>
      <hr class="h-[1px] w-full border-none bg-gradient-to-r from-transparent via-slate-400 to-transparent opacity-40 my-5">
      <li>
        <a href="/profil" class="flex items-center px-4 py-2 rounded-lg transition hover:bg-gray-200">
          <i class="fas fa-user text-orange-500 w-6"></i>
          <span class="ml-2">Profil</span>
        </a>
      </li>
      <li>
        <a href="{{ route('logout') }}" class="flex items-center px-4 py-2 rounded-lg transition hover:bg-gray-200">
          <i class="fas fa-right-from-bracket text-red-500 w-6"></i>
          <span class="ml-2">Logout</span>
        </a>
      </li>      
    </ul>
  </aside>