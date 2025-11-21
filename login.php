<html>

<head>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>

    <link href="https://fonts.googleapis.com/css2?family=Inter:ital,opsz,wght@0,14..32,100..900;1,14..32,100..900&family=Ubuntu:ital,wght@0,300;0,400;0,500;0,700;1,300;1,400;1,500;1,700&display=swap" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
    <style>
        * {
            font-family: "Inter", "Courier" !important;
        }

        .glassmorphism-element {
            backdrop-filter: blur(50px) saturate(180%);
            -webkit-backdrop-filter: blur(50px) saturate(180%);
            background: rgba(30, 41, 59, 0.15);
            border-radius: 20px;
            border: 1px solid rgba(100, 116, 139, 0.2);
            box-shadow: 0px 12px 40px 0 rgba(2, 6, 23, 0.3),
                inset 0 0 120px rgba(79, 70, 229, 0.08),
                inset 0px 0px 4px 2px rgba(255, 255, 255, 0.1);
        }

        /* Reflection overlay for realism using pseudo-elements */
        .glassmorphism-element::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            pointer-events: none;
            border-radius: inherit;
            background: linear-gradient(to left top, rgba(255, 255, 255, 0.5) 0%, rgba(255, 255, 255, 0) 50%);
            z-index: 1;
        }

        .glassmorphism-element::after {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            pointer-events: none;
            border-radius: inherit;
            background: linear-gradient(to bottom, rgba(255, 255, 255, 0.3) 0%, rgba(255, 255, 255, 0) 100%);
            z-index: 1;
        }
    </style>
</head>

<!--
  This example requires updating your template:

  ```
  <html class="h-full bg-gray-900">
  <body class="h-full">
  ```
-->
<!-- <div class="min-h-screen flex items-center justify-center bg-cover bg-center" style="border: solid; background-image: url(assets/group-diverse-grads-throwing-caps-up-sky.jpg)">
        <div class="glassmorphism-element flex h-[max-content] w-[max-content] flex-col justify-center px-6 py-12 lg:px-8 m-8">

            <div class="max-w-lg w-full overflow-hidden transition-all duration-500 ease-in-out">
                <div class="">
                    <div class="mt-10 sm:mx-auto sm:w-full sm:max-w-sm flex-1 form-section">
                        <div class="sm:mx-auto sm:w-full sm:max-w-sm">
                            <img src="assets\water_3410476.png" alt="Jev-Glossarium" class="mx-auto h-10 w-auto" />
                            <h2 class="mt-10 text-center text-2xl/9 font-bold tracking-tight text-black">Sign in to your account</h2>
                        </div>
                        <form action="backend/process.php" method="POST" class="space-y-6">
                            <div>
                                <label for="user" class="block text-sm/6 font-medium text-white">Username</label>
                                <div class="mt-2">
                                    <input id="user-sign-in" type="text" name="user-sign-in" required autocomplete="user" class="block w-full rounded-md bg-white/5 px-3 py-1.5 text-base text-white outline-1 -outline-offset-1 outline-white/10 placeholder:text-gray-500 focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-500 sm:text-sm/6" />
                                </div>
                            </div>

                            <div>
                                <div class="flex items-center justify-between">
                                    <label for="password" class="block text-sm/6 font-medium text-white">Password</label>
                                    <div class="text-sm">
                                        <a href="#" class="font-semibold text-indigo-400 hover:text-indigo-300">Forgot password?</a>
                                    </div>
                                </div>
                                <div class="mt-2">
                                    <input id="password-sign-in" type="password" name="password-sign-in" required autocomplete="current-password" class="block w-full rounded-md bg-white/5 px-3 py-1.5 text-base text-white outline-1 -outline-offset-1 outline-white/10 placeholder:text-gray-500 focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-500 sm:text-sm/6" />
                                </div>
                            </div>

                            <div>
                                <button type="submit" name="sign-in" class="flex w-full justify-center rounded-md bg-indigo-500 px-3 py-1.5 text-sm/6 font-semibold text-white hover:bg-indigo-400 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-500">Sign in</button>
                            </div>
                        </form>

                        <p class="mt-10 text-center text-sm/6 text-gray-400">
                            Don't have an account?
                            <a href="#" class="font-semibold text-indigo-400 hover:text-indigo-300 toSignup">Sign up</a>
                        </p>
                    </div>
                    <div class="mt-10 sm:mx-auto sm:w-full sm:max-w-sm flex-1 form-section">
                        <div class="sm:mx-auto sm:w-full sm:max-w-sm">
                            <img src="assets\water_3410476.png" alt="Jev-Glossarium" class="mx-auto h-10 w-auto" />
                            <h2 class="mt-10 text-center text-2xl/9 font-bold tracking-tight text-black">Get started!</h2>
                        </div>
                        <form action="backend/process.php" method="POST" class="space-y-6">
                            <div>
                                <label for="user" class="block text-sm/6 font-medium text-white">Username</label>
                                <div class="mt-2">
                                    <input id="user-sign-up" type="text" name="user-sign-up" required autocomplete="user" class="block w-full rounded-md bg-white/5 px-3 py-1.5 text-base text-white outline-1 -outline-offset-1 outline-white/10 placeholder:text-gray-500 focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-500 sm:text-sm/6" />
                                </div>
                            </div>

                            <div>
                                <div class="flex items-center justify-between">
                                    <label for="password" class="block text-sm/6 font-medium text-white">Password</label>
                                </div>
                                <div class="mt-2">
                                    <input id="password-sign-up" type="password" name="password-sign-up" required autocomplete="current-password" class="block w-full rounded-md bg-white/5 px-3 py-1.5 text-base text-white outline-1 -outline-offset-1 outline-white/10 placeholder:text-gray-500 focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-500 sm:text-sm/6" />
                                </div>
                            </div>

                            <div>
                                <div class="flex items-center justify-between">
                                    <label for="password" class="block text-sm/6 font-medium text-white">Confirm Password</label>
                                </div>
                                <div class="mt-2">
                                    <input id="password-confirm" type="password-confirm" name="password-sign-up" required autocomplete="current-password" class="block w-full rounded-md bg-white/5 px-3 py-1.5 text-base text-white outline-1 -outline-offset-1 outline-white/10 placeholder:text-gray-500 focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-500 sm:text-sm/6" />
                                </div>
                            </div>

                            <div>
                                <button type="submit" name="sign-up" class="flex w-full justify-center rounded-md bg-indigo-500 px-3 py-1.5 text-sm/6 font-semibold text-white hover:bg-indigo-400 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-500">Sign in</button>
                            </div>
                        </form>

                        <p class="mt-10 text-center text-sm/6 text-gray-400">
                            Already have an account?
                            <a href="#" class="font-semibold text-indigo-400 hover:text-indigo-300 toSignup">Sign in</a>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div> -->

