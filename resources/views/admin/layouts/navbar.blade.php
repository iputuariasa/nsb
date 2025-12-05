<nav class="fixed top-2 lg:left-68.5 mx-3 lg:right-0 z-50 lg:mx-3 flex flex-wrap items-center justify-between px-0 py-2 shadow-md lg:flex-nowrap lg:justify-start rounded-2xl bgBlur w-[calc(100%-1.5rem)] lg:w-auto bg-white">

    <div class="relative flex items-center justify-between w-full px-4 py-1 mx-auto flex-wrap-inherit">
      <nav>
        <!-- Breadcrumb -->
        <ol class="flex flex-wrap pt-1 mr-12 bg-transparent rounded-lg sm:mr-16">
            <li class="text-sm leading-normal">
                <div class="opacity-50 text-slate-700 inline-block"
                    x-data="clock()" 
                    x-init="start()" 
                    class="text-xl font-mono"
                    x-text="time">
                </div>
            </li>
        </ol>
        <h6 class="mb-0 font-bold capitalize">{{ $title }}</h6>
      </nav>

      <!-- Mobile User Button -->
      <div x-data="{ openMobile: false }" class="absolute hidden left-1/2 transform -translate-x-1/2 justify-center items-center">
        <img src="{{ asset('img/user.png') }}" alt="" class="lg:w-8 w-10 cursor-pointer" @click.prevent="openMobile = !openMobile">
        
        <!-- Modal (Mobile) -->
        <div x-show="openMobile" @click.outside="openMobile = false" x-transition class="absolute top-full mt-2 bg-white shadow-lg rounded-lg border border-gray-300 p-2 w-60 z-50">
          <div class="flex justify-center flex-col items-center">
              <img src="{{ asset('img/user.png') }}" alt="" class="w-20">
              <span class="font-semibold text-wrap text-center mb-1">{{ auth()->user()->name }}</span>
          </div>
          <hr class="h-[1px] my-2 w-full border-none bg-gradient-to-r from-transparent via-slate-400 to-transparent opacity-40">
          <div class="mb-3 flex justify-around">
              <a href="" class="bg-orange-400 px-3 py-1 rounded-md text-white text-sm"><i class="fas fa-user mr-2"></i>Profile</a>
              <a href="{{ route('logout') }}" class="bg-red-600 px-3 py-1 rounded-md text-white text-sm"><i class="fas fa-right-from-bracket mr-2"></i>Logout</a>
          </div>
        </div>
      </div>

      <div class="relative flex items-center space-x-3">
        <!-- Search (Desktop) -->
        <!-- PAKAI INI DI navbar.blade.php — PASTI JALAN -->
        <div class="hidden lg:flex items-center relative w-64" x-data>
            <span class="absolute left-3 flex h-full items-center text-slate-500 pointer-events-none">
                <i class="fas fa-search"></i>
            </span>

            <input
                type="text"
                placeholder="Cari data..."
                class="w-full pl-10 pr-10 py-2 text-sm rounded-lg border border-gray-300 bg-white text-gray-700 placeholder:text-gray-500 focus:outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-200 transition"
                autocomplete="off"

                x-init="
                    $el.value = $store.globalSearch.query;
                    $el.addEventListener('input', (e) => {
                        $store.globalSearch.query = e.target.value;
                    });
                "

                @input="$store.globalSearch.query = $event.target.value"
            >

            <!-- Tombol X -->
            <button 
                type="button"
                @click="$store.globalSearch.query = ''; $el.focus()"
                x-show="$store.globalSearch.query !== ''"
                class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 hover:text-gray-700 z-10">
                <i class="fas fa-times text-xs"></i>
            </button>
        </div>

        <!-- Desktop User Button -->
        <div x-data="{ openDesktop: false }" class="relative hidden lg:flex justify-center items-center">
          <img src="{{ asset('img/user.png') }}" alt="" class="w-8 cursor-pointer hidden lg:inline-block" @click.prevent="openDesktop = !openDesktop">

          <!-- Modal (Desktop) -->
          <div x-show="openDesktop" @click.outside="openDesktop = false" x-transition 
            class="absolute top-12 right-0 bg-white shadow-lg rounded-lg border border-gray-300 p-2 w-60 z-50">
            <div class="flex justify-center flex-col items-center">
              <img src="{{ asset('img/user.png') }}" alt="" class="w-20 mt-3">
              <span class="font-semibold text-wrap text-center mt-2 mb-1">{{ auth()->user()->name }}</span>
            </div>
            <hr class="h-[1px] my-2 w-full border-none bg-gradient-to-r from-transparent via-slate-400 to-transparent opacity-40">
            <div class="mb-3 flex justify-around">
              <a href="" class="bg-orange-400 px-3 py-1 rounded-md text-white text-sm"><i class="fas fa-user mr-2"></i>Profile</a>
              <a href="{{ route('logout') }}" class="bg-red-600 px-3 py-1 rounded-md text-white text-sm"><i class="fas fa-right-from-bracket mr-2"></i>Logout</a>
            </div>
          </div>
        </div>

        <!-- Hamburger Menu (Mobile) -->
        <button id="menuToggle" class="text-white bg-blue-600 p-1 w-10 h-10 rounded-md lg:hidden">
          <i id="menuIcon" class="fas fa-bars text-2xl transition-transform duration-300"></i>
        </button>
      </div>
    </div>
  </nav>