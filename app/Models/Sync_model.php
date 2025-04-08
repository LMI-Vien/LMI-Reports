<?php

namespace App\Models;

use CodeIgniter\Model;

class Sync_model extends Model
{
    protected $traccLmiDB;
    protected $sfaDB;

    public function __construct()
    {
        parent::__construct();
        $this->traccLmiDB = \Config\Database::connect('traccdatalmi');
        $this->traccRgdiDB = \Config\Database::connect('traccdatargdi');
        $this->sfaDB = \Config\Database::connect('default');
    }

    // public function syncData($batchSize = 5000)
    // {
    //     $offset = 0;
    //     while (true) {
    //         echo "Processing offset: $offset\n";

    //         $sourceData = $this->traccLmiDB->table('pricecodefile1')
    //                                      ->limit($batchSize, $offset)
    //                                      ->get()
    //                                      ->getResultArray();

    //         if (empty($sourceData)) {
    //             break;
    //         }

    //         $batchInsertData = [];
    //         $updateData = [];

    //         foreach ($sourceData as $row) {
    //             $existingRecord = $this->sfaDB->table('pricecodefile1tmp')
    //                                              ->select('id, prccde, prcdsc, curcde, chkmanual, withpromo, promdtefrm, promdteto, refnum, allowmanualentry, alloweditdiscount')
    //                                              ->where('id', $row['recid'])
    //                                              ->get()
    //                                              ->getRowArray();

    //             $newData = [
    //                 'id' => $row['recid'],
    //                 'prccde' => $row['prccde'],
    //                 'prcdsc' => $row['prcdsc'],
    //                 'curcde' => $row['curcde'],
    //                 'chkmanual' => $row['chkmanual'],
    //                 'withpromo' => $row['withpromo'],
    //                 'promdtefrm' => $row['promdtefrm'],
    //                 'promdteto' => $row['promdteto'],
    //                 'refnum' => $row['refnum'],
    //                 'allowmanualentry' => $row['allowmanualentry'],
    //                 'alloweditdiscount' => $row['alloweditdiscount'],
    //             ];

    //             if ($existingRecord) {
    //                 if ($newData != $existingRecord) {
    //                     $updateData[] = $newData;
    //                 }
    //             } else {
    //                 $batchInsertData[] = $newData;
    //             }
    //         }

    //         if (!empty($batchInsertData)) {
    //             $this->sfaDB->table('pricecodefile1tmp')->insertBatch($batchInsertData);
    //         }

    //         if (!empty($updateData)) {
    //             foreach ($updateData as $data) {
    //                 $this->sfaDB->table('pricecodefile1tmp')
    //                                ->where('id', $data['id'])
    //                                ->update($data);
    //             }
    //         }

    //         $offset += $batchSize;
    //     }

    //     return "Data synchronization completed in batches of $batchSize.";
    // }


