<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Xác Thực - Nam Vương IT</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-[#0d0e15] text-white font-sans min-h-screen flex items-center justify-center p-6">

    <div class="w-full max-w-sm bg-[#141622]/90 border border-gray-800 rounded-xl p-6 shadow-xl">
        <div class="text-center mb-6">
            <h2 class="text-xl font-black text-[#00f0ff] uppercase tracking-wider">👑 NAM VƯƠNG IT</h2>
            <p class="text-[10px] text-gray-500 uppercase tracking-widest mt-1">Đăng nhập để sử dụng Sò</p>
        </div>

        <?php if(!empty($error)): ?>
            <div class="bg-red-500/10 border border-red-500/30 text-red-400 text-xs p-2.5 rounded mb-4 text-center"><?= $error ?></div>
        <?php endif; ?>
        <?php if(!empty($success)): ?>
            <div class="bg-green-500/10 border border-green-500/30 text-green-400 text-xs p-2.5 rounded mb-4 text-center"><?= $success ?></div>
        <?php endif; ?>

        <form method="POST" class="space-y-4">
            <div>
                <label class="block text-[11px] font-bold uppercase text-gray-400 mb-1">Tài khoản</label>
                <input type="text" name="username" value="<?= htmlspecialchars($username ?? '') ?>" required 
                       class="w-full bg-[#0d0e15] border border-gray-700 rounded px-3 py-2 text-sm text-white focus:outline-none focus:border-[#00f0ff] transition-all">
            </div>
            <div>
                <label class="block text-[11px] font-bold uppercase text-gray-400 mb-1">Mật khẩu</label>
                <input type="text" name="password" required 
                       class="w-full bg-[#0d0e15] border border-gray-700 rounded px-3 py-2 text-sm text-white focus:outline-none focus:border-[#00f0ff] transition-all">
            </div>

            <div class="pt-2 flex flex-col gap-2">
                <button type="submit" name="action" value="login" 
                        class="w-full bg-[#00f0ff] text-black font-bold py-2 rounded text-sm hover:bg-white transition-colors">
                    Đăng Nhập ⚡
                </button>
                
                <button type="submit" name="action" value="register" 
                        class="w-full bg-transparent border border-[#ff007f] text-[#ff007f] font-bold py-2 rounded text-sm hover:bg-[#ff007f]/10 transition-colors">
                    Đăng Ký Tài Khoản Mới
                </button>
                <hr>

                <div class="mb-6">
                    <a href="index.php?url=main" class="inline-flex items-center gap-2 text-sm font-bold text-gray-400 hover:text-[#00f0ff] transition-colors group">
                        <span class="text-lg group-hover:-translate-x-1 transition-transform">←</span> Quay Lại
                    </a>
                </div>

            </div>
        </form>
    </div>

</body>
</html>