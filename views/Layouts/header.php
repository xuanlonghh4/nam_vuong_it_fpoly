 <header class="fixed top-0 left-0 right-0 z-50 h-20 bg-[#0d0e15]/90 backdrop-blur-md border-b border-[#ff007f]/30 shadow-[0_4px_20px_rgba(255,0,127,0.15)]">
        <div class="max-w-7xl mx-auto px-6 h-full flex items-center justify-between">
            
            <a href="index.php?url=main" class="flex items-center gap-3 group">
                <span class="text-2xl animate-bounce">👑</span>
                <span class="text-xl md:text-2xl font-black uppercase tracking-wider text-[#00f0ff]">
                    NAM VƯƠNG IT FPOLY
                </span>
            </a>
            
            <div class="flex items-center gap-6">
                
                <nav id="main-nav" class="hidden md:flex items-center gap-6">
                    <a href="?url=process-add" class="nav-item text-sm font-bold tracking-widest uppercase px-1 py-1 transition-all duration-200 border-b-2 border-[#00f0ff] text-[#00f0ff] drop-shadow-[0_0_5px_rgba(0,240,255,0.5)]">
                        Đăng kí
                    </a>
                    <a href="?url=main#danh-sach" class="nav-item text-sm font-bold tracking-widest uppercase px-1 py-1 transition-all duration-200 text-gray-400 hover:text-[#ff007f]">
                        Danh Sách 
                    </a>
                </nav>

                <div class="hidden md:block h-5 w-[1px] bg-gray-800/80"></div>

                <div class="flex items-center gap-4">
                    <?php if (isset($_SESSION['user_id'])): ?>
                        <div class="flex items-center gap-4">
                            
                            <a href="index.php?url=my-profile" class="flex items-center gap-3 p-1.5 rounded-lg border border-gray-800 bg-[#141622]/50 hover:border-[#00f0ff]/50 transition-all group">
                                
                                <span class="text-xs bg-[#0d0e15] border border-gray-800 px-2.5 py-1 rounded-full flex items-center gap-1.5">
                                    🐚 <span class="text-[#00f0ff] font-black">
                                        <?= isset($so_du_so) ? number_format($so_du_so) : 0 ?>
                                    </span> Sò
                                </span>
                                
                                <div class="flex flex-col text-right pr-1">
                                    <span class="text-xs font-bold text-gray-300 group-hover:text-[#00f0ff] transition-colors">
                                        👋 <?= htmlspecialchars($_SESSION['username']) ?>
                                    </span>
                                    <span class="text-[9px] text-gray-500 uppercase tracking-widest text-left">Xem hồ sơ</span>
                                </div>
                            </a>
                            
                            <a href="index.php?url=logout" class="text-[10px] text-red-400 hover:text-red-300 uppercase tracking-widest font-bold transition-colors pl-1">
                                Thoát
                            </a>
                            
                        </div>
                    <?php else: ?>
                        <a href="index.php?url=login" class="text-xs font-black tracking-widest uppercase bg-transparent border border-[#ff007f] text-[#ff007f] px-4 py-2 rounded-lg hover:bg-[#ff007f]/10 transition-all">
                            Đăng Nhập
                        </a>
                    <?php endif; ?>
                </div>
                
            </div>

            <script>
                const navItems = document.querySelectorAll('#main-nav .nav-item');
                navItems.forEach(item => {
                    item.addEventListener('click', function() {
                        navItems.forEach(nav => nav.className = 'nav-item text-sm font-bold tracking-widest uppercase px-1 py-1 transition-all duration-200 text-gray-400 hover:text-[#ff007f]');
                        this.className = 'nav-item text-sm font-bold tracking-widest uppercase px-1 py-1 transition-all duration-200 border-b-2 border-[#00f0ff] text-[#00f0ff] drop-shadow-[0_0_5px_rgba(0,240,255,0.5)]';
                    });
                });
            </script>
            
        </div>
    </header>