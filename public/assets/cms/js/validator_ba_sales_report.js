self.onmessage = function(e) {
    let data = e.data;
    let invalid = false;
    let errorLogs = [];
    let valid_data = [];
    var err_counter = 0;

    // Process in smaller batches to avoid memory issues
    let batchSize = 2000;
    let index = 0;

    function processBatch() {
        if (index >= data.length) {
            self.postMessage({ invalid, errorLogs, valid_data, err_counter });
            return;
        }

        console.log(`Processing batch starting at index: ${index}`);

        for (let i = 0; i < batchSize && index < data.length; i++, index++) {
            let row = data[index];
            let tr_count = index + 1;
            let area = row["Area"] ? row["Area"].trim() : "";
            let store_name = row["Store Name"] ? row["Store Name"].trim() : "";
            let brand = row["Brand"] ? row["Brand"].trim() : "";
            let ba_name = row["BA Name"] ? row["BA Name"].trim() : "";
            let date = row["Date"] ? row["Date"]: "";
            let amount = row["Amount"] ? row["Amount"].trim() : "";
            let user_id = row["Created by"] ? row["Created by"].trim() : "";
            let date_of_creation = row["Created Date"] ? row["Created Date"].trim() : "";  

            // if (payment_group.length > 25 || payment_group === "") {
            //     invalid = true;
            //     errorLogs.push(`⚠️ Invalid Payment Group at line #: ${tr_count}`);
            //     err_counter++;
            // }

            if (date) {
                let parsedDate = new Date(date);
                if (!isNaN(parsedDate.getTime())) {
                    let year = parsedDate.getFullYear();
                    let month = String(parsedDate.getMonth() + 1).padStart(2, '0'); 
                    let day = String(parsedDate.getDate()).padStart(2, '0'); 
                    date = `${year}-${month}-${day}`;
                }
            }

            if (!invalid) {
                valid_data.push({
                    area: area,
                    store_name: store_name,
                    brand: brand,
                    ba_name: ba_name,
                    date: date,
                    amount: amount,
                    status: 1,
                    created_by: user_id,
                    created_date: date_of_creation
                });
            }
        }

        setTimeout(processBatch, 0);
    }

    processBatch();
};