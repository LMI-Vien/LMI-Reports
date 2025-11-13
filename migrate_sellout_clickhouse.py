import pymysql
from clickhouse_connect import get_client
from datetime import datetime

def migrate_data(year=None, company=None, month=None, payment_group=None):
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
        ba_ids String,
        brand_ids String,
        ba_types String,
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
        conditions = []
        params = []
        if year is not None:
            conditions.append("year = %s")
            params.append(year)
        if company is not None:
            conditions.append("company = %s")
            params.append(company)
        if month is not None:
            conditions.append("month = %s")
            params.append(month)
        if payment_group is not None:
            conditions.append("customer_payment_group = %s")
            params.append(payment_group)

        where_clause = f"WHERE {' AND '.join(conditions)}" if conditions else ""

        cursor.execute(f"SELECT COUNT(*) FROM tbl_sell_out_pre_aggregated_data {where_clause}", params)
        total_rows = cursor.fetchone()[0]

        while True:
            query = f"""
                SELECT * FROM tbl_sell_out_pre_aggregated_data
                {where_clause}
                LIMIT %s OFFSET %s
            """
            query_params = params + [BATCH_SIZE, offset]
            cursor.execute(query, query_params)
            rows = cursor.fetchall()
            if not rows:
                break

            transformed = []
            for r in rows:

                ba_ids = ",".join(map(str, parse_array(r[5])))
                brand_ids = ",".join(map(str, parse_array(r[6])))
                ba_types = ",".join(map(str, parse_array(r[7])))
                transformed.append((
                    int(r[0]), int(r[1]), int(r[2]),
                    str(r[3] or ""), str(r[4] or ""),
                    ba_ids, brand_ids, ba_types,
                    int(r[8] or 0), int(r[9] or 0),
                    str(r[10] or ""), float(r[11] or 0), float(r[12] or 0),
                    float(r[13] or 0), str(r[14] or ""), str(r[15] or ""),
                    str(r[16] or ""), str(r[17] or ""), int(r[18] or 0),
                    int(r[19] or 0), int(r[20] or 0), int(r[21] or 0),
                    int(r[22] or 0), int(r[23] or 0), str(r[24] or ""),
                    str(r[25] or ""), int(r[26] or 0), int(r[27] or 0),
                    r[28].decode('utf-8') if isinstance(r[28], (bytes, bytearray)) else str(r[28] or ""), float(r[29] or 0), float(r[30] or 0),
                    float(r[31] or 0),
                    r[32] if isinstance(r[32], datetime) else datetime.now(),
                    r[33] if isinstance(r[33], datetime) else datetime.now(),
                ))

            ch_client.insert(
                "tbl_sell_out_pre_aggregated_data",
                transformed,
                column_names=[
                    "id","year","month","customer_payment_group","store_code",
                    "ba_ids","brand_ids","ba_types","area_id","asc_id",
                    "company","gross_sales","net_sales","quantity","itmcde",
                    "itmdsc","brncde","itmclacde","item_class_id",
                    "label_type_category_id","category_2_id","category_3_id",
                    "category_4_id","brand_id","cusitmcde","store_name",
                    "brand_type_id","brand_term_id","sku_codes","amount",
                    "unit_price","net_price","created_at","updated_at"
                ]
            )

            total_inserted += len(transformed)
            offset += BATCH_SIZE
            print(f"Inserted {total_inserted}/{total_rows} rows...")

    maria_conn.close()
    print(f"Migration complete! Total rows inserted: {total_inserted}")

if __name__ == "__main__":
    import argparse

    parser = argparse.ArgumentParser(description="Migrate sell-out data from MariaDB to ClickHouse")
    parser.add_argument("--year", type=int, help="Filter by year")
    parser.add_argument("--company", type=int, help="Filter by company name")
    parser.add_argument("--month", type=int, help="Filter by month")
    parser.add_argument("--payment_group", type=str, help="Filter by customer payment group")

    args = parser.parse_args()

    migrate_data(
        year=args.year,
        company=args.company,
        month=args.month,
        payment_group=args.payment_group
    )
