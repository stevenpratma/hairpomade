<div class="content">
    <h2 class="intro-y text-lg font-medium mt-10">
        Laporan Penjualan
    </h2>
    <div class="grid grid-cols-12 gap-6 mt-5">
        <div class="intro-y col-span-12 flex flex-wrap xl:flex-nowrap items-center mt-2">
            <div class="flex w-full sm:w-auto">
                <form id="filterForm" action="<?= site_url('admin/invoice/filterData') ?>" method="post">
                    <div class="form-group">
                        <label for="start_date">Tanggal Mulai</label>
                        <input type="date" name="start_date" class="form-control" id="start_date" value="<?= isset($start_date) ? $start_date : '' ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="end_date">Tanggal Akhir</label>
                        <input type="date" name="end_date" class="form-control" id="end_date" value="<?= isset($end_date) ? $end_date : '' ?>" required>
                    </div>
                    <button type="submit" class="btn btn-primary mt-2">Filter</button>
                    <button type="button" class="btn btn-secondary mt-2" onclick="resetForm()">Reset</button>
                    <!-- <a target="_blank" href="<?= site_url('admin/invoice/pdfLaporan/' . (isset($start_date) ? $start_date : 'null') . '/' . (isset($end_date) ? $end_date : 'null')) ?>" class="btn btn-success mt-2">Print</a> -->
                    <a target="_blank" href="<?= site_url('admin/invoice/pdfLaporan/' . (isset($start_date) ? $start_date : null) . '/' . (isset($end_date) ? $end_date : null)) ?>" class="btn btn-success mt-2">Print</a>
                    <p><?php echo isset($start_date) ?></p>
                </form>
                <script>
                    function resetForm() {
                        document.getElementById("filterForm").reset();
                        window.location.href = "<?= site_url('admin/invoice') ?>";
                        console.log('reset')
                    }
                   
                </script>
            </div>
        </div>
    </div>

    <h2 class="intro-y text-lg font-medium mt-10">
        Transaction List
    </h2>
    
    <div class="grid grid-cols-12 gap-6 mt-5">
        <div class="intro-y col-span-12 flex flex-wrap xl:flex-nowrap items-center mt-2">
           <!-- <div class="flex w-full sm:w-auto">
                <div class="w-48 relative text-slate-500">
                    <input type="text" class="form-control w-48 box pr-10" placeholder="Search by invoice...">
                    <i class="w-4 h-4 absolute my-auto inset-y-0 mr-3 right-0" data-lucide="search"></i>
                </div>
                <select class="form-select box ml-2">
                    <option>Status</option>
                    <option>Waiting Payment</option>
                    <option>Confirmed</option>
                    <option>Packing</option>
                    <option>Delivered</option>
                    <option>Completed</option>
                </select>
            </div> -->
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
                        <th class="whitespace-nowrap">CUSTOMER NAME</th>
                        <th class="whitespace-nowrap">TRANSACTION TIME</th>
                        <th class="whitespace-nowrap">PROOF OF PAYMENT</th>
                        <th class="whitespace-nowrap">STATUS</th>
                        <th class="text-center whitespace-nowrap">ACTIONS</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($invoice)) : ?>
                        <?php foreach ($invoice as $row) : ?>
                            <tr class="intro-x">
                                <td class="w-10">
                                    <input class="form-check-input" type="checkbox">
                                </td>
                                <td class="w-40 !py-4"> <a href="<?= site_url('admin/invoice/detail/' . $row->order_id) ?>" class="underline decoration-dotted whitespace-nowrap">#<?= $row->order_id ?></a> </td>
                                <td class="w-40">
                                    <a href="" class="font-medium whitespace-nowrap"><?= $row->name ?></a>
                                </td>
                                <td>
                                    <div class="text-slate-500 whitespace-nowrap mt-0.5"><?= $row->transaction_time ?></div>
                                </td>
                                <td><?php if (empty($row->gambar)) { ?>
                                        <div class="flex items-center whitespace-nowrap text-danger"> <i data-lucide="alert-circle" class="w-4 h-4 mr-2"></i>Belum upload bukti </div>
                                    <?php } else { ?>
                                        <a href="">
                                            <div class="flex items-center whitespace-nowrap text-primary"> <i data-lucide="link" class="w-4 h-4 mr-2"></i><a href="<?= base_url() . '/uploads/' . $row->gambar ?>">Lihat Bukti </a></div>
                                        </a>
                                    <?php } ?>
                                </td>
                                <td>
                                    <?php if ($row->status == "0") { ?>
                                        <div class="flex items-center whitespace-nowrap text-pending"><b>PENDING</b> </div>
                                    <?php } else if ($row->status == "1") { ?>
                                        <div class="flex items-center whitespace-nowrap text-success"> <b>PAID</b> </div>
                                    <?php } ?>
                                </td>
                                <td class="table-report__action">
                                    <div class="flex justify-center items-center space-x-2">
                                        <?php if ($row->status == "0") { ?>
                                            <a class="flex items-center text-primary whitespace-nowrap" href="<?= site_url('admin/invoice/confirm/' . $row->order_id) ?>"> <i data-lucide="arrow-left-right" class="w-4 h-4 mr-1"></i> Change Status </a>
                                        <?php } else if ($row->status == "1") { ?>
                                            <button class="btn btn-sm btn-success text-white">Payment Successfully</button>
                                        <?php } ?>
                                        <a class="flex items-center text-danger whitespace-nowrap" href="#" data-tw-toggle="modal" data-tw-target="#delete-confirmation-modal" data-order-id="<?= $row->order_id ?>"> <i data-lucide="trash-2" class="w-4 h-4 mr-1"></i> Delete </a>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else : ?>
                        <tr>
                            <td colspan="7">No data available</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
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
    <!-- BEGIN: Delete Confirmation Modal -->
    <div id="delete-confirmation-modal" class="modal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-body p-0">
                    <div class="p-5 text-center">
                        <i data-lucide="x-circle" class="w-16 h-16 text-danger mx-auto mt-3"></i>
                        <div class="text-3xl mt-5">Are you sure?</div>
                        <div class="text-slate-500 mt-2">
                            Do you really want to delete this record?
                            <br>
                            This process cannot be undone.
                        </div>
                    </div>
                    <div class="px-5 pb-8 text-center">
                        <button type="button" data-tw-dismiss="modal" class="btn btn-outline-secondary w-24 mr-1">Cancel</button>
                        <button type="button" class="btn btn-danger w-24" id="confirm-delete">Delete</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- END: Delete Confirmation Modal -->
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        var deleteButtons = document.querySelectorAll('[data-tw-toggle="modal"]');
        var deleteModal = document.getElementById('delete-confirmation-modal');
        var confirmDeleteButton = document.getElementById('confirm-delete');
        var orderIdToDelete;

        deleteButtons.forEach(function(button) {
            button.addEventListener('click', function() {
                orderIdToDelete = this.getAttribute('data-order-id');
            });
        });

        confirmDeleteButton.addEventListener('click', function() {
            window.location.href = '<?= site_url('admin/invoice/delete/') ?>' + orderIdToDelete;
        });
    });
</script>