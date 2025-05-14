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
        overflow: visible !important;
        max-height: none !important;
        overflow-x: hidden !important;
        overflow-y: hidden !important;
    }

    .centered-form {
        background-color: #F7F7F7; 
        padding: 120px 100px 20px 100px; /* top, right, bottom, left */
        border-radius: 5px; 
        max-width: 1100px; 
        margin: 0 auto; 
    }

    .box {
        padding-top: 10px;
        position: relative;
        background-color: white; 
        padding: 20px; 
        border-radius: 5px; 
        max-width: 2000px; 
        margin: 0 auto 20px auto; 
        border-left: 5px solid orange;
        display: flex; 
        flex-direction: column; 
    }

    .form-group {
        margin-bottom: 15px; 
    }

    label {
        display: block; 
        margin-bottom: 5px; 
    }

    .syspar-label {
        color: brown;
    }

    .btn.save {
        background-color: #1565C0 !important;
        color: white !important; 
        border: none !important; 
        box-shadow: none !important;
        transition: background-color 0.3s !important; 
    }

    .btn.save:hover {
        background-color: #104d92 !important;
        color: white !important;
    }

    .btn.save:active,
    .btn.save:focus,
    .btn.save:focus-visible,
    .btn.save:visited {
        background-color: #1565C0 !important;
        color: white !important;
        box-shadow: none !important;
        outline: none !important;
        border-color: #1565C0 !important;
    }

    .container {
        margin-top: 10px; 
    }

    .form-title {
        margin-top: -110px; 
        margin-bottom: 20px;
    }

    .form-title-two {
        margin-top: 30px;
        margin-bottom: 20px;
    }

    .modal-footer {
        margin-top: 40px;
    }

    .expandable-textbox {
        width: 100%;              /* Adjust as needed */
        min-height: 38px;
        max-height: 200px;
        resize: none;
        overflow-y: auto;
        padding: 0.375rem 0.75rem;
        font-size: 1rem;
        line-height: 1.5;
        border: 1px solid #ced4da;
        border-radius: 0.25rem;
        background-color: #fff;
        box-shadow: inset 0 1px 1px rgba(0,0,0,0.075);
    }

</style>

