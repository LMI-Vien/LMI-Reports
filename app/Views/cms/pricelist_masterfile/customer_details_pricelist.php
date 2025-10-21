<style>
    .rmv-btn {
        border-radius: 20px;
        background-color: #C80000;
        color: white;
        border: 0.5px solid #990000;
        box-shadow: 6px 6px 15px rgba(0, 0, 0, 0.5);
    }

    .rmv-btn:disabled {
        border-radius: 20px;
        background-color: gray;
        color: black;
        border: 0.5px solid gray;
        box-shadow: 6px 6px 15px rgba(0, 0, 0, 0.5);
    }
    .add_line {
        margin-right: 10px;
        margin-bottom: 10px;
        padding: 10px;
        min-width: 75px;
        max-height: 30px;
        line-height: 0.5;
        background-color: #339933;
        color: white;
        border: 1px solid #267326;
        border-radius: 10px;
        box-shadow: 6px 6px 15px rgba(0, 0, 0, 0.5);
    }

    .add_line:disabled {
        background-color: gray !important;
        color: black !important;
    }

    #list-data {
        overflow: auto !important;
        max-height: none !important;
    }
</style>


    <div class="content-wrapper p-4">
        <div class="card">
            <div class="text-center md-center">
                <b>C U S T O M E R &nbsp; D E T A I L S &nbsp; P R I C E L I S T</b>
            </div>
            <div class="card-body text-center">
                <div class="box">
                    <?php
                        echo view("cms/layout/buttons",$buttons);
                        $optionSet = '';
                        foreach($pageOption as $pageOptionLoop) {
                            $optionSet .= "<option value='".$pageOptionLoop."'>".$pageOptionLoop."</option>";
                        }
                    ?>
                    <div class="box-body">
                        <div class="col-md-12 list-data tbl-content" id="list-data">
                            <table class="table table-bordered listdata">
                                <thead>
                                    <tr>
                                        <th class='center-content'><input class ="selectall" type ="checkbox"></th>
                                        <th class='center-content'>Brand</th>
                                        <th class='center-content'>Brand Label Type</th>
                                        <th class='center-content'>Label Type Category</th>
                                        <th class='center-content'>Category 1 (Item Classification MF)</th>
                                        <th class='center-content'>Category 2 (Sub Classification MF)</th>
                                        <th class='center-content'>Category 3 (Department MF)</th>
                                        <th class='center-content'>Category 4 (Merch. Category MF)</th>
                                        <th class='center-content'>Item Code</th>
                                        <th class='center-content'>Item Description</th>
                                        <th class='center-content'>Customer Item Code</th>
                                        <th class='center-content'>UOM</th>
                                        <th class='center-content'>Selling Price</th>
                                        <th class='center-content'>Discount in Percent</th>
                                        <th class='center-content'>Net Price</th>
                                        <th class='center-content'>Effectivity Date</th>
                                        <th class='center-content'>Status</th>
                                        <th class='center-content'>Date Created</th>
                                        <th class='center-content'>Date Modified</th>
                                        <th class='center-content'>Action</th>
                                    </tr>
                                </thead>
                                <tbody class="table_body word_break"></tbody>
                            </table>
                        </div>
                        <div class="list_pagination"></div>
                        <div class="form-group pull-right">
                            <label>Show</label>
                            <select class="record-entries">
                                <?= $optionSet; ?>
                            </select>
                            <label>Entries</label>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- MODAL -->
    <div class="modal" tabindex="-1" id="popup_modal" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="staticBackdropLabel">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title">
                        <b></b>
                    </h1>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span>&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="form-modal">
                        <input type="hidden" id="customerId" value="<?= esc($customerId) ?>">
                        <input type="hidden" id="pricelistId" value="<?= esc($pricelistId) ?>">
                        <input type="hidden" id="paymentGroup" >
                        <input type="hidden" id="mainPricelistId" >
                        
                        <!-- Row 1: Brand / Brand Label Type -->
                        <div class="form-row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="brand" class="col-form-label">Brand</label>
                                    <input type="text" id="brand" name="brand" class="form-control required">
                                    <input type="hidden" id="brandId" name="brandId">
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="brandLabelType" class="col-form-label">Brand Label Type</label>
                                    <input type="text" id="brandLabelType" name="brandLabelType" class="form-control required">
                                    <input type="hidden" id="brandLabelTypeId" name="brandLabelTypeId">
                                </div>
                            </div>
                        </div>
                    
                    
                        <!-- Row 2: Label Type Category / Category 1 -->
                        <div class="form-row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="labelTypeCat" class="col-form-label">Label Type Category</label>
                                    <input type="text" id="labelTypeCat" name="labelTypeCat" class="form-control required">
                                    <input type="hidden" id="labelTypeCatId" name="labelTypeCatId">
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="catOne" class="col-form-label">Category 1 (Item Class MF)</label>
                                    <input type="text" id="catOne" name="catOne" class="form-control required">
                                    <input type="hidden" id="catOneId" name="catOneId">
                                </div>
                            </div>
                        </div>

                        <!-- Row 3: Category 2 / Category 3 -->
                        <div class="form-row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="catTwo" class="col-form-label">Category 2 (Sub Class MF)</label>
                                    <input type="text" id="catTwo" name="catTwo" class="form-control required">
                                    <input type="hidden" id="catTwoId" name="catTwoId">
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="catThree" class="col-form-label">Category 3 (Department MF)</label>
                                    <input type="text" id="catThree" name="catThree" class="form-control required">
                                    <input type="hidden" id="catThreeId" name="catThreeId">
                                </div>
                            </div>
                        </div>

                        <!-- Row 4: Category 4 / Item Code -->
                        <div class="form-row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="catFour" class="col-form-label">Category 4 (Merch. Category MF)</label>
                                    <input type="text" id="catFour" name="catFour" class="form-control required">
                                    <input type="hidden" id="catFourId" name="catFourId">
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="itemCode" class="col-form-label">Item Code</label>
                                    <input type="text" id="itemCode" name="itemCode" class="form-control required">
                                </div>
                            </div>
                        </div>

                        <!-- Row 5: Item Description -->
                        <div class="form-row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="itemDescription" class="col-form-label">Item Description</label>
                                    <input type="text" id="itemDescription" name="itemDescription" class="form-control required">
                                    <input type="hidden" id="itemDescriptionId" name="itemCodeId">
                                </div>
                            </div>
                        </div>

                        <!-- Row 6: Customer Item Code / UOM -->
                        <div class="form-row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="customerItemCode" class="col-form-label">Customer Item Code</label>
                                    <input type="text" id="customerItemCode" name="customerItemCode" class="form-control">
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="uom" class="col-form-label">UOM</label>
                                    <input type="text" id="uom" name="uom" class="form-control required">
                                </div>
                            </div>
                        </div>

                        <!-- Row 7: Selling Price / Discount % -->
                        <div class="form-row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="sellingPrice" class="col-form-label">Selling Price</label>
                                    <input type="text" id="sellingPrice" name="sellingPrice" class="form-control required numbersdecimalonly">
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="discountInPercent" class="col-form-label">Discount in Percent</label>
                                    <input type="text" id="discountInPercent" name="discountInPercent" class="form-control numbersonly">
                                </div>
                            </div>
                        </div>

                         <!-- Row 8: Net Price / Effectivity Date -->
                        <div class="form-row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="netPrice" class="col-form-label">Net Price</label>
                                    <input type="text" id="netPrice" name="netPrice" class="form-control required" disabled>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="effectDate" class="col-form-label">Effectivity Date</label>
                                    <input type="date" id="effectDate" name="effectDate" class="form-control required">
                                </div>
                            </div>
                        </div>
                      
                        <!-- Row 9: Status -->
                        <div class="form-row">
                            <div class="col-md-12">
                                <div class="form-check mb-0">
                                    <input type="checkbox" class="form-check-input" id="status" checked>
                                    <label class="form-check-label" for="status">Active</label>
                                </div>
                            </div>
                        </div>

                        <input type="hidden" id="itemUid" name="itemUid">
                        <input type="hidden" id="itemSource" name="itemSource">
                        <input type="hidden" id="itemId" name="itemId">
                    </form>
                </div>
                <div class="modal-footer"></div>
            </div>
        </div>
    </div>

    <!-- IMPORT MODAL -->
    <div class="modal" tabindex="-1" id="import_modal">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title">
                        <b></b>
                    </h1>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <div class="modal-body">
                    <div class="card">
                        <div class="mb-3">
                            <div class="text-center"
                            style="padding: 10px; font-family: 'Courier New', Courier, monospace; font-size: large; background-color: #fdb92a; color: #333333; border: 1px solid #ffffff; border-radius: 10px;"                            
                            >
                                <b>Extracted Data</b>
                            </div>

                            <div class="row">
                                <div class="import_buttons col-6">
                                    <label for="file" class="custom-file-upload save" style="margin-left:10px; margin-top: 10px; margin-bottom: 10px">
                                        <i class="fa fa-file-import" style="margin-right: 5px;"></i>Custom Upload
                                    </label>
                                    <input
                                        type="file"
                                        style="padding-left: 10px;"
                                        id="file"
                                        accept=".xls,.xlsx,.csv"
                                        aria-describedby="import_files"
                                        onclick="clear_import_table()"
                                    >
                
                                    <label class="custom-file-upload save" id="preview_xl_file" style="margin-top: 10px; margin-bottom: 10px" onclick="read_xl_file()">
                                        <i class="fa fa-sync" style="margin-right: 5px;"></i>Preview Data
                                    </label>
                                </div>
        
                                <div class="col"></div>
        
                                <div class="col-3">
                                    <label class="custom-file-upload save" id="download_template" style="margin-top: 10px; margin-bottom: 10px" onclick="download_template()">
                                        <i class="fa fa-file-download" style="margin-right: 5px;"></i>Download Import Template
                                    </label>
                                </div>
                            </div>

                            <div style="overflow-x: auto; max-height: 400px;">
                                <table class= "table table-bordered listdata">
                                    <thead>
                                        <tr>
                                            <th class='center-content'>Line #</th>
                                            <th class='center-content'>Brand</th>
                                            <th class='center-content'>Brand Label Type</th>
                                            <th class='center-content'>Label Type Category</th>
                                            <th class='center-content'>Category 1 (Item Classification MF)</th>
                                            <th class='center-content'>Category 2 (Sub Classification MF)</th>
                                            <th class='center-content'>Category 3 (Department MF)</th>
                                            <th class='center-content'>Category 4 (Merch. Category MF)</th>
                                            <th class='center-content'>Item Code</th>
                                            <th class='center-content'>Item Description</th>
                                            <th class='center-content'>Customer Item Code</th>
                                            <th class='center-content'>UOM</th>
                                            <th class='center-content'>Selling Price</th>
                                            <th class='center-content'>Discount in Percent</th>
                                            <th class='center-content'>Effectivity Date</th>
                                            <th class='center-content'>Status</th>
                                        </tr>
                                    </thead>
                                    <tbody class="word_break import_table"></tbody>
                                </table>
                            </div>
                        </div>
                        <center style="margin-bottom: 5px">
                            <div class="import_pagination btn-group"></div>
                        </center>
                    </div>
                </div>
                
                <div class="modal-footer">
                    <button type="button" class="btn save" onclick="process_xl_file()">Validate and Save</button>
                    <button type="button" class="btn caution" data-dismiss="modal">Close</button>        
                </div>
            </div>
        </div>
    </div>

    <div class="modal" tabindex="-1" id="historicalModal" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="staticBackdropLabel">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title">
                        <b>Historical Data</b>
                    </h1>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span>&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <table class="table table-striped table-bordered table-sm" id="historicalTable">
                        <thead>
                            <tr>
                            <th>Effectivity Date</th>
                            <th>Selling Price</th>
                            <th>Discount %</th>
                            <th>Net Price</th>
                            </tr>
                        </thead>
                        <tbody id="historicalTbody">
                        </tbody>
                    </table>
                </div>
                <div class="modal-footer"></div>
            </div>
        </div>
    </div>

