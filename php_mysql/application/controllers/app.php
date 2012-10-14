<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class app extends CI_Controller {

    public function show($id) {
        $this->load->helper("url");
        $this->load->database();
        $result = $this->db->get_where("students", array("id" => $id))->result_array();
        if (count($result) == 1) {
            echo base_url("uploads/" . $result[0]["pic_link"]);
        } else {
            echo "invalid";
        }
    }

}