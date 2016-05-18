<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class invoice extends CI_Controller {

    /**
     * Example: FPDF 
     *
     * Documentation: 
     * http://www.fpdf.org/ > Manual
     *
     */
    public function __construct() {

        parent::__construct();
    }

    public function index() {
        $this->load->library('fpdf_gen');


        $this->fpdf->AddFont('angsana', '', 'angsa.php');
        $this->fpdf->SetFont('angsana', '', 16);
        //$this->fpdf->Cell(40,10,'สัญญาเช่าห้องพัก');
        $this->fpdf->SetY(20);


        $xx = 'สัญญาเช่าห้องพัก (ในหอพัก)' . "\n";


        // $this->fpdf->Cell(width, height, text, border, position-next-cell, alignment);
        $this->fpdf->MultiCell(0, 5, iconv('UTF-8', 'cp874', $xx), 0, 'C');
        $this->fpdf->Ln();

        $xx .= 'สัญญาน้ำขั้นระหว่าง………………………………………อยู่บ้านเลขที่………………………';
        $xx .= 'ถนน………………………………..ตำบล/แขวง……………………………อำเภอ/เขต……………………';
        $xx .= 'จังหวัด…….……………………ซึ่งต่อไปในสัญญานี้จะเรียกว่า “ผู้เช่า” ฝ่ายหนึ่ง กับ………………………';
        $xx .= '………………………….. ……………….อยู่บ้านเลขที่ ………….…………ถนน………………………';
        $xx .= 'ตำบล/แขวง…………………………อำเภอ/เขต…………………………….จังหวัด…………………………';
        $xx .= 'ซึ่งต่อไปในสัญญานี้จะเรียกว่า “ผู้ให้เช่า” อีกฝ่ายหนึ่ง';


        $this->fpdf->SetX(15);
        $this->fpdf->MultiCell(0, 7, iconv('UTF-8', 'cp874', $xx));

        echo $this->fpdf->Output();
    }

    public function bill3() {
        $this->load->view('invoice', '', false);
    }
    public function bill2() {

     
        $data = [];

        //load mPDF library
        $this->load->library('m_pdf');

        $html = $this->load->view('invoice', $data, true);

        $this->m_pdf->pdf->WriteHTML($html);
        //download it.
    
        $this->m_pdf->pdf->Output();
      
    }

}
