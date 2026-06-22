<?php require_once 'php/auth_check.php'; ?>
<!DOCTYPE html>
<html lang="sw">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>EASTCSO | Dashboard ya Admin</title>
<link rel="stylesheet" href="css/style.css">
<style>
  .dash-header{
    background:var(--blue-deep);color:var(--white);padding:20px 0;
  }
  .dash-header .container{display:flex;align-items:center;justify-content:space-between;}
  .dash-header h2{font-size:18px;}
  .dash-header .who{font-size:13px;color:#cdd9ec;}
  .logout-btn{background:var(--gold);color:var(--blue-deep);padding:9px 18px;border-radius:6px;font-weight:600;font-size:13.5px;}
  .tabs{display:flex;gap:10px;margin:30px 0 24px;}
  .tab-btn{padding:10px 20px;border-radius:6px;border:1.5px solid #dbe3ef;background:var(--white);font-weight:600;font-size:13.5px;cursor:pointer;}
  .tab-btn.active{background:var(--blue-deep);color:var(--white);border-color:var(--blue-deep);}
  .tab-panel{display:none;}
  .tab-panel.active{display:block;}
  table{width:100%;border-collapse:collapse;background:var(--white);border-radius:var(--radius);overflow:hidden;box-shadow:var(--shadow);}
  th,td{padding:13px 16px;text-align:left;font-size:13.5px;border-bottom:1px solid #eef1f6;}
  th{background:#f1f5fb;color:var(--blue-deep);font-size:12.5px;text-transform:uppercase;letter-spacing:0.4px;}
  .row-actions button{font-size:12px;padding:6px 12px;border-radius:5px;border:none;cursor:pointer;margin-right:6px;}
  .edit-btn{background:#eaf2fd;color:var(--blue-bright);}
  .delete-btn{background:#fdeaea;color:#c0392b;}
  .add-card{margin-bottom:30px;}
</style>
</head>
<body>

<div class="dash-header">
  <div class="container">
    <div>
      <h2>EASTCSO — Dashboard ya Admin</h2>
      <div class="who">Umeingia kama: <?php echo htmlspecialchars($_SESSION['admin_name']); ?> (<?php echo htmlspecialchars($_SESSION['admin_role']); ?>)</div>
    </div>
    <a href="php/logout.php" class="logout-btn">Toka (Logout)</a>
  </div>
</div>

<div class="container" style="padding-top:10px;padding-bottom:60px;">

  <div class="tabs">
    <button class="tab-btn active" data-tab="announcements">Matangazo</button>
    <button class="tab-btn" data-tab="leaders">Viongozi</button>
  </div>

  <!-- ===================== ANNOUNCEMENTS TAB ===================== -->
  <div class="tab-panel active" id="tab-announcements">
    <div class="card add-card">
      <h3>Ongeza Tangazo Jipya</h3>
      <form id="ann-form" style="margin-top:14px;">
        <input type="hidden" name="id" id="ann-id">
        <div class="field">
          <label>Kichwa</label>
          <input type="text" name="title" id="ann-title" required>
        </div>
        <div class="field">
          <label>Maudhui</label>
          <textarea name="body" id="ann-body" rows="3" required></textarea>
        </div>
        <button type="submit" class="btn btn-primary" id="ann-submit-btn">Hifadhi Tangazo</button>
      </form>
    </div>

    <table>
      <thead><tr><th>Kichwa</th><th>Maudhui</th><th>Tarehe</th><th>Vitendo</th></tr></thead>
      <tbody id="ann-table-body"><tr><td colspan="4">Inapakia...</td></tr></tbody>
    </table>
  </div>

  <!-- ===================== LEADERS TAB ===================== -->
  <div class="tab-panel" id="tab-leaders">
    <div class="card add-card">
      <h3>Ongeza / Hariri Kiongozi</h3>
      <form id="leader-form" style="margin-top:14px;">
        <input type="hidden" name="id" id="leader-id">
        <div class="field"><label>Jina Kamili</label><input type="text" name="full_name" id="leader-name" required></div>
        <div class="field"><label>Nafasi</label><input type="text" name="position" id="leader-position" required></div>
        <div class="field"><label>Wizara (kama ipo)</label><input type="text" name="ministry" id="leader-ministry"></div>
        <div class="field"><label>Namba ya Simu</label><input type="text" name="phone" id="leader-phone"></div>
        <button type="submit" class="btn btn-primary" id="leader-submit-btn">Hifadhi Kiongozi</button>
      </form>
    </div>

    <table>
      <thead><tr><th>Jina</th><th>Nafasi</th><th>Wizara</th><th>Simu</th><th>Vitendo</th></tr></thead>
      <tbody id="leader-table-body"><tr><td colspan="5">Inapakia...</td></tr></tbody>
    </table>
  </div>

</div>

<script>
  /* ---- TAB SWITCHING ---- */
  document.querySelectorAll('.tab-btn').forEach(btn => {
    btn.addEventListener('click', () => {
      document.querySelectorAll('.tab-btn').forEach(b => b.classList.remove('active'));
      document.querySelectorAll('.tab-panel').forEach(p => p.classList.remove('active'));
      btn.classList.add('active');
      document.getElementById('tab-' + btn.dataset.tab).classList.add('active');
    });
  });

  /* ================= ANNOUNCEMENTS CRUD ================= */
  function loadAnnouncements() {
    fetch('php/announcements_crud.php?action=list')
      .then(r => r.json())
      .then(res => {
        const body = document.getElementById('ann-table-body');
        if (!res.success || !res.data.length) {
          body.innerHTML = '<tr><td colspan="4">Hakuna matangazo bado.</td></tr>';
          return;
        }
        body.innerHTML = res.data.map(a => `
          <tr>
            <td>${a.title}</td>
            <td>${a.body}</td>
            <td>${a.created_at}</td>
            <td class="row-actions">
              <button class="edit-btn" onclick='editAnn(${JSON.stringify(a)})'>Hariri</button>
              <button class="delete-btn" onclick="deleteAnn(${a.id})">Futa</button>
            </td>
          </tr>
        `).join('');
      });
  }

  function editAnn(a) {
    document.getElementById('ann-id').value = a.id;
    document.getElementById('ann-title').value = a.title;
    document.getElementById('ann-body').value = a.body;
    document.getElementById('ann-submit-btn').textContent = 'Sasisha Tangazo';
  }

  function deleteAnn(id) {
    if (!confirm('Una uhakika unataka kufuta tangazo hili?')) return;
    const fd = new FormData();
    fd.append('action', 'delete');
    fd.append('id', id);
    fetch('php/announcements_crud.php', { method: 'POST', body: fd })
      .then(r => r.json()).then(() => loadAnnouncements());
  }

  document.getElementById('ann-form').addEventListener('submit', function (e) {
    e.preventDefault();
    const id = document.getElementById('ann-id').value;
    const fd = new FormData(this);
    fd.append('action', id ? 'update' : 'create');
    fetch('php/announcements_crud.php', { method: 'POST', body: fd })
      .then(r => r.json())
      .then(() => {
        this.reset();
        document.getElementById('ann-id').value = '';
        document.getElementById('ann-submit-btn').textContent = 'Hifadhi Tangazo';
        loadAnnouncements();
      });
  });

  /* ================= LEADERS CRUD ================= */
  function loadLeaders() {
    fetch('php/leaders_crud.php?action=list')
      .then(r => r.json())
      .then(res => {
        const body = document.getElementById('leader-table-body');
        if (!res.success || !res.data.length) {
          body.innerHTML = '<tr><td colspan="5">Hakuna viongozi bado.</td></tr>';
          return;
        }
        body.innerHTML = res.data.map(l => `
          <tr>
            <td>${l.full_name}</td>
            <td>${l.position}</td>
            <td>${l.ministry || '-'}</td>
            <td>${l.phone || '-'}</td>
            <td class="row-actions">
              <button class="edit-btn" onclick='editLeader(${JSON.stringify(l)})'>Hariri</button>
              <button class="delete-btn" onclick="deleteLeader(${l.id})">Futa</button>
            </td>
          </tr>
        `).join('');
      });
  }

  function editLeader(l) {
    document.getElementById('leader-id').value = l.id;
    document.getElementById('leader-name').value = l.full_name;
    document.getElementById('leader-position').value = l.position;
    document.getElementById('leader-ministry').value = l.ministry || '';
    document.getElementById('leader-phone').value = l.phone || '';
    document.getElementById('leader-submit-btn').textContent = 'Sasisha Kiongozi';
  }

  function deleteLeader(id) {
    if (!confirm('Una uhakika unataka kumfuta kiongozi huyu?')) return;
    const fd = new FormData();
    fd.append('action', 'delete');
    fd.append('id', id);
    fetch('php/leaders_crud.php', { method: 'POST', body: fd })
      .then(r => r.json()).then(() => loadLeaders());
  }

  document.getElementById('leader-form').addEventListener('submit', function (e) {
    e.preventDefault();
    const id = document.getElementById('leader-id').value;
    const fd = new FormData(this);
    fd.append('action', id ? 'update' : 'create');
    fetch('php/leaders_crud.php', { method: 'POST', body: fd })
      .then(r => r.json())
      .then(() => {
        this.reset();
        document.getElementById('leader-id').value = '';
        document.getElementById('leader-submit-btn').textContent = 'Hifadhi Kiongozi';
        loadLeaders();
      });
  });

  loadAnnouncements();
  loadLeaders();
</script>
</body>
</html>
