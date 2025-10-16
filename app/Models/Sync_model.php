<?php

namespace App\Models;

use CodeIgniter\Model;
use Ramsey\Uuid\Uuid;

class Sync_model extends Model
{
    protected $traccLmiDB;
    protected $traccRgdiDB;
    protected $sfaDB; 

    public function __construct()
    {
        parent::__construct();
        $this->traccLmiDB = \Config\Database::connect('traccdatalmi');
        $this->traccRgdiDB = \Config\Database::connect('traccdatargdi');
        $this->sfaDB = \Config\Database::connect('default');
    }

    private function esc($value): string
    {
        return addslashes((string) $value);
    }

    //optimized version
    public function syncDataPriceCodeLMI($where, $batchSize = 5000)
    {
        $offset = 0;
        $totalRecordsSynced = 0;
        $errorMessage = null;
        $status = 'success';
        $filter = strtolower($where);
        try {
            $this->sfaDB->query("TRUNCATE TABLE tbl_price_code_file_2_lmi");
            while (true) {
                $sourceData = $this->traccLmiDB->table('pricecodefile2')
                                            // ->where('LOWER(prccde)', $filter) //removed filter to accomodate all accounts
                                             ->limit($batchSize, $offset)
                                             ->get()
                                             ->getResultArray();

                if (empty($sourceData)) {
                    break;
                }

                $values = [];
                foreach ($sourceData as $row) {
                    $values[] = "(
                        '" . $this->esc($row['recid']) . "',
                        " . (empty($row['prcdte']) ? "NULL" : "'" . $this->esc($row['prcdte']) . "'") . ",
                        " . (empty($row['upddte']) ? "NULL" : "'" . $this->esc($row['upddte']) . "'") . ",
                        '" . $this->esc($row['prccde']) . "',
                        '" . $this->esc($row['itmcde']) . "',
                        '" . $this->esc($row['itmdsc']) . "',
                        '" . $this->esc($row['untmea']) . "',
                        '" . $this->esc($row['groprc']) . "',
                        '" . $this->esc($row['prcdst1']) . "',
                        '" . $this->esc($row['prcdst2']) . "',
                        '" . $this->esc($row['prcdst3']) . "',
                        '" . $this->esc($row['prcdst4']) . "',
                        '" . $this->esc($row['untprc']) . "',
                        '" . $this->esc($row['curcde']) . "',
                        '" . $this->esc($row['disper']) . "',
                        '" . $this->esc($row['markup']) . "',
                        '" . $this->esc($row['untcst']) . "',
                        '" . $this->esc($row['disamt']) . "',
                        '" . $this->esc($row['groprcgross']) . "',
                        '" . $this->esc($row['cusitmcde']) . "',
                        '" . $this->esc($row['salquota']) . "',
                        '" . $this->esc($row['cusitmdsc']) . "',
                        '" . $this->esc($row['gwpbasis']) . "'
                    )";
                }

                if (!empty($values)) {
                    $sql = "INSERT INTO tbl_price_code_file_2_lmi (recid, prcdte, upddte, prccde, itmcde, itmdsc, untmea, groprc, prcdst1, prcdst2, prcdst3, prcdst4, untprc, curcde, disper, markup, untcst, disamt, groprcgross, cusitmcde, salquota, cusitmdsc, gwpbasis) 
                            VALUES " . implode(',', $values) . "
                            ON DUPLICATE KEY UPDATE 
                              prcdte = VALUES(prcdte), 
                              upddte = VALUES(upddte), 
                              prccde = VALUES(prccde),
                              itmcde = VALUES(itmcde),
                              itmdsc = VALUES(itmdsc),
                              untmea = VALUES(untmea),
                              groprc = VALUES(groprc),
                              prcdst1 = VALUES(prcdst1),
                              prcdst2 = VALUES(prcdst2),
                              prcdst3 = VALUES(prcdst3),
                              prcdst4 = VALUES(prcdst4),
                              untprc = VALUES(untprc),
                              curcde = VALUES(curcde),
                              disper = VALUES(disper),
                              markup = VALUES(markup),
                              untcst = VALUES(untcst),
                              disamt = VALUES(disamt),
                              groprcgross = VALUES(groprcgross),
                              cusitmcde = VALUES(cusitmcde),
                              salquota = VALUES(salquota),
                              cusitmdsc = VALUES(cusitmdsc),
                              gwpbasis = VALUES(gwpbasis)";

                    $this->sfaDB->query($sql);
                    $totalRecordsSynced += count($sourceData);
                }

                $offset += $batchSize;
            }
        } catch (\Exception $e) {
            $status = 'error';
            $errorMessage = $e->getMessage();
        }    
        return $status === 'success' ? "Data sync completed for Price Code LMI with $totalRecordsSynced records." : "Sync failed. $errorMessage.";
    }

    public function syncDataPriceCodeRGDI($where, $batchSize = 5000)
    {
        $offset = 0;
        $totalRecordsSynced = 0;
        $errorMessage = null;
        $status = 'success';
        $filter = strtolower($where);
        try {
            $this->sfaDB->query("TRUNCATE TABLE tbl_price_code_file_2_rgdi");
            while (true) {
                $sourceData = $this->traccRgdiDB->table('pricecodefile2')
                                            // ->where('LOWER(prccde)', $filter) //removed filter to accomodate all accounts
                                             ->limit($batchSize, $offset)
                                             ->get()
                                             ->getResultArray();

                if (empty($sourceData)) {
                    break;
                }

                $values = [];
                foreach ($sourceData as $row) {
                    $values[] = "(
                        '" . $this->esc($row['recid']) . "',
                        " . (empty($row['prcdte']) ? "NULL" : "'" . $this->esc($row['prcdte']) . "'") . ",
                        " . (empty($row['upddte']) ? "NULL" : "'" . $this->esc($row['upddte']) . "'") . ",
                        '" . $this->esc($row['prccde']) . "',
                        '" . $this->esc($row['itmcde']) . "',
                        '" . $this->esc($row['itmdsc']) . "',
                        '" . $this->esc($row['untmea']) . "',
                        '" . $this->esc($row['groprc']) . "',
                        '" . $this->esc($row['prcdst1']) . "',
                        '" . $this->esc($row['prcdst2']) . "',
                        '" . $this->esc($row['prcdst3']) . "',
                        '" . $this->esc($row['prcdst4']) . "',
                        '" . $this->esc($row['untprc']) . "',
                        '" . $this->esc($row['curcde']) . "',
                        '" . $this->esc($row['disper']) . "',
                        '" . $this->esc($row['markup']) . "',
                        '" . $this->esc($row['untcst']) . "',
                        '" . $this->esc($row['disamt']) . "',
                        '" . $this->esc($row['groprcgross']) . "',
                        '" . $this->esc($row['cusitmcde']) . "',
                        '" . $this->esc($row['salquota']) . "',
                        '" . $this->esc($row['cusitmdsc']) . "',
                        '" . $this->esc($row['gwpbasis']) . "'
                    )";
                }

                if (!empty($values)) {
                    $sql = "INSERT INTO tbl_price_code_file_2_rgdi (recid, prcdte, upddte, prccde, itmcde, itmdsc, untmea, groprc, prcdst1, prcdst2, prcdst3, prcdst4, untprc, curcde, disper, markup, untcst, disamt, groprcgross, cusitmcde, salquota, cusitmdsc, gwpbasis) 
                            VALUES " . implode(',', $values) . "
                            ON DUPLICATE KEY UPDATE 
                              prcdte = VALUES(prcdte), 
                              upddte = VALUES(upddte), 
                              prccde = VALUES(prccde),
                              itmcde = VALUES(itmcde),
                              itmdsc = VALUES(itmdsc),
                              untmea = VALUES(untmea),
                              groprc = VALUES(groprc),
                              prcdst1 = VALUES(prcdst1),
                              prcdst2 = VALUES(prcdst2),
                              prcdst3 = VALUES(prcdst3),
                              prcdst4 = VALUES(prcdst4),
                              untprc = VALUES(untprc),
                              curcde = VALUES(curcde),
                              disper = VALUES(disper),
                              markup = VALUES(markup),
                              untcst = VALUES(untcst),
                              disamt = VALUES(disamt),
                              groprcgross = VALUES(groprcgross),
                              cusitmcde = VALUES(cusitmcde),
                              salquota = VALUES(salquota),
                              cusitmdsc = VALUES(cusitmdsc),
                              gwpbasis = VALUES(gwpbasis)";

                    $this->sfaDB->query($sql);
                    $totalRecordsSynced += count($sourceData);
                }

                $offset += $batchSize;
            }
        } catch (\Exception $e) {
            $status = 'error';
            $errorMessage = $e->getMessage();
        }    
        return $status === 'success' ? "Data sync completed for Price Code RGDI with $totalRecordsSynced records." : "Sync failed. $errorMessage.";
    }

    public function syncDataitemfileLMI($where, $brandCode, $batchSize = 5000)
    {
        $offset = 0;
        $totalRecordsSynced = 0;
        $errorMessage = null;
        $status = 'success';
        $filter = strtolower($where);
        $brandCode = array_map('strtolower', $brandCode);
        try {
            $this->sfaDB->query("TRUNCATE TABLE tbl_itemfile_lmi");
            while (true) {
                $builder = $this->traccLmiDB->table('itemfile');
                $builder->where('LOWER(itmtyp)', $filter);
                foreach ($brandCode as $bc) {
                    $builder->where('LOWER(brncde) !=', $bc);
                }
                $sourceData =    $builder
                                 ->limit($batchSize, $offset)
                                 ->get()
                                 ->getResultArray();

                if (empty($sourceData)) {
                    break;
                }

                $values = [];
                foreach ($sourceData as $row) {
                    $values[] = "(
                        '" . $this->esc($row['recid']) . "',
                        '" . $this->esc($row['supdsc']) . "',
                        '" . $this->esc($row['itmcde']) . "',
                        '" . $this->esc($row['itmdsc']) . "',
                        '" . $this->esc($row['untmea']) . "',
                        '" . $this->esc($row['conver']) . "',
                        '" . $this->esc($row['untcst1']) . "',
                        '" . $this->esc($row['untcst2']) . "',
                        '" . $this->esc($row['crilvl']) . "',
                        '" . $this->esc($row['remarks']) . "',
                        '" . $this->esc($row['wardsc']) . "',
                        '" . $this->esc($row['avecst']) . "',
                        '" . $this->esc($row['status']) . "',
                        '" . $this->esc($row['untcst']) . "',
                        '" . $this->esc($row['untprc']) . "',
                        '" . $this->esc($row['brndsc']) . "',
                        '" . $this->esc($row['itmcladsc']) . "',
                        '" . $this->esc($row['supcde']) . "',
                        '" . $this->esc($row['warcde']) . "',
                        '" . $this->esc($row['brncde']) . "',
                        '" . $this->esc($row['itmclacde']) . "',
                        '" . $this->esc($row['barcde']) . "',
                        '" . $this->esc($row['inactive']) . "',
                        '" . $this->esc($row['itmtyp']) . "',
                        '" . $this->esc($row['multium']) . "',
                        '" . $this->esc($row['reqsernum']) . "',
                        '" . $this->esc($row['taxcde']) . "',
                        '" . $this->esc($row['itmbal']) . "',
                        '" . $this->esc($row['itmclass']) . "',
                        '" . $this->esc($row['itmsrc']) . "'
                    )";
                }

                if (!empty($values)) {
                    $sql = "INSERT INTO tbl_itemfile_lmi (recid, supdsc, itmcde, itmdsc, untmea, conver, untcst1, untcst2, crilvl, remarks, wardsc, avecst, status, untcst, untprc, brndsc, itmcladsc, supcde, warcde, brncde, itmclacde, barcde, inactive, itmtyp, multium, reqsernum, taxcde, itmbal, itmclass, itmsrc) 
                            VALUES " . implode(',', $values) . "
                            ON DUPLICATE KEY UPDATE 
                              supdsc = VALUES(supdsc),
                              itmcde = VALUES(itmcde),
                              itmdsc = VALUES(itmdsc),
                              untmea = VALUES(untmea),
                              conver = VALUES(conver),
                              untcst1 = VALUES(untcst1),
                              untcst2 = VALUES(untcst2),
                              crilvl = VALUES(crilvl),
                              remarks = VALUES(remarks),
                              wardsc = VALUES(wardsc),
                              avecst = VALUES(avecst),
                              status = VALUES(status),
                              untcst = VALUES(untcst),
                              untprc = VALUES(untprc),
                              brndsc = VALUES(brndsc),
                              itmcladsc = VALUES(itmcladsc),
                              supcde = VALUES(supcde),
                              warcde = VALUES(warcde),
                              brncde = VALUES(brncde),
                              itmclacde = VALUES(itmclacde),
                              barcde = VALUES(barcde),
                              inactive = VALUES(inactive),
                              itmtyp = VALUES(itmtyp),
                              multium = VALUES(multium),
                              reqsernum = VALUES(reqsernum),
                              taxcde = VALUES(taxcde),
                              itmbal = VALUES(itmbal),
                              itmclass = VALUES(itmclass),
                              itmsrc = VALUES(itmsrc)";

                    $this->sfaDB->query($sql);
                    $totalRecordsSynced += count($sourceData);
                }

                $offset += $batchSize;
            }
        } catch (\Exception $e) {
            $status = 'error';
            $errorMessage = $e->getMessage();
        }    
        return $status === 'success' ? "Data sync completed for Item File LMI with $totalRecordsSynced records." : "Sync failed. $errorMessage.";
    }

    public function syncDataitemfileRGDI($where, $brandCode, $batchSize = 5000)
    {
        $offset = 0;
        $totalRecordsSynced = 0;
        $errorMessage = null;
        $status = 'success';
        $filter = strtolower($where);
        $brandCode = array_map('strtolower', $brandCode);
        try {
            $this->sfaDB->query("TRUNCATE TABLE tbl_itemfile_rgdi");
            while (true) {
                $builder = $this->traccRgdiDB->table('itemfile');
                $builder->where('LOWER(itmtyp)', $filter);
                foreach ($brandCode as $bc) {
                    $builder->where('LOWER(brncde) !=', $bc);
                }
                $sourceData =    $builder
                                 ->limit($batchSize, $offset)
                                 ->get()
                                 ->getResultArray();

                if (empty($sourceData)) {
                    break;
                }

                $values = [];
                foreach ($sourceData as $row) {
                    $values[] = "(
                        '" . $this->esc($row['recid']) . "',
                        '" . $this->esc($row['supdsc']) . "',
                        '" . $this->esc($row['itmcde']) . "',
                        '" . $this->esc($row['itmdsc']) . "',
                        '" . $this->esc($row['untmea']) . "',
                        '" . $this->esc($row['conver']) . "',
                        '" . $this->esc($row['untcst1']) . "',
                        '" . $this->esc($row['untcst2']) . "',
                        '" . $this->esc($row['crilvl']) . "',
                        '" . $this->esc($row['remarks']) . "',
                        '" . $this->esc($row['wardsc']) . "',
                        '" . $this->esc($row['avecst']) . "',
                        '" . $this->esc($row['status']) . "',
                        '" . $this->esc($row['untcst']) . "',
                        '" . $this->esc($row['untprc']) . "',
                        '" . $this->esc($row['brndsc']) . "',
                        '" . $this->esc($row['itmcladsc']) . "',
                        '" . $this->esc($row['supcde']) . "',
                        '" . $this->esc($row['warcde']) . "',
                        '" . $this->esc($row['brncde']) . "',
                        '" . $this->esc($row['itmclacde']) . "',
                        '" . $this->esc($row['barcde']) . "',
                        '" . $this->esc($row['inactive']) . "',
                        '" . $this->esc($row['itmtyp']) . "',
                        '" . $this->esc($row['multium']) . "',
                        '" . $this->esc($row['reqsernum']) . "',
                        '" . $this->esc($row['taxcde']) . "',
                        '" . $this->esc($row['itmbal']) . "',
                        '" . $this->esc($row['itmclass']) . "',
                        '" . $this->esc($row['itmsrc']) . "'
                    )";
                }

                if (!empty($values)) {
                    $sql = "INSERT INTO tbl_itemfile_rgdi (recid, supdsc, itmcde, itmdsc, untmea, conver, untcst1, untcst2, crilvl, remarks, wardsc, avecst, status, untcst, untprc, brndsc, itmcladsc, supcde, warcde, brncde, itmclacde, barcde, inactive, itmtyp, multium, reqsernum, taxcde, itmbal, itmclass, itmsrc) 
                            VALUES " . implode(',', $values) . "
                            ON DUPLICATE KEY UPDATE 
                              supdsc = VALUES(supdsc),
                              itmcde = VALUES(itmcde),
                              itmdsc = VALUES(itmdsc),
                              untmea = VALUES(untmea),
                              conver = VALUES(conver),
                              untcst1 = VALUES(untcst1),
                              untcst2 = VALUES(untcst2),
                              crilvl = VALUES(crilvl),
                              remarks = VALUES(remarks),
                              wardsc = VALUES(wardsc),
                              avecst = VALUES(avecst),
                              status = VALUES(status),
                              untcst = VALUES(untcst),
                              untprc = VALUES(untprc),
                              brndsc = VALUES(brndsc),
                              itmcladsc = VALUES(itmcladsc),
                              supcde = VALUES(supcde),
                              warcde = VALUES(warcde),
                              brncde = VALUES(brncde),
                              itmclacde = VALUES(itmclacde),
                              barcde = VALUES(barcde),
                              inactive = VALUES(inactive),
                              itmtyp = VALUES(itmtyp),
                              multium = VALUES(multium),
                              reqsernum = VALUES(reqsernum),
                              taxcde = VALUES(taxcde),
                              itmbal = VALUES(itmbal),
                              itmclass = VALUES(itmclass),
                              itmsrc = VALUES(itmsrc)";

                    $this->sfaDB->query($sql);
                    $totalRecordsSynced += count($sourceData);
                }

                $offset += $batchSize;
            }
        } catch (\Exception $e) {
            $status = 'error';
            $errorMessage = $e->getMessage();
        }    
        return $status === 'success' ? "Data sync completed for Item File RGDI with $totalRecordsSynced records." : "Sync failed. $errorMessage.";
    }
    
    public function syncBrandData($batchSize = 5000)
    {
        $offset = 0;
        $totalRecordsSynced = 0;
        $errorMessage = null;
        $status = 'success';
        try {
            //$this->sfaDB->query("TRUNCATE TABLE tbl_brand");
            while (true) {
                $sourceData = $this->traccLmiDB->table('brandfile')
                                               ->limit($batchSize, $offset)
                                               ->get()
                                               ->getResultArray();

                if (empty($sourceData)) {
                    break;
                }

                $values = [];
                foreach ($sourceData as $row) {
                    $values[] = "(
                        '" . $this->esc($row['recid']) . "',
                        '" . $this->esc($row['brncde']) . "',
                        '" . $this->esc($row['brndsc']) . "',
                        '" . $this->esc($row['category_id']) . "',
                        '" . $this->esc($row['terms_id']) . "',
                        1, 
                        NULL,
                        NULL,
                        1, 
                        NULL
                    )";
                }

                if (!empty($values)) {
                    $sql = "INSERT INTO tbl_brand (id, brand_code, brand_description, category_id, terms_id, status, created_date, updated_date, created_by, updated_by) 
                            VALUES " . implode(',', $values) . "
                            ON DUPLICATE KEY UPDATE 
                              brand_code = VALUES(brand_code), 
                              brand_description = VALUES(brand_description),
                              category_id = VALUES(category_id),
                              terms_id = VALUES(terms_id),
                              status = 1,
                              created_date = created_date,
                              updated_date = updated_date,
                              created_by = created_by,
                              updated_by = 1;";

                    $this->sfaDB->query($sql);
                    $totalRecordsSynced += count($sourceData);
                }

                $offset += $batchSize;
            }
        } catch (\Exception $e) {
            $status = 'error';
            $errorMessage = $e->getMessage();
        }    
        return $status === 'success' ? "Data sync completed for Brand with $totalRecordsSynced records." : "Sync failed. $errorMessage.";
    }

    public function syncBrandLabelData($batchSize = 5000)
    {
        $offset = 0;
        $totalRecordsSynced = 0;
        $errorMessage = null;
        $status = 'success';
        try {
            $this->sfaDB->query("TRUNCATE TABLE tbl_brand_label_type");
            while (true) {
                $sourceData = $this->traccLmiDB->table('brand_label_type')
                                               ->limit($batchSize, $offset)
                                               ->get()
                                               ->getResultArray();

                if (empty($sourceData)) {
                    break;
                }

                $values = [];
                foreach ($sourceData as $row) {
                    $values[] = "(
                        '" . $this->esc($row['id']) . "',
                        '" . $this->esc($row['label']) . "',
                        '" . $this->esc($row['created_date']) . "',
                        '" . $this->esc($row['modified_date']) . "'
                    )";
                }

                if (!empty($values)) {
                    $sql = "INSERT INTO tbl_brand_label_type (id, label, created_date, modified_date) 
                            VALUES " . implode(',', $values) . "
                            ON DUPLICATE KEY UPDATE 
                              label = VALUES(label),
                              status = 1,
                              created_date = VALUES(created_date),
                              modified_date = VALUES(modified_date);";

                    $this->sfaDB->query($sql);
                    $totalRecordsSynced += count($sourceData);
                }

                $offset += $batchSize;
            }
        } catch (\Exception $e) {
            $status = 'error';
            $errorMessage = $e->getMessage();
        }    
        return $status === 'success' ? "Data sync completed for Brand Label with $totalRecordsSynced records." : "Sync failed. $errorMessage.";
    }   

    public function syncBrandTermData($batchSize = 5000)
    {
        $offset = 0;
        $totalRecordsSynced = 0;
        $errorMessage = null;
        $status = 'success';
        try {
            $this->sfaDB->query("TRUNCATE TABLE tbl_brand_terms");
            while (true) {
                $sourceData = $this->traccLmiDB->table('brand_terms')
                                               ->limit($batchSize, $offset)
                                               ->get()
                                               ->getResultArray();

                if (empty($sourceData)) {
                    break;
                }

                $values = [];
                foreach ($sourceData as $row) {
                    $values[] = "(
                        '" . $this->esc($row['id']) . "',
                        '" . $this->esc($row['terms']) . "',
                        '" . $this->esc($row['sfa_filter']) . "',
                        '" . $this->esc($row['created_date']) . "',
                        '" . $this->esc($row['modified_date']) . "'
                    )";
                }

                if (!empty($values)) {
                    $sql = "INSERT INTO tbl_brand_terms (id, terms, sfa_filter, created_date, modified_date) 
                            VALUES " . implode(',', $values) . "
                            ON DUPLICATE KEY UPDATE 
                              terms = VALUES(terms),
                              sfa_filter = VALUES(sfa_filter), 
                              created_date = VALUES(created_date),
                              modified_date = VALUES(modified_date);";

                    $this->sfaDB->query($sql);
                    $totalRecordsSynced += count($sourceData);
                }

                $offset += $batchSize;
            }
        } catch (\Exception $e) {
            $status = 'error';
            $errorMessage = $e->getMessage();
        }    
        return $status === 'success' ? "Data sync completed for Brand Term with $totalRecordsSynced records." : "Sync failed. $errorMessage.";
    }  

    public function syncClassificationData($batchSize = 5000)
    {
        $offset = 0;
        $totalRecordsSynced = 0;
        $errorMessage = null;
        $status = 'success';
        try {
            $this->sfaDB->query("TRUNCATE TABLE tbl_classification");
            while (true) {
                $sourceData = $this->traccLmiDB->table('itemclassfile')
                                               ->limit($batchSize, $offset)
                                               ->get()
                                               ->getResultArray();

                if (empty($sourceData)) {
                    break;
                }

                $values = [];
                foreach ($sourceData as $row) {
                    $values[] = "(
                        '" . $this->esc($row['recid']) . "',
                        '" . $this->esc($row['itmclacde']) . "',
                        '" . $this->esc($row['itmcladsc']) . "',
                        1, 
                        NULL,
                        NULL, 
                        1, 
                        NULL
                    )";
                }

                if (!empty($values)) {
                    $sql = "INSERT INTO tbl_classification (id, item_class_code, item_class_description, status, created_date, updated_date, created_by, updated_by) 
                            VALUES " . implode(',', $values) . "
                            ON DUPLICATE KEY UPDATE 
                              item_class_code = VALUES(item_class_code), 
                              item_class_description = VALUES(item_class_description), 
                              status = 1,
                              created_date = created_date,
                              updated_date = updated_date,
                              created_by = created_by,
                              updated_by = 1;";

                    $this->sfaDB->query($sql);
                    $totalRecordsSynced += count($sourceData);
                }

                $offset += $batchSize;
            }
        } catch (\Exception $e) {
            $status = 'error';
            $errorMessage = $e->getMessage();
        }    
        return $status === 'success' ? "Data sync completed for Classification with $totalRecordsSynced records." : "Sync failed. $errorMessage.";
    }

    public function syncSubClassificationData($batchSize = 5000)
    {
        $offset = 0;
        $totalRecordsSynced = 0;
        $errorMessage = null;
        $status = 'success';
        try {
            $this->sfaDB->query("TRUNCATE TABLE tbl_sub_classification");
            while (true) {
                $sourceData = $this->traccLmiDB->table('itemsubclassfile')
                                               ->limit($batchSize, $offset)
                                               ->get()
                                               ->getResultArray();

                if (empty($sourceData)) {
                    break;
                }

                $values = [];
                foreach ($sourceData as $row) {
                    $values[] = "(
                        '" . $this->esc($row['recid']) . "',
                        '" . $this->esc($row['itmclacde']) . "',
                        '" . $this->esc($row['itmcladsc']) . "',
                        '" . $this->esc($row['itmsubclacde']) . "',
                        '" . $this->esc($row['itmsubcladsc']) . "',
                        1, 
                        NULL,
                        NULL, 
                        1, 
                        NULL
                    )";
                }

                if (!empty($values)) {
                    $sql = "INSERT INTO tbl_sub_classification (id, item_class_code, item_class_description, item_sub_class_code, item_sub_class_description, status, created_date, updated_date, created_by, updated_by) 
                            VALUES " . implode(',', $values) . "
                            ON DUPLICATE KEY UPDATE 
                              item_class_code = VALUES(item_class_code), 
                              item_class_description = VALUES(item_class_description), 
                              item_sub_class_code = VALUES(item_sub_class_code), 
                              item_sub_class_description = VALUES(item_sub_class_description), 
                              status = 1,
                              created_date = created_date,
                              updated_date = updated_date,
                              created_by = created_by,
                              updated_by = 1;";

                    $this->sfaDB->query($sql);
                    $totalRecordsSynced += count($sourceData);
                }

                $offset += $batchSize;
            }
        } catch (\Exception $e) {
            $status = 'error';
            $errorMessage = $e->getMessage();
        }    
        return $status === 'success' ? "Data sync completed for Sub Classification with $totalRecordsSynced records." : "Sync failed. $errorMessage.";
    }

    public function syncDeptData($batchSize = 5000)
    {
        $offset = 0;
        $totalRecordsSynced = 0;
        $errorMessage = null;
        $status = 'success';
        try {
            $this->sfaDB->query("TRUNCATE TABLE tbl_item_department");
            while (true) {
                $sourceData = $this->traccLmiDB->table('itemdeptfile')
                                               ->limit($batchSize, $offset)
                                               ->get()
                                               ->getResultArray();

                if (empty($sourceData)) {
                    break;
                }

                $values = [];
                foreach ($sourceData as $row) {
                    $values[] = "(
                        '" . $this->esc($row['recid']) . "',
                        '" . $this->esc($row['itmdeptcde']) . "',
                        '" . $this->esc($row['itmdeptdsc']) . "',
                        1, 
                        NULL,
                        NULL, 
                        1, 
                        NULL
                    )";
                }

                if (!empty($values)) {
                    $sql = "INSERT INTO tbl_item_department (id, item_department_code, item_department_description, status, created_date, updated_date, created_by, updated_by) 
                            VALUES " . implode(',', $values) . "
                            ON DUPLICATE KEY UPDATE 
                              item_department_code = VALUES(item_department_code), 
                              item_department_description = VALUES(item_department_description), 
                              status = 1,
                              created_date = created_date,
                              updated_date = updated_date,
                              created_by = created_by,
                              updated_by = 1;";

                    $this->sfaDB->query($sql);
                    $totalRecordsSynced += count($sourceData);
                }

                $offset += $batchSize;
            }
        } catch (\Exception $e) {
            $status = 'error';
            $errorMessage = $e->getMessage();
        }    
        return $status === 'success' ? "Data sync completed for Item Department with $totalRecordsSynced records." : "Sync failed. $errorMessage.";
    }

    public function syncMerchData($batchSize = 5000)
    {
        $offset = 0;
        $totalRecordsSynced = 0;
        $errorMessage = null;
        $status = 'success';
        try {
            $this->sfaDB->query("TRUNCATE TABLE tbl_item_merchandise_category");
            while (true) {
                $sourceData = $this->traccLmiDB->table('itemmerchandisecategoryfile')
                                               ->limit($batchSize, $offset)
                                               ->get()
                                               ->getResultArray();

                if (empty($sourceData)) {
                    break;
                }

                $values = [];
                foreach ($sourceData as $row) {
                    $values[] = "(
                        '" . $this->esc($row['recid']) . "',
                        '" . $this->esc($row['itmmerchcatcde']) . "',
                        '" . $this->esc($row['itmmerchcatdsc']) . "',
                        1, 
                        NULL,
                        NULL, 
                        1, 
                        NULL
                    )";
                }

                if (!empty($values)) {
                    $sql = "INSERT INTO tbl_item_merchandise_category (id, item_mech_cat_code, item_merch_cat_description, status, created_date, updated_date, created_by, updated_by) 
                            VALUES " . implode(',', $values) . "
                            ON DUPLICATE KEY UPDATE 
                              item_mech_cat_code = VALUES(item_mech_cat_code), 
                              item_merch_cat_description = VALUES(item_merch_cat_description), 
                              status = 1,
                              created_date = created_date,
                              updated_date = updated_date,
                              created_by = created_by,
                              updated_by = 1;";

                    $this->sfaDB->query($sql);
                    $totalRecordsSynced += count($sourceData);
                }

                $offset += $batchSize;
            }
        } catch (\Exception $e) {
            $status = 'error';
            $errorMessage = $e->getMessage();
        }    
        return $status === 'success' ? "Data sync completed for Item Merch Category with $totalRecordsSynced records." : "Sync failed. $errorMessage.";
    }

    public function syncCusPaymentGroupLmiData($where, $batchSize = 5000)
    {
        $offset = 0;
        $totalRecordsSynced = 0;
        $errorMessage = null;
        $status = 'success';
        $filter = strtolower($where);
        try {
            $this->sfaDB->query("TRUNCATE TABLE tbl_cus_payment_group_lmi");
            while (true) {
                $sourceData = $this->traccLmiDB->table('customergroupfile')
                                               //->where('LOWER(cusgrpcde)', $filter) // removed this to get all the payment group
                                               ->limit($batchSize, $offset)
                                               ->get()
                                               ->getResultArray();

                if (empty($sourceData)) {
                    break;
                }

                $values = [];
                foreach ($sourceData as $row) {
                    $values[] = "(
                        '" . $this->esc($row['recid']) . "',
                        '" . $this->esc($row['cusgrpcde']) . "',
                        1, 
                        NULL,
                        NULL, 
                        1, 
                        NULL
                    )";
                }

                if (!empty($values)) {
                    $sql = "INSERT INTO tbl_cus_payment_group_lmi (id, customer_group_code, status, created_date, updated_date, created_by, updated_by) 
                            VALUES " . implode(',', $values) . "
                            ON DUPLICATE KEY UPDATE 
                              customer_group_code = VALUES(customer_group_code), 
                              status = 1,
                              created_date = created_date,
                              updated_date = updated_date,
                              created_by = created_by,
                              updated_by = 1;";

                    $this->sfaDB->query($sql);
                    $totalRecordsSynced += count($sourceData);
                }

                $offset += $batchSize;
            }
        } catch (\Exception $e) {
            $status = 'error';
            $errorMessage = $e->getMessage();
        }    
        return $status === 'success' ? "Data sync completed for Customer Payment Group LMI with $totalRecordsSynced records." : "Sync failed. $errorMessage.";
    }

    public function syncCusPaymentGroupRgdiData($where, $batchSize = 5000)
    {
        $offset = 0;
        $totalRecordsSynced = 0;
        $errorMessage = null;
        $status = 'success';
        $filter = strtolower($where);
        try {
            $this->sfaDB->query("TRUNCATE TABLE tbl_cus_payment_group_rgdi");
            while (true) {
                $sourceData = $this->traccRgdiDB->table('customergroupfile')
                                               //->where('LOWER(cusgrpcde)', $filter) // removed this to get all the payment group
                                               ->limit($batchSize, $offset)
                                               ->get()
                                               ->getResultArray();

                if (empty($sourceData)) {
                    break;
                }

                $values = [];
                foreach ($sourceData as $row) {
                    $values[] = "(
                        '" . $this->esc($row['recid']) . "',
                        '" . $this->esc($row['cusgrpcde']) . "',
                        1, 
                        NULL,
                        NULL, 
                        1, 
                        NULL
                    )";
                }

                if (!empty($values)) {
                    $sql = "INSERT INTO tbl_cus_payment_group_rgdi (id, customer_group_code, status, created_date, updated_date, created_by, updated_by) 
                            VALUES " . implode(',', $values) . "
                            ON DUPLICATE KEY UPDATE 
                              customer_group_code = VALUES(customer_group_code), 
                              status = 1,
                              created_date = created_date,
                              updated_date = updated_date,
                              created_by = created_by,
                              updated_by = 1;";

                    $this->sfaDB->query($sql);
                    $totalRecordsSynced += count($sourceData);
                }

                $offset += $batchSize;
            }
        } catch (\Exception $e) {
            $status = 'error';
            $errorMessage = $e->getMessage();
        }    
        return $status === 'success' ? "Data sync completed for Customer Payment Group RGDI with $totalRecordsSynced records." : "Sync failed. $errorMessage.";
    }

    public function syncCustomerLmiData($where, $batchSize = 5000)
    {
        $offset = 0;
        $totalRecordsSynced = 0;
        $errorMessage = null;
        $status = 'success';
        $filter = strtolower($where);
        try {
            $this->sfaDB->query("TRUNCATE TABLE tbl_customer_lmi");
            while (true) {
                $sourceData = $this->traccLmiDB->table('customerfile')
                                               //->where('LOWER(prccde)', $filter) // removed this to get all the payment group
                                               ->limit($batchSize, $offset)
                                               ->get()
                                               ->getResultArray();

                if (empty($sourceData)) {
                    break;
                }

                $values = [];
                foreach ($sourceData as $row) {
                    $values[] = "(
                        '" . $this->esc($row['recid']) . "',
                        '" . $this->esc($row['warcde']) . "',
                        '" . $this->esc($row['cuscde']) . "',
                        '" . $this->esc($row['cusdsc']) . "',
                        '" . $this->esc($row['trmcde']) . "',
                        '" . $this->esc($row['cusadd1']) . "',
                        '" . $this->esc($row['tinnum']) . "',
                        '" . $this->esc($row['smncde']) . "',
                        '" . $this->esc($row['prccde']) . "',
                        '" . $this->esc($row['aractcde']) . "',
                        '" . $this->esc($row['cusgrpdsc']) . "',
                        '" . $this->esc($row['curcde']) . "',
                        '" . $this->esc($row['advactcde']) . "',
                        '" . $this->esc($row['consig']) . "',
                        '" . $this->esc($row['outright']) . "',
                        '" . $this->esc($row['warcdenum']) . "',
                        '" . $this->esc($row['warloccde']) . "',
                        1, 
                        NULL,
                        NULL, 
                        1, 
                        NULL
                    )";
                }

                if (!empty($values)) {
                    $sql = "INSERT INTO tbl_customer_lmi (id, warehouse_code, customer_code, customer_description, term_code, customer_address, tin_number, salesman_code, payment_group_code, ar_account_code, customer_group_code, currency_code, advance_account_code, consignment, outright, warehouse_code_number, warehouse_location_code, status, created_date, updated_date, created_by, updated_by) 
                            VALUES " . implode(',', $values) . "
                            ON DUPLICATE KEY UPDATE 
                              customer_group_code = VALUES(customer_group_code),
                              customer_code = VALUES(customer_code), 
                              customer_description = VALUES(customer_description), 
                              term_code = VALUES(term_code), 
                              customer_address = VALUES(customer_address), 
                              tin_number = VALUES(tin_number), 
                              salesman_code = VALUES(salesman_code), 
                              payment_group_code = VALUES(payment_group_code), 
                              ar_account_code = VALUES(ar_account_code), 
                              currency_code = VALUES(currency_code), 
                              advance_account_code = VALUES(advance_account_code), 
                              consignment = VALUES(consignment), 
                              outright = VALUES(outright), 
                              warehouse_code_number = VALUES(warehouse_code_number), 
                              warehouse_location_code = VALUES(warehouse_location_code), 
                              status = 1,
                              created_date = created_date,
                              updated_date = updated_date,
                              created_by = created_by,
                              updated_by = 1;";

                    $this->sfaDB->query($sql);
                    $totalRecordsSynced += count($sourceData);
                }

                $offset += $batchSize;
            }
        } catch (\Exception $e) {
            $status = 'error';
            $errorMessage = $e->getMessage();
        }    
        return $status === 'success' ? "Data sync completed for Customer LMI with $totalRecordsSynced records." : "Sync failed. $errorMessage.";
    }

    public function syncCustomerRgdiData($where, $batchSize = 5000)
    {
        $offset = 0;
        $totalRecordsSynced = 0;
        $errorMessage = null;
        $status = 'success';
        $filter = strtolower($where);
        try {
            $this->sfaDB->query("TRUNCATE TABLE tbl_customer_rgdi");
            while (true) {
                $sourceData = $this->traccRgdiDB->table('customerfile')
                                               //->where('LOWER(prccde)', $filter) // removed this to get all the payment group
                                               ->limit($batchSize, $offset)
                                               ->get()
                                               ->getResultArray();

                if (empty($sourceData)) {
                    break;
                }

                $values = [];
                foreach ($sourceData as $row) {
                    $values[] = "(
                        '" . $this->esc($row['recid']) . "',
                        '" . $this->esc($row['warcde']) . "',
                        '" . $this->esc($row['cuscde']) . "',
                        '" . $this->esc($row['cusdsc']) . "',
                        '" . $this->esc($row['trmcde']) . "',
                        '" . $this->esc($row['cusadd1']) . "',
                        '" . $this->esc($row['tinnum']) . "',
                        '" . $this->esc($row['smncde']) . "',
                        '" . $this->esc($row['prccde']) . "',
                        '" . $this->esc($row['aractcde']) . "',
                        '" . $this->esc($row['cusgrpdsc']) . "',
                        '" . $this->esc($row['curcde']) . "',
                        '" . $this->esc($row['advactcde']) . "',
                        '" . $this->esc($row['consig']) . "',
                        '" . $this->esc($row['outright']) . "',
                        '" . $this->esc($row['warcdenum']) . "',
                        '" . $this->esc($row['warloccde']) . "',
                        1, 
                        NULL,
                        NULL, 
                        1, 
                        NULL
                    )";
                }

                if (!empty($values)) {
                    $sql = "INSERT INTO tbl_customer_rgdi (id, warehouse_code, customer_code, customer_description, term_code, customer_address, tin_number, salesman_code, payment_group_code, ar_account_code, customer_group_code, currency_code, advance_account_code, consignment, outright, warehouse_code_number, warehouse_location_code, status, created_date, updated_date, created_by, updated_by) 
                            VALUES " . implode(',', $values) . "
                            ON DUPLICATE KEY UPDATE 
                              customer_group_code = VALUES(customer_group_code),
                              customer_code = VALUES(customer_code), 
                              customer_description = VALUES(customer_description), 
                              term_code = VALUES(term_code), 
                              customer_address = VALUES(customer_address), 
                              tin_number = VALUES(tin_number), 
                              salesman_code = VALUES(salesman_code), 
                              payment_group_code = VALUES(payment_group_code), 
                              ar_account_code = VALUES(ar_account_code), 
                              currency_code = VALUES(currency_code), 
                              advance_account_code = VALUES(advance_account_code), 
                              consignment = VALUES(consignment), 
                              outright = VALUES(outright), 
                              warehouse_code_number = VALUES(warehouse_code_number), 
                              warehouse_location_code = VALUES(warehouse_location_code), 
                              status = 1,
                              created_date = created_date,
                              updated_date = updated_date,
                              created_by = created_by,
                              updated_by = 1;";

                    $this->sfaDB->query($sql);
                    $totalRecordsSynced += count($sourceData);
                }

                $offset += $batchSize;
            }
        } catch (\Exception $e) {
            $status = 'error';
            $errorMessage = $e->getMessage();
        }    
        return $status === 'success' ? "Data sync completed for Customer RGDI with $totalRecordsSynced records." : "Sync failed. $errorMessage.";
    }

    public function refreshScanData($data_header_id = null, $month = null, $year = null)
    {
        // $data_header_id = 17;
        // $month = 2;
        // $year = 2025;
        //brand_ids brands handled by BA NOT the actual brand_id of the itmcde

        if ($data_header_id && $month && $year) {
            $whereClause = "WHERE so.data_header_id = {$data_header_id} AND so.month = {$month} AND so.year = {$year}";
        }

        $sql = "
            WITH
            dedup_pclmi AS (
                SELECT cusitmcde, MIN(itmcde) AS itmcde
                FROM tbl_price_code_file_2_lmi
                GROUP BY cusitmcde
            ),
            dedup_pcrgdi AS (
                SELECT cusitmcde, MIN(itmcde) AS itmcde
                FROM tbl_price_code_file_2_rgdi
                GROUP BY cusitmcde
            ),
            dedup_pitmlmi AS (
                SELECT itmcde, itmdsc, MIN(brncde) AS brncde, MIN(itmclacde) AS itmclacde
                FROM tbl_itemfile_lmi
                GROUP BY itmcde
            ),
            dedup_itmrgdi AS (
                SELECT itmcde, itmdsc, MIN(brncde) AS brncde, MIN(itmclacde) AS itmclacde
                FROM tbl_itemfile_rgdi
                GROUP BY itmcde
            ),
            aggregated_so AS (
                SELECT
                    so.id,
                    so.year,
                    so.month,
                    so.store_code,
                    so.brand_ambassador_ids,
                    so.customer_payment_group,
                    so.brand_ids,
                    so.ba_types,
                    so.area_id,
                    so.asc_id,
                    h.company,
                    so.sku_code,
                    ROUND(SUM(COALESCE(so.gross_sales, 0)), 2) AS gross_sales,
                    ROUND(SUM(COALESCE(so.net_sales, 0)), 2) AS net_sales,
                    ROUND(SUM(COALESCE(so.quantity, 0)), 2) AS quantity
                FROM tbl_sell_out_data_details so
                INNER JOIN tbl_sell_out_data_header h ON so.data_header_id = h.id
                {$whereClause}
                GROUP BY so.id
            ),
            final_data AS (
                SELECT
                    aso.id,
                    aso.year,
                    aso.month,
                    aso.store_code,
                    aso.customer_payment_group,
                    cl.id AS item_class_id,
                    CASE 
                      WHEN mp.effectivity_date <= CURRENT_DATE() THEN mp.net_price
                      WHEN hmp.net_price IS NOT NULL THEN hmp.net_price
                      ELSE 0
                    END AS net_price
                    blt.id AS brand_type_id,
                    bbt.sfa_filter AS brand_term_id,
                    b.id AS brand_id,
                    GROUP_CONCAT(DISTINCT aso.brand_ambassador_ids) AS ba_ids,
                    GROUP_CONCAT(DISTINCT aso.brand_ids) AS brand_ids,
                    aso.ba_types,
                    aso.area_id,
                    aso.asc_id,
                    aso.company,
                    SUM(aso.gross_sales) AS gross_sales,
                    SUM(aso.net_sales) AS net_sales,
                    SUM(aso.quantity) AS quantity,
                    MIN(DISTINCT CASE WHEN aso.company = '2' THEN pclmi.itmcde ELSE pcrgdi.itmcde END) AS itmcde,
                    MIN(DISTINCT CASE WHEN aso.company = '2' THEN pclmi.cusitmcde ELSE pcrgdi.cusitmcde END) AS cusitmcde,
                    MIN(DISTINCT CASE WHEN aso.company = '2' THEN pitmlmi.itmdsc ELSE itmrgdi.itmdsc END) AS itmdsc,
                    CASE WHEN aso.company = '2' THEN pitmlmi.brncde ELSE itmrgdi.brncde END AS brncde,
                    CASE WHEN aso.company = '2' THEN pitmlmi.itmclacde ELSE itmrgdi.itmclacde END AS itmclacde,
                    CONCAT(MIN(aso.store_code), ' - ', s.description) AS store_name,
                    MIN(DISTINCT aso.sku_code) AS sku_codes,
                    COALESCE(itmunitall.untprc, 0) AS unit_price,
                    COALESCE(itmunitall.untprc, 0) * SUM(aso.quantity) AS amount
                FROM aggregated_so aso
                LEFT JOIN tbl_store s ON aso.store_code = s.code

                LEFT JOIN dedup_pclmi pclmi ON aso.sku_code = pclmi.cusitmcde AND aso.company = '2'
                LEFT JOIN dedup_pcrgdi pcrgdi ON aso.sku_code = pcrgdi.cusitmcde AND aso.company != '2'

                LEFT JOIN dedup_pitmlmi pitmlmi ON pclmi.itmcde = pitmlmi.itmcde AND aso.company = '2'
                LEFT JOIN dedup_itmrgdi itmrgdi ON pcrgdi.itmcde = itmrgdi.itmcde AND aso.company != '2'

                LEFT JOIN tbl_item_unit_file_all itmunitall 
                  ON itmunitall.itmcde = CASE 
                                             WHEN aso.company = '2' THEN pclmi.itmcde 
                                             ELSE pcrgdi.itmcde 
                                         END
                  AND itmunitall.untmea = 'PCS'
                  AND itmunitall.source_type = CASE 
                                                   WHEN aso.company = '2' THEN 'lmi' 
                                                   ELSE 'rgdi' 
                                               END
    

                LEFT JOIN tbl_brand b ON 
                    (aso.company = '2' AND pitmlmi.brncde = b.brand_code) OR
                    (aso.company != '2' AND itmrgdi.brncde = b.brand_code)

                LEFT JOIN tbl_brand_label_type blt ON b.category_id = blt.id
                LEFT JOIN tbl_brand_terms bbt ON b.terms_id = bbt.id
                LEFT JOIN tbl_classification cl ON
                    (CASE WHEN aso.company = '2' THEN pitmlmi.itmclacde ELSE itmrgdi.itmclacde END) = cl.item_class_code

                LEFT JOIN tbl_main_pricelist mp ON
                    mp.brand_id = b.id
                    AND mp.brand_label_type_id = blt.id
                    AND mp.category_1_id = cl.id
                    AND mp.item_code = (CASE WHEN aso.company = '2' THEN pclmi.itmcde ELSE pcrgdi.itmcde END)
                    AND mp.customer_payment_group = aso.customer_payment_group

                LEFT JOIN (
                    SELECT h1.*
                    FROM tbl_historical_main_pricelist h1
                    INNER JOIN (
                        SELECT main_pricelist_id, MAX(effectivity_date) AS max_effectivity_date
                        FROM tbl_historical_main_pricelist
                        WHERE effectivity_date <= CURRENT_DATE()
                        GROUP BY main_pricelist_id
                    ) h2 ON h1.main_pricelist_id = h2.main_pricelist_id AND h1.effectivity_date = h2.max_effectivity_date
                ) hmp ON hmp.main_pricelist_id = mp.id
                GROUP BY
                    aso.id
            )
            SELECT * FROM final_data
        ";

        $allData = $this->sfaDB->query($sql)->getResultArray();

        if (empty($allData)) {
            //log_message('error', 'No data found during refreshScanData copy.');
            return ['error' => 'No data found.'];
        }

        if (!$data_header_id || !$month || !$year) {
            $this->sfaDB->table('tbl_sell_out_pre_aggregated_data')->truncate();
        }

        $batchSize = 2000;
        $inserted  = 0;

        $this->sfaDB->transStart();

        foreach (array_chunk($allData, $batchSize) as $batch) {
            $this->sfaDB->table('tbl_sell_out_pre_aggregated_data')->insertBatch($batch);
            $inserted += count($batch);
        }

        $this->sfaDB->transComplete();

        if ($this->sfaDB->transStatus() === false) {
            log_message('error', 'Transaction failed during scan data insert');
            return ['error' => 'Transaction failed'];
        }

        return ['total_inserted' => $inserted];
    }

    public function refreshVmiData($week = null, $year = null, $company = null)
    {
        $builder = $this->sfaDB->table('tbl_vmi');

        $where = [];
        $bindings = [];

        if ($week !== null && $year !== null && $company !== null) {
            $where[] = "tv.week = ?";
            $bindings[] = $week;

            $where[] = "tv.year = ?";
            $bindings[] = $year;

            $where[] = "tv.company = ?";
            $bindings[] = $company;
        }

        $whereClause = '';
        if (!empty($where)) {
            $whereClause = "WHERE " . implode(' AND ', $where);
        }

        $sql = "
            WITH
            dedup_pclmi AS (
                SELECT cusitmcde, MIN(itmcde) AS itmcde
                FROM tbl_price_code_file_2_lmi
                GROUP BY cusitmcde
            ),
            dedup_pcrgdi AS (
                SELECT cusitmcde, MIN(itmcde) AS itmcde
                FROM tbl_price_code_file_2_rgdi
                GROUP BY cusitmcde
            ),
            dedup_pitmlmi AS (
                SELECT itmcde, itmdsc, MIN(brncde) AS brncde, MIN(itmclacde) AS itmclacde
                FROM tbl_itemfile_lmi
                GROUP BY itmcde
            ),
            dedup_itmrgdi AS (
                SELECT itmcde, itmdsc, MIN(brncde) AS brncde, MIN(itmclacde) AS itmclacde
                FROM tbl_itemfile_rgdi
                GROUP BY itmcde
            ),
            aggregated_vmi AS (
                SELECT
                    tv.id,
                    tv.store,
                    tv.area_id,
                    tv.asc_id,
                    tv.brand_ids,
                    tv.brand_ambassador_ids AS ba_ids,
                    tv.ba_types,
                    tv.item,
                    tv.item_name,
                    tv.vmi_status,
                    tv.item_class,
                    tv.supplier,
                    tv.c_group,
                    tv.dept,
                    tv.c_class,
                    tv.sub_class,
                    ROUND(SUM(COALESCE(tv.on_hand, 0)), 2) AS on_hand,
                    ROUND(SUM(COALESCE(tv.in_transit, 0)), 2) AS in_transit,
                    ROUND(SUM(COALESCE(tv.average_sales_unit, 0)), 2) AS average_sales_unit,
                    tv.year,
                    tv.week,
                    tv.company,
                    tv.status
                FROM tbl_vmi tv
                {$whereClause}
                GROUP BY tv.id
            ),
            final_data AS (
                SELECT
                    avmi.year,
                    avmi.week,
                    avmi.store AS store_id,
                    blt.id AS brand_type_id,
                    bbt.sfa_filter AS brand_term_id,
                    b.id AS tracc_brand_id,
                    avmi.vmi_status,
                    avmi.supplier,
                    GROUP_CONCAT(DISTINCT avmi.ba_ids SEPARATOR ',') AS ba_ids,
                    GROUP_CONCAT(DISTINCT avmi.brand_ids SEPARATOR ',') AS brand_ids,
                    avmi.area_id,
                    avmi.asc_id,
                    avmi.ba_types,
                    avmi.c_group,
                    avmi.dept,
                    avmi.c_class,
                    avmi.sub_class,
                    avmi.company,
                    s.code AS store_code,
                    avmi.on_hand,
                    avmi.in_transit,
                    avmi.average_sales_unit,
                    avmi.on_hand + avmi.in_transit AS total_qty,
                    GROUP_CONCAT(DISTINCT CASE WHEN avmi.company = '2' THEN pclmi.itmcde ELSE pcrgdi.itmcde END SEPARATOR ',') AS itmcde,
                    CASE WHEN avmi.company = '2' THEN pitmlmi.itmdsc ELSE itmrgdi.itmdsc END AS itmdsc,
                    CASE WHEN avmi.company = '2' THEN pitmlmi.brncde ELSE itmrgdi.brncde END AS brncde,
                    CASE WHEN avmi.company = '2' THEN pitmlmi.itmclacde ELSE itmrgdi.itmclacde END AS itmclacde,
                    CONCAT(MAX(s.code), ' - ', s.description) AS store_name,
                    avmi.item,
                    avmi.item_name,
                    avmi.item_class,
                    ic.id AS item_class_id
                FROM aggregated_vmi avmi
                LEFT JOIN tbl_store s ON avmi.store = s.id
                LEFT JOIN tbl_item_class ic ON avmi.item_class = ic.item_class_description
                LEFT JOIN dedup_pclmi pclmi ON avmi.item = pclmi.cusitmcde AND avmi.company = '2'
                LEFT JOIN dedup_pcrgdi pcrgdi ON avmi.item = pcrgdi.cusitmcde AND avmi.company != '2'
                LEFT JOIN dedup_pitmlmi pitmlmi ON pclmi.itmcde = pitmlmi.itmcde AND avmi.company = '2'
                LEFT JOIN dedup_itmrgdi itmrgdi ON pcrgdi.itmcde = itmrgdi.itmcde AND avmi.company != '2'
                LEFT JOIN tbl_brand b ON 
                    (avmi.company = '2' AND pitmlmi.brncde = b.brand_code) OR
                    (avmi.company != '2' AND itmrgdi.brncde = b.brand_code)
                LEFT JOIN tbl_brand_label_type blt ON b.category_id = blt.id
                LEFT JOIN tbl_brand_terms bbt ON b.terms_id = bbt.id
                GROUP BY
                    avmi.id
            )
            SELECT * FROM final_data
        ";

        $query = $this->sfaDB->query($sql, $bindings);
        $allData = $query->getResultArray();

        // Truncate only on full refresh
        if (!$company || !$week || !$year) {
            $this->sfaDB->query('SET FOREIGN_KEY_CHECKS=0');
            
            $this->sfaDB->query('DELETE FROM tbl_vmi_pre_aggregated_ba_ids');
            $this->sfaDB->query('DELETE FROM tbl_vmi_pre_aggregated_brand_ids');
            $this->sfaDB->query('DELETE FROM tbl_vmi_pre_aggregated_data');

            $this->sfaDB->query('SET FOREIGN_KEY_CHECKS=1');
        }

        $batchSize = 10000;
        $chunks = array_chunk($allData, $batchSize);

        $uuidMap = [];
        $totalInserted = 0;

        foreach ($chunks as $chunk) {
            $mainBatch = [];

            foreach ($chunk as $row) {
                $uuid = Uuid::uuid4()->toString();
                $uuidMap[$uuid] = $row;

                $mainBatch[] = [
                    'uuid' => $uuid,
                    'vmi_status' => $row['vmi_status'],
                    'supplier' => $row['supplier'],
                    'store_id' => $row['store_id'],
                    'area_id' => $row['area_id'],
                    'asc_id' => $row['asc_id'],
                    'store_code' => $row['store_code'],
                    'store_name' => $row['store_name'],
                    'ba_types' => $row['ba_types'],
                    'ba_ids' => $row['ba_ids'],
                    'brand_ids' => $row['brand_ids'],
                    'c_group' => $row['c_group'],
                    'dept' => $row['dept'],
                    'c_class' => $row['c_class'],
                    'sub_class' => $row['sub_class'],
                    'on_hand' => $row['on_hand'],
                    'in_transit' => $row['in_transit'],
                    'total_qty' => $row['total_qty'],
                    'itmcde' => $row['itmcde'],
                    'itmdsc' => $row['itmdsc'],
                    'brncde' => $row['brncde'],
                    'itmclacde' => $row['itmclacde'],
                    'tracc_brand_id' => $row['tracc_brand_id'],
                    'cusitmcde' => $row['item'],
                    'brand_type_id' => $row['brand_type_id'],
                    'brand_term_id' => $row['brand_term_id'],
                    'item' => $row['item'],
                    'item_name' => $row['item_name'],
                    'item_class' => $row['item_class'],
                    'item_class_id' => $row['item_class_id'],
                    'average_sales_unit' => $row['average_sales_unit'],
                    'ba_deployment_dates' => '',
                    'year' => $row['year'],
                    'week' => $row['week'],
                    'company' => $row['company']
                ];
            }

            $this->sfaDB->table('tbl_vmi_pre_aggregated_data')->insertBatch($mainBatch);
            $totalInserted += count($mainBatch);
        }

        // Map UUIDs back to inserted IDs
        $uuids = array_keys($uuidMap);
        $uuidQuery = $this->sfaDB->table('tbl_vmi_pre_aggregated_data')
            ->select('id, uuid')
            ->whereIn('uuid', $uuids)
            ->get();

        if (!$uuidQuery) {
            log_message('error', 'UUID fetch failed: ' . $this->sfaDB->getLastQuery());
            log_message('error', 'DB error: ' . print_r($this->sfaDB->error(), true));
            throw new \RuntimeException('Query to fetch inserted UUIDs failed.');
        }

        $insertedRecords = $uuidQuery->getResultArray();
        $uuidToId = array_column($insertedRecords, 'id', 'uuid');

        // $uuidToId = array_column($insertedRecords, 'id', 'uuid');

        // $baBatch = [];
        // $brandBatch = [];

        // foreach ($uuidMap as $uuid => $row) {
        //     $id = $uuidToId[$uuid] ?? null;
        //     if (!$id) continue;

        //     $baIds = array_filter(array_map('trim', explode(',', $row['ba_ids'] ?? '')));
        //     $brandIds = array_filter(array_map('trim', explode(',', $row['brand_ids'] ?? '')));

        //     foreach ($baIds as $baId) {
        //         if (is_numeric($baId)) {
        //             $baBatch[] = [
        //                 'pre_aggregated_id' => $id,
        //                 'ba_id' => (int)$baId
        //             ];
        //         }
        //     }

        //     foreach ($brandIds as $brandId) {
        //         if (is_numeric($brandId)) {
        //             $brandBatch[] = [
        //                 'pre_aggregated_id' => $id,
        //                 'brand_id' => (int)$brandId
        //             ];
        //         }
        //     }
        // }

        // Chunked insert
        // foreach (array_chunk($baBatch, 5000) as $baChunk) {
        //     $this->sfaDB->table('tbl_vmi_pre_aggregated_ba_ids')->insertBatch($baChunk);
        // }

        // foreach (array_chunk($brandBatch, 5000) as $brandChunk) {
        //     $this->sfaDB->table('tbl_vmi_pre_aggregated_brand_ids')->insertBatch($brandChunk);
        // }

        // Clear UUIDs
        // $this->sfaDB->table('tbl_vmi_pre_aggregated_data')
        //     ->whereIn('uuid', $uuids)
        //     ->set(['uuid' => null])
        //     ->update();

        return [
            'total_inserted' => $totalInserted
            //'ba_links_inserted' => count($baBatch),
            //'brand_links_inserted' => count($brandBatch)
        ];
    }


    public function refreshVmiWoWData($dataHeaderId = null, $week = null, $year = null)
    {
        //note
        //item_class = tbl_item_class
        //item_class_id = tbl_classification
        $whereClause = '';

        if ($dataHeaderId && $week && $year) {
            $whereClause = "WHERE week_vmi.header_id = {$dataHeaderId} AND week_vmi.week = {$week} AND week_vmi.year = {$year}";
        }
        $sql = "

            WITH
                dedup_pclmi AS (
                    SELECT cusitmcde, MIN(itmcde) AS itmcde
                    FROM tbl_price_code_file_2_lmi
                    GROUP BY cusitmcde
                ),
                dedup_pcrgdi AS (
                    SELECT cusitmcde, MIN(itmcde) AS itmcde
                    FROM tbl_price_code_file_2_rgdi
                    GROUP BY cusitmcde
                ),
                dedup_pitmlmi AS (
                    SELECT itmcde, itmdsc, MIN(brncde) AS brncde, MIN(itmclacde) AS itmclacde
                    FROM tbl_itemfile_lmi
                    GROUP BY itmcde
                ),
                dedup_itmrgdi AS (
                    SELECT itmcde, itmdsc, MIN(brncde) AS brncde, MIN(itmclacde) AS itmclacde
                    FROM tbl_itemfile_rgdi
                    GROUP BY itmcde
                ),
                aggregated_week_vmi AS (
                    SELECT
                        week_vmi.id,
                        week_vmi.item,
                        week_vmi.item_name,
                        week_vmi.label_type,
                        week_vmi.item_class, 
                        week_vmi.pog_store,
                        ROUND(SUM(COALESCE(week_vmi.quantity, 0)), 2) AS quantity,
                        ROUND(SUM(COALESCE(week_vmi.soh, 0)), 2) AS soh,
                        ROUND(SUM(COALESCE(week_vmi.ave_weekly_sales, 0)), 2) AS ave_weekly_sales,
                        ROUND(SUM(COALESCE(week_vmi.weeks_cover, 0)), 2) AS weeks_cover,
                        week_vmi.year,
                        week_vmi.week,
                        week_vmi.status
                    FROM tbl_week_on_week_details week_vmi
                    {$whereClause}
                    GROUP BY week_vmi.year, week_vmi.week, week_vmi.item
                ),
                joined_data AS (
                    SELECT
                        avmi.*,
                        COALESCE(pclmi.itmcde, pcrgdi.itmcde) AS itmcde,
                        COALESCE(pclmi.cusitmcde, pcrgdi.cusitmcde) AS cusitmcde,
                        COALESCE(pitmlmi.itmdsc, itmrgdi.itmdsc) AS itmdsc,
                        COALESCE(pitmlmi.brncde, itmrgdi.brncde) AS brncde,
                        COALESCE(pitmlmi.itmclacde, itmrgdi.itmclacde) AS itmclacde,
                        CASE 
                            WHEN pclmi.itmcde IS NOT NULL THEN '2'  -- LMI
                            ELSE '1'  -- RGDI
                        END AS company,
                        cl.id AS item_class_id,
                        b.id AS brand_id,
                        blt.id AS brand_type_id,
                        bbt.sfa_filter AS brand_term_id,
                        CASE 
                          WHEN mp.effectivity_date <= CURRENT_DATE() THEN mp.net_price
                          WHEN hmp.net_price IS NOT NULL THEN hmp.net_price
                          ELSE 0
                        END AS net_price
                    FROM aggregated_week_vmi avmi

                    LEFT JOIN dedup_pclmi pclmi ON avmi.item = pclmi.cusitmcde
                    LEFT JOIN dedup_pcrgdi pcrgdi ON avmi.item = pcrgdi.cusitmcde

                    LEFT JOIN dedup_pitmlmi pitmlmi ON pclmi.itmcde = pitmlmi.itmcde
                    LEFT JOIN dedup_itmrgdi itmrgdi ON pcrgdi.itmcde = itmrgdi.itmcde

                    LEFT JOIN tbl_classification cl 
                        ON (CASE 
                                WHEN pclmi.itmcde IS NOT NULL THEN pitmlmi.itmclacde 
                                ELSE itmrgdi.itmclacde 
                            END) = cl.item_class_code

                    LEFT JOIN tbl_brand b 
                        ON (CASE 
                                WHEN pclmi.itmcde IS NOT NULL THEN pitmlmi.brncde 
                                ELSE itmrgdi.brncde 
                            END) = b.brand_code

                    LEFT JOIN tbl_brand_label_type blt ON b.category_id = blt.id
                    LEFT JOIN tbl_brand_terms bbt ON b.terms_id = bbt.id

                    LEFT JOIN tbl_main_pricelist mp ON
                        mp.brand_id = b.id
                        AND mp.brand_label_type_id = blt.id
                        AND mp.category_1_id = cl.id
                        AND mp.item_code = COALESCE(pclmi.itmcde, pcrgdi.itmcde)

                    LEFT JOIN (
                        SELECT h1.*
                        FROM tbl_historical_main_pricelist h1
                        INNER JOIN (
                            SELECT main_pricelist_id, MAX(effectivity_date) AS max_effectivity_date
                            FROM tbl_historical_main_pricelist
                            WHERE effectivity_date <= CURRENT_DATE()
                            GROUP BY main_pricelist_id
                        ) h2 ON h1.main_pricelist_id = h2.main_pricelist_id AND h1.effectivity_date = h2.max_effectivity_date
                    ) hmp ON hmp.main_pricelist_id = mp.id
                ),
                final_data AS (
                    SELECT
                        jd.year,
                        jd.week,
                        jd.status,
                        jd.brand_type_id,
                        jd.brand_term_id,
                        jd.brand_id AS tracc_brand_id,
                        jd.label_type,
                        jd.pog_store,
                        SUM(jd.quantity) AS quantity,
                        SUM(jd.soh) AS soh,
                        SUM(jd.ave_weekly_sales) AS ave_weekly_sales,
                        SUM(jd.weeks_cover) AS weeks_cover,
                        jd.itmcde,
                        jd.cusitmcde,
                        jd.itmdsc,
                        jd.brncde,
                        jd.itmclacde,
                        jd.item,
                        jd.item_name,
                        jd.item_class,
                        jd.item_class_id,
                        jd.net_price
                    FROM joined_data jd
                    GROUP BY
                        jd.year,
                        jd.week,
                        jd.item,
                        jd.item_class,
                        jd.label_type,
                        jd.pog_store,
                        jd.itmcde,
                        jd.cusitmcde,
                        jd.itmdsc,
                        jd.brncde,
                        jd.itmclacde,
                        jd.item_name,
                        jd.item_class_id,
                        jd.net_price,
                        jd.status,
                        jd.brand_type_id,
                        jd.brand_term_id,
                        jd.brand_id
                )
            SELECT * FROM final_data";

        $query = $this->sfaDB->query($sql);
        $allData = $query->getResultArray();

        if (empty($dataHeaderId) && empty($week) && empty($year)) {
            $this->sfaDB->table('tbl_week_on_week_vmi_pre_aggregated_data')->truncate();
        }

        $batchSize = 10000;
        $chunks = array_chunk($allData, $batchSize);

        foreach ($chunks as $chunk) {
            $this->sfaDB->table('tbl_week_on_week_vmi_pre_aggregated_data')->insertBatch($chunk);
        }

        return [
            'total_inserted' => count($allData)
        ];
    }

    public function syncAllItemUnitFileLMIRGDIData($batchSize = 5000)
    {
        $offset = 0;
        $totalRecordsSynced = 0;
        $errorMessage = null;
        $status = 'success';

        try {
            $this->sfaDB->query("TRUNCATE TABLE tbl_item_unit_file_all");
            $sources = [
                'lmi' => [
                    'db' => $this->traccLmiDB,
                    'untprcFn' => fn($itmcde, $untmea) => $this->getUntprcLmi($itmcde, $untmea),
                ],
                'rgdi' => [
                    'db' => $this->traccRgdiDB,
                    'untprcFn' => fn($itmcde, $untmea) => $this->getUntprcRgdi($itmcde, $untmea),
                ],
            ];

            foreach ($sources as $sourceType => $sourceInfo) {
                $offset = 0;

                while (true) {
                    $sourceData = $sourceInfo['db']->table('itemunitfile')
                        ->limit($batchSize, $offset)
                        ->get()
                        ->getResultArray();

                    if (empty($sourceData)) {
                        break;
                    }

                    $values = [];
                    foreach ($sourceData as $row) {

                        $brandId = 'NULL';
                        $brandLabelId = 'NULL';
                        $brandCategoryId = 'NULL';
                        $untprc = $sourceInfo['untprcFn']($row['itmcde'], $row['untmea']);
                        
                        $itemFileTable = $sourceType === 'lmi' ? 'tbl_itemfile_lmi' : 'tbl_itemfile_rgdi';
                        $item = $this->sfaDB->table($itemFileTable)
                            ->select('brncde, itmclacde')
                            ->where('itmcde', $row['itmcde'])
                            ->get()
                            ->getRowArray();

                        if ($item && !empty($item['brncde'])) {
                            $brand = $this->sfaDB->table('tbl_brand')
                                ->select('id, category_id')
                                ->where('brand_code', $item['brncde'])
                                ->get()
                                ->getRowArray();

                            if ($brand) {
                                $brandId = (int) $brand['id'];
                                $brandLabelId = (int) $brand['category_id'];
                            }
                        }

                        if ($item && !empty($item['itmclacde'])) {
                            $category = $this->sfaDB->table('tbl_classification')
                                ->select('id')
                                ->where('item_class_code', $item['itmclacde'])
                                ->get()
                                ->getRowArray();

                            if ($category) {
                                $brandCategoryId = (int) $category['id'];
                            }
                        }
                        $values[] = "(
                            '" . $this->esc($row['recid']) . "',
                            '" . $this->esc($row['itmcde']) . "',
                            '" . $this->esc($row['conver']) . "',
                            '" . $this->esc($row['untmea']) . "',
                            '" . $this->esc($untprc) . "',
                            '" . $this->esc($row['untcst']) . "',
                            '" . $sourceType . "',
                            " . $brandId . ",
                            " . $brandLabelId . ",
                            " . $brandCategoryId . "
                        )";
                    }

                    if (!empty($values)) {
                        $sql = "INSERT INTO tbl_item_unit_file_all 
                                (recid, itmcde, conver, untmea, untprc, untcst, source_type, brand_id, brand_label_id, brand_category_id) 
                                VALUES " . implode(',', $values) . "
                                ON DUPLICATE KEY UPDATE 
                                  itmcde = VALUES(itmcde),
                                  conver = VALUES(conver),
                                  untmea = VALUES(untmea),
                                  untprc = VALUES(untprc),
                                  untcst = VALUES(untcst),
                                  source_type = VALUES(source_type),
                                  brand_id = VALUES(brand_id),
                                  brand_label_id = VALUES(brand_label_id),
                                  brand_category_id = VALUES(brand_category_id)";

                        $this->sfaDB->query($sql);
                        $totalRecordsSynced += count($sourceData);
                    }

                    $offset += $batchSize;
                }
            }
        } catch (\Exception $e) {
            $status = 'error';
            $errorMessage = $e->getMessage();
        }

        return $status === 'success'
            ? "Data sync completed for ALL Item Unit with {$totalRecordsSynced} records."
            : "Sync failed. {$errorMessage}";
    }

    public function syncSalesFile2AllData($batchSize = 5000)
    {
        $sources = [
            'LMI'  => $this->traccLmiDB,
            'RGDI' => $this->traccRgdiDB
        ];

        $totalRecordsSynced = 0;
        $errorMessage = null;
        $status = 'success';

        try {
            $this->sfaDB->query("TRUNCATE TABLE tbl_item_salesfile2_all");

            foreach ($sources as $sourceName => $dbConn) {
                $offset = 0;

                while (true) {
                    $sourceData = $dbConn->table('salesfile2')
                        ->limit($batchSize, $offset)
                        ->get()
                        ->getResultArray();

                    if (empty($sourceData)) {
                        break;
                    }

                    $values = [];
                    foreach ($sourceData as $row) {
                        $brandId = 'NULL';
                        $brandLabelId = 'NULL';
                        $brandCategoryId = 'NULL';
                        $itemFileTable = $sourceName === 'LMI' ? 'tbl_itemfile_lmi' : 'tbl_itemfile_rgdi';
                        $item = $this->sfaDB->table($itemFileTable)
                            ->select('brncde, itmclacde')
                            ->where('itmcde', $row['itmcde'])
                            ->get()
                            ->getRowArray();

                        if ($item && !empty($item['brncde'])) {
                            $brand = $this->sfaDB->table('tbl_brand')
                                ->select('id, category_id')
                                ->where('brand_code', $item['brncde'])
                                ->get()
                                ->getRowArray();

                            if ($brand) {
                                $brandId = (int) $brand['id'];
                                $brandLabelId = (int) $brand['category_id'];
                            }
                        }

                        if ($item && !empty($item['itmclacde'])) {
                            $category = $this->sfaDB->table('tbl_classification')
                                ->select('id')
                                ->where('item_class_code', $item['itmclacde'])
                                ->get()
                                ->getRowArray();

                            if ($category) {
                                $brandCategoryId = (int) $category['id'];
                            }
                        }

                        $values[] = "(
                            '" . $this->esc($row['recid']) . "',
                            '" . $this->esc($sourceName) . "',
                            '" . $this->esc($row['PckItmCde']) . "',
                            '" . $this->esc($row['docnum']) . "',
                            '" . $this->esc($row['cusdsc']) . "',
                            '" . $this->esc($row['itmcde']) . "',
                            '" . $this->esc($row['itmdsc']) . "',
                            '" . $this->esc($row['itmqty']) . "',
                            '" . $this->esc($row['untprc']) . "',
                            '" . $this->esc($row['extprc']) . "',
                            '" . $this->esc($row['trncde']) . "',
                            '" . $this->esc($row['untmea']) . "',
                            '" . $this->esc($row['cuscde']) . "',
                            '" . $this->esc($row['warcde']) . "',
                            '" . $this->esc($row['prccde']) . "',
                            '" . $this->esc($row['sonum']) . "',
                            '" . $this->esc($row['conver1']) . "',
                            '" . $this->esc($row['cusgrpcde']) . "',
                            '" . $this->esc($row['cusitmcde']) . "',
                            '" . $this->esc($row['batchnum']) . "',
                            '" . $this->esc($row['binnum']) . "',
                            '" . $this->esc($row['dettyp']) . "',
                            '" . $this->esc($row['extprcfor']) . "',
                            '" . $this->esc($row['taxcde']) . "',
                            '" . $this->esc($row['vatamtfor']) . "',
                            '" . $this->esc($row['netvatamtfor']) . "',
                            '" . $this->esc($row['amtdisfor']) . "',
                            '" . $this->esc($row['trndte']) . "',
                            '" . $this->esc($row['cdrnum']) . "',
                            " . $brandId . ",
                            " . $brandLabelId . ",
                            " . $brandCategoryId . "
                            
                        )";
                    }

                    if (!empty($values)) {
                        $sql = "INSERT INTO tbl_item_salesfile2_all 
                                (recid, source, pckitmcde, docnum, cusdsc, itmcde, itmdsc, itmqty, untprc, extprc, trncde, untmea, cuscde, warcde, prccde, sonum, conver1, cusgrpcde, cusitmcde, batchnum, binnum, dettyp, extprcfor, taxcde, vatamtfor, netvatamtfor, amtdisfor, trndte, cdrnum, brand_id, brand_label_id, brand_category_id) 
                                VALUES " . implode(',', $values) . "
                                ON DUPLICATE KEY UPDATE 
                                    source = VALUES(source),
                                    pckitmcde = VALUES(pckitmcde),
                                    docnum = VALUES(docnum),
                                    cusdsc = VALUES(cusdsc),
                                    itmcde = VALUES(itmcde),
                                    itmdsc = VALUES(itmdsc),
                                    itmqty = VALUES(itmqty),
                                    untprc = VALUES(untprc),
                                    extprc = VALUES(extprc),
                                    trncde = VALUES(trncde),
                                    untmea = VALUES(untmea),
                                    cuscde = VALUES(cuscde),
                                    warcde = VALUES(warcde),
                                    prccde = VALUES(prccde),
                                    sonum = VALUES(sonum),
                                    conver1 = VALUES(conver1),
                                    cusgrpcde = VALUES(cusgrpcde),
                                    cusitmcde = VALUES(cusitmcde),
                                    batchnum = VALUES(batchnum),
                                    binnum = VALUES(binnum),
                                    dettyp = VALUES(dettyp),
                                    extprcfor = VALUES(extprcfor),
                                    taxcde = VALUES(taxcde),
                                    vatamtfor = VALUES(vatamtfor),
                                    netvatamtfor = VALUES(netvatamtfor),
                                    amtdisfor = VALUES(amtdisfor),
                                    trndte = VALUES(trndte),
                                    cdrnum = VALUES(cdrnum),
                                    brand_id = VALUES(brand_id),
                                    brand_label_id = VALUES(brand_label_id),
                                    brand_category_id = VALUES(brand_category_id)";

                        $this->sfaDB->query($sql);
                        $totalRecordsSynced += count($sourceData);
                    }

                    $offset += $batchSize;
                }
            }
        } catch (\Exception $e) {
            $status = 'error';
            $errorMessage = $e->getMessage();
        }

        return $status === 'success'
            ? "Data sync completed for Sales File 2 ALL with $totalRecordsSynced records."
            : "Sync failed. $errorMessage.";
    }

    public function syncSalesFileConsignmentAllData($batchSize = 5000)
    {
        $sources = [
            'LMI'  => $this->traccLmiDB,
            'RGDI' => $this->traccRgdiDB
        ];

        $totalRecordsSynced = 0;
        $errorMessage = null;
        $status = 'success';

        try {
            $this->sfaDB->query("TRUNCATE TABLE tbl_item_salesfile_consignment_all");

            foreach ($sources as $sourceName => $dbConn) {
                $offset = 0;

                while (true) {
                    $sourceData = $dbConn->table('inventorytranfile1 h')
                        ->select("
                            h.trndte,
                            h.docnum,
                            h.refnum,
                            h.cusdsc,
                            d.smncde,
                            c.tinnum,
                            d.cuscde,
                            d.cusdsc AS customer_desc,
                            d.itmcde,
                            d.itmdsc,
                            d.itmqty,
                            d.untmea,
                            d.groprc,
                            d.disper,
                            d.disamt,
                            (CASE WHEN d.amtdis > 0 THEN 0 ELSE d.amtdis * -1 END) AS totdisamt,
                            d.untprc,
                            ((CASE WHEN d.amtdis > 0 THEN 0 ELSE d.amtdis * -1 END) + d.netvatamt) AS groamt,
                            CASE WHEN d.taxcde IS NOT NULL AND d.taxcde <> 'VAT EXEMPT'
                                 THEN d.netvatamt ELSE 0 END AS vatable,
                            CASE WHEN d.taxcde IS NULL OR d.taxcde = 'VAT EXEMPT'
                                 THEN d.netvatamt ELSE 0 END AS nonvat,
                            d.vatamt,
                            d.extprc AS amt
                        ")
                        ->join('inventorytranfile2b d', 'h.docnum = d.docnum')
                        ->join('customerfile c', 'd.cuscde = c.cuscde', 'left')
                        ->where('h.trncde', 'OUT')
                        ->where('h.trntypcde', 'CSA')
                        ->where('h.trntot <>', 0)
                        ->where("(d.dettyp <> 'C' OR d.dettyp IS NULL OR d.dettyp = '')")
                        ->limit($batchSize, $offset)
                        ->get()
                        ->getResultArray();

                    if (empty($sourceData)) {
                        break;
                    }

                    $values = [];
                    foreach ($sourceData as $row) {
                        
                        $brandId = 'NULL';
                        $brandLabelId = 'NULL';
                        $brandCategoryId = 'NULL';

                        $itemFileTable = $sourceName === 'LMI' ? 'tbl_itemfile_lmi' : 'tbl_itemfile_rgdi';
                        
                        $item = $this->sfaDB->table($itemFileTable)
                            ->select('brncde, itmclacde')
                            ->where('itmcde', $row['itmcde'])
                            ->get()
                            ->getRowArray();

                        if ($item && !empty($item['brncde'])) {
                            $brand = $this->sfaDB->table('tbl_brand')
                                ->select('id, category_id')
                                ->where('brand_code', $item['brncde'])
                                ->get()
                                ->getRowArray();

                            if ($brand) {
                                $brandId = (int) $brand['id'];
                                $brandLabelId = (int) $brand['category_id'];
                            }
                        }

                        if ($item && !empty($item['itmclacde'])) {
                            $category = $this->sfaDB->table('tbl_classification')
                                ->select('id')
                                ->where('item_class_code', $item['itmclacde'])
                                ->get()
                                ->getRowArray();

                            if ($category) {
                                $brandCategoryId = (int) $category['id'];
                            }
                        }

                        $values[] = "(
                            '" . $this->esc($sourceName) . "',
                            '" . $this->esc($row['trndte']) . "',
                            '" . $this->esc($row['docnum']) . "',
                            '" . $this->esc($row['refnum']) . "',
                            '" . $this->esc($row['cusdsc']) . "',
                            '" . $this->esc($row['smncde']) . "',
                            '" . $this->esc($row['tinnum']) . "',
                            '" . $this->esc($row['cuscde']) . "',
                            '" . $this->esc($row['customer_desc']) . "',
                            '" . $this->esc($row['itmcde']) . "',
                            '" . $this->esc($row['itmdsc']) . "',
                            '" . $this->esc($row['itmqty']) . "',
                            '" . $this->esc($row['untmea']) . "',
                            '" . $this->esc($row['groprc']) . "',
                            '" . $this->esc($row['disper']) . "',
                            '" . $this->esc($row['disamt']) . "',
                            '" . $this->esc($row['totdisamt']) . "',
                            '" . $this->esc($row['untprc']) . "',
                            '" . $this->esc($row['groamt']) . "',
                            '" . $this->esc($row['vatable']) . "',
                            '" . $this->esc($row['nonvat']) . "',
                            '" . $this->esc($row['vatamt']) . "',
                            '" . $this->esc($row['amt']) . "',
                            $brandId,
                            $brandLabelId,
                            $brandCategoryId
                        )";
                    }

                    if (!empty($values)) {
                        $sql = "INSERT INTO tbl_item_salesfile_consignment_all 
                                (source, trndte, docnum, refnum, cusdsc, smncde, tinnum, cuscde, customer_desc, itmcde, itmdsc, itmqty, untmea, groprc, disper, disamt, totdisamt, untprc, groamt, vatable, nonvat, vatamt, amt, brand_id, brand_label_id, brand_category_id) 
                                VALUES " . implode(',', $values) . "
                                ON DUPLICATE KEY UPDATE 
                                    cusdsc = VALUES(cusdsc),
                                    itmcde = VALUES(itmcde),
                                    itmdsc = VALUES(itmdsc),
                                    itmqty = VALUES(itmqty),
                                    untmea = VALUES(untmea),
                                    groprc = VALUES(groprc),
                                    disper = VALUES(disper),
                                    disamt = VALUES(disamt),
                                    totdisamt = VALUES(totdisamt),
                                    untprc = VALUES(untprc),
                                    groamt = VALUES(groamt),
                                    vatable = VALUES(vatable),
                                    nonvat = VALUES(nonvat),
                                    vatamt = VALUES(vatamt),
                                    amt = VALUES(amt),
                                    brand_id = VALUES(brand_id),
                                    brand_label_id = VALUES(brand_label_id),
                                    brand_category_id = VALUES(brand_category_id)";

                        $this->sfaDB->query($sql);
                        $totalRecordsSynced += count($sourceData);
                    }

                    $offset += $batchSize;
                }
            }
        } catch (\Exception $e) {
            $status = 'error';
            $errorMessage = $e->getMessage();
        }

        return $status === 'success'
            ? "Data sync completed for Sales File Consignment ALL with $totalRecordsSynced records."
            : "Sync failed. $errorMessage.";
    }

    private function getUntprcRgdi($itmcde, $untmea)
    {
        if ($untmea === 'PCS') {
            $result = $this->sfaDB->table('tbl_price_code_file_2_rgdi')
                         ->select('untprc')
                         ->where('itmcde', $itmcde)
                         ->where('untmea', 'PCS')   
                         ->get()
                         ->getRowArray();

            return $result['untprc'] ?? 0;
        }

        preg_match('/\d+/', $untmea, $matches);
        if (!empty($matches)) {
            $number = $matches[0];

            $result = $this->sfaDB->table('tbl_price_code_file_2_rgdi')
                                             ->select('untprc')
                                             ->where('itmcde', $itmcde)
                                             ->where('untmea', $untmea)
                                             ->get()
                                             ->getRowArray();



            if (!empty($result) && !empty($result['untprc'])) {
                $untprc = $result['untprc'] / $number;
                return $untprc;
            }else{
                return 0;
            }
        }

        return 0;
    }

    private function getUntprcLmi($itmcde, $untmea)
    {
        if ($untmea === 'PCS') {
            $result = $this->sfaDB->table('tbl_price_code_file_2_lmi')
                         ->select('untprc')
                         ->where('itmcde', $itmcde)
                         ->where('untmea', 'PCS')   
                         ->get()
                         ->getRowArray();

            return $result['untprc'] ?? 0;
        }

        preg_match('/\d+/', $untmea, $matches);
        if (!empty($matches)) {
            $number = $matches[0];

            $result = $this->sfaDB->table('tbl_price_code_file_2_lmi')
                                             ->select('untprc')
                                             ->where('itmcde', $itmcde)
                                             ->where('untmea', $untmea)
                                             ->get()
                                             ->getRowArray();



            if (!empty($result) && !empty($result['untprc'])) {
                $untprc = $result['untprc'] / $number;
                return $untprc;
            }else{
                return 0;
            }
        }

        return 0;
    }


    public function refreshAll()
    {
        $scanResult = $this->refreshScanData();
        $vmiResult = $this->refreshVmiData();
        $vmiWowResult = $this->refreshVmiWoWData();

        return [
            'scan' => $scanResult,
            'vmi'  => $vmiResult,
            'vmiwow'  => $vmiWowResult,
        ];
    }

}
