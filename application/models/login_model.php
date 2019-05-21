<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Login_model extends CI_Model{
 
  
   public function validate($username,$password){
        $this->db->where('username',$username);
        $this->db->where('pass',$password);
        $result = $this->db->get('users', 1);
        return $result;
      }
      
 /*
 public function validate($username,$password){
    $this->db->select('username', 'pass');
    $array = array('username' => $username, 'pass' => md5($password));
    $this->db->where($array);
    $query = $this->db->get('users', 1);   
    
    return $query;
  }
*/

  public function user_role($username){
      $this->db->select('role');
      $this->db->where('username', $username);
      $query = $this->db->get('users');
      $row = $query->row(0);
      
      return $row->role;
  }

  public function department($username){
      $this->db->select('department');
      $this->db->where('username', $username);
      $query = $this->db->get('users');
      $row = $query->row(0);

      return $row->department;
  }

  public function username($username){
    $this->db->select('username');
    $query = $this->db->get('users');
    $row = $query->row(0);

    return $row->username;
  }

  /*
  public function get_user_id($username){
      $this->db->select('userID');
      $this->db->where('username', $username);
      $query = $this->db->get('users');
      $row = $query->row(0);

      return $row->userID;
  }*/
  
}