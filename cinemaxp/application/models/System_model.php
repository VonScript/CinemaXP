<?php defined('BASEPATH') OR exit('No direct script access allowed');

class System_model extends CI_Model
{
    // The maximum number of attempts the system will allow.
    var $max_attempts = 5;

    // How long the user should wait when locked out.
    var $lock_minutes = 5;

    // Registers a new user into the system.
    public function new_user($email, $password, $name, $surname, $role = 8)
    {
        // 1. Generate a salt variable and encode the password.
        $salt = bin2hex($this->encryption->create_key(8));
        $password = password_hash($salt.$password, CRYPT_BLOWFISH);

        // 2. Try to insert the code via a transaction.
        $this->db->trans_start();

            // 3. Insert the information in the users table.
            $users = [
                'email'     => $email,
                'password'  => $password,
                'salt'      => $salt,
                'role_id'   => $role
            ];
            $this->db->insert('tbl_users', $users);

            // 4. Insert the information in the user_details table.
            $details = [
                'user_id'   => $this->db->insert_id(),
                'name'      => $name,
                'surname'   => $surname
            ];
            $this->db->insert('tbl_user_details', $details);

        $this->db->trans_complete();

        // 5. If the transaction was successful, commit the change,
        // otherwise, do not apply anything to the database.
        if ($this->db->trans_status() === FALSE)
        {
            $this->db->trans_rollback();
            return FALSE;
        }
        else
        {
            $this->db->trans_commit();
            return TRUE;
        }
    }

    // Try to log the user into the system.
    public function login($email, $password)
    {
        // 1. Try to retrieve the user's info from the database.
        $info = $this->db->select('id, password, salt, role_id AS role')
                         ->get_where('tbl_users', ['email' => $email])
                         ->row_array();

        // 2. If no data could be retrieved (user doesn't exist), we can stop the query.
        if ($info == NULL)
        {
            $this->_attempt($this->input->ip_address());
            return FALSE;
        }

        // 3. If the password is incorrect, we'll register an attempt in our database.
        if (!password_verify($info['salt'].$password, $info['password']))
        {
            $this->_attempt($this->input->ip_address(), $info['id']);
            return FALSE;
        }

        // 4. First, generate a key to register on this device.
        $key = bin2hex($this->encryption->create_key(16));

        // 5. Register the user's login session to the database.
        $data = [
            'user_id'           => $info['id'],
            'expiration'        => time() + 60 * 60 * 24 * 30,
            'sess_identifier'   => $key
        ];
        $this->db->insert('tbl_login_sessions', $data);

        // 6. Give the controller all the information needed to log in the user.
        return $this->db->select('
                                a.id, a.email, a.role_id AS role,
                                b.name, b.surname,
                                c.sess_identifier AS session_code
                            ')
                        ->join('tbl_user_details b', 'b.user_id = a.id', 'left')
                        ->join('tbl_login_sessions c', 'c.user_id = a.id', 'left')
                        ->get_where('tbl_users a', ['a.id' => $info['id']])
                        ->row_array();
    }

    // Writes a login attempt by a user to protect their account.
    private function _attempt($ip_address, $user_id = null)
    {
        // 1. Check if there were any attempts by this same user/ip address.
        $where = [
            'user_id'       => $user_id,
            'ip_address'    => $ip_address,
            'lock >'        => time()
        ];

        // 2. If there were no attempts by this user, we need to register the first one.
        // Otherwise, we'll just increment the attempt count.
        if ($this->db->where($where)->count_all_results('tbl_login_attempts') == 0)
        {
            $data = [
                'user_id'       => $user_id,
                'ip_address'    => $ip_address,
                'attempts'      => 1,
                'lock'          => time() + 60 * $this->lock_minutes
            ];
            $this->db->insert('tbl_login_attempts', $data);
        }
        else
        {
            // unset the 'lock >' key, because we will not be searching for that
            unset($where['lock >']);

            // stops the attempts column from being escaped as a string.
            $this->db->set('attempts', 'attempts + 1', FALSE)
                     ->set('lock', time() + 60 * $this->lock_minutes)
                     ->where($where)
                     ->update('tbl_login_attempts');
        }
    }

    // Checks that there were 5 or more attempts by this same user/ip
    public function is_locked($email)
    {
        // Attempts to get the user details if the email exists in the database.
        $user = $this->db->select('id')->get_where('tbl_users', ['email' => $email])->row_array();
        if ($user != NULL) $user = $user['id'];

        // Look for an attempt in the tbl_login_attempts table.
        $where = [
            'user_id'       => $user,
            'ip_address'    => $this->input->ip_address(),
            'attempts >='   => $this->max_attempts,
            'lock >'        => time()
        ];

        $record = $this->db->select('lock')
                           ->get_where('tbl_login_attempts', $where)
                           ->row_array();

        // If the user's account is locked, we can show them the time they can
        // re-attempt.
        return ($record == NULL) ? FALSE : $record['lock'];
    }

    // Confirms that this device has an active session in the database.
    public function confirm_session()
    {
        $where = [
            'user_id'           => $this->session->userdata('id'),
            'sess_identifier'   => $this->session->userdata('session_code'),
            'expiration >'      => time()
        ];

        return $this->db->get_where('tbl_login_sessions', $where)->num_rows() == 1;
    }

    // Checks the permissions for a particular role.
    public function check_permission($name, $role_id = NULL)
    {
        // if no role was specified we'll access what's available in the session data.
        if ($role_id == NULL) $role_id = $this->session->userdata('role');

        // ensure the $name variable is all uppercase to match the database entries.
        $name = strtoupper($name);

        $perm = $this->db->select('access')
                         ->get_where('tbl_permissions', ['name' => $name])
                         ->row_array();

        if ($perm == NULL) return FALSE;

        return (($perm['access'] & $role_id) == $role_id);
    }
}
