<?php

error_reporting(E_ALL ^ E_DEPRECATED);

function pdfEncrypt($origFile, $password, $destFile)
{
    require_once('FPDI_Protection.php');
    $pdf = new FPDI_Protection();
    // set the format of the destinaton file
    $pdf->FPDF("P", "in", array('8.27', '11.69'));
    //calculate the number of pages from the original document
    $pagecount = $pdf->setSourceFile($origFile);

    // copy all pages from the old unprotected pdf in the new one
    for ($loop = 1; $loop <= $pagecount; $loop++) {
        $tplidx = $pdf->importPage($loop);
        $pdf->addPage();
        $pdf->useTemplate($tplidx);
    }

    $pdf->SetProtection(array(), $password);
    $pdf->Output($destFile, 'F');
    return $destFile;
}

//password for the pdf file
$password = "a2zwebhelp";

//name of the original file
$origFile = "AuditReport.pdf";

//name of the destination file 
$destFile = "AuditReport_p.pdf";

//encrypt the book and create the protected file
pdfEncrypt($origFile, $password, $destFile);
