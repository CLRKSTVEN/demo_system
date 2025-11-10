<div class="left-side-menu">

    <div class="slimscroll-menu">

                <?php
                    if (!isset($schoolType)) {
                        // Load CodeIgniter instance only if $schoolType is not yet set
                        $CI = &get_instance();
                        $CI->load->database();

                        // Query the srms_settings_o table
                        $query = $CI->db->get('srms_settings_o');

                        $grade_display = 'Numeric';
                        $schoolType = 'public'; // Default

                        if ($query->num_rows() > 0) {
                            $row = $query->row();
                            $grade_display = $row->gradeDisplay;
                            $schoolType = $row->schoolType;
                        }
                    }
                    ?>

        <!--- Sidemenu -->
        <!-- System Administrator -->
        <?php if ($this->session->userdata('level') === 'Admin') : ?>
            <div id="sidebar-menu">
                <ul class="metismenu" id="side-menu">

                    <li class="menu-title">Administration</li>

                    <li>
                        <a href="<?= base_url(); ?>Page/admin" class="waves-effect">
                            <i class="ion ion-md-home"></i>
                            <span> Dashboard </span>
                        </a>
                    </li>

                    <li>
                        <a href="javascript: void(0);" class="waves-effect">
                            <i class=" ion ion-md-cog "></i>
                            <span> Configuration </span>
                            <span class="menu-arrow"></span>
                        </a>
                        <ul class="nav-second-level" aria-expanded="false">
                            <li><a href="<?= base_url(); ?>Settings/program">Programs</a></li>
                            <li><a href="<?= base_url(); ?>Settings/Track_strand">Track and Strand</a></li>
                            <!-- <li><a href="<?= base_url() ?>Settings/Sections">Sections</a></li> -->
                            <li><a href="<?= base_url() ?>Settings/SectionAdviser">Sections</a></li>
                            <li><a href="<?= base_url() ?>Settings/subjects">Subjects</a></li>
                            <li><a href="<?= base_url() ?>Settings/ClassProgram">Class Program</a></li>
                            <li><a href="<?= base_url(); ?>Settings/lockgrades">Grade Lock Schedule</a></li>

                        </ul>
                    </li>


                    
                    <?php if ($schoolType === 'Public'): ?>
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

                    <li>
                        <a href="javascript: void(0);" class="waves-effect">
                            <i class="fas fa-user-plus"></i>
                            <span> SBFP </span>
                            <span class="menu-arrow"></span>
                        </a>
                        <ul class="nav-second-level" aria-expanded="false">
                            <li><a href="<?= base_url(); ?>Sbfp/sbfp_bmi">Nutritional Status Report</a></li>

                        </ul>
                    </li>
                    <?php elseif ($schoolType === 'Private'): ?>
                        <!-- You can add a menu for Private here if needed -->
                    <?php endif; ?>

                  

                    <!-- 
                    <?php if ($grade_display === 'Letter'): ?>
                        <li>
                            <a href="<?= base_url(); ?>Page/update_grades" class="waves-effect">
                                <i class="ion-md-map"></i>
                                <span> Grades-Equivalent </span>
                            </a>
                        </li>
                    <?php elseif ($grade_display === 'Numeric'): ?>
                        <li>
                            <a href="<?= base_url(); ?>Page/update_grades" class="waves-effect">
                                <i class="ion-md-map"></i>
                                <span> Calculate Grades </span>
                            </a>
                        </li>
                    <?php endif; ?> -->

                    <li>
                        <a href="<?= base_url(); ?>Page/announcement?id=<?php echo $this->session->userdata('username'); ?>" class="waves-effect">
                            <i class=" ion ion-logo-ionic"></i>
                            <span> Announcement </span>
                        </a>
                    </li>



                    <li>
                        <a href="javascript: void(0);" class="waves-effect">
                            <i class=" ion ion-ios-podium"></i>
                            <span> Property Inventory </span>
                            <span class="menu-arrow"></span>
                        </a>

                        <ul class="nav-second-level nav" aria-expanded="false">
                            <li><a href="<?= base_url(); ?>Page/inventoryList">Item List</a></li>

                            <li>
                                <a href="javascript: void(0);" class="waves-effect">
                                    <span> Settings </span>
                                    <span class="menu-arrow"></span>
                                </a>

                                <ul class="nav-second-level nav" aria-expanded="false">
                                    <li><a href="<?= base_url(); ?>Settings/brand">Brands</a></li>
                                    <li><a href="<?= base_url(); ?>Settings/category">Category</a></li>
                                    <li><a href="<?= base_url(); ?>Settings/office">Office</a></li>
                                </ul>
                            </li>

                        </ul>
                    </li>

                    <li>
                        <a href="javascript: void(0);" class="waves-effect">
                            <i class=" ion ion-md-list-box "> </i>
                            <span> To Do </span>
                            <span class="menu-arrow"></span>
                        </a>
                        <ul class="nav-second-level" aria-expanded="false">
                            <li><a href="<?= base_url(); ?>ToDo/">ToDo</a></li>
                        </ul>
                    </li>

                    <li>
                        <a href="<?= base_url(); ?>Calendar/" target="_blank" class=" waves-effect">
                            <i class=" ion ion-md-calendar "> </i>
                            <span> Calendar </span>

                        </a>

                    </li>

                    <li>
                        <a href="<?= base_url(); ?>Note/" class=" waves-effect">
                            <i class=" ion ion-ios-keypad"> </i>
                            <span> Notes </span>

                        </a>

                    </li>


                    <li>
                        <a href="javascript: void(0);" class="waves-effect">
                            <i class="mdi mdi-shield-account"></i>
                            <span> Manage Users </span>
                            <span class="menu-arrow"></span>
                        </a>
                        <ul class="nav-second-level" aria-expanded="false">
                            <li><a href="<?= base_url(); ?>Page/userAccounts">User Accounts</a></li>
                            <!-- <li><a href="<?= base_url(); ?>Page/create_stude_accts">Create Students' Accounts</a></li> -->

                        </ul>
                    </li>

                    <li>
                        <a href="javascript: void(0);" class="waves-effect">
                            <i class="ion ion-md-settings"></i>
                            <span> Settings </span>
                            <span class="menu-arrow"></span>
                        </a>
                        <ul class="nav-second-level" aria-expanded="false">
                            <li><a href="<?= base_url(); ?>Settings/schoolInfo">School Info</a></li>
                            <li><a href="<?= base_url(); ?>Settings/loginFormBanner">Banners and Images</a></li>
                        </ul>
                    </li>

                    <li>
                        <a href="<?= site_url('admin/backup_database'); ?>" class="waves-effect">
                            <i class=" mdi mdi-database-import "></i>
                            <span> Backup Database </span>
                        </a>
                    </li>


                    <li class="menu-title">Reports</li>
                    <li>
                        <a href="javascript: void(0);" class="waves-effect">
                            <i class="ion ion-md-paper"></i>
                            <span> Admission Reports </span>
                            <span class="menu-arrow"></span>
                        </a>
                        <ul class="nav-second-level" aria-expanded="false">
                            <li><a href="<?= base_url(); ?>Masterlist/slotsMonitoring">Slots Monitoring</a></li>
                            <li><a href="<?= base_url(); ?>Ren/enrollment_summary">Enrollment Summary</a></li>

                        </ul>
                    </li>
                    <li>
                        <a href="javascript: void(0);" class="waves-effect">
                            <i class=" ion ion-md-stats "></i>
                            <span> Accounting Reports </span>
                            <span class="menu-arrow"></span>
                        </a>
                        <ul class="nav-second-level" aria-expanded="false">

                            <li><a href="<?= base_url(); ?>Page/proof_payment_view">Payment Verification</a></li>
                            <li><a href="<?= base_url(); ?>Accounting/collectionReport">Collection Report</a></li>
                            <li><a href="<?= base_url(); ?>Accounting/collectionYear">Collection Per Year</a></li>

                            <li><a href="<?= base_url(); ?>Page/onlinePaymentsAll">Online Payments (All)</a></li>
                            <li><a href="<?= base_url(); ?>Accounting/studeAccountsWithBalance">Students With Outstanding Balance</a></li>


                        </ul>
                    </li>

                    <li>
                        <a href="javascript: void(0);" class="waves-effect">
                            <i class=" mdi mdi-book-open-page-variant "></i>
                            <span> Student Reports </span>
                            <span class="menu-arrow"></span>
                        </a>
                        <ul class="nav-second-level nav" aria-expanded="false">
                            <li><a target="_blank" href="<?= base_url(); ?>Ren/good_moral">Good Moral Character</a></li>
                            <li><a target="_blank" href="<?= base_url(); ?>Ren/clearance">Certificate of Enrollment</a></li>
                            <li><a target="_blank" href="<?= base_url(); ?>Ren/clear">Clearance</a></li>
                            <li><a target="_blank" href="<?= base_url(); ?>Ren/stud_prof">Student Profile</a></li>
                            <li><a target="_blank" href="<?= base_url(); ?>Ren/stud_register_enrollment">Registration Form / Enrollment Form</a></li>
                            <li><a href="<?= base_url(); ?>Accounting/accountingStudeReports">Student's Accounts</a></li>
                        </ul>

                    </li>



                    <li>
                        <a href="<?= base_url(); ?>FAQ/" target="_blank" class="waves-effect">
                            <i class="ion ion-md-help"></i>
                            <span> SRMS FAQ </span>
                        </a>
                    </li>


                </ul>

            </div>
            <!-- End Sidebar -->


        <?php elseif ($this->session->userdata('level') === 'HR Admin') : ?>
            <div id="sidebar-menu">
                <ul class="metismenu" id="side-menu">

                    <li class="menu-title">Navigation</li>

                    <li>
                        <a href="<?= base_url(); ?>Page/hr" class="waves-effect">
                            <i class="ion ion-md-home"></i>
                            <span> Dashboard </span>
                        </a>
                    </li>
                    <li>
                        <a href="<?= base_url(); ?>Page/employeeList" class="waves-effect">
                            <i class=" ion ion-md-contact "></i>
                            <span> Faculty and Staff </span>
                        </a>

                    </li>

                    <li>
                        <a href="javascript: void(0);" class="waves-effect">
                            <i class=" ion ion-md-list-box "> </i>
                            <span> To Do </span>
                            <span class="menu-arrow"></span>
                        </a>
                        <ul class="nav-second-level" aria-expanded="false">
                            <li><a href="<?= base_url(); ?>ToDo/">ToDo</a></li>
                        </ul>
                    </li>

                    <li>
                        <a href="<?= base_url(); ?>Calendar/" target="_blank" class=" waves-effect">
                            <i class=" ion ion-md-calendar "> </i>
                            <span> Calendar </span>

                        </a>

                    </li>

                    <li>
                        <a href="<?= base_url(); ?>Note/" class=" waves-effect">
                            <i class=" ion ion-ios-keypad"> </i>
                            <span> Notes </span>

                        </a>

                    </li>

                    <li>
                        <a href="<?= base_url(); ?>FAQ/" target="_blank" class="waves-effect">
                            <i class="ion ion-md-help"></i>
                            <span> SRMS FAQ </span>
                        </a>
                    </li>


                </ul>

            </div>
            <!-- End Sidebar -->


        <?php elseif ($this->session->userdata('level') === 'Academic Officer') : ?>
            <div id="sidebar-menu">
                <ul class="metismenu" id="side-menu">

                    <li class="menu-title">Navigation</li>

                    <li>
                        <a href="<?= base_url(); ?>Page/a_officer" class="waves-effect">
                            <i class="ion ion-md-home"></i>
                            <span> Dashboard </span>
                        </a>
                    </li>

                    <li>
                        <a href="<?= base_url(); ?>Page/profileList" class="waves-effect">
                            <i class="ion ion-ios-person"></i>
                            <span>Student's Profile</span>
                        </a>
                    </li>

                    <li>
                        <a href="<?= base_url(); ?>Masterlist/enrolledList" class="waves-effect">
                            <i class="on ion-ios-checkmark-circle"></i>
                            <span>Enrollment</span>
                        </a>
                    </li>

                    <li>
                        <a href="<?= base_url(); ?>Page/forValidation" class="waves-effect">
                            <i class=" ion ion-md-keypad"></i>
                            <span>Online Enrollees</span>
                        </a>
                    </li>


                    <li>
                        <a href="javascript: void(0);" class="waves-effect">
                            <i class=" ion ion-ios-podium"></i>
                            <span> Masterlist </span>
                            <span class="menu-arrow"></span>
                        </a>

                        <ul class="nav-second-level nav" aria-expanded="false">
                            <!-- <li><a href="<?= base_url(); ?>Masterlist/dailyEnrollees">Enrollees By Date</a></li> -->
                            <li><a href="<?= base_url(); ?>Page/masterlistByCourseFiltered">By Course</a></li>
                            <li><a href="<?= base_url(); ?>Masterlist/byGradeLevel">By Grade Level</a></li>
                            <li><a href="<?= base_url(); ?>Masterlist/bySection">By Section</a></li>
                            <li><a href="<?= base_url(); ?>Masterlist/trackMasterList">By Track</a></li>
                            <li><a href="<?= base_url(); ?>Masterlist/bySY">By School Year</a></li>
                            <li><a href="<?= base_url(); ?>Masterlist/subregistration">By Subject</a></li>
                            <li><a href="<?= base_url(); ?>Masterlist/byEnrolledOnlineSem?sy=<?php echo $this->session->userdata('sy'); ?>&sem=<?php echo $this->session->userdata('semester'); ?>">Online Enrollees (By SY)</a></li>
                            <li><a href="<?= base_url(); ?>Masterlist/byEnrolledOnlineAll">Online Enrollees (All)</a></li>


                    </li>

                    <li>
                        <a href="#" aria-expanded="false">Reports
                            <span class="menu-arrow"></span>
                        </a>
                        <ul class="nav-third-level nav" aria-expanded="false">
                            <li><a href="<?= base_url(); ?>Masterlist/slotsMonitoring">Slots Monitoring</a></li>
                            <li><a href="<?= base_url(); ?>Masterlist/grades">Grading Sheets</a></li>
                            <!-- <li><a href="<?= base_url(); ?>Masterlist/signupList">Signup List</a></li> -->
                        </ul>
                    </li>
                </ul>
                </li>



                <li>
                    <a href="javascript: void(0);" class="waves-effect">
                        <i class=" ion ion-ios-medkit"></i>
                        <span> Medical </span>
                        <span class="menu-arrow"></span>
                    </a>
                    <ul class="nav-second-level nav" aria-expanded="false">
                        <li><a href="<?= base_url(); ?>Page/medInfo">Medical Info</a></li>
                        <li><a href="<?= base_url(); ?>Page/medRecords">Medical Records</a></li>

                    </ul>
                </li>

                <li>
                    <a href="javascript: void(0);" class="waves-effect">
                        <i class=" ion ion-ios-qr-scanner "></i>
                        <span> Guidance </span>
                        <span class="menu-arrow"></span>
                    </a>
                    <ul class="nav-second-level nav" aria-expanded="false">
                        <li><a href="<?= base_url(); ?>Page/incidents">Incidents</a></li>
                        <li><a href="<?= base_url(); ?>Page/counselling">Counselling</a></li>
                        <!-- <li><a href="<?= base_url(); ?>Page/medRecords">Student Development Plan</a></li> -->
                    </ul>
                </li>

                <li>
                    <a href="javascript: void(0);" class="waves-effect">
                        <i class=" ion ion-md-list-box "> </i>
                        <span> To Do </span>
                        <span class="menu-arrow"></span>
                    </a>
                    <ul class="nav-second-level" aria-expanded="false">
                        <li><a href="<?= base_url(); ?>ToDo/">ToDo</a></li>
                    </ul>
                </li>

                <li>
                    <a href="<?= base_url(); ?>Calendar/" target="_blank" class=" waves-effect">
                        <i class=" ion ion-md-calendar "> </i>
                        <span> Calendar </span>

                    </a>

                </li>

                <li>
                    <a href="<?= base_url(); ?>Note/" class=" waves-effect">
                        <i class=" ion ion-ios-keypad"> </i>
                        <span> Notes </span>

                    </a>

                </li>

                <li>
                    <a href="<?= base_url(); ?>FAQ/" target="_blank" class="waves-effect">
                        <i class="ion ion-md-help"></i>
                        <span> SRMS FAQ </span>
                    </a>
                </li>

                </ul>

            </div>
            <!-- End Sidebar -->

        <?php elseif ($this->session->userdata('level') === 'Principal') : ?>
            <div id="sidebar-menu">
                <ul class="metismenu" id="side-menu">

                    <li class="menu-title">Navigation</li>

                    <li>
                        <a href="<?= base_url(); ?>Page/s_principal" class="waves-effect">
                            <i class="ion ion-md-home"></i>
                            <span> Dashboard </span>
                        </a>
                    </li>

                    <li>
                        <a href="<?= base_url(); ?>Page/profileList" class="waves-effect">
                            <i class="ion ion-ios-person"></i>
                            <span>Student's Profile</span>
                        </a>
                    </li>

                    <li>
                        <a href="<?= base_url(); ?>Masterlist/enrolledList" class="waves-effect">
                            <i class="on ion-ios-checkmark-circle"></i>
                            <span>Enrollment</span>
                        </a>
                    </li>

                    <li>
                        <a href="<?= base_url(); ?>Page/forValidation" class="waves-effect">
                            <i class=" ion ion-md-keypad"></i>
                            <span>Online Enrollees</span>
                        </a>
                    </li>


                    <li>
                        <a href="javascript: void(0);" class="waves-effect">
                            <i class=" ion ion-ios-podium"></i>
                            <span> Masterlist </span>
                            <span class="menu-arrow"></span>
                        </a>

                        <ul class="nav-second-level nav" aria-expanded="false">
                            <!-- <li><a href="<?= base_url(); ?>Masterlist/dailyEnrollees">Enrollees By Date</a></li> -->
                            <li><a href="<?= base_url(); ?>Page/masterlistByCourseFiltered">By Course</a></li>
                            <li><a href="<?= base_url(); ?>Masterlist/byGradeLevel">By Grade Level</a></li>
                            <li><a href="<?= base_url(); ?>Masterlist/bySection">By Section</a></li>
                            <li><a href="<?= base_url(); ?>Masterlist/trackMasterList">By Track</a></li>
                            <li><a href="<?= base_url(); ?>Masterlist/bySY">By School Year</a></li>
                            <li><a href="<?= base_url(); ?>Masterlist/subregistration">By Subject</a></li>
                            <li><a href="<?= base_url(); ?>Masterlist/byEnrolledOnlineSem?sy=<?php echo $this->session->userdata('sy'); ?>&sem=<?php echo $this->session->userdata('semester'); ?>">Online Enrollees (By SY)</a></li>
                            <li><a href="<?= base_url(); ?>Masterlist/byEnrolledOnlineAll">Online Enrollees (All)</a></li>


                    </li>

                    <li>
                        <a href="#" aria-expanded="false">Reports
                            <span class="menu-arrow"></span>
                        </a>
                        <ul class="nav-third-level nav" aria-expanded="false">
                            <li><a href="<?= base_url(); ?>Masterlist/slotsMonitoring">Slots Monitoring</a></li>
                            <li><a href="<?= base_url(); ?>Masterlist/grades">Grading Sheets</a></li>
                            <!-- <li><a href="<?= base_url(); ?>Masterlist/signupList">Signup List</a></li> -->
                        </ul>
                    </li>
                </ul>
                </li>

                <li>
                    <a href="javascript: void(0);" class="waves-effect">
                        <i class=" ion ion-md-list-box "> </i>
                        <span> To Do </span>
                        <span class="menu-arrow"></span>
                    </a>
                    <ul class="nav-second-level" aria-expanded="false">
                        <li><a href="<?= base_url(); ?>ToDo/">ToDo</a></li>
                    </ul>
                </li>

                <li>
                    <a href="<?= base_url(); ?>Calendar/" target="_blank" class=" waves-effect">
                        <i class=" ion ion-md-calendar "> </i>
                        <span> Calendar </span>

                    </a>

                </li>

                <li>
                    <a href="<?= base_url(); ?>Note/" class=" waves-effect">
                        <i class=" ion ion-ios-keypad"> </i>
                        <span> Notes </span>

                    </a>

                </li>

                <li>
                    <a href="<?= base_url(); ?>FAQ/" target="_blank" class="waves-effect">
                        <i class="ion ion-md-help"></i>
                        <span> SRMS FAQ </span>
                    </a>
                </li>




                </ul>

            </div>
            <!-- End Sidebar -->

        <?php elseif ($this->session->userdata('level') === 'Property Custodian') : ?>
            <div id="sidebar-menu">
                <ul class="metismenu" id="side-menu">

                    <li class="menu-title">Navigation</li>

                    <li>
                        <a href="<?= base_url(); ?>Page/p_custodian" class="waves-effect">
                            <i class="ion ion-md-home"></i>
                            <span> Dashboard </span>
                        </a>
                    </li>


                    <li>
                        <a href="javascript: void(0);" class="waves-effect">
                            <i class=" ion ion-ios-podium"></i>
                            <span> Inventory </span>
                            <span class="menu-arrow"></span>
                        </a>

                        <ul class="nav-second-level nav" aria-expanded="false">
                            <li><a href="<?= base_url(); ?>Page/inventoryList">Item List</a></li>

                        </ul>
                    </li>

                    <li>
                        <a href="javascript: void(0);" class="waves-effect">
                            <i class=" ion ion-ios-podium"></i>
                            <span> Settings </span>
                            <span class="menu-arrow"></span>
                        </a>

                        <ul class="nav-second-level nav" aria-expanded="false">
                            <li><a href="<?= base_url(); ?>Settings/brand">Brands</a></li>
                            <li><a href="<?= base_url(); ?>Settings/category">Category</a></li>
                            <li><a href="<?= base_url(); ?>Settings/office">Office</a></li>
                        </ul>
                    </li>

                    <li>
                        <a href="javascript: void(0);" class="waves-effect">
                            <i class=" ion ion-md-list-box "> </i>
                            <span> To Do </span>
                            <span class="menu-arrow"></span>
                        </a>
                        <ul class="nav-second-level" aria-expanded="false">
                            <li><a href="<?= base_url(); ?>ToDo/">ToDo</a></li>
                        </ul>
                    </li>

                    <li>
                        <a href="<?= base_url(); ?>Calendar/" target="_blank" class=" waves-effect">
                            <i class=" ion ion-md-calendar "> </i>
                            <span> Calendar </span>

                        </a>

                    </li>

                    <li>
                        <a href="<?= base_url(); ?>Note/" class=" waves-effect">
                            <i class=" ion ion-ios-keypad"> </i>
                            <span> Notes </span>

                        </a>

                    </li>

                    <li>
                        <a href="<?= base_url(); ?>FAQ/" target="_blank" class="waves-effect">
                            <i class="ion ion-md-help"></i>
                            <span> SRMS FAQ </span>
                        </a>
                    </li>



                </ul>

                </li>


                </ul>

            </div>
            <!-- End Sidebar -->

        <?php elseif ($this->session->userdata('level') === 'Registrar') : ?>
            <div id="sidebar-menu">
                <ul class="metismenu" id="side-menu">

                    <li class="menu-title">Navigation</li>

                    <li>
                        <a href="<?= base_url(); ?>Page/registrar" class="waves-effect">
                            <i class="ion ion-md-home"></i>
                            <span> Dashboard </span>
                        </a>
                    </li>

                    <li>
                        <a href="javascript: void(0);" class="waves-effect">
                            <i class=" ion ion-md-school"></i>
                            <span> Admission </span>
                            <span class="menu-arrow"></span>


                        </a>
                        <ul class="nav-second-level" aria-expanded="false">
                            <li><a href="<?= base_url(); ?>Page/profileList">Student's Profile</a> </li>
                            <li><a href="<?= base_url(); ?>Masterlist/enrolledList">Enrollment</a></li>
                            <li><a href="<?= base_url(); ?>Ren/sub_enlist">Subject Enlistment</a></li>
                            <li><a href="<?= base_url(); ?>page/forValidation">Online Enrollees <small style="color:red;">[for action]</small></a></li>

                        </ul>
                    </li>

                    <li>
                        <a href="javascript: void(0);" class="waves-effect">
                            <i class="mdi mdi-seal"></i>
                            <span> Grades </span>
                            <span class="menu-arrow"></span>


                        </a>
                        <ul class="nav-second-level" aria-expanded="false">
                            <li><a href="<?= base_url(); ?>Page/modify_grades" title="Edit or adjust existing student grades">Modify Grades</a></li>
                            <li><a href="<?= base_url(); ?>Page/save_grades" title="Edit or adjust existing student grades">Manual Encoding Grades</a></li>

                            <li><a href="<?= base_url(); ?>Masterlist/viewing_grades" title="Enter new grades for students">Encode Grades</a></li>
                            <li><a href="<?= base_url(); ?>Page/update_grades" title="Calculate subject averages for students">Calculate Average</a></li>
                            <!-- <li><a href="<?= base_url(); ?>Student/compute_general_averages" title="Compute overall general averages for students">Calculate General Average</a></li> -->
                            <li><a href="<?= base_url(); ?>Masterlist/grades">Grading Sheets</a></li>

                        </ul>
                    </li>

                    <?php
                    // Load CodeIgniter instance
                    $CI = &get_instance();
                    $CI->load->database();

                    // Query the srms_settings_o table
                    $query = $CI->db->get('srms_settings_o');
                    $grade_display = 'Numeric'; // Default value
                    if ($query->num_rows() > 0) {
                        $grade_display = $query->row()->gradeDisplay;
                    }
                    ?>

                    <li>
                        <a href="javascript: void(0);" class="waves-effect">
                            <i class=" mdi mdi-file-document-box-plus-outline"></i>
                            <span> Requirements </span>
                            <span class="menu-arrow"></span>


                        </a>
                        <ul class="nav-second-level" aria-expanded="false">
                            <li><a href="<?= base_url(); ?>Student/req_list">Requirement Lists</a> </li>
                            <li><a href="<?= base_url(); ?>Student/pending_uploads">For Approval</a> </li>
                            <li><a href="<?= base_url(); ?>Student/approved_uploads">Approved Uploads</a></li>
                        </ul>
                    </li>


                    <li>
                        <a href="javascript: void(0);" class="waves-effect">
                            <i class="ion ion-md-list-box"></i>
                            <span> Masterlist </span>
                            <span class="menu-arrow"></span>
                        </a>
                        <ul class="nav-second-level" aria-expanded="false">
                            <!-- <li><a href="<?= base_url(); ?>Masterlist/dailyEnrollees">Enrollees By Date</a></li> -->
                            <li><a href="<?= base_url(); ?>Page/masterlistByCourseFiltered">By Course</a></li>
                            <li><a href="<?= base_url(); ?>Masterlist/studeEthnicity">By Ethnicity</a></li>
                            <li><a href="<?= base_url(); ?>Masterlist/byGradeLevel">By Grade Level</a></li>
                            <li><a href="<?= base_url(); ?>Masterlist/studeReligion">By Religion</a></li>
                            <li><a href="<?= base_url(); ?>Masterlist/bySection">By Section</a></li>
                            <li><a href="<?= base_url(); ?>Masterlist/trackMasterList">By Track and Strand</a></li>
                            <li><a href="<?= base_url(); ?>Masterlist/bySY">By School Year</a></li>
                            <li><a href="<?= base_url(); ?>Masterlist/subregistration">By Subject</a></li>

                            <!-- <li><a href="<?= base_url(); ?>Masterlist/byEnrolledOnlineSem?sy=<?php echo $this->session->userdata('sy'); ?>&sem=<?php echo $this->session->userdata('semester'); ?>">Online Enrollees (By SY)</a></li> -->
                            <li><a href="<?= base_url(); ?>Masterlist/byEnrolledOnlineAll">Online Enrollees</a></li>
                            <li><a href="<?= base_url(); ?>Student/view_list_not_enrolled">Not Enrolled</a></li>
                        </ul>
                    </li>


                    <li>
                        <a href="<?= base_url(); ?>Page/announcement?id=<?php echo $this->session->userdata('username'); ?>" class="waves-effect">
                            <i class=" ion ion-logo-ionic "></i>
                            <span> Announcement </span>
                        </a>
                    </li>


                    <li>
                        <a href="javascript: void(0);" class="waves-effect">
                            <i class=" ion ion-md-cog "></i>
                            <span> Configuration </span>
                            <span class="menu-arrow"></span>
                        </a>
                        <ul class="nav-second-level" aria-expanded="false">
                            <li><a href="<?= base_url(); ?>Settings/program">Programs</a></li>
                            <li><a href="<?= base_url(); ?>Settings/Track_strand">Track and Strand</a></li>
                            <li><a href="<?= base_url() ?>Settings/subjects">Subjects</a></li>
                            <li><a href="<?= base_url() ?>SubjectDeportment/index">Subject Deport</a></li>
                            <li><a href="<?= base_url() ?>Settings/ClassProgram">Class Program</a></li>
                            <li><a href="<?= base_url() ?>Settings/SectionAdviser">Sections</a></li>
                            <li><a href="<?= base_url(); ?>Settings/ethnicity">Ethnicity</a></li>
                            <li><a href="<?= base_url(); ?>Settings/religion">Religion</a></li>
                            <li><a href="<?= base_url(); ?>Settings/prevschool">Last School Attended</a></li>
                            <li><a href="<?= base_url(); ?>SchoolDays/index">Days of School </a></li>
                            <li><a href="<?= base_url(); ?>Settings/lockgrades">Grade Lock Schedule</a></li>


                        </ul>
                    </li>

                    <li>
                        <a href="javascript: void(0);" class="waves-effect">
                            <i class="mdi mdi-update"></i>
                            <span> Bulk Update </span>
                            <span class="menu-arrow"></span>
                        </a>
                        <ul class="nav-second-level" aria-expanded="false">
                            <li><a href="<?= base_url(); ?>Student/update_student_ages">Student Ages</a></li>

                        </ul>
                    </li>

                    <li>
                        <a href="javascript: void(0);" class="waves-effect">
                            <i class="mdi mdi-update"></i>
                            <span> Document Request </span>
                            <span class="menu-arrow"></span>
                        </a>
                        <ul class="nav-second-level" aria-expanded="false">
                            <li><a href="<?= base_url(); ?>Request/document_types">Docs for Request</a></li>
                            <li><a href="<?= base_url(); ?>Request/">Requests</a></li>

                        </ul>
                    </li>

                    <!-- <li>
                        <a href="<?= base_url(); ?>Page/studeDirectory" class="waves-effect">
                            <i class="fas fa-mobile-alt"></i>
                            <span> Contacts Directory </span>
                        </a>
                    </li> -->

                    <li>
                        <a href="javascript: void(0);" class="waves-effect">
                            <i class=" ion ion-md-list-box "> </i>
                            <span> To Do </span>
                            <span class="menu-arrow"></span>
                        </a>
                        <ul class="nav-second-level" aria-expanded="false">
                            <li><a href="<?= base_url(); ?>ToDo/">ToDo</a></li>
                        </ul>
                    </li>

                    <li>
                        <a href="<?= base_url(); ?>Calendar/" target="_blank" class=" waves-effect">
                            <i class=" ion ion-md-calendar "> </i>
                            <span> Calendar </span>

                        </a>

                    </li>

                    <li>
                        <a href="<?= base_url(); ?>Note/" class=" waves-effect">
                            <i class=" ion ion-ios-keypad"> </i>
                            <span> Notes </span>

                        </a>

                    </li>

                    <li class="menu-title">Reports</li>
                    <li>
                        <a href="javascript: void(0);" class="waves-effect">
                            <i class="ion ion-md-paper"> </i>
                            <span> Administrative Reports </span>
                            <span class="menu-arrow"></span>
                        </a>
                        <ul class="nav-second-level" aria-expanded="false">
                            <li><a href="<?= base_url(); ?>Masterlist/slotsMonitoring">Slots Monitoring</a></li>
                            <li><a href="<?= base_url(); ?>Ren/enrollment_summary">Enrollment Summary</a></li>
                            <li><a href="<?= base_url(); ?>Masterlist/consol" target="_blank">Consolidated Grades</a></li>
                            <li><a href="<?= base_url(); ?>ReportGrades/index">Report of Grades</a></li>

                            <!-- <li><a href="<?= base_url(); ?>Masterlist/signupList">Signup List</a></li> -->
                        </ul>
                    </li>

                    <li>
                        <a href="<?= base_url(); ?>Ren/stud_reports" class="waves-effect">
                            <i class=" mdi mdi-book-open-page-variant "></i>
                            <span> Student Reports </span>
                            <!-- <span class="menu-arrow"></span> -->
                        </a>
                        <!-- <ul class="nav-second-level nav" aria-expanded="false">
                            <li><a target="_blank" href="<?= base_url(); ?>Ren/good_moral">Good Moral Character</a></li>
                            <li><a target="_blank" href="<?= base_url(); ?>Ren/clearance">Certificate of Enrollment</a></li>
                            <li><a target="_blank" href="<?= base_url(); ?>Ren/clear">Clearance</a></li>
                            <li><a target="_blank" href="<?= base_url(); ?>Ren/stud_prof">Student Profile</a></li>
                            <li><a target="_blank" href="<?= base_url(); ?>Ren/stud_register_enrollment">Registration Form / Enrollment Form</a></li>
                            <li><a target="_blank" href="<?= base_url(); ?>Page/studentsForm">Form</a></li>
                            <li><a target="_blank" href="<?= base_url(); ?>Page/studentsForm1">Form1</a></li>
                            <li><a target="_blank" href="<?= base_url(); ?>Page/studentsForm2">Form2</a></li>
                            <li><a target="_blank" href="<?= base_url(); ?>Page/studentsForm3">Form3</a></li>
                            <li><a target="_blank" href="<?= base_url(); ?>Page/studentsForm4">Form4</a></li> -->


                        <!-- <li><a target="_blank" href="<?= base_url(); ?>Ren/rc_sf10_jhs">SF10 - JHS</a></li>
                            <li><a target="_blank" href="<?= base_url(); ?>Ren/good_moral">SF10 - SHS</a></li> -->

                        <!-- temporarily disabled due to errors.  -->
                        <!-- <?php
                                // Load CodeIgniter instance
                                $CI = &get_instance();
                                $CI->load->database();

                                // Query the srms_settings_o table
                                $query = $CI->db->get('srms_settings_o');
                                $grade_display = 'Numeric'; // Default
                                $school_type = 'Public';    // Default

                                if ($query->num_rows() > 0) {
                                    $settings = $query->row();
                                    $grade_display = $settings->gradeDisplay;
                                    $school_type = $settings->schoolType;
                                }
                                ?>

                            <?php if (strtolower($school_type) !== 'private') : ?>
                                <li><a target="_blank" href="#">SF10 - JHS</a></li>
                                <li><a target="_blank" href="#">SF10 - SHS</a></li>
                            <?php endif; ?>

                        </ul> -->

                    </li>



                    <li>
                        <a href="<?= base_url(); ?>FAQ/" target="_blank" class="waves-effect">
                            <i class="ion ion-md-help"></i>
                            <span> SRMS FAQ </span>
                        </a>
                    </li>


                </ul>

            </div>
            <!-- End Sidebar -->

        <?php elseif ($this->session->userdata('level') === 'Encoder') : ?>
            <div id="sidebar-menu">
                <ul class="metismenu" id="side-menu">

                    <li class="menu-title">Navigation</li>

                    <li>
                        <a href="<?= base_url(); ?>Page/encoder" class="waves-effect">
                            <i class="ion ion-md-home"></i>
                            <span> Dashboard </span>
                        </a>
                    </li>

                    <li>
                        <a href="javascript: void(0);" class="waves-effect">
                            <i class=" ion ion-md-school"></i>
                            <span> Admission </span>
                            <span class="menu-arrow"></span>


                        </a>
                        <ul class="nav-second-level" aria-expanded="false">
                            <li><a href="<?= base_url(); ?>Page/profileListEncoder">Student's Profile</a> </li>
                            <!-- <li><a href="<?= base_url(); ?>Masterlist/enrolledList">Enrollment</a></li> -->

                        </ul>
                    </li>


                    <?php
                    // Load CodeIgniter instance
                    $CI = &get_instance();
                    $CI->load->database();

                    // Query the srms_settings_o table
                    $query = $CI->db->get('srms_settings_o');
                    $grade_display = 'Numeric'; // Default value
                    if ($query->num_rows() > 0) {
                        $grade_display = $query->row()->gradeDisplay;
                    }
                    ?>

                    <li>
                        <a href="javascript: void(0);" class="waves-effect">
                            <i class=" ion ion-md-list-box "> </i>
                            <span> To Do </span>
                            <span class="menu-arrow"></span>
                        </a>
                        <ul class="nav-second-level" aria-expanded="false">
                            <li><a href="<?= base_url(); ?>ToDo/">ToDo</a></li>
                        </ul>
                    </li>

                    <li>
                        <a href="<?= base_url(); ?>Calendar/" target="_blank" class=" waves-effect">
                            <i class=" ion ion-md-calendar "> </i>
                            <span> Calendar </span>

                        </a>

                    </li>

                    <li>
                        <a href="<?= base_url(); ?>Note/" class=" waves-effect">
                            <i class=" ion ion-ios-keypad"> </i>
                            <span> Notes </span>

                        </a>

                    </li>

                </ul>

            </div>
            <!-- End Sidebar -->

        <?php elseif ($this->session->userdata('level') === 'Cashier') : ?>
            <div id="sidebar-menu">
                <ul class="metismenu" id="side-menu">

                    <li class="menu-title">Navigation</li>

                    <li>
                        <a href="<?= base_url(); ?>Page/cashier" class="waves-effect">
                            <i class="ion ion-md-home"></i>
                            <span> Dashboard </span>
                        </a>
                    </li>

                    <li>
                        <a href="javascript: void(0);" class="waves-effect">
                            <i class=" ion ion-md-list-box "> </i>
                            <span> Payments </span>
                            <span class="menu-arrow"></span>
                        </a>
                        <ul class="nav-second-level" aria-expanded="false">
                            <li><a href="<?= base_url(); ?>Accounting/PaymentPerCashier">Accounts</a></li>
                            <!-- <li><a href="<?= base_url(); ?>Accounting/services">Services</a></li> -->
                        </ul>
                    </li>

                    <li>
                        <a href="javascript: void(0);" class="waves-effect">
                            <i class=" ion ion-md-list-box "> </i>
                            <span> To Do </span>
                            <span class="menu-arrow"></span>
                        </a>
                        <ul class="nav-second-level" aria-expanded="false">
                            <li><a href="<?= base_url(); ?>ToDo/">ToDo</a></li>
                        </ul>
                    </li>

                    <li>
                        <a href="<?= base_url(); ?>Calendar/" target="_blank" class=" waves-effect">
                            <i class=" ion ion-md-calendar "> </i>
                            <span> Calendar </span>

                        </a>

                    </li>

                    <li>
                        <a href="<?= base_url(); ?>Note/" class=" waves-effect">
                            <i class=" ion ion-ios-keypad"> </i>
                            <span> Notes </span>

                        </a>

                    </li>

                </ul>

            </div>
            <!-- End Sidebar -->

        <?php elseif ($this->session->userdata('level') === 'Accounting') : ?>
            <div id="sidebar-menu">
                <ul class="metismenu" id="side-menu">

                    <li class="menu-title">Navigation</li>

                    <li>
                        <a href="<?= base_url(); ?>Page/accounting" class="waves-effect">
                            <i class="ion ion-md-home"></i>
                            <span> Dashboard </span>
                        </a>
                    </li>

                    <li>
                        <a href="javascript: void(0);" class="waves-effect">
                            <i class=" ion ion-md-card"></i>
                            <span> Accounting </span>
                            <span class="menu-arrow"></span>
                        </a>
                        <ul class="nav-second-level nav" aria-expanded="false">
                            <li><a href="<?= base_url(); ?>Accounting/studeAccounts">Student's Accounts</a></li>
                            <li><a href="<?= base_url(); ?>Page/pre_assessment">Pre-Assesment</a></li>
                            <li>
                                <a href="#" aria-expanded="false">Payments
                                    <span class="menu-arrow"></span>
                                </a>
                                <ul class="nav-third-level nav" aria-expanded="false">
                                    <li><a href="<?= base_url(); ?>Accounting/Payment">Accounts</a></li>
                                    <li><a href="<?= base_url(); ?>Page/MultiPayment">Multi Pay</a></li>
                                    <li><a href="<?= base_url(); ?>Accounting/services">Services</a></li>
                                </ul>
                            </li>

                            <li><a href="<?= base_url(); ?>Page/proof_payment_view">Payment Verification</a></li>


                            <li>
                                <a href="#" aria-expanded="false">Accounting Settings<span class="menu-arrow"></span></a>
                                <ul class="nav-third-level nav" aria-expanded="false">
                                    <li><a href="<?= base_url(); ?>Accounting/CourseFees">Course Fees Setup</a></li>
                                    <li><a href="<?= base_url(); ?>Accounting/monthly_pay_duration">Payment Duration</a></li>
                                    <li><a href="<?= base_url('Accounting/manageDescriptions'); ?>">Service Descriptions</a></li>

                                </ul>
                            </li>

                        </ul>
                    </li>

                    <li>
                        <a href="javascript: void(0);" class="waves-effect">
                            <i class="ion ion-md-paper"></i>
                            <span> School Expenses </span>
                            <span class="menu-arrow"></span>
                        </a>
                        <ul class="nav-second-level nav" aria-expanded="false">
                            <li><a href="<?= base_url(); ?>Accounting/expenses">Expenses</a></li>
                            <li><a href="<?= base_url(); ?>Accounting/expensescategory">Expenses Category</a></li>
                            <li><a href="<?= base_url(); ?>Accounting/expensesReport">Expenses Reports</a></li>
                        </ul>
                    </li>

                    <li>
                        <a href="javascript: void(0);" class="waves-effect">
                            <i class="ion ion-md-paper"></i>
                            <span> Void </span>
                            <span class="menu-arrow"></span>
                        </a>
                        <ul class="nav-second-level nav" aria-expanded="false">
                            <li><a href="<?= base_url(); ?>Accounting/VoidPayment">Void Receipts</a></li>
                        </ul>
                    </li>

                    <li>
                        <a href="javascript: void(0);" class="waves-effect">
                            <i class=" ion ion-md-card"></i>
                            <span> Reports </span>
                            <span class="menu-arrow"></span>
                        </a>
                        <ul class="nav-second-level nav" aria-expanded="false">

                            <!-- <li><a href="<?= base_url(); ?>Accounting/collectionReport">Collection Report</a></li> -->
                            <li><a href="<?= base_url(); ?>Accounting/collectionReportByDate">Collection Per Date</a></li>
                            <li><a href="<?= base_url(); ?>Accounting/collectionYear">Collection Per Year</a></li>
                            <li><a href="<?= base_url(); ?>Page/onlinePaymentsAll">Online Payments (All)</a></li>
                            <li><a href="<?= base_url(); ?>Accounting/studeAccountsWithBalance">Students With Outstanding Balance</a></li>
                            <li><a href="<?= base_url(); ?>Accounting/accountingStudeReports">Student's Reports</a></li>
                            <li><a href="<?= base_url(); ?>Page/discountReports">Discounts</a></li>
                            <li><a href="<?= base_url(); ?>Overdues/index">Overdues</a></li>

                            <!-- <li><a href="<?= base_url(); ?>Accounting/accountingStudeReports">Statement Of Account</a></li> -->

                        </ul>
                    </li>

                    <li>
                        <a href="javascript: void(0);" class="waves-effect">
                            <i class=" ion ion-md-list-box "> </i>
                            <span> To Do </span>
                            <span class="menu-arrow"></span>
                        </a>
                        <ul class="nav-second-level" aria-expanded="false">
                            <li><a href="<?= base_url(); ?>ToDo/">ToDo</a></li>
                        </ul>
                    </li>

                    <li>
                        <a href="<?= base_url(); ?>Calendar/" target="_blank" class=" waves-effect">
                            <i class=" ion ion-md-calendar "> </i>
                            <span> Calendar </span>

                        </a>

                    </li>

                    <li>
                        <a href="<?= base_url(); ?>Note/" class=" waves-effect">
                            <i class=" ion ion-ios-keypad"> </i>
                            <span> Notes </span>

                        </a>

                    </li>

                    <li>
                        <a href="<?= base_url(); ?>FAQ/" target="_blank" class="waves-effect">
                            <i class="ion ion-md-help"></i>
                            <span> SRMS FAQ </span>
                        </a>
                    </li>

                </ul>

            </div>

   <?php elseif ($this->session->userdata('level') === 'Student') : ?>
    <div id="sidebar-menu">
        <ul class="metismenu" id="side-menu">

            <li class="menu-title">Navigation</li>

            <!-- Always show Dashboard -->
            <li>
                <a href="<?= base_url(); ?>Page/student" class="waves-effect">
                    <i class="ion-md-speedometer"></i>
                    <span> Dashboard </span>
                </a>
            </li>

            <?php if (empty($isFlagged) || !$isFlagged): ?>
                <!-- Full student menu (only when NOT flagged/deactivated) -->

                <li>
                    <a href="<?= base_url(); ?>Page/studentsprofile?id=<?= htmlspecialchars($this->session->userdata('username'), ENT_QUOTES); ?>" class="waves-effect">
                        <i class="ion ion-md-contact"></i>
                        <span> My Profile </span>
                    </a>
                </li>

                <li>
                    <a href="<?= base_url(); ?>Page/enrollment" class="waves-effect">
                        <i class="ion ion-md-checkbox-outline"></i>
                        <span> Enrollment </span>
                    </a>
                </li>

                <li>
                    <a href="<?= base_url(); ?>Student/student_requirements" class="waves-effect">
                        <i class="ion ion-md-folder"></i>
                        <span> Requirements </span>
                    </a>
                </li>

                <li>
                    <a href="<?= base_url(); ?>Masterlist/COR?studeno=<?= htmlspecialchars($this->session->userdata('username'), ENT_QUOTES); ?>" class="waves-effect">
                        <i class="ion ion-ios-list-box"></i>
                        <span> Enrolled Subjects </span>
                    </a>
                </li>

                <li>
                    <a href="<?= base_url(); ?>Page/state_Account?id=<?= htmlspecialchars($this->session->userdata('username'), ENT_QUOTES); ?>" class="waves-effect">
                        <i class="ion ion-ios-wallet"></i>
                        <span> Statement Of Account </span>
                    </a>
                </li>

                <li>
                    <a href="<?= base_url(); ?>Page/proof_payment" class="waves-effect">
                        <i class="ion ion-md-filing"></i>
                        <span> Proof of Payment </span>
                    </a>
                </li>

                <li>
                    <a href="<?= base_url(); ?>Masterlist/studeGradesView?studeno=<?= htmlspecialchars($this->session->userdata('username'), ENT_QUOTES); ?>" class="waves-effect">
                        <i class="ion ion-md-school"></i>
                        <span> Grades </span>
                    </a>
                </li>

                <li>
                    <a href="javascript: void(0);" class="waves-effect">
                        <i class="ion ion-ios-medkit"></i>
                        <span> Medical </span>
                        <span class="menu-arrow"></span>
                    </a>
                    <ul class="nav-second-level nav" aria-expanded="false">
                        <li><a href="<?= base_url(); ?>Page/medInfo">Medical Info</a></li>
                        <li><a href="<?= base_url(); ?>Page/medRecords">Medical Records</a></li>
                    </ul>
                </li>

                <li>
                    <a href="javascript: void(0);" class="waves-effect">
                        <i class="ion ion-ios-qr-scanner"></i>
                        <span> Guidance </span>
                        <span class="menu-arrow"></span>
                    </a>
                    <ul class="nav-second-level nav" aria-expanded="false">
                        <li><a href="<?= base_url(); ?>Page/incidents">Incidents</a></li>
                        <li><a href="<?= base_url(); ?>Page/counselling">Counselling</a></li>
                    </ul>
                </li>

                <li>
                    <a href="javascript: void(0);" class="waves-effect">
                        <i class="ion ion-ios-qr-scanner"></i>
                        <span> Request </span>
                        <span class="menu-arrow"></span>
                    </a>
                    <ul class="nav-second-level nav" aria-expanded="false">
                        <li><a href="<?= base_url(); ?>Request/my_requests">My Request</a></li>
                    </ul>
                </li>

            <?php else: ?>
                <!-- When flagged/deactivated: show a small note (optional) -->
                <li class="mt-2 px-3 small text-muted">
                    Your access is limited while your account is deactivated.
                </li>
            <?php endif; ?>

        </ul>
    </div>


        <?php elseif ($this->session->userdata('level') === 'Teacher') : ?>
            <div id="sidebar-menu">
                <ul class="metismenu" id="side-menu">

                    <li class="menu-title">Navigation</li>

                    <li>
                        <a href="<?= base_url(); ?>Page/Teacher" class="waves-effect">
                            <i class="ion-md-speedometer"></i>
                            <span> Dashboard </span>
                        </a>
                    </li>

                    <li>
                        <a href="<?= base_url(); ?>Page/staffprofile?id=<?php echo $this->session->userdata('IDNumber'); ?>" class="waves-effect">
                            <i class="ion ion-md-contact "></i>
                            <span> My Profile </span>
                        </a>
                    </li>


                    <li>
                        <a href="javascript: void(0);" class="waves-effect">
                            <i class=" ion ion-md-school"></i>
                            <span> Admission </span>
                            <span class="menu-arrow"></span>


                        </a>
                        <ul class="nav-second-level" aria-expanded="false">
                            <li><a href="<?= base_url(); ?>Page/profileList">Student's Profile</a> </li>
                            <li><a href="<?= base_url(); ?>Masterlist/enrolledList">Enrollment</a></li>
                            <li><a href="<?= base_url(); ?>Ren/sub_enlist">Subject Enlistment</a></li>
                            <!-- <li><a href="<?= base_url(); ?>page/forValidation">Online Enrollees <small style="color:red;">[for action]</small></a></li> -->

                        </ul>
                    </li>


