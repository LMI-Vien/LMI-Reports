<?php

namespace App\Libraries;

use TCPDF;

class TCPDFLib extends TCPDF
{
    /** @var string */
    protected $reportTitle = '';

    /** @var array */
    protected $filterData = [];

    /**
     * Match TCPDF’s constructor signature exactly so you can still do
     * new TCPDFLib('L','mm','A4',true,'UTF-8',false);
     */
    public function __construct(
        $orientation = 'P',
        $unit        = 'mm',
        $format      = 'A4',
        $unicode     = true,
        $encoding    = 'UTF-8',
        $diskcache   = false,
        $pdfa        = false
    ) {
        parent::__construct(
            $orientation,
            $unit,
            $format,
            $unicode,
            $encoding,
            $diskcache,
            $pdfa
        );
    }


    // This is called automatically at the bottom of every page.
    public function Footer()
    {
        $this->SetY(-15);
        $this->SetFont('helvetica', 'I', 8);

        $pageNo  = $this->getAliasNumPage();
        $pageTot = $this->getAliasNbPages();

        $this->Cell(0, 10, "Page {$pageNo}/{$pageTot}", 0, 0, 'C');
    }
}
