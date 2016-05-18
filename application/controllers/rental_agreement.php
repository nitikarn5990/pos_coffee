<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class rental_agreement extends CI_Controller {

    /**
     * Index Page for this controller.
     *
     * Maps to the following URL
     * 		http://example.com/index.php/welcome
     * 	- or -
     * 		http://example.com/index.php/welcome/index
     * 	- or -
     * Since this controller is set as the default controller in
     * config/routes.php, it's displayed at http://example.com/
     *
     * So any other public methods not prefixed with an underscore will
     * map to /index.php/welcome/<method_name>
     * @see https://codeigniter.com/user_guide/general/urls.html
     */
    public function __construct() {

        parent::__construct();

        if ($this->session->userdata('is_logged_in') == '') {

            $this->session->set_userdata('url_back', current_url());
            redirect('auth/login');
        }
    }

    public function index($id) {
       
        $this->load->view('rental_agreement', ['id'=>$id], false);
    }

    public function bill3() {
        $this->load->view('rental_agreement', '', false);
    }

    public function bill2() {


        $data = [];

        //load mPDF library
        $this->load->library('m_pdf');

        $html = $this->load->view('rental_agreement', $data, true);

        $this->m_pdf->pdf->WriteHTML($html);
        //download it.

        $this->m_pdf->pdf->Output();
    }

}
