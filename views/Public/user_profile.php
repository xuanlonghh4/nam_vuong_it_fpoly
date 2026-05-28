<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Trung Tâm Điều Khiển - <?= htmlspecialchars($_SESSION['username']) ?></title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-[#0d0e15] text-white font-sans min-h-screen flex flex-col">

    <header class="h-20 bg-[#0d0e15]/90 backdrop-blur-md border-b border-[#00f0ff]/20 shadow-[0_4px_20px_rgba(0,240,255,0.1)]">
        <div class="max-w-4xl mx-auto px-6 h-full flex items-center justify-between">
            <a href="index.php?url=main" class="flex items-center gap-3">
                <span class="text-2xl">👑</span>
                <span class="text-xl font-black uppercase tracking-wider text-[#00f0ff]">NAM VƯƠNG IT FPOLY</span>
            </a>
            <a href="index.php?url=main" class="text-xs font-bold text-gray-400 hover:text-[#ff007f] transition-colors">← Quay Lại Trang Chủ</a>
        </div>
    </header>

    <main class="flex-grow max-w-4xl w-full mx-auto px-6 py-10">

        <div class="bg-[#141622]/80 border border-gray-800 rounded-2xl p-6 mb-8 flex flex-col sm:flex-row justify-between items-center gap-6 shadow-xl">
            <div class="flex items-center gap-4">
                <div class="w-14 h-14 bg-[#00f0ff]/10 border border-[#00f0ff]/50 rounded-full flex items-center justify-center text-2xl font-black text-[#00f0ff]">
                    <?= strtoupper(substr($_SESSION['username'], 0, 1)) ?>
                </div>
                <div>
                    <h2 class="text-lg font-black tracking-wide text-white uppercase"><?= htmlspecialchars($_SESSION['username']) ?></h2>
                    <p class="text-xs text-gray-500 uppercase tracking-widest mt-0.5">Thành viên hệ thống • ID: #<?= $_SESSION['user_id'] ?></p>
                </div>
            </div>
            
            <div class="bg-[#0d0e15] border border-[#ff007f]/30 px-6 py-3 rounded-xl text-center min-w-[160px] shadow-[0_0_15px_rgba(255,0,127,0.05)]">
                <p class="text-[10px] text-gray-400 font-bold uppercase tracking-widest mb-1">Số dư tài khoản</p>
                <p class="text-2xl font-black text-[#ff007f]">🐚 <?= number_format($so_du_so) ?> <span class="text-xs font-bold text-gray-400">Sò</span></p>
            </div>
        </div>
        <?php if($_SESSION['username'] === 'admin'): ?>
            <a href="?url=admin" class="group flex items-center gap-4 p-3 rounded-xl bg-transparent border border-[#00f0ff] hover:bg-[#00f0ff]/10 hover:border-[#00f0ff]/50 transition-all duration-300 mt-4">
                <span class="text-[#00f0ff]">⚙️</span> Truy cập trang Ánh Minh (Admin Dashboard)
            </a>
       <?php endif; ?>
        <a href="?url=logout" class="group flex items-center gap-4 p-3 rounded-xl bg-transparent border border-red-400 hover:bg-red-400/10 hover:border-red-300 transition-all duration-300 mt-4">
            <span class="text-red-400">🚪</span> Đăng Xuất
        </a>
        <br>

        <div class="bg-[#141622]/60 border border-gray-800 rounded-2xl p-6 shadow-xl">
            <h3 class="text-sm font-black text-[#00f0ff] uppercase tracking-wider mb-4 flex items-center gap-2">
                <span>📊</span> Lịch Sử Cống Hiến (Vote History)
            </h3>

            <div class="overflow-x-auto">
                <table class="w-full text-left text-sm text-gray-400">
                    <thead class="text-xs text-gray-500 uppercase tracking-wider border-b border-gray-800 bg-[#0d0e15]/50">
                        <tr>
                            <th class="py-3 px-4">Mã Giao Dịch</th>
                            <th class="py-3 px-4">Thí Sinh Được Vote</th>
                            <th class="py-3 px-4 text-center">Số Lượt Vote</th>
                            <th class="py-3 px-4 text-right">Thời Gian</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-800/60">
                        <?php if (empty($lichSuVote)): ?>
                            <tr>
                                <td colspan="4" class="py-8 text-center text-xs text-gray-600 italic uppercase tracking-widest">Bạn chưa thực hiện lượt ném Sò nào!</td>
                            </tr>
                        <?php else: ?>
                            <?php foreach ($lichSuVote as $history): ?>
                                <tr class="hover:bg-[#1a1c28]/40 transition-colors">
                                    <td class="py-3.5 px-4 font-mono text-xs text-gray-500">#VOTE-<?= $history->id ?></td>
                                    <td class="py-3.5 px-4 font-bold text-white uppercase tracking-wide">
                                        👑 <?= htmlspecialchars($history->candidate_name) ?>
                                    </td>
                                    <td class="py-3.5 px-4 text-center font-black text-[#00f0ff]">
                                        +<?= number_format($history->so_luong_vote) ?>
                                    </td>
                                    <td class="py-3.5 px-4 text-right text-xs text-gray-500">
                                        <?= date('d/m/Y H:i', strtotime($history->created_at)) ?>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>

        <br>


    </main>

    <footer class="bg-[#090a0f] border-t border-gray-900 py-6 text-center text-[10px] text-gray-600 uppercase tracking-widest">
        Hệ thống dữ liệu bảo mật • Fpoly Thanh Hóa 2026
    </footer>

</body>
</html>