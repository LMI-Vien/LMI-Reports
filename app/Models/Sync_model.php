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
                {$whereClause}
                GROUP BY so.year, so.month, so.store_code, so.brand_ambassador_ids, so.brand_ids, so.area_id, so.asc_id, so.data_header_id, so.sku_code, so.ba_types
            ),
            final_data AS (
                SELECT
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
                    GROUP_CONCAT(DISTINCT CASE WHEN aso.company = '2' THEN pclmi.itmcde ELSE pcrgdi.itmcde END) AS itmcde,
                    CASE WHEN aso.company = '2' THEN pitmlmi.brncde ELSE itmrgdi.brncde END AS brncde,
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
                    bbt.sfa_filter,
                    brncde,
                    b.id
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

    public function refreshVmiData($week = null, $year = null, $company = null)
    {

        $whereClause = '';

        if ($week && $year && $company) {
            $whereClause = "WHERE tv.week = {$week} AND tv.year = {$year} AND tv.company = {$company}";
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
                SELECT itmcde, MIN(brncde) AS brncde, MIN(itmclacde) AS itmclacde
                FROM tbl_itemfile_lmi
                GROUP BY itmcde
            ),
            dedup_itmrgdi AS (
                SELECT itmcde, MIN(brncde) AS brncde, MIN(itmclacde) AS itmclacde
                FROM tbl_itemfile_rgdi
                GROUP BY itmcde
            ),
            aggregated_vmi AS (
                SELECT
                    tv.id,
                    tv.store AS store_id,
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
                GROUP BY tv.year, tv.week, tv.store, tv.brand_ambassador_ids, tv.brand_ids, tv.area_id, tv.asc_id, tv.company, tv.item, tv.ba_types
            ),
            final_data AS (
                SELECT
                    avmi.year,
                    avmi.week,
                    avmi.store_id,
                    blt.id AS brand_type_id,
                    bbt.sfa_filter AS brand_term_id,
                    b.id AS tracc_brand_id,
                    avmi.vmi_status,
                    avmi.supplier,
                    GROUP_CONCAT(DISTINCT avmi.ba_ids) AS ba_ids,
                    GROUP_CONCAT(DISTINCT avmi.brand_ids) AS brand_ids,
                    avmi.area_id,
                    avmi.asc_id,
                    avmi.ba_types,
                    avmi.c_group,
                    avmi.dept,
                    avmi.c_class,
                    avmi.sub_class,
                    avmi.company,
                    s.code AS store_code,
                    SUM(avmi.on_hand) AS on_hand,
                    SUM(avmi.in_transit) AS in_transit,
                    SUM(avmi.average_sales_unit) AS average_sales_unit,
                    SUM(avmi.on_hand) + SUM(avmi.in_transit) AS total_qty,
                    GROUP_CONCAT(DISTINCT CASE WHEN avmi.company = '2' THEN pclmi.itmcde ELSE pcrgdi.itmcde END) AS itmcde,
                    CASE WHEN avmi.company = '2' THEN pitmlmi.brncde ELSE itmrgdi.brncde END AS brncde,
                    CASE WHEN avmi.company = '2' THEN pitmlmi.itmclacde ELSE itmrgdi.itmclacde END AS itmclacde,
                    CONCAT(MAX(s.code), ' - ', s.description) AS store_name,
                    avmi.item AS item,
                    avmi.item_name AS item_name,
                    avmi.item_class
                FROM aggregated_vmi avmi
                LEFT JOIN tbl_store s ON avmi.store_id = s.id
                -- to check if sku_Code = item
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
                    avmi.year,
                    avmi.week,
                    avmi.store_id,
                    avmi.area_id,
                    avmi.asc_id,
                    avmi.company,
                    avmi.item,
                    avmi.item_class,
                    blt.id,
                    bbt.sfa_filter,
                    brncde,
                    b.id
            )
            SELECT * FROM final_data
        ";

        $query = $this->sfaDB->query($sql);
        $allData = $query->getResultArray();

        if (!$company || !$week || !$year) {
            $this->sfaDB->table('tbl_vmi_pre_aggregated_data')->truncate();
        }
        //$this->db->query("TRUNCATE TABLE tbl_vmi_pre_aggregated_data");

        $batchSize = 10000;
        $chunks = array_chunk($allData, $batchSize);

        foreach ($chunks as $chunk) {
            $this->sfaDB->table('tbl_vmi_pre_aggregated_data')->insertBatch($chunk);
        }

        return [
            'total_inserted' => count($allData)
        ];
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
