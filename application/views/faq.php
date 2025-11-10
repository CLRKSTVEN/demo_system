<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>FAQ - School Records Management System</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        body {
            font-family: 'Inter', sans-serif;
        }
    </style>
</head>

<body class="bg-gray-50 text-gray-800">

    <!-- Top Banner -->
    <header class="bg-gradient-to-r from-blue-500 to-teal-400 text-white shadow-md p-5">
        <div class="max-w-6xl mx-auto flex flex-col sm:flex-row sm:items-center sm:justify-between">
            <div class="flex items-center space-x-4">
                <img src="<?= base_url(); ?>assets/images/srms-logo-new.png" alt="System Logo" class="w-14 h-14 rounded-full shadow-md">
                <div>
                    <h1 class="text-xl font-bold">SCHOOL RECORDS MANAGEMENT SYSTEM</h1>
                    <p class="text-sm">Empowering Schools Through Smarter Records</p>
                </div>
            </div>
        </div>
    </header>

    <!-- FAQ Section -->
    <main class="max-w-4xl mx-auto p-6">
        <h2 class="text-3xl font-bold mb-6 text-center">Frequently Asked Questions</h2>

        <div class="space-y-4">
            <!-- FAQ Item 1 -->
            <div class="bg-white rounded-xl shadow p-5">
                <button class="w-full text-left flex justify-between items-center faq-toggle">
                    <span class="font-semibold text-lg">What is SRMS?</span>
                    <svg class="w-5 h-5 transition-transform transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                    </svg>
                </button>
                <div class="faq-content mt-3 hidden text-sm text-gray-600 space-y-2">
                    <p>The <strong>School Records Management System (SRMS)</strong> is a comprehensive digital platform designed to centralize and streamline school operations. It efficiently manages and stores data related to student enrollment, class schedules, grades, school fees, and various administrative tasks.</p>
                    <p>SRMS provides easy and secure access for school administrators, teachers, parents, and students, improving transparency and communication within the school community.</p>
                    <img src="<?= base_url(); ?>images-faq/1.jpg" alt="SRMS Overview" class="mt-4 rounded shadow-lg">
                </div>
            </div>

            <!-- FAQ Item 2 -->
            <div class="bg-white rounded-xl shadow p-5">
                <button class="w-full text-left flex justify-between items-center faq-toggle">
                    <span class="font-semibold text-lg">How do I enroll a student in SRMS?</span>
                    <svg class="w-5 h-5 transition-transform transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                    </svg>
                </button>
                <div class="faq-content mt-3 hidden text-sm text-gray-600 space-y-2">
                    <p>To enroll a student in SRMS, follow these steps depending on whether the student is new or returning:</p>
                    <ol class="list-decimal list-inside space-y-1">
                        <li>Log in to your account using a Registrar role.</li>
                        <li>For new students, go to the <strong>Admission</strong> menu and click on <strong>Student Profile</strong> to begin creating their profile.</li>
                        <li>For returning students, go to the <strong>Admission</strong> menu and click on <strong>Enrollment</strong> since their profile already exists in the system.</li>
                        <li>Fill out all the required fields accurately, including personal and academic information.</li>
                        <li>Click <strong>Submit</strong> to complete and save the enrollment record.</li>
                    </ol>
                    <p>This process ensures all necessary data is captured properly for new and continuing students.</p>
                    <img src="<?= base_url(); ?>images-faq/1.png" alt="Enrollment Process Image" class="mt-4 rounded shadow-lg">
                </div>
            </div>

            <!-- FAQ Item 3 -->
            <div class="bg-white rounded-xl shadow p-5">
                <button class="w-full text-left flex justify-between items-center faq-toggle">
                    <span class="font-semibold text-lg">How can parents check their child’s grades?</span>
                    <svg class="w-5 h-5 transition-transform transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                    </svg>
                </button>
                <div class="faq-content mt-3 hidden text-sm text-gray-600 space-y-2">
                    <p>Parents can access the SRMS portal using their child's credentials:</p>
                    <ul class="list-disc list-inside">
                        <li><strong>Username:</strong> The student number</li>
                        <li><strong>Default Password:</strong> The student's birthdate in <code>YYYY-MM-DD</code> format (e.g., 2010-05-23)</li>
                    </ul>
                    <p>Once logged in, parents are advised to change the password immediately for account security. After login, the dashboard will display key information including:</p>
                    <ul class="list-disc list-inside">
                        <li>Available grades and academic performance</li>
                        <li>Current account balances and fees</li>
                        <li>Detailed payment history and transactions</li>
                    </ul>
                    <p>This provides a convenient way for parents to monitor their child’s progress and financial status at school.</p>
                </div>
            </div>

            <div class="bg-white rounded-xl shadow p-5">
                <button class="w-full text-left flex justify-between items-center faq-toggle">
                    <span class="font-semibold text-lg">What are the default login credentials for a teacher in the SRMS?</span>
                    <svg class="w-5 h-5 transition-transform transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                    </svg>
                </button>
                <div class="faq-content mt-3 hidden text-sm text-gray-600 space-y-2">
                    <p>The default username for a teacher is their employee number, and the default password is their birthdate in the format YYYY-MM-DD.
                        If you are unable to log in, please contact the system administrator or the IT in-charge to reset your password.</p>
                </div>
            </div>

            <div class="bg-white rounded-xl shadow p-5">
                <button class="w-full text-left flex justify-between items-center faq-toggle">
                    <span class="font-semibold text-lg">Can we assign an encoder?</span>
                    <svg class="w-5 h-5 transition-transform transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                    </svg>
                </button>
                <div class="faq-content mt-3 hidden text-sm text-gray-600 space-y-2">
                    <p>Yes, you can assign an encoder through the Manage Users section of an admin account. The encoder's role is strictly limited to adding student profiles.</p>
                </div>
            </div>

            <!-- FAQ Item 5 -->
            <div class="bg-white rounded-xl shadow p-5">
                <button class="w-full text-left flex justify-between items-center faq-toggle">
                    <span class="font-semibold text-lg">The currently logged-in school year is incorrect. How can I change it?</span>
                    <svg class="w-5 h-5 transition-transform transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                    </svg>
                </button>
                <div class="faq-content mt-3 hidden text-sm text-gray-600 space-y-2">
                    <h3 class="font-semibold text-lg">🔧 How to Change the Active School Year?</h3>
                    <p><strong>For Admin Accounts:</strong></p>
                    <ol class="list-decimal list-inside space-y-1">
                        <li>Login using your admin account.</li>
                        <li>Navigate to <strong>Settings &gt; School Info</strong>.</li>
                        <li>Locate the <strong>Active SY</strong> textbox.</li>
                        <li>Enter the correct or updated school year (e.g., 2024-2025).</li>
                        <li>Click the <strong>Update</strong> button to save your changes.</li>
                    </ol>

                    <p><strong>For Registrar or Accounting Accounts:</strong></p>
                    <ol class="list-decimal list-inside space-y-1">
                        <li>Login using your registrar or accounting account.</li>
                        <li>On your dashboard, click the <strong>School Year</strong> displayed at the top.</li>
                        <li>Type in the preferred school year you want to switch to.</li>
                        <li>Press <strong>Enter</strong> or confirm the selection to apply the change.</li>
                    </ol>
                    <p>This ensures that all data you access corresponds to the correct academic year.</p>
                </div>
            </div>

            <div class="bg-white rounded-xl shadow p-5">
                <button class="w-full text-left flex justify-between items-center faq-toggle">
                    <span class="font-semibold text-lg">Are advisers allowed to upload the scanned copy of a student's requirements?</span>
                    <svg class="w-5 h-5 transition-transform transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                    </svg>
                </button>
                <div class="faq-content mt-3 hidden text-sm text-gray-600 space-y-2">
                    <p>Yes. Advisers can upload scanned copies of student requirements. To do this, view the student’s profile and go to the Requirements tab. There, you'll see a list of required documents. On the right side of each item, there is an Upload button you can click to upload the corresponding file.</p>
                </div>
            </div>

            <div class="bg-white rounded-xl shadow p-5">
                <button class="w-full text-left flex justify-between items-center faq-toggle">
                    <span class="font-semibold text-lg">Are advisers allowed to edit a student's profile?</span>
                    <svg class="w-5 h-5 transition-transform transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                    </svg>
                </button>
                <div class="faq-content mt-3 hidden text-sm text-gray-600 space-y-2">
                    <p>Yes, advisers are allowed to edit student profiles, but only for students in their advisory class. Access to other students' profiles is restricted to maintain data privacy and security.</p>
                </div>
            </div>

            <div class="bg-white rounded-xl shadow p-5">
                <button class="w-full text-left flex justify-between items-center faq-toggle">
                    <span class="font-semibold text-lg">How do I add subjects?</span>
                    <svg class="w-5 h-5 transition-transform transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                    </svg>
                </button>
                <div class="faq-content mt-3 hidden text-sm text-gray-600 space-y-2">
                    <p>Log in using your registrar account, navigate to the Configuration menu, then select Subjects. Click the Add New button to add a subject.</p>
                </div>
            </div>

            <div class="bg-white rounded-xl shadow p-5">
                <button class="w-full text-left flex justify-between items-center faq-toggle">
                    <span class="font-semibold text-lg">How do I create a Class Program?</span>
                    <svg class="w-5 h-5 transition-transform transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                    </svg>
                </button>
                <div class="faq-content mt-3 hidden text-sm text-gray-600 space-y-2">
                    <p>Log in using your registrar account, navigate to the <strong>Configuration</strong> menu, then select <strong>Class Program</strong>.</p>
                    <p>Click the <strong>Add New</strong> button. Select the <strong>Grade Level</strong> and <strong>Section</strong>.</p>
                    <p>Select the <strong>Assigned Teacher</strong> and type the class schedule.</p>
                    <p>Once done, click the <strong>Save</strong> button.</p>
                </div>
            </div>


        </div>
    </main>

    <!-- Accordion Script -->
    <script>
        document.querySelectorAll('.faq-toggle').forEach(button => {
            button.addEventListener('click', () => {
                const content = button.nextElementSibling;
                const icon = button.querySelector('svg');
                content.classList.toggle('hidden');
                icon.classList.toggle('rotate-180');
            });
        });
    </script>
</body>

</html>