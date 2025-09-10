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
                                             ->where('LOWER(prccde)', $filter)
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
                                             ->where('LOWER(prccde)', $filter)    
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
    
    // public function syncDataitemfileRGDIBK($batchSize = 5000)
    // {
    //     $offset = 0;
    //     $totalRecordsSynced = 0;
    //     $errorMessage = null;
    //     $status = 'success';
    //     try {
    //         while (true) {
    //             $sourceData = $this->traccRgdiDB->table('itemfile')
    //                                          ->limit($batchSize, $offset)
    //                                          ->get()
    //                                          ->getResultArray();

    //             if (empty($sourceData)) {
    //                 break;
    //             }

    //             $values = [];
    //             foreach ($sourceData as $row) {
    //                 $values[] = "(
    //                     '" . $this->esc($row['recid']) . "',
    //                     '" . $this->esc($row['ptycde']) . "',
    //                     '" . $this->esc($row['olditmcde']) . "',
    //                     '" . $this->esc($row['saldisact']) . "',
    //                     '" . $this->esc($row['purdisact']) . "',
    //                     '" . $this->esc($row['scpwddis']) . "',
    //                     '" . $this->esc($row['supdsc']) . "',
    //                     '" . $this->esc($row['itmcde']) . "',
    //                     '" . $this->esc($row['itmdsc']) . "',
    //                     '" . $this->esc($row['untmea']) . "',
    //                     '" . $this->esc($row['untmea2']) . "',
    //                     '" . $this->esc($row['conver']) . "',
    //                     '" . $this->esc($row['untcst1']) . "',
    //                     '" . $this->esc($row['untcst2']) . "',
    //                     '" . $this->esc($row['crilvl']) . "',
    //                     '" . $this->esc($row['remarks']) . "',
    //                     '" . $this->esc($row['wardsc']) . "',
    //                     '" . $this->esc($row['avecst']) . "',
    //                     '" . $this->esc($row['maxlvl']) . "',
    //                     '" . $this->esc($row['status']) . "',
    //                     '" . $this->esc($row['lstcst']) . "',
    //                     '" . $this->esc($row['untcst']) . "',
    //                     '" . $this->esc($row['untprc']) . "',
    //                     '" . $this->esc($row['brndsc']) . "',
    //                     '" . $this->esc($row['itmcladsc']) . "',
    //                     '" . $this->esc($row['itmmdl']) . "',
    //                     '" . $this->esc($row['supcde']) . "',
    //                     '" . $this->esc($row['warcde']) . "',
    //                     '" . $this->esc($row['brncde']) . "',
    //                     '" . $this->esc($row['itmclacde']) . "',
    //                     '" . $this->esc($row['salum']) . "',
    //                     '" . $this->esc($row['srtum']) . "',
    //                     '" . $this->esc($row['recum']) . "',
    //                     '" . $this->esc($row['prtum']) . "',
    //                     '" . $this->esc($row['invum']) . "',
    //                     '" . $this->esc($row['barcde']) . "',
    //                     '" . $this->esc($row['cstdebcde']) . "',
    //                     '" . $this->esc($row['cstcrecde']) . "',
    //                     '" . $this->esc($row['inactive']) . "',
    //                     '" . $this->esc($row['itmtyp']) . "',
    //                     '" . $this->esc($row['cgsactcde']) . "',
    //                     '" . $this->esc($row['salactcde']) . "',
    //                     '" . $this->esc($row['invactcde']) . "',
    //                     '" . $this->esc($row['srtactcde']) . "',
    //                     '" . $this->esc($row['multium']) . "',
    //                     '" . $this->esc($row['reqsernum']) . "',
    //                     '" . $this->esc($row['taxcde']) . "',
    //                     '" . $this->esc($row['prtactcde']) . "',
    //                     '" . $this->esc($row['puractcde']) . "',
    //                     '" . $this->esc($row['purtaxcde']) . "',
    //                     '" . $this->esc($row['salewtcde']) . "',
    //                     '" . $this->esc($row['purewtcde']) . "',
    //                     '" . $this->esc($row['salevatcde']) . "',
    //                     '" . $this->esc($row['purevatcde']) . "',
    //                     '" . $this->esc($row['salcur']) . "',
    //                     '" . $this->esc($row['purcur']) . "',
    //                     '" . $this->esc($row['itmrem1']) . "',
    //                     '" . $this->esc($row['itmrem2']) . "',
    //                     '" . $this->esc($row['itmrem3']) . "',
    //                     '" . $this->esc($row['itmbal']) . "',
    //                     '" . $this->esc($row['strqty']) . "',
    //                     '" . $this->esc($row['chknontrd']) . "',
    //                     '" . $this->esc($row['package']) . "',
    //                     '" . $this->esc($row['rebdte']) . "',
    //                     '" . $this->esc($row['itmprt']) . "',
    //                     '" . $this->esc($row['gldepcde']) . "',
    //                     '" . $this->esc($row['reqbatchnum']) . "',
    //                     '" . $this->esc($row['logdte']) . "',
    //                     '" . $this->esc($row['itmsubclacde']) . "',
    //                     '" . $this->esc($row['linenum']) . "',
    //                     '" . $this->esc($row['saltarget01']) . "',
    //                     '" . $this->esc($row['saltarget02']) . "',
    //                     '" . $this->esc($row['saltarget03']) . "',
    //                     '" . $this->esc($row['saltarget04']) . "',
    //                     '" . $this->esc($row['saltarget05']) . "',
    //                     '" . $this->esc($row['saltarget06']) . "',
    //                     '" . $this->esc($row['saltarget07']) . "',
    //                     '" . $this->esc($row['saltarget08']) . "',
    //                     '" . $this->esc($row['saltarget09']) . "',
    //                     '" . $this->esc($row['saltarget10']) . "',
    //                     '" . $this->esc($row['saltarget11']) . "',
    //                     '" . $this->esc($row['saltarget12']) . "',
    //                     '" . $this->esc($row['recumcon']) . "',
    //                     '" . $this->esc($row['itmdeptcde']) . "',
    //                     '" . $this->esc($row['itmmerchcatcde']) . "',
    //                     '" . $this->esc($row['itmhierarchy']) . "',
    //                     '" . $this->esc($row['itmclass']) . "',
    //                     '" . $this->esc($row['itmtag']) . "',
    //                     '" . $this->esc($row['itmsrc']) . "',
    //                     '" . $this->esc($row['itminvmvmnttyp']) . "',
    //                     '" . $this->esc($row['tariffcde']) . "',
    //                     '" . $this->esc($row['bomactcde']) . "',
    //                     '" . $this->esc($row['itmpalletcap']) . "',
    //                     '" . $this->esc($row['splblum']) . "',
    //                     '" . $this->esc($row['chkmultibarcde']) . "',
    //                     '" . $this->esc($row['multibarcde']) . "',
    //                     '" . $this->esc($row['purseractcde']) . "',
    //                     '" . $this->esc($row['minOQ']) . "',
    //                     '" . $this->esc($row['chkreorder']) . "',
    //                     '" . $this->esc($row['maxOQ']) . "'
    //                 )";
    //             }

    //             if (!empty($values)) {
    //                 $sql = "INSERT INTO tbl_itemfile_rgdi (recid, ptycde, olditmcde, saldisact, purdisact, scpwddis, supdsc, itmcde, itmdsc, untmea, untmea2, conver, untcst1, untcst2, crilvl, remarks, wardsc, avecst, maxlvl, status, lstcst, untcst, untprc, brndsc, itmcladsc, itmmdl, supcde, warcde, brncde, itmclacde, salum, srtum, recum, prtum, invum, barcde, cstdebcde, cstcrecde, inactive, itmtyp, cgsactcde, salactcde, invactcde, srtactcde, multium, reqsernum, taxcde, prtactcde, puractcde, purtaxcde, salewtcde, purewtcde, salevatcde, purevatcde, salcur, purcur, itmrem1, itmrem2, itmrem3, itmbal, strqty, chknontrd, package, rebdte, itmprt, gldepcde, reqbatchnum, logdte, itmsubclacde, linenum, saltarget01, saltarget02, saltarget03, saltarget04, saltarget05, saltarget06, saltarget07, saltarget08, saltarget09, saltarget10, saltarget11, saltarget12, recumcon, itmdeptcde, itmmerchcatcde, itmhierarchy, itmclass, itmtag, itmsrc, itminvmvmnttyp, tariffcde, bomactcde, itmpalletcap, splblum, chkmultibarcde, multibarcde, purseractcde, minOQ, chkreorder, maxOQ) 
    //                         VALUES " . implode(',', $values) . "
    //                         ON DUPLICATE KEY UPDATE 
    //                           ptycde = VALUES(ptycde), 
    //                           olditmcde = VALUES(olditmcde), 
    //                           saldisact = VALUES(saldisact),
    //                           purdisact = VALUES(purdisact),
    //                           scpwddis = VALUES(scpwddis),
    //                           supdsc = VALUES(supdsc),
    //                           itmcde = VALUES(itmcde),
    //                           itmdsc = VALUES(itmdsc),
    //                           untmea = VALUES(untmea),
    //                           untmea2 = VALUES(untmea2),
    //                           conver = VALUES(conver),
    //                           untcst1 = VALUES(untcst1),
    //                           untcst2 = VALUES(untcst2),
    //                           crilvl = VALUES(crilvl),
    //                           remarks = VALUES(remarks),
    //                           wardsc = VALUES(wardsc),
    //                           avecst = VALUES(avecst),
    //                           maxlvl = VALUES(maxlvl),
    //                           lstcst = VALUES(lstcst),
    //                           untcst = VALUES(untcst),
    //                           brndsc = VALUES(brndsc),
    //                           itmcladsc = VALUES(itmcladsc),
    //                           itmmdl = VALUES(itmmdl),
    //                           supcde = VALUES(supcde),
    //                           warcde = VALUES(warcde),
    //                           brncde = VALUES(brncde),
    //                           itmclacde = VALUES(itmclacde),
    //                           salum = VALUES(salum),
    //                           srtum = VALUES(srtum),
    //                           recum = VALUES(recum),
    //                           prtum = VALUES(prtum),
    //                           invum = VALUES(invum),
    //                           barcde = VALUES(barcde),
    //                           cstdebcde = VALUES(cstdebcde),
    //                           cstcrecde = VALUES(cstcrecde),
    //                           inactive = VALUES(inactive),
    //                           cgsactcde = VALUES(cgsactcde),
    //                           salactcde = VALUES(salactcde),
    //                           invactcde = VALUES(invactcde),
    //                           srtactcde = VALUES(srtactcde),
    //                           multium = VALUES(multium),
    //                           reqsernum = VALUES(reqsernum),
    //                           taxcde = VALUES(taxcde),
    //                           prtactcde = VALUES(prtactcde),
    //                           puractcde = VALUES(puractcde),
    //                           purtaxcde = VALUES(purtaxcde),
    //                           salewtcde = VALUES(salewtcde),
    //                           purewtcde = VALUES(purewtcde),
    //                           salevatcde = VALUES(salevatcde),
    //                           purevatcde = VALUES(purevatcde),
    //                           salcur = VALUES(salcur),
    //                           purcur = VALUES(purcur),
    //                           itmrem1 = VALUES(itmrem1),
    //                           itmrem2 = VALUES(itmrem2),
    //                           itmrem3 = VALUES(itmrem3),
    //                           itmbal = VALUES(itmbal),
    //                           strqty = VALUES(strqty),
    //                           chknontrd = VALUES(chknontrd),
    //                           package = VALUES(package),
    //                           rebdte = VALUES(rebdte),
    //                           itmprt = VALUES(itmprt),
    //                           gldepcde = VALUES(gldepcde),
    //                           reqbatchnum = VALUES(reqbatchnum),
    //                           logdte = VALUES(logdte),
    //                           itmsubclacde = VALUES(itmsubclacde),
    //                           linenum = VALUES(linenum),
    //                           saltarget01 = VALUES(saltarget01),
    //                           saltarget02 = VALUES(saltarget02),
    //                           saltarget03 = VALUES(saltarget03),
    //                           saltarget04 = VALUES(saltarget04),
    //                           saltarget05 = VALUES(saltarget05),
    //                           saltarget06 = VALUES(saltarget06),
    //                           saltarget07 = VALUES(saltarget07),
    //                           saltarget08 = VALUES(saltarget08),
    //                           saltarget09 = VALUES(saltarget09),
    //                           saltarget10 = VALUES(saltarget10),
    //                           saltarget11 = VALUES(saltarget11),
    //                           saltarget12 = VALUES(saltarget12),
    //                           recumcon = VALUES(recumcon),
    //                           itmdeptcde = VALUES(itmdeptcde),
    //                           itmmerchcatcde = VALUES(itmmerchcatcde),
    //                           itmhierarchy = VALUES(itmhierarchy),
    //                           itmclass = VALUES(itmclass),
    //                           itmtag = VALUES(itmtag),
    //                           itmsrc = VALUES(itmsrc),
    //                           itminvmvmnttyp = VALUES(itminvmvmnttyp),
    //                           tariffcde = VALUES(tariffcde),
    //                           bomactcde = VALUES(bomactcde),
    //                           itmpalletcap = VALUES(itmpalletcap),
    //                           splblum = VALUES(splblum),
    //                           chkmultibarcde = VALUES(chkmultibarcde),
    //                           multibarcde = VALUES(multibarcde),
    //                           purseractcde = VALUES(purseractcde),
    //                           minOQ = VALUES(minOQ),
    //                           chkreorder = VALUES(chkreorder),
    //                           maxOQ = VALUES(maxOQ)";

    //                 $this->sfaDB->query($sql);
    //                 $totalRecordsSynced += count($sourceData);
    //             }

    //             $offset += $batchSize;
    //         }
    //     } catch (\Exception $e) {
    //         $status = 'error';
    //         $errorMessage = $e->getMessage();
    //     }    
    //     return $status === 'success' ? "Data sync completed for Item File RGDI with $totalRecordsSynced records." : "Sync failed. $errorMessage.";
    // }

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
                                               ->where('LOWER(cusgrpcde)', $filter)
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
                                               ->where('LOWER(cusgrpcde)', $filter)
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
                                               ->where('LOWER(prccde)', $filter)
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
                                               ->where('LOWER(prccde)', $filter)
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
        $whereClause = '';

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
                    MIN(DISTINCT CASE WHEN aso.company = '2' THEN pitmlmi.itmdsc ELSE itmrgdi.itmdsc END) AS itmdsc,
                    CASE WHEN aso.company = '2' THEN pitmlmi.brncde ELSE itmrgdi.brncde END AS brncde,
                    CASE WHEN aso.company = '2' THEN pitmlmi.itmclacde ELSE itmrgdi.itmclacde END AS itmclacde,
                    CONCAT(MIN(aso.store_code), ' - ', s.description) AS store_name,
                    MIN(DISTINCT aso.sku_code) AS sku_codes,
                    CASE WHEN aso.company = '2' THEN itmunitlmi.untprc ELSE itmunitrgdi.untprc END AS unit_price,
                    (CASE WHEN aso.company = '2' THEN itmunitlmi.untprc ELSE itmunitrgdi.untprc END) * SUM(aso.quantity) AS amount
                FROM aggregated_so aso
                LEFT JOIN tbl_store s ON aso.store_code = s.code

                LEFT JOIN dedup_pclmi pclmi ON aso.sku_code = pclmi.cusitmcde AND aso.company = '2'
                LEFT JOIN dedup_pcrgdi pcrgdi ON aso.sku_code = pcrgdi.cusitmcde AND aso.company != '2'

                LEFT JOIN dedup_pitmlmi pitmlmi ON pclmi.itmcde = pitmlmi.itmcde AND aso.company = '2'
                LEFT JOIN dedup_itmrgdi itmrgdi ON pcrgdi.itmcde = itmrgdi.itmcde AND aso.company != '2'

                LEFT JOIN tbl_item_unit_file_lmi itmunitlmi ON pclmi.itmcde = itmunitlmi.itmcde AND itmunitlmi.untmea = 'PCS' AND aso.company = '2'
                LEFT JOIN tbl_item_unit_file_rgdi itmunitrgdi ON pcrgdi.itmcde = itmunitrgdi.itmcde AND itmunitrgdi.untmea = 'PCS' AND aso.company != '2'

                LEFT JOIN tbl_brand b ON 
                    (aso.company = '2' AND pitmlmi.brncde = b.brand_code) OR
                    (aso.company != '2' AND itmrgdi.brncde = b.brand_code)

                LEFT JOIN tbl_brand_label_type blt ON b.category_id = blt.id
                LEFT JOIN tbl_brand_terms bbt ON b.terms_id = bbt.id

                GROUP BY
                    aso.id
            )
            SELECT * FROM final_data
        ";

        $allData = $this->sfaDB->query($sql)->getResultArray();

        if (empty($allData)) {
            log_message('error', 'No data found during refreshScanData copy.');
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

    // public function refreshVmiData($week = null, $year = null, $company = null)
    // {

    //     $whereClause = '';

    //     if ($week && $year && $company) {
    //         $whereClause = "WHERE tv.week = {$week} AND tv.year = {$year} AND tv.company = {$company}";
    //     }
    //     $sql = "

    //         WITH
    //         dedup_pclmi AS (
    //             SELECT cusitmcde, MIN(itmcde) AS itmcde
    //             FROM tbl_price_code_file_2_lmi
    //             GROUP BY cusitmcde
    //         ),
    //         dedup_pcrgdi AS (
    //             SELECT cusitmcde, MIN(itmcde) AS itmcde
    //             FROM tbl_price_code_file_2_rgdi
    //             GROUP BY cusitmcde
    //         ),
    //         dedup_pitmlmi AS (
    //             SELECT itmcde, MIN(brncde) AS brncde, MIN(itmclacde) AS itmclacde
    //             FROM tbl_itemfile_lmi
    //             GROUP BY itmcde
    //         ),
    //         dedup_itmrgdi AS (
    //             SELECT itmcde, MIN(brncde) AS brncde, MIN(itmclacde) AS itmclacde
    //             FROM tbl_itemfile_rgdi
    //             GROUP BY itmcde
    //         ),
    //         aggregated_vmi AS (
    //             SELECT
    //                 tv.id,
    //                 tv.store AS store,
    //                 tv.area_id,
    //                 tv.asc_id,
    //                 tv.brand_ids,
    //                 tv.brand_ambassador_ids AS ba_ids,
    //                 tv.ba_types,
    //                 tv.item,
    //                 tv.item_name,
    //                 tv.vmi_status,
    //                 tv.item_class,
    //                 tv.supplier,
    //                 tv.c_group,
    //                 tv.dept,
    //                 tv.c_class,
    //                 tv.sub_class,
    //                 ROUND(SUM(COALESCE(tv.on_hand, 0)), 2) AS on_hand,
    //                 ROUND(SUM(COALESCE(tv.in_transit, 0)), 2) AS in_transit,
    //                 ROUND(SUM(COALESCE(tv.average_sales_unit, 0)), 2) AS average_sales_unit,
    //                 tv.year,
    //                 tv.week,
    //                 tv.company,
    //                 tv.status
    //             FROM tbl_vmi tv
    //             {$whereClause}
    //             GROUP BY tv.year, tv.week, tv.store, tv.area_id, tv.asc_id, tv.company, tv.item, tv.item_name, tv.item_class
    //         ),
    //         final_data AS (
    //             SELECT
    //                 avmi.year,
    //                 avmi.week,
    //                 avmi.store AS store_id,
    //                 blt.id AS brand_type_id,
    //                 bbt.sfa_filter AS brand_term_id,
    //                 b.id AS tracc_brand_id,
    //                 avmi.vmi_status,
    //                 avmi.supplier,
    //                 GROUP_CONCAT(DISTINCT avmi.ba_ids) AS ba_ids,
    //                 GROUP_CONCAT(DISTINCT avmi.brand_ids) AS brand_ids,
    //                 avmi.area_id,
    //                 avmi.asc_id,
    //                 avmi.ba_types,
    //                 avmi.c_group,
    //                 avmi.dept,
    //                 avmi.c_class,
    //                 avmi.sub_class,
    //                 avmi.company,

    //                 avmi.on_hand AS on_hand,
    //                 avmi.in_transit AS in_transit,
    //                 avmi.average_sales_unit AS average_sales_unit,
    //                 avmi.on_hand + avmi.in_transit AS total_qty,
    //                 GROUP_CONCAT(DISTINCT CASE WHEN avmi.company = '2' THEN pclmi.itmcde ELSE pcrgdi.itmcde END) AS itmcde,
    //                 CASE WHEN avmi.company = '2' THEN pitmlmi.brncde ELSE itmrgdi.brncde END AS brncde,
    //                 CASE WHEN avmi.company = '2' THEN pitmlmi.itmclacde ELSE itmrgdi.itmclacde END AS itmclacde,
    //                 -- CONCAT(MAX(s.code), ' - ', s.description) AS store_name,
    //                 avmi.item AS item,
    //                 avmi.item_name AS item_name,
    //                 avmi.item_class
    //             FROM aggregated_vmi avmi
    //             -- LEFT JOIN tbl_store s. ON avmi.store = s.id
    //             -- to check if sku_Code = item
    //             LEFT JOIN dedup_pclmi pclmi ON avmi.item = pclmi.cusitmcde AND avmi.company = '2'
    //             LEFT JOIN dedup_pcrgdi pcrgdi ON avmi.item = pcrgdi.cusitmcde AND avmi.company != '2'

    //             LEFT JOIN dedup_pitmlmi pitmlmi ON pclmi.itmcde = pitmlmi.itmcde AND avmi.company = '2'
    //             LEFT JOIN dedup_itmrgdi itmrgdi ON pcrgdi.itmcde = itmrgdi.itmcde AND avmi.company != '2'

    //             LEFT JOIN tbl_brand b ON 
    //                 (avmi.company = '2' AND pitmlmi.brncde = b.brand_code) OR
    //                 (avmi.company != '2' AND itmrgdi.brncde = b.brand_code)

    //             LEFT JOIN tbl_brand_label_type blt ON b.category_id = blt.id
    //             LEFT JOIN tbl_brand_terms bbt ON b.terms_id = bbt.id

    //             GROUP BY
    //                 avmi.year,
    //                 avmi.week,
    //                 avmi.store,
    //                 avmi.area_id,
    //                 avmi.asc_id,
    //                 avmi.company,
    //                 avmi.item,
    //                 avmi.item_name,
    //                 avmi.item_class,
    //                 blt.id,
    //                 bbt.sfa_filter,
    //                 brncde,
    //                 b.id
    //         )
    //         SELECT * FROM final_data
    //     ";

    //     $query = $this->sfaDB->query($sql);
    //     $allData = $query->getResultArray();

    //     if (!$company || !$week || !$year) {
    //         $this->sfaDB->table('tbl_vmi_pre_aggregated_ba_ids')->truncate();
    //         $this->sfaDB->table('tbl_vmi_pre_aggregated_brand_ids')->truncate();
    //         $this->sfaDB->table('tbl_vmi_pre_aggregated_data')->truncate();
    //     }

    //     $batchSize = 10000;
    //     $chunks = array_chunk($allData, $batchSize);

    //     $totalInserted = 0;
    //     $uuidMap = [];

    //     foreach ($chunks as $chunk) {
    //         $mainBatch = [];

    //         foreach ($chunk as $row) {
    //             $uuid = Uuid::uuid4()->toString();
    //             $uuidMap[$uuid] = $row;

    //             $mainBatch[] = [
    //                 'uuid' => $uuid,
    //                 'vmi_status' => $row['vmi_status'],
    //                 'supplier' => $row['supplier'],
    //                 'store_id' => $row['store_id'],
    //                 'area_id' => $row['area_id'],
    //                 'asc_id' => $row['asc_id'],
    //                 //'store_code' => $row['store_code'],
    //                 //'store_name' => $row['store_name'],
    //                 'ba_types' => $row['ba_types'],
    //                 'c_group' => $row['c_group'],
    //                 'dept' => $row['dept'],
    //                 'c_class' => $row['c_class'],
    //                 'sub_class' => $row['sub_class'],
    //                 'on_hand' => $row['on_hand'],
    //                 'in_transit' => $row['in_transit'],
    //                 'total_qty' => $row['total_qty'],
    //                 'itmcde' => $row['itmcde'],
    //                 'brncde' => $row['brncde'],
    //                 'itmclacde' => $row['itmclacde'],
    //                 'tracc_brand_id' => $row['tracc_brand_id'],
    //                 'cusitmcde' => $row['item'],
    //                 'brand_type_id' => $row['brand_type_id'],
    //                 'brand_term_id' => $row['brand_term_id'],
    //                 'item' => $row['item'],
    //                 'item_name' => $row['item_name'],
    //                 'item_class' => $row['item_class'],
    //                 'average_sales_unit' => $row['average_sales_unit'],
    //                 'ba_deployment_dates' => '',
    //                 'year' => $row['year'],
    //                 'week' => $row['week'],
    //                 'company' => $row['company']
    //             ];
    //         }

    //         // Insert this chunk
    //         $this->sfaDB->table('tbl_vmi_pre_aggregated_data')->insertBatch($mainBatch);
    //         $totalInserted += count($mainBatch);
    //     }

    //     // Get inserted IDs
    //     $uuids = array_keys($uuidMap);
    //     $insertedRecords = $this->sfaDB->table('tbl_vmi_pre_aggregated_data')
    //         ->select('id, uuid')
    //         ->whereIn('uuid', $uuids)
    //         ->get()
    //         ->getResultArray();

    //     $uuidToId = [];
    //     foreach ($insertedRecords as $rec) {
    //         $uuidToId[$rec['uuid']] = $rec['id'];
    //     }

    //     // Build BA and Brand batches
    //     $baBatch = [];
    //     $brandBatch = [];

    //     foreach ($uuidMap as $uuid => $row) {
    //         $currentId = $uuidToId[$uuid] ?? null;
    //         if (!$currentId) continue;

    //         $baIds = array_filter(array_map('trim', explode(',', $row['ba_ids'] ?? '')));
    //         $brandIds = array_filter(array_map('trim', explode(',', $row['brand_ids'] ?? '')));

    //         foreach ($baIds as $baId) {
    //             if (is_numeric($baId)) {
    //                 $baBatch[] = [
    //                     'pre_aggregated_id' => $currentId,
    //                     'ba_id' => (int)$baId
    //                 ];
    //             }
    //         }

    //         foreach ($brandIds as $brandId) {
    //             if (is_numeric($brandId)) {
    //                 $brandBatch[] = [
    //                     'pre_aggregated_id' => $currentId,
    //                     'brand_id' => (int)$brandId
    //                 ];
    //             }
    //         }
    //     }

    //     // Chunk insert into linking tables
    //     $chunkSize = 5000;

    //     if (!empty($baBatch)) {
    //         foreach (array_chunk($baBatch, $chunkSize) as $baChunk) {
    //             $this->sfaDB->table('tbl_vmi_pre_aggregated_ba_ids')->insertBatch($baChunk);
    //         }
    //     }

    //     if (!empty($brandBatch)) {
    //         foreach (array_chunk($brandBatch, $chunkSize) as $brandChunk) {
    //             $this->sfaDB->table('tbl_vmi_pre_aggregated_brand_ids')->insertBatch($brandChunk);
    //         }
    //     }

    //     // Optional: clean up UUIDs to avoid clutter
    //     $this->sfaDB->table('tbl_vmi_pre_aggregated_data')
    //     ->whereIn('uuid', $uuids)
    //     ->set(['uuid' => null])
    //     ->update();

    //     return [
    //         'total_inserted' => count($allData),
    //         'ba_links_inserted' => count($baBatch),
    //         'brand_links_inserted' => count($brandBatch)
    //     ];
    // }

    // public function refreshVmiData($week = null, $year = null, $company = null)
    // {
    //     $builder = $this->sfaDB->table('tbl_vmi');

    //     $where = [];
    //     $bindings = [];

    //     if ($week !== null && $year !== null && $company !== null) {
    //         $where[] = "tv.week = ?";
    //         $bindings[] = $week;

    //         $where[] = "tv.year = ?";
    //         $bindings[] = $year;

    //         $where[] = "tv.company = ?";
    //         $bindings[] = $company;
    //     }

    //     $whereClause = '';
    //     if (!empty($where)) {
    //         $whereClause = "WHERE " . implode(' AND ', $where);
    //     }

    //     $sql = "
    //         WITH
    //         dedup_pclmi AS (
    //             SELECT cusitmcde, MIN(itmcde) AS itmcde
    //             FROM tbl_price_code_file_2_lmi
    //             GROUP BY cusitmcde
    //         ),
    //         dedup_pcrgdi AS (
    //             SELECT cusitmcde, MIN(itmcde) AS itmcde
    //             FROM tbl_price_code_file_2_rgdi
    //             GROUP BY cusitmcde
    //         ),
    //         dedup_pitmlmi AS (
    //             SELECT itmcde, MIN(brncde) AS brncde, MIN(itmclacde) AS itmclacde
    //             FROM tbl_itemfile_lmi
    //             GROUP BY itmcde
    //         ),
    //         dedup_itmrgdi AS (
    //             SELECT itmcde, MIN(brncde) AS brncde, MIN(itmclacde) AS itmclacde
    //             FROM tbl_itemfile_rgdi
    //             GROUP BY itmcde
    //         ),
    //         aggregated_vmi AS (
    //             SELECT
    //                 tv.id,
    //                 tv.store,
    //                 tv.area_id,
    //                 tv.asc_id,
    //                 tv.brand_ids,
    //                 tv.brand_ambassador_ids AS ba_ids,
    //                 tv.ba_types,
    //                 tv.item,
    //                 tv.item_name,
    //                 tv.vmi_status,
    //                 tv.item_class,
    //                 tv.supplier,
    //                 tv.c_group,
    //                 tv.dept,
    //                 tv.c_class,
    //                 tv.sub_class,
    //                 ROUND(SUM(COALESCE(tv.on_hand, 0)), 2) AS on_hand,
    //                 ROUND(SUM(COALESCE(tv.in_transit, 0)), 2) AS in_transit,
    //                 ROUND(SUM(COALESCE(tv.average_sales_unit, 0)), 2) AS average_sales_unit,
    //                 tv.year,
    //                 tv.week,
    //                 tv.company,
    //                 tv.status
    //             FROM tbl_vmi tv
    //             {$whereClause}
    //             GROUP BY tv.id
    //         ),
    //         final_data AS (
    //             SELECT
    //                 avmi.year,
    //                 avmi.week,
    //                 avmi.store AS store_id,
    //                 blt.id AS brand_type_id,
    //                 bbt.sfa_filter AS brand_term_id,
    //                 b.id AS tracc_brand_id,
    //                 avmi.vmi_status,
    //                 avmi.supplier,
    //                 GROUP_CONCAT(DISTINCT avmi.ba_ids SEPARATOR ',') AS ba_ids,
    //                 GROUP_CONCAT(DISTINCT avmi.brand_ids SEPARATOR ',') AS brand_ids,
    //                 avmi.area_id,
    //                 avmi.asc_id,
    //                 avmi.ba_types,
    //                 avmi.c_group,
    //                 avmi.dept,
    //                 avmi.c_class,
    //                 avmi.sub_class,
    //                 avmi.company,
    //                 s.code AS store_code,
    //                 avmi.on_hand,
    //                 avmi.in_transit,
    //                 avmi.average_sales_unit,
    //                 avmi.on_hand + avmi.in_transit AS total_qty,
    //                 GROUP_CONCAT(DISTINCT CASE WHEN avmi.company = '2' THEN pclmi.itmcde ELSE pcrgdi.itmcde END SEPARATOR ',') AS itmcde,
    //                 CASE WHEN avmi.company = '2' THEN pitmlmi.brncde ELSE itmrgdi.brncde END AS brncde,
    //                 CASE WHEN avmi.company = '2' THEN pitmlmi.itmclacde ELSE itmrgdi.itmclacde END AS itmclacde,
    //                 CONCAT(MAX(s.code), ' - ', s.description) AS store_name,
    //                 avmi.item,
    //                 avmi.item_name,
    //                 avmi.item_class
    //             FROM aggregated_vmi avmi
    //             LEFT JOIN tbl_store s ON avmi.store = s.id
    //             LEFT JOIN dedup_pclmi pclmi ON avmi.item = pclmi.cusitmcde AND avmi.company = '2'
    //             LEFT JOIN dedup_pcrgdi pcrgdi ON avmi.item = pcrgdi.cusitmcde AND avmi.company != '2'
    //             LEFT JOIN dedup_pitmlmi pitmlmi ON pclmi.itmcde = pitmlmi.itmcde AND avmi.company = '2'
    //             LEFT JOIN dedup_itmrgdi itmrgdi ON pcrgdi.itmcde = itmrgdi.itmcde AND avmi.company != '2'
    //             LEFT JOIN tbl_brand b ON 
    //                 (avmi.company = '2' AND pitmlmi.brncde = b.brand_code) OR
    //                 (avmi.company != '2' AND itmrgdi.brncde = b.brand_code)
    //             LEFT JOIN tbl_brand_label_type blt ON b.category_id = blt.id
    //             LEFT JOIN tbl_brand_terms bbt ON b.terms_id = bbt.id
    //             GROUP BY
    //                 avmi.id
    //         )
    //         SELECT * FROM final_data
    //     ";

    //     $query = $this->sfaDB->query($sql, $bindings);
    //     $allData = $query->getResultArray();

    //     // Truncate only on full refresh
    //     if (!$company || !$week || !$year) {
    //         $this->sfaDB->query('SET FOREIGN_KEY_CHECKS=0');
            
    //         $this->sfaDB->query('TRUNCATE TABLE tbl_vmi_pre_aggregated_ba_ids');
    //         $this->sfaDB->query('TRUNCATE TABLE tbl_vmi_pre_aggregated_brand_ids');
    //         $this->sfaDB->query('TRUNCATE TABLE tbl_vmi_pre_aggregated_data');

    //         $this->sfaDB->query('SET FOREIGN_KEY_CHECKS=1');
    //     }

    //     $batchSize = 10000;
    //     $chunks = array_chunk($allData, $batchSize);

    //     $uuidMap = [];
    //     $totalInserted = 0;

    //     foreach ($chunks as $chunk) {
    //         $mainBatch = [];

    //         foreach ($chunk as $row) {
    //             $uuid = Uuid::uuid4()->toString();
    //             $uuidMap[$uuid] = $row;

    //             $mainBatch[] = [
    //                 'uuid' => $uuid,
    //                 'vmi_status' => $row['vmi_status'],
    //                 'supplier' => $row['supplier'],
    //                 'store_id' => $row['store_id'],
    //                 'area_id' => $row['area_id'],
    //                 'asc_id' => $row['asc_id'],
    //                 'store_code' => $row['store_code'],
    //                 'store_name' => $row['store_name'],
    //                 'ba_types' => $row['ba_types'],
    //                 'ba_ids' => $row['ba_ids'],
    //                 'brand_ids' => $row['brand_ids'],
    //                 'c_group' => $row['c_group'],
    //                 'dept' => $row['dept'],
    //                 'c_class' => $row['c_class'],
    //                 'sub_class' => $row['sub_class'],
    //                 'on_hand' => $row['on_hand'],
    //                 'in_transit' => $row['in_transit'],
    //                 'total_qty' => $row['total_qty'],
    //                 'itmcde' => $row['itmcde'],
    //                 'brncde' => $row['brncde'],
    //                 'itmclacde' => $row['itmclacde'],
    //                 'tracc_brand_id' => $row['tracc_brand_id'],
    //                 'cusitmcde' => $row['item'],
    //                 'brand_type_id' => $row['brand_type_id'],
    //                 'brand_term_id' => $row['brand_term_id'],
    //                 'item' => $row['item'],
    //                 'item_name' => $row['item_name'],
    //                 'item_class' => $row['item_class'],
    //                 'average_sales_unit' => $row['average_sales_unit'],
    //                 'ba_deployment_dates' => '',
    //                 'year' => $row['year'],
    //                 'week' => $row['week'],
    //                 'company' => $row['company']
    //             ];
    //         }

    //         $this->sfaDB->table('tbl_vmi_pre_aggregated_data')->insertBatch($mainBatch);
    //         $totalInserted += count($mainBatch);
    //     }

    //     // Map UUIDs back to inserted IDs
    //     $uuids = array_keys($uuidMap);
    //     $insertedRecords = $this->sfaDB->table('tbl_vmi_pre_aggregated_data')
    //         ->select('id, uuid')
    //         ->whereIn('uuid', $uuids)
    //         ->get()
    //         ->getResultArray();

    //     $uuidToId = array_column($insertedRecords, 'id', 'uuid');

    //     $baBatch = [];
    //     $brandBatch = [];

    //     foreach ($uuidMap as $uuid => $row) {
    //         $id = $uuidToId[$uuid] ?? null;
    //         if (!$id) continue;

    //         $baIds = array_filter(array_map('trim', explode(',', $row['ba_ids'] ?? '')));
    //         $brandIds = array_filter(array_map('trim', explode(',', $row['brand_ids'] ?? '')));

    //         foreach ($baIds as $baId) {
    //             if (is_numeric($baId)) {
    //                 $baBatch[] = [
    //                     'pre_aggregated_id' => $id,
    //                     'ba_id' => (int)$baId
    //                 ];
    //             }
    //         }

    //         foreach ($brandIds as $brandId) {
    //             if (is_numeric($brandId)) {
    //                 $brandBatch[] = [
    //                     'pre_aggregated_id' => $id,
    //                     'brand_id' => (int)$brandId
    //                 ];
    //             }
    //         }
    //     }

    //     // Chunked insert
    //     foreach (array_chunk($baBatch, 5000) as $baChunk) {
    //         $this->sfaDB->table('tbl_vmi_pre_aggregated_ba_ids')->insertBatch($baChunk);
    //     }

    //     foreach (array_chunk($brandBatch, 5000) as $brandChunk) {
    //         $this->sfaDB->table('tbl_vmi_pre_aggregated_brand_ids')->insertBatch($brandChunk);
    //     }

    //     // Clear UUIDs
    //     $this->sfaDB->table('tbl_vmi_pre_aggregated_data')
    //         ->whereIn('uuid', $uuids)
    //         ->set(['uuid' => null])
    //         ->update();

    //     return [
    //         'total_inserted' => $totalInserted,
    //         'ba_links_inserted' => count($baBatch),
    //         'brand_links_inserted' => count($brandBatch)
    //     ];
    // }

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
                        COALESCE(pitmlmi.itmdsc, itmrgdi.itmdsc) AS itmdsc,
                        COALESCE(pitmlmi.brncde, itmrgdi.brncde) AS brncde,
                        COALESCE(pitmlmi.itmclacde, itmrgdi.itmclacde) AS itmclacde,
                        CASE 
                            WHEN pclmi.itmcde IS NOT NULL THEN '2'  -- LMI
                            ELSE '1'  -- RGDI
                        END AS company
                    FROM aggregated_week_vmi avmi
                    LEFT JOIN dedup_pclmi pclmi ON avmi.item = pclmi.cusitmcde
                    LEFT JOIN dedup_pcrgdi pcrgdi ON avmi.item = pcrgdi.cusitmcde
                    LEFT JOIN dedup_pitmlmi pitmlmi ON pclmi.itmcde = pitmlmi.itmcde
                    LEFT JOIN dedup_itmrgdi itmrgdi ON pcrgdi.itmcde = itmrgdi.itmcde
                ),
                final_data AS (
                    SELECT
                        jd.year,
                        jd.week,
                        jd.status,
                        blt.id AS brand_type_id,
                        bbt.sfa_filter AS brand_term_id,
                        b.id AS tracc_brand_id,
                        jd.label_type,
                        jd.pog_store,
                        SUM(jd.quantity) AS quantity,
                        SUM(jd.soh) AS soh,
                        SUM(jd.ave_weekly_sales) AS ave_weekly_sales,
                        SUM(jd.weeks_cover) AS weeks_cover,
                        jd.itmcde,
                        jd.itmdsc,
                        jd.brncde,
                        jd.itmclacde,
                        jd.item,
                        jd.item_name,
                        jd.item_class
                    FROM joined_data jd
                    LEFT JOIN tbl_brand b ON jd.brncde = b.brand_code
                    LEFT JOIN tbl_brand_label_type blt ON b.category_id = blt.id
                    LEFT JOIN tbl_brand_terms bbt ON b.terms_id = bbt.id
                    GROUP BY
                        jd.year,
                        jd.week,
                        jd.item,
                        jd.item_class,
                        blt.id,
                        bbt.sfa_filter,
                        jd.brncde,
                        b.id
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

    public function syncItemUnitFileLmiData($where, $batchSize = 5000)
    {
        $offset = 0;
        $totalRecordsSynced = 0;
        $errorMessage = null;
        $status = 'success';
        $filter = strtolower($where);
        try {
            $this->sfaDB->query("TRUNCATE TABLE tbl_item_unit_file_lmi");
            
            while (true) {
                $sourceData = $this->traccLmiDB->table('itemunitfile')
                                                 ->limit($batchSize, $offset)
                                                 ->get()
                                                 ->getResultArray();

                if (empty($sourceData)) {
                    break;
                }

                $values = [];
                foreach ($sourceData as $row) {
                    $untprc = $this->getUntprcLmi($row['itmcde'], $row['untmea']);
                    $values[] = "(
                        '" . $this->esc($row['recid']) . "',
                        '" . $this->esc($row['itmcde']) . "',
                        '" . $this->esc($row['conver']) . "',
                        '" . $this->esc($row['untmea']) . "',
                        '" . $this->esc($untprc) . "',
                        '" . $this->esc($row['untcst']) . "'
                    )";
                }

                if (!empty($values)) {
                    $sql = "INSERT INTO tbl_item_unit_file_lmi (recid, itmcde, conver, untmea, untprc, untcst) 
                            VALUES " . implode(',', $values) . "
                            ON DUPLICATE KEY UPDATE 
                              itmcde = VALUES(itmcde),
                              conver = VALUES(conver),
                              untmea = VALUES(untmea),
                              untprc = VALUES(untprc),
                              untcst = VALUES(untcst)";

                    $this->sfaDB->query($sql);
                    $totalRecordsSynced += count($sourceData);
                }

                $offset += $batchSize;
            }
        } catch (\Exception $e) {
            $status = 'error';
            $errorMessage = $e->getMessage();
        }    

        return $status === 'success' ? "Data sync completed for Item Unit File LMI with $totalRecordsSynced records." : "Sync failed. $errorMessage.";
    }

    public function syncItemUnitFileRgdiData($where, $batchSize = 5000)
    {
        $offset = 0;
        $totalRecordsSynced = 0;
        $errorMessage = null;
        $status = 'success';
        $filter = strtolower($where);
        try {
            $this->sfaDB->query("TRUNCATE TABLE tbl_item_unit_file_rgdi");
            
            while (true) {
                $sourceData = $this->traccRgdiDB->table('itemunitfile')
                                                 ->limit($batchSize, $offset)
                                                 ->get()
                                                 ->getResultArray();

                if (empty($sourceData)) {
                    break;
                }

                $values = [];
                foreach ($sourceData as $row) {
                    $untprc = $this->getUntprcRgdi($row['itmcde'], $row['untmea']);
                    $values[] = "(
                        '" . $this->esc($row['recid']) . "',
                        '" . $this->esc($row['itmcde']) . "',
                        '" . $this->esc($row['conver']) . "',
                        '" . $this->esc($row['untmea']) . "',
                        '" . $this->esc($untprc) . "',
                        '" . $this->esc($row['untcst']) . "'
                    )";
                }

                if (!empty($values)) {
                    $sql = "INSERT INTO tbl_item_unit_file_rgdi (recid, itmcde, conver, untmea, untprc, untcst) 
                            VALUES " . implode(',', $values) . "
                            ON DUPLICATE KEY UPDATE 
                              itmcde = VALUES(itmcde),
                              conver = VALUES(conver),
                              untmea = VALUES(untmea),
                              untprc = VALUES(untprc),
                              untcst = VALUES(untcst)";

                    $this->sfaDB->query($sql);
                    $totalRecordsSynced += count($sourceData);
                }

                $offset += $batchSize;
            }
        } catch (\Exception $e) {
            $status = 'error';
            $errorMessage = $e->getMessage();
        }    

        return $status === 'success' ? "Data sync completed for Item Unit File RGDI with $totalRecordsSynced records." : "Sync failed. $errorMessage.";
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
