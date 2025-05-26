<?php

namespace App\Models;

use CodeIgniter\Model;

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

    public function syncCusPaymentGroupLmiData($where, $batchSize = 5000)
    {
        $offset = 0;
        $totalRecordsSynced = 0;
        $errorMessage = null;
        $status = 'success';
        $filter = strtolower($where);
        try {
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

    // public function refreshScanData()
    // {
    //     $sql = "
    //         WITH distinct_store_count AS (
    //             SELECT COUNT(DISTINCT store_code) AS total_unique_store_codes
    //             FROM tbl_sell_out_data_details
    //         )
    //         SELECT
    //             so.year,
    //             so.month,
    //             so.store_code,
    //             blt.id AS brand_type_id,
    //             GROUP_CONCAT(DISTINCT so.brand_ambassador_ids) AS ba_ids,
    //             so.brand_ids,
    //             so.area_id,
    //             so.asc_id,
    //             h.company,
    //             ROUND(SUM(COALESCE(so.gross_sales, 0)), 2) AS gross_sales,
    //             ROUND(SUM(COALESCE(so.net_sales, 0)), 2) AS net_sales,
    //             ROUND(SUM(COALESCE(so.quantity, 0)), 2) AS quantity,
    //             GROUP_CONCAT(DISTINCT CASE WHEN h.company = '2' THEN pclmi.itmcde ELSE pcrgdi.itmcde END) AS itmcde,
    //             GROUP_CONCAT(DISTINCT CASE WHEN h.company = '2' THEN pitmlmi.brncde ELSE itmrgdi.brncde END) AS brncde,
    //             CONCAT(MAX(so.store_code), ' - ', s.description) AS store_name,
    //             GROUP_CONCAT(DISTINCT ba.type) AS ba_types,
    //             GROUP_CONCAT(DISTINCT so.sku_code) AS sku_codes
    //         FROM tbl_sell_out_data_details so
    //         INNER JOIN tbl_sell_out_data_header h ON so.data_header_id = h.id
    //         LEFT JOIN tbl_store s ON so.store_code = s.code
    //         LEFT JOIN tbl_price_code_file_2_lmi pclmi 
    //             ON so.sku_code = pclmi.cusitmcde AND h.company = '2'
    //         LEFT JOIN tbl_price_code_file_2_rgdi pcrgdi 
    //             ON so.sku_code = pcrgdi.cusitmcde AND h.company != '2'
    //         LEFT JOIN tbl_itemfile_lmi pitmlmi 
    //             ON pclmi.itmcde = pitmlmi.itmcde AND h.company = '2'
    //         LEFT JOIN tbl_itemfile_rgdi itmrgdi 
    //             ON pcrgdi.itmcde = itmrgdi.itmcde AND h.company != '2'
    //         LEFT JOIN tbl_brand b ON 
    //             (h.company = '2' AND pitmlmi.brncde = b.brand_code) OR
    //             (h.company != '2' AND itmrgdi.brncde = b.brand_code)
    //         LEFT JOIN tbl_brand_label_type blt ON b.category_id = blt.id
    //         LEFT JOIN tbl_brand_ambassador ba 
    //             ON FIND_IN_SET(ba.id, so.brand_ambassador_ids)
    //         GROUP BY so.store_code, so.year, so.month, blt.id
    //     ";

    //     $query = $this->sfaDB->query($sql);
    //     $allData = $query->getResultArray();

    //     $inserted = 0;
    //     foreach ($allData as $row) {
    //         $existing = $this->sfaDB->table('tbl_sell_out_pre_aggregated_data')
    //             ->where('year', $row['year'])
    //             ->where('month', $row['month'])
    //             ->where('store_code', $row['store_code'])
    //             ->where('brand_type_id', $row['brand_type_id'])
    //             ->get()
    //             ->getRow();

    //         if (!$existing) {
    //             $this->sfaDB->table('tbl_sell_out_pre_aggregated_data')->insert($row);
    //             $inserted++;
    //         }
    //     }

    //     return [
    //         'total_inserted' => $inserted
    //     ];
    // }

    // public function refreshScanData()
    // {
    //     $sql = "
    //         WITH distinct_store_count AS (
    //             SELECT COUNT(DISTINCT store_code) AS total_unique_store_codes
    //             FROM tbl_sell_out_data_details
    //         )
    //         SELECT
    //             so.year,
    //             so.month,
    //             so.store_code,
    //             blt.id AS brand_type_id,
    //             GROUP_CONCAT(DISTINCT so.brand_ambassador_ids) AS ba_ids,
    //             so.brand_ids,
    //             so.area_id,
    //             so.asc_id,
    //             h.company,
    //             ROUND(SUM(COALESCE(so.gross_sales, 0)), 2) AS gross_sales,
    //             ROUND(SUM(COALESCE(so.net_sales, 0)), 2) AS net_sales,
    //             ROUND(SUM(COALESCE(so.quantity, 0)), 2) AS quantity,
    //             GROUP_CONCAT(DISTINCT CASE WHEN h.company = '2' THEN pclmi.itmcde ELSE pcrgdi.itmcde END) AS itmcde,
    //             GROUP_CONCAT(DISTINCT CASE WHEN h.company = '2' THEN pitmlmi.brncde ELSE itmrgdi.brncde END) AS brncde,
    //             CONCAT(MAX(so.store_code), ' - ', s.description) AS store_name,
    //             GROUP_CONCAT(DISTINCT ba.type) AS ba_types,
    //             GROUP_CONCAT(DISTINCT so.sku_code) AS sku_codes
    //         FROM tbl_sell_out_data_details so
    //         INNER JOIN tbl_sell_out_data_header h ON so.data_header_id = h.id
    //         LEFT JOIN tbl_store s ON so.store_code = s.code
    //         LEFT JOIN tbl_price_code_file_2_lmi pclmi 
    //             ON so.sku_code = pclmi.cusitmcde AND h.company = '2'
    //         LEFT JOIN tbl_price_code_file_2_rgdi pcrgdi 
    //             ON so.sku_code = pcrgdi.cusitmcde AND h.company != '2'
    //         LEFT JOIN tbl_itemfile_lmi pitmlmi 
    //             ON pclmi.itmcde = pitmlmi.itmcde AND h.company = '2'
    //         LEFT JOIN tbl_itemfile_rgdi itmrgdi 
    //             ON pcrgdi.itmcde = itmrgdi.itmcde AND h.company != '2'
    //         LEFT JOIN tbl_brand b ON 
    //             (h.company = '2' AND pitmlmi.brncde = b.brand_code) OR
    //             (h.company != '2' AND itmrgdi.brncde = b.brand_code)
    //         LEFT JOIN tbl_brand_label_type blt ON b.category_id = blt.id
    //         LEFT JOIN tbl_brand_ambassador ba 
    //             ON FIND_IN_SET(ba.id, so.brand_ambassador_ids)
    //         GROUP BY so.store_code, so.year, so.month, blt.id
    //     ";

    //     $query = $this->sfaDB->query($sql);
    //     $allData = $query->getResultArray();

    //     $batchSize = 1000;
    //     $batch = [];
    //     $inserted = 0;

    //     $this->sfaDB->transStart(); 

    //     foreach ($allData as $row) {
    //         $batch[] = $row;

    //         if (count($batch) === $batchSize) {
    //             $this->sfaDB->table('tbl_sell_out_pre_aggregated_data')
    //                 ->ignore(true) // Skip duplicates based on unique keys
    //                 ->insertBatch($batch);
    //             $inserted += count($batch);
    //             $batch = [];
    //         }
    //     }

    //     // Insert remaining
    //     if (!empty($batch)) {
    //         $this->sfaDB->table('tbl_sell_out_pre_aggregated_data')
    //             ->ignore(true)
    //             ->insertBatch($batch);
    //         $inserted += count($batch);
    //     }

    //     $this->sfaDB->transComplete();

    //     return [
    //         'total_inserted' => $inserted
    //     ];
    // }

    public function refreshScanDatabk()
    {
        $sql = "
            WITH
            -- Deduplicated price code file for LMI
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
            -- Deduplicated itemfile for LMI
            dedup_pitmlmi AS (
                SELECT itmcde, MIN(brncde) AS brncde
                FROM tbl_itemfile_lmi
                GROUP BY itmcde
            ),
            dedup_itmrgdi AS (
                SELECT itmcde, MIN(brncde) AS brncde
                FROM tbl_itemfile_rgdi
                GROUP BY itmcde
            ),
            aggregated_so AS (
                SELECT
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
                GROUP BY so.year, so.month, so.store_code, so.brand_ambassador_ids, so.brand_ids, so.area_id, so.asc_id, so.data_header_id, so.sku_code, so.ba_types
            ),
            final_data AS (
                SELECT
                    aso.year,
                    aso.month,
                    aso.store_code,
                    blt.id AS brand_type_id,
                    bbt.sfa_filter AS brand_term_id,
                    GROUP_CONCAT(DISTINCT aso.brand_ambassador_ids) AS ba_ids,
                    GROUP_CONCAT(DISTINCT aso.brand_ids) AS brand_ids,
                    GROUP_CONCAT(DISTINCT aso.ba_types) AS ba_types,
                    aso.area_id,
                    aso.asc_id,
                    aso.company,
                    SUM(aso.gross_sales) AS gross_sales,
                    SUM(aso.net_sales) AS net_sales,
                    SUM(aso.quantity) AS quantity,
                    GROUP_CONCAT(DISTINCT CASE WHEN aso.company = '2' THEN pclmi.itmcde ELSE pcrgdi.itmcde END) AS itmcde,
                    GROUP_CONCAT(DISTINCT CASE WHEN aso.company = '2' THEN pitmlmi.brncde ELSE itmrgdi.brncde END) AS brncde,
                    CONCAT(MAX(aso.store_code), ' - ', s.description) AS store_name,
                    GROUP_CONCAT(DISTINCT aso.sku_code) AS sku_codes
                FROM aggregated_so aso
                LEFT JOIN tbl_store s ON aso.store_code = s.code

                LEFT JOIN dedup_pclmi pclmi ON aso.sku_code = pclmi.cusitmcde AND aso.company = '2'
                LEFT JOIN dedup_pcrgdi pcrgdi ON aso.sku_code = pcrgdi.cusitmcde AND aso.company != '2'

                LEFT JOIN dedup_pitmlmi pitmlmi ON pclmi.itmcde = pitmlmi.itmcde AND aso.company = '2'
                LEFT JOIN dedup_itmrgdi itmrgdi ON pcrgdi.itmcde = itmrgdi.itmcde AND aso.company != '2'

                LEFT JOIN tbl_brand b ON 
                    (aso.company = '2' AND pitmlmi.brncde = b.brand_code) OR
                    (aso.company != '2' AND itmrgdi.brncde = b.brand_code)

                LEFT JOIN tbl_brand_label_type blt ON b.category_id = blt.id
                LEFT JOIN tbl_brand_terms bbt ON b.terms_id = bbt.id

                GROUP BY
                    aso.year,
                    aso.month,
                    aso.store_code,
                    aso.area_id,
                    aso.asc_id,
                    aso.company,
                    blt.id,
                    bbt.sfa_filter
            )
            SELECT * FROM final_data
        ";


        $query = $this->sfaDB->query($sql);
        $allData = $query->getResultArray();

        // Batch insert
        $batchSize = 2000;
        $batch = [];
        $inserted = 0;
        $this->sfaDB->table('tbl_sell_out_pre_aggregated_data')->truncate();
        $this->sfaDB->transStart();

        foreach ($allData as $row) {
            $batch[] = $row;

            if (count($batch) === $batchSize) {
                $this->sfaDB->table('tbl_sell_out_pre_aggregated_data')
                    ->ignore(true)
                    ->insertBatch($batch);
                $inserted += count($batch);
                $batch = [];
            }
        }

        if (!empty($batch)) {
            $this->sfaDB->table('tbl_sell_out_pre_aggregated_data')
                ->ignore(true)
                ->insertBatch($batch);
            $inserted += count($batch);
        }

        $this->sfaDB->transComplete();

        return [
            'total_inserted' => $inserted
        ];
    }

    // public function refreshScanData()
    // {
    //     $sql = "
    //         WITH aggregated_so AS (
    //             SELECT
    //                 so.year,
    //                 so.month,
    //                 so.store_code,
    //                 so.brand_ambassador_ids,
    //                 so.brand_ids,
    //                 so.area_id,
    //                 so.asc_id,
    //                 so.ba_types,
    //                 h.company,
    //                 so.sku_code,

    //                 ROUND(SUM(COALESCE(so.gross_sales, 0)), 2) AS gross_sales,
    //                 ROUND(SUM(COALESCE(so.net_sales,   0)), 2) AS net_sales,
    //                 ROUND(SUM(COALESCE(so.quantity,     0)), 2) AS quantity

    //             FROM tbl_sell_out_data_details so
    //             INNER JOIN tbl_sell_out_data_header h
    //                 ON so.data_header_id = h.id
    //             LEFT JOIN tbl_brand_ambassador ba
    //                 ON FIND_IN_SET(CAST(ba.id AS CHAR), so.brand_ambassador_ids)

    //             GROUP BY
    //                 so.year,
    //                 so.month,
    //                 so.store_code,
    //                 so.brand_ambassador_ids,
    //                 so.ba_types,
    //                 so.brand_ids,
    //                 so.data_header_id,
    //                 so.area_id,
    //                 so.asc_id,
    //                 h.company,
    //                 so.sku_code
    //         ),

    //         final_data AS (
    //             SELECT
    //                 aso.year,
    //                 aso.month,
    //                 aso.store_code,

    //                 blt.id            AS brand_type_id,
    //                 bbt.sfa_filter    AS brand_term_id,
    //                 aso.brand_ambassador_ids AS ba_ids,
    //                 aso.brand_ids,
    //                 aso.ba_types,

    //                 aso.area_id,
    //                 aso.asc_id,
    //                 aso.company,

    //                 SUM(aso.gross_sales)  AS gross_sales,
    //                 SUM(aso.net_sales)    AS net_sales,
    //                 SUM(aso.quantity)     AS quantity,

    //                 CASE WHEN aso.company = '2'
    //                      THEN pclmi.itmcde
    //                      ELSE pcrgdi.itmcde
    //                 END AS itmcde,

    //                 CASE WHEN aso.company = '2'
    //                      THEN pitmlmi.brncde
    //                      ELSE itmrgdi.brncde
    //                 END AS brncde,

    //                 CONCAT(
    //                   MAX(aso.store_code),
    //                   ' - ',
    //                   MAX(s.description)
    //                 ) AS store_name,

    //                 aso.sku_code AS sku_codes

    //             FROM aggregated_so aso

    //             LEFT JOIN tbl_store s
    //               ON aso.store_code = s.code

    //             LEFT JOIN tbl_price_code_file_2_lmi pclmi
    //               ON aso.sku_code = pclmi.cusitmcde
    //              AND aso.company = '2'

    //             LEFT JOIN tbl_price_code_file_2_rgdi pcrgdi
    //               ON aso.sku_code = pcrgdi.cusitmcde
    //              AND aso.company != '2'

    //             LEFT JOIN tbl_itemfile_lmi  pitmlmi
    //               ON pclmi.itmcde = pitmlmi.itmcde
    //              AND aso.company = '2'

    //             LEFT JOIN tbl_itemfile_rgdi itmrgdi
    //               ON pcrgdi.itmcde = itmrgdi.itmcde
    //              AND aso.company != '2'

    //             LEFT JOIN tbl_brand b
    //               ON ( aso.company = '2'  AND pitmlmi.brncde = b.brand_code )
    //               OR ( aso.company != '2' AND itmrgdi.brncde = b.brand_code )

    //             LEFT JOIN tbl_brand_label_type blt
    //               ON b.category_id = blt.id

    //             LEFT JOIN tbl_brand_terms bbt
    //               ON b.terms_id = bbt.id

    //             GROUP BY
    //                 aso.year,
    //                 aso.month,
    //                 aso.store_code,
    //                 aso.brand_ambassador_ids,
    //                 aso.brand_ids,
    //                 aso.ba_types,
    //                 aso.area_id,
    //                 aso.asc_id,
    //                 aso.company,
    //                 blt.id,
    //                 bbt.sfa_filter,
    //                 aso.sku_code
    //         )

    //         SELECT * FROM final_data;
    //     ";

    //     // run the SQL and fetch everything
    //     $allData = $this->sfaDB
    //                     ->query($sql)
    //                     ->getResultArray();

    //     // clear out the old pre-agg rows
    //     $this->sfaDB
    //          ->table('tbl_sell_out_pre_aggregated_data')
    //          ->truncate();

    //     // bulk-insert in 2k‐row chunks
    //     $batchSize = 2000;
    //     $inserted  = 0;

    //     $this->sfaDB->transStart();

    //     foreach (array_chunk($allData, $batchSize) as $batch) {
    //         $this->sfaDB
    //              ->table('tbl_sell_out_pre_aggregated_data')
    //              ->insertBatch($batch);

    //         $inserted += count($batch);
    //     }

    //     $this->sfaDB->transComplete();

    //     if ($this->sfaDB->transStatus() === false) {
    //         // Something went wrong; rollback happened
    //         log_message('error', 'Transaction failed during scan data insert');
    //         return [
    //             'error' => 'Transaction failed. Data was not saved.'
    //         ];
    //     }
    //     return [
    //         'total_inserted' => $inserted
    //     ];
    // }

        public function refreshScanData()
        {
            $sql = "
                WITH
                -- Deduplicated price code file for LMI
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
                -- Deduplicated itemfile for LMI
                dedup_pitmlmi AS (
                    SELECT itmcde, MIN(brncde) AS brncde
                    FROM tbl_itemfile_lmi
                    GROUP BY itmcde
                ),
                dedup_itmrgdi AS (
                    SELECT itmcde, MIN(brncde) AS brncde
                    FROM tbl_itemfile_rgdi
                    GROUP BY itmcde
                ),
                aggregated_so AS (
                    SELECT
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
                    GROUP BY so.year, so.month, so.store_code, so.brand_ambassador_ids, so.brand_ids, so.area_id, so.asc_id, so.data_header_id, so.sku_code, so.ba_types
                ),
                final_data AS (
                    SELECT
                        aso.year,
                        aso.month,
                        aso.store_code,
                        blt.id AS brand_type_id,
                        bbt.sfa_filter AS brand_term_id,
                        GROUP_CONCAT(DISTINCT aso.brand_ambassador_ids) AS ba_ids,
                        GROUP_CONCAT(DISTINCT aso.brand_ids) AS brand_ids,
                        GROUP_CONCAT(DISTINCT aso.ba_types) AS ba_types,
                        aso.area_id,
                        aso.asc_id,
                        aso.company,
                        SUM(aso.gross_sales) AS gross_sales,
                        SUM(aso.net_sales) AS net_sales,
                        SUM(aso.quantity) AS quantity,
                        GROUP_CONCAT(DISTINCT CASE WHEN aso.company = '2' THEN pclmi.itmcde ELSE pcrgdi.itmcde END) AS itmcde,
                        GROUP_CONCAT(DISTINCT CASE WHEN aso.company = '2' THEN pitmlmi.brncde ELSE itmrgdi.brncde END) AS brncde,
                        CONCAT(MAX(aso.store_code), ' - ', s.description) AS store_name,
                        GROUP_CONCAT(DISTINCT aso.sku_code) AS sku_codes
                    FROM aggregated_so aso
                    LEFT JOIN tbl_store s ON aso.store_code = s.code

                    LEFT JOIN dedup_pclmi pclmi ON aso.sku_code = pclmi.cusitmcde AND aso.company = '2'
                    LEFT JOIN dedup_pcrgdi pcrgdi ON aso.sku_code = pcrgdi.cusitmcde AND aso.company != '2'

                    LEFT JOIN dedup_pitmlmi pitmlmi ON pclmi.itmcde = pitmlmi.itmcde AND aso.company = '2'
                    LEFT JOIN dedup_itmrgdi itmrgdi ON pcrgdi.itmcde = itmrgdi.itmcde AND aso.company != '2'

                    LEFT JOIN tbl_brand b ON 
                        (aso.company = '2' AND pitmlmi.brncde = b.brand_code) OR
                        (aso.company != '2' AND itmrgdi.brncde = b.brand_code)

                    LEFT JOIN tbl_brand_label_type blt ON b.category_id = blt.id
                    LEFT JOIN tbl_brand_terms bbt ON b.terms_id = bbt.id

                    GROUP BY
                        aso.year,
                        aso.month,
                        aso.store_code,
                        aso.area_id,
                        aso.asc_id,
                        aso.company,
                        blt.id,
                        bbt.sfa_filter
                )
                SELECT * FROM final_data
            ";


            // Execute the query
            $allData = $this->sfaDB->query($sql)->getResultArray();

            if (empty($allData)) {
                log_message('error', 'No data found during refreshScanData copy.');
                return ['error' => 'No data found.'];
            }

            // Clear target table
            $this->sfaDB->table('tbl_sell_out_pre_aggregated_data')->truncate();

            // Insert in batches
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


    public function refreshVmiData(){
        
    }

    public function refreshAll()
    {
        $scanResult = $this->refreshScanData();
        $vmiResult = $this->refreshVmiData();

        return [
            'scan' => $scanResult,
            'vmi'  => $vmiResult,
        ];
    }

}
