<?php
include "template/header.php";
include "page-includes/sidebar.php";
include "page-includes/navbar.php";

// Initialize variables to store previously submitted values
$lastname = $firstname = $middlename = $extensionname = $birthdate = $age = $gender = $marital_status = "";
$email = $phone_num = $province = $zip = $elem = $jhs = $shs = $college = "";
$job_title = $department = $hire_date = $hire_status = $job_salary = "";
$username = $login_role_id = $password = $confirm_password = "";

if (isset($_SESSION['form_values'])) {
    // Store previously submitted values
    $form_values = $_SESSION['form_values'];

    // Assign values only if they are set in the form_values array
    $lastname = isset($form_values['lastname']) ? $form_values['lastname'] : '';
    $firstname = isset($form_values['firstname']) ? $form_values['firstname'] : '';
    $middlename = isset($form_values['middlename']) ? $form_values['middlename'] : '';
    $extensionname = isset($form_values['extensionname']) ? $form_values['extensionname'] : '';
    $birthdate = isset($form_values['birthdate']) ? $form_values['birthdate'] : '';
    $age = isset($form_values['age']) ? $form_values['age'] : '';
    $gender = isset($form_values['gender']) ? $form_values['gender'] : '';
    $marital_status = isset($form_values['marital_status']) ? $form_values['marital_status'] : '';
    $email = isset($form_values['email']) ? $form_values['email'] : '';
    $phone_num = isset($form_values['phone_num']) ? $form_values['phone_num'] : '';
    $province = isset($form_values['province']) ? $form_values['province'] : '';
    $zip = isset($form_values['zip']) ? $form_values['zip'] : '';
    $elem = isset($form_values['elem']) ? $form_values['elem'] : '';
    $jhs = isset($form_values['jhs']) ? $form_values['jhs'] : '';
    $shs = isset($form_values['shs']) ? $form_values['shs'] : '';
    $college = isset($form_values['college']) ? $form_values['college'] : '';
    $job_title = isset($form_values['job_title']) ? $form_values['job_title'] : '';
    $department = isset($form_values['department']) ? $form_values['department'] : '';
    $hire_date = isset($form_values['hire_date']) ? $form_values['hire_date'] : '';
    $hire_status = isset($form_values['hire_status']) ? $form_values['hire_status'] : '';
    $job_salary = isset($form_values['job_salary']) ? $form_values['job_salary'] : '';
    $username = isset($form_values['username']) ? $form_values['username'] : '';
    $login_role_id = isset($form_values['login_role_id']) ? $form_values['login_role_id'] : '';
    $password = isset($form_values['password']) ? $form_values['password'] : '';
    $confirm_password = isset($form_values['confirm_password']) ? $form_values['confirm_password'] : '';

    unset($_SESSION['form_values']);
}


?>