    //optimized version
    public function syncDataPriceCodeLMI($batchSize = 5000)
    {
        $offset = 0;
        $totalRecordsSynced = 0;
        $errorMessage = null;
        $status = 'success';
        try {
            while (true) {
                $sourceData = $this->traccLmiDB->table('pricecodefile2')
                                             ->limit($batchSize, $offset)
                                             ->get()
                                             ->getResultArray();

                if (empty($sourceData)) {
                    break;
                }

                $values = [];
                foreach ($sourceData as $row) {
                    $values[] = "(
                        '" . addslashes($row['recid']) . "',
                        " . (empty($row['prcdte']) ? "NULL" : "'" . addslashes($row['prcdte']) . "'") . ",
                        " . (empty($row['upddte']) ? "NULL" : "'" . addslashes($row['upddte']) . "'") . ",
                        '" . addslashes($row['prccde']) . "',
                        '" . addslashes($row['itmcde']) . "',
                        '" . addslashes($row['itmdsc']) . "',
                        '" . addslashes($row['untmea']) . "',
                        '" . addslashes($row['groprc']) . "',
                        '" . addslashes($row['prcdst1']) . "',
                        '" . addslashes($row['prcdst2']) . "',
                        '" . addslashes($row['prcdst3']) . "',
                        '" . addslashes($row['prcdst4']) . "',
                        '" . addslashes($row['untprc']) . "',
                        '" . addslashes($row['curcde']) . "',
                        '" . addslashes($row['disper']) . "',
                        '" . addslashes($row['markup']) . "',
                        '" . addslashes($row['untcst']) . "',
                        '" . addslashes($row['disamt']) . "',
                        '" . addslashes($row['groprcgross']) . "',
                        '" . addslashes($row['cusitmcde']) . "',
                        '" . addslashes($row['salquota']) . "',
                        '" . addslashes($row['cusitmdsc']) . "',
                        '" . addslashes($row['gwpbasis']) . "'
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

    public function syncDataPriceCodeRGDI($batchSize = 5000)
    {
        $offset = 0;
        $totalRecordsSynced = 0;
        $errorMessage = null;
        $status = 'success';
        try {
            while (true) {
                $sourceData = $this->traccRgdiDB->table('pricecodefile2')
                                             ->limit($batchSize, $offset)
                                             ->get()
                                             ->getResultArray();

                if (empty($sourceData)) {
                    break;
                }

                $values = [];
                foreach ($sourceData as $row) {
                    $values[] = "(
                        '" . addslashes($row['recid']) . "',
                        " . (empty($row['prcdte']) ? "NULL" : "'" . addslashes($row['prcdte']) . "'") . ",
                        " . (empty($row['upddte']) ? "NULL" : "'" . addslashes($row['upddte']) . "'") . ",
                        '" . addslashes($row['prccde']) . "',
                        '" . addslashes($row['itmcde']) . "',
                        '" . addslashes($row['itmdsc']) . "',
                        '" . addslashes($row['untmea']) . "',
                        '" . addslashes($row['groprc']) . "',
                        '" . addslashes($row['prcdst1']) . "',
                        '" . addslashes($row['prcdst2']) . "',
                        '" . addslashes($row['prcdst3']) . "',
                        '" . addslashes($row['prcdst4']) . "',
                        '" . addslashes($row['untprc']) . "',
                        '" . addslashes($row['curcde']) . "',
                        '" . addslashes($row['disper']) . "',
                        '" . addslashes($row['markup']) . "',
                        '" . addslashes($row['untcst']) . "',
                        '" . addslashes($row['disamt']) . "',
                        '" . addslashes($row['groprcgross']) . "',
                        '" . addslashes($row['cusitmcde']) . "',
                        '" . addslashes($row['salquota']) . "',
                        '" . addslashes($row['cusitmdsc']) . "',
                        '" . addslashes($row['gwpbasis']) . "'
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

    public function syncDataitemfileLMI($batchSize = 5000)
    {
        $offset = 0;
        $totalRecordsSynced = 0;
        $errorMessage = null;
        $status = 'success';
        try {
            while (true) {
                $sourceData = $this->traccLmiDB->table('itemfile')
                                             ->limit($batchSize, $offset)
                                             ->get()
                                             ->getResultArray();

                if (empty($sourceData)) {
                    break;
                }

                $values = [];
                foreach ($sourceData as $row) {
                    $values[] = "(
                        '" . addslashes($row['recid']) . "',
                        '" . addslashes($row['supdsc']) . "',
                        '" . addslashes($row['itmcde']) . "',
                        '" . addslashes($row['itmdsc']) . "',
                        '" . addslashes($row['untmea']) . "',
                        '" . addslashes($row['conver']) . "',
                        '" . addslashes($row['untcst1']) . "',
                        '" . addslashes($row['untcst2']) . "',
                        '" . addslashes($row['crilvl']) . "',
                        '" . addslashes($row['remarks']) . "',
                        '" . addslashes($row['wardsc']) . "',
                        '" . addslashes($row['avecst']) . "',
                        '" . addslashes($row['status']) . "',
                        '" . addslashes($row['untcst']) . "',
                        '" . addslashes($row['untprc']) . "',
                        '" . addslashes($row['brndsc']) . "',
                        '" . addslashes($row['itmcladsc']) . "',
                        '" . addslashes($row['supcde']) . "',
                        '" . addslashes($row['warcde']) . "',
                        '" . addslashes($row['brncde']) . "',
                        '" . addslashes($row['itmclacde']) . "',
                        '" . addslashes($row['barcde']) . "',
                        '" . addslashes($row['inactive']) . "',
                        '" . addslashes($row['itmtyp']) . "',
                        '" . addslashes($row['multium']) . "',
                        '" . addslashes($row['reqsernum']) . "',
                        '" . addslashes($row['taxcde']) . "',
                        '" . addslashes($row['itmbal']) . "',
                        '" . addslashes($row['itmclass']) . "',
                        '" . addslashes($row['itmsrc']) . "'
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

    public function syncDataitemfileRGDI($batchSize = 5000)
    {
        $offset = 0;
        $totalRecordsSynced = 0;
        $errorMessage = null;
        $status = 'success';
        try {
            while (true) {
                $sourceData = $this->traccRgdiDB->table('itemfile')
                                             ->limit($batchSize, $offset)
                                             ->get()
                                             ->getResultArray();

                if (empty($sourceData)) {
                    break;
                }

                $values = [];
                foreach ($sourceData as $row) {
                    $values[] = "(
                        '" . addslashes($row['recid']) . "',
                        '" . addslashes($row['supdsc']) . "',
                        '" . addslashes($row['itmcde']) . "',
                        '" . addslashes($row['itmdsc']) . "',
                        '" . addslashes($row['untmea']) . "',
                        '" . addslashes($row['conver']) . "',
                        '" . addslashes($row['untcst1']) . "',
                        '" . addslashes($row['untcst2']) . "',
                        '" . addslashes($row['crilvl']) . "',
                        '" . addslashes($row['remarks']) . "',
                        '" . addslashes($row['wardsc']) . "',
                        '" . addslashes($row['avecst']) . "',
                        '" . addslashes($row['status']) . "',
                        '" . addslashes($row['untcst']) . "',
                        '" . addslashes($row['untprc']) . "',
                        '" . addslashes($row['brndsc']) . "',
                        '" . addslashes($row['itmcladsc']) . "',
                        '" . addslashes($row['supcde']) . "',
                        '" . addslashes($row['warcde']) . "',
                        '" . addslashes($row['brncde']) . "',
                        '" . addslashes($row['itmclacde']) . "',
                        '" . addslashes($row['barcde']) . "',
                        '" . addslashes($row['inactive']) . "',
                        '" . addslashes($row['itmtyp']) . "',
                        '" . addslashes($row['multium']) . "',
                        '" . addslashes($row['reqsernum']) . "',
                        '" . addslashes($row['taxcde']) . "',
                        '" . addslashes($row['itmbal']) . "',
                        '" . addslashes($row['itmclass']) . "',
                        '" . addslashes($row['itmsrc']) . "'
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
    //                     '" . addslashes($row['recid']) . "',
    //                     '" . addslashes($row['ptycde']) . "',
    //                     '" . addslashes($row['olditmcde']) . "',
    //                     '" . addslashes($row['saldisact']) . "',
    //                     '" . addslashes($row['purdisact']) . "',
    //                     '" . addslashes($row['scpwddis']) . "',
    //                     '" . addslashes($row['supdsc']) . "',
    //                     '" . addslashes($row['itmcde']) . "',
    //                     '" . addslashes($row['itmdsc']) . "',
    //                     '" . addslashes($row['untmea']) . "',
    //                     '" . addslashes($row['untmea2']) . "',
    //                     '" . addslashes($row['conver']) . "',
    //                     '" . addslashes($row['untcst1']) . "',
    //                     '" . addslashes($row['untcst2']) . "',
    //                     '" . addslashes($row['crilvl']) . "',
    //                     '" . addslashes($row['remarks']) . "',
    //                     '" . addslashes($row['wardsc']) . "',
    //                     '" . addslashes($row['avecst']) . "',
    //                     '" . addslashes($row['maxlvl']) . "',
    //                     '" . addslashes($row['status']) . "',
    //                     '" . addslashes($row['lstcst']) . "',
    //                     '" . addslashes($row['untcst']) . "',
    //                     '" . addslashes($row['untprc']) . "',
    //                     '" . addslashes($row['brndsc']) . "',
    //                     '" . addslashes($row['itmcladsc']) . "',
    //                     '" . addslashes($row['itmmdl']) . "',
    //                     '" . addslashes($row['supcde']) . "',
    //                     '" . addslashes($row['warcde']) . "',
    //                     '" . addslashes($row['brncde']) . "',
    //                     '" . addslashes($row['itmclacde']) . "',
    //                     '" . addslashes($row['salum']) . "',
    //                     '" . addslashes($row['srtum']) . "',
    //                     '" . addslashes($row['recum']) . "',
    //                     '" . addslashes($row['prtum']) . "',
    //                     '" . addslashes($row['invum']) . "',
    //                     '" . addslashes($row['barcde']) . "',
    //                     '" . addslashes($row['cstdebcde']) . "',
    //                     '" . addslashes($row['cstcrecde']) . "',
    //                     '" . addslashes($row['inactive']) . "',
    //                     '" . addslashes($row['itmtyp']) . "',
    //                     '" . addslashes($row['cgsactcde']) . "',
    //                     '" . addslashes($row['salactcde']) . "',
    //                     '" . addslashes($row['invactcde']) . "',
    //                     '" . addslashes($row['srtactcde']) . "',
    //                     '" . addslashes($row['multium']) . "',
    //                     '" . addslashes($row['reqsernum']) . "',
    //                     '" . addslashes($row['taxcde']) . "',
    //                     '" . addslashes($row['prtactcde']) . "',
    //                     '" . addslashes($row['puractcde']) . "',
    //                     '" . addslashes($row['purtaxcde']) . "',
    //                     '" . addslashes($row['salewtcde']) . "',
    //                     '" . addslashes($row['purewtcde']) . "',
    //                     '" . addslashes($row['salevatcde']) . "',
    //                     '" . addslashes($row['purevatcde']) . "',
    //                     '" . addslashes($row['salcur']) . "',
    //                     '" . addslashes($row['purcur']) . "',
    //                     '" . addslashes($row['itmrem1']) . "',
    //                     '" . addslashes($row['itmrem2']) . "',
    //                     '" . addslashes($row['itmrem3']) . "',
    //                     '" . addslashes($row['itmbal']) . "',
    //                     '" . addslashes($row['strqty']) . "',
    //                     '" . addslashes($row['chknontrd']) . "',
    //                     '" . addslashes($row['package']) . "',
    //                     '" . addslashes($row['rebdte']) . "',
    //                     '" . addslashes($row['itmprt']) . "',
    //                     '" . addslashes($row['gldepcde']) . "',
    //                     '" . addslashes($row['reqbatchnum']) . "',
    //                     '" . addslashes($row['logdte']) . "',
    //                     '" . addslashes($row['itmsubclacde']) . "',
    //                     '" . addslashes($row['linenum']) . "',
    //                     '" . addslashes($row['saltarget01']) . "',
    //                     '" . addslashes($row['saltarget02']) . "',
    //                     '" . addslashes($row['saltarget03']) . "',
    //                     '" . addslashes($row['saltarget04']) . "',
    //                     '" . addslashes($row['saltarget05']) . "',
    //                     '" . addslashes($row['saltarget06']) . "',
    //                     '" . addslashes($row['saltarget07']) . "',
    //                     '" . addslashes($row['saltarget08']) . "',
    //                     '" . addslashes($row['saltarget09']) . "',
    //                     '" . addslashes($row['saltarget10']) . "',
    //                     '" . addslashes($row['saltarget11']) . "',
    //                     '" . addslashes($row['saltarget12']) . "',
    //                     '" . addslashes($row['recumcon']) . "',
    //                     '" . addslashes($row['itmdeptcde']) . "',
    //                     '" . addslashes($row['itmmerchcatcde']) . "',
    //                     '" . addslashes($row['itmhierarchy']) . "',
    //                     '" . addslashes($row['itmclass']) . "',
    //                     '" . addslashes($row['itmtag']) . "',
    //                     '" . addslashes($row['itmsrc']) . "',
    //                     '" . addslashes($row['itminvmvmnttyp']) . "',
    //                     '" . addslashes($row['tariffcde']) . "',
    //                     '" . addslashes($row['bomactcde']) . "',
    //                     '" . addslashes($row['itmpalletcap']) . "',
    //                     '" . addslashes($row['splblum']) . "',
    //                     '" . addslashes($row['chkmultibarcde']) . "',
    //                     '" . addslashes($row['multibarcde']) . "',
    //                     '" . addslashes($row['purseractcde']) . "',
    //                     '" . addslashes($row['minOQ']) . "',
    //                     '" . addslashes($row['chkreorder']) . "',
    //                     '" . addslashes($row['maxOQ']) . "'
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
                        '" . addslashes($row['recid']) . "',
                        '" . addslashes($row['brncde']) . "',
                        '" . addslashes($row['brndsc']) . "',
                        1, 
                        NULL,
                        NULL,
                        1, 
                        NULL
                    )";
                }

                if (!empty($values)) {
                    $sql = "INSERT INTO tbl_brand (id, brand_code, brand_description, status, created_date, updated_date, created_by, updated_by) 
                            VALUES " . implode(',', $values) . "
                            ON DUPLICATE KEY UPDATE 
                              brand_code = VALUES(brand_code), 
                              brand_description = VALUES(brand_description),
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
                        '" . addslashes($row['recid']) . "',
                        '" . addslashes($row['itmclacde']) . "',
                        '" . addslashes($row['itmcladsc']) . "',
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

    public function syncCusPaymentGroupLmiData($batchSize = 5000)
    {
        $offset = 0;
        $totalRecordsSynced = 0;
        $errorMessage = null;
        $status = 'success';
        try {
            while (true) {
                $sourceData = $this->traccLmiDB->table('customergroupfile')
                                               ->limit($batchSize, $offset)
                                               ->get()
                                               ->getResultArray();

                if (empty($sourceData)) {
                    break;
                }

                $values = [];
                foreach ($sourceData as $row) {
                    $values[] = "(
                        '" . addslashes($row['recid']) . "',
                        '" . addslashes($row['cusgrpcde']) . "',
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

    public function syncCusPaymentGroupRgdiData($batchSize = 5000)
    {
        $offset = 0;
        $totalRecordsSynced = 0;
        $errorMessage = null;
        $status = 'success';
        try {
            while (true) {
                $sourceData = $this->traccRgdiDB->table('customergroupfile')
                                               ->limit($batchSize, $offset)
                                               ->get()
                                               ->getResultArray();

                if (empty($sourceData)) {
                    break;
                }

                $values = [];
                foreach ($sourceData as $row) {
                    $values[] = "(
                        '" . addslashes($row['recid']) . "',
                        '" . addslashes($row['cusgrpcde']) . "',
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

    public function syncCustomerLmiData($batchSize = 5000)
    {
        $offset = 0;
        $totalRecordsSynced = 0;
        $errorMessage = null;
        $status = 'success';
        try {
            while (true) {
                $sourceData = $this->traccLmiDB->table('customerfile')
                                               ->limit($batchSize, $offset)
                                               ->get()
                                               ->getResultArray();

                if (empty($sourceData)) {
                    break;
                }

                $values = [];
                foreach ($sourceData as $row) {
                    $values[] = "(
                        '" . addslashes($row['recid']) . "',
                        '" . addslashes($row['warcde']) . "',
                        '" . addslashes($row['cuscde']) . "',
                        '" . addslashes($row['cusdsc']) . "',
                        '" . addslashes($row['trmcde']) . "',
                        '" . addslashes($row['cusadd1']) . "',
                        '" . addslashes($row['tinnum']) . "',
                        '" . addslashes($row['smncde']) . "',
                        '" . addslashes($row['prccde']) . "',
                        '" . addslashes($row['aractcde']) . "',
                        '" . addslashes($row['cusgrpdsc']) . "',
                        '" . addslashes($row['curcde']) . "',
                        '" . addslashes($row['advactcde']) . "',
                        '" . addslashes($row['consig']) . "',
                        '" . addslashes($row['outright']) . "',
                        '" . addslashes($row['warcdenum']) . "',
                        '" . addslashes($row['warloccde']) . "',
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

    public function syncCustomerRgdiData($batchSize = 5000)
    {
        $offset = 0;
        $totalRecordsSynced = 0;
        $errorMessage = null;
        $status = 'success';
        try {
            while (true) {
                $sourceData = $this->traccRgdiDB->table('customerfile')
                                               ->limit($batchSize, $offset)
                                               ->get()
                                               ->getResultArray();

                if (empty($sourceData)) {
                    break;
                }

                $values = [];
                foreach ($sourceData as $row) {
                    $values[] = "(
                        '" . addslashes($row['recid']) . "',
                        '" . addslashes($row['warcde']) . "',
                        '" . addslashes($row['cuscde']) . "',
                        '" . addslashes($row['cusdsc']) . "',
                        '" . addslashes($row['trmcde']) . "',
                        '" . addslashes($row['cusadd1']) . "',
                        '" . addslashes($row['tinnum']) . "',
                        '" . addslashes($row['smncde']) . "',
                        '" . addslashes($row['prccde']) . "',
                        '" . addslashes($row['aractcde']) . "',
                        '" . addslashes($row['cusgrpdsc']) . "',
                        '" . addslashes($row['curcde']) . "',
                        '" . addslashes($row['advactcde']) . "',
                        '" . addslashes($row['consig']) . "',
                        '" . addslashes($row['outright']) . "',
                        '" . addslashes($row['warcdenum']) . "',
                        '" . addslashes($row['warloccde']) . "',
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

}