<?php
$userID = trim((string)$this->session->userdata('IDNumber'));

// your app often uses 'sy' (lowercase). Fallback to uppercase if needed.
$currentSY = $this->session->userdata('sy');
if (!$currentSY) {
    $currentSY = $this->session->userdata('SY'); // fallback
}

// Guard: if either is empty, no need to query
$isAdviser = false;
if ($userID !== '' && $currentSY !== '') {
    // Match either IDNumber or Adviser (some rows use name instead of ID)
    $this->db->from('sections');
    $this->db->where('SY', $currentSY);
    $this->db->group_start()
             ->where('IDNumber', $userID)
             ->group_end();
    $isAdviser = $this->db->count_all_results() > 0;
}
?>

<?php if ($isAdviser): ?>
    <li>
        <a href="<?= base_url('Masterlist/advisoryClass'); ?>" class="waves-effect">
            <i class="ion ion-md-contact"></i>
            <span> Advisory Class </span>
        </a>
    </li>


    
                    <li>
                        <a href="javascript: void(0);" class="waves-effect">
                            <i class=" ion ion-md-list-box"></i>
                            <span>Attendance </span>
                            <span class="menu-arrow"></span>
                        </a>
                        <ul class="nav-second-level" aria-expanded="false">
                            <li><a href="<?= base_url(); ?>Masterlist/advisoryAttendance">Class Attendance</a></li>
                            <li><a href="<?= base_url(); ?>Masterlist/attendanceReport">Class Attendance Report</a></li>
                            <!-- <li><a href="<?= base_url(); ?>sf10/index"> Permanent Record</a></li> -->
                        </ul>
                    </li>

                      
