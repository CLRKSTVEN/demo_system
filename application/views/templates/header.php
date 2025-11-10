<body>

    <!-- Begin page -->
    <div id="wrapper">

        <?php
        if ($this->session->position == 'School') {
            $noti = $this->SGODModel->three_cond_not_equal_cond('sgod_aip_track', 'school_id', $this->session->username, 'notify', 1, 'position', 'School');
            $nc = $this->SGODModel->three_cond_count_not_equal_cond('sgod_aip_track', 'school_id', $this->session->username, 'notify', 1, 'position', 'School');
        } else {
            $noti = $this->SGODModel->two_cond_not_equal_sencod('sgod_aip_track', 'notify', 1, 'res', $this->session->username);
            $nc = $this->SGODModel->two_cond_count_not_equal_cond('sgod_aip_track', 'notify', 1, 'res', $this->session->username);
        }

        ?>


        <!-- Topbar Start -->
        <div class="navbar-custom">
            <ul class="list-unstyled topnav-menu float-right mb-0">

                <?php if ($this->session->position == 'School' || $this->session->position == 'smme') { ?>
                    <li class="dropdown notification-list">
                        <a class="nav-link dropdown-toggle  waves-effect" data-toggle="dropdown" href="#" role="button" aria-haspopup="false" aria-expanded="false">
                            <i class="mdi mdi-bell-outline noti-icon"></i>
                            <?php if ($nc->num_rows() != 0) { ?><span class="badge badge-pink rounded-circle noti-icon-badge"><?= $nc->num_rows(); ?></span><?php } ?>
                        </a>
                        <div class="dropdown-menu dropdown-menu-right dropdown-lg">

                            <!-- item-->
                            <div class="dropdown-item noti-title">
                                <h5 class="font-16 m-0">
                                    <span class="float-right">
                                    </span>Notification
                                </h5>
                            </div>

                            <div class="slimscroll noti-scroll">


                                <?php
                                foreach ($noti as $row) {
                                    $user = $this->SGODModel->one_cond_row('users', 'username', $row->res);
                                ?>
                                    <!-- item-->
                                    <a href="<?= base_url(); ?>Page/aip_noti_track/<?= $row->submit_id; ?>" class="dropdown-item notify-item">
                                        <div class="notify-icon">
                                            <i class="mdi mdi-comment-account-outline text-info"></i>
                                        </div>
                                        <p class="notify-details"> <?= $user->fname . ' ' . $user->lname; ?> commented
                                            <small class="noti-time"></small>
                                        </p>
                                    </a>
                                <?php } ?>


                            </div>

                            <!-- All-->
                            <!-- <a href="javascript:void(0);" class="dropdown-item text-center notify-item notify-all">
                                    See all notifications
                            </a> -->

                        </div>
                    </li>

                <?php } ?>




                <li class="dropdown notification-list">
                    <?php
                    $pro_image = $this->session->image;
                    $sex = $this->session->sex;
                    $c_user = $this->Common->one_cond_row('users', 'user_id', $this->session->c_id);
                    $a = $this->Common->one_cond_row('hris_applicant', 'id', $this->session->c_id);
                    ?>
                    <a class="nav-link dropdown-toggle nav-user mr-0 waves-effect" data-toggle="dropdown" href="#" role="button" aria-haspopup="false" aria-expanded="false">
                        <img src="<?= base_url(); ?>uploads/profile/<?php if ($c_user->image != "") {
                                                                        echo $c_user->image;
                                                                    } else {
                                                                        if ($this->session->position == "reg") {
                                                                            if (isset($c_user->sex)) {
                                                                                if ($c_user->sex == 0) {
                                                                                    echo "icon/m.jpg";
                                                                                } else {
                                                                                    echo "icon/f.jpg";
                                                                                }
                                                                            }
                                                                        } else {
                                                                            echo "dd.png";
                                                                        }
                                                                    } ?>" alt="user-image" class="rounded-circle">
                        <span class="pro-user-name ml-1">
                            <?= strtoupper($this->session->user); ?> <i class="mdi mdi-chevron-down"></i>
                        </span>
                    </a>
                    <div class="dropdown-menu dropdown-menu-right profile-dropdown ">
                        <!-- item-->
                        <div class="dropdown-header noti-title">
                            <h6 class="text-overflow m-0">Welcome ! </h6>
                        </div>

                        <!-- item-->
                        <a href="<?= base_url(); ?><?php $ses = $this->session->position;
                                                    $id = $this->session->c_id;
                                                    if ($ses == "user") {
                                                        echo "personnel_profile/" . $id;
                                                    } elseif ($ses == "reg") {
                                                        echo "registered_profile/" . $id;
                                                    } elseif ($ses == "School") {
                                                        echo "Page/schoolProfile";
                                                    } else {
                                                        echo "";
                                                    } ?>" class="dropdown-item notify-item">
                            <i class="mdi mdi-account-outline"></i>
                            <span>Profile</span>
                        </a>

                        <!-- item-->
                        <a href="<?= base_url(); ?>Page/changeDP" class="dropdown-item notify-item">
                            <i class="mdi mdi-settings-outline"></i>
                            <span>Change Profile Image</span>
                        </a>

                        <!-- item-->
                        <a href="<?= base_url(); ?>/Page/systemFeedback" class="dropdown-item notify-item">
                            <i class="mdi mdi-lock-outline"></i>
                            <span>System Feedback</span>
                        </a>

                        <div class="dropdown-divider"></div>

                        <!-- item-->
                        <a href="<?= base_url(); ?>logout" class="dropdown-item notify-item">
                            <i class="mdi mdi-logout-variant"></i>
                            <span>Logout</span>
                        </a>

                    </div>
                </li>



            </ul>

            <!-- LOGO -->

            <div class="logo-box">
                <a href="<?= base_url(); ?>" class="logo text-center logo-dark">
                    <span class="logo-lg">
                        <img src="<?= base_url(); ?>assets/images/logo.png" alt="" height="18">
                        <!-- <span class="logo-lg-text-dark">Velonic</span> -->
                    </span>
                    <span class="logo-sm">
                        <!-- <span class="logo-lg-text-dark">V</span> -->
                        <img src="<?= base_url(); ?>assets/images/logo.png" alt="" height="22">
                    </span>
                </a>

                <!-- TryOne -->

                <a href="<?= base_url(); ?>" class="logo text-center logo">
                    <span class="logo-lg">
                        <?php
                        $position = $this->session->userdata('position');
                        $logo = ($position == 'SHNS') ? 'mediskweala.png' : 'logo-dark.png';
                        ?>
                        <img src="<?= base_url(); ?>assets/images/<?= $logo; ?>" alt="Logo" height="60">
                    </span>
                    <span class="logo-sm">
                        <?php
                        $position = $this->session->userdata('position');
                        $logo = ($position == 'SHNS') ? 'mediskweala-small.png' : 'logo.png';
                        ?>
                        <img src="<?= base_url(); ?>assets/images/<?= $logo; ?>" alt="Logo" height="60">
                    </span>
                </a>
            </div>

            <ul class="list-unstyled topnav-menu topnav-menu-left m-0">
                <li>
                    <button class="button-menu-mobile waves-effect">
                        <i class="mdi mdi-menu"></i>
                    </button>
                </li>
                <li class="d-none d-lg-block">
                    <?php
                    $attributes = array('class' => 'app-search');
                    echo form_open('t_and_t/', $attributes);
                    ?>
                    <div class="app-search-box">
                        <div class="input-group">
                            <input type="text" class="form-control" name="search" placeholder="Search">
                            <div class="input-group-append">
                                <button class="btn" type="submit">
                                    <i class="fas fa-search"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                    </form>
                </li>
            </ul>
        </div>
        <!-- end Topbar --> <!-- ========== Left Sidebar Start ========== -->
        <div class="left-side-menu">

            <div class="slimscroll-menu">


                <div id="sidebar-menu">
                    <ul class="metismenu" id="side-menu">
                        <li class="menu-title">Navigation</li>

                        <?php if ($this->session->sp == 0) { ?>

                            <?php if ($this->session->position === 'Admin') : ?>
                                <li><a href="<?= base_url(); ?>" class="waves-effect"><i class="fas fa-user-alt"></i><span> Dashboard </span></a></li>
                                <li>
                                    <a href="javascript: void(0);" class="waves-effect">
                                        <i class="ion ion-ios-school"></i>
                                        <span>Schools</span>
                                        <span class="menu-arrow"></span>
                                    </a>
                                    <ul class="nav-second-level" aria-expanded="false">
                                        <li><a href="<?= base_url(); ?>Pages/schools?type=Public">Public</a></li>
                                        <li><a href="<?= base_url(); ?>Pages/schools?type=Private">Private</a></li>
                                    </ul>
                                </li>
                                <li><a href="<?= base_url(); ?>users" class="waves-effect"><i class="ion ion-ios-person-add"></i><span> Manage Users </span></a></li>
                                <li>
                                    <a href="javascript: void(0);" class="waves-effect">
                                        <i class="mdi mdi-file-document-box-check-outline"></i>
                                        <span>Reports</span>
                                        <span class="menu-arrow"></span>
                                    </a>
                                    <ul class="nav-second-level" aria-expanded="false">
                                        <li><a href="<?= base_url(); ?>Pages/dcp_report" target="_blank">DCP Recipient Reports</a></li>
                                    </ul>
                                </li>

                                <li>
                                    <a href="javascript: void(0);" class="waves-effect">
                                        <i class=" ion ion-md-settings "></i>
                                        <span>System Settings</span>
                                        <span class="menu-arrow"></span>
                                    </a>
                                    <ul class="nav-second-level" aria-expanded="false">
                                        <li><a href="<?= base_url(); ?>Page/settings">Bulk Updating</a></li>
                                        <li><a href="<?= base_url(); ?>Page/tnCategory">Training Needs Category</a></li>
                                        <li><a href="<?= base_url(); ?>Pages/other_settings">Recaptcha Key</a></li>
                                        <li><a href="<?= base_url(); ?>Pages/other_settings">Other Settings</a></li>

                                    </ul>
                                </li>

                                <li><a href="<?= base_url(); ?>Page/announcements" class="waves-effect"><i class="fab fa-buromobelexperte"></i><span>Announcements </span></a></li>

                            <?php elseif ($this->session->position ===  'Human Resource Admin' || $this->session->position === 'asds') : ?>

                                <li><a href="<?= base_url(); ?>" class="waves-effect"><i class="fas fa-user-alt"></i><span> Dashboard </span></a></li>
                                <li>
                                    <a href="javascript: void(0);" class="waves-effect">
                                        <i class="far fa-address-book "></i>
                                        <span> Personnel </span>
                                        <span class="menu-arrow"></span>
                                    </a>
                                    <ul class="nav-second-level" aria-expanded="false">
                                        <li><a href="<?= base_url(); ?>personnel">Master List</a></li>
                                        <li>
                                            <a href="javascript: void(0);" aria-expanded="false">Personnel List
                                                <span class="menu-arrow"></span>
                                            </a>
                                            <ul class="nav-third-level nav" aria-expanded="false">
                                                <li><a href="<?= base_url(); ?>Page/employeelistv1">GSIS, Pagibig, PhilHealth and TIN</a></li>
                                                <li><a href="<?= base_url(); ?>Page/employeelistv2">Orig. Appointment, Last Appointment, Retirement Year</a></li>
                                                <li><a href="<?= base_url(); ?>Page/employeelistv3">For Retirement</a></li>
                                                <li><a href="<?= base_url(); ?>Page/step_increment">For Step Increment</a></li>
                                                <li><a href="<?= base_url(); ?>Page/employeelistv4">Length of Service</a></li>
                                                <li><a href="<?= base_url(); ?>Page/employeelistv5">Employment Status</a></li>
                                                <li><a href="<?= base_url(); ?>Page/employeelistDepartment">Department</a></li>
                                            </ul>
                                        </li>
                                        <li><a href="<?= base_url(); ?>Page/pos_summary">Per Position Title</a></li>
                                        <!-- <li><a href="#">Per Date Hired</a></li> -->
                                        <li><a href="<?= base_url(); ?>Page/perAppointmentDate">Per Appointment Date</a></li>
                                        <li><a href="<?= base_url(); ?>Page/retirement">Per Retirement Year</a></li>
                                        <li><a href="<?= base_url(); ?>Page/sg_summary">Per Salary Grade</a></li>
                                        <li><a href="<?= base_url(); ?>Page/loyalty">Loyalty</a></li>
                                        <li><a href="<?= base_url(); ?>Page/viewfilesAll">201 Files</a></li>
                                    </ul>
                                </li>

                                <li>
                                    <a href="javascript: void(0);" class="waves-effect">
                                        <i class="mdi mdi-view-compact-outline "></i>
                                        <span> Plantilla </span>
                                        <span class="menu-arrow"></span>
                                    </a>
                                    <ul class="nav-second-level" aria-expanded="false">
                                        <li><a href="<?= base_url(); ?>plantilla">Plantilla</a></li>
                                        <!-- <li><a href="<?= base_url(); ?>items/1">Unfilled Items</a></li> -->
                                        <li><a href="<?= base_url(); ?>Page/perPlantillaGroup">Plantilla Group</a></li>
                                        <li><a href="<?= base_url(); ?>Page/plantillaPositions">Plantilla Positions</a></li>
                                        <li><a href="<?= base_url(); ?>Page/unfilledItems">Unfilled Items</a></li>
                                    </ul>
                                </li>

                                <li>
                                    <a href="javascript: void(0);" class="waves-effect">
                                        <i class="ion ion-ios-attach"></i>
                                        <span> Service Record </span>
                                        <span class="menu-arrow"></span>
                                    </a>
                                    <ul class="nav-second-level" aria-expanded="false">
                                        <li><a href="<?= base_url(); ?>Page/serviceRecord">Service Record List</a></li>
                                        <li><a href="<?= base_url(); ?>Page/empList">Service Record Printing</a></li>
                                        <li><a href="<?= base_url(); ?>Page/serviceRecordUploading">Bulk Upload</a></li>
                                        <li><a href="<?= base_url(); ?>Page/sr_request_list">SR Requests</a></li>
                                    </ul>
                                </li>

                                <li>
                                    <a href="javascript: void(0);" class="waves-effect">
                                        <i class="mdi mdi-check-underline-circle "></i>
                                        <span> Leave </span>
                                        <span class="menu-arrow"></span>
                                    </a>
                                    <ul class="nav-second-level" aria-expanded="false">
                                        <!-- <li><a href="#">Leave Application</a></li> -->
                                        <li><a href="<?= base_url(); ?>Page/leaveCredits">Generate Monthly LC</a></li>
                                        <li><a href="<?= base_url(); ?>Page/leaveCreditsMonthly">Monthly Leave Credits</a></li>
                                        <li><a href="<?= base_url(); ?>Page/leaveCreditsSummary">Leave Credits Summary</a></li>
                                        <li><a href="<?= base_url(); ?>Page/leave_credits_approval">COC Credits</a></li>
                                    </ul>
                                </li>

                                <li>
                                    <a href="javascript: void(0);" class="waves-effect">
                                        <i class="mdi mdi-check-underline-circle "></i>
                                        <span> Travel </span>
                                        <span class="menu-arrow"></span>
                                    </a>
                                    <ul class="nav-second-level" aria-expanded="false">
                                        <!-- <li><a href="#">Leave Application</a></li> -->
                                        <li><a href="<?= base_url(); ?>Travel/viewPending">Authority to Travel (Pending)</a></li>
                                        <li><a href="<?= base_url(); ?>Travel/viewProcessedATT">Processed ATT</a></li>
                                    </ul>
                                </li>

                                <li>
                                    <a href="javascript: void(0);" class="waves-effect">
                                        <i class="fas fa-chalkboard-teacher"></i>
                                        <span> Recruitment </span>
                                        <span class="menu-arrow"></span>
                                    </a>
                                    <ul class="nav-second-level" aria-expanded="false">
                                        <li><a href="<?= base_url(); ?>Page/jobVacancy">Job Vacancies</a></li>
                                        <!-- <li><a href="<?= base_url(); ?>Pages/validated_applicant">Validated Applicants</a></li>
                                        <li><a href="<?= base_url(); ?>Pages/for_endorsement">For Endorsement</a></li> -->
                                        <li><a href="<?= base_url(); ?>Pages/endorsed_applicants">Endorsed Applicants</a></li>
                                        <li><a href="<?= base_url(); ?>Pages/rated_applicants">Rated Applicants</a></li>
                                        <li><a href="<?= base_url(); ?>Pages/query_applicants">Applicant Query</a></li>
                                        <li><a href="<?= base_url(); ?>Pages/confirmed_applicants">Confirmed Applicants</a></li>
                                        <li><a href="<?= base_url(); ?>Pages/dq_applicants">Disqualified Applicants</a></li>
                                        <li><a href="<?= base_url(); ?>Page/jobArchieved">Archived Vacancies</a></li>
                                        <li><a href="<?= base_url(); ?>Page/regApplicants">Registered Applicants</a></li>
                                        <li><a href="<?= base_url(); ?>Pages/request_rating">Retained Rating Request</span></a></li>
                                        <!-- <li><a href="<?= base_url(); ?>Page/appRatingUploading">Upload Applicant's Rating</a></li> -->
                                    </ul>
                                </li>

                                <?php if ($this->session->position === 'Admin') { ?>
                                    <li>
                                        <a href="javascript: void(0);" class="waves-effect">
                                            <i class="fas fa-scroll"></i>
                                            <spa>Implementation Plans</span>
                                                <span class="menu-arrow"></span>
                                        </a>
                                        <ul class="nav-second-level" aria-expanded="false">

                                            <li><a href="<?= base_url(); ?>Page/aip_sub">Submitted AIP</a></li>
                                            <li><a href="<?= base_url(); ?>Page/aip_stat">AIP Status</a></li>
                                            <li><a href="<?= base_url(); ?>Page/fy_setting">FY Settings</a></li>
                                        </ul>
                                    </li>
                                <?php } ?>

                                <li>
                                    <a href="javascript: void(0);" class="waves-effect">
                                        <i class="mdi mdi-notebook-multiple "></i>
                                        <span>Learning and Dev't.</span>
                                        <span class="menu-arrow"></span>
                                    </a>
                                    <ul class="nav-second-level" aria-expanded="false">
                                        <li><a href="<?= base_url(); ?>Page/tnSummary">Training Needs</a></li>
                                        <li><a href="<?= base_url(); ?>Page/idHR">Development Plan</a></li>

                                    </ul>
                                </li>
                                <?php if ($this->session->position === 'Admin') { ?>
                                    <li>
                                        <a href="javascript: void(0);" class="waves-effect">
                                            <i class=" ion ion-md-settings "></i>
                                            <span>System Settings</span>
                                            <span class="menu-arrow"></span>
                                        </a>
                                        <ul class="nav-second-level" aria-expanded="false">
                                            <li><a href="<?= base_url(); ?>Page/settings">Bulk Updating</a></li>
                                            <li><a href="<?= base_url(); ?>Page/tnCategory">Training Needs Category</a></li>

                                            <li><a href="<?= base_url(); ?>Pages/other_settings">Other Settings</a></li>

                                        </ul>
                                    </li>
                                    <li><a href="<?= base_url(); ?>Page/document_verifier" class="waves-effect"><i class="fas fa-address-book"></i><span> Document Verifier </span></a></li>
                                <?php } ?>
                                <?php if ($this->session->position === 'Human Resource Admin') { ?>
                                <?php } ?>
                                <li><a href="<?= base_url(); ?>hrusers" class="waves-effect"><i class="ion ion-ios-person-add"></i><span> Manage Users </span></a></li>
                                <li><a href="<?= base_url(); ?>Users/users_sub" class="waves-effect"><i class="fas fa-user-tie"></i>Manage Sub Users</a></li>
                                <li><a href="<?= base_url(); ?>Page/empReports" class="waves-effect"><i class="mdi mdi-equalizer "></i><span> Reports </span></a></li>
                                <li><a href="<?= base_url(); ?>Page/announcements" class="waves-effect"><i class="fab fa-buromobelexperte"></i><span>Announcements </span></a></li>
                                <li><a href="<?= base_url(); ?>Page/systemFeedback" class="waves-effect"><i class="fas fa-box "></i><span>System Feedback Form </span></a></li>
                                <li><a href="<?= base_url(); ?>Page/systemHelp" class="waves-effect"><i class=" fas fa-marker"></i><span>Help </span></a></li>


                            <?php elseif ($this->session->userdata('position') === 'Super Admin') : ?>
                                <li><a href="<?= base_url(); ?>" class="waves-effect"><i class="fas fa-user-alt"></i><span> Dashboard </span></a></li>
                                <li>
                                    <a href="javascript: void(0);" class="waves-effect">
                                        <i class="far fa-address-book "></i>
                                        <span> Personnel </span>
                                        <span class="menu-arrow"></span>
                                    </a>
                                    <ul class="nav-second-level" aria-expanded="false">
                                        <li><a href="<?= base_url(); ?>personnel">Master List</a></li>
                                        <li>
                                            <a href="javascript: void(0);" aria-expanded="false">Personnel List
                                                <span class="menu-arrow"></span>
                                            </a>
                                            <ul class="nav-third-level nav" aria-expanded="false">
                                                <li><a href="<?= base_url(); ?>Page/employeelistv1">GSIS, Pagibig, PhilHealth and TIN</a></li>
                                                <li><a href="<?= base_url(); ?>Page/employeelistv2">Orig. Appointment, Last Appointment, Retirement Year</a></li>
                                                <li><a href="<?= base_url(); ?>Page/employeelistv3">For Retirement</a></li>
                                                <li><a href="<?= base_url(); ?>Page/step_increment">For Step Increment</a></li>
                                                <li><a href="<?= base_url(); ?>Page/employeelistv4">Length of Service</a></li>
                                                <li><a href="<?= base_url(); ?>Page/employeelistv5">Employment Status</a></li>
                                                <li><a href="<?= base_url(); ?>Page/employeelistDepartment">Department</a></li>
                                            </ul>
                                        </li>
                                        <li><a href="<?= base_url(); ?>Page/pos_summary">Per Position Title</a></li>
                                        <!-- <li><a href="#">Per Date Hired</a></li> -->
                                        <li><a href="<?= base_url(); ?>Page/perAppointmentDate">Per Appointment Date</a></li>
                                        <li><a href="<?= base_url(); ?>Page/retirement">Per Retirement Year</a></li>
                                        <li><a href="<?= base_url(); ?>Page/sg_summary">Per Salary Grade</a></li>
                                        <li><a href="<?= base_url(); ?>Page/loyalty">Loyalty</a></li>
                                        <li><a href="<?= base_url(); ?>Page/viewfilesAll">201 Files</a></li>
                                    </ul>
                                </li>

                                <li>
                                    <a href="javascript: void(0);" class="waves-effect">
                                        <i class="mdi mdi-view-compact-outline "></i>
                                        <span> Plantilla </span>
                                        <span class="menu-arrow"></span>
                                    </a>
                                    <ul class="nav-second-level" aria-expanded="false">
                                        <!-- <li><a href="<?= base_url(); ?>items/0">Plantilla Positions</a></li> -->
                                        <!-- <li><a href="<?= base_url(); ?>items/1">Unfilled Items</a></li> -->
                                        <li><a href="<?= base_url(); ?>Page/perPlantillaGroup">Plantilla Group</a></li>
                                        <li><a href="<?= base_url(); ?>Page/plantillaPositions">Plantilla Positions</a></li>
                                        <li><a href="<?= base_url(); ?>Page/unfilledItems">Unfilled Items</a></li>
                                    </ul>
                                </li>
                                <li>
                                    <a href="javascript: void(0);" class="waves-effect">
                                        <i class="ion ion-ios-attach"></i>
                                        <span> Service Record </span>
                                        <span class="menu-arrow"></span>
                                    </a>
                                    <ul class="nav-second-level" aria-expanded="false">
                                        <li><a href="<?= base_url(); ?>Page/serviceRecord">Service Record List</a></li>
                                        <li><a href="<?= base_url(); ?>Page/empList">Service Record Printing</a></li>
                                        <li><a href="<?= base_url(); ?>Page/serviceRecordUploading">Bulk Upload</a></li>
                                        <li><a href="<?= base_url(); ?>Page/sr_request_list">SR Requests</a></li>
                                    </ul>
                                </li>
                                <li>
                                    <a href="javascript: void(0);" class="waves-effect">
                                        <i class="mdi mdi-check-underline-circle "></i>
                                        <span> Leave </span>
                                        <span class="menu-arrow"></span>
                                    </a>
                                    <ul class="nav-second-level" aria-expanded="false">
                                        <!-- <li><a href="#">Leave Application</a></li> -->
                                        <li><a href="<?= base_url(); ?>Page/leaveCredits">Generate Monthly LC</a></li>
                                        <li><a href="<?= base_url(); ?>Page/leaveCreditsMonthly">Monthly Leave Credits</a></li>
                                        <li><a href="<?= base_url(); ?>Page/leaveCreditsSummary">Leave Credits Summary</a></li>

                                    </ul>
                                </li>

                                <li>
                                    <a href="javascript: void(0);" class="waves-effect">
                                        <i class="fas fa-chalkboard-teacher"></i>
                                        <span> Recruitment </span>
                                        <span class="menu-arrow"></span>
                                    </a>
                                    <ul class="nav-second-level" aria-expanded="false">
                                        <li><a href="<?= base_url(); ?>Page/jobVacancy">Job Vacancies</a></li>
                                        <li><a href="<?= base_url(); ?>Pages/validated_applicant">Validated Applicants</a></li>
                                        <li><a href="<?= base_url(); ?>Pages/for_endorsement">For Endorsement</a></li>
                                        <li><a href="<?= base_url(); ?>Pages/endorsed_applicants">Endorsed Applicants</a></li>
                                        <li><a href="<?= base_url(); ?>Pages/rated_applicants">Rated Applicants</a></li>
                                        <li><a href="<?= base_url(); ?>Pages/query_applicants">Applicant Query</a></li>
                                        <li><a href="<?= base_url(); ?>Pages/confirmed_applicants">Confirmed Applicants</a></li>
                                        <li><a href="<?= base_url(); ?>Pages/dq_applicants">Disqualified Applicants</a></li>
                                        <li><a href="<?= base_url(); ?>Page/jobArchieved">Archived Vacancies</a></li>
                                        <li><a href="<?= base_url(); ?>Page/regApplicants">Registered Applicants</a></li>
                                        <li><a href="<?= base_url(); ?>Pages/regApplicantshire">Hired Applicants</a></li>
                                        <!-- <li><a href="<?= base_url(); ?>Page/appRatingUploading">Upload Applicant's Rating</a></li> -->
                                    </ul>
                                </li>

                                <li>
                                    <a href="javascript: void(0);" class="waves-effect">
                                        <i class="fas fa-scroll"></i>
                                        <spa>Implementation Plans</span>
                                            <span class="menu-arrow"></span>
                                    </a>
                                    <ul class="nav-second-level" aria-expanded="false">

                                        <li><a href="<?= base_url(); ?>Page/aip_sub">Submitted AIP</a></li>
                                        <li><a href="<?= base_url(); ?>Page/aip_stat">AIP Status</a></li>
                                        <li><a href="<?= base_url(); ?>Page/fy_setting">FY Settings</a></li>
                                    </ul>
                                </li>

                                <li>
                                    <a href="javascript: void(0);" class="waves-effect">
                                        <i class="mdi mdi-notebook-multiple "></i>
                                        <span>Learning and Dev't.</span>
                                        <span class="menu-arrow"></span>
                                    </a>
                                    <ul class="nav-second-level" aria-expanded="false">
                                        <li><a href="<?= base_url(); ?>Page/tnSummary">Training Needs</a></li>
                                        <li><a href="<?= base_url(); ?>Page/idHR">Development Plan</a></li>

                                    </ul>
                                </li>

                                <li>
                                    <a href="javascript: void(0);" class="waves-effect">
                                        <i class="ion ion-ios-school"></i>
                                        <span>Schools</span>
                                        <span class="menu-arrow"></span>
                                    </a>
                                    <ul class="nav-second-level" aria-expanded="false">
                                        <li><a href="<?= base_url(); ?>Pages/schools?type=Public">Public</a></li>
                                        <li><a href="<?= base_url(); ?>Pages/schools?type=Private">Private</a></li>
                                    </ul>
                                </li>

                                <li>
                                    <a href="javascript: void(0);" class="waves-effect">
                                        <i class=" ion ion-md-settings "></i>
                                        <span>System Settings</span>
                                        <span class="menu-arrow"></span>
                                    </a>
                                    <ul class="nav-second-level" aria-expanded="false">
                                        <li><a href="<?= base_url(); ?>Page/settings">Bulk Updating</a></li>
                                        <li><a href="<?= base_url(); ?>Page/tnCategory">Training Needs Category</a></li>

                                        <li><a href="<?= base_url(); ?>Pages/other_settings">Other Settings</a></li>

                                    </ul>
                                </li>


                                <li><a href="<?= base_url(); ?>users" class="waves-effect"><i class="ion ion-ios-person-add"></i><span> Manage Users </span></a></li>
                                <li><a href="<?= base_url(); ?>Page/empReports" class="waves-effect"><i class="mdi mdi-equalizer "></i><span> Reports </span></a></li>
                                <li><a href="<?= base_url(); ?>Page/systemFeedbackResults" class="waves-effect"><i class="fas fa-box "></i><span>System Feedback </span></a></li>
                                <li><a href="<?= base_url(); ?>Pages/mis_logs" class="waves-effect"><i class="fas fa-bars"></i><span>MIS Logs </span></a></li>
                                <li><a href="<?= base_url(); ?>Page/systemHelp" class="waves-effect"><i class=" fas fa-marker"></i><span>Help </span></a></li>


                            <?php elseif ($this->session->userdata('position') === 'HR Staff') : ?>
                                <li><a href="<?= base_url(); ?>" class="waves-effect"><i class="fas fa-user-alt"></i><span> Dashboard </span></a></li>
                                <li>
                                    <a href="javascript: void(0);" class="waves-effect">
                                        <i class="far fa-address-book "></i>
                                        <span> Personnel </span>
                                        <span class="menu-arrow"></span>
                                    </a>
                                    <ul class="nav-second-level" aria-expanded="false">
                                        <li><a href="<?= base_url(); ?>personnel">Master List</a></li>
                                        <li>
                                            <a href="javascript: void(0);" aria-expanded="false">Personnel List
                                                <span class="menu-arrow"></span>
                                            </a>
                                            <ul class="nav-third-level nav" aria-expanded="false">
                                                <li><a href="<?= base_url(); ?>Page/employeelistv1">GSIS, Pagibig, PhilHealth and TIN</a></li>
                                                <li><a href="<?= base_url(); ?>Page/employeelistv2">Orig. Appointment, Last Appointment, Retirement Year</a></li>
                                                <li><a href="<?= base_url(); ?>Page/employeelistv3">For Retirement</a></li>
                                                <li><a href="<?= base_url(); ?>Page/employeelistv4">Length of Service</a></li>
                                                <li><a href="<?= base_url(); ?>Page/employeelistv5">Employment Status</a></li>
                                                <li><a href="<?= base_url(); ?>Page/employeelistDepartment">Department</a></li>
                                            </ul>
                                        </li>
                                        <li><a href="<?= base_url(); ?>Page/pos_summary">Per Position Title</a></li>
                                        <!-- <li><a href="#">Per Date Hired</a></li> -->
                                        <li><a href="<?= base_url(); ?>Page/perAppointmentDate">Per Appointment Date</a></li>
                                        <li><a href="<?= base_url(); ?>Page/retirement">Per Retirement Year</a></li>
                                        <li><a href="<?= base_url(); ?>Page/sg_summary">Per Salary Grade</a></li>
                                        <li><a href="<?= base_url(); ?>Page/loyalty">Loyalty</a></li>
                                        <li><a href="<?= base_url(); ?>Page/viewfilesAll">201 Files</a></li>
                                    </ul>
                                </li>

                                <li>
                                    <a href="javascript: void(0);" class="waves-effect">
                                        <i class="mdi mdi-view-compact-outline "></i>
                                        <span> Plantilla </span>
                                        <span class="menu-arrow"></span>
                                    </a>
                                    <ul class="nav-second-level" aria-expanded="false">
                                        <!-- <li><a href="<?= base_url(); ?>items/0">Plantilla Positions</a></li> -->
                                        <!-- <li><a href="<?= base_url(); ?>items/1">Unfilled Items</a></li> -->
                                        <li><a href="<?= base_url(); ?>Page/perPlantillaGroup">Plantilla Group</a></li>
                                        <li><a href="<?= base_url(); ?>Page/plantillaPositions">Plantilla Positions</a></li>
                                        <li><a href="<?= base_url(); ?>Page/unfilledItems">Unfilled Items</a></li>
                                    </ul>
                                </li>
                                <li>
                                    <a href="javascript: void(0);" class="waves-effect">
                                        <i class="ion ion-ios-attach"></i>
                                        <span> Service Record </span>
                                        <span class="menu-arrow"></span>
                                    </a>
                                    <ul class="nav-second-level" aria-expanded="false">
                                        <li><a href="<?= base_url(); ?>Page/serviceRecord">Service Record List</a></li>
                                        <li><a href="<?= base_url(); ?>Page/empList">Service Record Printing</a></li>
                                        <li><a href="<?= base_url(); ?>Page/serviceRecordUploading">Bulk Upload</a></li>
                                        <li><a href="<?= base_url(); ?>Page/sr_request_list">SR Requests</a></li>
                                    </ul>
                                </li>
                                <li>
                                    <a href="javascript: void(0);" class="waves-effect">
                                        <i class="mdi mdi-check-underline-circle "></i>
                                        <span> Leave </span>
                                        <span class="menu-arrow"></span>
                                    </a>
                                    <ul class="nav-second-level" aria-expanded="false">
                                        <li><a href="<?= base_url(); ?>Page/leaveCredits">Generate Monthly LC</a></li>
                                        <li><a href="<?= base_url(); ?>Page/leaveCreditsMonthly">Monthly Leave Credits</a></li>
                                        <li><a href="<?= base_url(); ?>Page/leaveCreditsSummary">Leave Credits Summary</a></li>
                                    </ul>
                                </li>

                                <li>
                                    <a href="javascript: void(0);" class="waves-effect">
                                        <i class="fas fa-chalkboard-teacher"></i>
                                        <span> Recruitment </span>
                                        <span class="menu-arrow"></span>
                                    </a>
                                    <ul class="nav-second-level" aria-expanded="false">
                                        <li><a href="<?= base_url(); ?>Page/jobVacancy">Job Vacancies</a></li>
                                        <li><a href="<?= base_url(); ?>Page/jobArchieved">Archived Vacancies</a></li>
                                        <li><a href="<?= base_url(); ?>Page/regApplicants">Registered Applicants</a></li>
                                        <li><a href="<?= base_url(); ?>Page/appRatingUploading">Upload Applicant's Rating</a></li>

                                    </ul>
                                </li>

                                <li>
                                    <a href="javascript: void(0);" class="waves-effect">
                                        <i class="mdi mdi-notebook-multiple "></i>
                                        <span>Learning and Dev't.</span>
                                        <span class="menu-arrow"></span>
                                    </a>
                                    <ul class="nav-second-level" aria-expanded="false">
                                        <li><a href="<?= base_url(); ?>Page/tnSummary">Training Needs</a></li>
                                        <li><a href="<?= base_url(); ?>Page/idHR">Development Plan</a></li>

                                    </ul>
                                </li>


                                <li>
                                    <a href="javascript: void(0);" class="waves-effect">
                                        <i class=" ion ion-md-settings "></i>
                                        <span>System Settings</span>
                                        <span class="menu-arrow"></span>
                                    </a>
                                    <ul class="nav-second-level" aria-expanded="false">
                                        <li><a href="<?= base_url(); ?>Page/settings">Bulk Updating</a></li>
                                        <li><a href="<?= base_url(); ?>Page/tnCategory">Training Needs Category</a></li>

                                        <li><a href="<?= base_url(); ?>Pages/other_settings">Other Settings</a></li>

                                    </ul>
                                </li>

                                <!-- <li><a href="<?= base_url(); ?>users" class="waves-effect"><i class="ion ion-ios-person-add"></i><span> Manage Users </span></a></li> -->
                                <li><a href="<?= base_url(); ?>Page/empReports" class="waves-effect"><i class="mdi mdi-equalizer "></i><span> Reports </span></a></li>
                                <li><a href="<?= base_url(); ?>Page/systemFeedback" class="waves-effect"><i class="fas fa-box "></i><span>System Feedback Form </span></a></li>
                                <li><a href="<?= base_url(); ?>Page/systemHelp" class="waves-effect"><i class=" fas fa-marker"></i><span>Help </span></a></li>


                            <?php elseif ($this->session->userdata('position') === 'SHNS') : ?>
                                <li><a href="#" class="waves-effect"><i class="fas fa-user-alt"></i><span> Dashboard </span></a></li>
                                <li>
                                    <a href="javascript: void(0);" class="waves-effect">
                                        <i class="far fa-address-book"></i>
                                        <span> Medical </span>
                                        <span class="menu-arrow"></span>
                                    </a>
                                    <ul class="nav-second-level" aria-expanded="false">
                                        <li>
                                            <a href="javascript:void(0);" class="has-arrow">Consultations</a>
                                            <ul class="nav-third-level" aria-expanded="false">
                                                <li><a href="<?= base_url(); ?>Page/med_patient">Employee</a></li>
                                                <li><a href="<?= base_url(); ?>Page/med_patient_student">Student</a></li>
                                            </ul>
                                        </li>
                                        <li>
                                            <!-- <a href="<?= base_url(); ?>Page/med_patient_pending">Pending Consultations</a> -->
                                        </li>
                                        <li>
                                            <a href="<?= base_url(); ?>Page/lab_request">Laboratory Request</a>
                                        </li>
                                    </ul>
                                </li>

                                <li>
                                    <a href="<?= base_url(); ?>Page/med_healthRecDash" class="waves-effect">
                                        <i class="fas fa-notes-medical"></i>
                                        <span>Health Examination</span>
                                    </a>
                                </li>



                                <li>
                                    <a href="javascript: void(0);" class="waves-effect">
                                        <i class="mdi mdi-view-compact-outline "></i>
                                        <span> SBFP </span>
                                        <span class="menu-arrow"></span>
                                    </a>
                                    <ul class="nav-second-level" aria-expanded="false">
                                        <li><a href="<?= base_url(); ?>Sbfp/sbfp_bmi_dn_form">Nutritional Status Report</a></li>
                                        <!-- <li><a href="<?= base_url(); ?>Sbfp/sbfp_div_report">Nutritional Status</a></li>
                                        <li><a href="<?= base_url(); ?>Page/sbfp_form">SBFP Data</a></li>
                                        <li><a href="<?= base_url(); ?>Page/baseline" target="_blank">Baseline Weighing</a></li>
                                        <li><a href="<?= base_url(); ?>Page/baseline2nd" target="_blank">Second Weighing</a></li>
                                        <li><a href="<?= base_url(); ?>Page/baseline3nd" target="_blank">Third Weighing</a></li>
                                        <li><a href="<?= base_url(); ?>Page/sbfp_form1" target="_blank">Form 1</a></li>
                                        <li><a href="<?= base_url(); ?>Page/sbfp_form2" target="_blank">Form 2</a></li>
                                        <li><a href="<?= base_url(); ?>Page/sbfp_form3" target="_blank">Form 3</a></li>
                                        <li><a href="<?= base_url(); ?>Page/sbfp_sf8" target="_blank"><i class="mdi mdi-file-document-box-check-outline"></i>SF 8</a></li> -->
                                    </ul>
                                </li>





                                <li>
                                    <a href="javascript: void(0);" class="waves-effect">
                                        <i class="mdi mdi-view-compact-outline "></i>
                                        <span> Reports </span>
                                        <span class="menu-arrow"></span>
                                    </a>
                                    <ul class="nav-second-level" aria-expanded="false">
                                        <!-- <li><a href="#">Medical Certificate</a></li> -->
                                        <li><a href="<?= base_url(); ?>Page/med_patient_count">Patients Summary</a></li>
                                        <!-- <li><a href="#">Patient's Case Summary</a></li> -->
                                    </ul>
                                </li>


                                <li>
                                    <a href="javascript: void(0);" class="waves-effect">
                                        <i class=" ion ion-md-settings"></i>
                                        <span> Settings </span>
                                        <span class="menu-arrow"></span>
                                    </a>
                                    <ul class="nav-second-level" aria-expanded="false">
                                        <li><a href="<?= base_url(); ?>Page/med_disease">Diseases</a></li>
                                        <li><a href="<?= base_url(); ?>Page/med_disposition">Disposition</a></li>

                                    </ul>
                                </li>

                                <li><a data-toggle="modal" data-id="<?= $id; ?>" class="open-AddBookDialog" href="#change_pass"><i class="fas fa-unlock-alt"></i><span> Change Password </span></a></li>
                                <!-- <li><a href="<?= base_url(); ?>Page/med_settings" class="waves-effect"><i class=" fas fa-marker"></i><span>E - signature </span></a></li> -->

                                <li><a href="<?= base_url(); ?>Users/users_sub" class="waves-effect"><i class="fas fa-user-tie"></i>Manage Sub Users</a></li>

                                <li><a href="<?= base_url(); ?>Page/systemFeedback" class="waves-effect"><i class="fas fa-box "></i><span>System Feedback Form </span></a></li>
                                <li><a href="<?= base_url(); ?>Page/systemHelp" class="waves-effect"><i class=" fas fa-marker"></i><span>Help </span></a></li>








                            <?php elseif ($this->session->userdata('position') === 'Endorser') : ?>

                                <li><a href="<?= base_url(); ?>"><i class="mdi mdi-view-dashboard"></i>Dashboard</a></li>
                                <li>
                                    <a href="javascript: void(0);" class="waves-effect">
                                        <i class="mdi mdi-check-underline-circle "></i>
                                        <span> Leave </span>
                                        <span class="menu-arrow"></span>
                                    </a>
                                    <ul class="nav-second-level" aria-expanded="false">
                                        <!-- <li><a href="#">Leave Application</a></li> -->
                                        <li><a href="<?= base_url(); ?>Page/leaveCredits">Generate Monthly LC</a></li>
                                        <li><a href="<?= base_url(); ?>Page/leaveCreditsMonthly">Monthly Leave Credits</a></li>
                                        <li><a href="<?= base_url(); ?>Page/leaveCreditsSummary">Leave Credits Summary</a></li>
                                        <li><a href="<?= base_url(); ?>Page/leave_credits_approval">COC Credits</a></li>
                                    </ul>
                                </li>



                                <!-- Applicants Sidebar -->
                            <?php elseif ($this->session->userdata('position') === 'reg') : ?>

                                <li><a href="<?= base_url(); ?>Pages/view_user" class="waves-effect"><i class="fas fa-user-alt"></i><span> Dashboard </span></a></li>
                                <li>
                                    <a href="javascript: void(0);" class="waves-effect">
                                        <i class="fas fa-chalkboard-teacher"></i>
                                        <span> Recruitment </span>
                                        <span class="menu-arrow"></span>
                                    </a>
                                    <ul class="nav-second-level" aria-expanded="false">
                                        <li><a href="<?= base_url(); ?>Page/jobVacancy">Job Vacancies</a></li>
                                        <!-- <li><a href="<?= base_url(); ?>Page/myApplications">History</a></li>  -->
                                        <li><a href="<?= base_url(); ?>Pages/ja/<?= $this->session->c_id; ?>">My Application</a></li>
                                        <li><a href="<?= base_url(); ?>Pages/request_rating_applicant">Retained request</a></li>
                                        <li><a href="<?= base_url(); ?>Pages/ah/<?= $this->session->c_id; ?>">Application History</a></li>

                                    </ul>
                                </li>
                                <li><a data-toggle="modal" data-id="<?= $id; ?>" class="open-AddBookDialog" href="#change_pass"><i class="fas fa-user-alt"></i><span> Change Password </span></a></li>
                                <li><a href="<?= base_url(); ?>Page/systemFeedback" class="waves-effect"><i class="fas fa-box "></i><span>System Feedback Form </span></a></li>

                                <!-- Employee Sidebar -->
                            <?php elseif ($this->session->userdata('position') === 'user') : ?>

                                <li><a href="<?= base_url(); ?>Pages/view_employee" class="waves-effect"><i class="fas fa-user-alt"></i><span> Dashboard </span></a></li>
                                <li><a href="<?= base_url(); ?><?php $ses = $this->session->position;
                                                                $id = $this->session->c_id;
                                                                if ($ses == "user") {
                                                                    echo "personnel_profile/" . $id;
                                                                } elseif ($ses == "reg") {
                                                                    echo "registered_profile/" . $id;
                                                                } else {
                                                                    echo "";
                                                                } ?>" class="waves-effect"><i class="ion ion-md-contacts "></i><span>My Profile </span></a></li>
                                <li><a href="<?= base_url(); ?>Page/trainingNeeds" class="waves-effect"><i class="ion ion-ios-checkbox-outline"></i><span>Training Needs </span></a></li>

                                <li><a href="<?= base_url(); ?>Page/individualDevelopment" class="waves-effect"><i class="ion ion-ios-filing "></i><span>Individual Development </span></a></li>
                                <li><a href="<?= base_url(); ?>Page/empServiceRecord" class="waves-effect"><i class=" ion ion-ios-attach"></i><span>Service Record </span></a></li>
                                <li>
                                    <a href="javascript: void(0);" class="waves-effect">
                                        <i class="fas fa-cash-register"></i>
                                        <span> Payroll </span>
                                        <span class="menu-arrow"></span>
                                    </a>
                                    <ul class="nav-second-level" aria-expanded="false">
                                        <li><a href="<?= base_url(); ?>Page/empSalaryHistory">Salary History</a></li>
                                        <li><a href="<?= base_url(); ?>Page/mandatoryDed">Monthly Mandatory Deductions</a></li>
                                        <li><a href="<?= base_url(); ?>Page/empLoans">Current Loans</a></li>
                                        <li><a href="<?= base_url(); ?>Page/empBenefits">Other Benefits</a></li>
                                    </ul>
                                </li>

                                <li>
                                    <a href="javascript: void(0);" class="waves-effect">
                                        <i class="mdi mdi-check-underline-circle "></i>
                                        <span> Leave </span>
                                        <span class="menu-arrow"></span>
                                    </a>
                                    <ul class="nav-second-level" aria-expanded="false">
                                        <li><a href="<?= base_url(); ?>Page/leaveApplications">Leave Application</a></li>
                                        <li><a href="<?= base_url(); ?>Page/leave_credits">COC credits</a></li>
                                        <li><a href="<?= base_url(); ?>Page/LeaveSettings">Leave Settings</a></li>

                                        <?php if (!empty($is_endorser) && $is_endorser): ?>
                                            <li><a href="<?= base_url(); ?>Page/LeaveRecommendation">Leave Recommendation</a></li>
                                        <?php endif; ?>
                                    </ul>

                                </li>
                                <li>
                                    <a href="javascript: void(0);" class="waves-effect">
                                        <i class="fas fa-angle-double-right"></i>
                                        <span> Request </span>
                                        <span class="menu-arrow"></span>
                                    </a>
                                    <ul class="nav-second-level" aria-expanded="false">
                                        <li><a href="<?= base_url(); ?>Page/sr_request">Service Record</a></li>
                                    </ul>
                                </li>

                               <!-- Enrollment begin -->
                                <?php 
                                    $cstaff = $this->Common->one_cond_row('sections','IDNumber', $this->session->username); 
                                    if(!empty($cstaff)){
                                ?>


                                <li>
                                    <a href="javascript: void(0);" class="waves-effect">
                                        <i class="fas fa-user-plus"></i>
                                        <span> Enrollment </span>
                                        <span class="menu-arrow"></span>
                                    </a>
                                    <ul class="nav-second-level" aria-expanded="false">
                                        <li><a href="<?= base_url(); ?>Enrollment/profileList">Student's Profile</a></li>
                                        <li><a href="<?= base_url(); ?>Masterlist/enrolledList">Enrollment</a></li>

                                        <li>
                                            <a href="javascript: void(0);" class="waves-effect">
                                                <span> Enrollment Settings</span>
                                                <span class="menu-arrow"></span>
                                            </a>
                                            <ul class="nav-second-level" aria-expanded="false">
                                                <li><a href="<?= base_url(); ?>Page/ethnicity">Ethnicity</a></li>
                                                <li><a href="<?= base_url(); ?>Page/religion">Religion</a></li>
                                                <li><a href="<?= base_url(); ?>Page/prevschool">Previous Schools</a></li>
                                                <li><a href="<?= base_url(); ?>Page/program">Programs</a></li>
                                                <li><a href="<?= base_url(); ?>Sbfp/SectionAdviser">Sections</a></li>
                                                <li><a href="<?= base_url(); ?>Sbfp/grade_level_add">Grade Level</a></li>
                                                <li><a href="<?= base_url(); ?>Sbfp/track_and_strand_list">Track and Strand</a></li>
                                            </ul>
                                        </li>

                                    </ul>
                                </li>
                                <?php } ?>

                                <!-- Enrollment end -->


                                <li>
                                    <a href="javascript: void(0);" class="waves-effect">
                                        <i class="fas fa-chalkboard-teacher "></i>
                                        <span> Recruitment </span>
                                        <span class="menu-arrow"></span>
                                    </a>
                                    <ul class="nav-second-level" aria-expanded="false">
                                        <li><a href="<?= base_url(); ?>Page/jobVacancy">Job Vacancies</a></li>
                                        <li><a href="<?= base_url(); ?>Pages/ja/<?= $this->session->c_id; ?>">My Application</a></li>
                                        <li><a href="<?= base_url(); ?>Pages/ah/<?= $this->session->c_id; ?>">Application History</a></li>
                                    </ul>
                                </li>

                                <li>
                                    <a href="javascript: void(0);" class="waves-effect">
                                        <i class="fas fa-box "></i>
                                        <span> Authority to Travel </span>
                                        <span class="menu-arrow"></span>
                                    </a>
                                    <ul class="nav-second-level" aria-expanded="false">
                                        <li><a href="<?= base_url(); ?>Travel/travel_sign_settings">Settings</a></li>
                                        <li><a href="<?= base_url(); ?>Travel">Request</a></li>
                                        <?php
                                        $ts = $this->Common->one_cond_count_row('travel_sign_settings', 'staff_id', $this->session->c_id);
                                        if ($ts->num_rows() >= 1) {
                                        ?>
                                            <li><a href="<?= base_url(); ?>Travel/travel_request_for_action">For Action</a></li>
                                        <?php } ?>
                                    </ul>
                                </li>

                                <!-- <li><a href="<?= base_url(); ?>Travel/" class="waves-effect"><i class="fas fa-box "></i><span>Authority to Travel </span></a></li> -->

                                <li>
                                    <a href="javascript: void(0);" class="waves-effect">
                                        <i class="ion ion-md-paper"> </i>
                                        <span> To Do </span>
                                        <span class="menu-arrow"></span>
                                    </a>
                                    <ul class="nav-second-level" aria-expanded="false">
                                        <li><a href="<?= base_url(); ?>ToDo/">ToDo</a></li>
                                    </ul>
                                </li>


                                <li>
                                    <a href="<?= base_url(); ?>Calendar/" target="_blank" class=" waves-effect">
                                        <i class="ion ion-md-paper"> </i>
                                        <span> Calendar </span>

                                    </a>

                                </li>

                                <li>
                                    <a href="<?= base_url(); ?>Note/" class=" waves-effect">
                                        <i class="ion ion-md-paper"> </i>
                                        <span> Notes </span>

                                    </a>

                                </li>
                                <li><a href="<?= base_url(); ?>Page/systemFeedback" class="waves-effect"><i class="fas fa-box "></i><span>System Feedback Form </span></a></li>


                                <li><a data-toggle="modal" data-id="<?= $id; ?>" class="open-AddBookDialog" href="#change_pass"><i class="fas fa-user-alt"></i><span> Change Password </span></a></li>
                                <!-- <li><a href="<?= base_url(); ?>Page/changepassword/" class="waves-effect"><i class="ion ion-ios-keypad "></i><span>Change Password </span></a></li> -->
                                <!-- <li>
                       <a href="javascript: void(0);" class="waves-effect">
                               <i class="far fa-address-book "></i>
                               <span> Recruitment </span>
                               <span class="menu-arrow"></span>
                           </a>
                           <ul class="nav-second-level" aria-expanded="false">
                               <li><a href="<?= base_url(); ?>Page/jobVacancy">Job Vacancies</a></li>
                               <li><a href="<?= base_url(); ?>Page/myApplications">My Applications</a></li>
                           </ul>
                   </li> -->

                                <!-- Request Email Sidebar -->
                            <?php elseif ($this->session->userdata('position') === 'readmin') : ?>
                                <li><a href="<?= base_url(); ?>" class="waves-effect"><i class="mdi mdi-monitor-dashboard"></i><span> Dashboard </span></a></li>
                                <li><a href="<?= base_url(); ?>Page/aip_sub_sned"><i class="fas fa-scroll"></i>sample</a></li>

                                <!-- SMME Sidebar -->
                            <?php elseif ($this->session->userdata('position') === 'smme') : ?>
                                <li><a href="<?= base_url(); ?>" class="waves-effect"><i class="mdi mdi-monitor-dashboard"></i><span> Dashboard </span></a></li>
                                <li>
                                    <a href="javascript: void(0);" class="waves-effect">
                                        <i class="fas fa-scroll"></i>
                                        <spa>Implementation Plans</span>
                                            <span class="menu-arrow"></span>
                                    </a>
                                    <ul class="nav-second-level" aria-expanded="false">

                                        <li><a href="<?= base_url(); ?>Page/aip_sub">Submitted AIP</a></li>
                                        <li><a href="<?= base_url(); ?>Page/smea_admin">Submitted SMEA</a></li>
                                        <li><a href="<?= base_url(); ?>Page/aip_stat">AIP Status</a></li>
                                        <li><a href="<?= base_url(); ?>Page/fy_setting">FY Settings</a></li>
                                    </ul>
                                </li>

                                <li>
                                    <a href="javascript: void(0);" class="waves-effect">
                                        <i class="fas fa-user-plus"></i>
                                        <span> SBM </span>
                                        <span class="menu-arrow"></span>
                                    </a>
                                    <ul class="nav-second-level" aria-expanded="false">
                                        <li><a href="<?= base_url(); ?>Page/sbm">Principles</a></li>
                                        <li><a href="<?= base_url(); ?>Page/sbm_sub">Indicators</a></li>
                                        <li><a href="<?= base_url(); ?>Page/sbm_districts">SBM District List</a></li>
                                        <li><a href="<?= base_url(); ?>Page/sbm_list">Self-Assesment Checklist</a></li>
                                    </ul>
                                </li>

                                <li><a data-toggle="modal" data-id="<?= $id; ?>" class="open-AddBookDialog" href="#change_pass"><i class="fas fa-unlock-alt"></i><span> Change Password </span></a></li>

                                <li><a href="<?= base_url(); ?>logout" class="waves-effect"><i class="fas fa-arrow-circle-left "></i><span>Logout </span></a></li>

                                <!-- SocMob Sidebar -->
                            <?php elseif ($this->session->userdata('position') === 'socmob') : ?>
                                <li><a href="<?= base_url(); ?>" class="waves-effect"><i class="mdi mdi-monitor-dashboard"></i><span> Dashboard </span></a></li>


                                <li>
                                    <a href="javascript: void(0);" class="waves-effect">
                                        <i class="fas fa-user-plus"></i>
                                        <span> Brigada Eskwela</span>
                                        <span class="menu-arrow"></span>
                                    </a>
                                    <ul class="nav-second-level" aria-expanded="false">
                                        <li><a href="<?= base_url(); ?>Brigada/spc_districts" target="_blank">School Preparedness</a></li>
                                        <li><a href="<?= base_url(); ?>Brigada/spc_admin_report" target="_blank">SPC Report</a></li>
                                        <li><a href="<?= base_url(); ?>Brigada/brigada_summary" target="_blank">Summary Report</a></li>
                                        <li><a href="<?= base_url(); ?>Brigada/brigada_mon_tools_districts" target="_blank">Monitoring Tool</a></li>
                                        <!-- <li><a href="<?= base_url(); ?>Brigada/brigada_partner_summary" target="_blank">Partner</a></li> -->
                                        <li><a href="javascript: void(0);" aria-expanded="false">Partner<span class="menu-arrow"></span></a>
                                            <ul class="nav-third-level nav" aria-expanded="false">
                                                <li><a href="<?= base_url(); ?>Brigada/brigada_partner_summary/1">Government</a></li>
                                                <li><a href="<?= base_url(); ?>Brigada/brigada_partner_summary/2">Private</a></li>
                                            </ul>
                                        </li>

                                    </ul>
                                </li>

                                <li><a data-toggle="modal" data-id="<?= $id; ?>" class="open-AddBookDialog" href="#change_pass"><i class="fas fa-unlock-alt"></i><span> Change Password </span></a></li>

                                <li><a href="<?= base_url(); ?>logout" class="waves-effect"><i class="fas fa-arrow-circle-left "></i><span>Logout </span></a></li>

                                <!-- SBCP Sidebar -->
                            <?php elseif ($this->session->userdata('position') === 'sbcp') : ?>
                                <li><a href="<?= base_url(); ?>" class="waves-effect"><i class="mdi mdi-monitor-dashboard"></i><span> Dashboard </span></a></li>


                                <li>
                                    <a href="javascript: void(0);" class="waves-effect">
                                        <i class="fas fa-user-plus"></i>
                                        <span> SBCP Monitoring Tool</span>
                                        <span class="menu-arrow"></span>
                                    </a>
                                    <ul class="nav-second-level" aria-expanded="false">
                                        <li><a href="<?= base_url(); ?>Page/sbcp_list">Functionality Indicators</a></li>
                                        <li><a href="<?= base_url(); ?>Page/sbcp_list">Intake Sheet</a></li>
                                        <li><a href="<?= base_url(); ?>Page/sbcp_list">Confession</a></li>
                                    </ul>
                                </li>

                                <li><a data-toggle="modal" data-id="<?= $id; ?>" class="open-AddBookDialog" href="#change_pass"><i class="fas fa-unlock-alt"></i><span> Change Password </span></a></li>

                                <li><a href="<?= base_url(); ?>logout" class="waves-effect"><i class="fas fa-arrow-circle-left "></i><span>Logout </span></a></li>




                                <!-- SMME Sidebar -->
                            <?php elseif ($this->session->userdata('position') === 'sned') : ?>
                                <li><a href="<?= base_url(); ?>" class="waves-effect"><i class="mdi mdi-monitor-dashboard"></i><span> Dashboard </span></a></li>
                                <li><a href="<?= base_url(); ?>Page/aip_sub_sned"><i class="fas fa-scroll"></i>Implementation Plans</a></li>


                                <li><a data-toggle="modal" data-id="<?= $id; ?>" class="open-AddBookDialog" href="#change_pass"><i class="fas fa-unlock-alt"></i><span> Change Password </span></a></li>

                                <li><a href="<?= base_url(); ?>logout" class="waves-effect"><i class="fas fa-arrow-circle-left "></i><span>Logout </span></a></li>





                                <!-- School Sidebar -->
                            <?php elseif ($this->session->userdata('position') === 'School') : ?>
                                <li><a href="<?= base_url(); ?>Page/schoolDashboard" class="waves-effect"><i class="mdi mdi-monitor-dashboard"></i><span> Dashboard </span></a></li>
                                <li><a href="<?= base_url(); ?>Page/schoolProfile" class="waves-effect"><i class="mdi mdi-school"></i><span>School Profile </span></a></li>

                                <li>
                                    <a href="javascript: void(0);" class="waves-effect">
                                        <i class="ion ion-ios-checkbox-outline"></i>
                                        <span> HRIS </span>
                                        <span class="menu-arrow"></span>
                                    </a>
                                    <ul class="nav-second-level nav" aria-expanded="false">
                                        <li><a href="<?= base_url(); ?>Page/employeelist" class="waves-effect"><span>School Personnel </span></a></li>
                                        <li><a href="<?= base_url(); ?>Page/step_increment_school" class="waves-effect"><span>For Step Increment </span></a></li>
                                        <li><a href="<?= base_url(); ?>Page/for_retirement_school" class="waves-effect">For Retirement </span></a></li>
                                        <li><a href="<?= base_url(); ?>Page/service_lenght" class="waves-effect"><span>Length of Service </span></a></li>

                                        <li>
                                            <a href="javascript: void(0);" aria-expanded="false">Service Record
                                                <span class="menu-arrow"></span>
                                            </a>
                                            <ul class="nav-third-level nav" aria-expanded="false">
                                                <li><a href="<?= base_url(); ?>Page/serviceRecord">Service Record</a></li>
                                                <!-- <li><a href="<?= base_url(); ?>Page/emp_list_dept">Service Record Printing</a></li> -->
                                                <li><a href="<?= base_url(); ?>Page/serviceRecordUploading">Bulk Upload</a></li>
                                            </ul>
                                        </li>
                                        <li>
                                            <a href="javascript: void(0);" class="waves-effect">
                                                <span> Leave </span>
                                                <span class="menu-arrow"></span>
                                            </a>
                                            <ul class="nav-second-level" aria-expanded="false">
                                                <li><a href="<?= base_url(); ?>Page/leaveCreditsSummary">Leave Credits Summary</a></li>
                                            </ul>
                                        </li>
                                    </ul>
                                </li>


                                <li>
                                    <a href="javascript: void(0);" class="waves-effect">
                                        <i class="fas fa-chalkboard-teacher"></i>
                                        <span>Recruitment </span>
                                        <span class="menu-arrow"></span>
                                    </a>
                                    <ul class="nav-second-level" aria-expanded="false">
                                        <li><a href="<?= base_url(); ?>Page/jobVacancy">Job Vacancies</a></li>
                                        <li><a href="<?= base_url(); ?>Pages/applicant_list">List of Applicants</a></li>
                                        <li><a href="<?= base_url(); ?>Pages/validated_applicant">Validated Applicants</a></li>
                                    </ul>
                                </li>

                                <!-- <li>
                                    <a href="javascript: void(0);" class="waves-effect">
                                        <i class="fas fa-user-plus"></i>
                                        <span> Brigada Eskwela</span>
                                        <span class="menu-arrow"></span>
                                    </a>
                                    <ul class="nav-second-level" aria-expanded="false">
                                        <li><a href="<?= base_url(); ?>Brigada/" target="_blank">BE Form 01</a></li>
                                        <li><a href="<?= base_url(); ?>Brigada/kra_planning_form" target="_blank">BE Form 02</a></li>

                                    </ul>
                                </li> -->

                                <li>
                                    <a href="javascript: void(0);" class="waves-effect">
                                        <i class="fas fa-user-plus"></i>
                                        <span> Brigada Eskwela</span>
                                        <span class="menu-arrow"></span>
                                    </a>
                                    <ul class="nav-second-level" aria-expanded="false">
                                        <li><a href="<?= base_url(); ?>Brigada/brigada_spc" target="_blank">School Preparedness</a></li>
                                        <li><a href="<?= base_url(); ?>Brigada/be_daily_report" target="_blank">Daily Report</a></li>
                                        <li><a href="<?= base_url(); ?>Brigada/brigada_mon_tools_school_view" target="_blank">Monitoring Tool</a></li>
                                        <li><a href="<?= base_url(); ?>Brigada/partner_list" target="_blank">Partner</a></li>
                                    </ul>
                                </li>

                                <li>
                                    <a href="javascript: void(0);" class="waves-effect">
                                        <i class="fas fa-user-plus"></i>
                                        <span> Enrollment </span>
                                        <span class="menu-arrow"></span>
                                    </a>
                                    <ul class="nav-second-level" aria-expanded="false">
                                        <li><a href="<?= base_url(); ?>Enrollment/profileList">Student's Profile</a></li>
                                        <li><a href="<?= base_url(); ?>Masterlist/enrolledList">Enrollment</a></li>

                                        <li>
                                            <a href="javascript: void(0);" class="waves-effect">
                                                <span> Enrollment Settings</span>
                                                <span class="menu-arrow"></span>
                                            </a>
                                            <ul class="nav-second-level" aria-expanded="false">
                                                <li><a href="<?= base_url(); ?>Page/ethnicity">Ethnicity</a></li>
                                                <li><a href="<?= base_url(); ?>Page/religion">Religion</a></li>
                                                <li><a href="<?= base_url(); ?>Page/prevschool">Previous Schools</a></li>
                                                <li><a href="<?= base_url(); ?>Page/program">Programs</a></li>
                                                <li><a href="<?= base_url(); ?>Sbfp/SectionAdviser">Sections</a></li>
                                                <li><a href="<?= base_url(); ?>Sbfp/grade_level_add">Grade Level</a></li>
                                                <li><a href="<?= base_url(); ?>Sbfp/track_and_strand_list">Track and Strand</a></li>
                                            </ul>
                                        </li>

                                    </ul>
                                </li>


                                <li>
                                    <a href="javascript: void(0);" class="waves-effect">
                                        <i class="fas fa-user-plus"></i>
                                        <span> SBFP </span>
                                        <span class="menu-arrow"></span>
                                    </a>
                                    <ul class="nav-second-level" aria-expanded="false">
                                        <!-- <li><a href="<?= base_url(); ?>Sbfp/sbfp_nut_stat" target="_blank">Nutritional Status</a></li> -->
                                        <!-- <li><a href="<?= base_url(); ?>Sbfp/sbfp_bmi">Nutritional Status</a></li> -->

                                        <li><a href="<?= base_url(); ?>Sbfp/sbfp_bmi">Nutritional Status Report</a></li>
                                        <!-- <li><a href="<?= base_url(); ?>Page/baseline" target="_blank">Baseline Weighing</a></li>
                                        <li><a href="<?= base_url(); ?>Page/baseline2nd" target="_blank">Second Weighing</a></li>
                                        <li><a href="<?= base_url(); ?>Page/baseline3nd" target="_blank">Third Weighing</a></li>
                                        <li><a href="<?= base_url(); ?>Page/sbfp_form1" target="_blank">Form 1</a></li>
                                        <li><a href="<?= base_url(); ?>Page/sbfp_form2" target="_blank">Form 2</a></li>
                                        <li><a href="<?= base_url(); ?>Page/sbfp_sf8" target="_blank">SF 8</a></li> -->

                                    </ul>
                                </li>

                                <!-- <li>
                                    <a href="javascript: void(0);" class="waves-effect">
                                        <i class="mdi mdi-share-variant"></i>
                                        <span> Multi Level </span>
                                        <span class="menu-arrow"></span>
                                    </a>
                                    <ul class="nav-second-level nav" aria-expanded="false">
                                        <li>
                                            <a href="javascript: void(0);">Level 1.1</a>
                                        </li>
                                        <li>
                                            <a href="javascript: void(0);" aria-expanded="false">Level 1.2
                                                <span class="menu-arrow"></span>
                                            </a>
                                            <ul class="nav-third-level nav" aria-expanded="false">
                                                <li>
                                                    <a href="javascript: void(0);">Level 2.1</a>
                                                </li>
                                                <li>
                                                    <a href="javascript: void(0);">Level 2.2</a>
                                                </li>
                                            </ul>
                                        </li>
                                    </ul>
                                </li> -->


                                <li>
                                    <a href="javascript: void(0);" class="waves-effect">
                                        <i class="mdi mdi-notebook-multiple"></i>
                                        <span> Implementation Plans </span>
                                        <span class="menu-arrow"></span>
                                    </a>
                                    <ul class="nav-second-level" aria-expanded="false">
                                        <li><a href="<?= base_url(); ?>Page/school_allocations2">Fund Allocation</a></li>
                                        <li><a href="<?= base_url(); ?>page/view_sip">SIP</a></li>
                                        <!-- <li><a href="<?= base_url(); ?>page/implementation_plans">Plans</a></li> -->
                                        <li><a href="<?= base_url(); ?>page/fy_setting_school">Plans</a></li>
                                        <li><a href="<?= base_url(); ?>Page/liquidation" class="waves-effect">Liquidation</a></li>
                                        <li>
                                            <a href="javascript: void(0);" class="waves-effect">
                                                <span> IP Settings</span>
                                                <span class="menu-arrow"></span>
                                            </a>
                                            <ul class="nav-second-level" aria-expanded="false">
                                                <li><a href="<?= base_url(); ?>Page/settings_pias">PIAs</a></li>
                                                <li><a href="<?= base_url(); ?>Page/settings_bs">Budget Source</a></li>
                                            </ul>
                                        </li>
                                    </ul>

                                </li>

                                <!-- <li>
                                    <a href="<?= base_url(); ?>Page/smeav2" class="waves-effect">
                                        <i class="mdi mdi-format-list-checks"></i>
                                        <span> SMEA</span>
                                    </a>
                                    <ul class="nav-second-level" aria-expanded="false">
                                        <li><a href="<?= base_url(); ?>Page/smeav2?quarter=1st%20Quarter">1st Quarter</a></li>
                                        <li><a href="<?= base_url(); ?>Page/smea?quarter=1st%20Quarter">1st Quarter</a></li>
                                        <li><a href="<?= base_url(); ?>Page/smea?quarter=2nd%20Quarter">2nd Quarter</a></li>
                                        <li><a href="<?= base_url(); ?>Page/smea?quarter=3rd%20Quarter">3rd Quarter</a></li>
                                        <li><a href="<?= base_url(); ?>Page/smea?quarter=4th%20Quarter">4th Quarter</a></li>

                                    </ul>
                                </li> -->




                                <li>
                                    <a href="javascript: void(0);" class="waves-effect">
                                        <i class="mdi mdi-format-list-checks"></i>
                                        <span> SBM</span>
                                        <span class="menu-arrow"></span>
                                    </a>
                                    <ul class="nav-second-level" aria-expanded="false">
                                        <li><a href="<?= base_url(); ?>Page/sbm_action_plan">Action Plan</a></li>
                                        <li><a href="<?= base_url(); ?>Page/sbm_checklist">Self-Assessment</a></li>
                                        <li><a href="<?= base_url(); ?>Page/tapr_form">TA Form</a></li>

                                    </ul>
                                </li>
                                <li><a href="<?= base_url(); ?>Page/sbcp_list"><i class="mdi mdi-format-list-checks"></i>SBCP Monitoring Tool</a></li>



                                <li><a href="<?= base_url(); ?>Users/users_sub" class="waves-effect"><i class="fas fa-user-tie"></i>Manage Users</a></li>

                                <li><a href="<?= base_url(); ?>Page/systemFeedback" class="waves-effect"><i class="fas fa-box "></i><span>System Feedback Form </span></a></li>
                                <li><a data-toggle="modal" data-id="<?= $id; ?>" class="open-AddBookDialog" href="#change_pass"><i class="fas fa-unlock-alt"></i><span> Change Password </span></a></li>
                                <li><a href="<?= base_url(); ?>Page/systemHelp" class="waves-effect"><i class=" fas fa-marker"></i><span>Help </span></a></li>
                                <li><a href="<?= base_url(); ?>logout" class="waves-effect"><i class="fas fa-arrow-circle-left "></i><span>Logout </span></a></li>

                                <!-- Accountant Sidebar -->
                            <?php elseif ($this->session->userdata('position') === 'Accountant') : ?>
                                <li><a href="<?= base_url(); ?>" class="waves-effect"><i class="mdi mdi-monitor-dashboard"></i><span> Dashboard </span></a></li>
                                <li><a href="<?= base_url(); ?>Page/school_allocations" class="waves-effect"><i class="mdi mdi-cash-usd "></i><span>School Allocations </span></a></li>
                                <li>
                                    <a href="javascript: void(0);" class="waves-effect">
                                        <i class="fas fa-scroll"></i>
                                        <spa>Implementation Plans</span>
                                            <span class="menu-arrow"></span>
                                    </a>
                                    <ul class="nav-second-level" aria-expanded="false">

                                        <li><a href="<?= base_url(); ?>Page/aip_sub">Submitted AIP</a></li>
                                        <li><a href="<?= base_url(); ?>Page/aip_stat">AIP Status</a></li>
                                    </ul>
                                </li>
                                <li><a href="<?= base_url(); ?>Page/systemFeedback" class="waves-effect"><i class="fas fa-box "></i><span>System Feedback Form </span></a></li>
                                <li><a data-toggle="modal" data-id="<?= $id; ?>" class="open-AddBookDialog" href="#change_pass"><i class="fas fa-unlock-alt"></i><span> Change Password </span></a></li>

                                <li><a href="<?= base_url(); ?>logout" class="waves-effect"><i class="fas fa-arrow-circle-left "></i><span>Logout </span></a></li>


                            <?php elseif ($this->session->position === 'sgod') : ?>

                                <li><a href="<?= base_url(); ?>Page/deptDashboard" class="waves-effect"><i class="fas fa-user-alt"></i><span>Dashboard </span></a></li>

                                <li><a href="<?= base_url(); ?>Page/sections"><i class="fas fa-dice-four"></i>Sections</a></li>

                                <li><a href="<?= base_url(); ?>Page/memo" class="waves-effect"><i class=" fas fa-clipboard"></i>Memo</a></li>

                                <li>
                                    <a href="javascript: void(0);" class="waves-effect">
                                        <i class="fas fa-clipboard-list"></i>
                                        <spa>Implementation Plans</span>
                                            <span class="menu-arrow"></span>
                                    </a>
                                    <ul class="nav-second-level" aria-expanded="false">

                                        <li><a href="<?= base_url(); ?>Page/aip_sub">Submitted AIP</a></li>
                                        <li><a href="<?= base_url(); ?>Page/smea_admin">Submitted SMEA</a></li>
                                        <li><a href="<?= base_url(); ?>Page/aip_stat">AIP Status</a></li>
                                        <li><a href="<?= base_url(); ?>Page/fy_setting">FY Settings</a></li>
                                    </ul>
                                </li>

                                <li>
                                    <a href="javascript: void(0);" class="waves-effect">
                                        <i class="fas fa-book-open"></i>
                                        <span> SBM </span>
                                        <span class="menu-arrow"></span>
                                    </a>
                                    <ul class="nav-second-level" aria-expanded="false">
                                        <li><a href="<?= base_url(); ?>Page/sbm">Principles</a></li>
                                        <li><a href="<?= base_url(); ?>Page/sbm_sub">Indicators</a></li>
                                        <li><a href="<?= base_url(); ?>Page/sbm_districts">SBM District List</a></li>
                                        <li><a href="<?= base_url(); ?>Page/sbm_list">Self-Assesment Checklist</a></li>
                                    </ul>
                                </li>

                                <li><a href="<?= base_url(); ?>Page/districts" class="waves-effect"><i class="fas fa-building"></i>Districts</a></li>
                                <li>
                                    <a href="javascript: void(0);" class="waves-effect">
                                        <i class="fas fa-book-reader"></i>
                                        <span> Schools </span>
                                        <span class="menu-arrow"></span>
                                    </a>
                                    <ul class="nav-second-level" aria-expanded="false">
                                        <li><a href="<?= base_url(); ?>Pages/schools?type=Public">Public</a></li>
                                        <li><a href="<?= base_url(); ?>Pages/schools?type=Private">Private</a></li>
                                    </ul>
                                </li>



                                <li><a href="#" class="waves-effect"><i class=" fas fa-user"></i>Manage Users</a></li>


                            <?php elseif ($this->session->position === 'District' || $this->session->position === 'Evaluator' || $this->session->position === 'doceval' || $this->session->position === 'rater') : ?>

                                <li><a href="<?= base_url(); ?>" class="waves-effect"><i class="fas fa-user-alt"></i><span> Dashboard </span></a></li>

                                <li>
                                    <a href="javascript: void(0);" class="waves-effect">
                                        <i class="fas fa-chalkboard-teacher"></i>
                                        <span>Recruitment </span>
                                        <span class="menu-arrow"></span>
                                    </a>
                                    <ul class="nav-second-level" aria-expanded="false">
                                        <li><a href="<?= base_url(); ?>Page/jobVacancy">Job Vacancies</a></li>
                                        <!-- <li><a href="<?= base_url(); ?>Pages/endorsed_applicants">Endorsed Applicants</a></li>
                                    <li><a href="<?= base_url(); ?>Pages/dq_applicants">Disqualified Applicants</a></li> -->
                                    </ul>

                                </li>
                                <?php if ($this->session->position != 'District') { ?>
                                    <li><a href="<?= base_url(); ?>Pages/query_applicants"><i class="far fa-comment-dots "></i>Applicant Query</a></li>
                                <?php } ?>
                                <!-- <li><a href="<?= base_url(); ?>Page/sbm_district_list"><i class="fas fa-user-plus"></i>SBM</a></li> -->

                                <?php if ($this->session->position == 'District') { ?>
                                    <li>
                                        <a href="javascript: void(0);" class="waves-effect">
                                            <i class="mdi mdi-format-list-checks"></i>
                                            <span> SBM</span>
                                            <span class="menu-arrow"></span>
                                        </a>
                                        <ul class="nav-second-level" aria-expanded="false">
                                            <li><a href="<?= base_url(); ?>Page/sbm_district_list">School List</a></li>
                                            <li><a href="<?= base_url(); ?>Page/sbm_district_tech">Technical Assisstance</a></li>
                                        </ul>
                                    </li>

                                    <li>
                                        <a href="javascript: void(0);" class="waves-effect">
                                            <i class="fas fa-user-plus"></i>
                                            <span> Brigada Eskwela</span>
                                            <span class="menu-arrow"></span>
                                        </a>
                                        <ul class="nav-second-level" aria-expanded="false">
                                            <li><a href="<?= base_url(); ?>Brigada/spc_district_list" target="_blank">School Preparedness</a></li>

                                        </ul>
                                    </li>


                                    <li>
                                        <a href="<?= base_url(); ?>Page/school_list" class="waves-effect">
                                            <i class="mdi mdi-format-list-checks"></i>
                                            <span>School List</span>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="javascript: void(0);" class="waves-effect">
                                            <i class="mdi mdi-notebook-multiple"></i>
                                            <span> Implementation Plans </span>
                                            <span class="menu-arrow"></span>
                                        </a>
                                        <ul class="nav-second-level" aria-expanded="false">
                                            <li><a href="<?= base_url(); ?>page/view_sip_district">SIP</a></li>
                                            <li><a href="<?= base_url(); ?>page/view_plans_district">Plans</a></li>

                                        </ul>

                                    </li>

                                <?php } ?>



                                <!-- <li><a href="<?= base_url(); ?>Users/users_sub" class="waves-effect"><i class="fas fa-user-tie"></i>Manage Users</a></li> -->
                                <li><a data-toggle="modal" data-id="<?= $id; ?>" class="open-AddBookDialog" href="#change_eval_pass"><i class="fas fa-user-alt"></i><span> Change Password </span></a></li>
                                <li><a href="<?= base_url(); ?>logout" class="waves-effect"><i class="fas fa-arrow-circle-left "></i><span>Logout </span></a></li>

                            <?php elseif ($this->session->position === 'Validator') : ?>

                                <li><a href="<?= base_url(); ?>" class="waves-effect"><i class="fas fa-user-alt"></i><span> Dashboard </span></a></li>

                                <li><a href="<?= base_url(); ?>Page/jobVacancy"><i class="fas fa-chalkboard-teacher"></i>Job Vacancies</a></li>

                                <li><a href="<?= base_url(); ?>Users/users_sub" class="waves-effect"><i class="fas fa-user-tie"></i>Manage Users</a></li>
                                <li><a href="<?= base_url(); ?>logout" class="waves-effect"><i class="fas fa-arrow-circle-left "></i><span>Logout </span></a></li>

                            <?php elseif ($this->session->position == "sbfp") : ?>

                                <li><a href="<?= base_url(); ?>Page/sbfp_dashboard"><i class="mdi mdi-view-dashboard"></i>Dashboard</a></li>
                                <li><a href="<?= base_url(); ?>Page/uploadEnrolees"><i class="mdi mdi-folder-edit-outline"></i>Upload Data</a></li>
                                <li><a href="<?= base_url(); ?>Page/sbfp_form"><i class="mdi mdi-database-import"></i>SBFP Data</a></li>
                                <li><a href="<?= base_url(); ?>Page/baseline" target="_blank"><i class="mdi mdi-weight"></i>Baseline Weighing</a></li>
                                <li><a href="<?= base_url(); ?>Page/baseline2nd" target="_blank"><i class="mdi mdi-weight-kilogram"></i>Second Weighing</a></li>
                                <li><a href="<?= base_url(); ?>Page/baseline3nd" target="_blank"><i class="mdi mdi-weight-kilogram"></i>Third Weighing</a></li>
                                <li><a href="<?= base_url(); ?>Page/sbfp_form1" target="_blank"><i class="mdi mdi-file-document-box-check-outline"></i>Form 1</a></li>
                                <li><a href="<?= base_url(); ?>Page/sbfp_form2" target="_blank"><i class="mdi mdi-file-document-box-check-outline"></i>Form 2</a></li>
                                <li><a href="<?= base_url(); ?>Page/sbfp_form3" target="_blank"><i class="mdi mdi-file-document-box-check-outline"></i>Form 3</a></li>
                                <li><a href="<?= base_url(); ?>Page/sbfp_sf8" target="_blank"><i class="mdi mdi-file-document-box-check-outline"></i>SF 8</a></li>

                            <?php elseif ($this->session->userdata('position') === 'private') : ?>

                                <li><a href="<?= base_url(); ?>Pages/view_user" class="waves-effect"><i class="fas fa-user-alt"></i><span> Dashboard </span></a></li>
                                <li><a href="<?= base_url(); ?>Ps/private_list" class="waves-effect"><i class="fas fa-book"></i><span> Reports </span></a></li>
                                <li><a data-toggle="modal" data-id="<?= $id; ?>" class="open-AddBookDialog" href="#change_pass"><i class="fas fa-user-alt"></i><span> Change Password </span></a></li>
                                <li><a href="<?= base_url(); ?>Page/systemFeedback" class="waves-effect"><i class="fas fa-box "></i><span>System Feedback Form </span></a></li>


                            <?php endif; ?>

                        <?php } else { // sub user menu 
                        ?>

                            <?php if ($this->session->userdata('sp') != 0) : ?>
                                <?php $sp = $this->Common->one_cond_row('users_sp', 'id', $this->session->userdata('sp')); ?>


                                <?php if ($sp->position == "SSC") : ?>

                                    <li><a href="<?= base_url(); ?>" class="waves-effect"><i class="fas fa-user-alt"></i><span> Dashboard </span></a></li>
                                    <li>
                                        <a href="javascript: void(0);" class="waves-effect">
                                            <i class="fas fa-chalkboard-teacher"></i>
                                            <span>Recruitment </span>
                                            <span class="menu-arrow"></span>
                                        </a>
                                        <ul class="nav-second-level" aria-expanded="false">
                                            <li><a href="<?= base_url(); ?>Page/jobVacancy">Job Vacancies</a></li>
                                        </ul>
                                    </li>

                                <?php elseif ($sp->position == "SBFP") : ?>

                                    <li><a href="<?= base_url(); ?>Page/sbfp_dashboard"><i class="mdi mdi-view-dashboard"></i>Dashboard</a></li>
                                    <li><a href="<?= base_url(); ?>Page/uploadEnrolees"><i class="mdi mdi-folder-edit-outline"></i>Upload Data</a></li>
                                    <li><a href="<?= base_url(); ?>Page/sbfp_form"><i class="mdi mdi-database-import"></i>SBFP Data</a></li>
                                    <li><a href="<?= base_url(); ?>Page/baseline" target="_blank"><i class="mdi mdi-weight"></i>Baseline Weighing</a></li>
                                    <li><a href="<?= base_url(); ?>Page/baseline2nd" target="_blank"><i class="mdi mdi-weight-kilogram"></i>Second Weighing</a></li>
                                    <li><a href="<?= base_url(); ?>Page/baseline3nd" target="_blank"><i class="mdi mdi-weight-kilogram"></i>Third Weighing</a></li>
                                    <li><a href="<?= base_url(); ?>Page/sbfp_form1" target="_blank"><i class="mdi mdi-file-document-box-check-outline"></i>Form 1</a></li>
                                    <li><a href="<?= base_url(); ?>Page/sbfp_form2" target="_blank"><i class="mdi mdi-file-document-box-check-outline"></i>Form 2</a></li>
                                    <li><a href="<?= base_url(); ?>Page/sbfp_form3" target="_blank"><i class="mdi mdi-file-document-box-check-outline"></i>Form 3</a></li>
                                    <li><a href="<?= base_url(); ?>Page/sbfp_sf8" target="_blank"><i class="mdi mdi-file-document-box-check-outline"></i>SF 8</a></li>

                                <?php elseif ($sp->position == "Service Record Staff") : ?>

                                    <li><a href="<?= base_url(); ?>"><i class="mdi mdi-view-dashboard"></i>Dashboard</a></li>
                                    <li>
                                        <a href="javascript: void(0);" class="waves-effect">
                                            <i class="ion ion-ios-attach"></i>
                                            <span> Service Record </span>
                                            <span class="menu-arrow"></span>
                                        </a>
                                        <ul class="nav-second-level" aria-expanded="false">
                                            <li><a href="<?= base_url(); ?>Page/serviceRecord">Service Record List</a></li>
                                            <li><a href="<?= base_url(); ?>Page/empList">Service Record Printing</a></li>
                                            <li><a href="<?= base_url(); ?>Page/serviceRecordUploading">Bulk Upload</a></li>
                                            <li><a href="<?= base_url(); ?>Page/sr_request_list">SR Requests</a></li>
                                        </ul>
                                    </li>

                                <?php elseif ($sp->position == "Division Nurse") : ?>

                                    <li><a href="#" class="waves-effect"><i class="fas fa-user-alt"></i><span> Dashboard </span></a></li>


                                    <li>
                                        <a href="javascript: void(0);" class="waves-effect">
                                            <i class="fas fa-user-plus"></i>
                                            <span> SBFP </span>
                                            <span class="menu-arrow"></span>
                                        </a>
                                        <ul class="nav-second-level" aria-expanded="false">
                                            <!-- <li><a href="<?= base_url(); ?>Sbfp/sbfp_nut_stat" target="_blank">Nutritional Status</a></li> -->
                                            <!-- <li><a href="<?= base_url(); ?>Sbfp/sbfp_bmi">Nutritional Status</a></li> -->

                                            <li><a href="<?= base_url(); ?>Sbfp/sbfp_bmi_dn_form">Nutritional Status Report</a></li>
                                            <!-- <li><a href="<?= base_url(); ?>Page/baseline" target="_blank">Baseline Weighing</a></li>
                                            <li><a href="<?= base_url(); ?>Page/baseline2nd" target="_blank">Second Weighing</a></li>
                                            <li><a href="<?= base_url(); ?>Page/baseline3nd" target="_blank">Third Weighing</a></li>
                                            <li><a href="<?= base_url(); ?>Page/sbfp_form1" target="_blank">Form 1</a></li>
                                            <li><a href="<?= base_url(); ?>Page/sbfp_form2" target="_blank">Form 2</a></li>
                                            <li><a href="<?= base_url(); ?>Page/sbfp_sf8" target="_blank">SF 8</a></li> -->

                                        </ul>
                                    </li>


                                    <li><a data-toggle="modal" data-id="<?= $id; ?>" class="open-AddBookDialog" href="#change_pass"><i class="fas fa-unlock-alt"></i><span> Change Password </span></a></li>
                                    <li><a href="<?= base_url(); ?>Page/systemFeedback" class="waves-effect"><i class="fas fa-box "></i><span>System Feedback Form </span></a></li>
                                    <li><a href="<?= base_url(); ?>Page/systemHelp" class="waves-effect"><i class=" fas fa-marker"></i><span>Help </span></a></li>



                                <?php elseif ($sp->position == "Leave Credits Staff") : ?>

                                    <li><a href="<?= base_url(); ?>"><i class="mdi mdi-view-dashboard"></i>Dashboard</a></li>
                                    <li>
                                        <a href="javascript: void(0);" class="waves-effect">
                                            <i class="mdi mdi-check-underline-circle "></i>
                                            <span> Leave </span>
                                            <span class="menu-arrow"></span>
                                        </a>
                                        <ul class="nav-second-level" aria-expanded="false">
                                            <!-- <li><a href="#">Leave Application</a></li> -->
                                            <li><a href="<?= base_url(); ?>Page/leaveCredits">Generate Monthly LC</a></li>
                                            <li><a href="<?= base_url(); ?>Page/leaveCreditsMonthly">Monthly Leave Credits</a></li>
                                            <li><a href="<?= base_url(); ?>Page/leaveCreditsSummary">Leave Credits Summary</a></li>
                                            <li><a href="<?= base_url(); ?>Page/leave_credits_approval">COC Credits</a></li>
                                        </ul>
                                    </li>

                                <?php elseif ($sp->position == "Nurse") : ?>
                                    <li><a href="<?= base_url(); ?>"><i class="mdi mdi-view-dashboard"></i>Dashboard</a></li>
                                    <li>
                                        <a href="javascript: void(0);" class="waves-effect">
                                            <i class="far fa-address-book "></i>
                                            <span> Medical </span>
                                            <span class="menu-arrow"></span>
                                        </a>
                                        <ul class="nav-second-level" aria-expanded="false">
                                            <li>
                                                <a href="javascript:void(0);" class="has-arrow">Consultations</a>
                                                <ul class="nav-third-level" aria-expanded="false">
                                                    <li><a href="<?= base_url(); ?>Page/med_patient">Employee</a></li>
                                                    <li><a href="<?= base_url(); ?>Page/med_patient_student">Student</a></li>
                                                </ul>
                                            </li>
                                            <!-- <li><a href="<?= base_url(); ?>Page/med_patient_pending">Pending Consulations</a></li> -->
                                            <!-- <li><a href="<?= base_url(); ?>Page/labRequest">Laboratory Request</a></li> -->
                                        </ul>
                                    </li>



                                    <li>
                                        <a href="javascript: void(0);" class="waves-effect">
                                            <i class="mdi mdi-view-compact-outline "></i>
                                            <span> SBFP </span>
                                            <span class="menu-arrow"></span>
                                        </a>
                                        <ul class="nav-second-level" aria-expanded="false">
                                            <li><a href="<?= base_url(); ?>Sbfp/sbfp_nut_stat" target="_blank">Nutritional Status</a></li>
                                            <li><a href="<?= base_url(); ?>Page/sbfp_form">SBFP Data</a></li>
                                            <li><a href="<?= base_url(); ?>Page/baseline" target="_blank">Baseline Weighing</a></li>
                                            <li><a href="<?= base_url(); ?>Page/baseline2nd" target="_blank">Second Weighing</a></li>
                                            <li><a href="<?= base_url(); ?>Page/baseline3nd" target="_blank">Third Weighing</a></li>
                                            <li><a href="<?= base_url(); ?>Page/sbfp_form1" target="_blank">Form 1</a></li>
                                            <li><a href="<?= base_url(); ?>Page/sbfp_form2" target="_blank">Form 2</a></li>
                                            <li><a href="<?= base_url(); ?>Page/sbfp_form3" target="_blank">Form 3</a></li>
                                            <li><a href="<?= base_url(); ?>Page/sbfp_sf8" target="_blank"><i class="mdi mdi-file-document-box-check-outline"></i>SF 8</a></li>
                                        </ul>
                                    </li>

                                    <li>
                                        <a href="javascript: void(0);" class="waves-effect">
                                            <i class="mdi mdi-view-compact-outline "></i>
                                            <span> Reports </span>
                                            <span class="menu-arrow"></span>
                                        </a>
                                        <ul class="nav-second-level" aria-expanded="false">
                                            <li><a href="#">Medical Certificate</a></li>
                                            <li><a href="#">Patient's Case Summary</a></li>
                                        </ul>
                                    </li>
                                    <!-- <li><a href="<?= base_url(); ?>Users/users_sub" class="waves-effect"><i class="fas fa-user-tie"></i>Manage Sub Users</a></li>  -->

                                    <li><a href="<?= base_url(); ?>Page/systemFeedback" class="waves-effect"><i class="fas fa-box "></i><span>System Feedback Form </span></a></li>
                                    <li><a href="<?= base_url(); ?>Page/systemHelp" class="waves-effect"><i class=" fas fa-marker"></i><span>Help </span></a></li>




                                <?php elseif ($sp->position == "Enrollment In-Charge") : ?>

                                    <li><a href="<?= base_url(); ?>"><i class="mdi mdi-view-dashboard"></i>Dashboard</a></li>
                                    <li>
                                        <a href="javascript: void(0);" class="waves-effect">
                                            <i class="fas fa-user-plus"></i>
                                            <span> Enrollment </span>
                                            <span class="menu-arrow"></span>
                                        </a>
                                        <ul class="nav-second-level" aria-expanded="false">
                                            <li><a href="<?= base_url(); ?>Enrollment/profileList">Student's Profile</a></li>
                                            <li><a href="<?= base_url(); ?>Masterlist/enrolledList">Enrollment</a></li>

                                            <li>
                                                <a href="javascript: void(0);" class="waves-effect">
                                                    <span> Enrollment Settings</span>
                                                    <span class="menu-arrow"></span>
                                                </a>
                                                <ul class="nav-second-level" aria-expanded="false">
                                                    <li><a href="#">Ethnicity</a></li>
                                                    <li><a href="#">Religion</a></li>
                                                    <li><a href="#">Previous Schools</a></li>
                                                    <li><a href="#">Programs</a></li>
                                                </ul>
                                            </li>

                                        </ul>
                                    </li>


                                    <?php elseif ($sp->position == "PDO") : ?>

                                    <li><a href="<?= base_url(); ?>"><i class="mdi mdi-view-dashboard"></i>Dashboard</a></li>
                                    <li>
                                        <a href="javascript: void(0);" class="waves-effect">
                                            <i class="fas fa-user-plus"></i>
                                            <span> Tools </span>
                                            <span class="menu-arrow"></span>
                                        </a>
                                        <ul class="nav-second-level" aria-expanded="false">
                                            <li><a href="<?= base_url(); ?>Pdopage/bkdp">Barkada Kontra Droga Plus</a></li>
                                            <li><a href="<?= base_url(); ?>Masterlist/enrolledList">Youth for Environment in Schools Organization</a></li>
                                            <li><a href="<?= base_url(); ?>Masterlist/enrolledList">Youth Formation Program</a></li>
                                        </ul>
                                    </li>

                                <?php endif; ?>




                            <?php endif; ?>


                        <?php } ?>


                    </ul>

                </div>



                <div class="clearfix"></div>

            </div>
            <!-- Sidebar -left -->

        </div>
        <!-- Left Sidebar End -->