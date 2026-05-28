<div class="space-y-6">
    <div class="border-l-4 border-[#ff007f] pl-4">
        <h2 class="text-lg font-black uppercase tracking-tight text-[#ff007f] drop-shadow-[0_0_8px_rgba(255,0,127,0.3)]">
            🏆 Phong Đần Bảng
        </h2>
        <p class="text-[10px] text-gray-500 uppercase tracking-[0.2em]">Top 5 Quyền Lực Nhất</p>
    </div>

    <div class="flex flex-col gap-3">
        <?php if (!empty($listTop5)): ?>
            <?php foreach ($listTop5 as $index => $item): 
                $rank = $index + 1;
                $glowColor = match($rank) {
                    1 => 'border-yellow-400 shadow-[0_0_10px_rgba(234,179,8,0.4)]',
                    2 => 'border-slate-300 shadow-[0_0_8px_rgba(203,213,225,0.2)]',
                    3 => 'border-amber-600',
                    default => 'border-[#00f0ff]/30'
                };
            ?>
            <a href="?url=info&id=<?= $item->id ?>" class="group flex items-center gap-4 p-3 rounded-xl bg-[#141622]/80 border border-gray-800/40 hover:border-[#ff007f]/40 hover:bg-[#1a1c28] transition-all duration-300">
                
                <div class="relative shrink-0">
                    <span class="absolute -top-1 -left-1 z-10 w-5 h-5 flex items-center justify-center rounded-full text-[9px] font-black 
                        <?= $rank <= 3 ? 'bg-[#ff007f] text-white' : 'bg-gray-800 text-gray-400' ?>">
                        <?= $rank ?>
                    </span>
                    <div class="w-12 h-12 rounded-full border-2 overflow-hidden <?= $glowColor ?>">
                        <img src="Upload/<?= htmlspecialchars($item->thumbnail) ?>" 
                             alt="<?= htmlspecialchars($item->name) ?>"
                             class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500"
                             onerror="this.src='/nvtg/Upload/default-avatar.jpg';">
                    </div>
                </div>
                
                <div class="overflow-hidden flex-grow">
                    <h4 class="font-bold text-sm text-gray-200 group-hover:text-[#00f0ff] truncate transition-colors">
                        <?= htmlspecialchars($item->name) ?>
                    </h4>
                    <div class="flex items-center gap-2 mt-0.5">
                        <span class="text-[10px] text-[#00f0ff] font-black tracking-wider">
                            ⚡ <?= number_format($item->votes) ?> VOTE
                        </span>
                    </div>
                </div>
            </a>
            <?php endforeach; ?>
        <?php else: ?>
            <p class="text-xs text-gray-500 italic text-center py-4">Chưa cập nhật bảng vàng...</p>
        <?php endif; ?>
    </div>

    <div class="hidden lg:block p-3 rounded-xl border border-dashed border-gray-800/60 text-center">
        <p class="text-[9px] text-gray-600 uppercase tracking-widest">Fpoly IT Championship 2026</p>
    </div>
</div>