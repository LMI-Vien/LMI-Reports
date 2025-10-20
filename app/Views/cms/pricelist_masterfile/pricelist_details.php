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
                <b>P R I C E L I S T &nbsp; D E T A I L S</b>
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
                        <input type="hidden" id="pricelistId">
                        <input type="hidden" id="paymentGroup">
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
                                    <input type="hidden" id="itemCodeId" name="itemCodeId">
                                </div>
                            </div>
                        </div>

                        <!-- Row 5: Item Description -->
                        <div class="form-row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="itemDescription" class="col-form-label">Item Description</label>
                                    <input type="text" id="itemDescription" name="itemDescription" class="form-control required">
                                    <input type="hidden" id="itemDescriptionId" name="itemDescriptionId">
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
                                    <input type="text" id="netPrice" name="netPrice" class="form-control required">
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="effectDate" class="col-form-label">Effectivity Date</label>
                                    <input type="date" id="effectDate" name="effectDate" class="form-control required no-past-date">
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

<script>
    var query = "pl.status >= 0";
    var column_filter = '';
    var order_filter = '';
    var limit = 10; 
    var user_id = '<?=$session->sess_uid;?>';
    var url = "<?= base_url("cms/global_controller");?>";
    var base_url = '<?= base_url();?>';
    var pricelistId = '<?= $pricelistId; ?>';
    var paymentGroup = '<?= $paymentGroup; ?>';
    //for importing
    let currentPage = 1;
    let rowsPerPage = 1000;
    let totalPages = 1;
    let dataset = [];

    $(document).ready(function() {
        var query = "pl.status >= 0 AND pl.pricelist_id = " + pricelistId;
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

            enforceValidPick($('#itemCode'),        $('#itemUid'),            codeLabelToId, clearItemPair);
            enforceValidPick($('#itemDescription'), $('#itemDescriptionId'),  descLabelToId, clearItemPair);

            $('#itemUid, #itemDescriptionId').on('change', function () {
                const uid = $(this).val();
                if (uid) fillFrom(uid);
            });
        });

        enforceNumeric('#sellingPrice, #discountInPercent', { decimals: 2 });
    });

    function clearItemPair() {
        $('#itemCode').val('');
        $('#itemDescription').val('');
        $('#itemUid').val('');
        $('#itemDescriptionId').val('');
        $('#itemSource').val('');
        $('#itemId').val('');
    }

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

    function enforceValidPick($input, $hidden, labelToIdMap, onInvalid) {
        $input.on('blur', function () {
            const label = $input.val().trim();
            const id = $hidden.val();
            const ok = labelToIdMap.has(label) && String(labelToIdMap.get(label)) === String(id);
            if (!ok) {
                $input.val('');
                $hidden.val('');
                if (typeof onInvalid === 'function') onInvalid(); 
            }
        });
    }


    function get_data(query, field = "pl.pricelist_id", order = "asc") {
        var url = "<?= base_url("cms/global_controller");?>";
        var data = {
            event : "list",
            select : `pl.id, pl.pricelist_id, 
                    pl.brand_id, brnd.brand_code AS brand_code, 
                    pl.brand_label_type_id, brlbltyp.label AS brand_label_type, 
                    pl.label_type_category_id, catlist.code AS catlist_code, 
                    pl.category_1_id, class.item_class_code AS labeltype_code,
                    pl.category_2_id, sclass.item_sub_class_code AS item_subclass, 
                    pl.category_3_id, idept.item_department_code AS item_department,
                    pl.category_4_id, mcat.item_mech_cat_code AS merchandise_cat,
                    pl.item_code, pl.item_description, 
                    pl.cust_item_code, pl.uom, 
                    pl.selling_price, pl.disc_in_percent, 
                    pl.net_price, pl.effectivity_date, 
                    pl.status, pl.updated_date, pl.created_date`,
            query : query,
            offset : offset,
            limit : limit,
            table : "tbl_main_pricelist pl",
            order : {
                field : field,
                order : order 
            },
            join : [
                {
                    table: "tbl_brand brnd",
                    query: "brnd.id = pl.brand_id",
                    type: "left"
                },
                {
                    table: "tbl_label_category_list catlist",
                    query: "catlist.id = pl.label_type_category_id",
                    type: "left"
                },
                {
                    table: "tbl_classification class",
                    query: "class.id = pl.category_1_id",
                    type: "left"
                },
                {
                    table: "tbl_brand_label_type brlbltyp",
                    query: "brlbltyp.id = pl.brand_label_type_id",
                    type: "left"
                },
                {
                    table: "tbl_sub_classification sclass",
                    query: "sclass.id = pl.category_2_id",
                    type: "left"
                },
                {
                    table: "tbl_item_department idept",
                    query: "idept.id = pl.category_3_id",
                    type: "left"
                },
                {
                    table: "tbl_item_merchandise_category mcat",
                    query: "mcat.id = pl.category_4_id",
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
                        html += "<td scope=\"col\">" + y.brand_label_type + "</td>";
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
                          html+="<a class='btn-sm btn delete' onclick=\"delete_data('"+y.id+"')\" data-status='"
                            +y.status+"' id='"+y.id+"' title='Delete Details'><span class='glyphicon glyphicon-pencil'>Delete</span>";
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

    function get_pagination(query, field = "pl.pricelist_id", order = "asc") {
        var url = "<?= base_url("cms/global_controller");?>";
        var data = {
            event : "pagination",
            select : `pl.id, pl.pricelist_id, 
                    pl.brand_id, brnd.brand_code AS brand_code, 
                    pl.brand_label_type_id, brlbltyp.label AS brand_label_type, 
                    pl.label_type_category_id, catlist.code AS catlist_code, 
                    pl.category_1_id, class.item_class_code AS labeltype_code,
                    pl.category_2_id, sclass.item_sub_class_code AS item_subclass, 
                    pl.category_3_id, idept.item_department_code AS item_department,
                    pl.category_4_id, mcat.item_mech_cat_code AS merchandise_cat,
                    pl.item_code, pl.item_description, 
                    pl.cust_item_code, pl.uom, 
                    pl.selling_price, pl.disc_in_percent, 
                    pl.net_price, pl.effectivity_date, 
                    pl.status, pl.updated_date, pl.created_date`,
            query : query,
            offset : offset,
            limit : limit,
            table : "tbl_main_pricelist pl",
            order : {
                field : field,
                order : order 
            },
            join : [
                {
                    table: "tbl_brand brnd",
                    query: "brnd.id = pl.brand_id",
                    type: "left"
                },
                {
                    table: "tbl_label_category_list catlist",
                    query: "catlist.id = pl.label_type_category_id",
                    type: "left"
                },
                {
                    table: "tbl_classification class",
                    query: "class.id = pl.category_1_id",
                    type: "left"
                },
                {
                    table: "tbl_brand_label_type brlbltyp",
                    query: "brlbltyp.id = pl.brand_label_type_id",
                    type: "left"
                },
                {
                    table: "tbl_sub_classification sclass",
                    query: "sclass.id = pl.category_2_id",
                    type: "left"
                },
                {
                    table: "tbl_item_department idept",
                    query: "idept.id = pl.category_3_id",
                    type: "left"
                },
                {
                    table: "tbl_item_merchandise_category mcat",
                    query: "mcat.id = pl.category_4_id",
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
            new_query = "pl.status >= 0 AND pl.pricelist_id = " + pricelistId;
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
        }
    });

    $(document).on('click', '#search_button', function(event) {
        $('.btn_status').hide();
        $(".selectall").prop("checked", false);
        search_input = $('#search_query').val();
        var escaped_keyword = search_input.replace(/'/g, "''"); 
        offset = 1;
        new_query = "pl.status >= 0 AND pl.pricelist_id = " + pricelistId;
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

    $('#btn_filter').on('click', function(event) {
        title = addNbsp('FILTER DATA');
        $('#filter_modal').find('.modal-title').find('b').html(title);
        $('#filter_modal').modal('show');
    })

    $('#button_f').on('click', function(event) {
        let status_f = $("input[name='status_f']:checked").val();
        let c_date_from = $("#created_date_from").val();
        let c_date_to = $("#created_date_to").val();
        let m_date_from = $("#modified_date_from").val();
        let m_date_to = $("#modified_date_to").val();
        
        order_filter = $("input[name='order']:checked").val();
        column_filter = $("input[name='column']:checked").val();
        query = "status >= 0";
        
        query += status_f ? ` AND status = ${status_f}` : '';
        query += c_date_from ? ` AND created_date >= '${c_date_from} 00:00:00'` : '';
        query += c_date_to ? ` AND created_date <= '${c_date_to} 23:59:59'` : '';
        query += m_date_from ? ` AND updated_date >= '${m_date_from} 00:00:00'` : '';
        query += m_date_to ? ` AND updated_date <= '${m_date_to} 23:59:59'` : '';
        
        get_data(query, column_filter, order_filter);
        get_pagination(query, column_filter, order_filter);
        $('#filter_modal').modal('hide');
    })
    
    $('#clear_f').on('click', function(event) {
        order_filter = '';
        column_filter = '';
        query = "status >= 0";
        get_data(query);
        get_pagination(query);
        
        $("input[name='status_f']").prop('checked', false);
        $("#created_date_from").val('');
        $('#created_date_to').val('');
        $('#modified_date_from').val('');
        $('#modified_date_to').val('');
        $("input[name='order']").prop('checked', false);
        $("input[name='column']").prop('checked', false);

        $('#filter_modal').modal('hide');
    })

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
        open_modal('Add Pricelist Details', 'add', '');
    });

    $('#btn_import').on('click', function() {
        title = addNbsp('IMPORT PRICELIST DETAILS')
        $("#import_modal").find('.modal-title').find('b').html(title)
        $("#import_modal").modal('show')
        clear_import_table()
    });

    function edit_data(id) {
        open_modal('Edit Pricelist Details', 'edit', id);
    }

    function view_data(id) {
        open_modal('View Pricelist Details', 'view', id);
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
        $('#pricelistId').val(pricelistId);
        $('#paymentGroup').val(paymentGroup);
        
        let isReadOnly = actions === 'view';
        set_field_state('#brand, #brandLabelType, #labelTypeCat, #catOne, #catTwo, #catThree, #catFour, #itemCode, #itemDescription, #customerItemCode, #sellingPrice, #discountInPercent, #effectDate, #status', isReadOnly);
        $('#netPrice, #uom').prop({ readonly: true, disabled: true });

        $footer.empty();
        if (actions === 'add') $footer.append(buttons.save);
        if (actions === 'edit') $footer.append(buttons.edit);
        $footer.append(buttons.close);

        $modal.modal('show');

        $modal.off('shown.bs.modal').on('shown.bs.modal', function () {
        // Disable background interaction
        $contentWrapper.attr('inert', '');

        // Now it's safe to focus inside the modal
        $(this).find('input, textarea, button, select').filter(':visible:first').focus();
        });

        $modal.off('hidden.bs.modal').on('hidden.bs.modal', function () {
            $contentWrapper.removeAttr('inert');
            if (window.lastFocusedElement) window.lastFocusedElement.focus();
        });
    }

    function reset_modal_fields() {
        const idsToClear = [
            'pricelistId', 'brand', 'brandId',
            'brandLabelType', 'brandLabelTypeId', 
            'labelTypeCat', 'labelTypeCatId',
            'catOne', 'catOneId',
            'catTwo', 'catTwoId',
            'catThree', 'catThreeId',
            'catFour', 'catFourId',
            'itemCode', 'itemCodeId',
            'itemDescription', 'itemDescriptionId',
            'customerItemCode', 'uom',
            'sellingPrice', 'discountInPercent',
            'netPrice', 'effectDate',
            'itemUid', 'itemSource', 'itemId'
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

    function fetchCurrentPricelistRow(id, cb) {
        const done = (typeof cb === 'function') ? cb : function () {};
        const safeId = parseInt(id, 10);
        if (isNaN(safeId)) return done(null);

        aJax.post(url, {
            event: "list",
            table: "tbl_main_pricelist",
            select: "id, selling_price, disc_in_percent, net_price, effectivity_date",
            query: `id = ${safeId}`,
            limit: 1
        }, function (res) {
            const obj = is_json(res);
            if (!obj || obj.error) return done(null);

            const rows = Array.isArray(obj) ? obj : (Array.isArray(obj.data) ? obj.data : []);
            const row  = rows.length ? rows[0] : null;
            done(row);
        });
    }

    function stashHistoryIfNeeded(id, newVals, next) {
        const proceed = (typeof next === 'function') ? next : function(){};
        fetchCurrentPricelistRow(id, function (currentRow) {
            if (!currentRow) return proceed();

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

            const changed = ['selling_price','disc_in_percent','net_price','effectivity_date']
                .some(k => oldVals[k] !== compareVals[k]);

            if (!changed) return proceed();
            const paymentGroup = $('#paymentGroup').val();
            const historyRow = {
                pricelist_id: pricelistId,
                main_pricelist_id: id,
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
                table: "tbl_historical_main_pricelist",
                data: historyRow
            }, function (insRes) {
                const ins = is_json(insRes);
                if (!ins || ins.error) console.error('History insert failed:', insRes);
                proceed();
            });
        });
    }

    function save_data(action, id) {
        //pricelistId = $('#pricelistId').val();
       // var paymentGroup = $('#paymentGroup').val();
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
        check_current_db("tbl_main_pricelist", ["pricelist_id", "item_code"], [pricelistId, itemCode], "status", "id", id, false,
            function (exists) {
                if (exists) {
                    modal.alert('Item Code already exists in this Pricelist.', 'warning');
                    return; 
                }

                if (id !== undefined && id !== null && id !== '') { 
                    modal.confirm(confirm_update_message, function(result){
                        if(result){ 
                            modal.loading(true);

                            const newValsForCompare = {
                                selling_price: sellingPrice,
                                disc_in_percent: discountInPercent,
                                net_price: netPrice,
                                effectivity_date: effectDate
                            };
                            
                            stashHistoryIfNeeded(id, newValsForCompare, function () {
                            save_to_db(
                                pricelistId, brand, brandLabelType, labelTypeCat, catOneId, catTwo, catThree, catFour,
                                itemCode, itemDescription, customerItemCode, uom, sellingPrice, discountInPercent,
                                netPrice, effectDate, status_val, id
                            );
                            });
                        }
                    });
                } else {
                    modal.confirm(confirm_add_message, function(result){
                        if(result){ 
                            modal.loading(true);
                            save_to_db(
                                pricelistId, brand, brandLabelType, labelTypeCat, catOneId, catTwo, catThree, catFour,
                                itemCode, itemDescription, customerItemCode, uom, sellingPrice, discountInPercent,
                                netPrice, effectDate, status_val, null
                            );
                        }
                    }); 
                }
            }
        );
    }

    function save_to_db(pricelistId, brand, brandLabelType, labelTypeCat, catOneId, catTwo, catThree, catFour, itemCode, itemDescription, customerItemCode, uom, sellingPrice, discountInPercent, netPrice, effectDate, status_val, id) {
        let data = {}; 
        let modal_alert_success;
        const now = new Date();
        const start_time = now;
        let valid_data = []; // to log into file

        if (id !== undefined && id !== null && id !== '') {
            modal_alert_success = success_update_message;
            const updated_data = {
                pricelist_id: pricelistId,
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
                updated_date: formatDate(now),
                updated_by: user_id,
                status: status_val
            };

            valid_data.push({
                module: "Pricelist Details",
                action: "Update",
                remarks: "Updated Pricelist Details",
                new_data: JSON.stringify(updated_data),
                old_data: ''
            });

            data = {
                event: "update",
                table: "tbl_main_pricelist",
                field: "id",
                where: id,
                data: updated_data
            };
        } else {
            modal_alert_success = success_save_message;
            const inserted_data = {
                pricelist_id: pricelistId,
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
                created_by: user_id,
                status: status_val
            };

            valid_data.push({
                module: "Pricelist Details",
                action: "Insert",
                remarks: "Inserted new Pricelist Details",
                new_data: JSON.stringify(inserted_data),
                old_data: ""
            });

            data = {
                event: "insert",
                table: "tbl_main_pricelist",
                data: inserted_data
            };
        }

        aJax.post(url, data, function(result) {
            const obj = is_json(result);
            const end_time = new Date();
            const duration = formatDuration(start_time, end_time);
            modal.loading(false);
            const conditions = {
                main_pricelist_id: id
            };
            total_delete(url, 'tbl_customer_pricelist', conditions);
            modal.alert(modal_alert_success, 'success', function () {
                location.reload();
            });
        });
    }


    function delete_data(id) {
        get_field_values('tbl_main_pricelist', 'pricelist_id', 'id', [id], function(res) {
            let code = res[id];
            message = is_json(confirm_delete_message);
            message.message = `Delete this from Pricelist Details?`;

            modal.confirm(JSON.stringify(message), function(result){
                if (result) {
                    proceed_delete(id);
                }
            });
        });
    }

    function proceed_delete(id) {
        var url = "<?= base_url('cms/global_controller');?>";
        var data = {
            event : "update",
            table : "tbl_main_pricelist",
            field : "id",
            where : id, 
            data : {
                    updated_date : formatDate(new Date()),
                    updated_by : user_id,
                    status : -2
            }  
        }
        aJax.post(url,data,function(result){
            var obj = is_json(result);
            modal.alert(success_delete_message, 'success', function() {
                location.reload();
            });
        }); 
    }
    
    function setOriginalNoPastDates() {
        $(".no-past-date").each(function () {
            var v = ($(this).val() || "").trim();
            $(this).data("original", v).attr("data-original", v);
        });
    }

    function populate_modal(inp_id) {
        var query = "pl.status >= 0 and pl.id = " + inp_id;
        var url = "<?= base_url('cms/global_controller');?>";
        var data = {
            event : "list", 
            select : `pl.id, pl.pricelist_id, 
                    pl.brand_id, brnd.brand_code AS brand_code, 
                    pl.brand_label_type_id, brlbltyp.label AS brand_label_type, 
                    pl.label_type_category_id, catlist.code AS catlist_code, 
                    pl.category_1_id, class.item_class_code AS labeltype_code,
                    pl.category_2_id, sclass.item_sub_class_code AS item_subclass, 
                    pl.category_3_id, idept.item_department_code AS item_department,
                    pl.category_4_id, mcat.item_mech_cat_code AS merchandise_cat,
                    pl.item_code, pl.item_description, 
                    pl.cust_item_code, pl.uom, 
                    pl.selling_price, pl.disc_in_percent, 
                    pl.net_price, pl.effectivity_date,
                    pm.description AS customer_payment_group,
                    pl.status, pl.updated_date, pl.created_date`,
            query : query, 
            table : "tbl_main_pricelist pl",
            order : {
                field : "pl.pricelist_id",
                order : "asc", 
            },
            join : [
                {
                    table: "tbl_pricelist_masterfile pm",
                    query: "pl.customer_payment_group = pm.description",
                    type: "inner"
                },
                {
                    table: "tbl_brand brnd",
                    query: "brnd.id = pl.brand_id",
                    type: "left"
                },
                {
                    table: "tbl_label_category_list catlist",
                    query: "catlist.id = pl.label_type_category_id",
                    type: "left"
                },
                {
                    table: "tbl_classification class",
                    query: "class.id = pl.category_1_id",
                    type: "left"
                },
                {
                    table: "tbl_brand_label_type brlbltyp",
                    query: "brlbltyp.id = pl.brand_label_type_id",
                    type: "left"
                },
                {
                    table: "tbl_sub_classification sclass",
                    query: "sclass.id = pl.category_2_id",
                    type: "left"
                },
                {
                    table: "tbl_item_department idept",
                    query: "idept.id = pl.category_3_id",
                    type: "left"
                },
                {
                    table: "tbl_item_merchandise_category mcat",
                    query: "mcat.id = pl.category_4_id",
                    type: "left"
                }
            ]
        }
        aJax.post(url,data,function(result){
            var obj = is_json(result);
            if(obj){
                $.each(obj, function(index,asc) {
                    $('#id').val(asc.id);

                    $('#brand').val(asc.brand_code);
                    $('#brandId').val(asc.brand_id);

                    $('#brandLabelType').val(asc.brand_label_type);
                    $('#brandLabelTypeId').val(asc.brand_label_type_id);

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

                setOriginalNoPastDates();
            }
        });
    }

    function clear_import_table() {
        $(".import_table").empty()
    }

    function process_xl_file() {
        let btn = $(".btn.save");
        if (btn.prop("disabled")) return; // Prevent multiple clicks

        btn.prop("disabled", true);
        $(".import_buttons").find("a.download-error-log").remove();

        if (dataset.length === 0) {
            modal.alert('No data to process. Please upload a file.', 'error', () => {});
            return;
        }

        modal.loading(true);

        let jsonData = dataset.map(row => {
            return {
                "Brand": row["Brand"] || "",
                "Brand Label Type": row["Brand Label Type"] || "",
                "Label Type Category": row["Label Type Category"] || "",
                "Category 1 (Item Classification MF)": row["Category 1 (Item Classification MF)"] || "",
                "Category 2 (Sub Classification MF)": row["Category 2 (Sub Classification MF)"] || "",
                "Category 3 (Department MF)": row["Category 3 (Department MF)"] || "",
                "Category 4 (Merch. Category MF)": row["Category 4 (Merch. Category MF)"] || "",
                "Item Code": row["Item Code"] || "",
                "Item Description": row["Item Description"] || "",
                "Customer Item Code": row["Customer Item Code"] || "",
                "UOM": row["UOM"] || "",
                "Selling Price": row["Selling Price"] || "",
                "Discount in Percent": row["Discount in Percent"] || "",
                "Effectivity Date": row["Effectivity Date"] || "",
                "Status": row["Status"] || "",
                "Created by": user_id || "", 
                "Created Date": formatDate(new Date()) || ""
            };
        });

        let worker = new Worker(base_url + "assets/cms/js/validator_pricelist_details.js");
        worker.postMessage({ data: jsonData, base_url: base_url, pricelistId, paymentGroup,});

        worker.onmessage = function(e) {
            modal.loading_progress(false);

            let { invalid, errorLogs, valid_data, err_counter } = e.data;
            if (invalid) {
                let errorMsg = err_counter > 1000 
                    ? '⚠️ Too many errors detected. Please download the error log for details.'
                    : errorLogs.join("<br>");
                modal.content('Validation Error', 'error', errorMsg, '600px', () => { 
                    read_xl_file();
                    btn.prop("disabled", false);
                });
                createErrorLogFile(errorLogs, "Error " + formatReadableDate(new Date(), true));
            } else if (valid_data && valid_data.length > 0) {
                btn.prop("disabled", false);
                updateSwalProgress("Validation Completed", 10);
                setTimeout(() => saveValidatedData(valid_data, paymentGroup), 500);
            } else {
                btn.prop("disabled", false);
                modal.alert("No valid data returned. Please check the file and try again.", "error", () => {});
            }
        };

        worker.onerror = function() {
            modal.alert("Error processing data. Please try again.", "error", () => {});
        };
    }

    function saveValidatedData(valid_data, paymentGroup) {
        const overallStart = new Date();
        let batch_size = 5000;
        let total_batches = Math.ceil(valid_data.length / batch_size);
        let batch_index = 0;
        let retry_count = 0;
        let max_retries = 5; 
        let errorLogs = [];
        let skipLogs = [];

        let url = "<?= base_url('cms/global_controller');?>";
        let table = 'tbl_main_pricelist';

        // IMPORTANT: we must fetch all fields needed to compare “identical”
        let selected_fields = [
            'id',
            'pricelist_id',
            'customer_payment_group',
            'brand_id',
            'brand_label_type_id',
            'label_type_category_id',
            'category_1_id',
            'category_2_id',
            'category_3_id',
            'category_4_id',
            'item_code',
            'item_description',
            'cust_item_code',
            'uom',
            'selling_price',
            'disc_in_percent',
            'net_price',
            'effectivity_date',
            'status'
        ];

        // Business fields we compare for “identical”
        const compareFields = [
            'brand_id',
            'brand_label_type_id',
            'label_type_category_id',
            'category_1_id',
            'category_2_id',
            'category_3_id',
            'category_4_id',
            'item_code',
            'item_description',
            'cust_item_code',
            'uom',
            'disc_in_percent',
            'selling_price',
            'net_price',
            'effectivity_date',
            'status',
            'pricelist_id',
            'customer_payment_group'
        ];

        function norm(v) {
            if (v === null || v === undefined) return '';
            return String(v).trim();
        }

        function isIdentical(a, b) {
            return compareFields.every(f => norm(a[f]) === norm(b[f]));
        }

        function updateOverallProgress(stepName, completed, total) {
            let progress = total > 0 ? Math.round((completed / total) * 100) : 100;
            updateSwalProgress(stepName, progress);
        }

        modal.loading_progress(true, "Validating and Saving data...");

        // Fetch existing records to build a map by pricelist_id|item_code
        aJax.post(url, {
            table: table,
            event: "fetch_existing",
            selected_fields: selected_fields
        }, function(response) {

            const result = JSON.parse(response);
            const allEntries = result.existing || [];

            // Keep only the same pricelist context
            const originalEntries = allEntries.filter(rec => rec.pricelist_id == pricelistId);
            const customerPaymentGroup = originalEntries.length > 0 ? originalEntries[0].customer_payment_group : null;
            // Map: key = `${pricelist_id}|${ITEMCODE}`
            const existingByCode = new Map();
            originalEntries.forEach(r => {
                if (r.status < 0) return;
                const key = `${r.pricelist_id}|${(r.item_code ?? '').toString().trim().toUpperCase()}`;
                existingByCode.set(key, r);
            });

            function processNextBatch() {
            if (batch_index >= total_batches) {
                modal.loading_progress(false);

                const overallEnd = new Date();
                const remarks = `Action: Import Pricelist Details
                    <br>Processed ${valid_data.length} records
                    <br>Errors: ${errorLogs.length}
                    <br>Skipped: ${skipLogs.length}
                    <br>Start: ${formatReadableDate(overallStart)}
                    <br>End: ${formatReadableDate(overallEnd)}
                    <br>Duration: ${formatDuration(overallStart, overallEnd)}`;

                    logActivity(
                    "import-pricelist-details-module",
                    "Import Batch",
                    remarks,
                    "-",
                    JSON.stringify(valid_data),
                    JSON.stringify(originalEntries)
                );

                if (errorLogs.length > 0 || skipLogs.length > 0) {
                    // Attach skip logs to error log file for user visibility
                    const combined = [...errorLogs, ...skipLogs];
                    createErrorLogFile(combined, "Update_Skip_Log_" + formatReadableDate(new Date(), true));
                    modal.alert("Some rows were skipped or encountered errors. Check the log.", 'info', () => {});
                } else {
                    modal.alert("All records processed successfully!", 'success', () => location.reload());
                }
                return;
            }

            let batch = valid_data.slice(batch_index * batch_size, (batch_index + 1) * batch_size);

            let newRecords = [];
            let updateRecords = [];

            batch.forEach(row => {
                // Ensure pricelist context
                row.pricelist_id = pricelistId;

                // Normalize incoming to DB-shape for comparison
                const itemCodeRaw = row.item_code ?? row["Item Code"] ?? '';
                const itemCode = itemCodeRaw.toString().trim();

                if (!itemCode) {
                skipLogs.push(`Skipped (no Item Code): ${JSON.stringify(row).slice(0, 200)}...`);
                return;
                }

                const incomingDB = {
                    brand_id: row.brand_id,
                    brand_label_type_id: row.brand_label_type_id,
                    label_type_category_id: row.label_type_category_id,
                    category_1_id: row.category_1_id,
                    category_2_id: row.category_2_id,
                    category_3_id: row.category_3_id,
                    category_4_id: row.category_4_id,
                    item_code: itemCode,
                    item_description: row.item_description ?? row["Item Description"],
                    cust_item_code: row.cust_item_code ?? row["Customer Item Code"],
                    uom: row.uom ?? row["UOM"],
                    selling_price: row.selling_price ?? row["Selling Price"],
                    disc_in_percent: row.disc_in_percent ?? row["Discount in Percent"],
                    net_price: row.net_price ?? row["Net Price"],
                    effectivity_date: row.effectivity_date ?? row["Effectivity Date"],
                    status: row.status ?? row["Status"],
                    pricelist_id: pricelistId,
                    customer_payment_group: customerPaymentGroup ?? paymentGroup  
                };

                const key = `${pricelistId}|${itemCode.toUpperCase()}`;
                const existing = existingByCode.get(key);

                if (existing) {
                // NEW RULE:
                // identical  -> UPDATE
                // different  -> SKIP
                if (isIdentical(existing, incomingDB)) {
                    const upd = {
                        ...incomingDB,
                        id: existing.id,
                        updated_date: formatDate(new Date())
                        // NOTE: do NOT set created_* here; preserve DB originals
                    };
                        updateRecords.push(upd);
                } else {
                    skipLogs.push(`Skipped (differs from existing): Item Code ${itemCode}`);
                }
                } else {
                // Not found -> INSERT
                const ins = {
                    ...incomingDB,
                    created_by: user_id,
                    created_date: formatDate(new Date())
                };
                    newRecords.push(ins);
                }
            });

            function processUpdates() {
                return new Promise((resolve) => {
                    if (updateRecords.length > 0) {
                        batch_update(url, updateRecords, "tbl_main_pricelist", "id", false, (response) => {
                        if (response.message !== 'success') {
                            errorLogs.push(`Failed to update: ${JSON.stringify(response.error)}`);
                        }
                        resolve();
                        });
                    } else {
                        resolve();
                    }
                });
            }

            function processInserts() {
                return new Promise((resolve) => {
                    if (newRecords.length > 0) {
                        batch_insert(url, newRecords, "tbl_main_pricelist", false, (response) => {
                        if (response.message === 'success') {
                            updateOverallProgress("Saving Pricelist Details...", batch_index + 1, total_batches);
                        } else {
                            errorLogs.push(`Batch insert failed: ${JSON.stringify(response.error)}`);
                        }
                        resolve();
                        });
                    } else {
                        resolve();
                    }
                });
            }

            function handleSaveError() {
                if (retry_count < max_retries) {
                retry_count++;
                let wait_time = Math.pow(2, retry_count) * 1000;
                setTimeout(() => {
                    processInserts()
                    .then(() => {
                        batch_index++;
                        retry_count = 0;
                        processNextBatch();
                    })
                    .catch(handleSaveError);
                }, wait_time);
                } else {
                modal.alert('Failed to save data after multiple attempts. Please check your connection and try again.', 'error', () => {});
                }
            }

            processUpdates()
                .then(processInserts)
                .then(() => {
                batch_index++;
                setTimeout(processNextBatch, 300);
                })
                .catch(handleSaveError);
            }

            setTimeout(processNextBatch, 1000);
        });
    }

    function read_xl_file() {
        let btn = $(".btn.save");
        btn.prop("disabled", false);
        clear_import_table();

        dataset = [];

        const file = $("#file")[0].files[0];
        if (!file) {
            modal.loading_progress(false);
            modal.alert('Please select a file to upload', 'error', () => {});
            return;
        }

        const maxFileSize = 30 * 1024 * 1024; // 30MB limit
        if (file.size > maxFileSize) {
            modal.loading_progress(false);
            modal.alert('The file size exceeds the 30MB limit. Please upload a smaller file.', 'error', () => {});
            return;
        }

        modal.loading_progress(true, "Reviewing Data...");

        const reader = new FileReader();
        reader.onload = function(e) {
            const data = e.target.result;
            const workbook = XLSX.read(data, { type: "binary", raw: true });
            const sheet = workbook.Sheets[workbook.SheetNames[0]];

            let jsonData = XLSX.utils.sheet_to_json(sheet, { raw: true });

            jsonData = jsonData.map(row => {
                let fixedRow = {};
                Object.keys(row).forEach(key => {
                    let value = row[key];
                    if (typeof value === "number") {
                        value = String(value);
                    }

                    fixedRow[key] = value !== null && value !== undefined ? value : "";
                });
                return fixedRow;
            });

            processInChunks(jsonData, 5000, () => {
                paginateData(rowsPerPage);
            });
        };

        reader.readAsBinaryString(file);

    }


    function processInChunks(data, chunkSize, callback) {
        let index = 0;
        let totalRecords = data.length;
        let totalProcessed = 0;

        function nextChunk() {
            if (index >= data.length) {
                modal.loading_progress(false);
                callback(); 
                return;
            }

            let chunk = data.slice(index, index + chunkSize);
            dataset = dataset.concat(chunk);
            totalProcessed += chunk.length; 
            index += chunkSize;

            let progress = Math.min(100, Math.round((totalProcessed / totalRecords) * 100));
            updateSwalProgress("Preview Data", progress);
            requestAnimationFrame(nextChunk);
        }
        nextChunk();
    }

    function paginateData(rowsPerPage) {
        totalPages = Math.ceil(dataset.length / rowsPerPage);
        currentPage = 1;
        display_imported_data();
    }

    function display_imported_data() {
        let start = (currentPage - 1) * rowsPerPage;
        let end = start + rowsPerPage;
        let paginatedData = dataset.slice(start, end);

        let html = '';
        let tr_counter = start;

        paginatedData.forEach(row => {
            let rowClass = (tr_counter % 2 === 0) ? "even-row" : "odd-row";
            html += `<tr class="${rowClass}">`;
            html += `<td>${tr_counter + 1}</td>`;

            let lowerCaseRecord = Object.keys(row).reduce((acc, key) => {
                acc[key.toLowerCase()] = row[key];
                return acc;
            }, {});

            // 
            let td_validator = ['brand', 'brand label type', 'label type category', 'category 1 (item classification mf)',
            'category 2 (sub classification mf)', 'category 3 (department mf)', 'category 4 (merch. category mf)',
            'item code', 'item description', 'customer item code', 'uom', 'selling price', 'discount in percent', 'effectivity date', 'status'];
            td_validator.forEach(column => {
                if (column === 'effectivity date') {
                    lowerCaseRecord[column] = excel_date_to_readable_date(lowerCaseRecord[column]);
                }
                html += `<td>${lowerCaseRecord[column] !== undefined ? lowerCaseRecord[column] : ""}</td>`;
            });

            html += "</tr>";
            tr_counter += 1;
        });

        modal.loading(false);
        $(".import_table").html(html);
        updatePaginationControls();
    }

    function updatePaginationControls() {
        let paginationHtml = `
            <button onclick="firstPage()" ${currentPage === 1 ? "disabled" : ""}><i class="fas fa-angle-double-left"></i></button>
            <button onclick="prevPage()" ${currentPage === 1 ? "disabled" : ""}><i class="fas fa-angle-left"></i></button>
            
            <select onchange="goToPage(this.value)">
                ${Array.from({ length: totalPages }, (_, i) => 
                    `<option value="${i + 1}" ${i + 1 === currentPage ? "selected" : ""}>Page ${i + 1}</option>`
                ).join('')}
            </select>
            
            <button onclick="nextPage()" ${currentPage === totalPages ? "disabled" : ""}><i class="fas fa-angle-right"></i></button>
            <button onclick="lastPage()" ${currentPage === totalPages ? "disabled" : ""}><i class="fas fa-angle-double-right"></i></button>
        `;

        $(".import_pagination").html(paginationHtml);
    }

    function createErrorLogFile(errorLogs, filename) {
        let errorText = errorLogs.join("\n");
        let blob = new Blob([errorText], { type: "text/plain" });
        let url = URL.createObjectURL(blob);

        $(".import_buttons").find("a.download-error-log").remove();

        let $downloadBtn = $("<a>", {
            href: url,
            download: filename+".txt",
            text: "Download Error Logs",
            class: "download-error-log",
            css: {
                border: "1px solid white",
                borderRadius: "10px",
                display: "inline-block",
                padding: "10px",
                lineHeight: 0.5,
                background: "#990000",
                color: "white",
                textAlign: "center",
                cursor: "pointer",
                textDecoration: "none",
                boxShadow: "6px 6px 15px rgba(0, 0, 0, 0.5)",
            }
        });

        $(".import_buttons").append($downloadBtn);
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

        exportArrayToCSV(formattedData, `Pricelist Details - ${formatDate(new Date())}`, headerData);
    }

    $(document).on('click', '#btn_export', function () {
        modal.confirm(confirm_export_message,function(result){
            if (result) {
                modal.loading_progress(true, "Reviewing Data...");
                setTimeout(() => {
                    exportPricelistDetails()
                }, 500);
            }
        })
    })

    const exportPricelistDetails = () => {
        var ids = [];

        $('.select:checked').each(function () {
            var id = $(this).attr('data-id');
            ids.push(`'${id}'`);
        });

        console.log(ids, 'ids');

        const params = new URLSearchParams();
        ids.length > 0 ? 
            params.append('selectedids', ids.join(',')) :
            params.append('selectedids', '0');

        window.open("<?= base_url('cms/');?>" + 'pricelist-masterfile/export-pricelist-details?'+ params.toString(), '_blank');
        modal.loading_progress(false);
   }
   
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
            select : `id, pricelist_id, main_pricelist_id,
                    customer_payment_group, selling_price, disc_in_percent,
                    net_price, effectivity_date, created_date, created_by`,
            query  : `pricelist_id = '${plId}'`,
            offset : offset,
            limit : limit,
            table : "tbl_historical_main_pricelist",
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