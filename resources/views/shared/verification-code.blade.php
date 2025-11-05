<x-onboard-layout :title="'Verification Code'" :pageTitle="'Verification Code'" :loginMessage="'Enter the code sent to your email account'" :showBackButton="true" :backUrl="url('/')"
    :centered="true">
    <form method="POST" action="{{ route('verification.verify') }}" x-data="{ loading: false }" x-on:submit="loading = true"
        class="w-full max-w-sm mx-auto">
        @csrf
        <input type="hidden" name="email" value="{{ old('email', session('email')) }}">
        <input type="hidden" name="otp" id="otp">

        @if ($errors->any())
            <div class="bg-red-100 text-red-700 px-4 py-2 rounded m-4">
                @foreach ($errors->all() as $error)
                    {{ $error }}
                @endforeach
            </div>
        @endif

        @if (session('success'))
            <div x-data="{ show: true }" x-init="setTimeout(() => show = false, 10000)" x-show="show"
                class="bg-green-100 text-green-700 px-4 py-2 rounded mb-4 transition-opacity duration-500">
                {{ session('success') }}
            </div>
        @endif

        <div class="flex justify-center gap-4 mt-7">
            <x-otp-input id="otp1" next="otp2" autofocus />
            <x-otp-input id="otp2" next="otp3" />
            <x-otp-input id="otp3" next="otp4" />
            <x-otp-input id="otp4" />
        </div>

        <div class="flex flex-col items-center justify-end mt-7">
            <x-primary-button type="submit" class="w-full text-sm flex items-center justify-center"
                x-bind:disabled="loading">
                <template x-if="!loading">
                    <span>{{ __('VERIFY') }}</span>
                </template>
                <template x-if="loading">
                    <div class="flex items-center space-x-2">
                        <svg class="animate-spin h-4 w-4 text-white" xmlns="http://www.w3.org/2000/svg" fill="none"
                            viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor"
                                stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v4a4 4 0 00-4 4H4z"></path>
                        </svg>
                        <span>Verifying...</span>
                    </div>
                </template>
            </x-primary-button>
        </div>
    </form>

    <div x-data="resendOtp()" class="flex flex-col items-center mt-6">
        <p class="text-sm text-gray-600 mb-2">
            Didn’t receive a code?
        </p>

        <template x-if="!cooldown">
            <button @click="resend()" class="text-blue-600 hover:underline font-semibold" :disabled="loading">
                <span x-show="!loading">Resend Code</span>
                <span x-show="loading" class="flex items-center space-x-2">
                    <svg class="animate-spin h-4 w-4 text-blue-600" xmlns="http://www.w3.org/2000/svg" fill="none"
                        viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor"
                            stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v4a4 4 0 00-4 4H4z"></path>
                    </svg>
                    <span>Sending...</span>
                </span>
            </button>
        </template>

        <template x-if="cooldown">
            <p class="text-gray-500 text-sm">
                Resend available in <span x-text="timer"></span>s
            </p>
        </template>

        <p x-show="message" x-text="message" class="text-green-600 text-sm mt-2"></p>
    </div>

    <script>
        const otpInputs = document.querySelectorAll('[id^="otp"]');
        const hiddenOtp = document.getElementById('otp');

        otpInputs.forEach((input, index) => {
            input.addEventListener('input', (e) => {
                if (e.target.value.length === 1 && index < otpInputs.length - 1) {
                    otpInputs[index + 1].focus();
                }
                hiddenOtp.value = Array.from(otpInputs).map(i => i.value).join('');
            });
        });

        function resendOtp() {
            return {
                loading: false,
                message: '',
                cooldown: false,
                timer: 60,
                resend() {
                    this.loading = true;
                    this.message = '';

                    fetch("{{ route('forgot.send') }}", {
                            method: "POST",
                            headers: {
                                "Content-Type": "application/json",
                                "Accept": "application/json",
                                "X-CSRF-TOKEN": document.querySelector('meta[name=\"csrf-token\"]').content,
                            },
                            body: JSON.stringify({
                                email: "{{ old('email', session('email')) }}"
                            }),
                        })
                        .then(async (res) => {
                            let data;
                            try {
                                data = await res.json();
                            } catch (err) {
                                const text = await res.text();
                                console.error("Non-JSON response received:", text);
                                this.message = "Server returned an unexpected response.";
                                this.loading = false;
                                return;
                            }

                            this.loading = false;
                            if (data.success) {
                                this.message = data.message || "Verification code resent!";
                                this.startCooldown();
                            } else {
                                this.message = data.message || "Something went wrong.";
                            }
                        })
                        .catch((error) => {
                            console.error("Network error:", error);
                            this.loading = false;
                            this.message = "Network error. Try again.";
                        });
                },
                startCooldown() {
                    this.cooldown = true;
                    this.timer = 60;
                    const countdown = setInterval(() => {
                        this.timer--;
                        if (this.timer <= 0) {
                            clearInterval(countdown);
                            this.cooldown = false;
                        }
                    }, 1000);
                }
            }
        }
    </script>
</x-onboard-layout>
