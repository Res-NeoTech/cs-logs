<!doctype html>
<html lang="en" data-theme="dark">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>404 - Page Not Found</title>
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
    <link href="https://cdn.jsdelivr.net/npm/daisyui@5" rel="stylesheet" type="text/css" />
</head>

<body class="min-h-screen bg-slate-950 text-slate-100 antialiased">
    <main class="flex min-h-screen flex-col">

        <!-- HEADER -->
        <header class="sticky top-0 z-50 border-b border-slate-800 bg-slate-950/80 backdrop-blur">
            <div class="mx-auto flex max-w-6xl items-center justify-between px-4 py-4">
                <div class="flex items-center gap-2">
                    <div class="h-9 w-9 rounded-lg bg-indigo-500/20 text-indigo-400 grid place-items-center font-bold">
                        CL
                    </div>
                    <span class="text-lg font-semibold tracking-tight">
                        CS-<span class="text-indigo-400">Logs</span>
                    </span>
                </div>

                <nav class="hidden gap-6 text-sm text-slate-300 md:flex">
                    <a href="/" class="hover:text-white transition">Home</a>
                </nav>
            </div>
        </header>

        <!-- CONTENT -->
        <section class="flex-1">
            <div class="mx-auto max-w-6xl px-4 py-8">

                <!-- PAGE TITLE -->
                <div class="mb-8">
                    <h1 class="text-2xl font-bold tracking-tight">
                        404 - Page Not Found
                    </h1>
                    <p class="mt-1 text-sm text-slate-400">
                        The page you are looking for does not exist.
                    </p>
                </div>

                <!-- MAIN CONTENT -->
                <div class="space-y-6">
                    <div class="text-center">
                        <p class="text-lg text-slate-300">Oops! It seems like the page you're trying to reach doesn't exist.</p>
                        <a href="/" class="mt-4 inline-block px-4 py-2 bg-indigo-500 text-white rounded hover:bg-indigo-600 transition">Go Back Home</a>
                    </div>
                </div>

            </div>
        </section>

        <!-- FOOTER -->
        <footer class="border-t border-slate-800 bg-slate-950">
            <div class="mx-auto max-w-6xl px-4 py-6 text-xs text-slate-500 flex flex-col gap-2 sm:flex-row sm:justify-between">
                <span>
                    CS-Logs &copy; <?= date("Y") == "2026" ? date("Y") : "2026 - " . date("Y") ?>
                </span>
                <span>
                    I.DA-P3A
                </span>
            </div>
        </footer>

    </main>
</body>

</html>