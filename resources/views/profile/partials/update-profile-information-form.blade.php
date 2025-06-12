<section>
    <header>
        <h2 class="text-lg font-semibold text-gray-900 dark:text-gray-100">
            {{ __('Profile Information') }}
        </h2>

        <p class="mt-2 text-sm text-gray-600 dark:text-gray-400 leading-relaxed">
            {{ __("Update your profile details and email address below.") }}
        </p>
    </header>

    <!-- Hidden form to resend email verification -->
    <form id="send-verification" method="POST" action="{{ route('verification.send') }}">
        @csrf
    </form>

    <!-- Profile Update Form -->
    <form method="POST" action="{{ route('profile.update') }}" enctype="multipart/form-data" class="mt-6 space-y-6">
        @csrf
        @method('patch')

        <!-- Name -->
        <div>
            <x-input-label for="name" :value="__('Name')" />
            <x-text-input
                id="name"
                name="name"
                type="text"
                class="mt-1 block w-full max-w-md"
                :value="old('name', $user->name)"
                required
                autofocus
                autocomplete="name"
            />
            <x-input-error :messages="$errors->get('name')" class="mt-2" />
        </div>

        <!-- Bio -->
        <div>
            <x-input-label for="bio" :value="__('Bio')" />
            <textarea
                id="bio"
                name="Bio"
                rows="4"
                class="mt-1 block w-full max-w-md border-gray-300 rounded-md shadow-sm dark:bg-gray-800 dark:text-white"
            >{{ old('Bio', $user->Bio) }}</textarea>
            <x-input-error :messages="$errors->get('Bio')" class="mt-2" />
        </div>

        <!-- Avatar -->
        <div>
            <x-input-label for="avatar" :value="__('Avatar')" />
            <input
                type="file"
                id="avatar"
                name="avatar"
                class="mt-1 block w-full text-sm text-gray-700 dark:text-white"
            />

            @if ($user->Avatar)
                <div class="mt-3">
                    <img
                        src="{{ asset('storage/' . $user->Avatar) }}"
                        alt="Current Avatar"
                        class="w-24 h-24 rounded-full object-cover border"
                    />
                </div>
            @endif
        </div>

        <!-- Email -->
        <div>
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input
                id="email"
                name="email"
                type="email"
                class="mt-1 block w-full max-w-md"
                :value="old('email', $user->email)"
                required
                autocomplete="username"
            />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />

            @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
                <div class="mt-3 text-sm text-gray-800 dark:text-gray-200">
                    {{ __('Your email address is unverified.') }}

                    <button
                        form="send-verification"
                        class="underline text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800"
                    >
                        {{ __('Click here to re-send the verification email.') }}
                    </button>

                    @if (session('status') === 'verification-link-sent')
                        <p class="mt-2 font-medium text-sm text-green-600 dark:text-green-400">
                            {{ __('A new verification link has been sent to your email address.') }}
                        </p>
                    @endif
                </div>
            @endif
        </div>

        <!-- Submit -->
        <div class="flex items-center gap-4">
            <x-primary-button>{{ __('Save') }}</x-primary-button>

            @if (session('status') === 'profile-updated')
                <p
                    x-data="{ show: true }"
                    x-show="show"
                    x-transition
                    x-init="setTimeout(() => show = false, 2000)"
                    class="text-sm text-green-600 dark:text-green-400"
                >
                    {{ __('Profile updated successfully.') }}
                </p>
            @endif
        </div>
    </form>
</section>
