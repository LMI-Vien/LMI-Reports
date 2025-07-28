<div class="content-wrapper p-4">
    <div class="card">
        <div class="text-center page-title md-center">
            <b>C M S - A U D I T - L O G S</b>
        </div>

        <div class="box audit_trail_div">
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
                            <table class= "table table-bordered listdata table-bordered ">
                               <thead>
                                    <tr>
                                        <th class = 'center-align-format'>User</th>
                                        <th class = 'center-align-format'>Module</th>
                                        <th class = 'center-align-format'>Action</th>
                                        <th class = 'center-align-format'>Date &amp; Time</th>
                                        <th class = 'center-align-format'>Device IP</th>
                                        <th class = 'center-align-format'>Download Logs</th>
                                        <th class = 'center-align-format'>Remarks</th>
                                        <th class = 'center-align-format'>View</th>
                                    </tr>  
                                 </thead>
                                <tbody class="table_body word_break">
                                </tbody>
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
</div>


<script type="text/javascript">
    var query = "id >= 0";
    var limit = 10;
   // var offset = 0;
    $(document).ready(function() {
        get_data(query);
        get_pagination(query);
        $("#form_search").removeClass( "pull-right" );
        $(document).on('cut copy paste input', '.start-date, .end-date', function(e) {
            e.preventDefault();
        });
    });
    
    function get_data(query) {
        var url = "<?= base_url("cms/global_controller");?>";
        var data = {
            event : "list",
            select : "id, user, module, action, remarks, ip_address, link, new_data, old_data, created_at",
            query : query,
            offset : offset,
            limit : limit,
            table : "activity_logs",
            order : {
                field : "created_at", //field to order
                order : "desc" //asc or desc
            }
        }
        
        aJax.post(url,data,(result) => {
            var result = JSON.parse(result);
            var html = '';
            
            if(result) {
                if (result.length > 0) {
                    $.each(result, (x,y) => {
                        html += '<tr>';
                    
                        html += '<td>' + (y.user ?? '-') + '</td>';
                        // html += '<td>' + (y.module ?? '-') + '</td>';
                        html += '<td>' + cleanUpModule(y.module) + '</td>';
                        html += '<td>' + (y.action ?? '-') + '</td>';
                        html += '<td class="center-align-format">' + (y.created_at ? formatReadableDate(y.created_at, true) : '-') + '</td>';
                        html += '<td>' + (y.ip_address ?? '-') + '</td>';
                        html += '<td>' + (y.link ?? '-') + '</td>';
                        html += '<td>' + (y.remarks ?? '-') + '</td>';
                        if (y.new_data !== "" && y.new_data !== null) {
                            html += '   <td style="width: 50px;"><a class="view_history" href="#" data-id="'+y.id+'"><i class="fa fa-eye"></i></a></td>';
                        } else {
                            html += '   <td style="width: 50px;"></td>';
                        }                        
                        if (parseInt(y.status) === 1) {
                            status = 'Active';
                        }
                        else {
                            status = 'Inactive';
                        }
                        
                        html += '</tr>';
                    });
                }
                else {
                    html = '<tr><td colspan=12 class="center-align-format">'+ no_records +'</td></tr>';
                }
            }
            $('.table_body').html(html);
        });
    }



    function get_pagination() {
        var url = "<?= base_url("cms/global_controller");?>";
        var data = {
            event : "pagination",
            select : "id",
            query : query,
            offset : offset,
            limit : limit,
            table : "activity_logs",
            order : {
                field : "id", //field to order
                order : "asc" //asc or desc
            }
        }        
        
        aJax.post(url,data,function(result){
            var obj = is_json(result); //check if result is valid JSON format, Format to JSON if not
            modal.loading(false);
            pagination.generate(obj.total_page, ".list_pagination", get_data);
        });
    }

    pagination.onchange(function(){
        offset = $(this).val();
        get_data(query);
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
        modal.loading(false);
    });

    $(document).on('keydown', '#search_query', function(event) {
        $('.btn_status').hide();
        $(".selectall").prop("checked", false);
        if (event.key == 'Enter') {
            search_input = $('#search_query').val();
            offset = 1;
            new_query = query;
            new_query += ' and user like \'%'+search_input+'%\' or '+query+' and module like \'%'+search_input+'%\' or '+query+' and action like \'%'+search_input+'%\'';
            get_data(new_query);
            get_pagination(new_query);
        }
    });

    $(document).on('click', '#search_button', function(event) {
        $('.btn_status').hide();
        $(".selectall").prop("checked", false);
        search_input = $('#search_query').val();
        offset = 1;
        new_query = query;
        new_query += ' and user like \'%'+search_input+'%\' or '+query+' and module like \'%'+search_input+'%\' or '+query+' and action like \'%'+search_input+'%\'';
        get_data(new_query);
        get_pagination(new_query);
    });

    $(document).on('click', '#btnFilterDr', function() {
        var startDate = $('#startDate').val();
        var endDate   = $('#endDate').val();

        $('.start-date, .end-date').css('border-color', '#ccc');

        if (!startDate) {
            $('.start-date').css('border-color', 'red');
            return;
        }

        if (!endDate) {
            $('.end-date').css('border-color', 'red');
            return;
        }

        offset = 1;
        query  = "DATE(created_at) >= '" + startDate + "'"
                + " AND DATE(created_at) <= '" + endDate   + "'"
                + " AND id != 0";

        get_data(query);
    });


   $(document).on('click', '#btnResetDr', function() {
        $('.start-date').val('');
        $('.end-date').val('');
        $('.search-query').val('');
        query = "id != 0";
        get_data(query);
    });

    const lookupConfigs = {
        'brand-ambassador': [                   // module name
            {
                field:  'agency',               // name of the (JSON) field in newData/oldData
                table:  'tbl_agency',           // lookup table 
                select: 'id, agency',           // fields to select from the lookup table
                value:  'agency'                // label to display in the table
            },
            {
                field:  'team',
                table:  'tbl_team',           
                select: 'id, team_description',
                value:  'team_description'
            },  
        ],
        'asc': [
            {
                field:  'area_id',
                table:  'tbl_area',
                select: 'id, description',
                value:  'description'
            }, 
        ],
        'asc-module-import': [
            {
                field:  'area_id',
                table:  'tbl_area',
                select: 'id, description',
                value:  'description'
            }, 
        ],
        'store-group-module': [
            {
                field:  'store_id',
                table:  'tbl_store',
                select: 'id, description',
                value:  'description'
            },
            {
                field:  'area_id',
                table:  'tbl_area',
                select: 'id, description',
                value:  'description'
            },
        ],
        'store-group-module-import': [
            {
                field:  'store_id',
                table:  'tbl_store',
                select: 'id, description',
                value:  'description'
            },
            {
                field:  'area_id',
                table:  'tbl_area',
                select: 'id, description',
                value:  'description'
            },
        ],
        'area': [
            {
                field:  'store_id',
                table:  'tbl_store',
                select: 'id, description',
                value:  'description'
            },
            {
                field:  'area_id',
                table:  'tbl_area',
                select: 'id, description',
                value:  'description'
            },
        ], 
        'ba-per-store-module-import': [
            {
                field:  'store_id',
                table:  'tbl_store',
                select: 'id, description',
                value: 'description'
            },
            {
                field:  'brand_ambassador_id',
                table:  'tbl_brand_ambassador',
                select: 'id, name',
                value:  'name'
            },
        ],
        'ba-brand-group-module': [
            {
                field:  'store_id', 
                table:  'tbl_store',
                select: 'id, description',
                value: 'description'
            },
            {
                field:  'brand_ambassador_id',
                table:  'tbl_brand_ambassador',
                select: 'id, name',
                value:  'name'
            },
        ],
        'store-branch': [
            {
                field: 'store_id',
                table: 'tbl_store',
                select: 'id, description',
                value: 'description'
            },
            {
                field:  'brand_ambassador_id',
                table:  'tbl_brand_ambassador',
                select: 'id, name',
                value:  'name'
            },
        ],
        'ba-brand-module': [
            {
                field:  'brand_id',
                table:  'tbl_brand',
                select: 'id, brand_code',
                value:  'brand_code'
            },
            {
                field:  'ba_id',
                table:  'tbl_brand_ambassador',
                select: 'id, name',
                value:  'name'
            },
            {
                field:  'inserted',
                table:  'tbl_brand',
                select: 'id, brand_code',
                value:  'brand_code'
            },
            {
                field:  'deleted',
                table:  'tbl_brand',
                select: 'id, brand_code',
                value:  'brand_code'
            }
        ],
        'brand-ambassador-module-import': [
            {
                field: 'team',
                table: 'tbl_team',
                select: 'id, team_description',
                value: 'team_description'
            },
            {
                field: 'agency',
                table: 'tbl_agency',
                select: 'id, agency',
                value: 'agency'
            },
        ],
        'ba-module-import': [
            {
                field:  'ba_id',
                table:  'tbl_brand_ambassador',
                select: 'id, name',
                value:  'name'
            },
            {
                field: 'brand_id',
                table: 'tbl_brand',
                select: 'id, brand_code',
                value: 'brand_code'
            },
        ],
        'import-sell-out': [
            {
                field:  'month',
                table:  'tbl_month',
                select: 'id, month',
                value:  'month'
            },
            {
                field:  'year',
                table:  'tbl_year',           
                select: 'id, year',
                value:  'year'
            },  
            {
                field:  'company',
                table:  'tbl_company',           
                select: 'id, name',
                value:  'company'
            },  
        ],
        'import-week-on-week': [
            {
                field:  'year',
                table:  'tbl_year',           
                select: 'id, year',
                value:  'year'
            }, 
        ],
    };

    // ——————————————————————————————
    // 1) Generic field‐mapping helper
    // Returns a Promise that resolves once newData/oldData are updated
    // ——————————————————————————————

    function mapField(fieldConfig, newData, oldData, url) {
        return new Promise(resolve => {
            const { field, table, select, value } = fieldConfig;

            const newArr = Array.isArray(newData) ? newData : [ newData ];
            const oldArr = Array.isArray(oldData) ? oldData : [ oldData ];

            // collect IDs (even inside arrays)
            const ids = new Set();
            newArr.concat(oldArr).forEach(obj => {
            const val = obj[field];
            if (val == null) return;
            if (Array.isArray(val)) val.forEach(v => v != null && ids.add(v));
                else ids.add(val);
            });

            // console.log(`[mapField] field="${field}" → IDs=[${[...ids].join()}]`);

            if (!ids.size) return resolve();

            aJax.post(url, {
                event: 'list',
                table,
                select,
                query: 'id IN (' + [...ids].join(',') + ')'
                }, resp => {
                const rows = JSON.parse(resp);
                // console.log(`[mapField] fetched rows for "${field}":`, rows);

                // build lookup
                const lookup = {};
                rows.forEach(r => lookup[r.id] = r[value]);

                // map back
                newArr.concat(oldArr).forEach(obj => {
                    const val = obj[field];
                    if (val == null) return;
                    if (Array.isArray(val)) {
                        obj[field] = val.map(id => lookup[id] || id).join(', ');
                    }
                    else if (lookup[val]) {
                        obj[field] = lookup[val];
                    }
                });

                resolve();
            });
        });
    }



    $(document).on('click', '.view_history', function (e) {
        e.preventDefault();
        modal.loading(true);

        const dataId = $(this).attr('data-id');
        const url    = "<?= base_url('cms/global_controller') ?>";

        aJax.post(url, {
            event:  'list',
            select: "id, user, module, action, new_data, old_data, remarks, ip_address, created_at",
            query:  'id=' + dataId,
            table:  'activity_logs',
            order:  { field: 'created_at', order: 'desc' },
            limit:  1
        }, (resp) => {
            const entry   = JSON.parse(resp)[0] || {};

            let newData   = is_json(entry.new_data) ? JSON.parse(entry.new_data) : {};
            let oldData   = is_json(entry.old_data) ? JSON.parse(entry.old_data) : {};


            // 1) normalize into arrays
            const normalize = x => Array.isArray(x) ? x : [x];
            const newArr = normalize(newData);
            const oldArr = normalize(oldData);

            const flattenNested = (arr, field, extractKey) => {
            arr.forEach(obj => {
                let v = obj[field];
                    if (typeof v === 'string' && is_json(v)) {
                    try {
                        let a = JSON.parse(v);
                        // if we got an array of objects, pull out the one key we care about:
                        if (Array.isArray(a) && a.length && typeof a[0] === 'object') {
                        obj[field] = a
                            .map(item => item[extractKey] ?? JSON.stringify(item))
                            .join(', ');
                        }
                        // otherwise if array of primitives:
                        else if (Array.isArray(a)) {
                        obj[field] = a.join(', ');
                        }
                    } catch (_){/* ignore */} 
                    }
                });
            };

            // list every column you want to flatten, and
            // the property inside those objects that you really want to show:
            [
                { field: 'new_item_sku',         key: 'item_class_description' },
                { field: 'hero_sku',             key: 'item_class_description' },
                { field: 'brand_code_included',  key: 'brand_code' },
                { field: 'brand_code_excluded',  key: 'brand_code' },
                { field: 'brand_label_type',     key: 'label' },
                { field: 'cus_grp_code_lmi',     key: 'code' },
                { field: 'cus_grp_code_rgdi',    key: 'code' },
            ].forEach(cfg => {
                flattenNested(newArr, cfg.field, cfg.key);
                flattenNested(oldArr, cfg.field, cfg.key);
            });

            // 2) Status code → label
            [newArr, oldArr].forEach(arr => {
                arr.forEach(obj => {
                    if (obj.status !== undefined) {
                    const code = parseInt(obj.status, 10);
                    switch (code) {
                        case 1:
                            obj.status = 'Active';
                        break;
                        case -2:
                            obj.status = 'Deleted';
                        break;
                        default:
                            obj.status = 'Inactive';
                    }
                    }
                });
            });

            // 2.1) Type code → label (brand-ambassador only)
            if (entry.module === 'brand-ambassador' || entry.module === 'brand-ambassador-module-import') {
                [newArr, oldArr].forEach(arr => {
                    arr.forEach(obj => {
                        if (obj.type !== undefined) {
                            obj.type = obj.type == 1 ? 'Outright' : 'Consign';
                        }
                    });
                });
            }

            if (entry.module === 'ba-brand-group-module') {
                [newArr, oldArr].forEach(arr => {
                    arr.forEach(obj => {
                        if (obj.brand_ambassador_id !== undefined) {
                            const id = parseInt(obj.brand_ambassador_id, 10);
                            obj.brand_ambassador_label = id === -5 ? 'Vacant' : 'Non-BA';
                        }
                    });
                });
            }


            // 3) Module‐specific lookups via switch‐case
            // let moduleKey = entry.module.split('/')[0];
            // let configsToMap;
            // switch (moduleKey) {
            //     case 'brand-ambassador':               configsToMap = lookupConfigs['brand-ambassador']; break;
            //     case 'asc':                            configsToMap = lookupConfigs['asc']; break;
            //     case 'store-group-module':             configsToMap = lookupConfigs['store-group-module']; break;
            //     case 'store-group-module-import':      configsToMap = lookupConfigs['store-group-module-import']; break;
            //     case 'area':                           configsToMap = lookupConfigs['area']; break;
            //     case 'asc-module-import':              configsToMap = lookupConfigs['asc-module-import']; break;
            //     case 'ba-per-store-module-import':     configsToMap = lookupConfigs['ba-per-store-module-import']; break;
            //     case 'ba-brand-group-module':          configsToMap = lookupConfigs['ba-brand-group-module']; break;
            //     case 'store-branch':                   configsToMap = lookupConfigs['store-branch']; break;
            //     case 'ba-brand-module':                configsToMap = lookupConfigs['ba-brand-module']; break;
            //     case 'brand-ambassador-module-import': configsToMap = lookupConfigs['brand-ambassador-module-import']; break;
            //     case 'ba-module-import':               configsToMap = lookupConfigs['ba-module-import']; break;
            //     case 'import-sell-out':                configsToMap = lookupConfigs['import-sell-out']; break;
            //     case 'import-week-on-week':            configsToMap = lookupConfigs['import-week-on-week']; break;
            //     // case 'ba-brand-module-delete':         configsToMap = lookupConfigs['ba-brand-module-delete']; break;
            //     default:                               configsToMap = []; 
            // }

            function normalizeKey(s) {
                return s
                    .trim()                                   
                    .toLowerCase()                            
                    .replace(/[\u2010-\u2015\u2212]/g, '-')   
                    .replace(/[^a-z0-9\-]/g, '');             
            }

            // 2) get the raw module key from your log entry
            const rawKey = (entry.module || '').split('/')[0];

            // 3) find the matching config key by comparing normalized forms
            const matchedKey = Object
                .keys(lookupConfigs)
                .find(cfgKey => normalizeKey(cfgKey) === normalizeKey(rawKey));

            // 4) fall back to empty array if nothing matches
            const configsToMap = lookupConfigs[matchedKey] || [];

            // console.log(
            //     'raw module:', JSON.stringify(rawKey),
            //     'normalized:', normalizeKey(rawKey),
            //     'matched config:', matchedKey,
            //     'fields:', configsToMap.map(c=>c.field)
            // );

            // Kick off one mapField promise per config
            const mapPromises = configsToMap.map(cfg =>
                mapField(cfg, newArr, oldArr, url)
            );

            Promise.all(mapPromises).then(() => {

                // 4) Now do the generic created_by / updated_by lookup
                const idsToLookup = new Set();
                newArr.concat(oldArr).forEach(obj => {
                    if (obj.created_by) idsToLookup.add(obj.created_by);
                    if (obj.updated_by) idsToLookup.add(obj.updated_by);
                });

                if (idsToLookup.size === 0) {
                    return renderTable();
                }

                aJax.post(url, {
                    event:  'list',
                    select: 'id, username',
                    query:  'id IN (' + Array.from(idsToLookup).join(',') + ')',
                    table:  'cms_users'
                }, (userResp) => {
                    const users = JSON.parse(userResp);
                    const userMap = users.reduce((m,u) => (m[u.id]=u.username, m), {});

                    users.forEach(u => { userMap[u.id] = u.username; });

                    [newArr, oldArr].forEach(arr => {
                        arr.forEach(obj => {
                            if (obj.created_by && userMap[obj.created_by]) {
                                obj.created_by = userMap[obj.created_by];
                            }
                            if (obj.updated_by && userMap[obj.updated_by]) {
                                obj.updated_by = userMap[obj.updated_by];
                            }
                        });
                    });

                    renderTable();
                });
            });

            // which modules should always be grouped & collapsed by area_id
            const areaSummaryModules = new Set([
                'store-group-module-import',
                // add more module keys here as needed…
            ]);

            function renderTable() {
                modal.loading(false);

                // 1) normalize
                let rawNew = Array.isArray(newData) ? newData : [newData];
                let rawOld = Array.isArray(oldData) ? oldData : [oldData];

                const newArr = rawNew;
                const oldArr = rawOld;

                let toRender;

                if (areaSummaryModules.has(entry.module)) {
                    // ————————————————————————
                    // Group & collapse by area_id
                    // ————————————————————————
                    const group = arr => arr.reduce((g,r) => {
                        (g[r.area_id] = g[r.area_id]||[]).push(r);
                        return g;
                    }, {});

                    const newGroups = group(newArr);
                    const oldGroups = group(oldArr);

                    toRender = Object.keys(newGroups).map(area_id => {
                    const ns = newGroups[area_id],
                            os = oldGroups[area_id] || [],
                            summaryNew = {},
                            summaryOld = {},
                            keys = Object.keys(ns[0]);

                    keys.forEach(key => {
                        if (key === 'store_id') {
                        summaryNew.store_id = [...new Set(ns.map(r=>r.store_id))].join(', ');
                        summaryOld.store_id = os.length
                            ? [...new Set(os.map(r=>r.store_id))].join(', ')
                            : 'No Data';
                        } else {
                        summaryNew[key] = ns[0][key] ?? 'No Data';
                        summaryOld[key] = os[0]?.[key] ?? 'No Data';
                        }
                    });

                        return { new: summaryNew, old: summaryOld };
                    });

                } else {
                    // ————————————————————————
                    // Your old “collapse only if everything except store_id is identical”
                    // ————————————————————————
                    let summaryNew = {}, summaryOld = {};

                    if (newArr.length > 1) {
                        const keys = Object.keys(newArr[0]);
                        const allSame = keys.every(k => {
                        if (k === 'store_id') return true;
                            return newArr.every(r=>r[k]===newArr[0][k]) &&
                                oldArr.every(r=>r[k]===oldArr[0]?.[k]);
                    });

                        if (allSame) {
                            keys.forEach(k => {
                                if (k === 'store_id') {
                                    summaryNew.store_id = [...new Set(newArr.map(r=>r.store_id))].join(', ');
                                    summaryOld.store_id = oldArr.length
                                    ? [...new Set(oldArr.map(r=>r.store_id))].join(', ')
                                    : 'No Data';
                                } else {
                                    summaryNew[k] = newArr[0][k] ?? 'No Data';
                                    summaryOld[k] = oldArr[0]?.[k] ?? 'No Data';
                                }
                            });
                        }
                    }

                    toRender = Object.keys(summaryNew).length
                    ? [{ new: summaryNew, old: summaryOld }]
                    : newArr.map((_,i) => ({ new: newArr[i], old: oldArr[i]||{} }));
                }

                // ————————————————————————
                // now render `toRender` exactly as before
                // ————————————————————————
                const allKeys = new Set();
                    toRender.forEach(pair => {
                        Object.keys(pair.new).forEach(k=>allKeys.add(k));
                        Object.keys(pair.old).forEach(k=>allKeys.add(k));
                    });

                // let html = `
                //     <table class="table table-bordered m-t-20">
                //     <thead>
                //         <tr><th>Field</th><th>Old Data</th><th>New Data</th></tr>
                //     </thead>
                //     <tbody>
                // `;

                let html = `
                    <div class="table-responsive" style="max-height:500px; overflow-y:auto;">
                    <table class="table table-bordered m-t-20">
                        <thead>
                        <tr>
                            <th style="white-space:nowrap">Field</th>
                            <th style="white-space:nowrap">Old Data</th>
                            <th style="white-space:nowrap">New Data</th>
                        </tr>
                        </thead>
                        <tbody>
                `;
                toRender.forEach(pair => {
                    Array.from(allKeys).forEach(key => {
                    const o = pair.old[key] ?? 'No Data';
                    const n = pair.new[key] ?? 'No Data';
                    const changed = o !== n;
                    html += `
                        <tr>
                        <td>${key}</td>
                        <td>${o}</td>
                        <td class="${changed?'bg-c7cdfa':''}">${n}</td>
                        </tr>
                    `;
                    });
                });
                
                if (toRender.length===0) {
                    html += `<tr><td colspan="3" class="text-center">No changes found</td></tr>`;
                }
                html += `</tbody></table>`;

                modal.show('<div class="scroll-500">'+html+'</div>', 'large');
            }
        });
    });

</script>