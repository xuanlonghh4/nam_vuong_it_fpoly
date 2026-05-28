<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cyberpunk Edit - Nam Vương</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        .neon-glow { text-shadow: 0 0 10px #0ff, 0 0 20px #0ff; }
        .border-neon { border: 2px solid #0ff; box-shadow: 0 0 10px #0ff; }
    </style>
</head>
<body class="bg-slate-900 text-cyan-400 font-mono min-h-screen p-6">

    <div class="max-w-2xl mx-auto bg-slate-800 p-8 rounded-lg border border-cyan-500 shadow-[0_0_15px_rgba(0,255,255,0.3)]">
        <a href="?url=admin#tab-candidates" class="inline-block mb-6 px-4 py-2 bg-slate-700 hover:bg-rose-600 text-white transition-all duration-300 rounded border border-rose-500">
            &larr; Quay lại
        </a>

        <h1 class="text-3xl font-bold mb-8 neon-glow uppercase text-cyan-300 text-center tracking-widest">
            Cập nhật Thí Sinh
        </h1>

        <form action="" method="POST" enctype="multipart/form-data" class="space-y-6">
            <input type="hidden" name="id" value="<?= $item->id ?? '' ?>">
            
            <div class="flex justify-center">
                <img src="Upload/<?= htmlspecialchars($item->thumbnail)  ?>" alt="Thumbnail" class="w-40 h-40 object-cover rounded border-2 border-cyan-400 p-1 shadow-[0_0_15px_#0ff]">
            </div>

            <div class="mt-6">
                <label class="block text-sm uppercase mb-2">Thay đổi ảnh đại diện</label>
                <div class="relative group">
                    <input type="file" name="thumbnail" accept="image/*" 
                        class="block w-full text-sm text-slate-400 file:mr-4 file:py-2 file:px-4 file:rounded file:border-0 file:text-sm file:font-semibold file:bg-cyan-900 file:text-cyan-100 hover:file:bg-cyan-700 bg-slate-900 border border-cyan-700 p-2 rounded cursor-pointer transition-all">
                </div>
                <p class="text-xs text-slate-500 mt-1">Chỉ hỗ trợ file ảnh (jpg, png, jpeg).</p>
            </div>

            <div>
                <label class="block text-sm uppercase">Tên thí sinh</label>
                <input type="text" name="name" value="<?= $oldData['name'] ?? '' ?>" class="w-full bg-slate-900 border border-cyan-700 p-3 text-white focus:border-cyan-400 outline-none rounded">
                <span class="text-rose-500 text-xs"><?= $errors['name'] ?? '' ?></span>
            </div>

            <div>
                <label class="block text-sm uppercase">Số lượt vote</label>
                <input type="text" name="votes" value="<?= $oldData['votes'] ?? '' ?>" class="w-full bg-slate-900 border border-cyan-700 p-3 text-white focus:border-cyan-400 outline-none rounded">
                <span class="text-rose-500 text-xs"><?= $errors['votes'] ?? '' ?></span>
            </div>

            <div>
                <label class="block text-sm uppercase">Trạng thái</label>
                <select name="status" class="w-full bg-slate-900 border border-cyan-700 p-3 text-white focus:border-cyan-400 outline-none rounded">
                    <option value="1" <?= ( $oldData['status'] ?? 0) == 1 ? 'selected' : '' ?>>Hiển thị</option>
                    <option value="0" <?= ( $oldData['status'] ?? 0) == 0 ? 'selected' : '' ?>>Ẩn</option>
                </select>
            </div>

            <div>
                <label class="block text-sm uppercase">Mô tả</label>
                <textarea name="description" class="w-full bg-slate-900 border border-cyan-700 p-3 text-white focus:border-cyan-400 outline-none rounded h-32"><?= $oldData['description'] ?? '' ?></textarea>
                <span class="text-rose-500 text-xs"><?= $errors['description'] ?? '' ?></span>
            </div>

            <div>
                <label class="block text-sm uppercase">Thời điểm đăng kí</label>
                <input type="text" value="<?= date('d/m/Y H:i:s', strtotime($oldData['created_at'] ?? '')) ?? '' ?>" class="w-full bg-slate-900 border border-cyan-700 p-3 text-white focus:border-cyan-400 outline-none rounded" readonly>
            </div>

            <button type="submit" name="update" class="w-full bg-cyan-600 hover:bg-cyan-500 text-black font-bold py-3 uppercase tracking-widest transition-all duration-300 shadow-[0_0_15px_#0891b2] rounded">
                Xác nhận cập nhật
            </button>
        </form>
    </div>

</body>
</html>