<?php 

include "profile_data.php"; ?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Profile Settings</title>
  <link rel="stylesheet" href="../assets/css/login.css" />
  <style>
    body {
      background: #fcfdfb;
      font-family: "Segoe UI", sans-serif;
      margin: 0;
      padding: 0;
    }
    .profile-header {
      display: flex;
      align-items: center;
      gap: 12px;
      margin-bottom: 24px;
      flex-wrap: wrap;
    }
    .profile-title {
      font-size: 2rem;
      color: #eab308;
      font-weight: bold;
    }
    .profile-section {
      display: flex;
      flex-wrap: wrap;
      gap: 32px;
      margin-bottom: 32px;
    }
    .profile-card, .password-card {
      background: #fff;
      border-radius: 16px;
      box-shadow: 0 2px 8px rgba(60,180,120,0.08);
      padding: 32px;
      flex: 1 1 320px;
      min-width: 350px;
    }
    .avatar {
      width: 120px;
      height: 120px;
      border-radius: 50%;
      background: #f3f3f3;
      display: flex;
      align-items: center;
      justify-content: center;
      margin: 0 auto 18px;
      position: relative;
      overflow: hidden;
      transition: 0.2s;
      cursor: default;
    }
    .profile-label {
      font-weight: 500;
      margin-bottom: 6px;
    }
    .profile-input, .bank-input, select {
      width: 100%;
      padding: 10px;
      margin-bottom: 16px;
      border-radius: 8px;
      border: 1px solid #eaeaea;
      font-size: 1rem;
      transition: background 0.2s, border-color 0.2s;
    }
    .profile-input:disabled {
      background: #f8f8f8;
      color: #777;
      border-color: #e0e0e0;
      cursor: not-allowed;
    }
    .profile-btn, .bank-btn {
      width: 100%;
      background: linear-gradient(90deg, #facc15, #d97706);
      color: #222;
      font-weight: 600;
      border: none;
      border-radius: 10px;
      padding: 12px;
      margin-top: 8px;
      cursor: pointer;
      transition: 0.2s;
    }
    .profile-btn:hover, .bank-btn:hover {
      opacity: 0.9;
    }
    .bank-section {
      background: #fff;
      border-radius: 16px;
      box-shadow: 0 2px 8px rgba(60,180,120,0.08);
      padding: 32px;
      margin-bottom: 32px;
    }
    .bank-list {
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(400px, 1fr));
      gap: 16px;
      margin-bottom: 24px;
    }
    .bank-card {
      background: #fff;
      border-radius: 12px;
      box-shadow: 0 4px 24px rgba(60,180,120,0.08), 0 1.5px 8px rgba(0,0,0,0.06);
      padding: 18px 24px;
      display: flex;
      align-items: center;
      transition: transform 0.2s, box-shadow 0.2s;
    }
    .bank-card:hover {
      transform: translateY(-3px);
      box-shadow: 0 6px 20px rgba(60,180,120,0.15);
    }
    .remove-bank-btn {
      margin-left: 16px;
      background: #fff;
      color: #c00;
      border: 1px solid #c00;
      border-radius: 8px;
      padding: 8px 16px;
      cursor: pointer;
      font-weight: 600;
      flex-shrink: 0;
    }
    @media (max-width: 768px) {
      .profile-section { flex-direction: column; }
      .profile-title { font-size: 1.5rem; }
      .bank-card {
        flex-direction: column;
        align-items: flex-start;
        text-align: left;
        padding: 16px;
      }
      .remove-bank-btn {
        margin-top: 10px;
        width: 100%;
        text-align: center;
      }
    }
  </style>
</head>