<?php endif; ?>






                    <!-- 
                       <li>
                        <a href="<?= base_url(); ?>Masterlist/advisoryAttendance" class="waves-effect">
                            <i class=" ion ion-md-list-box"></i>
                            <span> Class Attendance </span>
                        </a>
                    </li> -->



<li class="has-nav-second-level">
    <a href="javascript:void(0);" class="waves-effect">
        <i class="ion-md-create"></i>
        <span> Grades Module </span>
        <span class="menu-arrow"></span>
    </a>
    <ul  class="nav-second-level">
        <li >
            <a href="<?= base_url(); ?>Page/save_grades">Manual Grades Encoding</a>
        </li>
        <li>
<a href="<?= base_url(); ?>Instructor/consol_teacher" target="_blank">Consolidated Grades</a>
        </li>
        <li>
            <a href="<?= base_url(); ?>Page/update_grades">Calculate Grades</a>
        </li>


    </ul>
</li>


<?php if ($isAdviser): ?>

                       <li>
                        <a href="javascript: void(0);" class="waves-effect">
                            <i class=" ion ion-md-cog "></i>
                            <span> Configuration </span>
                            <span class="menu-arrow"></span>
                        </a>
                        <ul class="nav-second-level" aria-expanded="false">
                         
                            <li><a href="<?= base_url() ?>Settings/ClassProgram">Class Program</a></li>
                        </ul>
                    </li>