<script>

    var column_filter = '';
    var order_filter = '';
    var limit = 10; 
    var user_id = '<?=$session->sess_uid;?>';
    var url = "<?= base_url("cms/global_controller");?>";
    var base_url = '<?= base_url();?>';
    var customerId = '<?=$uri->getSegment(4);?>';
    var pricelistId = '<?=$uri->getSegment(5);?>';
    var query = "mp.status >= 0 AND cl.id = "+customerId+" AND mp.pricelist_id = "+pricelistId;

    $(document).ready(function() {
       // var query = "pl.status >= 0 AND pl.customer_id = " + pricelistId;
        get_data(query);
        get_pagination(query);

        let brands = <?= json_encode($brands); ?>;
        let brandLabelType = <?= json_encode($brandLabelType); ?>;
        let labelCategory  = <?= json_encode($labelCategory); ?>;
        let itemClass = <?= json_encode($itemClass); ?>;
        let subClass = <?= json_encode($subClass); ?>;
        let itemDepartment = <?= json_encode($itemDepartment); ?>;
        let merchCategory = <?= json_encode($merchCategory); ?>;

        let brandOptions = brands.map(b => ({
            id: b.id,
            display: (b.brand_code ? b.brand_code : '')
        }));

        let brandLabelTypeOptions = brandLabelType.map(bl => ({
            id: bl.id,
            display: (bl.label ? bl.label : '')
        }));

        let labelCategoryOptions = labelCategory.map(lc => ({
            id: lc.id,
            display: (lc.code ? lc.code + ' - ' : '') + (lc.description || '')
        }));

        let catOneCategoryOptions = itemClass.map(ic => ({
            id: ic.id,
            display: (ic.item_class_code ? ic.item_class_code : '')
        }));

        let catTwoCategoryOptions = subClass.map(sc => ({
            id: sc.id,
            display: (sc.item_sub_class_code ? sc.item_sub_class_code : '')
        }));

        let catThreeCategoryOptions = itemDepartment.map(id => ({
            id: id.id,
            display: (id.item_department_code ? id.item_department_code : '') 
        }));

        let catFourCategoryOptions = merchCategory.map(mc => ({
            id: mc.id,
            display: (mc.item_mech_cat_code ? mc.item_mech_cat_code : '')
        }));
        

        let brandLabelToId        = new Map(brandOptions.map(o => [o.display, String(o.id)]));
        let brandLabelTypeToId    = new Map(brandLabelTypeOptions.map(o => [o.display, String(o.id)]));
        let labelCatLabelToId     = new Map(labelCategoryOptions.map(o => [o.display, String(o.id)]));
        let catOneLabelToId       = new Map(catOneCategoryOptions.map(o => [o.display, String(o.id)]));
        let catTwoLabelToId       = new Map(catTwoCategoryOptions.map(o => [o.display, String(o.id)]));
        let catThreeLabelToId     = new Map(catThreeCategoryOptions.map(o => [o.display, String(o.id)]));
        let catFourLabelToId      = new Map(catFourCategoryOptions.map(o => [o.display, String(o.id)]));
        

        initAuto($('#brand'),           $('#brandId'),            brandOptions,             'display', 'id', row => { $('#brandId').val(row.id); });
        initAuto($('#brandLabelType'),  $('#brandLabelTypeId'),   brandLabelTypeOptions,    'display', 'id', row => { $('#brandLabelTypeId').val(row.id); });
        initAuto($('#labelTypeCat'),    $('#labelTypeCatId'),     labelCategoryOptions,     'display', 'id', row => { $('#labelTypeCatId').val(row.id); });
        initAuto($('#catOne'),          $('#catOneId'),           catOneCategoryOptions,    'display', 'id', row => { $('#catOneId').val(row.id); });
        initAuto($('#catTwo'),          $('#catTwoId'),           catTwoCategoryOptions,    'display', 'id', row => { $('#catTwoId').val(row.id); });
        initAuto($('#catThree'),        $('#catThreeId'),         catThreeCategoryOptions,  'display', 'id', row => { $('#catThreeId').val(row.id); });
        initAuto($('#catFour'),         $('#catFourId'),          catFourCategoryOptions,   'display', 'id', row => { $('#catFourId').val(row.id); });
        
        // apply per field
        enforceValidPick($('#brand'),           $('#brandId'),              brandLabelToId);
        enforceValidPick($('#brandLabelType'),  $('#brandLabelTypeId'),     brandLabelTypeToId);
        enforceValidPick($('#labelTypeCat'),    $('#labelTypeCatId'),       labelCatLabelToId);
        enforceValidPick($('#catOne'),          $('#catOneId'),             catOneLabelToId);
        enforceValidPick($('#catTwo'),          $('#catTwoId'),             catTwoLabelToId);
        enforceValidPick($('#catThree'),        $('#catThreeId'),           catThreeLabelToId);
        enforceValidPick($('#catFour'),         $('#catFourId'),            catFourLabelToId);

        function calculateNetPrice() {
            let sellingPrice = parseFloat($("#sellingPrice").val()) || 0;
            let discountPercent = parseFloat($("#discountInPercent").val()) || 0;

            if (discountPercent < 0) discountPercent = 0;
            if (discountPercent > 100) discountPercent = 100;

            // formula: Net Price = Selling Price × (1 - Discount/100)
            let netPrice = sellingPrice * (1 - discountPercent / 100);

            $("#netPrice").val(netPrice.toFixed(2));
        }
        
        $("#sellingPrice, #discountInPercent").on("input", calculateNetPrice);

        $("#uom").on("input", function () {
            let val = $(this).val();
            $(this).val(val.toUpperCase());
        });

        $.getJSON('<?= base_url('cms/pricelist-masterfile/merged-items'); ?>', function(items) {
            items = items || [];

            // Create a unique id per row so "lmi:288" ≠ "rgdi:288"
            const rows = items.map(it => {
                return {
                    uid: (it.source + ':' + it.id),
                    recid: it.id,
                    source: it.source,
                    itmcde: it.itmcde || '',
                    itmdsc: it.itmdsc || ''
                };
            });

            let byUid = new Map(rows.map(r => [r.uid, r]));

            let codeOptions = rows.map(r => ({ 
                id: r.uid,
                display: r.itmcde
            }));

            let descOptions = rows.map(r => ({ 
                id: r.uid, 
                display: r.itmdsc 
            }));

            let codeLabelToId = new Map(codeOptions.map(o => [o.display, o.id]));
            let descLabelToId = new Map(descOptions.map(o => [o.display, o.id]));

            // Helper: when we know the uid, fill ALL related fields
            function fillFrom(uid) {
                const r = byUid.get(String(uid));
                if (!r) return;

                // hidden fields (for form submit)
                $('#itemUid').val(r.uid);
                $('#itemSource').val(r.source);
                $('#itemId').val(r.recid);

                // visible fields
                $('#itemCode').val(r.itmcde);
                $('#itemDescription').val(r.itmdsc);
            }

            initAuto($('#itemCode'), $('#itemUid'), codeOptions, 'display', 'id', (row) => {
                fillFrom(row.id);
            });

            initAuto($('#itemDescription'), $('#itemDescriptionId'), descOptions, 'display', 'id', (row) => {
                fillFrom(row.id);
            });

            enforceValidPick($('#itemCode'),        $('#itemUid'),            codeLabelToId);
            enforceValidPick($('#itemDescription'), $('#itemDescriptionId'),  descLabelToId);

            $('#itemUid, #itemDescriptionId').on('change', function () {
                const uid = $(this).val();
                if (uid) fillFrom(uid);
            });
        });
    });

    function initAuto($input, $hidden, options, labelKey, idKey, onPick) {
        if (!$input.length || $input.data('ui-autocomplete')) return;

        // call your existing helper as-is
        autocomplete_field($input, $hidden, options, labelKey, idKey, function(row){
            if (typeof onPick === 'function') onPick(row);
        });

        // put the menu inside the modal so it isn't clipped
        try { $input.autocomplete('option', 'appendTo', '#popup_modal'); } catch (e) {}

        // open suggestions on focus
        $input.on('focus', function(){ $(this).autocomplete('search', ''); });

        // clear stale id if user types
        $input.on('input', function(){ $hidden.val(''); });
    }

    function enforceValidPick($input, $hidden, labelToIdMap) {
        $input.on('blur', function () {
            const label = $input.val().trim();
            const id = $hidden.val();
            // if label doesn't map to a known id OR id is empty/mismatched, clear both
            if (!labelToIdMap.has(label) || String(labelToIdMap.get(label)) !== String(id)) {
                $input.val('');
                $hidden.val('');
            }
        });
    }

    
    function get_data(query, field = "cl.id", order = "asc") {
        var url = "<?= base_url("cms/global_controller");?>";
        var data = {
            event : "list",
            select : `mp.id, mp.id AS main_pricelist_id,
                    mp.brand_id, brnd.brand_code AS brand_code, 
                    mp.brand_label_type_id, brlbltyp.label AS brand_label_type, 
                    mp.label_type_category_id, catlist.code AS catlist_code, 
                    mp.category_1_id, class.item_class_code AS labeltype_code,
                    mp.category_2_id, sclass.item_sub_class_code AS item_subclass, 
                    mp.category_3_id, idept.item_department_code AS item_department,
                    mp.category_4_id, mcat.item_mech_cat_code AS merchandise_cat,
                    mp.item_code, mp.item_description,
                    mp.cust_item_code, mp.uom, 
                    mp.item_code,
                    mp.item_description,
                    mp.status, mp.updated_date, mp.created_date,
                    COALESCE(cp.selling_price, mp.selling_price) AS selling_price,
                    COALESCE(cp.disc_in_percent, mp.disc_in_percent) AS disc_in_percent,
                    COALESCE(cp.net_price, mp.net_price) AS net_price,
                    COALESCE(cp.effectivity_date, mp.effectivity_date) AS effectivity_date,
                    IF(cp.id IS NOT NULL, 1, 0) AS is_customer_override`,
            query : query,
            offset : offset,
            limit : limit,
            table : "tbl_main_pricelist mp",
            order : {
                field : field,
                order : order 
            },
            join : [
                {
                    table: "tbl_customer_list cl",
                    query: "mp.pricelist_id = cl.pricelist_id",
                    type: "inner"
                },
                {
                    table: "tbl_customer_pricelist cp",
                    query: "cp.customer_id = cl.id AND cp.main_pricelist_id = mp.id",
                    type: "left"
                },
                {
                    table: "tbl_brand brnd",
                    query: "brnd.id = mp.brand_id",
                    type: "left"
                },
                {
                    table: "tbl_label_category_list catlist",
                    query: "catlist.id = mp.label_type_category_id",
                    type: "left"
                },
                {
                    table: "tbl_classification class",
                    query: "class.id = mp.category_1_id",
                    type: "left"
                },
                {
                    table: "tbl_brand_label_type brlbltyp",
                    query: "brlbltyp.id = mp.brand_label_type_id",
                    type: "left"
                },
                {
                    table: "tbl_sub_classification sclass",
                    query: "sclass.id = mp.category_2_id",
                    type: "left"
                },
                {
                    table: "tbl_item_department idept",
                    query: "idept.id = mp.category_3_id",
                    type: "left"
                },
                {
                    table: "tbl_item_merchandise_category mcat",
                    query: "mcat.id = mp.category_4_id",
                    type: "left"
                }
            ]
        }

        aJax.post(url,data,function(result){
            var result = JSON.parse(result);
            var html = '';
            if(result) {
                if (result.length > 0) {
                    $.each(result, function(x,y) {
                        var status = ( parseInt(y.status) === 1 ) ? status = "Active" : status = "Inactive";
                        var rowClass = (x % 2 === 0) ? "even-row" : "odd-row";

                        html += "<tr class='" + rowClass + "'>";
                        html += "<td class='center-content' style='width: 5%'><input class='select' type=checkbox data-id="+y.id+" onchange=checkbox_check()></td>";
                        html += "<td scope=\"col\">" + y.brand_code + "</td>";
                        html += "<td scope=\"col\">" + y.brand_label_type, 10 + "</td>";
                        html += "<td scope=\"col\">" + y.catlist_code + "</td>";
                        html += "<td scope=\"col\">" + y.labeltype_code + "</td>";
                        html += "<td scope=\"col\">" + y.item_subclass + "</td>";
                        html += "<td scope=\"col\">" + y.item_department + "</td>";
                        html += "<td scope=\"col\">" + y.merchandise_cat + "</td>";
                        html += "<td scope=\"col\">" + y.item_code + "</td>";
                        html += "<td scope=\"col\">" + y.item_description + "</td>";
                        html += "<td scope=\"col\">" + y.cust_item_code + "</td>";
                        html += "<td scope=\"col\">" + y.uom + "</td>";
                        html += "<td scope=\"col\">" + y.selling_price + "</td>";
                        html += "<td scope=\"col\">" + y.disc_in_percent + "</td>";
                        html += "<td scope=\"col\">" + y.net_price + "</td>";
                        html += "<td scope=\"col\">" + y.effectivity_date + "</td>";
                        html += "<td scope=\"col\">" +status+ "</td>";
                        html += "<td class='center-content' scope=\"col\">" + (y.created_date ? ViewDateformat(y.created_date) : "N/A") + "</td>";
                        html += "<td class='center-content' scope=\"col\">" + (y.updated_date ? ViewDateformat(y.updated_date) : "N/A") + "</td>";

                        if (y.id == 0) {
                            html += "<td><span class='glyphicon glyphicon-pencil'></span></td>";
                        } else {
                          html+="<td class='center-content' scope=\"col\">";
                          html+="<a class='btn-sm btn save' onclick=\"edit_data('"+y.id+"')\" data-status='"
                            +y.status+"' id='"+y.id+"' title='Edit Details'><span class='glyphicon glyphicon-pencil'>Edit</span>";
                          html+="<a class='btn-sm btn view' onclick=\"view_data('"+y.id+"')\" data-status='"
                            +y.status+"' id='"+y.id+"' title='Show Details'><span class='glyphicon glyphicon-pencil'>View</span>";
                          html+="<a class='btn-sm btn view' onclick=\"view_historical_data('"+y.id+"')\" data-status='"
                          +y.status+"' id='"+y.id+"' title='Show Historical'><span class='glyphicon glyphicon-pencil'>Historical</span>";
                          html+="</td>";
                        }
                        
                        
                        html += "</tr>";   
                    });
                } else {
                    html = '<tr><td colspan=20 class="center-align-format">'+ no_records +'</td></tr>';
                }
            }
            $('.table_body').html(html);
        });
    }

    function get_pagination(query, field = "cl.id", order = "asc") {
        var url = "<?= base_url("cms/global_controller");?>";
        var data = {
            event : "list",
            select : `mp.id, mp.id AS main_pricelist_id,
                    mp.brand_id, brnd.brand_code AS brand_code, 
                    mp.brand_label_type_id, brlbltyp.label AS brand_label_type, 
                    mp.label_type_category_id, catlist.code AS catlist_code, 
                    mp.category_1_id, class.item_class_code AS labeltype_code,
                    mp.category_2_id, sclass.item_sub_class_code AS item_subclass, 
                    mp.category_3_id, idept.item_department_code AS item_department,
                    mp.category_4_id, mcat.item_mech_cat_code AS merchandise_cat,
                    mp.item_code, mp.item_description,
                    mp.cust_item_code, mp.uom, 
                    mp.item_code,
                    mp.item_description,
                    mp.status, mp.updated_date, mp.created_date,
                    COALESCE(cp.selling_price, mp.selling_price) AS selling_price,
                    COALESCE(cp.disc_in_percent, mp.disc_in_percent) AS disc_in_percent,
                    COALESCE(cp.net_price, mp.net_price) AS net_price,
                    COALESCE(cp.effectivity_date, mp.effectivity_date) AS effectivity_date,
                    IF(cp.id IS NOT NULL, 1, 0) AS is_customer_override`,
            query : query,
            offset : offset,
            limit : limit,
            table : "tbl_main_pricelist mp",
            order : {
                field : field,
                order : order 
            },
            join : [
                {
                    table: "tbl_customer_list cl",
                    query: "mp.pricelist_id = cl.pricelist_id",
                    type: "inner"
                },
                {
                    table: "tbl_customer_pricelist cp",
                    query: "cp.customer_id = cl.id AND cp.main_pricelist_id = mp.id",
                    type: "left"
                },
                {
                    table: "tbl_brand brnd",
                    query: "brnd.id = mp.brand_id",
                    type: "left"
                },
                {
                    table: "tbl_label_category_list catlist",
                    query: "catlist.id = mp.label_type_category_id",
                    type: "left"
                },
                {
                    table: "tbl_classification class",
                    query: "class.id = mp.category_1_id",
                    type: "left"
                },
                {
                    table: "tbl_brand_label_type brlbltyp",
                    query: "brlbltyp.id = mp.brand_label_type_id",
                    type: "left"
                },
                {
                    table: "tbl_sub_classification sclass",
                    query: "sclass.id = mp.category_2_id",
                    type: "left"
                },
                {
                    table: "tbl_item_department idept",
                    query: "idept.id = mp.category_3_id",
                    type: "left"
                },
                {
                    table: "tbl_item_merchandise_category mcat",
                    query: "mcat.id = mp.category_4_id",
                    type: "left"
                }
            ]
        }

        aJax.post(url,data,function(result){
            var obj = is_json(result);
            modal.loading(false);
            pagination.generate(obj.total_page, ".list_pagination", get_data);
        });
    }


    pagination.onchange(function(){
        offset = $(this).val();
        get_data(query, column_filter, order_filter);
        $('.selectall').prop('checked', false);
        $('.btn_status').hide();
    });


    $(document).on('keydown', '#search_query', function(event) {
        $('.btn_status').hide();
        $(".selectall").prop("checked", false);
        if (event.key == 'Enter') {
            search_input = $('#search_query').val();
            var escaped_keyword = search_input.replace(/'/g, "''"); 
            offset = 1;
            new_query = "mp.status >= 0 AND cl.id = "+customerId+" AND mp.pricelist_id = "+pricelistId;
            new_query += " AND (" +
                "brnd.brand_code LIKE '%" + escaped_keyword + "%' OR " +
                "brlbltyp.label LIKE '%" + escaped_keyword + "%' OR " +
                "catlist.code LIKE '%" + escaped_keyword + "%' OR " +
                "class.item_class_code LIKE '%" + escaped_keyword + "%' OR " +
                "sclass.item_sub_class_code LIKE '%" + escaped_keyword + "%' OR " +
                "idept.item_department_code LIKE '%" + escaped_keyword + "%' OR " +
                "mcat.item_mech_cat_code LIKE '%" + escaped_keyword + "%' OR " +
                "mp.item_code LIKE '%" + escaped_keyword + "%' OR " +
                "mp.item_description LIKE '%" + escaped_keyword + "%' OR " +
                "mp.cust_item_code LIKE '%" + escaped_keyword + "%'" +
                ")";

            get_data(new_query);
            get_pagination(new_query);
        }
    });

    $(document).on('click', '#search_button', function(event) {
        $('.btn_status').hide();
        $(".selectall").prop("checked", false);
        search_input = $('#search_query').val();
        var escaped_keyword = search_input.replace(/'/g, "''"); 
        offset = 1;
        new_query = "pl.status >= 0 AND pl.customer_id = " + pricelistId;
        new_query += " AND (" +
                "brnd.brand_code LIKE '%" + escaped_keyword + "%' OR " +
                "brlbltyp.label LIKE '%" + escaped_keyword + "%' OR " +
                "catlist.code LIKE '%" + escaped_keyword + "%' OR " +
                "class.item_class_code LIKE '%" + escaped_keyword + "%' OR " +
                "sclass.item_sub_class_code LIKE '%" + escaped_keyword + "%' OR " +
                "idept.item_department_code LIKE '%" + escaped_keyword + "%' OR " +
                "mcat.item_mech_cat_code LIKE '%" + escaped_keyword + "%' OR " +
                "pl.item_code LIKE '%" + escaped_keyword + "%' OR " +
                "pl.item_description LIKE '%" + escaped_keyword + "%' OR " +
                "pl.cust_item_code LIKE '%" + escaped_keyword + "%'" +
                ")";
        get_data(new_query);
        get_pagination(new_query);
    });
    
    $(document).on("change", ".record-entries", function(e) {
        $(".record-entries option").removeAttr("selected");
        $(".record-entries").val($(this).val());
        $(".record-entries option:selected").attr("selected","selected");
        var record_entries = $(this).prop( "selected",true ).val();
        limit = parseInt(record_entries);
        offset = 1;
        modal.loading(true); 
        get_data(query);
        get_pagination(query);
        modal.loading(false);
    });

    $('#btn_add').on('click', function() {
        open_modal('Add Customer Details Pricelist', 'add', '');
    });

    function edit_data(id) {
        open_modal('Edit Customer Details Pricelist', 'edit', id);
    }

    function view_data(id) {
        open_modal('View Customer Details Pricelist', 'view', id);
    }

    function open_modal(msg, actions, id) {
        window.lastFocusedElement = document.activeElement;
        $(".form-control").css('border-color','#ccc');
        $(".validate_error_message").remove();
        let $modal = $('#popup_modal');
        let $footer = $modal.find('.modal-footer');
        let $contentWrapper = $('.content-wrapper');

        $modal.find('.modal-title b').html(addNbsp(msg));
        reset_modal_fields();

        if (actions === 'add') {
            const $uom = $("#uom");
            if ($uom.length && !$uom.val().trim()) {
                $uom.val("PCS").trigger("change");
            }
        }

        let buttons = {
            save: create_button('Save', 'save_data', 'btn save', function () {
                if (validate.standard("form-modal")) {
                    if (!validate.numbersonly_optional(".numbersonly")) {
                        return; // stop saving
                    }
                    save_data('save', null);
                }
            }),
            edit: create_button('Update', 'edit_data', 'btn update', function () {
                if (validate.standard("form-modal")) {
                    save_data('update', id);
                }
            }),
            close: create_button('Close', 'close_data', 'btn caution', function () {
                $modal.modal('hide');
            })
        };

        if (['edit', 'view'].includes(actions)) populate_modal(id);

        const viewLock = [
            '#brand', '#brandLabelType', '#labelTypeCat',
            '#catOne', '#catTwo', '#catThree', '#catFour',
            '#itemCode', '#itemDescription', '#customerItemCode',
            '#uom', '#sellingPrice', '#discountInPercent',
            '#netPrice', '#effectDate', '#status'
        ];

        const editLock = [
            '#brand', '#brandLabelType', '#labelTypeCat',
            '#catOne', '#catTwo', '#catThree', '#catFour',
            '#itemCode', '#itemDescription', '#customerItemCode',
            '#uom', '#sellingPrice', '#netPrice', '#status'
        ];

        const allFields = Array.from(new Set([...viewLock, ...editLock]));
        set_field_state(allFields.join(','), false);

        if (actions === 'view') {
            set_field_state(viewLock.join(','), true);
        } else if (actions === 'edit') {
            set_field_state(editLock.join(','), true);
        } else {
        // 'add' or anything else → ensure everything is enabled
            set_field_state(viewLock.join(','), false);
        }

        $footer.empty();
        if (actions === 'add') $footer.append(buttons.save);
        if (actions === 'edit') $footer.append(buttons.edit);
        $footer.append(buttons.close);

        $modal.modal('show');

        $modal.off('shown.bs.modal').on('shown.bs.modal', function () {
        $contentWrapper.attr('inert', '');
        $(this).find('input, textarea, button, select').filter(':visible:first').focus();
        });

        $modal.off('hidden.bs.modal').on('hidden.bs.modal', function () {
            $contentWrapper.removeAttr('inert');
            if (window.lastFocusedElement) window.lastFocusedElement.focus();
        });
    }

    function reset_modal_fields() {
        const idsToClear = [
            'brand','brandId',
            'brandLabelType','brandLabelTypeId',
            'labelTypeCat','labelTypeCatId',
            'catOne','catOneId',
            'catTwo','catTwoId',
            'catThree','catThreeId',
            'catFour','catFourId',
            'itemCode','itemDescription','itemDescriptionId',
            'customerItemCode','uom',
            'sellingPrice','discountInPercent','netPrice',
            'effectDate',
            'itemUid','itemSource','itemId'
            // NOTE: intentionally NOT clearing 'customerId' and 'pricelistId'
        ];

        const sel = idsToClear.map(id => `#popup_modal #${id}`).join(', ');
        $(sel).val('');

        $('#popup_modal #status').prop('checked', true);
    }

    function set_field_state(selector, isReadOnly) {
        $(selector).prop({ readonly: isReadOnly, disabled: isReadOnly });
    }


    function create_button(btn_txt, btn_id, btn_class, onclick_event) {
        var new_btn = $('<button>', {
            text: btn_txt,
            id: btn_id,
            class: btn_class,
            click: onclick_event
        });
        return new_btn;
    }

    function fetchCurrentPricelistRowByKey(customerId, mainPricelistId, itemCode, cb) {
        const done = (typeof cb === 'function') ? cb : function () {};
        if (!customerId || !mainPricelistId || !itemCode) return done(null);

        const query = `customer_id = '${customerId}' AND main_pricelist_id = '${mainPricelistId}' AND item_code = '${itemCode}'`;

        aJax.post(url, {
            event: "list",
            table: "tbl_customer_pricelist",
            select: "id, selling_price, disc_in_percent, net_price, effectivity_date",
            query: query,
            limit: 1
        }, function (res) {
            const obj = is_json(res);
            if (!obj || obj.error) return done(null);

            const rows = Array.isArray(obj) ? obj : (Array.isArray(obj.data) ? obj.data : []);
            const row  = rows.length ? rows[0] : null;
            done(row);
        });
    }

    function stashHistoryIfNeeded(customerId, mainPricelistId, itemCode, newVals, next) {
        const proceed = (typeof next === 'function') ? next : function() {};

        fetchCurrentPricelistRowByKey(customerId, mainPricelistId, itemCode, function (currentRow) {
            if (!currentRow) return proceed(true);

            const oldVals = {
                selling_price: currentRow.selling_price,
                disc_in_percent: currentRow.disc_in_percent,
                net_price: currentRow.net_price,
                effectivity_date: currentRow.effectivity_date
            };

            const compareVals = {
                selling_price: newVals.selling_price,
                disc_in_percent: newVals.disc_in_percent,
                net_price: newVals.net_price,
                effectivity_date: newVals.effectivity_date
            };

            const changed = ['selling_price', 'disc_in_percent', 'net_price', 'effectivity_date']
                .some(k => oldVals[k] !== compareVals[k]);

            if (!changed) return proceed(false);

            const paymentGroup = $('#paymentGroup').val();
            const historyRow = {
                pricelist_id: pricelistId,
                customer_id: currentRow.id,
                customer_payment_group: paymentGroup,
                selling_price: oldVals.selling_price,
                disc_in_percent: oldVals.disc_in_percent,
                net_price: oldVals.net_price,
                effectivity_date: oldVals.effectivity_date,
                created_date: formatDate(new Date()),
                created_by: user_id
            };

            aJax.post(url, {
                event: "insert",
                table: "tbl_historical_sub_pricelist",
                data: historyRow
            }, function (insRes) {
                const ins = is_json(insRes);
                if (!ins || ins.error) console.error('History insert failed:', insRes);
                proceed(true);
            });
        });
    }


    function save_data(action, id) {
        var customerId = $('#customerId').val();
        var pricelistId = $('#pricelistId').val();
        var paymentGroup = $('#paymentGroup').val();
        var mainPricelistId = $('#mainPricelistId').val();
        var brand = $('#brandId').val().trim();
        var brandLabelType = $('#brandLabelTypeId').val().trim();
        var labelTypeCat = $('#labelTypeCatId').val().trim();
        var catOneId = $('#catOneId').val().trim();
        var catTwo = $('#catTwoId').val().trim();
        var catThree = $('#catThreeId').val().trim();
        var catFour = $('#catFourId').val().trim();
        var itemCode = $('#itemCode').val().trim();
        var itemDescription = $('#itemDescription').val().trim();
        var customerItemCode = $('#customerItemCode').val().trim();
        var uom = $('#uom').val().trim();
        var sellingPrice = $('#sellingPrice').val().trim();
        var discountInPercent = $('#discountInPercent').val().trim();
        var netPrice = $('#netPrice').val().trim();
        var effectDate = $('#effectDate').val().trim();
        var chk_status = $('#status').prop('checked');
        
        if (chk_status) {
            status_val = 1;
        } else {
            status_val = 0;
        }
        
        modal.confirm(confirm_update_message, function(result){
            if(result){ 
                modal.loading(true);
                
                const newValsForCompare = {
                    selling_price: sellingPrice,
                    disc_in_percent: discountInPercent,
                    net_price: netPrice,
                    effectivity_date: effectDate
                };

                stashHistoryIfNeeded(customerId, mainPricelistId, itemCode, newValsForCompare, function (shouldSave) {
                    if (shouldSave) {
                        save_to_db(customerId, pricelistId, paymentGroup, brand, brandLabelType, labelTypeCat, catOneId, catTwo, catThree, catFour, itemCode, itemDescription, customerItemCode, uom, sellingPrice, discountInPercent, netPrice, effectDate,status_val, id);
                    } else {
                        modal.loading(false);
                        modal.alert('No changes detected, nothing to save.', 'info');
                    }
                });
            }
        });
    }

    function save_to_db(customerId, pricelistId, paymentGroup, brand, brandLabelType, labelTypeCat, catOneId, catTwo, catThree, catFour, itemCode, itemDescription, customerItemCode, uom, sellingPrice, discountInPercent, netPrice, effectDate, status_val, id) {
        const url = "<?= base_url('cms/global_controller'); ?>";
        let data = {}; 
        let modal_alert_success;
        const now = new Date();
        const start_time = now;
        let valid_data = [];

        mainPricelistId = $('#mainPricelistId').val();

        modal_alert_success = success_update_message;
        const updated_data = {
            customer_id: customerId,
            pricelist_id: pricelistId,
            main_pricelist_id: mainPricelistId,
            customer_payment_group: paymentGroup,
            brand_id: brand,
            brand_label_type_id: brandLabelType,
            label_type_category_id: labelTypeCat,
            category_1_id: catOneId,
            category_2_id: catTwo,
            category_3_id: catThree,
            category_4_id: catFour,
            item_code: itemCode,
            item_description: itemDescription,
            cust_item_code: customerItemCode,
            uom: uom,
            selling_price: sellingPrice,
            disc_in_percent: discountInPercent,
            net_price: netPrice,
            effectivity_date: effectDate,
            created_date: formatDate(now),
            updated_date: formatDate(now),
            updated_by: user_id,
            created_by: user_id,
            updated_by: user_id,
            status: status_val
        };

        valid_data.push({
            module: "Customer Details Pricelist",
            action: "Update",
            remarks: "Updated Customer Details Pricelist",
            new_data: JSON.stringify(updated_data),
            old_data: ''
        });

        const key = {
            customer_id: customerId,
            main_pricelist_id: mainPricelistId,
            item_code: itemCode
        };

        data = {
            event: "upsert",
            table: "tbl_customer_pricelist",
            key: key,
            data: updated_data
        };

        aJax.post(url, data, function(result) {
            const obj = is_json(result);
            const end_time = new Date();
            const duration = formatDuration(start_time, end_time);
            modal.loading(false);
            modal.alert(modal_alert_success, 'success', function () {
                location.reload();
            });
        });
    }

    function populate_modal(inp_id) {
        field = "cl.id";
        order = "asc";
        var query = "mp.status > 0 and mp.id = " + inp_id;
        var url = "<?= base_url('cms/global_controller');?>";
        var data = {
            event : "list",
            select : `mp.id, mp.id AS main_pricelist_id,
                    mp.brand_id, brnd.brand_code AS brand_code, 
                    mp.brand_label_type_id, brlbltyp.label AS brand_label_type, 
                    mp.label_type_category_id, catlist.code AS catlist_code, 
                    mp.category_1_id, class.item_class_code AS labeltype_code,
                    mp.category_2_id, sclass.item_sub_class_code AS item_subclass, 
                    mp.category_3_id, idept.item_department_code AS item_department,
                    mp.category_4_id, mcat.item_mech_cat_code AS merchandise_cat,
                    mp.item_code, mp.item_description,
                    mp.cust_item_code, mp.uom, 
                    mp.item_code,
                    mp.item_description,
                    mp.brand_id,
                    mp.brand_label_type_id,
                    mp.label_type_category_id,
                    mp.category_1_id,
                    mp.category_2_id,
                    mp.category_3_id,
                    mp.category_4_id,
                    pm.description AS customer_payment_group,
                    mp.status, mp.updated_date, mp.created_date,
                    COALESCE(cp.selling_price, mp.selling_price) AS selling_price,
                    COALESCE(cp.disc_in_percent, mp.disc_in_percent) AS disc_in_percent,
                    COALESCE(cp.net_price, mp.net_price) AS net_price,
                    COALESCE(cp.effectivity_date, mp.effectivity_date) AS effectivity_date,
                    IF(cp.id IS NOT NULL, 1, 0) AS is_customer_override`,
            query : query,
            offset : offset,
            limit : limit,
            table : "tbl_main_pricelist mp",
            order : {
                field : field,
                order : order 
            },
            join : [
                {
                    table: "tbl_customer_list cl",
                    query: "mp.pricelist_id = cl.pricelist_id",
                    type: "inner"
                },
                {
                    table: "tbl_pricelist_masterfile pm",
                    query: "mp.customer_payment_group = pm.description",
                    type: "inner"
                },
                {
                    table: "tbl_customer_pricelist cp",
                    query: "cp.customer_id = cl.id AND cp.main_pricelist_id = mp.id",
                    type: "left"
                },
                {
                    table: "tbl_brand brnd",
                    query: "brnd.id = mp.brand_id",
                    type: "left"
                },
                {
                    table: "tbl_label_category_list catlist",
                    query: "catlist.id = mp.label_type_category_id",
                    type: "left"
                },
                {
                    table: "tbl_classification class",
                    query: "class.id = mp.category_1_id",
                    type: "left"
                },
                {
                    table: "tbl_brand_label_type brlbltyp",
                    query: "brlbltyp.id = mp.brand_label_type_id",
                    type: "left"
                },
                {
                    table: "tbl_sub_classification sclass",
                    query: "sclass.id = mp.category_2_id",
                    type: "left"
                },
                {
                    table: "tbl_item_department idept",
                    query: "idept.id = mp.category_3_id",
                    type: "left"
                },
                {
                    table: "tbl_item_merchandise_category mcat",
                    query: "mcat.id = mp.category_4_id",
                    type: "left"
                }
            ]
        }
        aJax.post(url,data,function(result){
            var obj = is_json(result);
            if(obj){
                $.each(obj, function(index,asc) {
                    $('#customerId').val(customerId);
                    $('#paymentGroup').val(asc.customer_payment_group);
                    $('#mainPricelistId').val(asc.main_pricelist_id);

                    $('#brand').val(asc.brand_code);
                    $('#brandId').val(asc.brand_id);

                    $('#brandLabelType').val(asc.brand_label_type);
                    $('#brandLabelTypeId').val(asc.brand_label_type_id)

                    $('#labelTypeCat').val(asc.catlist_code);
                    $('#labelTypeCatId').val(asc.label_type_category_id);

                    $('#catOne').val(asc.labeltype_code);
                    $('#catOneId').val(asc.category_1_id);

                    $('#catTwo').val(asc.item_subclass);
                    $('#catTwoId').val(asc.category_2_id);

                    $('#catThree').val(asc.item_department);
                    $('#catThreeId').val(asc.category_3_id);

                    $('#catFour').val(asc.merchandise_cat);
                    $('#catFourId').val(asc.category_4_id);

                    $('#itemCode').val(asc.item_code);
                    $('#itemDescription').val(asc.item_description);
                    $('#customerItemCode').val(asc.cust_item_code);
                    $('#uom').val(asc.uom);
                    $('#sellingPrice').val(asc.selling_price);
                    $('#discountInPercent').val(asc.disc_in_percent);
                    $('#netPrice').val(asc.net_price);
                    $('#effectDate').val(asc.effectivity_date);
                    if(asc.status == 1) {
                        $('#status').prop('checked', true)
                    } else {
                        $('#status').prop('checked', false)
                    }
                }); 
            }
        });
    }


    function download_template() {
        const headerData = [];

        formattedData = [
            {
                "Brand": "",
                "Brand Label Type": "",
                "Label Type Category": "",
                "Category 1 (Item Classification MF)": "",
                "Category 2 (Sub Classification MF)": "",
                "Category 3 (Department MF)": "",
                "Category 4 (Merch. Category MF)": "",
                "Item Code": "",
                "Item Description": "",
                "Customer Item Code": "",
                "UOM": "",
                "Selling Price": "",
                "Discount in Percent": "",
                "Effectivity Date": "",
                "Status": "",
                "NOTE:": "Please do not change the column headers."
            }
        ]

        exportArrayToCSV(formattedData, `Customer Details Pricelist - ${formatDate(new Date())}`, headerData);
    }

    $(document).on('click', '#btn_export', function () {
        modal.confirm(confirm_export_message,function(result){
            if (result) {
                modal.loading_progress(true, "Reviewing Data...");
                setTimeout(() => {
                    exportAgency()
                }, 500);
            }
        })
    })
   
   function exportArrayToCSV(data, filename, headerData) {
       const worksheet = XLSX.utils.json_to_sheet(data, { origin: headerData.length });
       XLSX.utils.sheet_add_aoa(worksheet, headerData, { origin: "A1" });
       const csvContent = XLSX.utils.sheet_to_csv(worksheet);
       const blob = new Blob([csvContent], { type: "text/csv;charset=utf-8;" });
       saveAs(blob, filename + ".csv");
   }

    let histCurrentPage   = 1;
    const HIST_PAGE_SIZE  = 10;
    let histLimit         = HIST_PAGE_SIZE;
    let histTotalRecords  = 0;
    let histTotalPages    = 1;

    function view_historical_data() {
        const $tbody = $('#historicalTbody');
        if ($tbody.length) $tbody.html('<tr><td colspan="4" style="text-align:center">Loading…</td></tr>');
        $('#historicalModal').modal('show');

        histCurrentPage = 1;
        runHistorical(pricelistId);
    }

    function runHistorical(plId) {
        const histOffset = histCurrentPage;
        renderHistorical(plId, histOffset, histLimit);
    }

    function renderHistorical(plId, histOffset, histLimit) {
        const $tbody  = $('#historicalTbody');
        const $footer = $('#historicalModal .modal-footer');

            var data = {
            event : "list",
            select : `id, pricelist_id, customer_id,
                    customer_payment_group, selling_price, disc_in_percent,
                    net_price, effectivity_date, created_date, created_by`,
            query  : `pricelist_id = '${plId}'`,
            offset : offset,
            limit : limit,
            table : "tbl_historical_sub_pricelist",
            order : {
                field : "effectivity_date",
                order : "desc" 
            },
        }

        aJax.post(url, data, function (result) {
            let parsed = {};
            try { parsed = (typeof result === 'string') ? JSON.parse(result) : result; }
            catch (e) { parsed = []; }

            const rows =
                Array.isArray(parsed?.list) ? parsed.list :
                Array.isArray(parsed?.data) ? parsed.data :
                Array.isArray(parsed)       ? parsed       :
                [];

            histTotalRecords = parsed?.pagination?.total_record ?? rows.length;
            histTotalPages   = Math.max(1, Math.ceil(histTotalRecords / histLimit));

            if (!rows.length) {
                $tbody.html('<tr><td colspan="4" style="text-align:center">No history found.</td></tr>');
            } else {
                const html = rows.map(r => `
                    <tr>
                    <td>${r.effectivity_date ?? ''}</td>
                    <td class="text-right">${r.selling_price ?? ''}</td>
                    <td class="text-right">${r.disc_in_percent ?? ''}</td>
                    <td class="text-right">${r.net_price ?? ''}</td>
                    </tr>
                `).join('');
                $tbody.html(html);
            }

            const footerHtml = `
            <div class="d-flex w-100 justify-content-between align-items-center">
                <div>Page ${histCurrentPage} of ${histTotalPages}</div>
                <div class="btn-group">
                    <button type="button" class="btn btn-warning" onclick="firstHistoricalPage('${plId}')" ${histCurrentPage === 1 ? 'disabled' : ''}>&laquo; First</button>
                    <button type="button" class="btn btn-warning" onclick="backHistoricalPage('${plId}')"  ${histCurrentPage <= 1 ? 'disabled' : ''}>&lsaquo; Prev</button>
                    <button type="button" class="btn btn-warning" onclick="nextHistoricalPage('${plId}')"  ${histCurrentPage >= histTotalPages ? 'disabled' : ''}>Next &rsaquo;</button>
                    <button type="button" class="btn btn-warning" onclick="lastHistoricalPage('${plId}')"  ${histCurrentPage === histTotalPages ? 'disabled' : ''}>Last &raquo;</button>
                </div>
            </div>
            `;
            $footer.html(footerHtml);
        });
    }

    function backHistoricalPage(plId) {
        if (histCurrentPage > 1) {
            histCurrentPage--;
            runHistorical(plId);
        }
    }

    function nextHistoricalPage(plId) {
        if (histCurrentPage < histTotalPages) {
            histCurrentPage++;
            runHistorical(plId);
        }
    }

    function firstHistoricalPage(plId) {
        histCurrentPage = 1;
        runHistorical(plId);
    }

    function lastHistoricalPage(plId) {
        histCurrentPage = histTotalPages;
        runHistorical(plId);
    }

</script>