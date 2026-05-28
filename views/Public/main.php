<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nam Vương IT Fpoly</title>
    <script src="https://cdn.tailwindcss.com"></script>
    
</head>
<body class="bg-[#0d0e15] text-white font-sans flex flex-col min-h-screen">

    <header class="fixed top-0 left-0 right-0 z-50 h-20 bg-[#0d0e15]/90 backdrop-blur-md border-b border-[#ff007f]/30 shadow-[0_4px_20px_rgba(255,0,127,0.15)]">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 h-full flex items-center justify-between">
            
            <a href="?url=main" class="flex items-center gap-2 group">
                <span class="text-xl animate-bounce">👑</span>
                <span class="text-sm md:text-xl font-black uppercase tracking-wider text-[#00f0ff] truncate">
                    NAM VƯƠNG IT
                </span>
            </a>
            
            <div class="flex items-center gap-6">
                <nav id="main-nav" class="hidden md:flex items-center gap-6">
                    <!-- <a href="?url=main" class="nav-item text-sm font-bold uppercase text-[#00f0ff] border-b-2 border-[#00f0ff]">Trang Chủ</a> -->
                    <a href="#danh-sach" class="nav-item text-sm font-bold uppercase text-gray-400 hover:text-[#ff007f]">Danh Sách</a>
                    <a href="?url=process-add-nam-vuong" class="nav-item text-sm font-bold uppercase text-gray-400 hover:text-[#ff007f]">Đăng Kí</a>
                </nav>

                <div class="hidden md:flex items-center">
                    <?php if (isset($_SESSION['user_id'])): ?>
                        <a href="?url=my-profile" class="flex items-center gap-2 p-1.5 rounded-lg border border-gray-800 bg-[#141622]/50 hover:border-[#00f0ff]/50 transition-all cursor-pointer">
                            <span class="text-xs bg-[#0d0e15] border border-gray-800 px-2 py-1 rounded-full text-[#00f0ff] font-bold">
                                🐚 <?= isset($so_du_so) ? number_format($so_du_so) : 0 ?>
                            </span>
                            <span class="text-xs font-bold text-gray-300"><?= htmlspecialchars($_SESSION['username']) ?></span>
                        </a>
                    <?php else: ?>
                        <a href="?url=login" class="text-xs font-black uppercase border border-[#ff007f] text-[#ff007f] px-3 py-1.5 rounded-lg hover:bg-[#ff007f]/10 transition-all">Đăng Nhập</a>
                    <?php endif; ?>
                </div>

                <button onclick="toggleMobileMenu()" class="md:hidden text-gray-400 p-2 z-50">
                    <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                    </svg>
                </button>
            </div>
        </div>

        <div id="mobile-menu" class="hidden md:hidden absolute top-20 left-0 w-full bg-[#141622]/95 backdrop-blur-lg border-b border-gray-800 p-4 space-y-4">
            <!-- <a href="?url=main" class="block text-center font-bold text-gray-300 hover:text-[#00f0ff]">Trang Chủ</a> -->
            <a href="#danh-sach" class="block text-center font-bold text-gray-300 hover:text-[#00f0ff]">Danh Sách</a>
            <a href="?url=process-add-nam-vuong" class="block text-center font-bold text-gray-300 hover:text-[#00f0ff]">Đăng Kí</a>
            
            <div class="border-t border-gray-800 pt-4 text-center">
                <?php if (isset($_SESSION['user_id'])): ?>
                    <a href="?url=my-profile" class="text-[#00f0ff] font-bold">🤡 Profile</a>
                <?php else: ?>
                    <a href="?url=login" class="block bg-[#ff007f] text-white py-2 rounded-lg font-bold">Đăng Nhập</a>
                <?php endif; ?>
            </div>
        </div>

        <script>
            function toggleMobileMenu() {
                const menu = document.getElementById('mobile-menu');
                menu.classList.toggle('hidden');
            }
        </script>
    </header>

   <section class="relative pt-20 w-full bg-[#0d0e15] border-b border-gray-800/40 overflow-hidden">
    
        <div class="absolute inset-0 z-0 bg-[url('https://images.unsplash.com/photo-1618005182384-a83a8bd57fbe?q=80&w=1920')] bg-cover bg-center opacity-10 mix-blend-lighten pointer-events-none"></div>
        
        <div class="absolute inset-0 z-0 bg-gradient-to-b from-[#141622]/40 via-transparent to-[#0d0e15]"></div>

        <div class="relative z-10 max-w-7xl mx-auto px-6 py-12 flex flex-col lg:flex-row gap-8 items-start">
            
            <div class="w-full lg:w-[65%] py-6 lg:py-12 text-left">
                <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full border border-[#ff007f]/40 bg-[#ff007f]/10 text-[#ff007f] text-xs font-bold uppercase tracking-widest mb-6">
                    ⚡ Cuộc thi nhan sắc lầy lội nhất năm 2026
                </div>
                <h1 class="text-4xl md:text-5xl lg:text-6xl font-black tracking-tight mb-6 bg-gradient-to-r from-[#00f0ff] via-white to-[#ff007f] bg-clip-text text-transparent uppercase leading-tight">
                    Tìm Kiếm Nam Vương<br>IT Fpoly Thanh Hóa
                </h1>
                <p class="max-w-2xl text-gray-400 text-sm md:text-base leading-relaxed mb-8">
                    Nơi hội tụ những gương mặt vàng trong làng code dạo, những nam thần mang tâm hồn phân tích hệ thống nhưng nhan sắc thách thức mọi camera dìm hàng. Hãy xem profile và ném những lượt vote công tâm nhất!
                </p>
                <div>
                    <a href="#danh-sach" class="inline-block px-6 py-3 rounded-lg bg-[#00f0ff] text-black font-bold text-sm shadow-[0_0_15px_rgba(0,240,255,0.4)] hover:scale-105 transition-transform">
                        Kéo Xuống Xem Thí Sinh 👇
                    </a>
                </div>
            </div>

            <div class="w-full lg:w-[35%] bg-[#141622]/60 border border-gray-800/80 rounded-2xl p-5 shadow-xl">
                <?php include 'views/Components/top-5-nam-vuong.php'; ?>
            </div>

        </div>
    </section>

    <main id="danh-sach" class="max-w-7xl w-full mx-auto px-6 py-12">
        <?php include 'views/Components/danh-sach-nam-vuong.php'; ?>
    </main>

    <footer class="bg-[#090a0f] border-t border-gray-900 py-6 mt-auto">
        <div class="max-w-7xl mx-auto px-6 flex flex-col sm:flex-row items-center justify-between gap-4 text-xs text-gray-500">
            <p>&copy; 2026 <span class="text-[#00f0ff]">Nam Vương IT Fpoly</span>. Phát triển bởi Cha Viết Code (Travis Code).</p>
            <p class="uppercase tracking-widest">Built with PHP & Tailwind</p>
        </div>
    </footer>

</body>
</html>