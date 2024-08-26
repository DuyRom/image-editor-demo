<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use PhpOffice\PhpWord\PhpWord;
use PhpOffice\PhpWord\Writer\Word2007;
use Carbon\Carbon;

class Letter extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request)
    {
        $phpWord = new PhpWord();
        // Setting various styles to be used
        $phpWord->addParagraphStyle('p1Style', array('align'=>'both', 'spaceAfter'=>0, 'spaceBefore'=>0));
        $phpWord->addParagraphStyle('p2Style', array('align'=>'both'));
        $phpWord->addParagraphStyle('p3Style', array('align'=>'right', 'spaceAfter'=>0, 'spaceBefore'=>0));
        $phpWord->addFontStyle('f1Style', array('name' => 'Calibri', 'size'=>12));
        $phpWord->addFontStyle('f2Style', array('name' => 'Calibri','bold'=>true, 'size'=>12));
        $company = "ABC (Private) Limited";
        // Defining data. For simplicity we're using hardcoded data; practically they will be fetched from database.
        $no_of_banks = 3;
        $branches = ["Clifton Branch","Defence Branch","15th Street Branch"];
        $begin = Carbon::parse("1/1/2020");
        $end = Carbon::parse("12/31/2020");
        $year = $end->year;
        $str = "first Monday of July {$year}";
        $date = new Carbon($str);
        // Getting first characters from company name for generating reference
        $name = str_replace(["(",")"],"",$company);
        $words = preg_split("/[\s,_-]+/", $name);
        $acronym = "";
        $count = 1;
        foreach ($words as $w) {
            $acronym .= $w[0];
        }
        // Generating letter for each branch
        for($i=0;$i<count($branches);$i++) {
            $section = $phpWord->addSection();
$textrun = $section->addTextRun();
            $section->addTextBreak(2);
$ref = "MZ-BCONF/".$acronym."/".$year."/".$count++;
            $section->addText($ref, 'f2Style', 'p1Style');
            
            $textrun = $section->addTextRun();
            $section->addTextBreak(1);
$section->addText($date->format('F j, Y'), 'f2Style', 'p1Style');
$textrun = $section->addTextRun();
            $section->addTextBreak(0);
$section->addText('The Manager,','f1Style','p1Style');
            $section->addText($branches[$i],'f1Style','p1Style');
$textrun = $section->addTextRun();
            $section->addTextBreak(0);
            $section->addText('Dear Sir,','f1Style','p2Style');
$textrun = $section->addTextRun();
            $section->addTextBreak(0);
$textrun = $section->addTextRun('p2Style');
            $textrun->addText('Subject: ', 'f1Style');
            $textrun->addText('Bank Report for Audit Purpose of ', 'f2Style');
            $textrun->addText($company, 'f2Style');
$textrun = $section->addTextRun();
            $section->addTextBreak(0);
$textrun = $section->addTextRun('p2Style');
            $textrun->addText(
                "In accordance with your above named customer’s instructions given hereon, please send DIRECT to us at the below address, as auditors of your customer, the following information relating to their affairs at your branch as at the close of business on ",
                'f1Style',
            );
            $textrun->addText($end->format('F j, Y'), 'f2Style');
            $textrun->addText(
                " and, in the case of items 2, 4 and 9, during the period since ",
                'f1Style',
            );
            $textrun->addText($begin->format('F j, Y'), 'f2Style');
$textrun = $section->addTextRun();
            $section->addTextBreak(0);
$textrun = $section->addTextRun();
            $textrun->addText(
                "Please state against each item any factors which may limit the completeness of your reply; if there is nothing to report, state ‘NONE’.",
                'f1Style', 'p2Style'
            );
            
            $textrun = $section->addTextRun();
            $section->addTextBreak(0);
$textrun = $section->addTextRun();
            $textrun->addText(
                "It is understood that any replies given are in strict confidence, for the purposes of audit.",
                'f1Style', 'p2Style'
            );
$textrun = $section->addTextRun();
            $section->addTextBreak(0);
$textrun = $section->addTextRun();
            $textrun->addText(
                "Yours truly,",
                'f1Style', 'p2Style'
            );
$section->addText(
                "Disclosure  Authorized",
                'f2Style', 'p3Style'
            );
$section->addText(
                "For  and  on  behalf  of",
                'f2Style', 'p3Style'
            );
$textrun = $section->addTextRun();
            $section->addTextBreak(1);
$textrun = $section->addTextRun();
            $textrun->addText(
                "Chartered Accountants                                                                                  ___________________",
                'f2Style', 'p2Style'
            );
$textrun = $section->addTextRun();
            $section->addTextBreak(0);
$textrun = $section->addTextRun();
            $textrun->addText(
                "Enclosures:",
                'f1Style', 'p2Style'
            );
}
$writer = new Word2007($phpWord);
        $writer->save('Bank Letters.docx');
    }
}