<body class="">
    <div class="min-h-screen flex items-center justify-center bg-cover bg-center" style="border: solid; background-image: url('assets/group-diverse-grads-throwing-caps-up-sky.jpg')">
        <div class="glassmorphism-element flex flex-col justify-center px-6 py-12 lg:px-8 m-8">
            <div class="w-full sm:max-w-sm overflow-hidden">
                <div id="slider-track" class="flex transition-transform duration-500 ease-in-out" style="width: 200%;">

                    <div class="w-1/2 flex-shrink-0 px-4">
                        <div class="sm:mx-auto sm:w-full sm:max-w-sm">
                            <img src="assets\water_3410476.png" alt="Jev-Glossarium" class="mx-auto h-10 w-auto" />
                            <h2 class="mt-10 text-center text-2xl/9 font-bold tracking-tight text-black">Sign in to your account</h2>
                        </div>
                        <form action="backend/process.php" method="POST" class="space-y-6 mt-10">
                            <div>
                                <label for="user-sign-in" class="block text-sm/6 font-medium text-white">Username</label>
                                <div class="mt-2">
                                    <input id="user-sign-in" type="text" name="user-sign-in" required autocomplete="user" class="block w-full rounded-md bg-white/5 px-3 py-1.5 text-base text-white outline-1 -outline-offset-1 outline-white/10 placeholder:text-gray-500 focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-500 sm:text-sm/6" />
                                </div>
                            </div>

                            <div>
                                <div class="flex items-center justify-between">
                                    <label for="password-sign-in" class="block text-sm/6 font-medium text-white">Password</label>
                                    <div class="text-sm">
                                        <a href="#" class="font-semibold text-indigo-400 hover:text-indigo-300">Forgot password?</a>
                                    </div>
                                </div>
                                <div class="mt-2">
                                    <input id="password-sign-in" type="password" name="password-sign-in" required autocomplete="current-password" class="block w-full rounded-md bg-white/5 px-3 py-1.5 text-base text-white outline-1 -outline-offset-1 outline-white/10 placeholder:text-gray-500 focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-500 sm:text-sm/6" />
                                </div>
                            </div>

                            <div>
                                <button type="submit" name="sign-in" class="flex w-full justify-center rounded-md bg-indigo-500 px-3 py-1.5 text-sm/6 font-semibold text-white hover:bg-indigo-400 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-500">Sign in</button>
                            </div>
                        </form>

                        <p class="mt-10 text-center text-sm/6 text-gray-400">
                            Don't have an account?
                            <button type="button" id="go-to-signup" class="font-semibold text-indigo-400 hover:text-indigo-300 cursor-pointer">Sign up</button>
                        </p>
                    </div>

                    <div class="w-1/2 flex-shrink-0 px-4">
                        <div class="sm:mx-auto sm:w-full sm:max-w-sm">
                            <img src="assets\water_3410476.png" alt="Jev-Glossarium" class="mx-auto h-10 w-auto" />
                            <h2 class="mt-10 text-center text-2xl/9 font-bold tracking-tight text-black">Get started!</h2>
                        </div>
                        <form action="backend/process.php" method="POST" class="space-y-6 mt-10">
                            <div>
                                <label for="user-sign-up" class="block text-sm/6 font-medium text-white">Username</label>
                                <div class="mt-2">
                                    <input id="user-sign-up" type="text" name="user-sign-up" required autocomplete="user" class="block w-full rounded-md bg-white/5 px-3 py-1.5 text-base text-white outline-1 -outline-offset-1 outline-white/10 placeholder:text-gray-500 focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-500 sm:text-sm/6" />
                                </div>
                            </div>

                            <div class="flex items-center justify-between">
                                <label for="role-selection" class="block text-sm/6 font-medium text-white">I am a...</label>
                                <div class="mt-2">
                                    <select class="text-white" name="role-selection" id="roles">
                                        <option value="instructor">Instructor</option>
                                        <option value="student">Student</option>
                                    </select>
                                </div>
                            </div>

                            <div>
                                <div class="flex items-center justify-between">
                                    <label for="password-sign-up" class="block text-sm/6 font-medium text-white">Password</label>
                                </div>
                                <div class="mt-2">
                                    <input id="password-sign-up" type="password" name="password-sign-up" required autocomplete="new-password" class="block w-full rounded-md bg-white/5 px-3 py-1.5 text-base text-white outline-1 -outline-offset-1 outline-white/10 placeholder:text-gray-500 focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-500 sm:text-sm/6" />
                                </div>
                            </div>

                            <div>
                                <div class="flex items-center justify-between">
                                    <label for="password-confirm" class="block text-sm/6 font-medium text-white">Confirm Password</label>
                                </div>
                                <div class="mt-2">
                                    <input id="password-confirm" type="password" name="password-confirm" required autocomplete="new-password" class="block w-full rounded-md bg-white/5 px-3 py-1.5 text-base text-white outline-1 -outline-offset-1 outline-white/10 placeholder:text-gray-500 focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-500 sm:text-sm/6" />
                                </div>
                            </div>

                            <div>
                                <button type="submit" name="sign-up" class="flex w-full justify-center rounded-md bg-indigo-500 px-3 py-1.5 text-sm/6 font-semibold text-white hover:bg-indigo-400 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-500">Sign up</button>
                            </div>
                        </form>

                        <p class="mt-10 text-center text-sm/6 text-gray-400">
                            Already have an account?
                            <button type="button" id="go-to-signin" class="font-semibold text-indigo-400 hover:text-indigo-300 cursor-pointer">Sign in</button>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        const track = document.getElementById('slider-track');
        const btnToSignup = document.getElementById('go-to-signup');
        const btnToSignin = document.getElementById('go-to-signin');

        function showSignup() {
            track.style.transform = 'translateX(-50%)';
        }

        function showSignin() {
            track.style.transform = 'translateX(0)';
        }

        // Aku nak login
        btnToSignup.addEventListener('click', (e) => {
            e.preventDefault(); // Ape benda nii?
            track.style.transform = 'translateX(-50%)';
        });

        // Aku nak ikot
        btnToSignin.addEventListener('click', (e) => {
            e.preventDefault();
            track.style.transform = 'translateX(0)';
        });

        const urlParams = new URLSearchParams(window.location.search);
        if (urlParams.get('view') === 'signup') {
            showSignup();
        }
    </script>
</body>

</html>