<!-- Page content -->
<div class="main">
    <div class="container-fluid">
        <?php if (isset($_SESSION['AlertMsg'])) { ?>
            <div class="alert <?= $_SESSION['AlertColor'] ?> fade show" role="alert">
                <?= $_SESSION['AlertMsg'] ?>

            </div>
        <?php }
        unset($_SESSION['AlertMsg']); ?>
        <h5 class="mt-3 mb-4">Create Employee Account</h5>
        <div class="container bg-light p-3">
            <form action="config/add_new_employee.php" method="post">
                <h6 class="text-center fw-bold">Employee Personal Information:</h6>
                <div class="row mb-2">
                    <div class="col">
                        <label for="">Last Name:</label>
                        <div class="input-group">
                            <input type="text" name="lastname" required value="<?= $lastname ?>" class="form-control">
                        </div>
                    </div>
                    <div class="col">
                        <label for="">First Name:</label>
                        <div class="input-group">
                            <input type="text" name="firstname" required value="<?= $firstname ?>" class="form-control">
                        </div>
                    </div>
                    <div class="col">
                        <label for="">Middle Name:</label>
                        <div class="input-group">
                            <input type="text" name="middlename" value="<?= $middlename ?>" class="form-control">
                        </div>
                    </div>
                    <div class="col">
                        <label for="">Name Extensions:</label>
                        <div class="input-group">
                            <input type="text" name="extensionname" value="<?= $extensionname ?>" class="form-control">
                        </div>
                    </div>
                </div>

                <div class="row mb-2">
                    <div class="col">
                        <label for="">Birthdate:</label>
                        <div class="input-group">
                            <input type="date" id="birthdate" required value="<?= $birthdate ?>" name="birthdate" max="<?= date('Y-m-d') ?>" class="form-control">
                        </div>
                    </div>
                    <div class="col">
                        <label for="">Age:</label>
                        <div class="input-group">
                            <input type="number" id="age" value="<?= $age ?>" readonly name="age" class="form-control">
                        </div>
                    </div>
                    <div class="col">
                        <label for="">Gender/Sex:</label>
                        <div class="input-group">
                            <select name="gender" required class="form-control" id="">
                                <option value="" <?php if ($gender == '') echo 'selected'; ?> disabled>--Select Gender/Sex--</option>
                                <option value="MALE" <?php if ($gender == 'MALE') echo 'selected'; ?>>MALE</option>
                                <option value="FEMALE" <?php if ($gender == 'FEMALE') echo 'selected'; ?>>FEMALE</option>
                            </select>
                        </div>
                    </div>
                    <div class="col">
                        <label for="">Marital Status:</label>
                        <div class="input-group">
                            <select name="marital_status" required class="form-control" id="">
                                <option value="" <?php if ($marital_status == '') echo 'selected'; ?> disabled>--Select Status--</option>
                                <option value="SINGLE" <?php if ($marital_status == 'SINGLE') echo 'selected'; ?>>SINGLE</option>
                                <option value="MARRIED" <?php if ($marital_status == 'MARRIED') echo 'selected'; ?>>MARRIED</option>
                                <option value="DIVORCED" <?php if ($marital_status == 'DIVORCED') echo 'selected'; ?>>DIVORCED</option>
                                <option value="WIDOWED" <?php if ($marital_status == 'WIDOWED') echo 'selected'; ?>>WIDOWED</option>
                                <option value="SEPARATED" <?php if ($marital_status == 'SEPARATED') echo 'selected'; ?>>SEPARATED</option>
                            </select>
                        </div>
                    </div>
                </div>

                <hr>
                <h6 class="text-center fw-bold">Contact Information:</h6>
                <div class="row mb-2">
                    <div class="col">
                        <label for="">Contact Number:</label>
                        <div class="input-group">
                            <span class="input-group-text" required id="contact-input">+63</span>
                            <input type="text" value="<?= $phone_num ?>" name="phone_num" maxlength="10" class="form-control" aria-describedby="contact-input">
                        </div>
                    </div>
                    <div class="col">
                        <label for="">Email:</label>
                        <div class="input-group">
                            <input type="email" value="<?= $email ?>" required name="email" class="form-control">
                        </div>
                    </div>
                </div>

                <div class="row mb-2">
                    <div class="col">
                        <label for="">Province:</label>
                        <div class="input-group">
                            <input type="text" name="province" required value="<?= $province ?>" class="form-control">
                        </div>
                    </div>
                    <div class="col">
                        <label for="">Zip:</label>
                        <div class="input-group">
                            <input type="number" name="zip" required value="<?= $zip ?>" class="form-control">
                        </div>
                    </div>
                </div>

                <hr>
                <h6 class="text-center fw-bold">Educational Background:</h6>
                <div class="row mb-2">
                    <label for="">Elementary School:</label>
                    <div class="input-group">
                        <input type="text" name="elem" required value="<?= $elem ?>" class="form-control">
                    </div>
                </div>
                <div class="row mb-2">
                    <label for="">Junior High School:</label>
                    <div class="input-group">
                        <input type="text" name="jhs" required value="<?= $jhs ?>" class="form-control">
                    </div>
                </div>
                <div class="row mb-2">
                    <label for="">Senior High School:</label>
                    <div class="input-group">
                        <input type="text" name="shs" required value="<?= $shs ?>" class="form-control">
                    </div>
                </div>
                <div class="row mb-2">
                    <label for="">College:</label>
                    <div class="input-group">
                        <input type="text" name="college" required value="<?= $college ?>" class="form-control">
                    </div>
                </div>
                <hr>
                <h6 class="text-center fw-bold">Job Description:</h6>
                <div class="row mb-2">
                    <div class="col">
                        <label for="">Job Title:</label>
                        <div class="input-group">
                            <select name="job_title" required class="form-control" id="">
                                <option value="" <?php if ($job_title == '') echo 'selected'; ?> disabled>--Select Job Title--</option>
                                <option value="MANAGER" <?php if ($job_title == 'MANAGER') echo 'selected'; ?>>MANAGER</option>
                                <option value="SHIPPING EMPLOYEE" <?php if ($job_title == 'SHIPPING EMPLOYEE') echo 'selected'; ?>>SHIPPING EMPLOYEE</option>
                                <option value="IT EMPLOYEE" <?php if ($job_title == 'IT EMPLOYEE') echo 'selected'; ?>>IT EMPLOYEE</option>
                                <option value="FINANCE EMPLOYEE" <?php if ($job_title == 'FINANCE EMPLOYEE') echo 'selected'; ?>>FINANCE EMPLOYEE</option>
                                <option value="RIDER" <?php if ($job_title == 'RIDER') echo 'selected'; ?>>RIDER</option>
                            </select>

                        </div>
                    </div>
                    <div class="col">
                        <label for="">Department:</label>
                        <div class="input-group">
                            <select name="department" required class="form-control" id="">
                                <option value="" <?php if ($department == '') echo 'selected'; ?> disabled>--Select Department--</option>
                                <option value="ORDER PROCESSING" <?php if ($department == 'ORDER PROCESSING') echo 'selected'; ?>>ORDER PROCESSING</option>
                                <option value="SHIPPING/LOGISTICS" <?php if ($department == 'SHIPPING/LOGISTICS') echo 'selected'; ?>>SHIPPING/LOGISTICS</option>
                                <option value="IT SUPPORT" <?php if ($department == 'IT SUPPORT') echo 'selected'; ?>>IT SUPPORT</option>
                                <option value="FINANCE" <?php if ($department == 'FINANCE') echo 'selected'; ?>>FINANCE</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="row mb-2">
                    <div class="col">
                        <label for="">Hire Date:</label>
                        <div class="input-group">
                            <input type="date" required value="<?= $hire_date ?>" name="hire_date" class="form-control">
                        </div>
                    </div>
                    <div class="col">
                        <label for="">Hire Status:</label>
                        <div class="input-group">
                            <select name="hire_status" required class="form-control" id="">
                                <option value="" <?php if ($hire_status == '') echo 'selected'; ?> disabled>--Select Hire Status--</option>
                                <option value="PART-TIME" <?php if ($hire_status == 'PART-TIME') echo 'selected'; ?>>PART-TIME</option>
                                <option value="FULL-TIME" <?php if ($hire_status == 'FULL-TIME') echo 'selected'; ?>>FULL-TIME</option>
                                <option value="CONTRACT" <?php if ($hire_status == 'CONTRACT') echo 'selected'; ?>>CONTRACT</option>
                                <option value="INTERN" <?php if ($hire_status == 'INTERN') echo 'selected'; ?>>INTERN</option>
                            </select>

                        </div>
                    </div>
                    <div class="col">
                        <label for="">Job Salary:</label>
                        <div class="input-group">
                            <input type="text" required name="job_salary" value="<?= $job_salary ?>" class="form-control">
                        </div>
                    </div>
                </div>

                <hr>
                <h6 class="text-center fw-bold">Login Credentials:</h6>
                <div class="row mb-2">
                    <div class="col">
                        <label for="">Username:</label>
                        <div class="input-group">
                            <input type="text" required name="username" class="form-control">
                        </div>
                    </div>
                    <div class="col">
                        <label for="">User Role:</label>
                        <div class="input-group">
                            <select name="login_role_id"  required class="form-control" id="">
                                <option value="" <?php if ($login_role_id == '') echo 'selected'; ?> disabled>--Select User Role--</option>
                                <option value="1" <?php if ($login_role_id == '1') echo 'selected'; ?>>ADMIN</option>
                                <option value="2" <?php if ($login_role_id == '2') echo 'selected'; ?>>STAFF</option>
                                <option value="3" <?php if ($login_role_id == '3') echo 'selected'; ?>>RIDER</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="row mb-2">
                    <div class="col">
                        <label for="">Create Password:</label>
                        <div class="input-group">
                            <input type="text" name="password" required class="form-control">
                        </div>
                    </div>
                    <div class="col">
                        <label for="">Confirm Password:</label>
                        <div class="input-group">
                            <input type="text" name="confirm_password" required class="form-control">
                        </div>
                    </div>
                </div>
                <div class="row my-4">
                    <div class="col d-flex justify-content-end">
                        <button type="submit" name="btn_save_employee" class="btn btn-info">Save</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<script src="assets/js/birthday.js"></script>

<?php
include "template/footer.php";
?>