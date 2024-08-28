<div class="content">
    <h2 class="intro-y text-lg font-medium mt-10">
        Orders List
    </h2>
    <div class="grid grid-cols-12 gap-6 mt-5">
        <div class="intro-y col-span-12 flex flex-wrap xl:flex-nowrap items-center mt-2">
            <!-- Search functionality -->
            <div class="hidden xl:block mx-auto text-slate-500"></div>
        </div>
        <!-- BEGIN: Data List -->
        <div class="intro-y col-span-12 overflow-auto 2xl:overflow-visible">
            <table class="table table-report -mt-2">
                <thead>
                    <tr>
                        <th class="whitespace-nowrap">
                            <input class="form-check-input" type="checkbox">
                        </th>
                        <th class="whitespace-nowrap">ORDER ID</th>
                        <th class="whitespace-nowrap">TRACKING NUMBER</th>
                        <th class="whitespace-nowrap">PAYMENT METHOD</th>
                        <th class="whitespace-nowrap">TRANSACTION TIME</th>
                        <th class="whitespace-nowrap">TRANSACTION END</th>
                        <th class="whitespace-nowrap">STATUS</th>
                        <th class="whitespace-nowrap">ACTION</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($bill as $row) : ?>
                        <tr class="intro-x">
                            <td class="w-10">
                                <input class="form-check-input" type="checkbox">
                            </td>
                            <td class="w-40 !py-4"> <a href="<?= site_url('bill/detail/' . $row->order_id) ?>" class="underline decoration-dotted whitespace-nowrap">#<?= $row->order_id ?></a> </td>
                            <td class="w-40 !py-4"> <a class="underline decoration-dotted whitespace-nowrap"><?= $row->tracking_id ?></a> </td>
                            <td class="w-40">
                                <a href="" class="font-medium text-primary whitespace-nowrap"><?= $row->payment_method ?></a>
                            </td>
                            <td class="w-40">
                                <a href="" class="font-medium whitespace-nowrap"><?= $row->transaction_time ?></a>
                            </td>
                            <td class="w-40">
                                <a href="" class="font-medium whitespace-nowrap"><?= $row->payment_limit ?></a>
                            </td>
                            <td>
                                <div class="flex items-center whitespace-nowrap text-success"> Paid </div>
                            </td>
                            <td>
                                <a class="btn btn-sm btn-rounded-success text-white">Verified</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
        <!-- END: Data List -->
        <!-- BEGIN: Pagination -->
        <!-- Pagination functionality -->
        <!-- END: Pagination -->
    </div>

    <!-- BEGIN: WhatsApp Button -->
    <div class="intro-y col-span-12 flex justify-center mt-5">
        <a href="https://api.whatsapp.com/send?phone=6285363551952&text=Halo, saya ingin memberitahukan tentang pesanan saya." class="btn btn-lg btn-success w-full">
            Hubungi Whatsapp kita jika sudah melakukan pembayaran!!
        </a>
    </div>
    <!-- END: WhatsApp Button -->
</div>

        <!-- END: Data List -->
        <!-- BEGIN: Pagination -->
        <!--  <div class="intro-y col-span-12 flex flex-wrap sm:flex-row sm:flex-nowrap items-center">
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