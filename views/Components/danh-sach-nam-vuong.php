<div class="space-y-6">
    
    <div class="mb-8 border-b-2 border-[#00f0ff] pb-3 shadow-[0_4px_12px_-4px_rgba(0,240,255,0.5)]">
        <h2 class="text-left text-xl md:text-2xl font-black uppercase tracking-widest text-white flex items-center gap-2">
            <span class="text-[#00f0ff] drop-shadow-[0_0_6px_rgba(0,240,255,0.8)]">⚡</span> 
            Danh sách nam vương
        </h2>
    </div>
    
    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-8">
        <form class="grid grid-cols-1 md:grid-cols-12 gap-4" method="GET" action="?url=main#danh-sach">
            <input type="hidden" name="url" value="main">
            
            <input type="text" name="search" placeholder="Tìm kiếm theo tên..." 
                value="<?= htmlspecialchars($search ?? '') ?>"
                class="md:col-span-8 w-full bg-[#1a1c28] border border-gray-800 rounded-lg px-4 py-2 text-sm text-white focus:outline-none focus:border-[#00f0ff] transition-all">
            
            <div class="md:col-span-4 flex gap-2">
                <select name="order" class="flex-grow bg-[#1a1c28] border border-gray-800 rounded-lg px-3 py-2 text-sm text-white focus:outline-none focus:border-[#00f0ff] transition-all">
                    <option value="DESC" <?= (isset($order) && $order === 'DESC') ? 'selected' : '' ?>>Max Votes</option>
                    <option value="ASC" <?= (isset($order) && $order === 'ASC') ? 'selected' : '' ?>>Min Votes</option>    
                </select>
                
                <button type="submit" 
                        class="bg-[#00f0ff] text-black font-bold py-2 px-4 rounded-lg hover:bg-white transition-colors whitespace-nowrap">
                    Lọc
                </button>
            </div>
        </form>
        <a href="?url=main#danh-sach" class="col-span-full text-right text-sm text-gray-400 hover:text-[#00f0ff] transition-colors">
            Xóa bộ lọc & Xem tất cả
        </a>
        <!-- Hiển thị số kết quả lọc và số page -->
        <?php if (isset($pagination['total_records']) && isset($search)): ?>
            <div class="col-span-full text-sm text-gray-500 italic">
                <strong><?= $pagination['total_records'] ?></strong> kết quả / <strong><?= $pagination['total_pages'] ?></strong> trang 
            </div>
        <?php endif; ?>
        <?php if (!empty($listAll)): ?>
            <?php foreach ($listAll as $item): ?>
                <div id="candidate-<?= $item->id ?>" 
                    class="group flex flex-col w-full bg-[#1a1c28] border-2 border-[#ff007f] rounded-2xl overflow-hidden 
                            shadow-[0_0_15px_rgba(255,0,127,0.2)] transition-all duration-300
                            hover:-translate-y-2 hover:border-[#00f0ff] hover:shadow-[0_0_25px_rgba(255,0,127,0.5),0_0_10px_rgba(0,240,255,0.3)]">
                    
                    <!-- Ảnh dọc (Tỉ lệ 3:4) -->
                    <div class="relative w-full aspect-[3/4] bg-[#252839] overflow-hidden">
                        <img src="Upload/<?= htmlspecialchars($item->thumbnail) ?>" 
                            alt="<?= htmlspecialchars($item->name) ?>" 
                            class="absolute inset-0 w-full h-full object-cover transition-transform duration-500 group-hover:scale-110"
                            onerror="this.src='/Upload/default-avatar.jpg';">
                        
                        <!-- Overlay mờ dưới chân ảnh để làm nổi bật badge -->
                        <div class="absolute inset-x-0 bottom-0 h-16 bg-gradient-to-t from-[#1a1c28] to-transparent"></div>
                        
                        <span class="absolute bottom-4 right-4 bg-[#0d0e15]/80 text-[#00f0ff] border border-[#00f0ff] 
                                    text-xs font-bold px-3 py-1 rounded-full shadow-[0_0_8px_rgba(0,240,255,0.6)]">
                            ⚡ <?= number_format($item->votes) ?> Lượt Vote
                        </span>
                    </div>

                    <!-- Tên -->
                    <div class="p-5 flex-grow flex items-center justify-center">
                        <h3 class="text-xl font-bold text-white text-center tracking-wide">
                            <?= htmlspecialchars($item->name) ?>
                        </h3>
                    </div>

                    <!-- Nút bấm -->
                    <div class="p-4 bg-[#141622] border-t border-gray-800/50">
                        <a href="?url=info&id=<?= $item->id ?>" 
                        class="flex items-center justify-center text-sm font-bold py-3 px-4 rounded-lg border border-[#00f0ff] 
                                text-[#00f0ff] hover:bg-[#00f0ff] hover:text-black transition-all">
                            👀 Xem Profile & Vote
                        </a>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <p class="text-center text-gray-500 italic col-span-full py-12">
                Chưa có thí sinh nào đủ dũng cảm đăng ký tham gia bảng phong thần!
            </p>
        <?php endif; ?>

         <!-- Phân trang -->

        <?php if ($pagination['total_pages'] > 1): ?>
            <div class="col-span-full flex justify-center items-center gap-3 mt-4">
                <?php for ($i = 1; $i <= $pagination['total_pages']; $i++): ?>
                    <a href="?url=main&search=<?= urlencode($search) ?>&page=<?= $i ?>#danh-sach" 
                    class="px-3 py-1 rounded-md text-sm font-bold <?= $i == $pagination['current_page'] ? 'bg-[#00f0ff] text-black' : 'bg-[#1a1c28] text-gray-400 hover:bg-[#00f0ff]/50 hover:text-white' ?> transition-colors">
                        <?= $i ?>
                    </a>
                <?php endfor; ?>
            </div>
        <?php endif; ?>
    </div>
</div>