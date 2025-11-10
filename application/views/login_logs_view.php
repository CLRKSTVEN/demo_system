<!DOCTYPE html>
<html lang="en">

<?php include('includes/head.php'); ?>

<body>

    <div id="wrapper">

        <?php include('includes/top-nav-bar.php'); ?>
        <?php include('includes/sidebar.php'); ?>

        <div class="content-page">
            <div class="content">
                <div class="container-fluid">

                    <!-- Page Title -->
                    <div class="row">
                        <div class="col-12">
                            <div class="page-title-box">
                                <div class="clearfix"></div>
                            </div>
                        </div>
                    </div>

                    <!-- Search Form -->
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <form id="logSearchForm" onsubmit="return false;">
                                <div class="input-group">
                                    <input type="text" id="searchInput" class="form-control" placeholder="Search username...">
                                    <div class="input-group-append">
                                        <button type="button" class="btn btn-primary" onclick="searchLogs()">Search</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>

                    <!-- Log Table -->
                    <div class="row">
                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-body table-responsive">
                                    <h4 class="header-title mb-4"><b>Login Logs</b></h4>

                                    <table class="table table-bordered" id="logTable">
                                        <thead>
                                            <tr>
                                                <th>Username</th>
                                                <?php if ($this->session->userdata('level') === 'Super Admin'): ?>
                                                    <th>Password Attempt</th>
                                                <?php endif; ?>
                                                <th>Status</th>
                                                <th>IP</th>
                                                <th>Date & Time</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach ($logs as $index => $log): ?>
                                                <tr class="log-row" style="display: none;">
                                                    <td class="username-cell"><?= htmlspecialchars($log->username) ?></td>

                                                    <?php if ($this->session->userdata('level') === 'Super Admin'): ?>
                                                        <td>
                                                            <?php if (!empty($log->decrypted_password) && $log->decrypted_password !== '-' && $log->decrypted_password !== 'N/A'): ?>
                                                                <span id="pwd<?= $index ?>"
                                                                    onclick="togglePassword('pwd<?= $index ?>')"
                                                                    data-hidden="<?= htmlspecialchars($log->decrypted_password) ?>"
                                                                    style="cursor:pointer; color:blue; text-decoration:underline;">
                                                                    [Click to Show]
                                                                </span>
                                                            <?php else: ?>
                                                                <?= htmlspecialchars($log->decrypted_password ?? 'N/A') ?>
                                                            <?php endif; ?>
                                                        </td>
                                                    <?php endif; ?>

                                                    <td><?= ucfirst($log->status) ?></td>
                                                    <td><?= $log->ip_address ?></td>
                                                    <td><?= $log->login_time ?></td>
                                                </tr>
                                            <?php endforeach; ?>
                                        </tbody>
                                    </table>

                                    <script>
                                        function togglePassword(id) {
                                            const el = document.getElementById(id);
                                            el.innerText = el.getAttribute('data-hidden');
                                        }

                                        function searchLogs() {
                                            const keyword = document.getElementById('searchInput').value.toLowerCase().trim();
                                            const rows = document.querySelectorAll('.log-row');
                                            let found = false;

                                            rows.forEach(row => {
                                                const usernameCell = row.querySelector('.username-cell');
                                                if (usernameCell && usernameCell.innerText.toLowerCase().includes(keyword)) {
                                                    row.style.display = '';
                                                    found = true;
                                                } else {
                                                    row.style.display = 'none';
                                                }
                                            });

                                            if (!found && keyword !== '') {
                                                alert("No results found for: " + keyword);
                                            }
                                        }
                                    </script>

                                   

                                </div>
                            </div>
                        </div>
                    </div>

                </div> <!-- container -->
            </div> <!-- content -->

            <?php include('includes/footer.php'); ?>
        </div> <!-- content-page -->
    </div> <!-- wrapper -->

    <?php include('includes/themecustomizer.php'); ?>

    <script src="<?= base_url(); ?>assets/js/vendor.min.js"></script>
    <script src="<?= base_url(); ?>assets/js/app.min.js"></script>

</body>

</html>