@section('title', 'Permission Control')
<x-superadmin-layout>
    <!-- Main Content -->
    <main class="ml-[335px] max-2xl:ml-auto p-4">
        <h2 class="max-2xl:hidden text-left bg-[#f2f2f2] shadow-lg p-[35px] rounded-[30px] font-medium text-[28px]">
            PERMISSION CONTROL
        </h2>
        <br>

        <button type="button" id="openModalBtn"
            class="m-auto block border-2 border-secondary px-5 py-3 max-md:px-4 max-md:py-2 bg-primary font-bold text-white max-md:text-[14px] rounded-md hover:border-primary hover:bg-secondary hover:text-primary duration-200">Add
            User
        </button>

        <!-- Modal form -->
        <div id="modalOverlay" class="fixed inset-0 bg-black bg-opacity-50 hidden justify-center items-center z-50">
            <button id="closeModalBtn"
                class="absolute top-2 right-2 text-gray hover:text-black text-xl">&times;</button>
            <!-- Modal layout -->
            <div
                class="bg-white rounded-md mt-6 px-6 py-4 border-4 border-gray max-md:mx-2 max-h-[80vh] overflow-y-auto relative max-sm:max-h-[75vh] max-sm:overflow-y-auto max-sm:relative">
                <h2 class="mb-6 font-semibold text-2xl max-md:text-[20px]">Add User</h2>
                <!-- Form -->
                <form method="POST" action="{{ route('superadmin.store') }}" id="modalForm">
                    @csrf
                    <!-- Full name for another user -->
                    <div class="mt-2">
                        <x-input-label for="adminName" :value="__('Full name')" />
                        <div class="flex space-x-2">
                            <!-- Last name -->
                            <div class="w-1/3">
                                <x-text-input id="adminLname"
                                    class="block mt-1 w-full text-[14px] max-sm:text-[13px] h-[35px]" type="text"
                                    name="adminLname" :value="old('adminLname')" required autofocus
                                    autocomplete="adminLname" placeholder="Last name" />
                                <x-input-error :messages="$errors->get('adminLname')" class="mt-2" />
                            </div>
                            <!-- First name -->
                            <div class="w-1/3">
                                <x-text-input id="adminFname"
                                    class="block mt-1 w-full text-[14px] max-sm:text-[13px] h-[35px]" type="text"
                                    name="adminFname" :value="old('adminFname')" required autofocus
                                    autocomplete="adminFname" placeholder="First name" />
                                <x-input-error :messages="$errors->get('adminFname')" />
                            </div>
                            <!-- Middle Initial -->
                            <div class="w-1/3">
                                <x-text-input id="adminMI"
                                    class="block mt-1 w-full text-[14px] max-sm:text-[13px] h-[35px]" type="text"
                                    name="adminMI" maxlength="2" :value="old('adminMI')" required autofocus
                                    autocomplete="adminMI" placeholder="M.I." />
                                <x-input-error :messages="$errors->get('adminMI')" class="mt-2" />
                            </div>
                        </div>
                    </div>

                    <!-- Classify users -->
                    <div class="mt-2">
                        <x-input-label for="user" :value="__('Type of user')" />
                        <x-combobox-user-type id="adminAccess" name="adminAccess"
                            class="mt-1 w-full text-[14px] max-sm:text-[13px] h-[35px] leading-[15px]" />
                        <x-input-error :messages="$errors->get('adminAccess')" class="mt-2" />
                    </div>

                    <!-- Password -->
                    <div class="mt-2">
                        <x-input-label for="adminPassword" :value="__('Password')" />
                        <x-text-input id="adminPassword"
                            class="block mt-1 w-full text-[14px] max-sm:text-[13px] h-[35px]" type="password"
                            name="adminPassword" required autocomplete="adminPassword" placeholder="Password" />
                        <x-input-error :messages="$errors->get('adminPassword')" class="mt-2" />
                    </div>

                    <!-- Confirm Password -->
                    <div class="mt-2">
                        <x-input-label for="adminPassword" :value="__('Confirm Password')" />
                        <x-text-input id="adminPassword_confirmation"
                            class="block mt-1 w-full text-[14px] max-sm:text-[13px] h-[35px]" type="password"
                            name="adminPassword_confirmation" required autocomplete="adminPassword"
                            placeholder="Confirm Password" />
                    </div>

                    <!-- Email Address -->
                    <div class="mt-2">
                        <x-input-label for="email" :value="__('Email')" />
                        <x-text-input id="adminEmail" class="block mt-1 w-full text-[14px] max-sm:text-[13px] h-[35px]"
                            type="email" name="adminEmail" :value="old('adminEmail')" required autocomplete="username"
                            placeholder="you@example.com" />
                        <x-input-error :messages="$errors->get('adminEmail')" class="mt-2" />
                    </div>

                    <!-- Button -->
                    <div class="flex justify-end">
                        <x-primary-button class="mt-4 max-sm:text-sm">
                            Submit
                        </x-primary-button>
                    </div>
                </form>
            </div>
        </div>

        @if ($errors->any())
            <script>
                alert("{{ implode('\n', $errors->all()) }}");
            </script>
        @endif

        @if (session('success'))
            <script>
                alert("{{ session('success') }}");
            </script>
        @endif

        <table id="myTable" class="table-fixed min-w-full display overflow-scroll whitespace-normal border-collapse w-full">
            <!-- Table header -->
            <thead class="bg-primary text-white text-[18px]/7 max-lg:text-[16px]/7">
                <tr class="header-table">
                    <th>Account Name</th>
                    <th>Username</th>
                    <th>Access</th>
                    <th>Role</th>
                    <th>Date Modified</th>
                </tr>
            </thead>
            <!-- Table body -->
            <tbody class="text-base/6 max-lg:text-sm/6">
                @foreach($admins as $admin)
                    <tr>
                        <td>{{ $admin->adminID }}</td>
                        <td>{{ $admin->adminFname }} {{ $admin->adminMI ? $admin->adminMI . '.' : '' }}
                            {{ $admin->adminLname }}
                        </td>
                        <td>{{ $admin->adminEmail }}</td>
                        <td>{{ $admin->adminAccess }}</td>
                        <td>{{ $admin->created_at->format('n/j/Y') }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </main>
</x-superadmin-layout>
<script>
    const openBtn = document.getElementById('openModalBtn');
    const closeBtn = document.getElementById('closeModalBtn');
    const modal = document.getElementById('modalOverlay');

    openBtn.addEventListener('click', () => {
        modal.classList.remove('hidden');
        modal.classList.add('flex');
    });

    closeBtn.addEventListener('click', () => {
        modal.classList.add('hidden');
    });

    // Optional: close modal when clicking outside the modal content
    modal.addEventListener('click', (e) => {
        if (e.target === modal) {
            modal.classList.add('hidden');
        }
    });
</script>