<div class="content-wrapper p-4">
    <div class="card">
        <div class="text-center md-center">
            <b>S Y S T E M - P A R A M E T E R</b>
        </div>
        <div class="card-body">
            <form id="system-parameter-form" class="centered-form">
                <h4 class="form-title">System Parameters - SKU Settings</h4>
                <div class="box">
                    <div class="container">
                        <h5 class="syspar-label">Slow Moving SKUs</h5>
                        <div class="row mb-3">
                      
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="minimum" class="col-form-label">Minimum Weeks of No Sales</label>
                                    <input type="text" id="minimum" name="minimum" class="form-control numbersonly" placeholder="e.g. 20">
                                </div>
                            </div>

                        
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="maximum" class="col-form-label">Maximum Weeks of No Sales</label>
                                    <input type="text" id="maximum" name="maximum" class="form-control numbersonly" placeholder="e.g. 30">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="box">
                    <div class="container">
                        <h5 class="syspar-label">Overstock SKUs</h5>
                        <div class="row mb-3">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="overstock" class="col-form-label">Start Threshold (Weeks in Stock)</label>
                                    <input type="text" id="overstock" name="overstock" class="form-control numbersonly" placeholder="e.g. 31">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="box">
                    <div class="container">
                        <h5 class="syspar-label">New Item SKUs</h5>
                        <div class="row mb-3">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="newItem" class="col-form-label">Select Item Class to be display in New Item SKU's</label>
                                    <!-- <input type="text" id="newItem" name="newItem" class="form-control" placeholder="-- Select Class --"> -->
                                    <textarea id="newItem" name="newItem" class="form-control expandable-textbox" placeholder="-- Select Class --"></textarea>
                                    <input type="hidden" id="newItem_id">
                                    <input type="hidden" id="newItem_json" name="newItem_json">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="box">
                    <div class="container">
                        <h5 class="syspar-label">Hero SKUs</h5>
                        <div class="row mb-3">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="hero" class="col-form-label">Select Item Class to be display in Hero SKU's</label>
                                    <!-- <input type="text" id="hero" name="hero" class="form-control" placeholder="-- Select Class --"> -->
                                    <textarea id="hero" name="hero" class="form-control expandable-textbox" placeholder="-- Select Class --"></textarea>
                                    <input type="hidden" id="hero_id">
                                    <input type="hidden" id="hero_json" name="hero_json">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <h4 class="form-title-two">System Parameters - Sales Settings</h4>
                <div class="box">
                    <div class="container">
                        <h5 class="syspar-label">Sales Incentive</h5>
                        <div class="row mb-3">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="sales_incentives" class="col-form-label">Incentive Percentage (%)</label>
                                    <input type="text" id="sales_incentives" name="sales_incentives" class="form-control numbersonly" placeholder="e.g. 5">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <h4 class="form-title-two">System Parameters - Others</h4>
                <div class="box">
                    <div class="container">
                        <h5 class="syspar-label">Payment Group / Price Code File</h5>
                        <div class="row mb-3">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="payment_grp_lmi" class="col-form-label">Customer Group Code / Price Code (LMI)</label>
                                    <!-- <input type="text" id="payment_grp_lmi" name="payment_grp_lmi" class="form-control" placeholder="e.g. LMI"> -->
                                    <textarea id="payment_grp_lmi" name="payment_grp_lmi" class="form-control expandable-textbox" placeholder="e.g. LMI"></textarea>
                                    <input type="hidden" id="payment_grp_lmi_id">
                                    <input type="hidden" id="payment_grp_lmi_json" name="payment_grp_lmi_json">
                                </div>
                            </div>

                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="payment_grp_rgdi" class="col-form-label">Customer Group Code / Price Code (RGDI)</label>
                                    <!-- <input type="text" id="payment_grp_rgdi" name="payment_grp_rgdi" class="form-control" placeholder="e.g. RGDI"> -->
                                    <textarea id="payment_grp_rgdi" name="payment_grp_rgdi" class="form-control expandable-textbox" placeholder="e.g. RGDI"></textarea>
                                    <input type="hidden" id="payment_grp_rgdi_id">
                                    <input type="hidden" id="payment_grp_rgdi_json" name="payment_grp_rgdi_json">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <h4 class="form-title-two">System Parameters - Item File</h4>
                <div class="box">
                    <div class="container">
                        <h5 class="syspar-label">Brand Code</h5>
                        <div class="row mb-3">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="brand_included" class="col-form-label">Included</label>
                                    <!-- <input type="text" id="brand_included" name="brand_included" class="form-control" placeholder="Inventory"> -->
                                    <textarea id="brand_included" name="brand_included" class="form-control expandable-textbox" placeholder="Inventory"></textarea>
                                    <input type="hidden" id="brand_included_id">
                                    <input type="hidden" id="brand_included_json" name="brand_included_json">
                                </div>
                            </div>

                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="brand_excluded" class="col-form-label">Excluded</label>
                                    <!-- <input type="text" id="brand_excluded" name="brand_excluded" class="form-control" placeholder="Inventory"> -->
                                    <textarea id="brand_excluded" name="brand_excluded" class="form-control expandable-textbox" placeholder="Inventory"></textarea>
                                    <input type="hidden" id="brand_excluded_id">
                                    <input type="hidden" id="brand_excluded_json" name="brand_excluded_json">
                                </div>
                            </div>

                        </div>
                    </div>
                </div>

                <h4 class="form-title-two">System Parameters - Scanned Data</h4>
                <div class="box">
                    <div class="container">
                        <h5 class="syspar-label">Brand Level Type</h5>
                        <div class="row mb-3">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="brandLabelType" class="col-form-label">Select Label Type (Brand Label Type Masterfile)</label>
                                    <textarea id="brandLabelType" name="brandLabelType" class="form-control expandable-textbox" placeholder="e.g. Exclusive"></textarea>
                                    <input type="hidden" id="brandLabelTypeId">
                                    <input type="hidden" id="brandLabelTypeJson" name="brandLabelTypeJson">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <h4 class="form-title-two">System Parameters - Brand Ambassador (Consign)</h4>
                <div class="box">
                    <div class="container">
                        <h5 class="syspar-label">Target per Brand Ambassador</h5>
                        <div class="row mb-3">
                      
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="amountPerBa" class="col-form-label">Amount per Brand Ambassador</label>
                                    <input type="text" id="amountPerBa" name="amountPerBa" class="form-control numbersdecimalonly" placeholder="e.g. 8,000">
                                </div>
                            </div>

                        
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="numOfDays" class="col-form-label">No. of Days</label>
                                    <input type="text" id="numOfDays" name="numOfDays" class="form-control numbersonly" placeholder="e.g. 26">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <input type="hidden" id="id" name="id" value="">
                

                <div class="modal-footer">
                    <button type="button" class="btn save" onclick="save_data()">Save Settings</button>
                </div>
            </form>
        </div>
    </div>
