<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hồ Sơ Nam Vương - <?= htmlspecialchars($item->name) ?></title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-[#0d0e15] text-white font-sans min-h-screen flex flex-col">

    <header class="h-20 bg-[#0d0e15]/90 backdrop-blur-md border-b border-[#ff007f]/30 shadow-[0_4px_20px_rgba(255,0,127,0.15)]">
        <div class="max-w-5xl mx-auto px-6 h-full flex items-center justify-between">
            <a href="?url=main" class="flex items-center gap-3">
                <span class="text-2xl">👑</span>
                <span class="text-xl font-black uppercase tracking-wider text-[#00f0ff]">NAM VƯƠNG IT FPOLY</span>
            </a>
            
            <div class="flex items-center gap-4">
                <?php if (isset($_SESSION['user_id'])): ?>
                    <span class="text-xs bg-[#141622] border border-gray-800 px-3 py-1.5 rounded-full flex items-center gap-1.5">
                        🐚 <span class="text-[#00f0ff] font-black"><?= number_format($so_du_so) ?></span> Sò
                    </span>
                    <span class="text-xs text-gray-400">👋 <?= htmlspecialchars($_SESSION['username']) ?></span>
                <?php else: ?>
                    <a href="?url=login" class="text-xs font-black tracking-widest uppercase bg-transparent border border-[#ff007f] text-[#ff007f] px-3 py-1.5 rounded-lg hover:bg-[#ff007f]/10 transition-all">Đăng Nhập</a>
                <?php endif; ?>
            </div>
        </div>
    </header>

    <main class="flex-grow max-w-5xl w-full mx-auto px-6 py-8">
        
        <div class="mb-6">
            <a href="?url=main&#danh-sach" class="inline-flex items-center gap-2 text-sm font-bold text-gray-400 hover:text-[#00f0ff] transition-colors group">
                <span class="text-lg group-hover:-translate-x-1 transition-transform">←</span> Quay Lại Danh Sách
            </a>
        </div>

        <div class="bg-[#141622]/60 border border-gray-800 rounded-2xl p-6 md:p-8 shadow-2xl flex flex-col md:flex-row gap-8 items-start">
            
            <div class="w-full md:w-2/5 shrink-0">
                <div class="relative w-full aspect-square bg-[#252839] border-2 border-[#ff007f] rounded-xl overflow-hidden shadow-[0_0_15px_rgba(255,0,127,0.3)]">
                    <img src="Upload/<?= htmlspecialchars($item->thumbnail) ?>" 
                         alt="<?= htmlspecialchars($item->name) ?>" 
                         class="w-full h-full object-cover"
                         onerror="this.src='Upload/default-avatar.jpg';">
                    
                    <span class="absolute bottom-4 right-4 bg-[#0d0e15]/90 border border-[#00f0ff] text-[#00f0ff] font-bold px-4 py-1.5 rounded-full shadow-[0_0_10px_rgba(0,240,255,0.5)] text-sm">
                        ⚡ <?= number_format($item->votes) ?> Lượt Vote
                    </span>
                </div>
            </div>

            <div class="w-full md:w-3/5 flex flex-col justify-between self-stretch">
                <div>
                    <div class="border-b border-gray-800 pb-3 mb-4">
                        <h1 class="text-2xl md:text-4xl font-black text-white tracking-wide uppercase">
                            <?= htmlspecialchars($item->name) ?>
                        </h1>
                    </div>

                    <div class="mb-8">
                        <h3 class="text-xs font-bold text-[#ff007f] uppercase tracking-widest mb-2">✦ Tóm tắt lý lịch</h3>
                        <p class="text-gray-300 leading-relaxed whitespace-pre-line text-sm md:text-base bg-[#0d0e15]/40 p-4 rounded-xl border border-gray-800/40">
                            <?= htmlspecialchars($item->description ?? 'Chưa có tiểu sử...') ?>
                        </p>
                    </div>
                </div>

                <div class="bg-[#1a1c28] border border-[#00f0ff]/20 rounded-xl p-5 shadow-lg">
                    <h3 class="text-sm font-bold text-[#00f0ff] uppercase tracking-wider mb-3 flex items-center gap-2">
                        <span>⚡</span> Bơm Vote Tiếp Sức Nam Vương
                    </h3>
                    
                    <?php if (isset($_SESSION['user_id'])): ?>
                        <form action="?url=process-vote" method="POST" class="flex flex-col sm:flex-row gap-3">
                            <input type="hidden" name="candidate_id" value="<?= $item->id ?>">
                            
                            <div class="relative flex-grow">
                                <input type="number" 
                                       name="so_luong_vote" 
                                       min="1" 
                                       max="<?= $so_du_so ?>"
                                       value="1" 
                                       required
                                       class="w-full bg-[#0d0e15] border border-gray-700 rounded-lg px-4 py-3 text-sm text-white placeholder-gray-500 focus:outline-none focus:border-[#00f0ff] focus:ring-1 focus:ring-[#00f0ff] transition-all">
                                <span class="absolute right-4 top-1/2 -translate-y-1/2 text-xs text-gray-500 font-bold uppercase">Sò 🐚</span>
                            </div>
                            
                            <button type="submit" 
                                    class="bg-[#ff007f] text-white font-bold text-sm px-6 py-3 rounded-lg hover:bg-white hover:text-black hover:shadow-[0_0_15px_rgba(255,0,127,0.6)] transition-all shrink-0 uppercase tracking-widest">
                                Xác Nhận Vote
                            </button>
                        </form>
                        <p class="text-[10px] text-gray-500 mt-2 italic">
                            * Hệ thống áp dụng tỷ giá cố định: 1 Sò quy đổi tương ứng với 1 Lượt bình chọn.
                        </p>
                    <?php else: ?>
                        <div class="flex flex-col sm:flex-row items-center justify-between gap-4 py-1">
                            <p class="text-xs text-gray-400">Bạn cần đăng nhập để sử dụng ví Sò bình chọn cho thí sinh này.</p>
                            <a href="?url=login" 
                               class="bg-transparent border border-[#00f0ff] text-[#00f0ff] text-center font-bold text-xs px-5 py-2.5 rounded-lg hover:bg-[#00f0ff]/10 transition-all uppercase tracking-wider whitespace-nowrap shrink-0">
                                Đăng Nhập Ngay ⚡
                            </a>
                        </div>
                    <?php endif; ?>
                </div>

            </div>
        </div>
    </main>

    <footer class="bg-[#090a0f] border-t border-gray-900 py-6">
        <div class="max-w-5xl mx-auto px-6 text-center text-xs text-gray-600 uppercase tracking-widest">
            Fpoly IT Championship 2026 • Built with Pure PHP
        </div>
    </footer>

</body>
</html>