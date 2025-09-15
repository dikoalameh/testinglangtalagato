@section('title', 'Register')
<x-guest-layout>
    <style>
        .step {
            display: none;
        }

        .step.active {
            display: block;
        }
        
        #departmentWrapper {
            display: none;
        }

        button {
            margin-top: 10px;
        }
    </style>
    <form method="POST" action="{{ route('register') }}" id="studentForm">
        <div id="step1" class="step active">
            @csrf
            <h2 class="mb-4 font-medium uppercase text-xl max-sm:text-base text-primary">Registration Form</h2>
            <!-- Name -->
            <div id="pi-wrapper">
                <x-input-label for="pi_name" :value="__('Principal Investigator')" />
                <div class="flex space-x-2">
                    <div class="w-1/3">
                        <x-text-input id="pi_Lname" class="block mt-1 w-full text-[14px] max-sm:text-[13px] h-[35px]"
                            type="text" name="pi_Lname" :value="old('pi_Lname')" required autofocus
                            autocomplete="pi_Lname" placeholder="Last name" />
                        <x-input-error :messages="$errors->get('pi_Lname')" class="mt-2" />
                    </div>
                    <div class="w-1/3">
                        <x-text-input id="pi_fname" class="block mt-1 w-full text-[14px] max-sm:text-[13px] h-[35px]"
                            type="text" name="pi_fname" :value="old('pi_fname')" required autofocus
                            autocomplete="pi_fname" placeholder="First name" />
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
                <x-text-input id="pi_Email" class="block mt-1 w-full text-[14px] max-sm:text-[13px] h-[35px]"
                    type="email" name="pi_Email" :value="old('pi_Email')" required autocomplete="username"
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
                    name="pi_Password_confirmation" required autocomplete="pi_Password"
                    placeholder="Confirm Password" />
                <x-input-error :messages="$errors->get('pi_Password_confirmation')" class="mt-2" />
            </div>

            <div class="flex items-center justify-end mt-4">
                <a class="text-sm max-sm:text-[13px] text-primary hover:text-secondary duration-200 rounded-md focus:outline-none"
                    href="{{ route('login') }}">
                    {{ __('Back to Login') }}
                </a>
                <!-- button type="button" ginamit ko para madirect sya into 2nd part khit nakarequired(pag submit button ginamit, di madidirect si user sa 2ndo part since naka required sya) -->
                <button type="button" onclick="nextStep()"
                    class="bg-secondary hover:bg-primary text-primary hover:text-secondary max-sm:text-sm px-4 py-2 rounded-md ms-2 uppercase tracking-widest duration-200">
                    Next
                </button>
            </div>
        </div>
        <div id="step2" class="step">
            <h2 class="mb-4 font-medium uppercase text-xl max-sm:text-base text-primary">Registration Form</h2>
            <!-- Name -->
            <div id="co-wrapper">
                <x-input-label for="Co_Investigators" :value="__('Co-Investigator/s (type N/A if none)')" />
                <x-text-input id="Co_Investigators" class="block mt-1 w-full text-[14px] max-sm:text-[13px] h-[35px]"
                    type="text" name="Co_Investigators" :value="old('Co_Investigators')" required
                    autocomplete="Co_Investigators" placeholder="e.g. (John Doe, Carlos González)" />
                <x-input-error :messages="$errors->get('Co_Investigators')" class="mt-2" />
            </div>

            <!-- If MCU Student or not -->
            <div class="mt-3">
                <label for="checkmcu" class="flex items-center space-x-1">
                    <input id="toggleCheckBox" type="checkbox" class="rounded max-sm:w-[14px] max-sm:h-[14px]"
                        name="checkmcu" value="1" />
                    <span id="inputSpan"
                        class="text-[14px] text-primary max-sm:text-[13px]">{{ __('Check if not MCU student') }}
                    </span>
                </label>

                <x-input-label id="inputLabel" for="pi_program" :value="__('Select College and Department')" />
                <x-combo-box id="pi_program" name="pi_program" onchange="updateDepartments()"
                    class="block border-gray mt-1 w-full text-sm max-sm:text-[13px] h-[35px] leading-[15px]" />
                <div id="departmentWrapper">
                    <select id="department" name="pi_department" class="w-full text-sm mt-1 border-gray rounded-md">
                        <option value="" disabled selected>-- Select Department --</option>
                    </select>
                </div>
                <x-input-error :messages="$errors->get('pi_program')" class="mt-2" />

                <input type="text" id="textBox"
                    class="h-[35px] text-[14px] block mt-1 w-full border-gray hover:bg-gray rounded-md duration-200 hidden"
                    placeholder="School" name="pi_school" />
            </div>

            <!-- Research Title -->
            <div class="mt-2">
                <x-input-label for="pi_title" :value="__('Research Title')" />
                <x-text-input id="pi_title" class="block mt-1 w-full text-[14px] max-sm:text-[13px] h-[35px]"
                    type="text" name="pi_title" :value="old('pi_title')" required autocomplete="pi_title"
                    placeholder="Research Title" />
                <x-input-error :messages="$errors->get('pi_title')" class="mt-2" />
            </div>

            <!-- Attach Endorsement Letter File -->
            <div class="mt-2">
                <x-input-label for="attachments" :value="__('Endorsement Letter')" />
                <x-text-input id="endorsement"
                    class="block mt-1 w-full rounded-md p-1 hover:bg-transparent text-[14px] max-sm:text-[13px] h-[35px]"
                    type="file" name="endorsement[]" multiple />
            </div>

            <div class="flex items-center justify-end mt-4">
                <a class="text-sm max-sm:text-[13px] text-primary hover:text-secondary duration-200 rounded-md focus:outline-none"
                    href="{{ route('login') }}">
                    {{ __('Back to Login') }}
                </a>
                <!-- button type="button" ginamit ko para madirect sya into 1st part khit nakarequired(pag submit button ginamit, di madidirect si user sa 2nd part since naka required sya) -->
                <button type="button" onclick="prevStep()"
                    class="ms-2 bg-secondary hover:bg-primary text-primary hover:text-secondary max-sm:text-sm px-4 py-2 rounded-lg uppercase tracking-widest">
                    Back
                </button>
                <x-primary-button class="ms-2 max-sm:text-sm">
                    {{ __('Register') }}
                </x-primary-button>
            </div>
        </div>
    </form>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const toggleCheckBox = document.getElementById('toggleCheckBox');
            const comboBox = document.getElementById('pi_program');
            const textBox = document.getElementById('textBox');
            const departmentWrapper = document.getElementById('departmentWrapper')
            const inputSpan = document.getElementById('inputSpan');
            const dynamicLabel = document.getElementById('inputLabel');

            toggleCheckBox.addEventListener('change', function () {
                if (toggleCheckBox.checked) {
                    comboBox.classList.add('hidden');
                    departmentWrapper.style.display = "none";
                    textBox.classList.remove('hidden');
                    textBox.value = "";
                    textBox.disabled = false;

                    // Update the x-input-label's text
                    dynamicLabel.textContent = 'School';
                } else {
                    comboBox.classList.remove('hidden');
                    comboBox.value = "";
                    if (comboBox.value && departmentOptions[comboBox.value]) {
                        departmentWrapper.style.display = "block";
                    }
                    else {
                        departmentWrapper.style.display = "none";
                    }
                    departmentWrapper.value = "";
                    textBox.classList.add('hidden');
                    textBox.disabled = true;

                    // Restore label text
                    dynamicLabel.textContent = 'Select Program';
                }
            });
        });

        // Program → Department mapping
        const departmentOptions = {
            cas: ["Bachelor of Science in Biology", "Bachelor of Science in Computer Science",
                "Bachelor of Science in Information Technology", "Bachelor of Science in Psychology",
                "Bachelor of Arts in Communication", "Bachelor of Science in Entertainment and Multimedia Computing"],
            ioe: ["Bachelor of Secondary Education"],
            sbm: ["Bachelor of Science in Business Administration", "Bachelor of Accountancy",
                "Bachelor of Science in Entrepreneurship", "Bachelor of Science in Hospitality Management",
                "Bachelor of Science in Tourism Management"],
            medical: ["Bachelor of Science in Radiologic Technology", "Bachelor of Science in Medical Technology",
                "Doctor of Dental Medicine", "Doctor of Medicine", "Bachelor of Science in Nursing",
                "Doctor of Optometry", "Bachelor of Science in Pharmacy", "Bachelor of Science in Physical Therapy"]
        };

        function updateDepartments() {
            const program = document.getElementById("pi_program").value;
            const departmentSelect = document.getElementById("department");
            const departmentWrapper = document.getElementById("departmentWrapper");

            // Clear old options
            departmentSelect.innerHTML = '<option value="" disabled selected>-- Select Department --</option>';

            if (program && departmentOptions[program]) {
                // Show department dropdown
                departmentWrapper.style.display = "block";

                departmentOptions[program].forEach(dept => {
                    const option = document.createElement("option");
                    option.textContent = dept;
                    departmentSelect.appendChild(option);
                });
            }
        }
        
        let currentStep = 1;
        const totalSteps = 2;

        function showStep(step) {
            // hide all steps
            for (let i = 1; i <= totalSteps; i++) {
                document.getElementById("step" + i).classList.remove("active");
                // disable required for hidden inputs
                document.querySelectorAll("#step" + i + " [required]").forEach(input => {
                    input.dataset.required = "true";
                    input.removeAttribute("required");
                });
            }

            // show current step
            const currentDiv = document.getElementById("step" + step);
            currentDiv.classList.add("active");
            // enable required for visible inputs
            currentDiv.querySelectorAll("[data-required]").forEach(input => {
                input.setAttribute("required", "true");
            });
        }

        function nextStep() {
            const form = document.getElementById("studentForm");
            if (form.checkValidity()) { // validate current step
                currentStep++;
                showStep(currentStep);
            } else {
                form.reportValidity(); // show validation error
            }
        }

        function prevStep() {
            if (currentStep > 1) {
                currentStep--;
                showStep(currentStep);
            }
        }

        // initialize
        document.addEventListener("DOMContentLoaded", () => showStep(currentStep));

        // handle final submit
        document.getElementById("multiStepForm").addEventListener("submit", function (e) {
            e.preventDefault();
            alert("✅ Registration complete!");
        });
    </script>
</x-guest-layout>