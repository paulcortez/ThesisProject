<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
class Page extends CI_Controller
{

  public function __construct()
  {
    parent::__construct();
    if ($this->session->userdata('logged_in') !== TRUE) {
      redirect('login');
    }
  }

  public function ccs()
  {
    if ($this->session->userdata('role') == 'Faculty') {
      $this->load->view('user/requestView');
    } else if ($this->session->userdata('role') == 'Dean') {
      $this->load->view('dept_views/dean_view');
    } else {
      echo "Access Denied";
    }
  }

  public function budgeting()
  {
    $this->load->view('dept_views/budgeting_view');
  }

  public function purchasing()
  {
    $this->load->view('dept_views/purchasing_view');
  }
}
