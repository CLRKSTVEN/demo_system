<!DOCTYPE html>
<html lang="en">
<?php include(APPPATH . 'views/includes/head.php'); ?>

<body>
  <div id="wrapper">
    <?php include(APPPATH . 'views/includes/top-nav-bar.php'); ?>
    <?php include(APPPATH . 'views/includes/sidebar.php'); ?>

    <style>
      .settings-card {
        border: 0;
        box-shadow: 0 8px 28px rgba(0, 0, 0, .08);
        border-radius: 18px;
        overflow: hidden;
      }

      .settings-head {
        background: linear-gradient(135deg, #3b82f6, #06b6d4);
        color: #fff;
        padding: 20px 22px;
        display: flex;
        align-items: center;
        gap: 14px;
      }

      .settings-head .icon {
        width: 44px;
        height: 44px;
        border-radius: 12px;
        background: rgba(255, 255, 255, .2);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 22px;
      }

      .settings-body {
        padding: 22px;
      }

      .switch-xl {
        transform: scale(1.35);
        transform-origin: left center;
      }

      .muted {
        color: #6c757d;
      }

      .hint {
        font-size: .92rem;
        color: #6c757d;
        margin-top: 10px;
      }

      .divider {
        height: 1px;
        background: #eef0f3;
        margin: 18px 0;
      }

      .badge-pill {
        border-radius: 999px;
        padding: .45rem .8rem;
        font-weight: 600;
      }

      .list-compact li {
        margin-bottom: 6px;
      }

      .pending-dot {
        width: 8px;
        height: 8px;
        border-radius: 50%;
        background: #ffc107;
        display: inline-block;
        margin-right: 6px;
      }

      .btn-link-muted {
        color: #6c757d;
      }

      .btn-link-muted:hover {
        color: #495057;
        text-decoration: none;
      }

      .scope-badges .badge {
        font-weight: 600;
        letter-spacing: .2px;
      }

      .callout {
        border-left: 4px solid #3b82f6;
        background: #f8fafc;
        padding: 12px 14px;
        border-radius: 10px;
      }

      .callout .title {
        font-weight: 700;
        margin-bottom: 6px;
      }

      .mini {
        font-size: .9rem;
      }

      .cardish {
        border: 1px solid #eef0f3;
        border-radius: 12px;
        padding: 12px 14px;
        display: flex;
        gap: 12px;
        align-items: flex-start;
        background: #fff;
      }

      .cardish .ic {
        width: 34px;
        height: 34px;
        border-radius: 10px;
        background: #eef6ff;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 18px;
        color: #2563eb;
        flex: 0 0 auto;
      }

      .soft {
        color: #6b7280;
      }

      /* ---------- Custom Toast ---------- */
      .ct-toast {
        position: fixed;
        top: 1rem;
        right: 1rem;
        z-index: 2000;
        background: #ffffff;
        color: #1f2937;
        border-radius: 12px;
        box-shadow: 0 10px 30px rgba(0, 0, 0, .15);
        min-width: 280px;
        max-width: 360px;
        padding: 12px 14px 12px 12px;
        display: flex;
        align-items: flex-start;
        gap: 10px;
        border-left: 5px solid #22c55e;
        opacity: 0;
        transform: translateY(-10px);
        pointer-events: none;
        transition: opacity .2s ease, transform .2s ease;
      }

      .ct-toast.is-visible {
        opacity: 1;
        transform: translateY(0);
        pointer-events: auto;
      }

      .ct-toast__icon {
        font-size: 20px;
        line-height: 1;
        margin-top: 2px;
        color: #22c55e;
      }

      .ct-toast__body {
        flex: 1;
      }

      .ct-toast__title {
        font-weight: 700;
        margin: 0 0 2px 0;
        font-size: 0.95rem;
      }

      .ct-toast__text {
        margin: 0;
        font-size: 0.92rem;
        color: #475569;
      }

      .ct-toast__close {
        appearance: none;
        border: 0;
        background: transparent;
        color: #6b7280;
        font-size: 18px;
        line-height: 1;
        padding: 0 4px;
        cursor: pointer;
      }

      .ct-toast__close:hover {
        color: #111827;
      }
    </style>

    <div class="content-page">
      <div class="content">
        <div class="container-fluid">

          <div class="row justify-content-center">
            <div class="col-lg-8 col-md-10">
              <div class="card settings-card">
                <div class="settings-head">
                  <div class="icon"><i class="ion ion-md-settings"></i></div>
                  <div>
                    <h4 class="mb-0">Online Payment Settings</h4>

                  </div>
                </div>

                <div class="settings-body">
                  <?php
                  $isOn = !empty($online_settings) && (int)$online_settings->show_online_payments === 1;
                  $lastUpdated = !empty($online_settings->updated_at) ? date('M d, Y g:i A', strtotime($online_settings->updated_at)) : null;
                  $flashSuccess = $this->session->flashdata('success'); // read ONCE

                  // Optional: Build a quick student test URL if session has StudentNumber
                  $studentQuick = $this->session->userdata('StudentNumber');
                  $testUrl = $studentQuick ? base_url('Page/studeaccount?id=' . urlencode($studentQuick)) : base_url('Page/studeaccount');
                  ?>



                  <div class="divider"></div>

                  <!-- Toggle -->
                  <form method="post" action="<?= base_url('OnlineSettings/update'); ?>" id="settingsForm" novalidate>
                    <input type="hidden" name="settingsID" value="<?= (int)($settingsRow['settingsID'] ?? 0) ?>">

                    <div class="mb-3">
                      <label for="dragonpay_merchantid" class="form-label mb-1"><strong>Dragonpay Merchant ID</strong></label>
                      <input
                        type="text"
                        class="form-control"
                        id="dragonpay_merchantid"
                        name="dragonpay_merchantid"
                        value="<?= html_escape($settingsRow['dragonpay_merchantid'] ?? '') ?>"
                        placeholder="e.g., DP123456"
                        required>
                      <div class="muted mini">Provided by Dragonpay.</div>
                    </div>

                    <div class="mb-3">
                      <label for="dragonpay_password" class="form-label mb-1"><strong>Dragonpay Password</strong></label>
                      <input
                        type="password"
                        class="form-control"
                        id="dragonpay_password"
                        name="dragonpay_password"
                        value="<?= html_escape($settingsRow['dragonpay_password'] ?? '') ?>"
                        placeholder="••••••••"
                        required>
                      <div class="muted mini">API password/secret from your Dragonpay dashboard.</div>
                    </div>

                    <div class="mb-3">
                      <label for="dragonpay_url" class="form-label mb-1"><strong>Dragonpay Endpoint URL</strong></label>
                      <input
                        type="url"
                        class="form-control"
                        id="dragonpay_url"
                        name="dragonpay_url"
                        value="<?= html_escape($settingsRow['dragonpay_url'] ?? '') ?>"
                        placeholder="https://gw.dragonpay.ph/Pay.aspx"
                        required>
                      <div class="muted mini">Production or sandbox endpoint.</div>
                    </div>

                    <div class="divider"></div>

                    <div class="d-flex align-items-center flex-wrap gap-2">
                      <button type="submit" class="btn btn-primary" id="saveBtn" disabled>
                        <i class="ion ion-md-save"></i> Submit
                      </button>
                      <button type="button" class="btn btn-link btn-link-muted ml-2" id="resetBtn" disabled>
                        Reset
                      </button>
                    </div>
                  </form>

                  <script>
                    (function() {
                      const form = document.getElementById('settingsForm');
                      const saveBtn = document.getElementById('saveBtn');
                      const resetBtn = document.getElementById('resetBtn');

                      // Capture initial values for dirty-checking
                      const initial = new FormData(form);
                      const isDirty = () => {
                        const now = new FormData(form);
                        for (const [k, v] of initial.entries()) {
                          if ((now.get(k) ?? '') !== (v ?? '')) return true;
                        }
                        // Also catch any new fields (shouldn’t happen here but safer)
                        for (const [k] of now.entries()) {
                          if (!initial.has(k)) return true;
                        }
                        return false;
                      };

                      const toggleButtons = () => {
                        const dirty = isDirty();
                        saveBtn.disabled = !dirty;
                        resetBtn.disabled = !dirty;
                      };

                      form.addEventListener('input', toggleButtons);
                      form.addEventListener('change', toggleButtons);

                      resetBtn.addEventListener('click', () => {
                        // Restore original values
                        for (const [k, v] of initial.entries()) {
                          const el = form.elements.namedItem(k);
                          if (!el) continue;
                          if (el.type === 'checkbox' || el.type === 'radio') {
                            el.checked = (v === 'on' || v === '1' || v === el.value);
                          } else {
                            el.value = v;
                          }
                        }
                        toggleButtons();
                      });

                      // Initialize state
                      toggleButtons();
                    })();
                  </script>



                </div>
              </div>
            </div>
          </div>

        </div>
      </div>

      <?php include(APPPATH . 'views/includes/footer.php'); ?>
    </div>
  </div>

  <!-- Toast -->
  <div id="ctToast" class="ct-toast" role="alert" aria-live="assertive" aria-atomic="true">
    <div class="ct-toast__icon"><i class="ion ion-md-checkmark-circle"></i></div>
    <div class="ct-toast__body">
      <div class="ct-toast__title">Settings Updated</div>
      <p class="ct-toast__text" id="ctToastMsg">Online Payments visibility has been saved successfully.</p>
    </div>
    <button class="ct-toast__close" type="button" aria-label="Close">&times;</button>
  </div>

  <script>
    (function() {
      var chk = document.getElementById('showOP');
      var form = document.getElementById('toggleForm');
      var saveBtn = document.getElementById('saveBtn');
      var resetBtn = document.getElementById('resetBtn');
      var badge = document.getElementById('statusBadge');
      var pending = document.getElementById('pendingNote');

      if (!chk || !badge || !saveBtn || !resetBtn) return;

      var initialIsOn = <?= $isOn ? 'true' : 'false' ?>;

      function reflectToggle() {
        var isOn = chk.checked;
        badge.textContent = isOn ? 'ENABLED' : 'DISABLED';
        badge.classList.toggle('badge-success', isOn);
        badge.classList.toggle('badge-danger', !isOn);
        var changed = (isOn !== initialIsOn);
        if (pending) pending.classList.toggle('d-none', !changed);
        saveBtn.disabled = !changed;
        resetBtn.disabled = !changed;
      }

      chk.addEventListener('change', reflectToggle);

      resetBtn.addEventListener('click', function() {
        chk.checked = initialIsOn;
        reflectToggle();
      });

      form.addEventListener('submit', function() {
        saveBtn.disabled = true;
        resetBtn.disabled = true;
        saveBtn.innerHTML = '<span class="spinner-border spinner-border-sm mr-1"></span> Saving...';
      });

      reflectToggle();
    })();
  </script>

  <script>
    (function() {
      var toast = document.getElementById('ctToast');
      var toastMsgEl = document.getElementById('ctToastMsg');
      var closeBtn = toast.querySelector('.ct-toast__close');
      var hideTimer = null;

      function showToast(message, ms) {
        if (!toast) return;
        if (typeof message === 'string' && toastMsgEl) toastMsgEl.textContent = message;

        clearTimeout(hideTimer);
        toast.classList.add('is-visible');
        hideTimer = setTimeout(hideToast, ms || 2500);
      }

      function hideToast() {
        toast.classList.remove('is-visible');
      }

      if (closeBtn) closeBtn.addEventListener('click', hideToast);

      var flashMsg = <?php echo json_encode($flashSuccess ?: null); ?>;
      if (flashMsg) {
        showToast(flashMsg, 2500);
      }
    })();
  </script>
</body>

</html>