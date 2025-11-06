import pymysql
from clickhouse_connect import get_client
from datetime import datetime
from uuid import UUID

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

create_table_sql = """
CREATE TABLE IF NOT EXISTS tbl_vmi_pre_aggregated_data (
    id UInt32,
    vmi_status String,
    supplier Int32,
    store_id Int32,
    area_id Int32,
    asc_id Int32,
    store_code String,
    store_name String,
    ba_ids String,
    brand_ids String,
    ba_types String,
    c_group String,
    dept String,
    c_class String,
    sub_class Int32,
    on_hand Int32,
    in_transit Int32,
    total_qty Int32,
    itmcde String,
    itmdsc String,
    brncde String,
    itmclacde String,
    tracc_brand_id Int32,
    cusitmcde String,
    brand_type_id Int32,
    brand_term_id Int32,
    item String,
    item_name String,
    item_class String,
    item_class_id Int32,
    average_sales_unit Float64,
    ba_deployment_dates String,
    year Int32,
    week Int32,
    swc Float64,
    company Int32,
    uuid UUID
) ENGINE = MergeTree()
ORDER BY (year, week, store_id, itmcde)
"""
ch_client.command(create_table_sql)

BATCH_SIZE = 500000
offset = 0
total_inserted = 0

with maria_conn.cursor() as cursor:
    cursor.execute("SELECT COUNT(*) AS cnt FROM tbl_vmi_pre_aggregated_data")
    total_rows = cursor.fetchone()["cnt"]
    print(f"🚀 Starting migration of {total_rows} rows...")

    while True:
        cursor.execute(f"SELECT * FROM tbl_vmi_pre_aggregated_data LIMIT {BATCH_SIZE} OFFSET {offset}")
        rows = cursor.fetchall()
        if not rows:
            break

        transformed = []
        for r in rows:
            try:
                transformed.append((
                    int(r["id"]),
                    str(r.get("vmi_status") or ""),
                    int(r.get("supplier") or 0),
                    int(r.get("store_id") or 0),
                    int(r.get("area_id") or 0),
                    int(r.get("asc_id") or 0),
                    str(r.get("store_code") or ""),
                    str(r.get("store_name") or ""),
                    str(r.get("ba_ids") or ""),
                    str(r.get("brand_ids") or ""),
                    str(r.get("ba_types") or ""),
                    str(r.get("c_group") or ""),
                    str(r.get("dept") or ""),
                    str(r.get("c_class") or ""),
                    int(r.get("sub_class") or 0),
                    int(r.get("on_hand") or 0),
                    int(r.get("in_transit") or 0),
                    int(r.get("total_qty") or 0),
                    str(r.get("itmcde") or ""),
                    str(r.get("itmdsc") or ""),
                    str(r.get("brncde") or ""),
                    str(r.get("itmclacde") or ""),
                    int(r.get("tracc_brand_id") or 0),
                    str(r.get("cusitmcde") or ""),
                    int(r.get("brand_type_id") or 0),
                    int(r.get("brand_term_id") or 0),
                    str(r.get("item") or ""),
                    str(r.get("item_name") or ""),
                    str(r.get("item_class") or ""),
                    int(r.get("item_class_id") or 0),
                    float(r.get("average_sales_unit") or 0.0),
                    str(r.get("ba_deployment_dates") or ""),
                    int(r.get("year") or 0),
                    int(r.get("week") or 0),
                    float(r.get("swc") or 0.0),
                    int(r.get("company") or 0),
                    str(r.get("uuid") or "00000000-0000-0000-0000-000000000000")
                ))
            except Exception as e:
                print(f"Skipping row ID {r.get('id')} due to error: {e}")

        if transformed:
            ch_client.insert(
                "tbl_vmi_pre_aggregated_data",
                transformed,
                column_names=[
                    "id","vmi_status","supplier","store_id","area_id","asc_id","store_code","store_name",
                    "ba_ids","brand_ids","ba_types","c_group","dept","c_class","sub_class","on_hand","in_transit",
                    "total_qty","itmcde","itmdsc","brncde","itmclacde","tracc_brand_id","cusitmcde","brand_type_id",
                    "brand_term_id","item","item_name","item_class","item_class_id","average_sales_unit",
                    "ba_deployment_dates","year","week","swc","company","uuid"
                ]
            )

        total_inserted += len(transformed)
        offset += BATCH_SIZE
        print(f" Inserted {total_inserted}/{total_rows} rows...")

print(f"🎉 Migration complete! Total rows inserted: {total_inserted}")
