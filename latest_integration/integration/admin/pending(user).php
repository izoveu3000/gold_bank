<style>
	
	.pending-main {
		padding: 12px 0;
	}
				.pending-title {
					font-size: 2.2rem;
					font-weight: 700;
					color: #1a4d2e;
					margin-bottom: 8px;
				}
				.pending-subtitle {
					color: #6c8e6b;
					font-size: 1.15rem;
					margin-bottom: 32px;
				}
				.pending-card {
					background: linear-gradient(135deg, #f8fcf7 95%, #e6f4ea 100%);
					border-radius: 16px;
					box-shadow: 0 2px 16px #e6f4ea;
					border: 1.5px solid #dbeedc;
					padding: 24px 24px 16px 24px;
					margin-bottom: 24px;
					position: relative;
				}
				.pending-badge {
					background: #ffe082;
					color: #a67c00;
					font-size: 0.95rem;
					font-weight: 600;
					border-radius: 8px;
					padding: 2px 12px;
					margin-left: 8px;
				}
				.pending-icon {
					background: #eaf6ee;
					border-radius: 50%;
					width: 40px;
					height: 40px;
					display: flex;
					align-items: center;
					justify-content: center;
					font-size: 1.5rem;
					color: #219a43;
					position: absolute;
					left: 24px;
					top: 24px;
				}
				.pending-actions {
					position: absolute;
					right: 24px;
					top: 24px;
					display: flex;
					gap: 12px;
				}
				.pending-edit {
					background: #fff;
					color: #219a43;
					border: 1px solid #e6f4ea;
					border-radius: 6px;
					padding: 6px 18px;
					font-size: 1rem;
					font-weight: 500;
					cursor: pointer;
					display: flex;
					align-items: center;
					gap: 6px;
				}
				.pending-cancel {
					background: #f44336;
					color: #fff;
					border: none;
					border-radius: 6px;
					padding: 6px 18px;
					font-size: 1rem;
					font-weight: 500;
					cursor: pointer;
					display: flex;
					align-items: center;
					gap: 6px;
				}
				.pending-note {
					background: #eaf6ee;
					color: #219a43;
					border-radius: 8px;
					padding: 12px 16px;
					margin-top: 16px;
					font-size: 1rem;
				}
				.pending-admin {
					background: #ffeaea;
					color: #f44336;
					border-radius: 8px;
					padding: 12px 16px;
					margin-top: 12px;
					font-size: 1rem;
				}
	#sidebar {
  transition: transform 0.3s ease; /* smooth slide */
}

#sidebar.closed {
  transform: translateX(-100%) !important;
}

#sidebar.open {
  transform: translateX(0) !important;
}

@media (min-width: 992px) {
	#sidebar {
		transform: translateX(0) !important;
		width: 240px;
	}
	#content {
		margin-left: 240px; /* only shifts on big screens */
	}
}
@media (max-width: 991px) {
	#sidebar {
		transform: translateX(-100%);
		position: fixed;
		left: 0;
		top: 0;
		height: 100%;
		z-index: 999;
	}
	#content {
		margin-left: 0;
	}
}

</style>
	<!-- Removed duplicate dashboard-flex and nav include -->
