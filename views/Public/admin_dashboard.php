<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hệ Thống Quản Trị Tối Cao - Admin Panel</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        /* Lưới cyber phát quang chìm giúp không gian sáng sủa và có chiều sâu */
        .cyber-grid {
            background-image: linear-gradient(to right, rgba(0, 240, 255, 0.04) 1px, transparent 1px),
                              linear-gradient(to bottom, rgba(0, 240, 255, 0.04) 1px, transparent 1px);
            background-size: 30px 30px;
        }
        /* Hiệu ứng mờ dần khi xóa hàng dữ liệu bằng AJAX */
        .fade-out {
            opacity: 0;
            transform: translateX(-20px);
            transition: all 0.5s ease-out;
        }
    </style>
</head>
<body class="bg-gradient-to-br from-[#0a0c16] via-[#101426] to-[#15122c] text-white font-sans min-h-screen cyber-grid relative">

    <div class="h-16 bg-[#11142a]/90 backdrop-blur-md border-b border-[#ff007f]/40 px-6 flex items-center justify-between shadow-[0_4px_25px_rgba(255,0,127,0.15)] sticky top-0 z-50">
        <div class="flex items-center gap-3">
            <span class="text-xl animate-pulse">⚙️</span>
            <span class="text-sm font-black uppercase tracking-widest bg-gradient-to-r from-[#ff007f] to-[#00f0ff] bg-clip-text text-transparent drop-shadow-[0_0_8px_rgba(0,240,255,0.4)]">Ánh Minh CONTROL PANEL</span>
        </div>
        <a href="index.php?url=main" class="text-xs font-black uppercase tracking-wider text-[#00f0ff] border border-[#00f0ff]/30 px-3 py-1.5 rounded-lg hover:bg-[#00f0ff]/10 transition-all">← Quay Lại Trang Chủ</a>
    </div>

    <div class="max-w-6xl mx-auto px-6 py-8 relative z-10">
        
        <div class="grid grid-cols-1 sm:grid-cols-3 gap-6 mb-8">
            <div class="bg-[#181d3a] border border-gray-700/60 p-5 rounded-xl shadow-[0_4px_20px_rgba(0,0,0,0.3)]">
                <p class="text-[10px] uppercase text-gray-400 font-bold tracking-wider">Tổng thành viên</p>
                <p class="text-3xl font-black text-white mt-1" id="total-users-display"><?= count($allUsers) ?> <span class="text-xs font-normal text-gray-400 uppercase">Người</span></p>
            </div>
            <div class="bg-[#181d3a] border border-[#00f0ff]/30 p-5 rounded-xl shadow-[0_4px_20px_rgba(0,240,255,0.05)]">
                <p class="text-[10px] uppercase text-[#00f0ff] font-bold tracking-wider">Tổng Sò lưu hành</p>
                <p class="text-3xl font-black text-[#00f0ff] drop-shadow-[0_0_10px_rgba(0,240,255,0.3)] mt-1">🐚 <?= number_format($totalSo) ?></p>
            </div>
            <div class="bg-[#181d3a] border border-[#ff007f]/30 p-5 rounded-xl shadow-[0_4px_20px_rgba(255,0,127,0.05)]">
                <p class="text-[10px] uppercase text-[#ff007f] font-bold tracking-wider">Tổng lượt Vote cống hiến</p>
                <p class="text-3xl font-black text-[#ff007f] drop-shadow-[0_0_10px_rgba(255,0,127,0.3)] mt-1">⚡ <?= number_format($totalVotes) ?></p>
            </div>

            <div class="bg-[#181d3a] border border-[#00f0ff]/20 p-5 rounded-xl shadow-lg">
                <p class="text-[10px] uppercase text-gray-400 font-bold tracking-wider">Tổng số lượt click (Views)</p>
                <p class="text-3xl font-black text-white mt-1">👀 <?= number_format($counterStats->views) ?></p>
            </div>

            <div class="bg-[#181d3a] border border-[#ff007f]/20 p-5 rounded-xl shadow-lg">
                <p class="text-[10px] uppercase text-gray-400 font-bold tracking-wider">Lượt truy cập thực tế (Visits)</p>
                <p class="text-3xl font-black text-[#00f0ff] mt-1">🚀 <?= number_format($counterStats->visits) ?></p>
            </div>
        </div>

        <div class="flex border-b border-gray-700 gap-2 mb-6 bg-[#131732] p-1 rounded-t-xl">
            <button id="btn-tab-users" onclick="switchTab('tab-users')" class="tab-btn px-5 py-3 text-xs font-black uppercase tracking-wider border-b-2 border-[#ff007f] text-[#ff007f] bg-[#ff007f]/5 transition-all">
                👥 Bảng Users
            </button>
            <button id="btn-tab-candidates" onclick="switchTab('tab-candidates')" class="tab-btn px-5 py-3 text-xs font-black uppercase tracking-wider text-gray-400 hover:text-white transition-all">
                👑 Bảng Nam Vương
            </button>
            <button id="btn-tab-history" onclick="switchTab('tab-history')" class="tab-btn px-5 py-3 text-xs font-black uppercase tracking-wider text-gray-400 hover:text-white transition-all">
                📊 Nhật Ký Vote
            </button>
        </div>

        <div>
            <div id="tab-users" class="tab-content table-container bg-[#181d3a]/90 border border-gray-700 rounded-xl p-5 shadow-2xl">
                <h3 class="text-xs font-black text-[#00f0ff] uppercase tracking-widest mb-4 flex items-center gap-2">
                    <span class="w-1.5 h-3 bg-[#00f0ff] inline-block"></span> Danh sách tài khoản người dùng
                </h3>
                <div class="overflow-x-auto rounded-lg border border-gray-700 bg-[#0f1224]">
                    <table class="w-full text-left text-xs text-gray-300">
                        <thead class="bg-[#1b203e] text-gray-400 uppercase font-black border-b border-gray-700">
                            <tr>
                                <th class="p-3.5">ID</th>
                                <th class="p-3.5">Tài Khoản</th>
                                <th class="p-3.5 w-72">Số Dư Sò (Chỉnh sửa trực tiếp)</th>
                                <th class="p-3.5 text-center">Hành Động</th>
                                <th class="p-3.5 text-right">Ngày Tham Gia</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-700/40">
                            <?php foreach ($allUsers as $u): ?>
                                <tr id="user-row-<?= $u->id ?>" class="hover:bg-[#20264b]/50 transition-colors">
                                    <td class="p-3.5 font-mono text-gray-400 font-bold">#<?= $u->id ?></td>
                                    <td class="p-3.5 font-black text-white tracking-wide"><?= htmlspecialchars($u->username) ?></td>
                                    
                                    <td class="p-3.5">
                                        <div class="flex items-center gap-2">
                                            <span class="text-[#00f0ff] font-black text-sm min-w-[70px]" id="so-display-<?= $u->id ?>">🐚 <?= number_format($u->so_du_so) ?></span>
                                            <input type="number" id="input-so-<?= $u->id ?>" value="<?= $u->so_du_so ?>" 
                                                   class="w-20 bg-black/60 border border-gray-700 text-[#00f0ff] px-2 py-1 rounded focus:outline-none focus:border-[#00f0ff] text-xs font-bold">
                                            <button onclick="updateSoDuAjax(<?= $u->id ?>)" class="bg-[#00f0ff]/10 border border-[#00f0ff]/40 text-[#00f0ff] px-2 py-1 rounded text-[10px] font-black uppercase hover:bg-[#00f0ff] hover:text-black transition-all">Lưu</button>
                                        </div>
                                    </td>

                                    <td class="p-3.5 text-center">
                                        <button onclick="deleteUserAjax(<?= $u->id ?>, '<?= htmlspecialchars($u->username) ?>')" 
                                                class="bg-red-900/20 border border-red-500/40 text-red-400 px-3 py-1 rounded text-[10px] font-black uppercase hover:bg-red-600 hover:text-white transition-all">
                                            Trục xuất ❌
                                        </button>
                                    </td>

                                    <td class="p-3.5 text-right text-gray-400"><?= date('d/m/Y H:i', strtotime($u->created_at)) ?></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>

            <div id="tab-candidates" class="tab-content table-container bg-[#181d3a]/90 border border-gray-700 rounded-xl p-5 shadow-2xl hidden">
                <h3 class="text-xs font-black text-[#ff007f] uppercase tracking-widest mb-4 flex items-center gap-2">
                    <!-- <span class="w-1.5 h-3 bg-[#ff007f] inline-block"></span> Danh sách thí sinh Nam Vương -->
                    <form method="GET" class="mb-4 flex items-center gap-3" action="?url=admin#tab-candidates">
                        <input type="hidden" name="url" value="admin">
                        <div class="flex items-center gap-3">
                            <input type="text" name="admin-search" autofocus placeholder="Tìm kiếm theo tên..." value="<?= htmlspecialchars($adminSearch ?? '') ?>"
                                    class="flex-grow bg-[#1a1c28] border border-gray-800 rounded-lg px-4 py-2 text-sm text-white focus:outline-none focus:border-[#ff007f] transition-all">
                                    <!-- <input type="hidden" name="tab" value="candidates"> -->
                            <button type="submit" 
                                    class="bg-[#ff007f] text-white font-bold py-2 px-4 rounded-lg hover:bg-white hover:text-black transition-colors">
                                Tìm Kiếm
                            </button>
                            <a href="?url=admin#tab-candidates" 
                                class="text-sm text-gray-400 hover:text-[#ff007f] transition-colors">
                                Xóa bộ lọc
                            </a>
                        </div>
                    </form>
                </h3>
                
                <div class="overflow-x-auto rounded-lg border border-gray-700 bg-[#0f1224]">
                    <table class="w-full text-left text-xs text-gray-300">
                        <thead class="bg-[#1b203e] text-gray-400 uppercase font-black border-b border-gray-700">
                            <tr>
                                <th class="p-3.5">ID</th>
                                <th class="p-3.5 w-20">Ảnh</th>
                                <th class="p-3.5">Họ Tên</th>
                                <th class="p-3.5 text-right">Tổng Lượt Vote</th>
                                <th class="p-3.5 text-right">Ngày Đăng Kí</th>
                                <th class="p-3.5 text-center">Trạng Thái</th>
                                <th class="p-3.5 text-center">Hành Động</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-700/40">
                            <?php if (count($allCandidates) === 0): ?>
                                <tr>
                                    <td colspan="8" class="p-5 text-center text-gray-500 italic">Chưa có thí sinh nào được đăng ký...</td>
                                </tr>
                            <?php else: ?>
                            <?php foreach ($allCandidates as $c): ?>
                                <tr class="hover:bg-[#20264b]/50 transition-colors">
                                    <td class="p-3.5 font-mono text-gray-400 font-bold">#<?= $c->id ?></td>
                                    <td class="p-3.5">
                                        <img src="Upload/<?= htmlspecialchars($c->thumbnail) ?>" class="w-9 h-9 object-cover rounded-lg border border-gray-600 shadow-md" onerror="this.src='Upload/default-avatar.jpg';">
                                    </td>
                                    <td class="p-3.5 font-black text-white uppercase tracking-wide"><?= htmlspecialchars($c->name) ?></td>
                                    <td class="p-3.5 text-right text-[#ff007f] font-black text-sm">⚡ <?= number_format($c->votes) ?></td>
                                    <td class="p-3.5 text-right text-gray-400"><?= date('d/m/Y H:i', strtotime($c->created_at)) ?></td>
                                    <td class="p-3.5 text-center"><?= $c->status ?? 'Chưa xác định' ?></td>
                                    <td class="p-3.5 text-center flex items-center justify-center gap-2">
                                        <!-- <a href="candidate/<?= $c->id ?>" class="bg-[#ff007f] hover:bg-[#ff007f]/80 text-white py-1 px-3 rounded-lg text-xs font-bold transition-colors">
                                            Chi Tiết
                                        </a> -->
                                        <a href="?url=process-edit-nam-vuong&id=<?= $c->id ?>" class="bg-[#00f0ff] hover:bg-[#00f0ff]/80 text-black py-1 px-3 rounded-lg text-xs font-bold transition-colors">
                                            Xem/Sửa
                                        </a>
                                        <a href="?url=delete-nam-vuong&id=<?= $c->id ?>" class="bg-red-900/20 border border-red-500/40 text-red-400 px-3 py-1 rounded text-[10px] font-black uppercase hover:bg-red-600 hover:text-white transition-all" onclick="return confirm('Đồng chí có chắc muốn xóa thí sinh này?');">
                                            Xóa
                                        </a>
                                    </td>       
                                </tr>
                            <?php endforeach; ?>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>

            <div id="tab-history" class="tab-content table-container bg-[#181d3a]/90 border border-gray-700 rounded-xl p-5 shadow-2xl hidden">
                <h3 class="text-xs font-black text-[#00f0ff] uppercase tracking-widest mb-4 flex items-center gap-2">
                    <span class="w-1.5 h-3 bg-[#00f0ff] inline-block"></span> Toàn bộ lịch sử giao dịch vote_history
                </h3>
                <div class="overflow-x-auto rounded-lg border border-gray-700 bg-[#0f1224]">
                    <table class="w-full text-left text-xs text-gray-400">
                        <thead class="bg-[#1b203e] text-gray-400 uppercase font-black border-b border-gray-700">
                            <tr>
                                <th class="p-3.5">Mã GD</th>
                                <th class="p-3.5">Người Tặng</th>
                                <th class="p-3.5">Thí Sinh Nhận</th>
                                <th class="p-3.5 text-center">Số Lượt</th>
                                <th class="p-3.5 text-right">Thời Gian</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-700/40">
                            <?php foreach ($allHistory as $h): ?>
                                <tr class="hover:bg-[#20264b]/50 transition-colors">
                                    <td class="p-3.5 font-mono text-gray-500 font-bold">#VOTE-<?= $h->id ?></td>
                                    <td class="p-3.5 text-gray-200 font-black"><?= htmlspecialchars($h->username) ?></td>
                                    <td class="p-3.5 text-white uppercase font-bold">👑 <?= htmlspecialchars($h->candidate_name) ?></td>
                                    <td class="p-3.5 text-center text-[#00f0ff] font-black text-sm">+<?= number_format($h->so_luong_vote) ?></td>
                                    <td class="p-3.5 text-right text-gray-400"><?= date('d/m/Y H:i:s', strtotime($h->created_at)) ?></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div> 
    </div>

    <footer class="bg-[#050711] border-t border-gray-800/60 py-6 mt-12 text-center text-[10px] text-gray-500 uppercase tracking-widest relative z-10">
        Hệ thống lõi tối cao • Fpoly IT Championship 2026 • Encryption Secure (AJAX Integrated)
    </footer>

    <script>
        // Hàm chuyển Tab nguyên bản của đồng chí
        // 1. Hàm chuyển Tab và lưu trạng thái vào LocalStorage
        function switchTab(tabId) {
            // Ẩn tất cả nội dung
            document.querySelectorAll('.tab-content').forEach(el => el.classList.add('hidden'));
            
            // Hiện tab được chọn
            document.getElementById(tabId).classList.remove('hidden');
            
            // Reset tất cả các nút
            document.querySelectorAll('.tab-btn').forEach(btn => {
                btn.classList.remove('border-b-2', 'border-[#ff007f]', 'text-[#ff007f]', 'bg-[#ff007f]/5');
                btn.classList.add('text-gray-400');
            });
            
            // Focus vào nút đang chọn
            let activeBtn = document.getElementById('btn-' + tabId);
            if (activeBtn) {
                activeBtn.classList.add('border-b-2', 'border-[#ff007f]', 'text-[#ff007f]', 'bg-[#ff007f]/5');
                activeBtn.classList.remove('text-gray-400');
            }

            // LƯU VÀO BỘ NHỚ TRÌNH DUYỆT
            localStorage.setItem('activeAdminTab', tabId);
        }

        // 2. TỰ ĐỘNG KHÔI PHỤC TAB KHI TẢI LẠI TRANG
        window.addEventListener('DOMContentLoaded', () => {
            const savedTab = localStorage.getItem('activeAdminTab');
            if (savedTab && document.getElementById(savedTab)) {
                switchTab(savedTab);
            }
        });
        // =========================================================
        // LỒNG AJAX 1: TRỤC XUẤT TÀI KHOẢN NGẦM KHÔNG RELOAD TRANG
        // =========================================================
        function deleteUserAjax(userId, username) {
            if (!confirm(`Đồng chí có chắc muốn TRỤC XUẤT tài khoản [${username}] ra khỏi hệ thống?`)) {
                return;
            }

            let formData = new FormData();
            formData.append('id', userId);

            // Bắn request ngầm lên router xử lý ajax của đồng chí
            fetch('index.php?url=admin-ajax&action=delete_user', {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.status === 'success') {
                    let row = document.getElementById(`user-row-${userId}`);
                    row.classList.add('fade-out'); // Kích hoạt hiệu ứng bay màu mượt mà
                    
                    setTimeout(() => {
                        row.remove(); // Xóa thẻ khỏi cây DOM
                    }, 500);

                    alert(data.message);
                } else {
                    alert('Lỗi: ' + data.message);
                }
            })
            .catch(err => {
                console.error('Lỗi luồng AJAX:', err);
                alert('Mất kết nối lõi, không thể xóa!');
            });
        }

        // =========================================================
        // LỒNG AJAX 2: CẬP NHẬT/BƠM SÒ TRỰC TIẾP TẠI DÒNG
        // =========================================================
        function updateSoDuAjax(userId) {
            let inputField = document.getElementById(`input-so-${userId}`);
            let newSoValue = inputField.value;

            let formData = new FormData();
            formData.append('id', userId);
            formData.append('so_du_so', newSoValue);

            fetch('index.php?url=admin-ajax&action=update_so', {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.status === 'success') {
                    // Thay đổi số dư hiển thị theo định dạng chuỗi có dấu phẩy của PHP trả về
                    document.getElementById(`so-display-${userId}`).innerText = '🐚 ' + data.formatted_so;
                    
                    // Hiệu ứng lóe sáng xanh Neon báo hiệu dữ liệu đã đồng bộ thành công vào DB
                    inputField.classList.add('border-[#00f0ff]', 'bg-[#00f0ff]/10');
                    setTimeout(() => {
                        inputField.classList.remove('border-[#00f0ff]', 'bg-[#00f0ff]/10');
                    }, 600);
                } else {
                    alert('Lỗi: ' + data.message);
                }
            })
            .catch(err => {
                console.error('Lỗi luồng AJAX:', err);
                alert('Mất kết nối lõi, không thể lưu số Sò!');
            });
        }
    </script>
</body>
</html>