<body>
  <div style="padding:24px 16px;max-width:1200px;margin:auto;box-sizing:border-box;">
    <div class="profile-header">
      <button onclick="history.back()" style="background:none;border:none;cursor:pointer;padding:6px 10px;border-radius:8px;display:flex;align-items:center;justify-content:center;">
        <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="#333" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
          <polyline points="15 18 9 12 15 6"></polyline>
        </svg>
      </button>
      <div class="profile-title">Profile Settings</div>
    </div>

    <div class="profile-section">
      <div class="profile-card">
        <div style="font-size:1.2rem;font-weight:600;margin-bottom:8px;">Profile Information</div>
        <div style="color:#888;margin-bottom:18px;">Update your personal details</div>
        <div class="avatar" id="avatarContainer">
          <img id="avatarPreview" src="<?php echo $img; ?>" alt="Avatar" style="width:100%;height:100%;border-radius:50%;object-fit:cover;">
        </div>

        <div class="profile-label">Full Name</div>
        <input class="profile-input" id="fullName" value="<?php echo $user_name; ?>" type="text" disabled>
        <div class="profile-label">Email Address</div>
        <input class="profile-input" id="email" type="email" value="<?php echo $email; ?>" disabled>
        <div class="profile-label">Phone Number</div>
        <input class="profile-input" id="phone" type="text" value="<?php echo $phone_number; ?>" disabled>
        <button id="editProfileBtn" class="profile-btn" onclick="toggleEdit()">Edit Profile</button>
      </div>

      <div class="password-card">
        <div style="font-size:1.2rem;font-weight:600;margin-bottom:8px;">Change Password</div>
        <div style="color:#888;margin-bottom:18px;">Update your account password</div>
        <div class="profile-label">Current Password</div>
        <input class="profile-input" type="password" id="currentPassword" placeholder="Enter current password">
        <div class="profile-label">New Password</div>
        <input class="profile-input" type="password" id="newPassword" placeholder="Enter new password">
        <div class="profile-label">Confirm New Password</div>
        <input class="profile-input" type="password" id="confirmPassword" placeholder="Confirm new password">
        <button class="profile-btn" id="change_password">Change Password</button>
      </div>
    </div>

    <div class="bank-section">
      <div style="font-size:1.2rem;font-weight:600;margin-bottom:8px;">Bank Information</div>
      <div style="color:#888;margin-bottom:18px;">Update your banking details for withdrawals</div>
      <div class="bank-list" id="bankListContainer">
        <?php 
          if (!empty($banks)) {
            foreach ($banks as $bank) {
              echo '<div class="bank-card" data-account-number="' . $bank['account_number'] . '">';
              echo '<div style="flex:0 0 60px;display:flex;align-items:center;justify-content:center;">';
              echo '<img src="' . $bank['bank_name'] . '.png" alt="Bank" style="width:40px;">';
              echo '</div>';
              echo '<div style="flex:1;padding-left:16px;">';
              echo '<div style="font-size:1.1rem;font-weight:600;letter-spacing:2px;">' . $bank['account_number'] . '</div>';
              echo '<div style="color:#888;font-size:0.95rem;">' . $bank['account_holder'] . '</div>';
              echo '</div>';
              echo '<button class="remove-bank-btn" onclick="handleRemoveBank(\'' . $bank['account_number'] . '\', \'' . $bank['bank_name'] . '\')">Remove</button>';
              echo '</div>';
            }
          } else {
            echo '<p style="color:#888;">No bank accounts added yet.</p>';
          }
        ?>
      </div>
      <button class="bank-btn" onclick="openBankModal()">+ Add Bank</button>
    </div>
  </div>

  <!-- Add Bank Modal -->
  <div id="bankModal" style="display:none;position:fixed;top:0;left:0;width:100vw;height:100vh;background:rgba(0,0,0,0.3);z-index:1000;align-items:center;justify-content:center;">
    <div style="background:#fff;padding:32px;border-radius:16px;max-width:500px;width:90vw;box-shadow:0 2px 16px rgba(0,0,0,0.15);position:relative;">
      <button onclick="closeBankModal()" style="position:absolute;top:12px;right:12px;background:none;border:none;font-size:1.5rem;cursor:pointer;color:#888;">&times;</button>
      <div class="profile-label">Account Holder Name</div>
      <input id="accountHolderName" class="bank-input" type="text" placeholder="Enter account holder name"> 
      <div class="profile-label">Account Number</div>
      <input id="accountNumber" class="bank-input" type="text" placeholder="Enter account number">
      <div class="profile-label">Bank Name</div>
      <select id="bankName" class="bank-input">
        <option value="">Select bank</option>
        <option value="KBZ">KBZ</option>
        <option value="CB">CB</option>
        <option value="AYA">AYA</option>
      </select>
      <button class="bank-btn" onclick="handleBankConfirm()">Confirm</button>
    </div>
  </div>

  <script>
    // --- Modal Control ---
    function openBankModal() {
      document.getElementById('bankModal').style.display = 'flex';
    }
    function closeBankModal() {
      document.getElementById('bankModal').style.display = 'none';
    }

    // --- Create bank card HTML ---
    function createBankCardHTML(bank) {
      return `
        <div class="bank-card" data-account-number="${bank.account_number}">
          <div style="flex:0 0 60px;display:flex;align-items:center;justify-content:center;">
            <img src="${bank.bank_name}.png" alt="Bank" style="width:40px;">
          </div>
          <div style="flex:1;padding-left:16px;">
            <div style="font-size:1.1rem;font-weight:600;letter-spacing:2px;">${bank.account_number}</div>
            <div style="color:#888;font-size:0.95rem;">${bank.account_holder}</div>
          </div>
          <button class="remove-bank-btn" onclick="handleRemoveBank('${bank.account_number},${bank.bank_name}')">Remove</button>
        </div>
      `;
    }

    // --- Fetch & render banks ---
    async function fetchAndRenderBanks() {
      try {
        const res = await fetch('profile_data.php?action=get_banks');
        const data = await res.json();
        const container = document.getElementById('bankListContainer');
        container.innerHTML = '';
        if (data.banks && data.banks.length > 0) {
          data.banks.forEach(bank => container.innerHTML += createBankCardHTML(bank));
        } else {
          container.innerHTML = '<p style="color:#888;">No bank accounts added yet.</p>';
        }
      } catch (err) {
        console.error(err);
      }
    }

    // --- Add bank ---
    async function handleBankConfirm() {
      const accountHolderName = document.getElementById('accountHolderName').value.trim();
      const accountNumber = document.getElementById('accountNumber').value.trim();
      const bankName = document.getElementById('bankName').value;
      if (!accountHolderName || !accountNumber || !bankName) {
        alert('Please fill in all fields.');
        return;
      }
      const response = await fetch('profile_data.php', {
        method: 'POST',
        headers: {'Content-Type': 'application/json'},
        body: JSON.stringify({
          action: 'add_bank',
          account_holder: accountHolderName,
          account_number: accountNumber,
          bank_name: bankName
        })
      });
      const result = await response.json();
      if (result.success) {
        alert('Bank added!');
        closeBankModal();
        fetchAndRenderBanks();
      } else {
        alert(result.message || 'Failed to add bank.');
      }
    }

    // --- Remove bank ---
    async function handleRemoveBank(accountNumber,bank_name) {
      if (!confirm("Are you sure you want to remove this bank account?")) return;
      const response = await fetch('profile_data.php', {
        method: 'POST',
        headers: {'Content-Type': 'application/json'},
        body: JSON.stringify({ action: 'remove_bank', account_number: accountNumber,bank_name:bank_name })
      });
      const result = await response.json();
      if (result.success) {
        alert('Bank removed!');
        fetchAndRenderBanks();
      } else {
        alert(result.message || 'Failed to remove bank.');
      }
    }

    // --- Profile edit toggle ---
    let editable = false;
    function toggleEdit() {
      const inputs = document.querySelectorAll("#fullName, #phone");
      const btn = document.getElementById("editProfileBtn");
      editable = !editable;
      inputs.forEach(input => input.disabled = !editable);
      if (editable) {
        btn.textContent = "Update Profile";
        btn.style.background = "linear-gradient(90deg, #22c55e, #16a34a)";
      } else {
        btn.textContent = "Edit Profile";
        btn.style.background = "linear-gradient(90deg, #facc15, #d97706)";
        const user_name = document.getElementById('fullName').value;
        const phone_number = document.getElementById('phone').value;
        fetch('profile_data.php', {
          method: 'POST',
          headers: {'Content-Type': 'application/json'},
          body: JSON.stringify({ action: 'update_profile', user_name, phone_number })
        }).then(r => r.json()).then(data => {
          alert(data.message || 'Profile updated.');
        });
      }
    }

    // --- Change password ---
    document.getElementById("change_password").addEventListener("click", async () => {
      const current = document.getElementById("currentPassword").value.trim();
      const newPass = document.getElementById("newPassword").value.trim();
      const confirmPass = document.getElementById("confirmPassword").value.trim();
      if (!current || !newPass || !confirmPass) {
        alert("Please fill in all password fields.");
        return;
      }
      if (newPass !== confirmPass) {
        alert("New password and confirm password do not match!");
        return;
      }
      const response = await fetch("profile_data.php", {
        method: "POST",
        headers: { "Content-Type": "application/json" },
        body: JSON.stringify({
          action: 'change_password',
          current_password: current,
          new_password: newPass
        })
      });
      const data = await response.json();
      alert(data.message);
      if (data.success) {
        document.getElementById("currentPassword").value = "";
        document.getElementById("newPassword").value = "";
        document.getElementById("confirmPassword").value = "";
      }
    });
  </script>
</body>
</html>
