import pymysql
from clickhouse_connect import get_client
from datetime import datetime

# ---------------- MariaDB Connection ----------------
maria_conn = pymysql.connect(
    host="127.0.0.1",
    user="root",
    password="new_secure_password",
    database="sfa_prod_db",
    charset="utf8mb4",
    cursorclass=pymysql.cursors.Cursor
)

# ---------------- ClickHouse Connection ----------------
ch_client = get_client(
    host="localhost",
    port=8123,
    username="default",
    password="LMI@123",
    database="sfa_db"
)

def parse_array(val):
    if val and isinstance(val, str):
        return [int(x.strip()) for x in val.split(",") if x.strip()]
    return []

create_table_sql = """
CREATE TABLE IF NOT EXISTS tbl_sell_out_pre_aggregated_data (
    id UInt32,
    year UInt16,
    month UInt8,
    customer_payment_group String,
    store_code String,
    ba_ids Array(Int32),
    brand_ids Array(Int32),
    ba_types Array(Int32),
    area_id Int32,
    asc_id Int32,
    company String,
    gross_sales Float64,
    net_sales Float64,
    quantity Float64,
    itmcde String,
    itmdsc String,
    brncde String,
    itmclacde String,
    item_class_id Int32,
    label_type_category_id Int32,
    category_2_id Int32,
    category_3_id Int32,
    category_4_id Int32,
    brand_id Int32,
    cusitmcde String,
    store_name String,
    brand_type_id Int32,
    brand_term_id Int32,
    sku_codes String,
    amount Float64,
    unit_price Float64,
    net_price Float64,
    created_at DateTime,
    updated_at DateTime
) ENGINE = MergeTree()
ORDER BY (year, month, store_code, brand_id)
"""
ch_client.command(create_table_sql)

BATCH_SIZE = 500000
offset = 0
total_inserted = 0

with maria_conn.cursor() as cursor:
    cursor.execute("SELECT COUNT(*) FROM tbl_sell_out_pre_aggregated_data")
    total_rows = cursor.fetchone()[0]
    print(f"Starting migration of {total_rows} rows...")

    while True:
        cursor.execute(
            f"SELECT * FROM tbl_sell_out_pre_aggregated_data LIMIT {BATCH_SIZE} OFFSET {offset}"
        )
        rows = cursor.fetchall()
        if not rows:
            break

        transformed = []
        for r in rows:
            ba_ids = parse_array(r[5])
            brand_ids = parse_array(r[6])
            ba_types = parse_array(r[7])

            transformed.append((
                int(r[0]),
                int(r[1]), 
                int(r[2]),  
                str(r[3] or ""),
                str(r[4] or ""),
                ba_ids, brand_ids, ba_types,
                int(r[8] or 0),
                int(r[9] or 0),
                str(r[10] or ""),
                float(r[11] or 0),
                float(r[12] or 0),
                float(r[13] or 0),
                str(r[14] or ""),
                str(r[15] or ""),
                str(r[16] or ""),
                str(r[17] or ""),
                int(r[18] or 0),
                int(r[19] or 0),
                int(r[20] or 0),
                int(r[21] or 0),
                int(r[22] or 0),
                int(r[23] or 0),
                str(r[24] or ""),
                str(r[25] or ""),
                int(r[26] or 0),
                int(r[27] or 0),
                str(r[28] or ""),
                float(r[29] or 0),
                float(r[30] or 0),
                float(r[31] or 0),
                r[32] if isinstance(r[32], datetime) else datetime.now(),
                r[33] if isinstance(r[33], datetime) else datetime.now(),
            ))

        ch_client.insert(
            "tbl_sell_out_pre_aggregated_data",
            transformed,
            column_names=[
                "id","year","month","customer_payment_group","store_code","ba_ids","brand_ids","ba_types",
                "area_id","asc_id","company","gross_sales","net_sales","quantity",
                "itmcde","itmdsc","brncde","itmclacde","item_class_id","label_type_category_id","category_2_id","category_3_id","category_4_id","brand_id",
                "cusitmcde","store_name","brand_type_id","brand_term_id","sku_codes","amount","unit_price","net_price",
                "created_at","updated_at"
            ]
        )

        total_inserted += len(transformed)
        offset += BATCH_SIZE
        print(f" Inserted {total_inserted}/{total_rows} rows...")

print(f"Migration complete! Total rows inserted: {total_inserted}")