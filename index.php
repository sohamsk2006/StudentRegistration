
<?php
// ---------------- PHP FORM PROCESSING ----------------

$errors = [];
$success = false;
$data = [];

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Collect and sanitize form data
    $fields = [
        "fullname", "email", "phone", "dob",
        "gender", "course", "qualification",
        "address", "city", "state", "pincode"
    ];

    foreach ($fields as $field) {
        $data[$field] = trim($_POST[$field] ?? "");
    }

    // Server-side validation
    foreach ($fields as $field) {
        if ($data[$field] === "") {
            $errors[] = ucfirst($field) . " is required.";
        }
    }

    if (!filter_var($data["email"], FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Please enter a valid email address.";
    }

    if (!preg_match("/^[0-9]{10}$/", $data["phone"])) {
        $errors[] = "Phone number must contain exactly 10 digits.";
    }

    if (!preg_match("/^[0-9]{6}$/", $data["pincode"])) {
        $errors[] = "PIN code must contain exactly 6 digits.";
    }

    if (!isset($_POST["terms"])) {
        $errors[] = "Please accept the terms and conditions.";
    }

    if (empty($errors)) {
        $success = true;
        $registrationId = "STU" . date("Ymd") . rand(100, 999);
    }
}

// Safe output function
function e($value) {
    return htmlspecialchars($value ?? "", ENT_QUOTES, "UTF-8");
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Student Registration Portal</title>

    <link rel="stylesheet" href="style.css">

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <!-- Font Awesome Icons -->
    <link rel="stylesheet"
    href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
</head>

<body>

<!-- NAVIGATION BAR -->

<nav class="navbar">
    <div class="logo">
        <div class="logo-icon">
            <i class="fa-solid fa-graduation-cap"></i>
        </div>
        <div>
            <h2>Edu<span>Portal</span></h2>
            <small>STUDENT REGISTRATION</small>
        </div>
    </div>

    <div class="nav-right">
        <i class="fa-solid fa-circle-question"></i>
        <span>Need Help?</span>
    </div>
</nav>


<?php if ($success): ?>

<!-- ---------------- SUCCESS PAGE ---------------- -->

<section class="success-container">

    <div class="success-card">

        <div class="success-icon">
            <i class="fa-solid fa-check"></i>
        </div>

        <h1>Registration Successful!</h1>

        <p class="success-message">
            Congratulations! Your registration details
            have been submitted successfully.
        </p>

        <div class="registration-id">
            <span>REGISTRATION ID</span>
            <h2><?php echo e($registrationId); ?></h2>
        </div>

        <div class="details-heading">
            <h3>Submitted Information</h3>
            <span>Personal Profile</span>
        </div>

        <div class="details-grid">

            <?php
            $labels = [
                "fullname" => "Full Name",
                "email" => "Email Address",
                "phone" => "Phone Number",
                "dob" => "Date of Birth",
                "gender" => "Gender",
                "qualification" => "Qualification",
                "course" => "Selected Course",
                "address" => "Address",
                "city" => "City",
                "state" => "State",
                "pincode" => "PIN Code"
            ];

            foreach ($labels as $key => $label):
            ?>

            <div class="detail-item">
                <span><?php echo e($label); ?></span>
                <strong><?php echo e($data[$key]); ?></strong>
            </div>

            <?php endforeach; ?>

        </div>

        <div class="success-actions">
            <button onclick="window.print()" class="btn-primary">
                <i class="fa-solid fa-print"></i>
                Print Details
            </button>

            <a href="index.php" class="btn-secondary">
                <i class="fa-solid fa-house"></i>
                Back to Home
            </a>
        </div>

    </div>

</section>


<?php else: ?>

<!-- ---------------- REGISTRATION FORM ---------------- -->

<main class="main-container">

    <div class="welcome-section">
        <div>
            <span class="eyebrow">
                <i class="fa-solid fa-sparkles"></i>
                YOUR FUTURE STARTS HERE
            </span>

            <h1>Student Registration</h1>

            <p>
                Fill in your details below to begin your
                academic journey with us.
            </p>
        </div>

        <div class="welcome-icon">
            <i class="fa-solid fa-user-graduate"></i>
        </div>
    </div>


    <!-- FORM CARD -->

    <div class="form-card">

        <div class="form-top">
            <div>
                <h2>Registration Form</h2>
                <p>Please provide accurate information.</p>
            </div>

            <span class="required-note">
                * Required fields
            </span>
        </div>


        <!-- PHP ERROR DISPLAY -->

        <?php if (!empty($errors)): ?>

        <div class="error-box">
            <strong><i class="fa-solid fa-circle-exclamation"></i>
                Please correct the following:</strong>

            <ul>
                <?php foreach ($errors as $error): ?>
                    <li><?php echo e($error); ?></li>
                <?php endforeach; ?>
            </ul>
        </div>

        <?php endif; ?>


        <form id="registrationForm" method="POST" action="index.php">

            <!-- PERSONAL INFORMATION -->

            <div class="section-title">
                <div class="section-icon">
                    <i class="fa-solid fa-user"></i>
                </div>

                <div>
                    <h3>Personal Information</h3>
                    <p>Tell us a little about yourself</p>
                </div>
            </div>


            <div class="form-grid">

                <div class="form-group">
                    <label>Full Name <span>*</span></label>

                    <input type="text" name="fullname"
                    placeholder="Enter your full name"
                    value="<?php echo e($data["fullname"] ?? ""); ?>"
                    required>

                    <small class="field-error"></small>
                </div>


                <div class="form-group">
                    <label>Email Address <span>*</span></label>

                    <input type="email" name="email"
                    placeholder="example@gmail.com"
                    value="<?php echo e($data["email"] ?? ""); ?>"
                    required>

                    <small class="field-error"></small>
                </div>


                <div class="form-group">
                    <label>Phone Number <span>*</span></label>

                    <input type="tel" name="phone"
                    placeholder="10-digit mobile number"
                    maxlength="10"
                    value="<?php echo e($data["phone"] ?? ""); ?>"
                    required>

                    <small class="field-error"></small>
                </div>


                <div class="form-group">
                    <label>Date of Birth <span>*</span></label>

                    <input type="date" name="dob"
                    value="<?php echo e($data["dob"] ?? ""); ?>"
                    max="<?php echo date('Y-m-d'); ?>"
                    required>

                    <small class="field-error"></small>
                </div>


                <div class="form-group full-width">
                    <label>Gender <span>*</span></label>

                    <div class="gender-options">

                        <label class="gender-card">
                            <input type="radio" name="gender"
                            value="Male"
                            <?php echo (($data["gender"] ?? "") == "Male") ? "checked" : ""; ?>
                            required>
                            <i class="fa-solid fa-mars"></i>
                            Male
                        </label>

                        <label class="gender-card">
                            <input type="radio" name="gender"
                            value="Female"
                            <?php echo (($data["gender"] ?? "") == "Female") ? "checked" : ""; ?>>
                            <i class="fa-solid fa-venus"></i>
                            Female
                        </label>

                        <label class="gender-card">
                            <input type="radio" name="gender"
                            value="Other"
                            <?php echo (($data["gender"] ?? "") == "Other") ? "checked" : ""; ?>>
                            <i class="fa-solid fa-user"></i>
                            Other
                        </label>

                    </div>
                </div>

            </div>


            <!-- ACADEMIC INFORMATION -->

            <div class="section-title section-spacing">
                <div class="section-icon purple">
                    <i class="fa-solid fa-book-open"></i>
                </div>

                <div>
                    <h3>Academic Information</h3>
                    <p>Choose your educational preferences</p>
                </div>
            </div>


            <div class="form-grid">

                <div class="form-group">
                    <label>Highest Qualification <span>*</span></label>

                    <select name="qualification" required>
                        <option value="">Select Qualification</option>

                        <?php
                        $qualifications = [
                            "10th Standard",
                            "12th Standard / PUC",
                            "Diploma",
                            "Undergraduate",
                            "Postgraduate"
                        ];

                        foreach ($qualifications as $q):
                        ?>
                        <option value="<?php echo e($q); ?>"
                        <?php echo (($data["qualification"] ?? "") == $q) ? "selected" : ""; ?>>
                            <?php echo e($q); ?>
                        </option>
                        <?php endforeach; ?>

                    </select>
                </div>


                <div class="form-group">
                    <label>Interested Course <span>*</span></label>

                    <select name="course" required>
                        <option value="">Select a Course</option>

                        <?php
                        $courses = [
                            "Computer Science Engineering",
                            "Information Science Engineering",
                            "Artificial Intelligence & ML",
                            "Electronics & Communication",
                            "Mechanical Engineering",
                            "Civil Engineering",
                            "Business Administration",
                            "Other"
                        ];

                        foreach ($courses as $course):
                        ?>
                        <option value="<?php echo e($course); ?>"
                        <?php echo (($data["course"] ?? "") == $course) ? "selected" : ""; ?>>
                            <?php echo e($course); ?>
                        </option>
                        <?php endforeach; ?>

                    </select>
                </div>

            </div>


            <!-- CONTACT INFORMATION -->

            <div class="section-title section-spacing">
                <div class="section-icon orange">
                    <i class="fa-solid fa-location-dot"></i>
                </div>

                <div>
                    <h3>Contact Information</h3>
                    <p>Where can we reach you?</p>
                </div>
            </div>


            <div class="form-grid">

                <div class="form-group full-width">
                    <label>Full Address <span>*</span></label>

                    <textarea name="address"
                    placeholder="Enter your complete residential address"
                    required><?php echo e($data["address"] ?? ""); ?></textarea>
                </div>


                <div class="form-group">
                    <label>City <span>*</span></label>

                    <input type="text" name="city"
                    placeholder="Enter your city"
                    value="<?php echo e($data["city"] ?? ""); ?>"
                    required>
                </div>


                <div class="form-group">
                    <label>State <span>*</span></label>

                    <input type="text" name="state"
                    placeholder="Enter your state"
                    value="<?php echo e($data["state"] ?? ""); ?>"
                    required>
                </div>


                <div class="form-group">
                    <label>PIN Code <span>*</span></label>

                    <input type="text" name="pincode"
                    placeholder="6-digit PIN code"
                    maxlength="6"
                    value="<?php echo e($data["pincode"] ?? ""); ?>"
                    required>
                </div>

            </div>


            <!-- TERMS AND CONDITIONS -->

            <div class="terms">
                <label>
                    <input type="checkbox" name="terms" required>
                    <span>
                        I confirm that the information provided above
                        is accurate and accept the terms and conditions.
                    </span>
                </label>
            </div>


            <!-- BUTTONS -->

            <div class="form-buttons">

                <button type="reset" class="reset-btn">
                    <i class="fa-solid fa-rotate-left"></i>
                    Reset Form
                </button>

                <button type="submit" class="submit-btn">
                    Submit Registration
                    <i class="fa-solid fa-arrow-right"></i>
                </button>

            </div>

        </form>

    </div>


    <footer>
        <p>© 2026 EduPortal. All rights reserved.</p>
        <p>Designed for a better learning experience.</p>
    </footer>

</main>

<?php endif; ?>


<script src="script.js"></script>

</body>
</html>
