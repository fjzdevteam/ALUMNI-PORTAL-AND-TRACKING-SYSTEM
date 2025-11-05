<x-onboard-layout :title="'Forgot Password'" :pageTitle="'Set New Password'" :loginMessage="'Enter your new password'" :showBackButton="true" :backUrl="url('/')"
    :centered="true">

    @php
        $email = session('email');
    @endphp

    @if (!$email)
        <div class="text-center text-red-600 mt-6">
            Your session has expired. Please request a new verification code.
        </div>
        <div class="flex justify-center mt-4">
            <a href="{{ route('forgot.form') }}" class="text-blue-600 hover:underline text-sm">
                Back to Forgot Password
            </a>
        </div>
    @else
        <form id="resetForm" method="POST" action="{{ route('password.reset') }}">
            @csrf
            <input type="hidden" name="email" value="{{ $email }}">

            @if (session('success'))
                <div id="success-message"
                    class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-md text-center mb-4 flex items-center justify-center gap-2"
                    role="alert">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 flex-shrink-0" fill="none"
                        viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                    </svg>
                    <span>{{ session('success') }}</span>
                </div>

                <script>
                    setTimeout(() => {
                        const msg = document.getElementById('success-message');
                        if (msg) msg.style.display = 'none';
                        window.location.href =
                            "{{ session('redirect_to') ? route(session('redirect_to')) : route('alumni.login') }}";
                    }, 3000);
                </script>
            @endif

            <div class="mt-7">
                <x-input-label for="password" :value="__('New Password')" />
                <x-text-input class="w-full" id="password" type="password" name="password"
                    placeholder="Enter your new password" required />
                <x-input-error :messages="$errors->get('password')" />
            </div>

            <div class="mt-7">
                <x-input-label for="password_confirmation" :value="__('Confirm Password')" />
                <x-text-input class="w-full" id="password_confirmation" type="password" name="password_confirmation"
                    placeholder="Re-enter your new password" required />
                <x-input-error :messages="$errors->get('password_confirmation')" />
            </div>

            <div id="formMessage" class="text-center text-sm mt-3"></div>

            <x-primary-button id="submitBtn" type="submit" class="mt-7 w-full text-sm">
                {{ __('Change Password') }}
            </x-primary-button>

            <div class="text-center mt-5">
                <a href="{{ route('alumni.login') }}" class="hover:underline text-sm">
                    Back to <strong>Login</strong>
                </a>
            </div>
        </form>

        <script>
            const form = document.getElementById('resetForm');
            const button = document.getElementById('submitBtn');
            const message = document.getElementById('formMessage');

            form.addEventListener('submit', async (event) => {
                event.preventDefault();

                button.disabled = true;
                button.textContent = 'Changing...';
                message.textContent = '';
                message.className = 'text-center text-gray-500 text-sm mt-3';

                try {
                    const response = await fetch(form.action, {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                            'Accept': 'application/json',
                        },
                        body: new FormData(form),
                    });

                    const data = await response.json();

                    if (response.ok && data.success) {
                        message.textContent = 'Password changed successfully!';
                        message.className = 'text-green-600 text-sm mt-3';
                        setTimeout(() => {
                            window.location.href = data.redirect_to;
                        }, 1500);
                    } else {
                        message.textContent = data.message || 'Something went wrong.';
                        message.className = 'text-red-600 text-sm mt-3';
                    }
                } catch (error) {
                    message.textContent = 'Network error. Please try again.';
                    message.className = 'text-center text-red-600 text-sm mt-3';
                } finally {
                    button.disabled = false;
                    button.textContent = 'Change Password';
                }
            });
        </script>
    @endif
</x-onboard-layout>