<?php endif; ?>



                    <li>
                        <a href="javascript: void(0);" class="waves-effect">
                            <i class=" ion ion-md-settings"></i>
                            <span> Inventory </span>
                            <span class="menu-arrow"></span>
                        </a>
                        <ul class="nav-second-level" aria-expanded="false">
                            <li><a href="<?= base_url(); ?>Page/Accountable">Inventory List</a></li>
                        </ul>
                    </li>

                    <li>
                        <a href="javascript: void(0);" class="waves-effect">
                            <i class=" ion ion-md-list-box "> </i>
                            <span> To Do </span>
                            <span class="menu-arrow"></span>
                        </a>
                        <ul class="nav-second-level" aria-expanded="false">
                            <li><a href="<?= base_url(); ?>ToDo/">ToDo</a></li>
                        </ul>
                    </li>

                    <li>
                        <a href="<?= base_url(); ?>Calendar/" target="_blank" class=" waves-effect">
                            <i class=" ion ion-md-calendar "> </i>
                            <span> Calendar </span>

                        </a>

                    </li>

                    <li>
                        <a href="<?= base_url(); ?>Note/" class=" waves-effect">
                            <i class=" ion ion-ios-keypad"> </i>
                            <span> Notes </span>

                        </a>

                    </li>

        

                    <?php if ($schoolType === 'Public'): ?>
                        <li>
                            <a href="javascript:void(0);" class="waves-effect">
                                <i class="ion ion-md-expand"></i>
                                <span> BAC </span>
                                <span class="menu-arrow"></span>
                            </a>
                            <ul class="nav-second-level" aria-expanded="false">
                                <li><a href="<?= base_url(); ?>BAC/activity_list">Activities/Projects</a></li>
                            </ul>
                        </li>
                    <?php elseif ($schoolType === 'Private'): ?>
                        <!-- You can add a menu for Private here if needed -->
                    <?php endif; ?>


                    <li>
                        <a href="<?= base_url(); ?>FAQ/" target="_blank" class="waves-effect">
                            <i class="ion ion-md-help"></i>
                            <span> SRMS FAQ </span>
                        </a>
                    </li>



                </ul>
            </div>

        <?php elseif ($this->session->userdata('level') === 'Librarian') : ?>
            <div id="sidebar-menu">
                <ul class="metismenu" id="side-menu">

                    <li class="menu-title">Navigation</li>

                    <li>
                        <a href="<?= base_url(); ?>Page/library" class="waves-effect">
                            <i class="ion-md-speedometer"></i>
                            <span> Dashboard </span>
                        </a>
                    </li>


                    <li>
                        <a href="<?= base_url(); ?>Library/Books" class="waves-effect">
                            <i class=" ion ion-ios-document"></i>
                            <span> Cataloging </span>
                        </a>
                    </li>
                    <li>
                        <a href="<?= base_url(); ?>Library/ebooks" class="waves-effect">
                            <i class=" ion ion-ios-book"></i>
                            <span> E-Book </span>
                        </a>
                    </li>
                    <li>
                        <a href="javascript: void(0);" class="waves-effect">
                            <i class=" ion ion-ios-photos"></i>
                            <span> Circulation </span>
                            <span class="menu-arrow"></span>
                        </a>
                        <ul class="nav-second-level" aria-expanded="false">
                            <li><a href="<?= base_url(); ?>Library/borrow">Borrow</a></li>
                            <li><a href="<?= base_url(); ?>Library/returnbooks">Return</a></li>
                        </ul>
                    </li>

                    <li>
                        <a href="javascript: void(0);" class="waves-effect">
                            <i class=" ion ion-md-settings"></i>
                            <span> Settings </span>
                            <span class="menu-arrow"></span>
                        </a>
                        <ul class="nav-second-level" aria-expanded="false">
                            <li><a href="<?= base_url(); ?>Library/author">Author</a></li>
                            <li><a href="<?= base_url(); ?>Library/category">Category</a></li>
                            <li><a href="<?= base_url(); ?>Library/location">Location</a></li>
                            <li><a href="<?= base_url(); ?>Library/publisher">Publisher</a></li>
                            <li><a href="<?= base_url(); ?>Library/other_settings">Other Settings</a></li>
                        </ul>
                    </li>
                    <li>
                        <a href="javascript: void(0);" class="waves-effect">
                            <i class=" ion ion-ios-paper"></i>
                            <span> Reports </span>
                            <span class="menu-arrow"></span>
                        </a>
                        <ul class="nav-second-level" aria-expanded="false">
                            <li><a href="<?= base_url(); ?>Library/reportsAllBooks">All Books</a></li>
                        </ul>
                    </li>

                    <li>
                        <a href="javascript: void(0);" class="waves-effect">
                            <i class=" ion ion-md-list-box "> </i>
                            <span> To Do </span>
                            <span class="menu-arrow"></span>
                        </a>
                        <ul class="nav-second-level" aria-expanded="false">
                            <li><a href="<?= base_url(); ?>ToDo/">ToDo</a></li>
                        </ul>
                    </li>

                    <li>
                        <a href="<?= base_url(); ?>Calendar/" target="_blank" class=" waves-effect">
                            <i class=" ion ion-md-calendar "> </i>
                            <span> Calendar </span>

                        </a>

                    </li>

                    <li>
                        <a href="<?= base_url(); ?>Note/" class=" waves-effect">
                            <i class=" ion ion-ios-keypad"> </i>
                            <span> Notes </span>

                        </a>

                    </li>

                    <li>
                        <a href="<?= base_url(); ?>FAQ/" target="_blank" class="waves-effect">
                            <i class="ion ion-md-help"></i>
                            <span> SRMS FAQ </span>
                        </a>
                    </li>


                </ul>
            </div>

        <?php elseif ($this->session->userdata('level') === 'BAC') : ?>
            <div id="sidebar-menu">
                <ul class="metismenu" id="side-menu">

                    <li class="menu-title">Navigation</li>

                    <li>
                        <a href="<?= base_url(); ?>Page/bac" class="waves-effect">
                            <i class="ion-md-speedometer"></i>
                            <span> Dashboard </span>
                        </a>
                    </li>

                    <li>
                        <a href="javascript: void(0);" class="waves-effect">
                            <i class=" ion ion-md-expand"></i>
                            <span> BAC </span>
                            <span class="menu-arrow"></span>
                        </a>
                        <ul class="nav-second-level" aria-expanded="false">
                            <li><a href="<?= base_url(); ?>BAC/activity_list">Activities/Projects</a></li>
                        </ul>
                    </li>

                    <li>
                        <a href="javascript: void(0);" class="waves-effect">
                            <i class=" ion ion-ios-paper"></i>
                            <span> Reports </span>
                            <span class="menu-arrow"></span>
                        </a>
                        <ul class="nav-second-level" aria-expanded="false">
                            <li><a href="#">Sample Report</a></li>
                        </ul>
                    </li>

                    <li>
                        <a href="javascript: void(0);" class="waves-effect">
                            <i class=" ion ion-md-list-box "> </i>
                            <span> To Do </span>
                            <span class="menu-arrow"></span>
                        </a>
                        <ul class="nav-second-level" aria-expanded="false">
                            <li><a href="<?= base_url(); ?>ToDo/">ToDo</a></li>
                        </ul>
                    </li>

                    <li>
                        <a href="<?= base_url(); ?>Calendar/" target="_blank" class=" waves-effect">
                            <i class=" ion ion-md-calendar "> </i>
                            <span> Calendar </span>

                        </a>

                    </li>

                    <li>
                        <a href="<?= base_url(); ?>Note/" class=" waves-effect">
                            <i class=" ion ion-ios-keypad"> </i>
                            <span> Notes </span>

                        </a>

                    </li>

                    <li>
                        <a href="<?= base_url(); ?>FAQ/" target="_blank" class="waves-effect">
                            <i class="ion ion-md-help"></i>
                            <span> SRMS FAQ </span>
                        </a>
                    </li>

                </ul>
            </div>

        <?php elseif ($this->session->userdata('level') === 'Guidance') : ?>
            <div id="sidebar-menu">
                <ul class="metismenu" id="side-menu">

                    <li class="menu-title">Navigation</li>

                    <li>
                        <a href="<?= base_url(); ?>Page/guidance" class="waves-effect">
                            <i class="ion-md-speedometer"></i>
                            <span> Dashboard </span>
                        </a>
                    </li>

                    <li>
                        <a href="<?= base_url(); ?>Page/incidents" class="waves-effect">
                            <i class="ion ion-md-alert"></i>
                            <span> Incidents </span>
                        </a>
                    </li>

                    <li>
                        <a href="<?= base_url(); ?>Page/counselling" class="waves-effect">
                            <i class="ion ion-ios-analytics"></i>
                            <span> Counselling </span>
                        </a>
                    </li>

                    <li>
                        <a href="javascript: void(0);" class="waves-effect">
                            <i class=" ion ion-md-list-box "> </i>
                            <span> To Do </span>
                            <span class="menu-arrow"></span>
                        </a>
                        <ul class="nav-second-level" aria-expanded="false">
                            <li><a href="<?= base_url(); ?>ToDo/">ToDo</a></li>
                        </ul>
                    </li>

                    <li>
                        <a href="<?= base_url(); ?>Calendar/" target="_blank" class=" waves-effect">
                            <i class=" ion ion-md-calendar "> </i>
                            <span> Calendar </span>

                        </a>

                    </li>

                    <li>
                        <a href="<?= base_url(); ?>Note/" class=" waves-effect">
                            <i class=" ion ion-ios-keypad"> </i>
                            <span> Notes </span>

                        </a>

                    </li>

                    <li>
                        <a href="<?= base_url(); ?>FAQ/" target="_blank" class="waves-effect">
                            <i class="ion ion-md-help"></i>
                            <span> SRMS FAQ </span>
                        </a>
                    </li>

                </ul>
            </div>

        <?php elseif ($this->session->userdata('level') === 'School Nurse') : ?>
            <div id="sidebar-menu">
                <ul class="metismenu" id="side-menu">

                    <li class="menu-title">Navigation</li>

                    <li>
                        <a href="<?= base_url(); ?>Page/medical" class="waves-effect">
                            <i class="ion-md-speedometer"></i>
                            <span> Dashboard </span>
                        </a>
                    </li>

                    <li>
                        <a href="<?= base_url(); ?>Page/medInfo" class="waves-effect">
                            <i class="ion ion-md-medical "></i>
                            <span> Medical Info </span>
                        </a>
                    </li>

                    <li>
                        <a href="<?= base_url(); ?>Page/medRecords" class="waves-effect">
                            <i class="ion ion-md-medkit "></i>
                            <span> Medical Records </span>
                        </a>
                    </li>

                    <li>
                        <a href="javascript: void(0);" class="waves-effect">
                            <i class=" ion ion-md-list-box "> </i>
                            <span> To Do </span>
                            <span class="menu-arrow"></span>
                        </a>
                        <ul class="nav-second-level" aria-expanded="false">
                            <li><a href="<?= base_url(); ?>ToDo/">ToDo</a></li>
                        </ul>
                    </li>

                    <li>
                        <a href="<?= base_url(); ?>Calendar/" target="_blank" class=" waves-effect">
                            <i class=" ion ion-md-calendar "> </i>
                            <span> Calendar </span>

                        </a>

                    </li>

                    <li>
                        <a href="<?= base_url(); ?>Note/" class=" waves-effect">
                            <i class=" ion ion-ios-keypad"> </i>
                            <span> Notes </span>

                        </a>

                    </li>

                    <li>
                        <a href="<?= base_url(); ?>FAQ/" target="_blank" class="waves-effect">
                            <i class="ion ion-md-help"></i>
                            <span> SRMS FAQ </span>
                        </a>
                    </li>


                </ul>
            </div>

        <?php elseif ($this->session->userdata('level') === 'Super Admin'): ?>
            <div id="sidebar-menu">
                <ul class="metismenu" id="side-menu">
                    <li class="menu-title">Navigation</li>

                    <li>
                        <a href="<?= base_url(); ?>Page/superAdmin" class="waves-effect">
                            <i class="ion-md-speedometer"></i>
                            <span> Dashboard </span>
                        </a>
                    </li>

                    <li>
                        <a href="<?= base_url(); ?>Page/school_info" class="waves-effect">
                            <i class="ion ion-md-folder-open"></i>
                            <span> School Info </span>
                        </a>
                    </li>


                    <li>
                        <a href="<?= base_url(); ?>Page/system_setting" class="waves-effect">
                            <i class=" ion ion-md-settings"></i>
                            <span> System Setting </span>
                        </a>
                    </li>

                    <li>
                        <a href="javascript: void(0);" class="waves-effect">
                            <i class="ion ion-md-paper"> </i>
                            <span> School Settings </span>
                            <span class="menu-arrow"></span>
                        </a>
                        <ul class="nav-second-level" aria-expanded="false">
                            <li><a href="<?= base_url('OnlineSettings'); ?>">On/Off Online Payment</a></li>
                            <!-- <li><a href="<?= base_url('OnlineSettings/OnlinePaymentSettings'); ?>">Online Payment Settings</a></li> -->
                            <!-- <li><a href="#">LMS Settings</a></li> -->
                        </ul>
                    </li>

                    <li>
                        <a href="<?= base_url(); ?>Settings/view_logs" class="waves-effect">
                            <i class=" ion ion-md-settings"></i>
                            <span> User Logs </span>
                        </a>
                    </li>

                </ul>
            </div>


        <?php endif; ?>




        <div class="clearfix"></div>

    </div>
    <!-- Sidebar -left -->

</div>