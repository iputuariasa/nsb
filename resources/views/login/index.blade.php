<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    @vite('resources/css/app.css')
    <title>LOGIN - NSB</title>
</head>
<body class="rounded-lg h-screen w-screen">
  <div class="flex flex-col mx-auto bg-slate-100 rounded-lg h-full w-full relative">
    <div class="flex justify-center w-full h-full my-auto xl:gap-14 lg:justify-normal md:gap-5">
      <div class="flex items-center justify-center w-full">
        <div class="flex items-center p-6 xl:p-10 w-full md:w-1/2 xl:w-1/3">
          <form method="post" action="/login" class="flex flex-col w-full h-full p-8 text-center rounded-3xl shadow bg-white">
            @csrf
            <h3 class="mb-3 text-4xl font-extrabold text-gray-900">Sign In</h3>
            <p class="mb-4 text-gray-700">Enter your email and password</p>
            <div class="flex items-center mb-3">
              <hr class="border-b border-gray-500 grow">
            </div>
            <label for="email" class="mb-2 text-sm text-start text-gray-900">Email*</label>
            <input id="email" type="email" name="email" placeholder="mail@example.com" class="w-full px-5 py-4 mb-7 text-sm font-medium bg-gray-200 rounded-2xl placeholder-gray-500 text-gray-900 outline-none focus:bg-gray-300"/>
            <label for="password" class="mb-2 text-sm text-start text-gray-900">Password*</label>
            <input id="password" type="password" name="password" placeholder="Enter a password" class="w-full px-5 py-4 mb-5 text-sm font-medium bg-gray-200 rounded-2xl placeholder-gray-500 text-gray-900 outline-none focus:bg-gray-300"/>
            <div class="flex justify-between mb-8">
              <label class="inline-flex items-center cursor-pointer">
                <input type="checkbox" name="remember" class="sr-only peer">
                <div class="w-5 h-5 bg-white border-2 rounded-sm border-gray-500 peer-checked:border-0 peer-checked:bg-indigo-500 flex items-center justify-center">
                  <img src="https://raw.githubusercontent.com/Loopple/loopple-public-assets/main/motion-tailwind/img/icons/check.png" alt="tick">
                </div>
                <span class="ml-3 text-sm font-normal text-gray-900">Keep me logged in</span>
              </label>
              <a href="#" class="text-sm font-medium text-indigo-500 hover:text-indigo-600">Forget password?</a>
            </div>
            <button type="submit" class="w-full px-6 py-5 mb-5 text-sm font-bold text-white bg-indigo-500 rounded-2xl hover:bg-indigo-600 focus:ring-4 focus:ring-indigo-200">Sign In</button>
            <p class="text-sm text-gray-900">Not registered yet? <a href="#" class="font-bold text-gray-700 hover:text-gray-900">Request an Account</a></p>
          </form>
        </div>
      </div>
    </div>

    @if (session()->has('error'))
        <div class="absolute right-0 top-3 flex items-center p-4 mb-4 text-sm text-red-800 rounded-lg bg-red-50" role="alert">
            <svg class="shrink-0 inline w-4 h-4 me-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
            <path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 0 1 1 1v4h1a1 1 0 0 1 0 2Z"/>
            </svg>
            <span class="sr-only">Info</span>
            <div>
            <span class="font-medium">{{ session('error') }}</span>
            </div>
        </div>
    @endif
    @if (session()->has('success'))
        <div class="absolute inset-0 right-0 top-3 flex items-center p-4 mb-4 text-sm text-orange-800 rounded-lg bg-orange-50" role="alert">
            <svg class="shrink-0 inline w-4 h-4 me-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
            <path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 0 1 1 1v4h1a1 1 0 0 1 0 2Z"/>
            </svg>
            <span class="sr-only">Info</span>
            <div>
            <span class="font-medium">Success! </span> {{ session('success') }}
            </div>
        </div>
    @endif
  </div>
</body>
</html>