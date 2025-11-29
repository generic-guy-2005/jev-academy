<section class="p-16 mb-32 bg-gray-50">
    <div class="grid grid-cols-[1fr_2fr] gap-6">
        <div class="bg-white p-0 rounded-xl shadow aspect-video">
            <div class="block w-full h-40 p-0 m-0 object-cover [border-top-left-radius:10px] [border-top-right-radius:10px] bg-green-600 flex items-center justify-center">
                <img class="h-20" src="assets\shield.png" alt="">
            </div>
            <h1 class="p-6 text-xl">We Protect Your Transaction!</h1>
            <a href="index.php?page=payment&id=<?= $_GET['id'] ?>"><button class="px-6 py-2 m-2 rounded-full bg-blue-600 text-white hover:bg-blue-400">Cancel</button></a>
        </div>
        <div class="bg-white p-6 rounded-xl shadow">
            <h1 class="text-2xl">Top Up</h1>
            <hr>
            <form action="backend/transaction.php" method="post" class="mt-2">
                <input type="hidden" name="id" value="<?= $_GET['id'] ?>">
                <div>
                    <label for="top-up-amount" class="block text-sm/6 text-black">Amount</label>
                    <div class="mt-2 shadow">
                        <input id="top-up-amount" type="number" name="top-up-amount" placeholder="0" required class="block w-full rounded-md bg-white/5 px-3 py-1.5 text-base text-black outline-1 -outline-offset-1 outline-white/10 placeholder:text-gray-500 focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-500 sm:text-sm/6 border-solid" />
                    </div>
                </div>
                <div>
                    <label for="top-up-pass" class="block text-sm/6 text-black">Password</label>
                    <div class="mt-2 shadow">
                        <input id="top-up-amount" type="password" name="top-up-pass" required class="block w-full rounded-md bg-white/5 px-3 py-1.5 text-base text-black outline-1 -outline-offset-1 outline-white/10 placeholder:text-gray-500 focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-500 sm:text-sm/6 border-solid" />
                    </div>
                </div>
                <div>
                    <label for="confirmation" class="block text-sm/6 text-black">Confirm Password</label>
                    <div class="mt-2 shadow">
                        <input id="top-up-amount" type="password" name="confirmation" required class="block w-full rounded-md bg-white/5 px-3 py-1.5 text-base text-black outline-1 -outline-offset-1 outline-white/10 placeholder:text-gray-500 focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-500 sm:text-sm/6 border-solid" />
                    </div>
                </div>
                <div>
                    <button type="submit" name="top-up" class="flex w-full justify-center rounded-md bg-indigo-500 px-3 py-1.5 mt-3 text-sm/6 font-semibold text-white hover:bg-indigo-400 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-500">Top Up</button>
                </div>
            </form>
        </div>
    </div>
</section>