<script src="https://cdn.tailwindcss.com"></script>
<script src="https://unpkg.com/feather-icons"></script>
<script src="https://cdn.jsdelivr.net/npm/feather-icons/dist/feather.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<?php
include 'header.php';
?>
<div class="dashboard-flex">
	<!-- Responsive Toggle Sidebar Button -->
	<button id="toggleSidebar" class="p-2 bg-green-600 border border-green-700 rounded shadow-sm absolute top-4 left-4 z-50 d-lg-none" style="display:inline-flex;align-items:center;justify-content:center;">
		<i data-feather="menu" style="width:24px;height:24px;color:#fff;"></i>
	</button>
	<?php include 'nav.php'; ?>
	<div id="content" class="dashboard-main" >
		<script>
	document.addEventListener('DOMContentLoaded', function() {
		var sidebar = document.getElementById('sidebar');
		var toggleBtn = document.getElementById('toggleSidebar');
		var header = document.querySelector('nav.header-shiftable');
		var dashboardFlex = document.querySelector('.dashboard-flex');
		var content = document.getElementById('content');

		function openSidebar() {
			sidebar.classList.add("open");
			sidebar.classList.remove("closed");
			dashboardFlex.classList.remove("sidebar-closed");
			content.style.marginLeft = window.innerWidth >= 992 ? '240px' : '70px';
			content.style.width = '';
			if (header) header.classList.add("header-shifted");
		}

		function closeSidebar() {
			sidebar.classList.add("closed");
			sidebar.classList.remove("open");
			dashboardFlex.classList.add("sidebar-closed");
			content.style.marginLeft = '0';
			content.style.width = '100vw';
			if (header) header.classList.remove("header-shifted");
		}

		if (toggleBtn) {
			toggleBtn.onclick = function(e) {
				e.stopPropagation();
				if (sidebar.classList.contains("open")) {
					closeSidebar();
				} else {
					openSidebar();
				}
			};
		}

		function handleResize() {
			if (window.innerWidth < 992) {
				toggleBtn.style.display = 'inline-flex';
				closeSidebar();
			} else {
				toggleBtn.style.display = 'none';
				openSidebar();
			}
		}

		window.addEventListener('resize', handleResize);
		handleResize();

		feather.replace();
	});

		</script>
		<main class="container-fluid" style="background: #f8fcf9; min-height: 100vh; padding: 0;">
			<div class="pending-main">
				<div class="pending-title">Pending Transactions</div>
				<div class="pending-subtitle">Manage your pending transactions and view admin responses</div>
				<!-- Card 1 -->
				<div class="pending-card">
					<div class="pending-icon">&#x21ba;</div>
					<div style="margin-left:56px;">
						<div style="font-size:1.25rem;font-weight:600;color:#1a4d2e;display:inline-block;">Account Recharge</div>
						<span class="pending-badge">Pending Review</span>
						<div style="color:#6c8e6b;font-size:1rem;margin-top:2px;">TX006 &bull; 1/16/2024</div>
						<div style="font-size:1.15rem;color:#219a43;margin-top:8px;font-weight:600;">$3,000</div>
						<div style="color:#6c8e6b;font-size:0.98rem;">Transaction ID: TXN123456789</div>
						<div class="pending-note">Your Note:<br>Transferred $3000 to admin account</div>
						<div class="pending-admin"><span style="font-weight:600;">&#9888; Admin Response:</span><br>Please provide clearer image of the transaction receipt. The amount is not visible clearly.</div>
					</div>
					<div class="pending-actions">
						<button class="pending-edit"><i data-feather="edit"></i> Edit</button>
						<button class="pending-cancel"><i data-feather="x"></i> Cancel</button>
					</div>
				</div>

				
				<!-- Card 2 -->
				<div class="pending-card">
					<div class="pending-icon">&#8599;</div>
					<div style="margin-left:56px;">
						<div style="font-size:1.25rem;font-weight:600;color:#1a4d2e;display:inline-block;">Withdrawal Request</div>
						<span class="pending-badge">Pending Review</span>
						<div style="color:#6c8e6b;font-size:1rem;margin-top:2px;">TX007 &bull; 1/15/2024</div>
						<div style="font-size:1.15rem;color:#219a43;margin-top:8px;font-weight:600;">$1,500</div>
						<div style="color:#6c8e6b;font-size:0.98rem;">Bank: ABC Bank - John Doe - ****1234</div>
						<div class="pending-note">Your Note:<br>Need urgent withdrawal for medical expenses</div>
					</div>
					<div class="pending-actions">
						<button class="pending-edit"><i data-feather="edit"></i> Edit</button>
						<button class="pending-cancel"><i data-feather="x"></i> Cancel</button>
					</div>
				</div>
				<!-- Card 3: Gold Purchase - 1.2 oz -->
				<div class="pending-card" style="background: #f8fcf7; border: 1.5px solid #dbeedc; box-shadow: 0 4px 24px 0 rgba(0,0,0,0.12), 0 0 0 4px rgba(230,244,234,0.5); backdrop-filter: blur(2px);">
					<div class="pending-icon" style="background:#fff7e6;color:#a67c00;"><i data-feather="dollar-sign"></i></div>
					<div style="margin-left:56px;">
						<div style="font-size:1.5rem;font-weight:700;color:#1a4d2e;display:inline-block;">Gold Purchase - 1.2 oz</div>
						<span class="pending-badge" style="background:#ffe8b3;color:#a67c00;font-size:1rem;font-weight:600;border-radius:16px;padding:4px 18px;margin-left:10px;vertical-align:middle;">Pending Review</span>
						<div style="color:#6c8e6b;font-size:1.1rem;margin-top:2px;">TX008 &bull; 1/14/2024</div>
						<div style="font-size:1.25rem;color:#ffb300;margin-top:8px;font-weight:700;display:inline-block;">$3,168</div>
						<span style="color:#6c8e6b;font-size:1.1rem;margin-left:8px;">@ $2640.00/oz</span>
						<div style="background:#eaf6ee;color:#1a4d2e;border-radius:16px;padding:18px 24px;margin-top:18px;font-size:1.1rem;width:fit-content;max-width:100%;">
							<span style="font-weight:700;">Your Note:</span><br>
							<span style="color:#219a43;font-weight:500;">Buying 1.2 oz gold at current rate</span>
						</div>
						<div style="background:#ffeaea;color:#f44336;border-radius:16px;padding:18px 24px;margin-top:18px;font-size:1.1rem;width:fit-content;max-width:100%;border:1.5px solid #f44336;">
							<span style="font-weight:700;"><i data-feather="alert-circle" style="margin-right:6px;"></i> Admin Response:</span><br>
							Transaction amount doesn't match gold price. Please verify the calculation.
						</div>
					</div>
					<div class="pending-actions">
						<button class="pending-edit"><i data-feather="edit"></i> Edit</button>
						<button class="pending-cancel"><i data-feather="x"></i> Cancel</button>
					</div>
				</div>
				
			</div>
			<script>feather.replace();</script>
		</main>
	</div>
</div>

<?php include 'footer.php'; ?>