</div>



<script>
    var query = "status >= 0";
    var url = "<?= base_url('cms/global_controller');?>";
    var limit = 10;
    var user_id = '<?=$session->sess_uid;?>';

    let selectedHeroItems = [];
    let selectedNewItems = [];
    let selectedBrandExcluded = [];
    let selectedBrandIncluded = [];
    let selectedBrandLabelType = [];
    // let selectedLMI = [];
    // let selectedRGDI = [];
    
    $(document).ready(function() {
        get_data(query);

        let hero = <?= json_encode($hero); ?>;
        let newItem = <?= json_encode($newItem); ?>;
        let brandExcluded = <?= json_encode($brandExcluded); ?>;
        let brandIncluded = <?= json_encode($brandIncluded); ?>;
        let brandLabelTypeOptions = <?= json_encode($brandLabelTypeOptions); ?>;
        
        autocomplete_field_multi($("#newItem"), $("#newItem_id"), newItem, "item_class_description", "id", function(result) {
            let data = {
                event: "list",
                query: "id = " + result.id,
                select: "id, item_class_description",
                offset: offset,
                limit: 0,
                table: "tbl_item_class",
            };

            aJax.post(base_url + "cms/global_controller", data, function(res) {
                let newItem_desc = JSON.parse(res);
                let newItem_obj = newItem_desc[0];

                addNewItem(newItem_obj);

                $("#newItem").val(selectedNewItems.map(item => item.item_class_description).join(", ") + (selectedNewItems.length > 0 ? ", " : ""));
                adjustTextareaHeight($("#newItem")[0]);
                $("#newItem_json").val(JSON.stringify(selectedNewItems));
            });
        }, {
            focus: function() {
                return false;
            },
            select: function(event, ui) {
                let item = {
                    id: ui.item.info.id,
                    item_class_description: ui.item.info.item_class_description
                };

                addNewItem(item);

                $("#newItem").val(selectedNewItems.map(item => item.item_class_description).join(", ") + (selectedNewItems.length > 0 ? ", " : ""));
                adjustTextareaHeight($("#newItem")[0]);
                $("#newItem_json").val(JSON.stringify(selectedNewItems));

                return false;
            }
        });

        autocomplete_field_multi($("#hero"), $("#hero_id"), newItem, "item_class_description", "id", function(result) {
            let data = {
                event: "list",
                query: "id = " + result.id,
                select: "id, item_class_description",
                offset: offset,
                limit: 0,
                table: "tbl_item_class",
            };

            aJax.post(base_url + "cms/global_controller", data, function(res) {
                let hero_desc = JSON.parse(res);
                let hero_obj = hero_desc[0];

                addHeroItem(hero_obj);

                $("#hero").val(selectedHeroItems.map(item => item.item_class_description).join(", ") + (selectedHeroItems.length > 0 ? ", " : ""));
                adjustTextareaHeight($("#hero")[0]);
                $("#hero_json").val(JSON.stringify(selectedHeroItems));
            });
        }, {
            focus: function() {
                return false;
            },
            select: function(event, ui) {
                let item = {
                    id: ui.item.info.id,
                    item_class_description: ui.item.info.item_class_description
                };

                addHeroItem(item);

                $("#hero").val(selectedHeroItems.map(item => item.item_class_description).join(", ") + (selectedHeroItems.length > 0 ? ", " : ""));
                adjustTextareaHeight($("#hero")[0]);
                $("#newItemhero_jsonjson").val(JSON.stringify(selectedHeroItems));

                return false;
            }
        });

        autocomplete_field_multi($("#brand_included"),$("#brand_included_id"),brandIncluded,"brand_code","id",function(result) {
            let data = {
                event: "list",
                query: "id = " + result.id,
                select: "id, brand_code",
                offset: offset,
                limit: 0,
                table: "tbl_brand",
            };

            aJax.post(base_url + "cms/global_controller", data, function(res) {
                let brand_code = JSON.parse(res);
                let brandcode_obj = brand_code[0];

                addBrandIncluded(brandcode_obj);

                $("#brand_included").val(selectedBrandIncluded.map(item => item.brand_code).join(", ") + (selectedBrandIncluded.length > 0 ? ", " : ""));
                adjustTextareaHeight($("#brand_included")[0]);
                $("#brand_included_json").val(JSON.stringify(selectedBrandIncluded));
            });
        }, {
            focus: function() {
                return false;
            },
            select: function(event, ui) {
                let item = {
                    id: ui.item.info.id,
                    brand_code: ui.item.info.brand_code
                };

                addBrandIncluded(item);

                $("#brand_included").val(selectedBrandIncluded.map(item => item.brand_code).join(", ") + (selectedBrandIncluded.length > 0 ? ", " : ""));
                adjustTextareaHeight($("#brand_included")[0]);
                $("#brand_included_json").val(JSON.stringify(selectedBrandIncluded));

                return false;
            }
        });

        autocomplete_field_multi($("#brand_excluded"),$("#brand_excluded_id"),brandExcluded,"brand_code","id",function(result) {
            let data = {
                event: "list",
                query: "id = " + result.id,
                select: "id, brand_code",
                offset: offset,
                limit: 0,
                table: "tbl_brand",
            };

            aJax.post(base_url + "cms/global_controller", data, function(res) {
                let brand_code = JSON.parse(res);
                let brandcode_obj = brand_code[0];

                addBrandExcluded(brandcode_obj);

                $("#brand_excluded").val(selectedBrandExcluded.map(item => item.brand_code).join(", ") + (selectedBrandExcluded.length > 0 ? ", " : ""));
                adjustTextareaHeight($("#brand_excluded")[0]);
                $("#brand_excluded_json").val(JSON.stringify(selectedBrandExcluded));
            });
            }, {
                focus: function() {
                    return false;
                },
                select: function(event, ui) {
                    let item = {
                        id: ui.item.info.id,
                        brand_code: ui.item.info.brand_code
                    };

                    addBrandExcluded(item);

                    $("#brand_excluded").val(selectedBrandExcluded.map(item => item.brand_code).join(", ") + (selectedBrandExcluded.length > 0 ? ", " : ""));
                    adjustTextareaHeight($("#brand_excluded")[0]);
                    $("#brand_excluded_json").val(JSON.stringify(selectedBrandExcluded));

                    return false;
                }
            }
        );
        
        autocomplete_field_multi($("#brandLabelType"),$("#brandLabelTypeId"),brandLabelTypeOptions,"label","id",function(result) {
            let data = {
                event: "list",
                query: "id = " + result.id,
                select: "id, label",
                offset: offset,
                limit: 0,
                table: "tbl_brand_label_type",
            };

            aJax.post(base_url + "cms/global_controller", data, function(res) {
                let brandLabelType = JSON.parse(res);
                let brandCodeObj = brandLabelType[0];

                addBrandLabelType(brandCodeObj);

                $("#brandLabelType").val(selectedBrandLabelType.map(item => item.label).join(", ") + (selectedBrandLabelType.length > 0 ? ", " : ""));
                adjustTextareaHeight($("#brandLabelType")[0]);
                $("#brandLabelTypeJson").val(JSON.stringify(selectedBrandLabelType));
            });
        }, {
            focus: function() {
                return false;
            },
            select: function(event, ui) {
                let item = {
                    id: ui.item.info.id,
                    label: ui.item.info.label
                };

                addBrandLabelType(item);

                $("#brandLabelType").val(selectedBrandLabelType.map(item => item.label).join(", ") + (selectedBrandLabelType.length > 0 ? ", " : ""));
                adjustTextareaHeight($("#brandLabelType")[0]);
                $("#brandLabelTypeJson").val(JSON.stringify(selectedBrandLabelType));

                return false;
            }
        });
    });

    function addNewItem(item) {
        if (!selectedNewItems.some(i => i.id === item.id)) {
            selectedNewItems.push(item);
        }
    }

    function addHeroItem(item) {
        if (!selectedHeroItems.some(i => i.id === item.id)) {
            selectedHeroItems.push(item);
        }
    }

    function addBrandExcluded(item) {
        if (!selectedBrandExcluded.some(i => i.id === item.id)) {
            selectedBrandExcluded.push(item);
        }
    }

    function addBrandIncluded(item) {
        if (!selectedBrandIncluded.some(i => i.id === item.id)) {
            selectedBrandIncluded.push(item);
        }
    }

    function addBrandLabelType(item) {
        if (!selectedBrandLabelType.some(i => i.id === item.id)) {
            selectedBrandLabelType.push(item);
        }
    }

    // pag nag error lagay sa pinakataas 
    function adjustTextareaHeight(el) {
        el.style.height = 'auto';
        el.style.height = el.scrollHeight + 'px';
    }

        
    // function addUniqueItem(arraySelected, item) {
    //     if (!arraySelected.some(i => i.id === item.id)) {
    //         arraySelected.push(item);
    //     }
    // }

    // addUniqueItem(selectedHeroItems, item);
    // addUniqueItem(selectedNewItems, item);
    // addUniqueItem(selectedBrandIncluded, item);
    // addUniqueItem(selectedBrandExcluded, item);



    function get_data(query) {
        var url = "<?= base_url("cms/global_controller");?>";
            var data = {
                event : "list",
                select : `id, sm_sku_min, sm_sku_max, overstock_sku, new_item_sku, hero_sku, sales_incentives, cus_grp_code_lmi, 
                cus_grp_code_rgdi, brand_code_included, brand_code_excluded, brand_label_type, tba_amount_per_ba, tba_num_days,
                status, created_by, updated_by, created_date, updated_date`,
                query : query,
                offset : offset,
                limit : limit,
                table : "tbl_system_parameter",
            }

            aJax.post(url, data, function(result) {
            let obj = is_json(result);
            if (obj && obj.length > 0) {
                let row = obj[0];

                $('#id').val(row.id);
                $('#minimum').val(row.sm_sku_min);
                $('#maximum').val(row.sm_sku_max);
                $('#overstock').val(row.overstock_sku);
                $('#newItem').val(row.new_item_sku);
                $('#hero').val(row.hero_sku);
                $('#sales_incentives').val(row.sales_incentives);
                // $('#payment_grp_lmi').val(row.cus_grp_code_lmi);
                // $('#payment_grp_rgdi').val(row.cus_grp_code_rgdi);
                $('#brand_included').val(row.brand_code_included);
                $('#brand_excluded').val(row.brand_code_excluded);
                $('#brandLabelType').val(row.brand_label_type);
                $('#amountPerBa').val(row.tba_amount_per_ba);
                $('#numOfDays').val(row.tba_num_days);

                // Parse the JSON strings
                let lmi_data = JSON.parse(row.cus_grp_code_lmi || "[]");
                let rgdi_data = JSON.parse(row.cus_grp_code_rgdi || "[]");

                // Extract only the labels
                let lmi_labels = lmi_data.map(item => item.code).join(", ");
                let rgdi_labels = rgdi_data.map(item => item.code).join(", ");

                // Set them into the input fields
                // enable kapag madami na 
                $('#payment_grp_lmi').val(lmi_labels);
                // adjustTextareaHeight($('#payment_grp_lmi')[0]);

                $('#payment_grp_rgdi').val(rgdi_labels);
                // adjustTextareaHeight($('#payment_grp_rgdi')[0]); 
               

                if (row.hero_sku) {
                    try {
                        let hero_items = JSON.parse(row.hero_sku);
                        if (Array.isArray(hero_items)) {
                            selectedHeroItems = hero_items;
                            // Handle multiple hero items
                            let hero_desc = hero_items.map(item => item.item_class_description).join(", ");
                            $('#hero').val(hero_desc);
                            $('#hero_json').val(row.hero_sku); // Store the whole JSON in the hidden field
                        } else {
                            // Handle single hero item
                            selectedHeroItems = [hero_items];
                            $('#hero').val(hero_items.item_class_description + ", ");
                            $('#hero_id').val(hero_items.id);
                            $('#hero_json').val(JSON.stringify(hero_items));
                        }
                    } catch (err) {
                        console.warn("Invalid hero_sku JSON:", row.hero_sku);
                    }
                }

                if (row.new_item_sku) {
                    try {
                        let newItem_items = JSON.parse(row.new_item_sku);
                        if (Array.isArray(newItem_items)) {
                            selectedNewItems = newItem_items;
                            let newItem_desc = newItem_items.map(item => item.item_class_description).join(", ");
                            $('#newItem').val(newItem_desc);
                            $('#newItem_json').val(row.new_item_sku); 
                        } else {
                            selectedNewItems = [newItem_items];
                            $('#newItem').val(newItem_items.item_class_description + ", ");
                            $('#newItem_id').val(newItem_items.id);
                            $('#newItem_json').val(JSON.stringify(newItem_items));
                        }
                    } catch (err) {
                        console.warn("Invalid new_item_sku JSON:", row.new_item_sku);
                    }
                }

                if (row.brand_code_included) {
                    try {
                        let brandIncluded_items = JSON.parse(row.brand_code_included);
                        if (Array.isArray(brandIncluded_items)) {
                            selectedBrandIncluded = brandIncluded_items;
                            let brandIncluded_code = brandIncluded_items.map(item => item.brand_code).join(", ");
                            $('#brand_included').val(brandIncluded_code);
                            $('#brand_included_json').val(row.brand_code_included); 
                        } else {
                            selectedBrandIncluded = [brandIncluded_items];
                            $('#brand_included').val(brandIncluded_items.brand_code + ", ");
                            $('#brand_included_id').val(brandIncluded_items.id);
                            $('#brand_included_json').val(JSON.stringify(brandIncluded_items));
                        }
                    } catch (err) {
                        console.warn("Invalid brand_code_included JSON:", row.brand_code_included);
                    }
                }

                if (row.brand_code_excluded) {
                    try {
                        let brandExcluded_items = JSON.parse(row.brand_code_excluded);
                        if (Array.isArray(brandExcluded_items)) {
                            selectedBrandExcluded = brandExcluded_items;
                            let brandExcluded_code = brandExcluded_items.map(item => item.brand_code).join(", ");
                            $('#brand_excluded').val(brandExcluded_code);
                            $('#brand_excluded_json').val(row.brand_code_excluded);
                        } else {
                            selectedBrandExcluded = [brandExcluded_items];
                            $('#brand_excluded').val(brandExcluded_items.brand_code + ", ");
                            $('#brand_excluded_id').val(brandExcluded_items.id);
                            $('#brand_excluded_json').val(JSON.stringify(brandExcluded_items));
                        }
                    } catch (err) {
                        console.warn("Invalid brand_code_excluded JSON:", row.brand_code_excluded);
                    }
                }

                if (row.brand_label_type) {
                    try {
                        let brandLabelType_items = JSON.parse(row.brand_label_type);
                        if (Array.isArray(brandLabelType_items)) {
                            selectedBrandLabelType = brandLabelType_items;
                            let brandLabelType_code = brandLabelType_items.map(item => item.label).join(", ");
                            $('#brandLabelType').val(brandLabelType_code);
                            $('#brandLabelTypeJson').val(row.brand_label_type); 
                        } else {
                            selectedBrandLabelType = [brandLabelType_items];
                            $('#brandLabelType').val(brandLabelType_items.label + ", ");
                            $('#brandLabelTypeId').val(brandLabelType_items.id);
                            $('#brandLabelTypeJson').val(JSON.stringify(brandLabelType_items));
                        }
                    } catch (err) {
                        console.warn("Invalid brand_label_type JSON:", row.brand_label_type);
                    }
                }

            }
        });
    }


    function save_data() {
        var id = $('#id').val();
        
        var minimum = $('#minimum').val();
        var maximum = $('#maximum').val();
        var overstock = $('#overstock').val();
        var hero_json = $('#hero_json').val();
        var newItem_json = $('#newItem_json').val();
        var sales_incentives = $('#sales_incentives').val();
        // var lmi_json = $('#payment_grp_lmi').val();
        // var rgdi_json = $('#payment_grp_rgdi').val();
        var brand_excluded_json = $('#brand_excluded_json').val();
        var brand_included_json = $('#brand_included_json').val();
        var brandLabelTypeJson = $('#brandLabelTypeJson').val();
        var amountPerBa = $('#amountPerBa').val();
        var numOfDays = $('#numOfDays').val();

        // for user input payment groups / price code file (LMI & RGDI)
        let lmi_input = $('#payment_grp_lmi').val();
        let lmi_array = lmi_input.split(',')
            .map(s => s.trim())
            .filter(s => s !== "")
            .map((s, index) => ({ id: index + 1, code: s }));
            
        let lmi_json = JSON.stringify(lmi_array);

        let rgdi_input = $('#payment_grp_rgdi').val();
        let rgdi_array = rgdi_input.split(',')
            .map(s => s.trim())
            .filter(s => s !== "")
            .map((s, index) => ({ id: index + 1, code: s }));
            
        let rgdi_json = JSON.stringify(rgdi_array);



        if(validate.standard("system-parameter-form")){
            if (id !== undefined && id !== null && id !== '') {
                check_current_db("tbl_system_parameter", ["sm_sku_min", "sm_sku_max", "overstock_sku", "new_item_sku", "hero_sku", "sales_incentives", "cus_grp_code_lmi", "cus_grp_code_rgdi", "brand_code_included", "brand_code_excluded", "brand_label_type", "tba_amount_per_ba", "tba_num_days"], [minimum, maximum, overstock, newItem_json, hero_json, sales_incentives, lmi_json, rgdi_json, brand_included_json, brand_excluded_json, brandLabelTypeJson, amountPerBa, numOfDays], "status" , "id", id, true, function(exists, duplicateFields) {
                    if (!exists) {
                        modal.confirm(confirm_update_message, function(result){
                            if(result){ 
                                    modal.loading(true);
                                save_to_db(minimum, maximum, overstock, newItem_json, hero_json, sales_incentives, lmi_json, rgdi_json,  brand_included_json, brand_excluded_json, brandLabelTypeJson, amountPerBa, numOfDays, id)
                            }
                        });
    
                    }             
                });
            }else{
                check_current_db("tbl_system_parameter", ["sm_sku_min", "sm_sku_max", "overstock_sku", "new_item_sku", "hero_sku", "sales_incentives", "cus_grp_code_lmi", "cus_grp_code_rgdi", "brand_code_included", "brand_code_excluded", "brand_label_type", "tba_amount_per_ba", "tba_num_days"], [minimum, maximum, overstock, newItem_json, hero_json, sales_incentives, lmi_json, rgdi_json, brand_included_json, brand_excluded_json, brandLabelTypeJson, amountPerBa, numOfDays], "status", null, null, true, function(exists, duplicateFields) {
                    if (!exists) {
                        modal.confirm(confirm_add_message, function(result){
                            if(result){ 
                                    modal.loading(true);
                                save_to_db(minimum, maximum, overstock, newItem_json, hero_json, sales_incentives, lmi_json, rgdi_json, brand_included_json, brand_excluded_json, brandLabelTypeJson, amountPerBa, numOfDays, null)
                            }
                        });
    
                    }                  
                });
            }
        }
    }

    function save_to_db(inp_min, inp_max, inp_os, inp_nI_json, inp_hero_json, inp_sI, inp_lmi_json, inp_rgdi_json, inp_bi_json, inp_be_json, inp_blt_json, inp_amnt_ba, inp_numdays, id) {
        const url = "<?= base_url('cms/global_controller'); ?>";
        let data = {}; 
        let modal_alert_success;

        if (id !== undefined && id !== null && id !== '') {
            modal_alert_success = success_update_message;
            data = {
                event: "update",
                table: "tbl_system_parameter",
                field: "id",
                where: id,
                data: {
                    sm_sku_min: inp_min,
                    sm_sku_max: inp_max,
                    overstock_sku: inp_os,
                    new_item_sku: inp_nI_json,
                    hero_sku: inp_hero_json,
                    sales_incentives: inp_sI,
                    cus_grp_code_lmi: inp_lmi_json,
                    cus_grp_code_rgdi: inp_rgdi_json,
                    brand_code_included: inp_bi_json,
                    brand_code_excluded: inp_be_json,
                    brand_label_type: inp_blt_json,
                    tba_amount_per_ba: inp_amnt_ba,
                    tba_num_days: inp_numdays,
                    updated_date: formatDate(new Date()),
                    updated_by: user_id,
                    status: '1'
                }
            };
        } else {
            modal_alert_success = success_save_message;
            data = {
                event: "insert",
                table: "tbl_system_parameter",
                data: {
                    sm_sku_min: inp_min,
                    sm_sku_max: inp_max,
                    overstock_sku: inp_os,
                    new_item_sku: inp_nI_json,
                    hero_sku: inp_hero_json,
                    sales_incentives: inp_sI,
                    cus_grp_code_lmi: inp_lmi_json,
                    cus_grp_code_rgdi: inp_rgdi_json,
                    brand_code_included: inp_bi_json,
                    brand_code_excluded: inp_be_json,
                    brand_label_type: inp_blt_json,
                    tba_amount_per_ba: inp_amnt_ba,
                    tba_num_days: inp_numdays,
                    created_date: formatDate(new Date()),
                    created_by: user_id,
                    status: '1'
                }
            };
        }

        aJax.post(url,data,function(result){
            var obj = is_json(result);
            modal.loading(false);
            modal.alert(modal_alert_success, 'success', function() {
                location.reload();
            });
        });
    }

    // add ka lang rito kapag may bago na json
    const multiAutocompleteConfigs = {
        brand_included: {
            array: () => selectedBrandIncluded,
            updateArray: (val) => selectedBrandIncluded = val,
            hiddenField: '#brand_included_json',
            displayKey: 'brand_code'
        },
        brand_excluded: {
            array: () => selectedBrandExcluded,
            updateArray: (val) => selectedBrandExcluded = val,
            hiddenField: '#brand_excluded_json',
            displayKey: 'brand_code'
        },
        hero: {
            array: () => selectedHeroItems,
            updateArray: (val) => selectedHeroItems = val,
            hiddenField: '#hero_json',
            displayKey: 'item_class_description'
        }, 
        newItem: {
            array: () => selectedNewItems,
            updateArray: (val) => selectedNewItems = val,
            hiddenField: '#newItem_json',
            displayKey: 'item_class_description'
        },
        brandLabelType: {
            array: () => selectedBrandLabelType,
            updateArray: (val) => selectedBrandLabelType = val,
            hiddenField: '#brandLabelTypeJson',
            displayKey: 'label'
        },
        // payment_grp_lmi: {
        //     array: () => selectedLMI,
        //     updateArray: (val) => selectedLMI = val,
        //     hiddenField: '#payment_grp_lmi_json',
        //     displayKey: 'code'
        // },
        // payment_grp_rgdi: {
        //     array: () => selectedRGDI,
        //     updateArray: (val) => selectedRGDI = val,
        //     hiddenField: '#payment_grp_rgdi_json',
        //     displayKey: 'code'
        // }

    };

    Object.keys(multiAutocompleteConfigs).forEach(fieldId => {
        const $input = $('#' + fieldId);

        $input.on('keydown', function (e) {
            if (e.key === 'Backspace') {
                let inputVal = $(this).val();
                const config = multiAutocompleteConfigs[this.id];
                if (!config) return;

                if (this.selectionStart === inputVal.length) {
                    const parts = inputVal.split(',');
                    const lastChunk = parts[parts.length - 1];

                    // Check if user hasn't typed a new value after the last comma
                    if (lastChunk.trim() === '' || parts.length === config.array().length) {
                        let items = [...config.array()];
                        if (items.length > 0) {
                            items.pop();
                            config.updateArray(items);

                            let updatedInput = items.map(item => item[config.displayKey]).join(", ");
                            $(this).val(updatedInput);
                            $(config.hiddenField).val(JSON.stringify(items));
                        }

                        if (items.length === 0) {
                            $(this).val('');
                            config.updateArray([]);
                            $(config.hiddenField).val('[]');
                        }

                        e.preventDefault();
                    }
                }
            }
        });

        $input.on('input', function () {
            const config = multiAutocompleteConfigs[this.id];
            if (!config) return;

            const val = $(this).val();

            if (val.trim() === '') {
                config.updateArray([]);
                $(config.hiddenField).val('[]');
            }
        });
    });

    // basis
    // $('#brand_included, #brand_excluded').on('keydown', function (e) {
    //     if (e.key === 'Backspace') {
    //         let inputVal = $(this).val();

    //         if ((inputVal.endsWith(", ") || inputVal.endsWith(",")) && this.selectionStart === inputVal.length) {
    //             let parts = inputVal.split(',').map(s => s.trim()).filter(s => s !== "");

    //             if (parts.length > 0) {
    //                 parts.pop(); // remove last typed brand

    //                 // Identify which field triggered the event
    //                 if (this.id === 'brand_included') {
    //                     selectedBrandIncluded.pop();

    //                     let updatedInput = selectedBrandIncluded.map(item => item.brand_code).join(", ");
    //                     if (updatedInput) updatedInput += ", ";
    //                     $(this).val(updatedInput);
    //                     $('#brand_included_json').val(JSON.stringify(selectedBrandIncluded));
    //                 } else if (this.id === 'brand_excluded') {
    //                     selectedBrandExcluded.pop();

    //                     let updatedInput = selectedBrandExcluded.map(item => item.brand_code).join(", ");
    //                     if (updatedInput) updatedInput += ", ";
    //                     $(this).val(updatedInput);
    //                     $('#brand_excluded_json').val(JSON.stringify(selectedBrandExcluded));
    //                 }
    //             }

    //             e.preventDefault(); 
    //         }
    //     }
    // });

    // function split(val) {
    //     return val.split(/,\s*/);
    // }


</script>

    