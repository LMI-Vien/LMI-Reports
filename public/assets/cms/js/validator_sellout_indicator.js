self.onmessage = async function(e) {
    let data = e.data.data;
    let BASE_URL = e.data.base_url;
    let invalid = false;
    let errorLogs = [];
    let unique_description = new Set();
    let valid_data = [];
    let err_counter = 0;


    // --- Helper functions ---
    // Clean up description: lowercase, trim, collapse spaces
    function normalizeText(value) {
        return String(value || "")
        .toLowerCase()
        .trim()
        .replace(/\s+/g, " ");
    }

    // Clean up codes: lowercase, trim, remove spaces
    function normalizeCode(value) {
        return String(value || "")
        .toLowerCase()
        .trim()
        .replace(/\s+/g, "");
    }

    try { 
        let get_ba_valid_response = await fetch(`${BASE_URL}cms/customer-sellout-indicator/merged-customers`);
        let ba_data = await get_ba_valid_response.json();

        const baArray = Array.isArray(ba_data) ? ba_data : Object.values(ba_data || {});
        const baLookup = {};
            for (let iBA = 0; iBA < baArray.length; iBA++) {
                const item = baArray[iBA] || {};
                const codeKeyBA = normalizeCode(item.customer_code);
                const descKeyBA = normalizeText(item.customer_description);
            if (!codeKeyBA || !descKeyBA) continue;
                const key = codeKeyBA + '::' + descKeyBA;
            if (!baLookup[key]) baLookup[key] = item; // keep first occurrence
        }

        let batchSize = 2000;
        let index = 0;

        function processBatch() {
            if (index >= data.length) {
                self.postMessage({ invalid, errorLogs, valid_data, err_counter });
                return;
            }

            for (let i = 0; i < batchSize && index < data.length; i++, index++) {
                let row = data[index];
                let tr_count = index + 1;
                let rowInvalid = false;

                let customerCode = row["Customer Code"] ? row["Customer Code"].trim() : "";
                let customerDesc = row["Customer Description"] ? row["Customer Description"].trim() : "";
                let status = row["Status"] ? row["Status"].trim().toLowerCase() : "";
                let user_id = row["Created by"] ? row["Created by"].trim() : "";
                let date_of_creation = row["Created Date"] ? row["Created Date"].trim() : "";

                const codeKeyRow = normalizeCode(customerCode);
                const descKeyRow = normalizeText(customerDesc);
                const lookupKey  = codeKeyRow + '::' + descKeyRow;
                const baMatch    = baLookup[lookupKey];

                if (!baMatch) {
                    invalid = true;
                    rowInvalid = true;
                    errorLogs.push(`⚠️ Code or Description does not exist in Mastefile at line #: ${tr_count}`);
                    err_counter++;
                }

                if (!["active", "inactive"].includes(status)) {
                    invalid = true;
                    rowInvalid = true;
                    errorLogs.push(`⚠️ Invalid Status at line #: ${tr_count}`);
                    err_counter++;
                }

                if (!rowInvalid) {
                    var custId = baMatch.id;
                    var source = (baMatch.source_label || baMatch.source || '').toString();

                    valid_data.push({
                        cus_id: custId,
                        cus_code: customerCode,
                        cus_description: customerDesc,
                        source: source,
                        status: status === "active" ? 1 : 0,                    
                        created_by: user_id,
                        created_date: date_of_creation
                    });
                }
            }

            setTimeout(processBatch, 0);
        }

        processBatch();
    } catch (error) {
        self.postMessage({ invalid: true, errorLogs: [`Validation failed: ${error.message}`], err_counter: 1 });
    }


};