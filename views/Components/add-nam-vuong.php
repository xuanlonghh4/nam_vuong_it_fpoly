<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <script src="https://cdn.tailwindcss.com"></script>
    <title>Đăng kí nam vương</title>
</head>
<body class="bg-[#05060f] min-h-screen flex items-center justify-center p-4">

    <form enctype="multipart/form-data" action="?url=process-add-nam-vuong" method="POST" 
          class="w-full max-w-sm bg-[#141622] border border-[#00f0ff]/30 rounded-xl p-8 shadow-[0_0_20px_rgba(0,240,255,0.15)]">
        
        <h2 class="text-center text-2xl font-black text-[#00f0ff] uppercase tracking-widest mb-8 drop-shadow-[0_0_10px_rgba(0,240,255,0.5)]">
            Đăng Kí Nam Vương
        </h2>

        <div class="mb-5">
            <label class="block text-[10px] font-bold uppercase text-[#00f0ff]/70 mb-2 tracking-widest">Tên Thí Sinh</label>
            <input type="text" name="name" 
                   class="w-full bg-[#0d0e15] border border-gray-700 rounded px-4 py-3 text-sm text-white focus:outline-none focus:border-[#00f0ff] focus:ring-1 focus:ring-[#00f0ff] transition-all" value="<?= $oldData['name'] ?? '' ?>" placeholder="Nhập tên thí sinh...">
                   <span class="text-rose-500 text-xs"><?= $errors['name'] ?? '' ?></span>
        </div>

        <div class="mb-5">
            <label class="block text-[10px] font-bold uppercase text-[#00f0ff]/70 mb-2 tracking-widest">Ảnh Đại Diện</label>
            <input type="file" name="thumbnail" value="<?= $oldData['thumbnail'] ?? '' ?>" accept="image/*"
                   class="w-full bg-[#0d0e15] border border-gray-700 rounded px-3 py-2 text-sm text-white file:mr-4 file:py-1 file:px-3 file:rounded file:border-0 file:bg-[#00f0ff] file:text-black file:font-bold hover:file:cursor-pointer">
                   <span class="text-rose-500 text-xs"><?= $errors['thumbnail'] ?? '' ?></span>
        </div>

        <div class="mb-6">
            <label class="block text-[10px] font-bold uppercase text-[#00f0ff]/70 mb-2 tracking-widest">Mô Tả Ngắn</label>
            <textarea name="description" rows="3" 
                      class="w-full bg-[#0d0e15] border border-gray-700 rounded px-4 py-3 text-sm text-white focus:outline-none focus:border-[#00f0ff] focus:ring-1 focus:ring-[#00f0ff] transition-all" 
                      placeholder="Nhập mô tả..."><?= $oldData['description'] ?? '' ?></textarea>
            <span class="text-rose-500 text-xs"><?= $errors['description'] ?? '' ?></span>
        </div>

        <div class="flex gap-3">
            <button type="button" onclick="history.back()" 
                    class="w-1/3 bg-transparent border border-gray-600 text-gray-400 font-bold py-2 rounded text-sm hover:border-white hover:text-white transition-all">
                BACK
            </button>
            <button type="submit" name="add"
                    class="w-2/3 bg-[#00f0ff] text-black font-bold py-2 rounded text-sm hover:bg-white hover:shadow-[0_0_15px_rgba(255,255,255,0.5)] transition-all">
                XÁC NHẬN ⚡
            </button>
        </div>
    </form>

</body>
</html>
