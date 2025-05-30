<div class="content">
    <h2 class="intro-y text-lg font-medium mt-10">
        Product List
    </h2>
    <div class="grid grid-cols-12 gap-6 mt-5">
        <div class="intro-y col-span-12 flex flex-wrap sm:flex-nowrap items-center mt-2">
            <!-- <div class="w-full sm:w-auto mt-3 sm:mt-0 sm:ml-auto md:ml-0">
                <div class="w-56 relative text-slate-500">
                    <input type="text" class="form-control w-56 box pr-10" placeholder="Search...">
                    <i class="w-4 h-4 absolute my-auto inset-y-0 mr-3 right-0" data-lucide="search"></i>
                </div>
            </div> -->
        </div>
        <!-- BEGIN: Users Layout -->
        <?php foreach ($product as $row) : ?>
            <div class="intro-y col-span-12 md:col-span-6 lg:col-span-4 xl:col-span-3">
                <div class="box">
                    <div class="p-5">
                        <div class="h-40 2xl:h-56 image-fit rounded-md overflow-hidden before:block before:absolute before:w-full before:h-full before:top-0 before:left-0 before:z-10 before:bg-gradient-to-t before:from-black before:to-black/10">
                            <img alt="Midone - HTML Admin Template" class="rounded-md" src="<?= base_url() . '/uploads/' . $row->gambar ?>">
                            <span class="absolute top-0 bg-pending/80 text-white text-xs m-5 px-2 py-1 rounded z-10">Featured</span>
                            <div class="absolute bottom-0 text-white px-5 pb-6 z-10"> <a href="" class="block font-medium text-base"><?= $row->nama_brg ?></a> <span class="text-white/90 text-xs mt-3"><?= $row->kategori ?></span> </div>
                        </div>
                        <div class="text-slate-600 dark:text-slate-500 mt-5">
                            <div class="flex items-center"> <i data-lucide="link" class="w-4 h-4 mr-2"></i> Price: IDR <?= number_format($row->harga, 0, ',', '.') ?> </div>
                            <div class="flex items-center mt-2"> <i data-lucide="layers" class="w-4 h-4 mr-2"></i> Remaining Stock: <?= number_format($row->stok, 0, ',', '.') ?> </div>
                            <div class="flex items-center mt-2"> <i data-lucide="check-square" class="w-4 h-4 mr-2"></i> Status: Active </div>
                            <div class="flex items-center mt-2"> <i data-lucide="info" class="w-4 h-4 mr-2"></i> Jenis: <?= $row->keterangan ?> </div>
                        </div>
                    </div>
                    <div class="flex justify-center lg:justify-end items-center p-5 border-t border-slate-200/60">
                        <form action="<?= site_url('dashboard/cart/' . $row->id_brg) ?>" method="post">
                            <div class="flex items-center">
                                <label for="qty-<?= $row->id_brg ?>" class="mr-2">Qty:</label>
                                <input type="number" id="qty-<?= $row->id_brg ?>" name="qty" min="1" max="<?= $row->stok ?>" value="1" class="form-control w-16">
                            </div>
                            <button type="submit" class="flex items-center btn btn-sm btn-primary ml-3"> 
                                <i data-lucide="shopping-cart" class="w-4 h-4 mr-1"></i> Add to Cart 
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
        <!-- END: Users Layout -->
        <!-- BEGIN: Pagination -->
        <!-- <div class="intro-y col-span-12 flex flex-wrap sm:flex-row sm:flex-nowrap items-center">
            <nav class="w-full sm:w-auto sm:mr-auto">
                <ul class="pagination">
                    <li class="page-item">
                        <a class="page-link" href="#"> <i class="w-4 h-4" data-lucide="chevrons-left"></i> </a>
                    </li>
                    <li class="page-item">
                        <a class="page-link" href="#"> <i class="w-4 h-4" data-lucide="chevron-left"></i> </a>
                    </li>
                    <li class="page-item"> <a class="page-link" href="#">...</a> </li>
                    <li class="page-item"> <a class="page-link" href="#">1</a> </li>
                    <li class="page-item active"> <a class="page-link" href="#">2</a> </li>
                    <li class="page-item"> <a class="page-link" href="#">3</a> </li>
                    <li class="page-item"> <a class="page-link" href="#">...</a> </li>
                    <li class="page-item">
                        <a class="page-link" href="#"> <i class="w-4 h-4" data-lucide="chevron-right"></i> </a>
                    </li>
                    <li class="page-item">
                        <a class="page-link" href="#"> <i class="w-4 h-4" data-lucide="chevrons-right"></i> </a>
                    </li>
                </ul>
            </nav>
            <select class="w-20 form-select box mt-3 sm:mt-0">
                <option>10</option>
                <option>25</option>
                <option>35</option>
                <option>50</option>
            </select>
        </div> -->
        <!-- END: Pagination -->
    </div>
</div>
