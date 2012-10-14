<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class admin extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->helper(array('form', 'url'));
    }

    public function index() {
        $this->load->view('upload_form', array("error" => ""));
    }

    function makeqr() {

        $this->load->database();
        $q = $this->db->get("students")->result_array();
        echo "<html><body><table>";

        foreach ($q as $student) {
            echo "<tr>";
            echo "<td>";
            echo $student["name"];
            echo "</td>";
            echo "<td>";
            echo '<img src="' . base_url() . "index.php/admin/qr/" . $student["id"] . '.png" ></img>';
            echo "</td>";
            echo "</tr>";
        }
        echo "</table></body></html>";
    }

    public function qr($id) {
        $code = explode(".", $id);
        $this->load->library('ciqrcode');
        header("Content-Type: image/png");
        $params['data'] = $code[0];
        $this->ciqrcode->generate($params);
    }

    public function oneqr($id) {
        $this->load->database();
        $q = $this->db->get_where("students", array("id" => $id))->result_array();
        if (count($q) != 1) {
            echo "Invalid ID";
            return;
        }
        $student = $q[0];
        echo "<html><body><table>";
        echo "<tr>";
        echo "<td>";
        echo $student["name"];
        echo "</td>";
        echo "<td>";
        echo '<img src="' . base_url() . "index.php/admin/qr/" . $student["id"] . '.png" ></img>';
        echo "</td>";
        echo "</tr>";

        echo "</table></body></html>";
    }

    public function register() {
        $this->load->view('upload_form', array('error' => ' '));
    }

    function do_upload() {
        $config['upload_path'] = './uploads/';
        $config['allowed_types'] = 'png';
        $config['max_size'] = '100';
        $config['max_width'] = '1024';
        $config['max_height'] = '768';
        $config['file_name'] = $this->input->post("stud_id") . ".png";

        $this->load->database();

        $query = $this->db->get_where("students", array("id" => $this->input->post("stud_id")));
        if (count($query->result_array()) > 0) {
            $this->load->view('upload_form', array('error' => "ID already registered"));
            return;
        }
        $this->db->insert("students", array("id" => $this->input->post("stud_id"), "name" => $this->input->post("name"), "pic_link" => $this->input->post("stud_id") . ".png"));
        $this->load->library('upload', $config);
        if (!$this->upload->do_upload()) {
            $error = array('error' => $this->upload->display_errors());
            $this->load->view('upload_form', $error);
        } else {
            $data = array('upload_data' => $this->upload->data());
            $this->load->view('register_success', $data);
        }
    }

}