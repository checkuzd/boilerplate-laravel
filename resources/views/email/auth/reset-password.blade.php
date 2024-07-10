
<x-email-layout>
    <section class="p-5 bg-orange-400 text-center">
        <h1 class="text-white text-4xl uppercase font-bold">Reset Password</h1>
    </section>
    <section class="p-10 bg-lime-100">
        <p>Hello!</p>

        <p>You are receiving this email because we received a password reset request for your account.</p>

        <p class="text-center"><a class="my-5 inline-block py-2 px-5 bg-green-500 text-white uppercase" href="{{ $action }}" target="_blank">Reset Password</a></p>
        <p>This password reset link will expire in {{ $count }} minutes.</p>

        <p>If you did not request a password reset, no further action is required.</p>

        <p>Regards,</p>
        <p>Boilerplate</p>
    </section>
    <hr>
    <section class="p-10 bg-green-200">        
        <p>If you're having trouble clicking the "Reset Password" button, copy and paste the URL below into your web browser: 
            <a href="{{ $action }}" target="_blank">{{ $action }}</a></p>
    </section>
</x-email-layout>
