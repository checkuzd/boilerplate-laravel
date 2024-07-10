<!DOCTYPE html>
<html lang="en" class="bg-gradient-to-r from-lime-500 from-10% via-green-500 via-30% to-emerald-500 to-90% w-screen">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Password</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="md:w-7/12 mx-auto">

    <header class="py-8 bg-green-400">
        <img src="{{ SettingsHelper::logo() }}" alt="" class="text-center mx-auto">
    </header>

    <article>

        {{ $slot }}

    </article>

    <footer class="p-4">
    <section class="mx-auto text-center">
        <ul class="inline-flex">
            <li>
                <a href="https://x.com" target="_blank">
                    <img src="./images/email/x-logo-colored.png" alt="x" width="36" height="36">
                </a>
            </li>
            <li>
                <a href="https://facebook.com" target="_blank">
                    <img src="./images/email/facebook-logo-colored.png" alt="fb" width="36" height="36">
                </a>
            </li>
            <li>
                <a href="https://instagram.com" target="_blank">
                    <img src="./images/email/instagram-logo-colored.png" alt="ig" width="36" height="36">
                </a>
            </li>
            <li>
                <a href="https://youtube.com" target="_blank">
                    <img src="./images/email/youtube-logo-colored.png" alt="yt" width="36" height="36">
                </a>
            </li>
        </ul>
    </section>
</footer>
</body>

</html>