@section('title', 'Register')
<x-guest-layout>
    <form method="POST" action="{{ route('register') }}" id="studentForm">
        @csrf
        <h2 class="mb-4 font-medium uppercase text-xl max-sm:text-base text-primary">Registration Form</h2>
        <!-- Name -->
        <div id="pi-wrapper">
            <x-input-label for="pi_name" :value="__('Principal Investigator')" />
            <div class="flex space-x-2">
                <div class="w-1/3">
                    <x-text-input id="pi_Lname" class="block mt-1 w-full text-[14px] max-sm:text-[13px] h-[35px]"
                        type="text" name="pi_Lname" :value="old('pi_Lname')" required autofocus autocomplete="pi_Lname"
                        placeholder="Last name" />
                    <x-input-error :messages="$errors->get('pi_Lname')" class="mt-2" />
                </div>
                <div class="w-1/3">
                    <x-text-input id="pi_fname" class="block mt-1 w-full text-[14px] max-sm:text-[13px] h-[35px]"
                        type="text" name="pi_fname" :value="old('pi_fname')" required autofocus autocomplete="pi_fname"
                        placeholder="First name" />
                    <x-input-error :messages="$errors->get('pi_fname')" class="mt-2" />
                </div>
                <div class="w-1/3">
                    <x-text-input id="pi_MI" class="block mt-1 w-full text-[14px] max-sm:text-[13px] h-[35px]"
                        type="text" name="pi_MI" maxlength="4" :value="old('pi_MI')" required autofocus
                        autocomplete="pi_MI" placeholder="M.I." />
                    <x-input-error :messages="$errors->get('pi_MI')" class="mt-2" />
                </div>
            </div>
        </div>

        <!-- Email Address -->
        <div class="mt-2">
            <x-input-label for="pi_Email" :value="__('Email')" />
            <x-text-input id="pi_Email" class="block mt-1 w-full text-[14px] max-sm:text-[13px] h-[35px]" type="email"
                name="pi_Email" :value="old('pi_Email')" required autocomplete="username"
                placeholder="you@example.com" />
            <x-input-error :messages="$errors->get('pi_Email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="mt-2">
            <x-input-label for="pi_Password" :value="__('Password')" />
            <x-text-input id="pi_Password" class="block mt-1 w-full text-[14px] max-sm:text-[13px] h-[35px]"
                type="password" name="pi_Password" required autocomplete="pi_Password" placeholder="Password" />
            <x-input-error :messages="$errors->get('pi_Password')" class="mt-2" />
        </div>

        <!-- Confirm Password -->
        <div class="mt-2">
            <x-input-label for="pi_Password" :value="__('Confirm Password')" />
            <x-text-input id="pi_Password_confirmation"
                class="block mt-1 w-full text-[14px] max-sm:text-[13px] h-[35px]" type="password"
                name="pi_Password_confirmation" required autocomplete="pi_Password" placeholder="Confirm Password" />
            <x-input-error :messages="$errors->get('pi_Password_confirmation')" class="mt-2" />
        </div>

        <div class="flex items-center justify-end mt-4">
            <a class="text-sm max-sm:text-[13px] text-primary hover:text-secondary duration-200 rounded-md focus:outline-none"
                href="{{ route('login') }}">
                {{ __('Back to Login') }}
            </a>
            <!-- button type="button" ginamit ko para madirect sya into 2nd part khit nakarequired(pag submit button ginamit, di madidirect si user sa 2ndo part since naka required sya) -->
            <a href="{{ url('/register-co-inv') }}">
                <button type="button"
                    class="bg-secondary hover:bg-primary text-primary hover:text-secondary max-sm:text-sm px-4 py-2 rounded-md ms-2 uppercase tracking-widest duration-200">
                    Next
                </button>
            </a>
        </div>
    </form>
</x-guest-layout>